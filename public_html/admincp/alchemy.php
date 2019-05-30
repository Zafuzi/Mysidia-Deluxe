<?php

class ACPAlchemyController extends AppController{

    const PARAM = "alid";
	
	public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanagesettings") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage alchemy.");
		}	
    }
	
	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");			
		$stmt = $mysidia->db->select("alchemy");
        $num = $stmt->rowCount();
        if($num == 0) throw new InvalidIDException("default_none");
		$this->setField("stmt", new DatabaseStatement($stmt));	
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");
	    if($mysidia->input->post("submit")){
		    $this->dataValidate();	
			$mysidia->db->insert("alchemy", array("alid" => NULL, "item" => $mysidia->input->post("item"), "item2" => $mysidia->input->post("item2"), "item3" => $mysidia->input->post("item3"), "item4" => $mysidia->input->post("item4"), "item5" => $mysidia->input->post("item5"),
			                                        "newitem" => $mysidia->input->post("newitem"), "chance" => $mysidia->input->post("chance"), "recipe" => $mysidia->input->post("recipe")));	
		}
		$this->loadItemMap();				
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");		
	    if(!$mysidia->input->get("alid")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){
		    $this->dataValidate();
			$mysidia->db->update("alchemy", array("item" => $mysidia->input->post("item"), "item2" => $mysidia->input->post("item2"), "item3" => $mysidia->input->post("item3"), "item4" => $mysidia->input->post("item4"), "item5" => $mysidia->input->post("item5"), "newitem" => $mysidia->input->post("newitem"),
			                                      "chance" => $mysidia->input->post("chance"), "recipe" => $mysidia->input->post("recipe")), "alid='{$mysidia->input->get("alid")}'");			
		    return;
		}
		else{
		    $alchemy = $mysidia->db->select("alchemy", array(), "alid='{$mysidia->input->get("alid")}'")->fetchObject();		
		    if(!is_object($alchemy)) throw new InvalidIDException("nonexist");
			$this->setField("alchemy", new DataObject($alchemy));
			$this->loadItemMap();		
	    }
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
        if(!$mysidia->input->get("alid")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
        $mysidia->db->delete("alchemy", "alid='{$mysidia->input->get("alid")}'");
    }
	
	public function settings(){
	    $mysidia = Registry::get("mysidia");
        $alchemySettings = new AlchemySetting($mysidia->db);				
		if($mysidia->input->post("submit")){
		    $settings = array('system', 'chance', 'recipe', 'cost', 'license', 'usergroup');
			foreach($settings as $name){			
				if($mysidia->input->post($name) != ($alchemySettings->$name)) $mysidia->db->update("alchemy_settings", array("value" => $mysidia->input->post($name)), "name='{$name}'");	 
			}
		    return;
		}
		$this->setField("alchemySettings", $alchemySettings);
	}	
	
	private function dataValidate(){
	    $mysidia = Registry::get("mysidia");
		if(!$mysidia->input->post("item") or !is_numeric($mysidia->input->post("item"))) throw new BlankFieldException("item");	
		if(!$mysidia->input->post("item2") or !is_numeric($mysidia->input->post("item2"))) throw new BlankFieldException("item2");
		
        if($mysidia->input->action() == "add"){
		    $whereClause = "
				(
					item = '{$mysidia->input->post("item")}'
						OR item = '{$mysidia->input->post("item2")}'
						OR item = '{$mysidia->input->post("item3")}'
						OR item = '{$mysidia->input->post("item4")}'
						OR item = '{$mysidia->input->post("item5")}'
				)
				and 
				(
					item2 = '{$mysidia->input->post("item")}' 
						OR item2 = '{$mysidia->input->post("item2")}' 
						OR item2 = '{$mysidia->input->post("item3")}'
						OR item2 = '{$mysidia->input->post("item4")}'
						OR item2 = '{$mysidia->input->post("item5")}'
				)
				and 
				(
					item3 = '{$mysidia->input->post("item")}'
						OR item3 = '{$mysidia->input->post("item2")}'
						OR item3 = '{$mysidia->input->post("item3")}'
						OR item3 = '{$mysidia->input->post("item4")}'
						OR item3 = '{$mysidia->input->post("item5")}'
				)
				and 
				(
					item4 = '{$mysidia->input->post("item")}' 
						OR item4 = '{$mysidia->input->post("item2")}' 
						OR item4 = '{$mysidia->input->post("item3")}'
						OR item4 = '{$mysidia->input->post("item4")}'
						OR item4 = '{$mysidia->input->post("item5")}'
				)
				and 
				(
					item5 = '{$mysidia->input->post("item")}'
						OR item5 = '{$mysidia->input->post("item2")}'
						OR item5 = '{$mysidia->input->post("item3")}'
						OR item5 = '{$mysidia->input->post("item4")}'
						OR item5 = '{$mysidia->input->post("item5")}'
				)";		
			
		    $alchemy = $mysidia->db->select("alchemy", array(), $whereClause)->fetchObject();
		    if(is_object($alchemy)) throw new DuplicateIDException("duplicate");
        }
		
		if(!$mysidia->input->post("newitem")) throw new BlankFieldException("newitem");		
		if($mysidia->input->post("chance") < 0 or $mysidia->input->post("chance") > 100) throw new InvalidActionException("chance");
		header("Refresh:3; URL='../../index'");
        return TRUE;
	}
	
	private function loadItemMap(){
	    $mysidia = Registry::get("mysidia");	
		$stmt = $mysidia->db->select("items", array("id", "itemname"));
		$map = $mysidia->db->fetchMap($stmt);
		$this->setField("itemMap", $map);	
        $stmt2 = $mysidia->db->select("items", array("id", "itemname"), "function = 'Recipe'");	
		$map2 = $mysidia->db->fetchMap($stmt2);
		$this->setField("recipeMap", $map2);		
	}
}	
?>