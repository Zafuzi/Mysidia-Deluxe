<?php

use Resource\Native\Integer;

class UsershopController extends AppController{

	const PARAM = "shop_id";
	
	public function __construct(){
        parent::__construct("member");	
        $mysidia = Registry::get("mysidia");		
        $mysidia->user->getstatus();
		if($mysidia->user->status->canshop == "no"){
		    throw new NoPermissionException($mysidia->lang->denied);
		}
		if($mysidia->input->action() != "index" and !$mysidia->input->get("shop_id")){
		    throw new InvalidIDException($mysidia->lang->global_id);
		}
    }
	
	public function index(){		
	$mysidia = Registry::get("mysidia");
	}
	
	public function browse(){		
	$mysidia = Registry::get("mysidia");
        $shop_id = $mysidia->input->get("shop_id");
        $this->setField("shop_id", $shop_id);
	}
}
?>