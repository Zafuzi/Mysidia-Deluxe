 <?php 

class santaclawsView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>Play Santa Claws!</center>");           

        if($mysidia->user->money >= 500){ 
            $mysidia->user->changecash(-500);
        }
        else{
            $document->add(new Comment("<b><center>You don't have enough beads! You need at least 500, so maybe come back later?</b><p>
            <a href='http://atrocity.mysidiahost.com/pages/view/jinglejollygathering'>Return to the Event page</a></p></center>"));
            return;
        }
  
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/santaclaws'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/jinglejollygathering'> Go back to the event page</a></center>", FALSE));   
                           
			$random = rand(1,80);
            if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));
				$document->add(new Comment("The claw machine dropped the item! you didnt win!</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 24){
				$amount = rand(5,20);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));
				$document->add(new Comment("Your pet managed to find- $amount Beads inside one of the Capsules!</center>", FALSE)); 
			}
			elseif($random >= 25 && $random <= 28){
				$item = "Pudding Bauble";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw gave you a <img src='http://atrocity.mysidiahost.com/picuploads/png/d3d0739d7e3a2b01d724e10915bac40a.png'><b>$item</b>! </center>", FALSE));
			}
			elseif($random >= 29 && $random <= 34){
				$item = "Blue Ornament";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw grabbed a<img src='http://atrocity.mysidiahost.com/picuploads/png/61836c85204d7d234ce9d7cc2402cc2b.png'><b>$item</b> </center>", FALSE));
            }

			elseif($random >= 35 && $random <= 40){
				$item = "Green Ornament";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The Claw Picked up a<img src='http://atrocity.mysidiahost.com/picuploads/png/224356b166b0f6d4c8fdda77f1c2d364.png'> <b>$item</b> </center>", FALSE));
			}
			elseif($random >= 41 && $random <= 42){
				$item = "Red Ornament";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw picked up a <img src='http://atrocity.mysidiahost.com/picuploads/png/28a989f5a985451df8a3bab1c7a275cc.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random >= 43 && $random <= 46){
				$item = "Candy Cane Cookie";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw grabbed a <img src='http://atrocity.mysidiahost.com/picuploads/png/ff6ca2e79baa5c9c1f1e8713bbeb1c8b.png'> <b>$item</b> </center>", FALSE));
			}
			elseif($random >= 47 && $random <= 50){
				$item = "Gingerbread cookie";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw grabbed a <img src='http://atrocity.mysidiahost.com/picuploads/png/9b1f3c5850a660fcdee4e517962e24e7.png'><b>$item</b>!</center>", FALSE));
            }
            			elseif($random >= 51 && $random <= 53){
				$item = "Reindeer plushie";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw picked up a <img src='http://atrocity.mysidiahost.com/picuploads/png/1395157a33babc934d36ded5a618fcc2.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 54 && $random <= 55){
				$item = "Red Nosed Reindeer plushie";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw grabbed a <img src='http://atrocity.mysidiahost.com/picuploads/png/e9681bc9a6b73ac12a3a580179391df9.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 56 && $random <= 57){
				$item = "Snowflake cookie";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The claw picked up a <img src='http://atrocity.mysidiahost.com/picuploads/png/9dd4149b1384a29a2d5f1c697e381947.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 57 && $random <= 59){
				$item = "Blue Ornament";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
				$document->add(new Comment("The Claw grabbed a <img src='http://atrocity.mysidiahost.com/picuploads/png/61836c85204d7d234ce9d7cc2402cc2b.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 60 && $random <= 69){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));
				$document->add(new Comment("The Claw Machine ALMOST gave you your item! too bad!</center>", FALSE));
			}
			elseif($random == 70&& $random <=80){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));
				$document->add(new Comment("The claw machine managed to grab a capsule- but nothing was inside... Try again!</center>", FALSE));
			}
            else{ 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'></center>", FALSE)); 
                $document->add(new Comment("<center>The Claw Machine ALMOST gave you your item! Too bad!</center>", FALSE)); 
            }    
    } 
   }  
?> 