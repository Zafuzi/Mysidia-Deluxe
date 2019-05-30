<?php

class Exploreeyresgame2View extends View{
	
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>Hanafuda with Eyre</center>");           
$item = "Katty Taffy"; 
$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn(); 
if($hasitem > 0){ 
    $document->add(new Comment("<b><center>Used 1 <img src='http://atrocity.mysidiahost.com/picuploads/png/1fd47190afccea95a16e3794bb33f5ff.png'> {$item}!</b></center>"));
    $qty = 1; 
    $item = new PrivateItem($item, $mysidia->user->username); 
    $item->remove($qty, $mysidia->user->username);
}
else{
    $document->add(new Comment("<b><center>You don't have a <img src='http://atrocity.mysidiahost.com/picuploads/png/1fd47190afccea95a16e3794bb33f5ff.png'> {$item}!</b><p>
    <a href='http://atrocity.mysidiahost.com/pages/view/bakenekohalloween'>Return to the event?</a></p></center>"));
    return;
}

        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/exploreeyresgame2'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/bakenekohalloween'> Go back to the event plaza</a>.</center>", FALSE));  
	                         
			$random = rand(1,115);
           
			if($random > 1 && $random < 20){
$document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/291a4c3f9d34e71b1a97ba1ea41a2476.png'>"));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
				$document->add(new Comment("<center>You lost!</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(5,20);
				$mysidia->user->changecash($amount); 
$document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
$document->add(new Comment("center><img src='http://pile.randimg.net/1/90/85240/Hanafuda%20ties.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85240/Hanafuda%20ties.png'></center>", FALSE));
				$document->add(new Comment("<center>Its a Tie...I guess I'll give you some beads...<i>You got $amount Beads!</center></i>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$item = "Red Pirahna Toy";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
$document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));
				$document->add(new Comment("<center>Ugh! I cant lose... fine... take this <img src='http://atrocity.mysidiahost.com/picuploads/png/b5249b5da4564c210d83f7cd61de9d33.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 41 && $random <= 60){
				$item = "Fake fangs";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
                           $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));  
				$document->add(new Comment("<center>Take it Human thing...The <img src='http://atrocity.mysidiahost.com/picuploads/png/69680cfc5d803f9170fe6549655f7f5b.png'><b>$item</b> is yours!</center>", FALSE));
            }
			elseif($random >= 101 && $random <= 110){
				$item = "Red Gummy eye";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				 $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));  
				$document->add(new Comment("Fine Human thing...take the treasure.. the <img src='http://atrocity.mysidiahost.com/picuploads/png/40618507daa6fe0dd5708d878139c1e4.png'><b>$item</b> belongs to you now.</center>", FALSE));
			}
			
			elseif($random >= 61 && $random <= 70){
				$item = "Halloween Kazoo";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				 $document->add(new Comment("<b><center>Eyres Hand</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'></center>", FALSE));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));  
				$document->add(new Comment("<center>Alright Human thing... you can have my uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/6cd9c65227f0ae199cf399f294c1acb1.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 75){
				$item = "Jar of Halloween spirit";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				 $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));  
				$document->add(new Comment("No...not my rare <img src=http://atrocity.mysidiahost.com/picuploads/png/63388ceaa8e021597d9af37977138554.png'> <b>$item</b>!Human thing you are unfair!</center>", FALSE));
			}
			elseif($random >= 76 && $random <= 80){
				$item = "Mystery candy";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				 $document->add(new Comment("<b><center>Eyres Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));  
				$document->add(new Comment("Fine human thing....take my <img src='http://atrocity.mysidiahost.com/picuploads/png/282ad92a5ac391066e7e1999809f39ab.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 90){
				$item = "Zombie arm";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				 $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));  
				$document->add(new Comment("This is why I hate Human things... they always take my <img src='http://atrocity.mysidiahost.com/picuploads/png/856746dbbefc14049ea9d29bf86049a7.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 111 && $random <= 115){
				$item = "Halloween Treat basket";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				 $document->add(new Comment("<b><center>Eyre's Hand.</center></b>", FALSE));
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8a513071bd47ab3361b61942118f8b87.png'>"));
  $document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85239/Hanafuda%20losers.png'></center>", FALSE));
$document->add(new Comment("<b><center>Your Hand.</center></b>", FALSE));
$document->add(new Comment("<center><img src='http://pile.randimg.net/1/90/85238/Hanafuda%20winners.png'></center>", FALSE));  
				$document->add(new Comment("Alright alright...the <img src='http://atrocity.mysidiahost.com/picuploads/png/6282ede37f0ccc934ea7336751740ccc.png'> <b>$item</b> is yours.</center>", FALSE));
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
  
             else { 
    $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/e0e7af76327949082a47922fe0d6c1e4.png'></center>", FALSE)); 
    $document->add(new Comment("<center>You are out of candy...come back when you have more!!</center>", FALSE)); 
}   
} 
	}


?>