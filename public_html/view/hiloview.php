<?php
class HiLoView extends View{	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;	
		$document->setTitle('Higher or Lower');
		$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/f24809e28df502916dc416e19e5059e2.png' /></center>"));
		$document->add(new Comment('<p><b>Maria says:</b> Hehe can you Guess if the second number will be higher or lower? Its easy I promise! The highest possible number is 16.</p>
			<iframe id="game" style="width: 100%; min-height: 500px;" src="../../games/hilo/hilo.php?username='.$mysidia->user->username.'" frameborder="0" scrolling="yes"></iframe>'));
	} 
} 
?>