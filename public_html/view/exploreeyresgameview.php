<?php

class exploreeyresgameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle("<center>Hanafuda with Eyre</center>");
        $document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_eyregame} of 2 plays.</center>", FALSE));
        $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/Hanafudawitheyre'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/arcade'> Go back to the arcade</a>.</center>", FALSE));  
	    $today = date('d'); // Day of the month
            
        // Reset explore counter if the last recorded exploration was on a different day than today:
        $reset = $mysidia->user->lastday != $today; 

        // Allow user to explore if they are under the limit or if reset condition is true. 
        if ($mysidia->user->exploretimes_eyregame < 2) {  
            $updatedexploretimes_eyregame = $mysidia->user->exploretimes_eyregame + 1; 
                
            $mysidia->db->update("users", array("exploretimes_eyregame" => ($updatedexploretimes_eyregame)), "username = '{$mysidia->user->username}'"); 
            $random = rand(1,135); 
             
            if($random > 1 && $random < 20){ 
                $document->add(new Comment("<b><center>Eyres Hand</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/291a4c3f9d34e71b1a97ba1ea41a2476.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<center>You lost!</center>", FALSE)); 
            } 
            elseif($random >= 21 && $random <= 30){ 
                $amount = rand(5,20); 
                $mysidia->user->changecash($amount);  
                $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("center><img src='http://pile.randimg.net/1/90/85240/Hanafuda%20ties.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85240/Hanafuda%20ties.png'></center>", FALSE)); 
                $document->add(new Comment("<center>Its a Tie...I guess I'll give you some beads...<i>You got $amount Beads!</center></i>", FALSE));  
            } 
            elseif($random >= 61 && $random <= 70){ 
                $item = "Onigiri"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>, FALSE")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("Alright Human thing... you can have my common <img src='http://atrocity.mysidiahost.com/picuploads/png/e48bc0117875e792924062ee2afe945b.png'> <b>$item</b>!</center>", FALSE)); 
            } 
            elseif($random >= 71 && $random <= 75){ 
                $item = "Red Oni Mask "; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("No...not my rare <img src='http://atrocity.mysidiahost.com/picuploads/png/9738197cf7676819f387e0374bcd8e48.png'> <b>$item</b>!Human thing you are unfair!</center>", FALSE)); 
            } 
            elseif($random >= 81 && $random <= 90){ 
                $item = "Red Daruma Doll"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("This is why I hate Human things... they always take my <img src='http://atrocity.mysidiahost.com/picuploads/png/9b8c72673221c817be9b600a91fbfd7c.png'><b>$item</b>!</center>", FALSE)); 
            } 
            elseif($random >= 91 && $random <= 99){ 
                $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/291a4c3f9d34e71b1a97ba1ea41a2476.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));   
                $document->add(new Comment("You lose Human thing!</center>", FALSE)); 
            } 
            elseif($random == 100){ 
                $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/291a4c3f9d34e71b1a97ba1ea41a2476.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));   
                $document->add(new Comment("You lose Human thing!</center>", FALSE)); 
            } 
            elseif($random >= 101 && $random <= 108){ 
                $item = "Tanuki plush"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("This is why I hate Human things... they always take my <img src='http://atrocity.mysidiahost.com/picuploads/png/6ae032de03b656562267ba5b58e0e210.png'><b>$item</b>!</center>", FALSE)); 
            } 
            elseif($random >= 109 && $random <= 111){ 
                $item = "Pink Kokeshi Doll"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("No...not my rare <img src=http://atrocity.mysidiahost.com/picuploads/png/0dab3607d3ff4f4ec24f3b6e1a81eb96.png'> <b>$item</b>!Human thing you are unfair!</center>", FALSE));
            } 
            elseif($random >= 111 && $random <= 115){ 
                $item = "Green Kokeshi Doll"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>, FALSE")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("Alright Human thing... you can have my uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/1e719d1922587a6fe6d63807e8685fd2.png'> <b>$item</b>!</center>", FALSE)); 
            }                           
            elseif($random >= 115 && $random <= 119){ 
                $item = "Blue Kokeshi doll"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>, FALSE")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("Alright Human thing... you can have my uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/54e1469e3733dd46da4f8e580cac36e2.png'> <b>$item</b>!</center>", FALSE)); 
            } 
            elseif($random >= 120 && $random <= 125){ 
                $item = "Old sandals"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>, FALSE")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("Alright Human thing... you can have my uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/34910ada2c68093c607f4ff9ae254653.png'> <b>$item</b>!</center>", FALSE)); 
            } 
            elseif($random >= 125 && $random <= 130){ 
                $item = "Chipped Teacup"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("This is why I hate Human things... they always take my <img src='http://atrocity.mysidiahost.com/picuploads/png/ac0b734ba93013432e6204b065cfcad1.png'><b>$item</b>!</center>", FALSE)); 
            } 
            elseif($random >= 131 && $random <= 132){ 
                $item = "Bonzai Tree"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("This is why I hate Human things... they always take my <img src='http://atrocity.mysidiahost.com/picuploads/png/8f81128db3867af1c6e481b42fb6f723.png'><b>$item</b>!</center>", FALSE)); 
            } 
            elseif($random >= 133 && $random <= 135){ 
                $item = "Sake Bottle"; 
                $qty = 1; 
                $newitem = new StockItem($item); 
                $newitem->append($qty, $mysidia->user->username); 
                $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>")); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE)); 
                $document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE)); 
                $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));   
                $document->add(new Comment("This is why I hate Human things... they always take my <img src='http://atrocity.mysidiahost.com/picuploads/png/8f81128db3867af1c6e481b42fb6f723.png'><b>$item</b>!</center>", FALSE)); 
            } 
        } 
        else{ 
            $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/b30c16d80645c40477b2143fae5f5eeb.png'></center>", FALSE)); 
            $document->add(new Comment("<center>You are out of Plays...come back when you have more!!</center>", FALSE)); 
        }
    } 
}
?> 