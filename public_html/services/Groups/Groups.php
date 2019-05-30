<?php
namespace services\Groups;

use Resource\Native\Object;

class Groups extends Object {
	public $tablename = 'adoptables_groups';

	function __construct($mysidia, $userid=null) {
		$this->db = $mysidia->db;
		$this->mysidia = $mysidia;
		if ($userid == null){
			$userid = $mysidia->user->uid;
		}
		$this->userid = (int) $userid;
		if ($userid <= 0) throw new NoPermissionException('You must be logged in to manage adoptables.');
	}

	function display($groupid) {

	}

	function displayGroupDropdown($userid=null) {
		$groups = $this->getGroups($userid);
		if (count($groups) == 0) return;

		$result = "<label for='groupselect'>Groups:</label> <script>$('.groupselect').on('change',function(){
    var value = $(this).val();
    location.href = '/group/'+ value;
    });</script>";
		$result = '<select id="groupselect" class="groupselect">';
		foreach ($groups as $group) {
			$result .= "<option value='{$group['id']}'>".htmlentities($group['name']).'</option>';
		}
		return $result.'</select>';
	}

	function store($name, $userid=null) {
		if ($userid == null) $userid = $this->userid;
		$userid = (int) $userid;
		$group = $this->db->insert($this->tablename, ['userid'=>$userid, 'name'=>$name]);
		$this->getGroups($userid);
		return $group->id;
	}

	function update($name, $groupid) {
		if ($this->valid($groupid) == false) throw new Exception('Invalid group id given.');
		$this->db->update($this->tablename, ['name'=>$name], "id = $groupid and userid = {$this->userid}");
		return true;
	}

	function delete($groupid) {
		 if ($this->valid($groupid == false)) throw new Exception('Invalid group id given.');
		 $this->db->delete($this->tablename, "groupid = $groupid and userid = {$this->userid}");
		 $this->db->update('owned_adoptables', ['groupid'=>0], "groupid = $groupid");
		 return true;
	}

	function movePet($petid, $newgroupid) {
		if ($this->valid($groupid) == false) throw new Exception('Invalid group id given.'); 
		$this->db->update('owned_adoptables', ['groupid'=>$newgroupid], "aid = $petid and owner = {$this->mysidia->user->username}");
		return true;
	}

	function getGroups($userid=null) {
		if ($userid == null) $userid = $this->userid;
		$userid = (int) $userid;
		$this->groups = $this->db->select($this->tablename, [], "userid = $userid")->fetchAll(PDO::FETCH_ASSOC);
		return $this->groups;
	}

	function valid($groupid) {
		if (!is_numeric($groupid)) return false;
		if ($groupid < 0) return false;
		$groups = $this->getGroups();
		if (!in_array($groupid, $groups)) return false;

		return true;
	}


}