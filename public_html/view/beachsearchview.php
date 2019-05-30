<?php

class beachsearchView extends View{
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle("<center>Exploring the beach</center>");
        $document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_beachsearch} of 5 searches.</center>", FALSE));
        $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/beachsearch'>search again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/TheBeach'> Go back to the Beach?</a>.</center>", FALSE));  
	    $today = date('d'); // Day of the month
            
        // Reset explore counter if the last recorded exploration was on a different day than today:
        $reset = $mysidia->user->lastday != $today; 

        // Allow user to explore if they are under the limit or if reset condition is true. 
        if ($mysidia->user->exploretimes_beachsearch < 5) {  
            $updatedexploretimes_beachsearch = $mysidia->user->exploretimes_beachsearch + 1; 
                
            $mysidia->db->update("users", array("exploretimes_beachsearch" => ($updatedexploretimes_beachsearch)), "username = '{$mysidia->user->username}'"); 
			$random = rand(1,115);
            
			if($random > 1 && $random < 20){
	
				$document->add(new Comment("<center>Sorry- your pet didnt find anything this time.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(500,5000);
				$mysidia->user->changecash($amount); 
		
				$document->add(new Comment("<center>Oh look! You found $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 34){
				$item = "Common seashell";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
								$document->add(new Comment("<center>Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/56e165fca5e25a33b5ebe5445122f382.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 35 && $random <= 38){
				$item = "Pumice stone";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
	
				$document->add(new Comment("<center>Oh look! You found a<img src='http://atrocity.mysidiahost.com/picuploads/png/ae798d7563c78bec1d9695efdb5a5902.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 39 && $random <= 42){
				$item = "Blue Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
	
				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/7b254df39cd51bbbce8ca519f27e7b4e.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 42 && $random <= 45){
				$item = "Green Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
	
				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/4cc96ae0910bc368682aebf568da59cb.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 46 && $random <= 48){
				$item = "Bag of Seashells";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
	
				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/fd73eca42dbc03d1de1acc490f199a02.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 49 && $random <= 53){
				$item = "Orange Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/e7a1eb65eb12c2f8c2ec5c9a256095a4.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 54 && $random <= 56){
				$item = "Purple Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
	
				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/1f6dbaac1a054649e1d3a532d93a1553.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 57 && $random <= 60){
				$item = "Red Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/d5c9fff06114b25bc4a91632afc193a4.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 61 && $random <= 99){
		
				$document->add(new Comment("<center>Your pet got sand in its eyes, Maybe you'll have better luck another time?</center>", FALSE));
			}
			elseif($random >= 100 && $random <= 115){
			
				$document->add(new Comment("<center>You didnt find anything, sorry, try again.</center>", FALSE));
			}
		
             else { 
 
    $document->add(new Comment("<center>Seems like you;d cleaned the beach for today...why dont you try again tomorrow?!</center>", FALSE)); 
} 
	}

}
}
?>