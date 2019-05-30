 <?php 

class cupgameView extends View{ 
     
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
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/96df20a84bf24968ba40768ad0e732f6.png'>"));
				$document->add(new Comment("Nope...you chose wrong!</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 24){
				$amount = rand(50,500);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));
				$document->add(new Comment("Oh joy...you found the ball...Heres- $amount Beads..</center>", FALSE)); 
			}
			elseif($random >= 25 && $random <= 28){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/96df20a84bf24968ba40768ad0e732f6.png'>"));
				$document->add(new Comment("I dont think you know how this game works</center>", FALSE));
			}

			elseif($random >= 29 && $random <= 34){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/96df20a84bf24968ba40768ad0e732f6.png'>"));
				$document->add(new Comment("You sure know how to pickem!!</center>", FALSE));
			}


			elseif($random >= 35 && $random <= 40){
			$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/96df20a84bf24968ba40768ad0e732f6.png'>"));
				$document->add(new Comment("BZZZT! wrong!...!</center>", FALSE));
			}

			elseif($random >= 41 && $random <= 42){
				$item = "Common seashell";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));  
				$document->add(new Comment("hooray...you won a <img src='http://atrocity.mysidiahost.com/picuploads/png/56e165fca5e25a33b5ebe5445122f382.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random >= 43 && $random <= 46){
	$item = "Broken bottle ";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));  
				$document->add(new Comment("hooray...you won a <img src='http://atrocity.mysidiahost.com/picuploads/png/5303765aecea6795dad019b40df8b457.png'> <b>$item</b></center>", FALSE));
			}

			elseif($random >= 47 && $random <= 50){
	$item = "Pumice stone";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));  
	$document->add(new Comment("hooray...you won a <img src='http://atrocity.mysidiahost.com/picuploads/png/ae798d7563c78bec1d9695efdb5a5902.png'> <b>$item</b></center>", FALSE));
			}
            			elseif($random >= 51 && $random <= 53){
		$item = "Blue Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));  
			$document->add(new Comment("hooray...you won some <img src='http://atrocity.mysidiahost.com/picuploads/png/7b254df39cd51bbbce8ca519f27e7b4e.png'> <b>$item</b></center>", FALSE));
			}

			elseif($random >= 54 && $random <= 55){
	$item = "Green Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));  
		$document->add(new Comment("hooray...you won some <img src='http://atrocity.mysidiahost.com/picuploads/png/4cc96ae0910bc368682aebf568da59cb.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random >= 56 && $random <= 57){
	$item = "Orange Seaglass";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));  
	$document->add(new Comment("hooray...you won some <img src='http://atrocity.mysidiahost.com/picuploads/png/e7a1eb65eb12c2f8c2ec5c9a256095a4.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random >= 57 && $random <= 59){
	$item = "Purple Seaglass ";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/d585fc70bc9760d8fd31bb0c411422bc.png'>"));  
			$document->add(new Comment("hooray...you won some <img src='http://atrocity.mysidiahost.com/picuploads/png/1f6dbaac1a054649e1d3a532d93a1553.png'> <b>$item</b></center>", FALSE));
			}
			elseif($random >= 60 && $random <= 69){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/96df20a84bf24968ba40768ad0e732f6.png'>"));
				$document->add(new Comment("How does one person FAIL so much?!</center>", FALSE));
			}
			elseif($random == 70&& $random <=80){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/96df20a84bf24968ba40768ad0e732f6.png'>"));
				$document->add(new Comment("The point of the game is to find the ball under the cup...cant you understand simple directions?</center>", FALSE));
			}
            else{ 
                $document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/96df20a84bf24968ba40768ad0e732f6.png'></center>", FALSE)); 
                $document->add(new Comment("<center>Wow, you really suck at this..dont you??</center>", FALSE)); 
            }    
    } 
   }  
?> 