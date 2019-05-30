<?php

class ImageController extends AppController{
	const first = 'firstvar';
	const second = 'secondvar';
	const third = 'thirdvar';

	public function __construct(){
		parent::__construct();	
	}
	
	public function index($id){
		$image = Registry::get('cImage');
		$image->random();
		$image->display();
	}

	public function display(){
		$mysidia = Registry::get("mysidia");
		$species = $mysidia->input->get("firstvar");
		$id = null;

		$image = Registry::get('cImage');
		$image->setOwner(null);
		if ($species != null){
			$image->setSpecies($species);
		}
		if (trim($id) == null) {
			$image->random();
		}
		$image->display($id);
	}

}
?>