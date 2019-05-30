<?php

class PetController extends AppController{
	const PARAM = 'id'; 

	public $id;
	public $adopt;

    public function __construct(){
        parent::__construct();	
        $mysidia = Registry::get('mysidia');
        $this->id = (int) trim($mysidia->input->get('id'));
        if ($this->id == null OR $this->id == 0) {
        	throw new Exception('Pet not found.');
        }

        $this->adopt = new OwnedAdoptable($this->id);
        $this->setField('adopt',$this->adopt);
	}
	
	public function profile(){}

	public function release(){
		$mysidia = Registry::get('mysidia');
		$this->setField('aid', $mysidia->input->get('id'));
		 
	}
}