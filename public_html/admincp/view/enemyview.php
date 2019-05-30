<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPEnemyView extends View{

    public function index(){
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();
		$document = $this->document;
		$document->setTitle("Enemy List");
		
        $fields = new LinkedHashMap;
		$fields->put(new String("eid"), NULL);
		$fields->put(new String("name"), NULL);
		$fields->put(new String("max_level"), NULL);
		$fields->put(new String("image_url"), new String("getImage"));	
		$fields->put(new String("creator"), NULL);			
		$fields->put(new String("eid::edit"), new String("getEditLink"));
		$fields->put(new String("eid::delete"), new String("getDeleteLink"));		
		
		$ownedAdoptTable = new TableBuilder("ownedadopt");
		$ownedAdoptTable->setAlign(new Align("center", "middle"));
		$ownedAdoptTable->buildHeaders("ID", "Name", "Max Level", "Image", "Creator", "Edit", "Delete");
		$ownedAdoptTable->setHelper(new TableHelper);
		$ownedAdoptTable->buildTable($stmt, $fields);
        $document->add($ownedAdoptTable);	
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    if($mysidia->input->post("submit")){
		    $document->setTitle("Enemy Added Successfully");
			$document->addLangvar("A new enemy, {$mysidia->input->post('name')}, has been added successfully.
                  </br><a href='..'>Click Here</a> to return to the enemies manager.");
			return;
		}
		
		$document->setTitle("Create an enemy");
		$document->addLangvar("<p>Here you can create an enemy using the form below.</p> <p>If you wish for any enemy to appear on any explore page, leave the location URL blank.</p>");
		
		$enemyForm = new FormBuilder("addform", "add", "post");
		$enemyForm->buildComment("<u><strong>Create A New Enemy:</strong></u>")
		               ->buildComment("Enemy Name: ", FALSE)->buildTextField("name")
					   ->buildComment("Max Level: ", FALSE)->buildTextField("maxlevel")
					   ->buildComment("Image URL: ", FALSE)->buildTextField("image")
		               ->buildComment("Biography: ", TRUE)->buildTextArea("bio")
					   ->buildComment("Creator: ", FALSE)->buildTextField("creator")
					   ->buildComment("Location URL: ", FALSE)->buildTextField("area")
					   ->buildButton("Create Enemy", "submit", "submit");
		$document->add($enemyForm);		
    }

    public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		
	    if($mysidia->input->post("submit")){
		    $document->setTitle("Enemy Updated Successfully");
			$document->addLangvar("{$mysidia->input->post('name')} has been updated successfully.
                  </br><a href='..'>Click Here</a> to return to the enemies manager.");
			return;
		}
		
		$enemy = $this->getField("enemy")->get();
		$document->setTitle("Enemies Editor - Editing {$mysidia->input->post("eid")}'s Data");
		$document->addLangvar("Here you can edit info and images for existing enemies.<br />");

			
		$enemyForm = new FormBuilder("editform", $mysidia->input->get("eid"), "post");
		$enemyForm->buildComment("<u><strong>Edit Existing Enemy:</strong></u>")
		               ->buildComment("Enemy Name: ", FALSE)->buildTextField("name", $enemy->name)
					   ->buildComment("Max Level: ", FALSE)->buildTextField("maxlevel", $enemy->max_level)
					   ->buildComment("Image URL: ", FALSE)->buildTextField("image", $enemy->image_url)
		               ->buildComment("Biography: ", TRUE)->buildTextArea("bio", $enemy->bio)
					   ->buildComment("Creator: ", FALSE)->buildTextField("creator", $enemy->creator)
					   ->buildComment("Location URL: ", FALSE)->buildTextField("area", $enemy->area)
					   ->buildButton("Edit this Enemy", "submit", "submit");
		$document->add($enemyForm);			
    }

    public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("eid")){
		    $this->index();
			return;
		}	
		$document->setTitle("Enemy deleted");
		$document->addLangvar("This enemy has been successfully deleted!");
        header("Refresh:3; URL='../index'");
    }

    private function dataValidate(){
        $mysidia = Registry::get("mysidia");
		$fields = array("type" => $mysidia->input->post("type"), "name" => $mysidia->input->post("name"), "owner" => $mysidia->input->post("owner"), "clicks" => $mysidia->input->post("clicks"), 
			            "level" => $mysidia->input->post("level"), "usealternates" => $mysidia->input->post("usealternates"), "gender" => $mysidia->input->post("gender"));
        foreach($fields as $field => $value){
			if(!$value){
                if($field == "clicks" and $value == 0) continue;
                if($field == "usealternates") continue;
                if($field == "level" and $value == 0) continue;
				throw new BlankFieldException("You did not enter in {$field} for the adoptable.  Please go back and try again.");
            }
	    }
		return TRUE;
    }	
}

?>