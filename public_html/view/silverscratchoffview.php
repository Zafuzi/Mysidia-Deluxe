 <?php 

class silverscratchoffView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>silver scratchoff</center>");           
$item = "Silver scratchoff"; 
$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn(); 
if($hasitem > 0){ 
    $document->add(new Comment("<b><center>Used 1 <img src='http://atrocity.mysidiahost.com/picuploads/png/d09d6ce8c52c92d54ff390104a78f76b.png'> {$item}!</b></center>"));
    $qty = 1; 
    $item = new PrivateItem($item, $mysidia->user->username); 
    $item->remove($qty, $mysidia->user->username);
}
else{
    $document->add(new Comment("<b><center>You don't have a <img src='http://atrocity.mysidiahost.com/picuploads/png/d09d6ce8c52c92d54ff390104a78f76b.png'> {$item}!</b><p>
    <a href='http://atrocity.mysidiahost.com/raffle'>Return to the raffle?</a></p></center>"));
    return;
}
  
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/silverscratchoff'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/raffle'> Go back to the Raffle/a></center>", FALSE));   
                           
			$random = rand(1,100);
            			if($random > 1 && $random < 10){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("Sorry ...You didnt win anything...</center>", FALSE));
			}
			elseif($random >= 11 && $random <= 13){
				$amount = rand(50000,10000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 14 && $random <= 17){
				$amount = rand(12000,17000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 18 && $random <= 21){
				$amount = rand(18000,20000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
            }

			elseif($random >= 22 && $random <= 25){
				$amount = rand(25000,30000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 26 && $random <= 29){
				$amount = rand(50000,60000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 30 && $random <= 31){
				$amount = rand(200000,300000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			
			}
            			if($random > 32 && $random < 100){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("Sorry ...You didnt win anything...</center>", FALSE));
			}
             else { 

}
    } 
   }  
?> 