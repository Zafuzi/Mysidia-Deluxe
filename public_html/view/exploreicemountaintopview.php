<?php

class Exploreicemountaintopview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Exploring The top of the ice mountain<br>"); 
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/icemountain5/'>Go back to the campsite</a><br><br></center>", FALSE));
        			      	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/exploreicemountaintop'>Search again?</a><br><br></center>", FALSE));
		$item = "Old worn harness";
		$qty = 1;
		$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn();
		if($hasitem){
			$document->add(new Comment("You have a {$item}!"));
			$item = new PrivateItem($item, $mysidia->user->username); 
			$item->remove($qty, $mysidia->user->username);    
			
			//They have the item, so they can explore now
			
			$random = rand(1,80);

			if($random > 1 && $random < 5){
				$item = "White husky hounda";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/0350f0b0169038d5369841283648a84a.png'><br> Oh look! You found a <b>{$item}</b> Companion!</center>", FALSE));
			}
			elseif($random >= 6 && $random <= 15){
				$amount = rand(50,2000);
				$mysidia->user->changecash($amount); 
			$document->add(new Comment("Oh look! You found {$amount} Beads!", FALSE)); 
			}
			elseif($random >= 16 && $random <= 25){
				$item = "Black husky hounda";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ac64278f3c047658e9c73d6bb0566761.png'><br>Oh look! You found a <b>{$item}</b>!</center>", FALSE));
			}
			elseif($random >= 26 && $random <= 30){
				$amount = rand(500,5000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center>Oh look! You found {$amount} Beads!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$amount = rand(50,200);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center>Oh look! You found {$amount} cash!</center>", FALSE)); 
			}
			elseif($random >= 41 && $random <= 50){
				$item = "White husky hounda";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/0350f0b0169038d5369841283648a84a.png'><br>Oh look! You found a <b>{$item}</b>!</center>", FALSE));
			}
			
			elseif($random >= 51 && $random <= 60){
				$item = "Grey Rock";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);  
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/21f115a0879afcc25feda750934c2818.png'><br>Oh look! You found a <b>{$item}</b>!</center>", FALSE));
			}
			elseif($random >= 61 && $random <= 79){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>You didn't find anything. Better luck next time.</center>", FALSE));
			}
			elseif($random == 80){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>You didn't find anything. Better luck next time.</center>", FALSE));
			}
			
		} 
		else {
			$document->add(new Comment("<br><p><center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>Sorry, you do not have a {$item} you cant search here!!<br></p></center>"));
			return; //return prevents the rest of the script from happening if they don't have the item
		}     

	}
}
?>
