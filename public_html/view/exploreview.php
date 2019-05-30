 <?php
class ExploreView extends View{

    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
        $document->setTitle("Fishing");    
        $document->add(new Comment("Would you like to fish?", FALSE));

    }
    
}
?>