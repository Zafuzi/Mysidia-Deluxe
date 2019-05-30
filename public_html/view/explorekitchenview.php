<?php

class explorekitchenview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		
		$profile = $mysidia->user->getprofile();
        if ((int)$profile->getFavpetID() == 0) {
            $document->setTitle("<center>Whoops!</center><br>");
            $document->add(new Comment("<center>You don't have a fav pet! <a href='/account/profile'>Pick one?</a></center>"));
            return;
        }
        
        $pet = new OwnedAdoptable($profile->getFavpetID());
        
		$item = "Laboratory permit";
		$qty = 1;
		$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn();
		if($hasitem){
		    //$document->add(new Comment("<center>You have a {$item}!</center>"));
			$item = new PrivateItem($item, $mysidia->user->username); 
        	$document->setTitle("<center>Your pet {$pet->name} is having a snack<br>"); 
        	
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/myhouse/'>Go back to the house</a><br><br></center>", FALSE));
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/explorekitchen'>Give pet another snack</a><br><br></center>", FALSE));
	
			//They have the item, so they can explore now
			$document->add(new Comment("<center><img src='https://cdn.discordapp.com/attachments/502505548818939941/571385569070809119/kitcheneatgif1.gif'></center><br/>")); 
	
  $boost = mt_rand(10,50);
                if($pet->getHunger() < 50){
                    $new_mood = $pet->getHunger() + $boost; if($new_mood > 50){$new_mood = 50;}
                    $mysidia->db->update("adoptable_stats", array("Hunger" => $new_mood), "id = '$pet->aid'");
                    $document->add(new Comment("<center>That was a delicious Snack!! <b>{$pet->name}</b> has recovered <b>{$boost}</b> Hunger.</center>"));
                }
                else{$document->add(new Comment("<center>That was a delicious snack!</center>"));}
		
  $boost = mt_rand(10,50);
                if($pet->getThirst() < 50){
                    $new_mood = $pet->getThirst() + $boost; if($new_mood > 50){$new_mood = 50;}
                    $mysidia->db->update("adoptable_stats", array("Thirst" => $new_mood), "id = '$pet->aid'");
                    $document->add(new Comment("<center>That was a satisfying drink!! <b>{$pet->name}</b> has recovered <b>{$boost}</b> thirst.</center>"));
                }
                else{$document->add(new Comment("<center>That was a satisfying drink!</center>"));}
		}
		else {
		    $document->setTitle("<center>Whoops!</center><br>");
			$document->add(new Comment("<br><p><center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>Sorry, you do not have a {$item}. You cant give your pet a snack!<br></p></center>"));
			return; //return prevents the rest of the script from happening if they don't have the item
		}     
	}
}

?>