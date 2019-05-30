<?php

class Explorelevel6forestminegameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Level 6 of the forest mine</center>");
        	$document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_forestmine6} shovels out of 1 shovels.</center>", FALSE));
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/level6forestmine'>mine again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/forestminelevels'> Go back to the level choices</a>.</center>", FALSE));  
	        $today = date('d'); // Day of the month
            
            // Reset explore counter if the last recorded exploration was on a different day than today:
            $reset = $mysidia->user->lastday != $today; 

            // Allow user to explore if they are under the limit or if reset condition is true. 
            if ($mysidia->user->exploretimes_forestmine6 < 1) {  
                $updatedexploretimes_forestmine6 = $mysidia->user->exploretimes_forestmine6 + 1; 
                
                $mysidia->db->update("users", array("exploretimes_forestmine6" => ($updatedexploretimes_forestmine6)), "username = '{$mysidia->user->username}'"); 
			$random = rand(1,120);
            }
			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("You Dug for a while, but found nothing but dirty paws, sorry.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 26){
				$amount = rand(500,6000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));
				$document->add(new Comment("Oh look! You found $amount Beads inside the rock!</center>", FALSE)); 
			}
			elseif($random >= 27 && $random <= 28){
				$item = "Antique faucet";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/d8b19cbc7e5f5c2f70a61568678661a0.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 29 && $random <= 30){
				$item = "Wooden chicken";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/7c34d63a66b9faf8cc3f450f2bccce7d.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 31 && $random <= 32){
				$item = "Butterfly hairclip";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/03c095dd3d503256d6e0e92454e48379.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 33 && $random <= 34){
				$item = "Old glove";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/518faf5a526569a7fe6d5e156183ddf1.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 35 && $random <= 36){
				$item = "Old manuscript";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src=''>"));  
				$document->add(new Comment("Oh look! You found a  <img src='http://atrocity.mysidiahost.com/picuploads/png/aee17291b326a47700d02759b4db4585.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 37 && $random <= 38){
				$item = "Old mirror";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/31cc1434eab1d1d6a2926eb54265c4e2.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 39 && $random <= 40){
				$item = "Old pendant";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/f3d13462d647df91ad53792674df42e9.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 41 && $random <= 42){
				$item = "Strange cube";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/d6fd9c5b20090a8748c5f128a01d139d.png'> <b>$item</b>!</center>", FALSE));
			}
elseif($random >= 43 && $random <= 44){
				$item = "Wooden apple";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/cbde45ddec2933ded032d38cf9bcd7b3.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 45 && $random <= 99){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("Your pet Got nothing but really dirty...and you didnt find anything..</center>", FALSE));
			}
			elseif($random == 100 && $random <= 120){
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