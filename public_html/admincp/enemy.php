<?php

class ACPEnemyController extends AppController{

	const PARAM = "eid";
	
    public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage enemies.");
		}		
    }

    public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("enemies");
		if($stmt->rowCount() == 0) throw new InvalidIDException("empty");
		$this->setField("stmt", new DatabaseStatement($stmt));		
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
	        $this->dataValidate();
		    if($mysidia->input->post("area") == NULL){$area = "any";}
		    else{$area = $mysidia->input->post("area");}
			$mysidia->db->insert("enemies", array("eid" => NULL, "name" => $mysidia->input->post("name"), "max_level" => $mysidia->input->post("maxlevel"), "creator" => $mysidia->input->post("creator"), "image_url" => $mysidia->input->post("image"), "bio" => $mysidia->input->post("bio"), 
			                                               "area" => $area));
		}	
    }

    public function edit(){
	    $mysidia = Registry::get("mysidia");
	    if(!$mysidia->input->get("eid")){
		    $this->index();
			return;
        } 		
	    if($mysidia->input->post("submit")){
	        $this->dataValidate();
		    if($mysidia->input->post("area") == NULL){$area = "any";}
		    else{$area = $mysidia->input->post("area");}
			$mysidia->db->update("enemies", array("name" => $mysidia->input->post("name"), "max_level" => $mysidia->input->post("maxlevel"), "creator" => $mysidia->input->post("creator"), "bio" => $mysidia->input->post("bio"), 
			                                               "image_url" => $mysidia->input->post("image"), "area" => $area), "eid='{$mysidia->input->get("eid")}'");
		    return;
		}
		
		$stmt = $mysidia->db->select("enemies", array(), "eid='{$mysidia->input->get("eid")}'");		
		if($enemy = $stmt->fetchObject()){
		    $this->setField("enemy", new DataObject($enemy));			
		}
		else throw new InvalidIDException("global_id");
    }

    public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("eid")){
		    $this->index();
			return;
		}
        $mysidia->db->delete("enemies", "eid='{$mysidia->input->get("eid")}'");		
    }

    private function dataValidate(){
        $mysidia = Registry::get("mysidia");
        if($mysidia->input->post("area") == NULL){$area = "any";}
		else{$area = $mysidia->input->post("area");}
		$fields = array("name" => $mysidia->input->post("name"), "max_level" => $mysidia->input->post("maxlevel"), "creator" => $mysidia->input->post("creator"), "bio" => $mysidia->input->post("bio"), 
			                                               "image_url" => $mysidia->input->post("image"), "area" => $area);
        foreach($fields as $field => $value){
			if(!$value){
                if($field == "area") continue;
                if($field == "bio") continue;
				throw new BlankFieldException("You did not enter in {$field} for the adoptable.  Please go back and try again.");
            }
	    }
		return TRUE;
    }	
}
?>