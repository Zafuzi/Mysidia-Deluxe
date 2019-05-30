 <?php

class Explorelevel3forestminegameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Level 3 of the forest mine</center>");
        	$document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_forestmine3} PIckaxes out of 3 pickaxes.</center>", FALSE));
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/level3forestmine'>mine again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/forestminelevels'> Go back to the level choices</a>.</center>", FALSE));  
	        $today = date('d'); // Day of the month
            
            // Reset explore counter if the last recorded exploration was on a different day than today:
            $reset = $mysidia->user->lastday != $today; 

            // Allow user to explore if they are under the limit or if reset condition is true. 
            if ($mysidia->user->exploretimes_forestmine3 < 3) {  
                $updatedexploretimes_forestmine3 = $mysidia->user->exploretimes_forestmine3 + 1; 
                
                $mysidia->db->update("users", array("exploretimes_forestmine3" => ($updatedexploretimes_forestmine3)), "username = '{$mysidia->user->username}'"); 
                  
			$random = rand(1,120);
            }
			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("You Smashed open the Rock, but nothing was inside, sorry.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(500,2000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));
				$document->add(new Comment("Oh look! You found $amount Beads inside the rock!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 35){
				$item = "Blue rock";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/270478327290a87f8a56024a6da4a815.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 36 && $random <= 60){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 61 && $random <= 63){
				$item = "Blue rock";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/270478327290a87f8a56024a6da4a815.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 64 && $random <= 70){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src=''>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 73){
				$item = "Moonstone";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a  <img src='http://atrocity.mysidiahost.com/picuploads/png/4a8426e02bd57dc2fc201efb92dda800.png'> <b>$item</b>!</center>", FALSE));
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
			elseif($random >= 91 && $random <= 94){
				$item = "Amber Gem";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/6ece0f1f53b64dbbc3ceb5e96d0ba8ae.png'> <b>$item</b>!</center>", FALSE));
			}
elseif($random >= 95 && $random <= 110){
				$item = "Dirt";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d13f0c1374f4085040b8a55c9a395f7b.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/0dfa9a7697d0b3244321fbcdb9bad84d.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 111 && $random <=115 ){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/4f6ffff5c3d2efb101358ab81ffb4702.png'>"));
				$document->add(new Comment("Your pet hurt themselves on a sharp piece... you didnt find anything..</center>", FALSE));
			}
			elseif($random == 116 && $random <=120 ){
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