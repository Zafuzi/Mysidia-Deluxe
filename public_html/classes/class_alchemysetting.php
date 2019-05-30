<?php

final class AlchemySetting extends Setting{
  
    public $system;
	public $chance;
	public $cost;
    public $license;	
    public $recipe;
    public $usergroup;
  
    public function __construct(Database $db){
	    parent::__construct($db);	
		if($this->usergroup != "all") $this->usergroup = explode(",", $this->usergroup);	
    }

    public function fetch($db){
        $stmt = $db->select("alchemy_settings", array());
	    while($row = $stmt->fetchObject()){
	        $property = $row->name;
	        $this->$property = $row->value;
	    }	 
    }
  
    public function set($property, $value){
        $this->$property = $value;
    }
}
?>