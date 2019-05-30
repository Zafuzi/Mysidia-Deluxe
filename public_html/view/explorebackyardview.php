<?php

class explorebackyardview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Your pet is exploring the backyard<br>"); 
        		         
		$item = "Backyard permit";
		$qty = 1;
		$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn();
		if($hasitem){
			$document->add(new Comment("<center>You have a {$item}!</center>"));
			$item = new PrivateItem($item, $mysidia->user->username); 
			
			//They have the item, so they can explore now
        	 $document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes_backyard} of 5 explores.</center>", FALSE));
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/myhouse/'>Go back to the house</a><br><br></center>", FALSE));
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/explorebackyard/'>Explore again?</a><br><br></center>", FALSE));

			
        			     $today = date('d'); // Day of the month
            
        // Reset explore counter if the last recorded exploration was on a different day than today:
        $reset = $mysidia->user->lastday != $today; 

        // Allow user to explore if they are under the limit or if reset condition is true. 
        if ($mysidia->user->exploretimes_backyard < 5) {  
            $updatedexploretimes_backyard = $mysidia->user->exploretimes_backyard + 1; 
                
            $mysidia->db->update("users", array("exploretimes_backyard" => ($updatedexploretimes_backyard)), "username = '{$mysidia->user->username}'"); 
				
			$random = rand(1,88);
            if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'>"));
				$document->add(new Comment("your pet didnt find anything...</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 24){
				$amount = rand(50,5000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));
				$document->add(new Comment("your pet found- $amount Beads..</center>", FALSE)); 
			}
			elseif($random >= 25 && $random <= 28){
			$item = "Pine branch";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet pulled off a<img src='http://atrocity.mysidiahost.com/picuploads/png/ca20cd0d13c26305b54e3d7ca9a309bc.png'> <b>$item</b></center>", FALSE));

			}

			elseif($random >= 29 && $random <= 34){
				$item = "Blue mushroom";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet picked a<img src='http://atrocity.mysidiahost.com/picuploads/png/f902e3cc6832db7099797f253be5bfd6.png'> <b>$item</b></center>", FALSE));
			}

			elseif($random >= 35 && $random <= 40){
			$item = "Dried grass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet picked some<img src='http://atrocity.mysidiahost.com/picuploads/png/e83f4dbe87ada7676fa289ce8e5dfdd2.png'> <b>$item</b></center>", FALSE));

			}

			elseif($random >= 41 && $random <= 42){
				$item = "Special blue stone";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet found a<img src='http://atrocity.mysidiahost.com/picuploads/png/54c40fc33a5e15df4573ca90ff53ef4b.png'> <b>$item</b></center>", FALSE));

			}
			elseif($random >= 43 && $random <= 46){
	$item = "Fresh grass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet pulled up some<img src='http://atrocity.mysidiahost.com/picuploads/png/54d73e9218936b21cbfa339d8bff8fd8.png'> <b>$item</b></center>", FALSE));

			}
elseif($random >= 87 && $random <= 88){
$item = "Very dried grass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet Pulled up some <img src='http://atrocity.mysidiahost.com/picuploads/png/39d4ca30a50cf6a7a152a2ffdc3fed88.png'> <b>$item</b></center>", FALSE));
			}
            			elseif($random >= 51 && $random <= 53){
$item = "Yellow ginko leaf";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet found a<img src='http://atrocity.mysidiahost.com/picuploads/png/504f3b2b0975e9cfcae2c3ad3dc3ca4a.png'> <b>$item</b></center>", FALSE));
			}

			elseif($random >= 54 && $random <= 55){
$item = "Green ginko leaf";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet found a<img src='http://atrocity.mysidiahost.com/picuploads/png/e8f06470a2e4ebddc44d0840e81c12a0.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random >= 56 && $random <= 57){
$item = "Raspberry leaves";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet found a<img src='http://atrocity.mysidiahost.com/picuploads/png/e27c4f4f4ef76dedf6a5da6a6da56034.png'> <b>$item</b></center>", FALSE));


			}
			elseif($random >= 57 && $random <= 59){
	$item = "Rib bones";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet found a<img src='http://atrocity.mysidiahost.com/picuploads/png/3e49a3af1bc619d08c0b8cd071d0021e.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random >= 60 && $random <= 69){
				$item = "Turkeytail fungus";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet found a<img src='http://atrocity.mysidiahost.com/picuploads/png/06fc4e2aa4076bf345f55573a001f722.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random == 70&& $random <=80){
				$item = "Fresh grass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet pulled up some<img src='http://atrocity.mysidiahost.com/picuploads/png/54d73e9218936b21cbfa339d8bff8fd8.png'> <b>$item</b></center>", FALSE));

			}
	elseif($random == 81&& $random <=82){
				$item = "Spearhead";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet Found a<img src='http://atrocity.mysidiahost.com/picuploads/png/333b3e5e5c15f22d279bcaff6cc4a101.png'> <b>$item</b></center>", FALSE));
}

	elseif($random == 83&& $random <=84){
				$item = "Red Mushroom";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet Picked a<img src='http://atrocity.mysidiahost.com/picuploads/png/ea89d39a3950786560d2454825845474.png'> <b>$item</b></center>", FALSE));
}

	elseif($random == 85&& $random <=86){
				$item = "Mammoth tooth";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='https://media.discordapp.net/attachments/502505548818939941/567456329694969897/exploregif1.gif'>"));  
				$document->add(new Comment("Your pet Picked a<img src='http://atrocity.mysidiahost.com/picuploads/png/aed502c21f636652a0cbb6c26fc226f9.png'> <b>$item</b></center>", FALSE));
}


		else{
			$document->add(new Comment("<br><p><center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>Sorry, you do not have a {$item} you cant search here!!<br></p></center>"));
			return; //return prevents the rest of the script from happening if they don't have the item
		}    
		}
       else{
           $document->add(new Comment("<br><p><center><img src='http://atrocity.mysidiahost.com/picuploads/png/8349a0434c0e2897e50b2a333e07ad07.png'><br>Sorry, your pet is done exploring for today!!<br></p></center>")); return;
       }
		}
    
	}
	}


?>