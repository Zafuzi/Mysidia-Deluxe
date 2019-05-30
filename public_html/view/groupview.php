<?php

use Resource\Native\String;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class GroupView extends View{

	function index(){
		$document = $this->document;
	    $document->setTitle('<center>Your Adoptables</center>');
	    $groups = $this->getField('groups');
	}

	function view(){
		$document = $this->document;
	    $document->setTitle('<center>Your Adoptables</center>');
	    $groups = $this->getField('groups');
	}

	function create() {
		$mysidia = Registry::get("mysidia");
		if ($mysidia->input->get("name")) {

		}


		$document = $this->document;
	    $document->setTitle('<center>Create Group</center>');
		$document->add(new Comment('Create a new group to sort your pets.<br>
			<form method="post">
			<label for="name">Group Name:</label> <input type="text" id="name" name="name"><br>
			<button id="submit" value="submit" type="submit">Create</button>
			</form>'));
	}

	function store() {

	}
}