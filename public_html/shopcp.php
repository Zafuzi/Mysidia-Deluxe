<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ShopcpController extends AppController{

	const PARAM = "usid";
	
	public function __construct(){
        parent::__construct("member");
		$mysidia = Registry::get("mysidia");
		//if($mysidia->usergroup->getpermission("groupname") != "rootadmins"){
		    //throw new NoPermissionException("Sorry! Only admins can test user shops at this time!");
		//}		
    }
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("user_shops");
		$shop_info = $mysidia->db->select("user_shops", array(), "manager_id='{$mysidia->user->uid}'")->fetchObject();
		$stmt = $mysidia->db->select("user_shops", array(), "manager_id='{$mysidia->user->uid}'");
        $num = $stmt->rowCount();		
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");		
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("usid")){
		    $this->index();
		    throw new NoPermissionException("You do not own this shop!");
			return;
		}
		else{
		    $shop = $mysidia->db->select("user_shops", array(), "usid='{$mysidia->input->get('usid')}'")->fetchObject();		
		    if(!is_object($shop)) throw new InvalidIDException("nonexist");
			$this->setField("user_shop", new DataObject($shop));	
	    }
	}

    public function delete(){
	   	$mysidia = Registry::get("mysidia");
		$document = $mysidia->frame->getDocument();
        if($mysidia->user->uid !== $mysidia->input->get("manager_id")){
		    $this->index();
		    throw new NoPermissionException("You do not own this shop!");
			return;
		}
        $mysidia->db->delete("user_shops", "usid='{$mysidia->input->get('usid')}'");
    }

 	private function dataValidate(){
	    $mysidia = Registry::get("mysidia");
		if(!$mysidia->input->post("us_name")) throw new BlankFieldException("us_name");	
		if(!$mysidia->input->post("npc_url") and $mysidia->input->post("existingnpc_url") == "none") throw new BlankFieldException("images"); 
        if(!$mysidia->input->post("status")) throw new BlankFieldException("status");
		if($mysidia->input->post("tax") < 0) throw new InvalidActionException("tax");
		
		$shop = $mysidia->db->select("user_shops", array(), "us_name = '{$mysidia->input->post("us_name")}'")->fetchObject();
		if($this->action == "add" and is_object($shop)) throw new DuplicateIDException("duplicate");
		return TRUE;
	}
}
?>