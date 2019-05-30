<?php
use Resource\Native\String;

class ExploreicelakeController extends AppController{

    public function __construct(){
        parent::__construct("member");	
    }
	
	public function index(){
		$mysidia = Registry::get("mysidia");
	}

	public function fish()
	{
		$mysidia = Registry::get("mysidia");
	}
}
?>