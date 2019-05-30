 <?php 

class cupgameeView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>Play The cup game!</center>");           
            $document->add(new Comment("<a href='http://atrocity.mysidiahost.com/pages/view/thebeach'>Return to the beach</a></p></center>"));
        if($mysidia->user->money >= 5000){ 
            $mysidia->user->changecash(-5000);
        }
        else{
$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png>"));
            $document->add(new Comment("<b><center>You don't have enough beads! You need at least 5000, so maybe come back later?</b><p>
            <a href='http://atrocity.mysidiahost.com/pages/view/thebeach'>Return to the beach</a></p></center>"));
            return;
        }
  
         
                           
			$random = rand(1,80);
            if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png'>"));
				$document->add(new Comment("I dont know what you're doing.... theres nothing in my hands...!</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 24){
				$amount = rand(5000,20000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/7da97033299e973a30e64e73643671a1.png'>"));
				$document->add(new Comment("Darn...you found it....I guess I'll have to bribe you to be quiet...will- $amount Beads work?</center>", FALSE)); 
			}
			elseif($random >= 25 && $random <= 28){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png'>"));
				$document->add(new Comment("I dont know what you're doing.... theres nothing in my hands...!</center>", FALSE));
			}

			elseif($random >= 29 && $random <= 34){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png'>"));
				$document->add(new Comment("I dont know what you're doing.... theres nothing in my hands...!</center>", FALSE));
			}


			elseif($random >= 35 && $random <= 40){
			$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png'>"));
				$document->add(new Comment("I dont know what you're doing.... theres nothing in my hands...!</center>", FALSE));
			}

			elseif($random >= 41 && $random <= 42){
				$item = "Rainbow Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/7da97033299e973a30e64e73643671a1.png'>"));  
				$document->add(new Comment("Fine...you caught me....Will this ><img src='http://atrocity.mysidiahost.com/picuploads/gif/7dedc2656c5e44cc8d3fad444422bb32.gif'> <b>$item</b>shut you up?</center>", FALSE));
			}
			elseif($random >= 43 && $random <= 44){
	$item = "Rainbow Hermit crab shell ";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/7da97033299e973a30e64e73643671a1.png'>"));  
				$document->add(new Comment("Augh...How did I let you see it? Okay take my ><img src='http://atrocity.mysidiahost.com/picuploads/gif/dfd560995e59e7b036935a4b7a8cc1a1.gif'> <b>$item</b></center>", FALSE));
			}

			elseif($random >= 45 && $random <= 46){
	$item = "Bag of Rainbow shells ";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/7da97033299e973a30e64e73643671a1.png'>"));  
				$document->add(new Comment("Augh...How did I let you see it? Okay take my ><img src='http://atrocity.mysidiahost.com/picuploads/gif/23b806942fe64049c9dbc48621a310b7.gif'> <b>$item</b></center>", FALSE));
			}
            			elseif($random >= 47 && $random <= 48){
		$item = "Rainbow clam shell ";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/5f294d9a15c12ded6d37cb621ece9b79.png'>"));  
	$document->add(new Comment("You must have cheated yourself! But I got caught...so take my- ><img src='http://atrocity.mysidiahost.com/picuploads/gif/569cedc9514fa02ca33ca0c414d4042d.gif'> <b>$item</b></center>", FALSE));
			}

			
			elseif($random >= 49 && $random <= 69){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png'>"));
				$document->add(new Comment("What the heck?? I dont have anything!</center>", FALSE));
			}
			elseif($random == 70&& $random <=80){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png'>"));
				$document->add(new Comment("The point of the game is to find the ball under the cup...cant you understand simple directions?</center>", FALSE));
			}
            else{ 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/3faa2394fb0d74345e51134f05e53a05.png'></center>", FALSE)); 
                $document->add(new Comment("<center>Wow you must not know what a cup looks like...why are you looking here??</center>", FALSE)); 
            }    
    } 
   }  
?> 