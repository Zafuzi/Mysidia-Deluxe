<?php

class Exploremeadowfarmview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Exploring the meadow's farm<br>"); 
        	$document->add(new Comment("<a href='http://atrocity.mysidiahost.com/pages/view/Meadowfarm'>Go back</a><br><br></center>", FALSE));
		$item = "Shovel";
		      	$document->add(new Comment("<a href='http://atrocity.mysidiahost.com/exploremeadowfarm'>Dig again?</a><br><br></center>", FALSE));
		$item = "Shovel";
		$qty = 1;
		$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn();
		if($hasitem){
			$document->add(new Comment("You have a {$item}!"));
			$item = new PrivateItem($item, $mysidia->user->username); 
			$item->remove($qty, $mysidia->user->username);    
			
			//They have the item, so they can explore now
			
			$random = rand(1,80);

			if($random > 1 && $random < 5){
				$item = "Homegrown Zuchinni";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			elseif($random >= 6 && $random <= 15){
				$amount = rand(50,2000);
				$mysidia->user->changecash($amount); 
			$document->add(new Comment("Oh look! You found {$amount} Beads!", FALSE)); 
			}
			elseif($random >= 16 && $random <= 25){
				$item = "Homegrown Carrot";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			elseif($random >= 26 && $random <= 30){
				$amount = rand(500,5000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("Oh look! You found {$amount} Beads!", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$amount = rand(50,200);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("Oh look! You found {$amount} cash!", FALSE)); 
			}
			elseif($random >= 41 && $random <= 50){
				$item = "Homegrown Potato";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			
			elseif($random >= 51 && $random <= 60){
				$item = "Homegrown Parsnip";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("Oh look! You found a <b>{$item}</b>!", FALSE));
			}
			elseif($random >= 61 && $random <= 79){
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>You didn't find anything. Better luck next time.", FALSE));
			}
			elseif($random == 80){
				$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>You didn't find anything. Better luck next time.", FALSE));
			}
			
		} 
		else {
			$document->add(new Comment("<img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br><p>Sorry, you do not have a {$item} you cant search here!!<br></p>"));
			return; //return prevents the rest of the script from happening if they don't have the item
		}     

	}
}
?>
