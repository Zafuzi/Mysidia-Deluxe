<?php

class CalendarController extends AppController{

    public function __construct(){
        parent::__construct("member");	
    }
	
	public function index(){
        $mysidia = Registry::get("mysidia");
	}

}