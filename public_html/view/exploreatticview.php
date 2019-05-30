<?php

class exploreatticview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle("<center>Exploring The Attic<br>");
        
        $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/myhouse/'>Go back to the house</a><br><br></center>", FALSE));

        $item = "Attic permit";
		$qty = 1;
		$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn();
		
		if($hasitem){ //they have the item, let them explore
		    //$document->add(new Comment("You have a {$item}!"));
			$item = new PrivateItem($item, $mysidia->user->username);
			
			$explore_check = $mysidia->db->select("users", array("exploretimes_attic"), "uid='{$mysidia->user->uid}'")->fetchColumn();

			if ($explore_check < 1) { //they haven't explored today, so let them through!
			    //uncomment the line below to only allow exploring once a day
			    //$mysidia->db->update("users", array("exploretimes_attic" => '1'), "uid = '{$mysidia->user->uid}'");
			    
			}
			else{ //they already explored today!
			    $document->add(new Comment("<br><p><center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>Sorry, you've already been here today. You cant search here!!<br></p></center>"));
			    return; //return prevents the rest of the script from happening if they already explored today
			}
		}
		else {
			$document->add(new Comment("<br><p><center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>Sorry, you do not have a {$item}. You cant search here!!<br></p></center>"));
			return; //return prevents the rest of the script from happening if they don't have the item
		}     
	}
}
?>