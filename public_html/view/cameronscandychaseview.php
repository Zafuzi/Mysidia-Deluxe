<?php
class cameronscandychaseView extends View{	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;	
		$document->setTitle('Camerons Candy Chase');
		$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/arcade' />~Go back to the Arcade</a></center>"));
                $document->add(new Comment ('<iframe id="game" style="width: 100%; min-height: 500px;" src="../../games/cameronscandychase/index.html" frameborder="0" scrolling="yes"></iframe>'));
	} 
} 
?>