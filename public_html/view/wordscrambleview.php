<?php
class WordScrambleView extends View{	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;	
		$document->setTitle('Word Scramble');
		$document->add(new Comment("<center><img src='http://atrocity.mysidiahost.com/picuploads/png/ace88e4b69f6747f91f4bcdd3448c589.png' /></center>"));  
		$document->add(new Comment('<p><b> Madeline says:</b> Can you Unscramble the word? Theyre all Atrocity related! Whether NPCs,items, pets or places! Good luck sweetie!!</p>
			<iframe id="game" style="width: 100%; min-height: 500px;" src="../../games/wordscramble/wordscramble.php?username='.$mysidia->user->username.'" frameborder="0" scrolling="yes"></iframe>'));
	} 
} 
?>