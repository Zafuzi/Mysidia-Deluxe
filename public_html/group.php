<?php

class GroupController extends AppController{

	CONST PARAM = 'groupid';

    public function __construct(){
        parent::__construct();	
    }
	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$groups = new services\Groups\Groups($mysidia);
		$this->setField('groups',$groups);
	}

	function create() {

	}

	function view(){
		$mysidia = Registry::get("mysidia");
		$groupid = $mysidia->input->get('groupid');
		$groups = new services\Groups\Groups($mysidia);
		$this->setField('groups',$groups);

		$querystring = null;
		if ($groupid != null) {
			$groups->valid($groupid)
		}
	    if (count($groups) != 0){
	    	$groups_imploded = implode(',',$groups['id']);
	    	$querystring = 'AND `groupid` NOT IN ($groups_imploded)';
	    }

		$total = $mysidia->db->select("owned_adoptables", array("aid"), "`owner` = '{$mysidia->user->username}' $querystring")->rowCount();

		$pagination = new Pagination($total, 10, "group/view/$groupid");
        $pagination->setPage($mysidia->input->get("page"));	

        $stmt = $mysidia->db
				->join('adoptables','owned_adoptables.type = adoptables.type')
				->join('levels', 'owned_adoptables.type = levels.adoptiename')
				->select(
						"owned_adoptables",
						array(PREFIX.'owned_adoptables`.*, `primaryimage','alternateimage','eggimage','class'),
						"`owner` = '{$mysidia->user->username}' AND ".PREFIX.'owned_adoptables.currentlevel = '.PREFIX."levels.thisislevel $querystring ORDER BY class, totalclicks LIMIT {$pagination->getLimit()},{$pagination->getRowsperPage()}"
				);
		$this->setField("pagination", $pagination);
        $this->setField("stmt", new DatabaseStatement($stmt));
	}
}