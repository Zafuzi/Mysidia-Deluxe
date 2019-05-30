 <?php 

class turnintrashView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>Turn in Trash</center>");           
$item = "trash"; 
$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn(); 
if($hasitem > 0){ 
    $document->add(new Comment("<b><center>Used 1 <img src='http://atrocity.mysidiahost.com/picuploads/png/d0b8f4722752010c5f76d90a9e091a29.png'> {$item}!</b> </center>"));
    $qty = 1; 
    $item = new PrivateItem($item, $mysidia->user->username); 
    $item->remove($qty, $mysidia->user->username);
}

else{
    $document->add(new Comment("<b><center>You don't have a <img src='http://atrocity.mysidiahost.com/picuploads/png/d0b8f4722752010c5f76d90a9e091a29.png'> {$item}!</b><p>
    <a href='http://atrocity.mysidiahost.com/pages/view/trashomatic3000'>Return to the Trash-O-Matic?</a></p></center>"));
    return;
}
  
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/turnintrash'>Again?</a> Or <a href='http://atrocity.mysidiahost.com/pages/view/trashomatic3000'> Go back to the Trash O Matic?</a></center>", FALSE));   
                           
			$random = rand(1,100);
            			if($random > 1 && $random < 10){
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("Sorry ...You didnt get anything...</center>", FALSE));
			}
			elseif($random >= 11 && $random <= 20){
				$amount = rand(100,300);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("There was $amount Beads in that trash!!</center>", FALSE)); 
			}
			elseif($random >= 21 && $random <= 24){
				$amount = rand(40,100);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("You found $amount Beads in the trash!</center>", FALSE)); 
			}
			elseif($random >= 25 && $random <= 35){
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("Sorry ...You didnt get anything...</center>", FALSE)); 
            }

			elseif($random >= 36 && $random <= 42){
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("Sorry ...You didnt get anything...</center>", FALSE));
			}
			elseif($random >= 43 && $random <= 44){
			    				$item = "Keyring";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/14923aebb1faed6544d564358687ebf7.png'> $Item in the trash!</center>", FALSE));
			}
			elseif($random >= 45 && $random <= 46){
			   				$item = "Button Battery";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/a680b6bbe87f9b89ce15ec4c06b8c280.png'> $Item in the trash!</center>", FALSE));
				
            }
            			elseif($random >= 47 && $random <= 48){
			   				$item = "Computer Chip";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/b50c28cb2e1b84aaeb9e92dca5699b85.png'> $Item in the trash!</center>", FALSE));
				
            }
            			elseif($random >= 48 && $random <= 49){
			   				$item = "Seagreen Plastic Egg";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/ee3807545d53756d48f7e9c9beb290af.png'> $Item in the trash!</center>", FALSE));
				
            }
            if($random > 50 && $random < 100){
				$document->add(new Comment("<center><img src=''>"));
				$document->add(new Comment("Sorry ...You didnt get anything...</center>", FALSE));
			}
              else { 

} 
    } 
}
?> 