<?php
class minesweeperView extends View{	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;	
		$document->setTitle('Marias candy search');
		$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/arcade' />~Go back to the Arcade</a></center>"));
                $document->add(new Comment ('<iframe id="game" style="width: 1000px; min-height: 1000px;" src="/games/minesweeper_js-master/index.html" frameborder="0" scrolling="yes"></iframe>'));
	} 
} 
?>