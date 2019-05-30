<?php

class Explorelevel1forestminegameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Level 1 of the forest mine</center>");
        	$document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_forestmine1} PIckaxes out of 5 pickaxes.</center>", FALSE));
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/level1forestmine'>mine again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/forestminelevels'> Go back to the level choices</a>.</center>", FALSE));  
	        $today = date('d'); // Day of the month
            
            // Reset explore counter if the last recorded exploration was on a different day than today:
            $reset = $mysidia->user->lastday != $today; 

            // Allow user to explore if they are under the limit or if reset condition is true. 
            if ($mysidia->user->exploretimes_forestmine1 < 5) {  
                $updatedexploretimes_forestmine1 = $mysidia->user->exploretimes_forestmine1 + 1; 
                
                $mysidia->db->update("users", array("exploretimes_forestmine1" => ($updatedexploretimes_forestmine1)), "username = '{$mysidia->user->username}'"); 
                  
			$random = rand(1,120);
            }
			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("You Smashed open the Rock, but nothing was inside, sorry.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 24){
				$amount = rand(500,2000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));
				$document->add(new Comment("Oh look! You found $amount Beads inside the rock!</center>", FALSE)); 
			}
			elseif($random >= 25 && $random <= 28){
				$item = "Copper Bar";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/7ccd513b4f0d9200469b3b169669476a.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 29 && $random <= 60){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 61 && $random <= 63){
				$item = "Iron Bar";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/2ac166324539eca9437b4cea8b6825d4.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 63 && $random <= 70){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 73){
				$item = "Gold Bar";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a  <img src='http://atrocity.mysidiahost.com/picuploads/png/897d979215b8328080d8d871d59778cd.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 74 && $random <= 80){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 90){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 99 && $random <= 101){
				$item = "Silver Bar";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/68d5213c9da4e8fc72554c1eb7501c30.png'> <b>$item</b>!</center>", FALSE));
			}
elseif($random >= 102 && $random <= 107){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 108 && $random <= 118){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("Your pet hurt themselves on a sharp piece... you didnt find anything..</center>", FALSE));
			}
			elseif($random == 119 && $random <= 120){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("You didnt find anything, sorry, try again.</center>", FALSE));
			}
			else{
		        $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
		        $document->add(new Comment("<center>You ran out of pickaxes for today...You'll have to come back tomorrow.</center>", FALSE));
		    }   

	}

}
?>