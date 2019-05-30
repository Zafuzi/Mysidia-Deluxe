 <?php 

class ExploreaurorasgameView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>The spooky forest with Aurora</center>");           
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
  
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/Spookyforestwithauro'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/bakenekohalloween'> Go back to the event plaza</a></center>", FALSE));   
                           
			$random = rand(1,122);
            			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/e0e7af76327949082a47922fe0d6c1e4.png'>"));
				$document->add(new Comment("Sorry human thing...your pet Got too Scared to continue!</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(5,20);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));
				$document->add(new Comment("Your pet managed to find- $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$item = "Bat Wing";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/47dcbf781182b4850cc2d72dd77d41a4.png'>"));  
				$document->add(new Comment("Your pet found a <img src='http://atrocity.mysidiahost.com/picuploads/png/f5f3895544cce10eff234e933d11f0d0.png'><b>$item</b>! Hiding in a tree branch!</center>", FALSE));
			}
			elseif($random >= 41 && $random <= 60){
				$item = "Leathery Wing";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/47dcbf781182b4850cc2d72dd77d41a4.png'>"));  
				$document->add(new Comment("Your pet managed to to find a <img src='http://atrocity.mysidiahost.com/picuploads/png/34c1ab0491b664ff04ccd7f168701fd1.png'><b>$item</b> in a pile of leaves!</center>", FALSE));
            }

			elseif($random >= 61 && $random <= 70){
				$item = "Unripe Pumpkin";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));  
				$document->add(new Comment("Your pet found an uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/19667ac5d523a3f3d544e5fedb35fa1f.png'> <b>$item</b> in a gopher nest!!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 75){
				$item = "Magic pumpkin";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));  
				$document->add(new Comment("Oh wow Human thing!! your pet found a rare <img src='http://atrocity.mysidiahost.com/picuploads/png/5af943d53031152e301178337b62d1fe.png'> <b>$item</b> in a badgers hideout!</center>", FALSE));
			}
			elseif($random >= 76 && $random <= 80){
				$item = "Bug Bits";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));  
				$document->add(new Comment("Your pet located a <img src='http://atrocity.mysidiahost.com/picuploads/png/81daad0c188ed6befdb78948f0dbe651.png'> <b>$item</b> down one of the creepier paths!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 90){
				$item = "Halloween Pumpkin";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));  
				$document->add(new Comment("Your pet found a <img src='http://atrocity.mysidiahost.com/picuploads/png/1aa4735a74eab8da5e479ad8b1584737.png'><b>$item</b>!</center>", FALSE));
            }
            			elseif($random >= 104 && $random <= 110){
				$item = "White Wing";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/47dcbf781182b4850cc2d72dd77d41a4.png'>"));  
				$document->add(new Comment("Your pet picked up a <img src='http://atrocity.mysidiahost.com/picuploads/png/31fc62ef9563e9ca3d255b3b00c157a6.png'><b>$item</b>! from a tree trunk</center>", FALSE));
			}
			elseif($random >= 111 && $random <= 115){
				$item = "White Pumpkin";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));  
				$document->add(new Comment("Your pet has found a <img src='http://atrocity.mysidiahost.com/picuploads/png/c2b219d8cf54bcb841907393d74f3a79.png'> <b>$item</b>!</center>", FALSE));
			}
						elseif($random >= 116 && $random <= 117){
				$item = "Bashful Ghost";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));  
				$document->add(new Comment("Your pet has found a <img src='http://atrocity.mysidiahost.com/picuploads/png/0efb60d2efb24d49d18b169f51863c8f.png'> <b>$item</b>!</center>", FALSE));
			}
								elseif($random >= 118 && $random <= 122){
				$item = "Gross Wing";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/49d3f278cb13d3ea4f0153e5903e9d52.png'>"));  
				$document->add(new Comment("Your pet has found a <img src='http://atrocity.mysidiahost.com/picuploads/png/5eac3618829ef7503126bd36b25735aa.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 91 && $random <= 99){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/e0e7af76327949082a47922fe0d6c1e4.png'>"));
				$document->add(new Comment("I've never seen such a scared pet... I didnt torment them <i>Too bad</i> I promise...</center>", FALSE));
			}
			elseif($random == 100&& $random <=103){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/e0e7af76327949082a47922fe0d6c1e4.png'>"));
				$document->add(new Comment("Maybe you should give your pet more attention...they didnt want to even go in...</center>", FALSE));
			}
             else { 
    $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/e0e7af76327949082a47922fe0d6c1e4.png'></center>", FALSE)); 
    $document->add(new Comment("<center>You are out of candy...come back when you have more!!</center>", FALSE)); 
}    
    } 
   }  
?> 