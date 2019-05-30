<?php
use Resource\Native\Boolean;
use Resource\Native\Integer;

class RewardsController extends AppController{
	private function paycheck($usergroup) {
		$paycheck = [
			// Root Admins
		1 => 150000,
			// Admins
		2 => 100000,
			// Artists
		4 => 50000,
			// Moderators
		7 => 75000,
			// Wiki Creators
		10 => 50000,
		];

		$possibleItemRarities = [
			// Root Admins
		1 => ['Rare','Special','Super Rare'],
			// Admins
		2 => ['Rare','Special','Super Rare'],
			// Artists
		4 => ['Rare','Special'],
			// Moderators
		7 => ['Rare','Special','Super Rare'],
			// Wiki Creators
		10 => ['Rare', 'Special'],
		];

		$payment = 0;
		$itemRarities = null;
		if (isset($paycheck[$usergroup])) {
			$payment = $paycheck[$usergroup];
		}
		if (isset($possibleItemRarities[$usergroup]))
		{
			$itemRarities = $possibleItemRarities[$usergroup];
		}

		return ['paycheck' => $payment, 'rarities' => $itemRarities];
	}


	private $getReward = false;

	public function __construct(){
		parent::__construct();	
		$mysidia = Registry::get('mysidia');
		$this->group = $mysidia->user->usergroup;
		$nonPayingGroups = [3,5,6];
		if (in_array((int) $this->group->gid, $nonPayingGroups)){
			$lang = Registry::get("lang");
		    throw new Exception($lang->lang['not_staff']);
		}
		$lastReward = strtotime($mysidia->user->getStatus()->last_staff_reward);
		if (date('Ym',$lastReward) < date('Ym')){
			$this->getReward = true;			
		}

		$this->setField('canGetReward', new Boolean($this->getReward));
		$this->mysidia = $mysidia;
	}
	
	public function index(){
		$mysidia = $this->mysidia;
		if ($mysidia->input->post('paycheck') == null OR $this->getReward == false){
			return;
		}
		
		// Select paycheck based on usergroup
		$paycheck = $this->paycheck($this->group->gid);

		// Pay Player
		$mysidia->user->changecash($paycheck['paycheck']);
		$this->setField('pay', new Integer($paycheck['paycheck']));

		// Give Random Item
		if ($paycheck['rarities'] != null){
			$itemRarities = implode(', ', $paycheck['rarities']);
			$in  = str_repeat('?,', count($paycheck['rarities']) - 1) . '?';
			$stmt = $mysidia->db->prepare("SELECT itemname FROM adopts_items WHERE rarity IN ($in) ORDER BY RAND() LIMIT 1");
			$stmt->execute($paycheck['rarities']);
			$itemprize = $stmt->fetchColumn();
			$item = new StockItem($itemprize);
			$item->append(1, $mysidia->user->username);
			$this->setField('item', $item);
		}

		// Update timestamp in database
		$mysidia->db->update('users_status', ['last_staff_reward'=>date('Y-m-d H:i:s', time())], "username='{$mysidia->user->username}'");
	}
}