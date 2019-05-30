 <?php 

class goldscratchoffView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>Gold scratchoff</center>");           
$item = "Gold scratchoff"; 
$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn(); 
if($hasitem > 0){ 
    $document->add(new Comment("<b><center>Used 1 <img src='http://atrocity.mysidiahost.com/picuploads/png/0faa06e3d1ab0c78e161fcc9e76ce8d1.png'> {$item}!</b></center>"));
    $qty = 1; 
    $item = new PrivateItem($item, $mysidia->user->username); 
    $item->remove($qty, $mysidia->user->username);
}
else{
    $document->add(new Comment("<b><center>You don't have a <img src='http://atrocity.mysidiahost.com/picuploads/png/0faa06e3d1ab0c78e161fcc9e76ce8d1.png'> {$item}!</b><p>
    <a href='http://atrocity.mysidiahost.com/raffle'>Return to the raffle?</a></p></center>"));
    return;
}
  
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/goldscratchoff'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/raffle'> Go back to the Raffle</a></center>", FALSE));   
                           
			$random = rand(1,100);
            			if($random > 1 && $random < 10){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/217ae3f04828bcb6f88d2c989e52b91d.png'>"));
				$document->add(new Comment("Sorry ...You didnt win anything...</center>", FALSE));
			}
			elseif($random >= 11 && $random <= 13){
				$amount = rand(50000,10000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/594f5bfe4a00ace3c32ba6a3cfa98fb6.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 14 && $random <= 16){
				$amount = rand(120000,170000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/594f5bfe4a00ace3c32ba6a3cfa98fb6.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 16 && $random <= 18){
				$amount = rand(180000,200000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/594f5bfe4a00ace3c32ba6a3cfa98fb6.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
            }

			elseif($random >= 19 && $random <= 21){
				$amount = rand(250000,300000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/594f5bfe4a00ace3c32ba6a3cfa98fb6.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 22 && $random <= 24){
				$amount = rand(500000,600000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/594f5bfe4a00ace3c32ba6a3cfa98fb6.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 25 && $random <= 26){
				$amount = rand(1,5);
				$mysidia->user->changepremium($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/594f5bfe4a00ace3c32ba6a3cfa98fb6.png'>"));
				$document->add(new Comment("You won $amount Candy!</center>", FALSE)); 
			
			}
            			if($random > 27 && $random < 100){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/594f5bfe4a00ace3c32ba6a3cfa98fb6.png'>"));
				$document->add(new Comment("Sorry ...You didnt win anything...</center>", FALSE));
			}
             else { 

}    
    } 
   }  
?> 