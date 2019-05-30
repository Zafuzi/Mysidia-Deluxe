 <?php 

class ExplorehoshisgameView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>The Corn Maze with Hoshi</center>");           
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
  
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/Cornmazewithhoshi'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/bakenekohalloween'> Go back to the event plaza</a></center>", FALSE));   
                           
			$random = rand(1,118);
            			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/2eab46da248e7e4955debdf1d8bca0bc.png'>"));
				$document->add(new Comment("Your pet Got lost..and wandered out the exit...Sorry! they lose Human thing And I get a candy!!!</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(5,20);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/f3395342a569f18397e312f1a09cbf1a.png'>"));
				$document->add(new Comment("Oh look! you didnt find me but You found $amount Beads! I'll take a candy now!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$item = "Mouse Tail";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/f3395342a569f18397e312f1a09cbf1a.png'>"));  
				$document->add(new Comment("Oh wow Human thing you found me! Heres a <img src='http://atrocity.mysidiahost.com/picuploads/png/313d41c77e2755158c8419b53a991e44.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 41 && $random <= 60){
				$item = "Stray Candy Corns";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1eedc31b8b547837de4aa3acf545c4c7.png'>"));  
				$document->add(new Comment("Okay fair is fair human thing You found me! Take this <img src='http://atrocity.mysidiahost.com/picuploads/png/c74ee2e357e630036b571173444b45f0.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 101 && $random <= 110){
				$item = "Reject candy corns";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/f3395342a569f18397e312f1a09cbf1a.png'>"));  
				$document->add(new Comment("Okay! I've been found! heres a <img src='http://atrocity.mysidiahost.com/picuploads/png/922a0a2137765b88df3ed94a1f55d12f.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 61 && $random <= 70){
				$item = "Rat tail";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/f3395342a569f18397e312f1a09cbf1a.png'>"));  
				$document->add(new Comment("Haha! here I am! And heres an uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/df0d9afdaaf7b8830c06fdf218a84cd8.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 75){
				$item = "Harvest moon Bookmark";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1eedc31b8b547837de4aa3acf545c4c7.png'>"));  
				$document->add(new Comment("Oh! i thought I was hiding so well too! Oh well fair is fair! heres a rare <img src='http://atrocity.mysidiahost.com/picuploads/png/c734267020b0c87c9d06068a95cde4a0.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 76 && $random <= 80){
				$item = "Scary Candy Corns";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/f3395342a569f18397e312f1a09cbf1a.png'>"));  
				$document->add(new Comment("Here I am human thing! and heres a <img src='http://atrocity.mysidiahost.com/picuploads/png/fa60d8d084e40d041883f14f16b109fa.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 90){
				$item = "Poisonous Candy Corns";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1eedc31b8b547837de4aa3acf545c4c7.png'>"));  
				$document->add(new Comment("You found me! here you go human thing! A <img src='http://atrocity.mysidiahost.com/picuploads/png/e6ff0fbbb25208b562670f1b12dce703.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 111 && $random <= 115){
				$item = "Rubber Tail";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1eedc31b8b547837de4aa3acf545c4c7.png'>"));  
				$document->add(new Comment("You found me!! have a  <img src='http://atrocity.mysidiahost.com/picuploads/png/fe1dc40b3d4389e3a63a22b0171647dd.png'> <b>$item</b>!</center>", FALSE));
			}
						elseif($random >= 116 && $random <= 118){
				$item = "Friendly Ghost";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1eedc31b8b547837de4aa3acf545c4c7.png'>"));  
				$document->add(new Comment("You found me!! have a  <img src='http://atrocity.mysidiahost.com/picuploads/png/d17d00acb2f01a51fff8cb3c316956d6.png'> <b>$item</b>!</center>", FALSE));
			}
						elseif($random >= 118 && $random <= 122){
				$item = "Gummy Tail";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1eedc31b8b547837de4aa3acf545c4c7.png'>"));  
				$document->add(new Comment("You found me!! have a  <img src='http://atrocity.mysidiahost.com/picuploads/png/6b009a047151d810361e7725353a128b.png'> <b>$item</b>!</center>", FALSE));
			}
				elseif($random >= 123 && $random <= 125){
				$item = "Halloween Bottle";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1eedc31b8b547837de4aa3acf545c4c7.png'>"));  
				$document->add(new Comment("You found me!! have a  <img src='http://atrocity.mysidiahost.com/picuploads/png/016dbdb4dc6b856e250901a129c15c03.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 91 && $random <= 99){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/56c01193346ae88af61c9eb4be2be83e.png'>"));
				$document->add(new Comment("well you didnt find me, but I'll take your candy anyway!</center>", FALSE));
			}
			elseif($random == 100){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/56c01193346ae88af61c9eb4be2be83e.png'>"));
				$document->add(new Comment("You didnt find me, sorry human thing, try again.</center>", FALSE));
			}
             else { 
    $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/2eab46da248e7e4955debdf1d8bca0bc.png'></center>", FALSE)); 
    $document->add(new Comment("<center>You are out of candy...come back when you have more!!</center>", FALSE)); 
}    
    } 
   }  
?> 