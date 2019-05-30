 <?php 

class bronzescratchoffView extends View{ 
     
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
            $document->setTitle("<center>Bronze scratchoff</center>");           
$item = "Bronze scratchoff"; 
$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn(); 
if($hasitem > 0){ 
    $document->add(new Comment("<b><center>{$item}<br> <img src='http://atrocity.mysidiahost.com/picuploads/png/75055873d5a54477888f2a46632069a0.png'><br>Used 1<br> Own {$itemquantity} !</b></center>"));
    $qty = 1; 
    $item = new PrivateItem($item, $mysidia->user->username); 
    $item->remove($qty, $mysidia->user->username);
}
else{
    $document->add(new Comment("<b><center>You don't have a <img src='http://atrocity.mysidiahost.com/picuploads/png/75055873d5a54477888f2a46632069a0.png'> {$item}!</b><p>
    <a href='http://atrocity.mysidiahost.com/raffle'>Return to the raffle?</a></p></center>"));
    return;
}
  
            $document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/bronzescratchoff'>Play again?</a> Or <a href='http://atrocity.mysidiahost.com/raffle'> Go back to the Raffle/a></center>", FALSE));   
                           
			$random = rand(1,100);
            			if($random > 1 && $random < 10){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("Sorry ...You didnt win anything...</center>", FALSE));
			}
			elseif($random >= 11 && $random <= 15){
				$amount = rand(5000,7000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 15 && $random <= 18){
				$amount = rand(5000,7000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 19 && $random <= 24){
				$amount = rand(8000,12000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
            }

			elseif($random >= 25 && $random <= 27){
				$amount = rand(15000,20000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 28 && $random <= 30){
				$amount = rand(50000,60000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
			}
			elseif($random >= 31 && $random <= 32){
				$amount = rand(100000,200000);
				$mysidia->user->changecash($amount); 
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("You won $amount Beads!</center>", FALSE)); 
				
            }			if($random > 32 && $random < 100){
				$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/1bc7a3937099d9db5af01c3171143bbd.png'>"));
				$document->add(new Comment("Sorry ...You didnt win anything...</center>", FALSE));
			}
              else { 

} 
    } 
}
?> 