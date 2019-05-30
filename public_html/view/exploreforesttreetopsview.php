<?php

class exploreforesttreetopsview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Exploring The top of the Forest mountain trees<br></center>"); 
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/forestmountain4//'>Go back down</a><br><br></center>", FALSE));
        			      	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/exploreforesttreetops/'>Try again?</a><br><br></center>", FALSE));
		$item = "Mealworm";
		$qty = 1;
		$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn();
		if($hasitem){
			$document->add(new Comment("You have a {$item}!"));
			$item = new PrivateItem($item, $mysidia->user->username); 
			$item->remove($qty, $mysidia->user->username);    
			
			//They have the item, so they can explore now
			
			$random = rand(1,99);

			if($random > 1 && $random < 5){
				$item = "Albino mini glidera";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/5aabbd9df0996f0974aa4c23f476ef29.png'><br>Oh look! You found a <b>{$item}</b> Companion!", FALSE));
			}
			elseif($random >= 6 && $random <= 15){
				$amount = rand(50,2000);
				$mysidia->user->changecash($amount); 
			$document->add(new Comment("Oh look! You found {$amount} Beads!", FALSE)); 
			}
			elseif($random >= 16 && $random <= 25){
				$item = "Ringtail mini glidera";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/4decd474925d3b37b77693bbfff2b0b7.png'><br>Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			elseif($random >= 26 && $random <= 30){
				$amount = rand(500,5000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("Oh look! You found {$amount} Beads!", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$amount = rand(50,200);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("Oh look! You found {$amount} Beads!", FALSE)); 
			}
			elseif($random >= 41 && $random <= 50){
				$item = "Platinum mini glidera";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/438a075ceaa7920126f06489d0ed9f71.png'><br>Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			
			elseif($random >= 51 && $random <= 60){
				$item = "Grey Rock";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/21f115a0879afcc25feda750934c2818.png'><br>Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			elseif($random >= 61 && $random <= 79){
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>You didn't find anything. Better luck next time.", FALSE));
			}
						elseif($random >= 80 && $random <= 85){
				$item = "Leu mini glidera";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/5b577d2b8ee23c263b09fb41d46fc247.png'><br>Oh look! You found a <b>{$item}</b>!", FALSE));
			}
						elseif($random >= 86 && $random <= 92){
				$item = "Grey mini glidera";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/41f3b5d2dbe0b1b0e8e0cb56f9a0d5cc.png'><br>Oh look! You found a <b>{$item}</b>!", FALSE));
			}
						elseif($random >= 93 && $random <= 98){
				$item = "Cremino mini glidera";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/176c4604326d7d3eba9d0963159a45de.png'><br>Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			elseif($random == 99){
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>You didn't find anything. Better luck next time.", FALSE));
			}
			
		} 
		else {
			$document->add(new Comment("<center><p><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br></p>"));$document->add(new Comment("<p>Sorry, you do not have a {$item} you cant search here!!<br></p></center>"));
			return; //return prevents the rest of the script from happening if they don't have the item
		}     

	}
}
?>
