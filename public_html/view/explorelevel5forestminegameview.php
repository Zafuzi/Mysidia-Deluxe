<?php

class Explorelevel5forestminegameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Level 5 of the forest mine</center>");
        	$document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_forestmine5} shovels out of 3 shovels.</center>", FALSE));
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/level5forestmine'>mine again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/forestminelevels'> Go back to the level choices</a>.</center>", FALSE));  
	        $today = date('d'); // Day of the month
            
            // Reset explore counter if the last recorded exploration was on a different day than today:
            $reset = $mysidia->user->lastday != $today; 

            // Allow user to explore if they are under the limit or if reset condition is true. 
            if ($mysidia->user->exploretimes_forestmine5 < 3) {  
                $updatedexploretimes_forestmine5 = $mysidia->user->exploretimes_forestmine5 + 1; 
                
                $mysidia->db->update("users", array("exploretimes_forestmine5" => ($updatedexploretimes_forestmine5)), "username = '{$mysidia->user->username}'"); 
			$random = rand(1,120);
            }
			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("You Dug for a while, but found nothing but dirty paws, sorry.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 26){
				$amount = rand(500,4000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("Oh look! You found $amount Beads inside the rock!</center>", FALSE)); 
			}
			elseif($random >= 27 && $random <= 29){
				$item = "Amazonite necklace";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/7398cebe80c1116c49ea9058857d09ff.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 30 && $random <= 60){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 61 && $random <= 63){
				$item = "Artifact necklace";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/e6fa44b774c033000146c52940c34b36.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 64 && $random <= 70){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 73){
				$item = "Imperial necklace";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a  <img src='http://atrocity.mysidiahost.com/picuploads/png/73d5cc072e880a32c93f8512aa9a3d5e.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 74 && $random <= 80){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 82){
				$item = "Onyx necklace";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src=''>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/919d0102a8027d077421d83e27ff8a39.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 83 && $random <= 85){
				$item = "Rhyolite necklace";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/1effbc54d2616c349dae3680d16f1ebe.png'> <b>$item</b>!</center>", FALSE));
			}
elseif($random >= 86 && $random <= 88){
				$item = "Tigereye necklace";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/bbe97a01ee44adcb536cfa6551e6eb3d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 89 && $random <= 99){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("Your pet Got nothing but really dirty...and you didnt find anything..</center>", FALSE));
			}
			elseif($random ==  100 && $random <= 120){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("You didnt find anything, sorry, try again.</center>", FALSE));
			}
			else{
		        $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
		        $document->add(new Comment("<center>You ran out of Shovels for today...You'll have to come back tomorrow.</center>", FALSE));
		    }   

	}

}
?>