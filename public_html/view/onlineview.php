<?php

class OnlineView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
		$document->setTitle($this->lang->title);
		
	    $total = $this->getField("total")->getValue();
		$stmt = $this->getField("stmt")->get();
		$document->add(new Comment("
			<table style='width:100%; text-align:center;'>
				<tr>
					<th style='color:#fd1d1d'>Username</th>
					<th style='color:#983398'>Nickname</th>
					<th style='color:#358935'>Pets Owned</th>
					<th style='color:#4242fb'>Cash</th>
					<th style='color:#ffaa00'>Gender</th>
					<th>Alignment</th>
				</tr>
		"));
	    while($username = $stmt->fetchColumn()){
		    $user = new Member($username);
			$alignment = $mysidia->db->select("users", array("alignment"), "username = '$user->username'")->fetchColumn();
		    $user->getprofile();
				$document->add(new Comment("
						<tr>
							<td>{$user->username}</td>
							<td>{$user->profile->getnickname()}</td>
							<td>{$user->getalladopts()}</td>
							<td>{$user->money}</td>
							<td>{$user->profile->getgender()}</td>
							<td>{$alignment}</td>
						</tr>
				", FALSE));
	    }
		$document->add(new Comment("</table>"));
		$document->addLangvar($this->lang->visitors.$total);
		$this->refresh(30);
	}
}
?>