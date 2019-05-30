<?php

class Fish {
	function __construct($mysidia, $document, $vars)
	{
		$this->mysidia = $mysidia;
		$this->document = $document;
		$this->bait = $vars['bait'];
		$this->numBaitUsed = $vars['numBaitUsed'];
		$this->prizes = $vars['prizes'];
		$this->cash_prize = $vars['cash_prize'];
		$this->failure_chance = $vars['failure_chance'];
		$this->lang = $vars['lang'];

		$document->setTitle($vars['lang']['page_title']);
		if (!is_null($vars['lang']['area_description'])){
			$document->add(new Comment($vars['lang']['area_description']));
		}
		$document->add(new Comment($vars['lang']['previous_area']));

		if ($mysidia->input->post("adopt")) 
		{
			$validated = $this->_verifyAdopt();
			if ($validated)
			{
				$this->_adopt();
			}
			else
			{
				$document->add(new Comment($vars['lang']['adopt_not_found']));
			}
			$document->add(new Comment("<a href='{$_SERVER['REQUEST_URI']}'>{$vars['lang']['continue_fishing']}</a>"));
			$document->add(new Comment("<img src='{$vars['lang']['area_img']}'/>"));
				return;
		}

		if ($this->hasEquipment($vars['pole'], $vars['bait']) == false)
		{
			$document->add(new Comment($vars['lang']['equipment_error']));
			$document->add(new Comment("<img src='{$vars['lang']['area_img']}'>"));
			return false;
		}

		if($this->canFish($vars['maxExploreTimes']) == false)
		{
			$document->add(new Comment("You have used <b>{$mysidia->user->exploretimes} out of {$vars['maxExploreTimes']}</b> explore points.<br /><br />{$vars['lang']['out_of_turns']}"));
			$document->add(new Comment("<img src='{$vars['lang']['area_img']}'>"));
			return false;
		}

		$result = $this->cast();

		// Failed
		if ($result == false)
		{
			$document->add(new Comment($vars['lang']['failure']));
		}

		// Won money
		if (is_numeric($result))
		{
			$mysidia->user->changecash($result);
			$document->add(new Comment($vars['lang']['cash']."<b>$result</b>".$vars['lang']['cash_end']));
		}

		if (is_array($result))
		{
			// Check if an adopt
			if (isset($result[2]))
			{
				$this->adoptRequest($result);
			}
			else
			{
				$item = new StockItem($result[0]);
				$item->append(1, $mysidia->user->username);
				$document->add(new Comment($vars['lang']['success']."<img src='{$result[1]}'/> <b>{$result[0]}</b>".$vars['lang']['success_end']));
			}
		
		}

		$document->add(new Comment("<a href='{$_SERVER['REQUEST_URI']}'>{$vars['lang']['continue_fishing']}</a>"));
		$document->add(new Comment("<img src='{$vars['lang']['area_img']}'/>"));
		return;
	}

	function cast()
	{
		$item = new PrivateItem($this->bait, $this->mysidia->user->username);
		$item->remove($this->numBaitUsed, $this->mysidia->user->username);

		if ($this->failure_chance >= mt_rand(0,100)) {
			return false;
		}

		if ($this->cash_prize != false AND $this->cash_prize['chance'] >= mt_rand(0,100))
		{
			return mt_rand($this->cash_prize['minAmount'],$this->cash_prize['maxAmount']);
		}

		$prizes = $this->prizes;
		ksort($prizes);
		end($prizes);
		$max = key($prizes);
		reset($prizes);

		$random = mt_rand(0,$max);
		foreach ($prizes as $odds => $prize)
		{
			if ($random <= $odds)
			{
				$prize['key'] = $odds;
				return $prize;
			}
		}
	}

	function adoptRequest($result)
	{
		$_SESSION['fish'] = $result;
		$_SESSION['timer'] = date('Y-m-d H:i:s', strtotime('+5 minutes'));
		$_SESSION['page'] = $_SERVER['REQUEST_URI'];

		$this->document->add(new Comment($this->lang['adopt_caught']."<img src='{$result[1]}'> <b>{$result[0]}</b> ".$this->lang['adopt_caught_end'].' '.$result[2]));
		$this->document->add(new Comment($this->lang['adopt_request']));
		$form = new FormBuilder('adopt_fish', $_SERVER['REQUEST_URI'], 'post');
		$form->buildButton("Adopt {$result[0]}", "adopt", "adopt");
		$this->document->add($form);
	}

	private function _verifyAdopt()
	{
		if (!isset($_SESSION['fish']) || !isset($_SESSION['timer']) || !isset($_SESSION['page'])) return false;
		if ($_SESSION['page'] != $_SERVER['REQUEST_URI']) return false;
		if (date('Y-m-d H:i:s') > $_SESSION['timer']) return false;
		if (!isset($this->prizes[$_SESSION['fish']['key']][0]) || $this->prizes[$_SESSION['fish']['key']][0] != $_SESSION['fish'][0]) return false;
		return true;
	}

	private function _adopt()
	{
		try{
			hasTooManyPets();
		} catch (Exception $e) {
			$this->document->add(new Comment($e->getMessage()));
			return;
		}
		$result = $_SESSION['fish'];
		$adopt = new StockAdopt($result[0]);
		$adopt->append($this->mysidia->user->username);

		$this->document->add(new Comment("{$this->lang['adopt_adopted']}<br><a href='/myadopts/manage/{$adopt->info['id']}'><img src='{$result[1]}'> <b>{$result[0]}</b> {$adopt->info['gender']}</a>"));

		unset($_SESSION['fish']);
	}

	function canFish($maxTimes = 20)
	{
    	$today = date("d"); // Day of the month

            // Reset explore counter if the last recorded exploration was on a different day than today:
    	$reset = $this->mysidia->user->lastday != $today; 

            // Allow user to explore if they are under the limit or if reset condition is true. 
    	if ($this->mysidia->user->exploretimes <= $maxTimes || $reset) {  
                // Update the last day that they explored to today
    		$this->mysidia->db->update("users", array("lastday" => $today), "username = '{$this->mysidia->user->username}'");

                // If $reset condition was true, reset the count to 1, otherwise increment the existing count. 
    		$updatedExploreTimes = $reset ? 1 : $this->mysidia->user->exploretimes + 1; 

    		$this->mysidia->db->update("users", array("exploretimes" => ($updatedExploreTimes)), "username = '{$this->mysidia->user->username}'"); 
    		return true;
    	}
    	return false;
    }

    function hasEquipment($pole, $bait)
    {
    	$hasItems = $this->mysidia->db->select("inventory", array("quantity"), "itemname IN ('{$pole}','{$bait}') and owner='{$this->mysidia->user->username}'")->fetchAll(PDO::FETCH_COLUMN);

    	if(count($hasItems)>=2) return true;
    	return false;
    }
}