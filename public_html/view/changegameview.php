<?php
class changegameView extends View{	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;	
		$document->setTitle('Change');
		$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/pages/view/arcade' />~Go back to the Arcade</a></center>"));
                $document->add(new Comment ('<iframe id="game" style="width: 100%; min-height: 500px;" src="../../games/change/app/assets/javascripts/application.js" frameborder="0" scrolling="yes"></iframe>'));
	} 
} 
?>