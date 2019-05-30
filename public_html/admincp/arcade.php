<?php

use Resource\Native\String;

class ACPArcadeController extends AppController{

	const PARAM = "game";
	
    public function __construct(){
        parent::__construct();
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canmanageadopts") != "yes"){
		    throw new NoPermissionException("You do not have permission to manage adoptables.");
		}	
    }

    public function add(){
	    $mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("submit")){
		    // The form has been submitted, it's time to validate data and add a record to database.
			if($mysidia->session->fetch("acpArcade") != "add"){
                $this->setFlag("global_error", "Session already expired...");
				return;
            }
			
			if(!$mysidia->input->post("name")) throw new BlankFieldException("name");
			elseif(!$mysidia->input->post("image")) throw new BlankFieldException("image");
		    elseif(!$mysidia->input->post("link")) throw new BlankFieldException("link");
		    
			if(!$mysidia->input->post("status")){$status = "yes";}
			else{$status = $mysidia->input->post("status");}
			
			if(!$mysidia->input->post("description")){$description = "No Description";}
			else{$sdescription = $mysidia->input->post("description");}

			// insert into the arcade
			$mysidia->db->insert("arcade", array("name" => $mysidia->input->post("name"), "img" => $mysidia->input->post("image"), "description" => $description, "link" => $mysidia->input->post("link"), "available" => $status));
			$mysidia->session->terminate("acpArcade");
		    return;
		}		
	    $mysidia->session->assign("acpArcade", "add", TRUE);								   
    }

    public function edit(){
        $mysidia = Registry::get("mysidia");
		$document = $mysidia->frame->getDocument();

		if($mysidia->input->post("submit")){
			if($mysidia->session->fetch("acpArcade") != "edit"){
                $this->setFlag("global_error", "Session already expired...");
				return;
            }
			elseif($mysidia->input->post("delete") == "yes"){
			    $mysidia->db->delete("arcade", "id='{$mysidia->input->get("game")}'");	
			}
			else{
			    if(!$mysidia->input->post("status")){$status = "yes";}
			    else{$status = $mysidia->input->post("status");}
				$mysidia->db->update("arcade", array("name" => $mysidia->input->post("name"), "img" => $mysidia->input->post("image"), "description" => $mysidia->input->post("description"), "link" => $mysidia->input->post("link"), "available" => $status), "id='{$mysidia->input->get("game")}'");
			}
		}
		else{
		    $game = $mysidia->input->get("game");	
            $this->setField("game", $game);
            $mysidia->session->assign("acpArcade", "edit", TRUE);
	    }
    }

    public function delete(){

    }	
}
?>