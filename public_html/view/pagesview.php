<?php

class PagesView extends View{

    public function view(){
        $mysidia = Registry::get("mysidia");
	    if($this->flags) $this->redirect(3, "../../index");
    }
}