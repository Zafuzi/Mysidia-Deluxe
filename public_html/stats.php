<?php

use Resource\Native\Str;
use Resource\Collection\LinkedList;

class StatsController extends AppController{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("owned_adoptables", array("aid"), "owner != 'SYSTEM' ORDER BY totalclicks DESC LIMIT 10");
		$top10 = new LinkedList;
		while($aid = $stmt->fetchColumn()){
		    $top10->add(new OwnedAdoptable($aid));    
		}
        $this->setField("top10", $top10);
		
		$stmt = $mysidia->db->select("owned_adoptables", array("aid"), "owner != 'SYSTEM' ORDER BY RAND() DESC LIMIT 5");
		$rand5 = new LinkedList;
		while($aid = $stmt->fetchColumn()){
		    $rand5->add(new OwnedAdoptable($aid));    
		}
		$this->setField("rand5", $rand5);
	}              
}
?>