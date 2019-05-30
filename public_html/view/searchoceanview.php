<?php

class searchoceanView extends View{
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle("<center>Searching the Ocean</center>");
        $document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_searchocean} of 5 searches.</center>", FALSE));
        $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/searchocean'>search again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/TheBeach'> Go back to the Beach?</a>.</center>", FALSE));  
	    $today = date('d'); // Day of the month
            
        // Reset explore counter if the last recorded exploration was on a different day than today:
        $reset = $mysidia->user->lastday != $today; 

        // Allow user to explore if they are under the limit or if reset condition is true. 
        if ($mysidia->user->exploretimes_searchocean < 5) {  
            $updatedexploretimes_searchocean = $mysidia->user->exploretimes_searchocean + 1; 
                
            $mysidia->db->update("users", array("exploretimes_searchocean" => ($updatedexploretimes_searchocean)), "username = '{$mysidia->user->username}'"); 
			$random = rand(1,115);
            
			if($random > 1 && $random < 20){

				$document->add(new Comment("<center>Sorry- your pet didnt find anything this time.</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(500,5000);
				$mysidia->user->changecash($amount); 
		
				$document->add(new Comment("<center>Oh look! You found $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 35){
				$item = "Empty bottle";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
			
				$document->add(new Comment("<center>Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/595d9fb40b764c1bb89f1e56574230d4.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 36 && $random <= 60){
				$item = "Broken bottle ";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center>Oh look! You found a<img src='http://atrocity.mysidiahost.com/picuploads/png/5303765aecea6795dad019b40df8b457.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 61 && $random <= 64){
				$item = "Blue Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/7b254df39cd51bbbce8ca519f27e7b4e.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 65 && $random <= 69){
				$item = "Green Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
	
				$document->add(new Comment("<center>Oh look! You found some  <img src='http://atrocity.mysidiahost.com/picuploads/png/4cc96ae0910bc368682aebf568da59cb.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 70 && $random <= 73){
				$item = "Message in a bottle";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center>Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/5f24e1ce89e10e7a3bfab1c0f884fbd5.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 74 && $random <= 77){
				$item = "Orange Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/e7a1eb65eb12c2f8c2ec5c9a256095a4.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 78 && $random <= 82){
				$item = "Purple Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center>Oh look! You found some <img src='http://atrocity.mysidiahost.com/picuploads/png/1f6dbaac1a054649e1d3a532d93a1553.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 83 && $random <= 86){
				$item = "Red Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);

				$document->add(new Comment("<center> look! You found some<img src='http://atrocity.mysidiahost.com/picuploads/png/d5c9fff06114b25bc4a91632afc193a4.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 87 && $random <= 99){
	
				$document->add(new Comment("<center>Your pet came up sputtering, Maybe you'll have better luck another time?</center>", FALSE));
			}
			elseif($random >= 100 && $random <= 115){
			
				$document->add(new Comment("<center><center>You didnt find anything, sorry, try again.</center>", FALSE));
			}
		
             else { 
   
    $document->add(new Comment("<center>You're scaring the fish a bit too much..why dont you try again tomorrow?!</center>", FALSE)); 
} 
	}

}
}
?>