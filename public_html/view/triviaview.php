 <?php
class TriviaView extends View{    
    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;    
        $document->setTitle('Trivia Title');
        $document->add(new Comment('<p>Try to guess the right answer!</p>
            <iframe id="game" style="width: 100%; min-height: 500px;" src="../../games/trivia/trivia.php?username='.$mysidia->user->username.'" frameborder="0" scrolling="yes"></iframe>'));
    } 
} 
?> 