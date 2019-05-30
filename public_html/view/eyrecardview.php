<?php

class eyrecardview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("<center>Bribing Eyre<br>");
 
        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/Thelonelygraven/'>Go back</a><br><br></center>", FALSE));
		$item = "Hanafuda card";

		$item = "Hanafuda card";
		$qty = 1;
		$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn();
		if($hasitem){
			$document->add(new Comment("<center>You have a {$item}!</center>"));
			$item = new PrivateItem($item, $mysidia->user->username); 
			$item->remove($qty, $mysidia->user->username);    
			       	        	$document->add(new Comment("<center><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i1a2625f3e803a51d/version/1424206526/image.png'><br><br>"));
			       	        	
			       	                	$document->add(new Comment("Ah! Human thing! You have a card for me! please go right into the shrine<br><br></center>", FALSE));
        	        	$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/Bakenekoshrinecard'>Go To the shrine</a><br><br>"));	
        	        
			//They have the item, so they can explore now
			
		}
		else {
		    			$document->add(new Comment("<center><p><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ie25e21c686b41862/version/1486187254/image.png'><br></p>"));
			$document->add(new Comment("<p>You do not have a {$item} you cant come this way! <a href='http://atrocity.mysidiahost.com/pages/view/Thelonelygraven/'>Go away!</a><br></p></center>"));
			return; //return prevents the rest of the script from happening if they don't have the item
		}     

	}
}

?>
