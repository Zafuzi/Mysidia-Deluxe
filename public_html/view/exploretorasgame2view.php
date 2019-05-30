<?php

class ExploreTorasgame2View extends View{
	
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>Smash pumpkins with Tora</center>");           
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

$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/Torapumpkinsmash2'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/bakenekohalloween'> Go back to the event plaza</a></center>", FALSE));   
                           
  
                  
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
				$item = "Zombie Bureaucrat";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/0c6eb73d80733ffc47828f87886f7247.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 41 && $random <= 60){
				$item = "Rook Block";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/974c2f8d54a07aafd521f70321f6281f.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 101 && $random <= 110){
				$item = "Tree Spirit block";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("You found <img src='http://atrocity.mysidiahost.com/picuploads/png/8d612edbf55ef7ed689c90b5a99b3902.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 61 && $random <= 70){
				$item = "Strange Creature Block ";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("You found an uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/80c686a0d9125a94b2234a82c709606a.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 75){
				$item = "Bogfire Spirit Block";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a rare <img src='http://atrocity.mysidiahost.com/picuploads/png/6800775376bb13506ccd58b6c78eed01.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 76 && $random <= 80){
				$item = "Phantom block";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/a3a3134d4eee9a393c81724ed9bc7b7a.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 90){
				$item = "Squid Spirit block";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/38c427b649ec81718a72d35a31babd3f.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 111 && $random <= 115){
				$item = "Dust Bunny Block";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/8be82848bfab48d6ba83cf8287aa91f2.png'> <b>$item</b>!</center>", FALSE));
			}
elseif($random >= 116 && $random <= 120){
				$item = "Bat Block";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ea057c49d8f39d20cde5dcaa8a9efcfd.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/705090cbf5de987eba6c955d1099ced4.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 91 && $random <= 99){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5009e4faa7c67cd9b63e8e375fd01ca3.png'>"));
				$document->add(new Comment("Your pet Got all slimy and sticky from trying to get into the pumpkin, But there was no prize</center>", FALSE));
			}
			elseif($random == 100){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5009e4faa7c67cd9b63e8e375fd01ca3.png'>"));
				$document->add(new Comment("You didnt find anything, sorry, try again.</center>", FALSE));
			}
             else { 
    $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5009e4faa7c67cd9b63e8e375fd01ca3.png'></center>", FALSE)); 
    $document->add(new Comment("<center>You are out of candy...come back when you have more!!</center>", FALSE)); 
}

	}

}
?>