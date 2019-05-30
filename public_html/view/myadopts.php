<?php

use Resource\Native\Integer;
use Resource\Native\String;

class MyadoptsController extends AppController{

	const PARAM = "aid";
	const PARAM2 = "confirm";
	private $adopt;
	private $image;

	public function __construct(){
		parent::__construct("member");
		$mysidia = Registry::get("mysidia");
		if($this->action != "index"){
			try{
				$this->adopt = new OwnedAdoptable($mysidia->input->get("aid"));	
				if($this->adopt->getOwner() != $mysidia->user->username) throw new NoPermissionException("permission");		
				$this->image = new Comment($this->adopt->getImage("gui"), FALSE);
			}
			catch(AdoptNotfoundException $pne){
				$this->setFlags("nonexist_title", "nonexist");
			}              			
		}
	}

	public function index(){
		$mysidia = Registry::get("mysidia");
		$groups_call = $mysidia->db->select("adoptables_groups", ['name','id'], "userid = '{$mysidia->user->uid}'");
		$this->setField("groups", new DatabaseStatement($groups_call));
		$groups = $groups_call->fetchAll(PDO::FETCH_ASSOC);
		$querystring = null;
		if (count($groups) != 0){
			$groups_imploded = implode(',',$groups['id']);
			$querystring = 'AND `groupid` NOT IN ($groups_imploded)';
		}

		$total = $mysidia->db->select("owned_adoptables", array("aid"), "`owner` = '{$mysidia->user->username}' $querystring")->rowCount();



		$status = $mysidia->user->getStatus();
		$site_total = $mysidia->getSettings()->maximumpets;
		$pet_storage_info = "Total Pets: $total/{$status->max_pets} (can expand up to $site_total)<br>.";
		$this->setField('pet_storage_info', new Comment($pet_storage_info));

		$pagination = new Pagination($total, 10, "myadopts");
		$pagination->setPage($mysidia->input->get("page"));	
		//	$stmt = $mysidia->db->select("owned_adoptables", array("aid"), "owner = '{$mysidia->user->username}' ORDER BY totalclicks LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}");
		$stmt = $mysidia->db
		->join('adoptables','owned_adoptables.type = adoptables.type')
		->join('levels', 'owned_adoptables.type = levels.adoptiename')
		->select(
			"owned_adoptables",
			array(PREFIX.'owned_adoptables`.*, `primaryimage','alternateimage','eggimage','class'),
			"`owner` = '{$mysidia->user->username}' AND ".PREFIX.'owned_adoptables.currentlevel = '.PREFIX."levels.thisislevel $querystring ORDER BY class, type, totalclicks LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}"
			);
		$this->setField("pagination", $pagination);
		$this->setField("stmt", new DatabaseStatement($stmt));
	}

	public function manage(){
		$this->setField("aid", new Integer($this->adopt->getAdoptID()));
		$this->setField("name", new String($this->adopt->getName()));	
		$this->setField("image", $this->image);		
	}

	public function stats(){
		$mysidia = Registry::get("mysidia");				
		$stmt = $mysidia->db->select("vote_voters", array(), "adoptableid='{$this->adopt->getAdoptID()}' ORDER BY date DESC LIMIT 10");
		$this->setField("adopt", $this->adopt);		
		$this->setField("image", $this->image);		
		$this->setField("stmt", new DatabaseStatement($stmt));
	}

	public function bbcode(){
		$this->setField("adopt", $this->adopt);	
	}

	public function rename(){
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("submit")){
			$poundsettings = getpoundsettings();
			$poundpet = $mysidia->db->select("pounds", array(), "aid='{$this->adopt->getAdoptID()}'")->fetchObject();
			if($poundpet and $poundsettings->rename->active == "yes"){
				if(!empty($poundpet->firstowner) and $mysidia->user->username != $poundpet->firstowner){
					$this->setFlags("rename_error", "rename_owner");
					return;	
				}				
			}			
			$this->adopt->setName($mysidia->input->post("adoptname"), "update");
		}
		$this->setField("adopt", $this->adopt);		
		$this->setField("image", $this->image);			
	}

	public function trade(){
	$mysidia = Registry::get("mysidia");		
	if($mysidia->input->post("confirm") != null){
		switch($this->adopt->getTradeStatus()){
			case "fortrade":
			$this->adopt->setTradeStatus("notfortrade", "update");
			$message = $mysidia->lang->trade_disallow;
			break;
			case "notfortrade":
			$this->adopt->setTradeStatus("fortrade", "update");
			$message = $mysidia->lang->trade_allow;
			break;
			default:
			throw new InvalidActionException("global_action");
		}
	}
	else
	{
	/*	
		$message = "Are you sure you wish to change the trade status of this adoptable?
		<center><b><a href='{$this->adopt->getAdoptID()}/confirm'>Yes I'd like to change its trade status</a></b><br /><br />
			<b><a href='../../myadopts'>Nope I change my mind! Go back to the previous page.</a></b></center><br />";
	*/
		$message = "Are you sure you wish to change the trade status of this adoptable?<br><center><form method='post'><input type='submit' name='confirm' class='button' value=\"Yes I'd like to change its trade status.\"></form><br><b><a href='../../myadopts'>Nope I change my mind! Go back to the previous page.</a></b></center>";
		}
		$this->setField("aid", new Integer($this->adopt->getAdoptID()));
		$this->setField("image", $this->image);				
		$this->setField("message", new String($message));				
	}

	public function freeze(){
		$message = null;
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("confirm") != null){
			switch($this->adopt->isFrozen()){
				case "no":
				$frozen = "yes";
				$message = $this->adopt->getName().$mysidia->lang->freeze_success;
				break;
				case "yes":
				$frozen = "no";
				$message = $this->adopt->getName().$mysidia->lang->freeze_reverse;
				break;
				default:
				throw new InvalidActionException("global_action");			
			}
			$this->adopt->setFrozen($frozen, "update");
			$message .= "<br>You may now manage {$this->adopt->getName()} on the ";			       
		}	 
		$this->setField("adopt", $this->adopt);
		$this->setField("image", $this->image, false);	
		$this->setField("message", new String($message));			
	}

	public function release(){
		$message = null;
		$mysidia = Registry::get('mysidia');

		$validator = new UserValidator($mysidia->user, array("username" => $mysidia->user->username, "password" => $mysidia->input->post("password")));
		$validator->validate("password");

		if($validator->triggererror()){
			throw new Exception('Wrong password.');
		}

		// Delete pet
		$mysidia->db->update('owned_adoptables', ['owner'=>'SYSTEM', 'isdead'=>1], "aid={$this->adopt->aid}");
	}

	public function updatebio(){
		$this->setField("adopt", $this->adopt);
		$mysidia = Registry::get('mysidia');
		if ($mysidia->input->post('submit') != null){
			$this->adopt->setBio($mysidia->input->post("bio"), "update");
			redirect('/pet/profile/'.$this->adopt->aid);
		}
	}
}