<?php

use Resource\Native\Integer;
use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPRewardController extends AppController{

    const PARAM = "promo";
	const PARAM2 = "reward";
	
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanageadopts") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage rewards.");
		}
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("promocodes");
		$this->setField("stmt", new DatabaseStatement($stmt));		
	}
	
    public function browse(){
	    $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("promo")){
		    // A promocode has yet been selected, return to the index page.
		    $this->index();
			return;
        }
		$code = $mysidia->db->select("promocodes", array("code"), "pid='{$mysidia->input->get("promo")}'")->fetchColumn();	
		$stmt = $mysidia->db->select("rewards", array(), "code='{$code}'");
		$this->setField("stmt", new DatabaseStatement($stmt));		
    }

	public function add(){
	    $mysidia = Registry::get("mysidia");
		
	    if(!$mysidia->input->get("promo")){
		    // A promocode has yet been selected, return to the index page.
		    $this->index();
			return;
        }
		elseif($mysidia->input->post("submit")){
		    $this->dataValidate();	
            $mysidia->db->insert("rewards", array("rid" => NULL, "code" => $mysidia->input->post("code"), "type" => $mysidia->input->post("type"), "reward" => $mysidia->input->post("reward"), "quantity" => $mysidia->input->post("quantity")));				        
        }
		else{
		    $promo = $mysidia->db->select("promocodes", array(), "pid='{$mysidia->input->get("promo")}'")->fetchObject();		
		    if(!is_object($promo)) throw new InvalidIDException("nonexist");
            $this->setField("promo", new DataObject($promo));		
		}
	}

	public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("promo")){
		    // A reward has yet been selected, return to the index page.
		    $this->index();
			return;
		}
        $mysidia->db->delete("rewards", "rid='{$mysidia->input->get("promo")}'");	
	}

	private function dataValidate(){
	    $mysidia = Registry::get("mysidia");
		if(!$mysidia->input->post("type")) throw new BlankFieldException("type");	
		if(!$mysidia->input->post("reward")) throw new BlankFieldException("reward");		
		if(!is_numeric($mysidia->input->post("quantity"))) throw new BlankFieldException("quantity");
		return TRUE;
	}
}