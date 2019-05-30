 <?php

class EncyclopediaController extends AppController{

    public function __construct(){
        parent::__construct("member");    
    }
    
    public function index(){
        $mysidia = Registry::get("mysidia");
    }
    
    public function hounda(){
                $mysidia = Registry::get("mysidia");   
        }
		
	public function catari(){
                $mysidia = Registry::get("mysidia");   
        }
		
	public function feesh(){
                $mysidia = Registry::get("mysidia");   
        }
}
?> 