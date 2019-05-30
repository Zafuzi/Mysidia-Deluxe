<?php

class ExploretorasgameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle("<center>Tora's Smashing Pumpkin Game</center>");
        $document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_torasgame} of 2 plays.</center>", FALSE));
        $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/Torapumpkinsmash'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/arcade'> Go back to the arcade</a>.</center>", FALSE));  
	    $today = date('d'); // Day of the month
            
        // Reset explore counter if the last recorded exploration was on a different day than today:
        $reset = $mysidia->user->lastday != $today; 

        // Allow user to explore if they are under the limit or if reset condition is true. 
        if ($mysidia->user->exploretimes_torasgame < 2) {  
            $updatedexploretimes_torasgame = $mysidia->user->exploretimes_torasgame + 1; 
                
            $mysidia->db->update("users", array("exploretimes_torasgame" => ($updatedexploretimes_torasgame)), "username = '{$mysidia->user->username}'"); 
		    $random = rand(1,120);
		    
		    if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5009e4faa7c67cd9b63e8e375fd01ca3.png'>"));
				$document->add(new Comment("You Smashed open the Pumpkin, but nothing was inside, sorry.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(5,20);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));
				$document->add(new Comment("Oh look! You found $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$item = "Chinese Paintbrush";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/b5603564386f3376d0629909faa17165.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 41 && $random <= 60){
				$item = "Purple Daruma Doll";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/8b309b1bdfc02d345bf7214b688f9642.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 101 && $random <= 110){
				$item = "Onigiri";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/e48bc0117875e792924062ee2afe945b.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 61 && $random <= 70){
				$item = "Maneki neko";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("You found an uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/1ba00eff59909d985114fa71a8a66354.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 75){
				$item = "Blue Oni Mask";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a rare <img src='http://atrocity.mysidiahost.com/picuploads/png/ca4b07fb3ad0932e207291917edd62c8.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 76 && $random <= 80){
				$item = "Yellow Kokeshi Doll";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/285f027555244d822fd6700ce31844e0.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 90){
				$item = "Japanese windchime";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/7397189b28563055039b57df55b36ee2.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 111 && $random <= 115){
				$item = "Salmon Kokeshi doll";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/ddbb3ed5f46075bb216c19d2e20471e4.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 116 && $random <= 120){
				$item = "Tanuki plush";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/6ae032de03b656562267ba5b58e0e210.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 91 && $random <= 99){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5009e4faa7c67cd9b63e8e375fd01ca3.png'>"));
				$document->add(new Comment("Your pet Got all slimy and sticky from trying to get into the pumpkin, But there was no prize</center>", FALSE));
			}
			elseif($random == 100){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5009e4faa7c67cd9b63e8e375fd01ca3.png'>"));
				$document->add(new Comment("You didnt find anything, sorry, try again.</center>", FALSE));
			}
		    
        }
		else{
		  $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5009e4faa7c67cd9b63e8e375fd01ca3.png'>"));
		  $document->add(new Comment("<center>I'm All out of pumpkins for today...You'll have to come back tomorrow.</center>", FALSE));
		}   
	}
}
?>