 <?php

class ShoutboxView extends View{
    
    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle("Shoutbox");
        $document->add(new Comment("<iframe src='https://titanembeds.com/embed/471651340074876948?scrollbartheme=3d-dark&theme=IceWyvern' height='800' width='900' frameborder='0'></iframe>"));
    }
}
?> 