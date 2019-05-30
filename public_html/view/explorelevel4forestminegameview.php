<?php

class Explorelevel4forestminegameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Level 4 of the forest mine</center>");
        	$document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_forestmine4} PIckaxes out of 2 pickaxes.</center>", FALSE));
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/level4forestmine'>mine again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/forestminelevels'> Go back to the level choices</a>.</center>", FALSE));  
	        $today = date('d'); // Day of the month
            
            // Reset explore counter if the last recorded exploration was on a different day than today:
            $reset = $mysidia->user->lastday != $today; 

            // Allow user to explore if they are under the limit or if reset condition is true. 
            if ($mysidia->user->exploretimes_forestmine4 < 2) {  
                $updatedexploretimes_forestmine4 = $mysidia->user->exploretimes_forestmine4 + 1; 
                
                $mysidia->db->update("users", array("exploretimes_forestmine4" => ($updatedexploretimes_forestmine4)), "username = '{$mysidia->user->username}'"); 
                  
			$random = rand(1,120);
            }
			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("You Smashed open the Rock, but nothing was inside, sorry.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 25){
				$amount = rand(500,2000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));
				$document->add(new Comment("Oh look! You found $amount Beads inside the rock!</center>", FALSE)); 
			}
			elseif($random >= 36 && $random <= 37){
				$item = "Ruby Gem";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/5cc5cf71ba046a2fafd1cc4471e43f30.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 38 && $random <= 60){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 61 && $random <= 62){
				$item = "Sapphire Gem";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/207cd99ef9767b4e1182d3a3bc336a8c.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 63 && $random <= 70){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 72){
				$item = "Diamond Gem";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a  <img src='http://atrocity.mysidiahost.com/picuploads/png/a460134f76714ef7f976ace6d3f57ad4.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 72 && $random <= 80){
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
			elseif($random >= 91 && $random <= 110){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
elseif($random >= 111 && $random <= 115){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 116 && $random <= 118){
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