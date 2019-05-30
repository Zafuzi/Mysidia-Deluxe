<?php

class ExplorelaricsgameView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        $document->setTitle("<center>Larics Box Game</center>");
        $document->add(new Comment("<center>You have taken {$mysidia->user->exploretimes} of 1 plays.</center>", FALSE));
        $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/bakenekohalloween'> Go back to the event plaza</a>.</center>", FALSE));  
	    $today = date('d'); // Day of the month
            
        // Reset explore counter if the last recorded exploration was on a different day than today:
        $reset = $mysidia->user->lastday != $today; 

        // Allow user to explore if they are under the limit or if reset condition is true. 
        if ($mysidia->user->exploretimes <= 1 || $reset) {  
            // Update the last day that they explored to today
            $mysidia->db->update("users", array("lastday" => $today), "username = '{$mysidia->user->username}'");

            // If $reset condition was true, reset the count to 1, otherwise increment the existing count. 
            $updatedExploreTimes = $reset ? 1 : $mysidia->user->exploretimes + 1; 
                
            $mysidia->db->update("users", array("exploretimes" => $updatedExploreTimes), "username = '{$mysidia->user->username}'"); 
			$random = rand(1,115);
			
			if($random > 1 && $random < 20){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));
				$document->add(new Comment("Your pet got a Pie to the face! Tricked!</center>", FALSE));
			}
			elseif($random >= 21 && $random <= 30){
				$amount = rand(5,20);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));
				$document->add(new Comment("You got $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 40){
				$item = "Bubbly Sludge Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/d92c11ee45377fe6fd6b55dde9a636d0.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 41 && $random <= 60){
				$item = "Cute Sludge Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/1bb61fed8124b44a0b4effb1d5965da3.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 101 && $random <= 110){
				$item = "Deadly Brew Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found <img src='http://atrocity.mysidiahost.com/picuploads/png/5fdd829718ef37f441ca12cc3aaf6595.png'><b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 61 && $random <= 70){
				$item = "Glowy Sludge Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found an uncommon <img src='http://atrocity.mysidiahost.com/picuploads/png/3064efb0ea545cb58aa946dfa20adb35.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 71 && $random <= 75){
				$item = "Mystical Brew Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a rare <img src='http://atrocity.mysidiahost.com/picuploads/png/9592844cc824a52fb57f8ea8e73e7561.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 76 && $random <= 80){
				$item = "Omninous Sludge Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/dafe1b4784030610cea596a519fa1459.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 81 && $random <= 90){
				$item = "Unidentified Brew Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/06f5fed965540b20afb5123b17d738cd.png'><b>$item</b>!</center>", FALSE));
            }
			elseif($random >= 111 && $random <= 115){
				$item = "Witches Brew Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/e6493d2ef1884d2afd127c225b88c5c9.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 116 && $random <= 120){
				$item = "Broken Jar Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/2186a73268365cec6c99e9f444cbbdc4.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 121 && $random <= 126){
				$item = "Faded Elixir Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/d53aa78192b1739fcc5662b53d66c11d.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 127 && $random <= 131){
				$item = "Flourescent Vial Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/898b94a224cc096c732b0a025968f910.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 132 && $random <= 137){
				$item = "Intriguing Jar Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/d7b4242613739a43640636ccefe19d4b.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 138 && $random <= 142){
				$item = "Mercurial Vial Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/8df48bb90e8e1745cf241a1c8c0c1690.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 138 && $random <= 142){
				$item = "Sealed Vial Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/1724c97735f493a1a94ecd2583e2d1f0.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 143 && $random <= 147){
				$item = "Smelly Elixir Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/89a6258b345ad06063aee22dd7e29e63.png'> <b>$item</b>!</center>", FALSE));
			}

            elseif($random >= 148 && $random <= 152){
				$item = "Specimen Vial Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/313076eea01b41d4d2170758dbac92c5.png'> <b>$item</b>!</center>", FALSE));
			}

            elseif($random >= 153 && $random <= 157){
				$item = "Strange Elixir Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/4f5e20b1a05674f0fe988b327ba39c85.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 158 && $random <= 162){
				$item = "Suspicious Jar Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/1d97710547dc67eff64bfba765e06feb.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 163 && $random <= 167){
				$item = "Toxic Elixir Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/6040325d07acdc0d8f7b7e0730ed7bb2.png'> <b>$item</b>!</center>", FALSE));
			}
            elseif($random >= 168 && $random <= 173){
				$item = "Unsettling Jar Recipe";
				$qty = 1;
				$newitem = new StockItem($item);
				$newitem->append($qty, $mysidia->user->username);
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));  
				$document->add(new Comment("Oh look! You found a <img src='http://atrocity.mysidiahost.com/picuploads/png/bf445e100736798f09c1cab80c193181.png'> <b>$item</b>!</center>", FALSE));
			}
			elseif($random >= 91 && $random <= 99){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));
				$document->add(new Comment("Your pet Found nothing! Tricked!</center>", FALSE));
			}
			elseif($random == 100){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1fee2552bd9cebc8fcecec60fea07eaf.png'>"));
				$document->add(new Comment("You didnt find anything, sorry, try again.</center>", FALSE));
			}
			
        }
		else{
		  $document->add(new Comment("<center><img src='http://i65.tinypic.com/33o5oud.jpg'>"));
		  $document->add(new Comment("<center>It seems you have ran out of chances, why don't you try again tomorrow?</center>", FALSE));
		}   
	}
}
?>