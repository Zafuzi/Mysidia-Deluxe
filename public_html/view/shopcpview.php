<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ShopcpView extends View{
	
	public function index(){
	$mysidia = Registry::get("mysidia");		
		$document = $this->document;
		$document->setTitle("Manage Shops");
		$stmt = $mysidia->db->select("user_shops", array("usid"), "manager_id='{$mysidia->user->uid}'");
		
		$document->add(new Comment("</br><a class='btn btn-info' href='/shopcp/add'>Add new shop</a>"));
		$document->add(new Comment("<center><table style='text-align:center;border-collapse:collapse;'>
  <thead>
    <tr>
      <th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Name</th>
      <th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Description</th>
      <th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Type</th>
      <th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Status</th>
      <th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Action</th>
    </tr>
  </thead>
  <tbody>", FALSE));
  		while($usid = $stmt->fetchColumn()){
		    $shop_info = $mysidia->db->select("user_shops", array(), "usid='{$usid}'")->fetchObject(); 
		    if($shop_info->status == "open"){$status = "<p style='color:green;'>Open</p>";}
		    else{$status = "<p style='color:red;'>Closed</p>";}
                   
                   $document->add(new Comment("<tr>
      <td style='border: 2px solid #7F7F7F;padding:8px;'>{$shop_info->us_name}</td>
      <td style='border: 2px solid #7F7F7F;padding:8px;'>{$shop_info->description}</td>
      <td style='border: 2px solid #7F7F7F;padding:8px;'>{$shop_info->type} shop</td>
      <td style='border: 2px solid #7F7F7F;padding:8px;'>{$status}</td>
      <td style='border: 2px solid #7F7F7F;padding:8px;'><a href='/shopcp/edit/{$usid}' class='btn btn-primary' style='width:48%; height:auto;'>Edit</a> <a href='/usershop/browse/{$usid}' class='btn btn-primary' style='width:48%; height:auto;'>Visit</a></td>

    </tr>", FALSE));
                   } 
		
		$document->add(new Comment("</tbody></table></center>"));
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$shopName = $_REQUEST["shopname"];
			$description = $_REQUEST["desc"];
			$wm = $_REQUEST["welcome"];
			$image = $_REQUEST["image"];
			$status = $_REQUEST["shopstat"];
			$type = $_REQUEST["shoptype"];
			$document->setTitle("Shop created!");
			$uid = $mysidia->user->uid;
			
			$document->add(new Comment("{$shopName} has been created!</br> Return to the <a href='/shopcp'>Shop CP</a>?"));
			$mysidia->db->insert("user_shops", array("manager_id" => $uid, "type" => $type, "us_name" => $shopName, "description" => $description, "welcome_message" => $wm, "npc_url" => $image, "status" => $status));
			return;
		} 
		
		$document->setTitle(" ");
		$document->add(new Comment("<title>Create a new shop</title>"));
		$adoptshop_lookup = $mysidia->db->select("user_shops", array("usid"), "manager_id='{$mysidia->user->uid}' AND type='adopt'")->rowCount();
		if ($adoptshop_lookup > 0 OR $adoptshop_lookup != NULL){
			$document->add(new Comment("Sorry! You can only make one shop at the moment.</br> Return to the <a href='/shopcp'>Shop CP</a>?"));
			return;
		}
		$document->addLangvar($this->lang->add);		
        		$document->add(new Comment("
	<p><u><h2>Create A New Shop:</u></h2></p>					
	<form method='post' action='/shopcp/add'>
		<p><input type='text' class='form-control' placeholder='Shop name' id='shopname' name='shopname' maxlength='20' style='width:25%;'><small class='form-text text-muted'>20 characters max.</small></p>
		<p><textarea class='form-control' placeholder='Here you can enter a description for your shop' maxlength='400' name='desc' id='desc'></textarea></p>
		<p><textarea class='form-control' placeholder='Here you can enter your welcome message' maxlength='400' id='welcome' name='welcome'></textarea></p>
		<p><input type='text' class='form-control' placeholder='NPC image' id='npc' name='npc' maxlength='150' style='width:25%;'><small class='form-text text-muted'>Must be the full url, including http://</small></p>
		<p><div class='form-check form-check-inline'>
			Shop Status:<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shopstat' id='shopstat' value='open' checked>&nbsp&nbsp&nbsp Open
			</label>
		</div>
		<div class='form-check form-check-inline'>
			<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shopstat' id='shopstat' value='closed'>&nbsp&nbsp&nbsp Closed
			</label>
		</div></p>
		<p><div class='form-check form-check-inline'>
			Shop Type:<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shoptype' id='shoptype' value='adopt' checked>&nbsp&nbsp&nbsp Adopt
			</label>
		</div>
		<div class='form-check form-check-inline disabled'>
			<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shoptype' id='shoptype' value='item' disabled>&nbsp&nbsp&nbsp Item
			</label>
		</div></p>
		<button type='submit' class='btn btn-primary'>Create Shop</button>
	</form>
", FALSE));
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
				
	    if(!$mysidia->input->get("usid")){
		    $this->index();
			return;
		}
		elseif ($_SERVER['REQUEST_METHOD'] == 'POST') {
			$shopName = $_REQUEST["shopname"];
			$description = $_REQUEST["desc"];
			$wm = $_REQUEST["welcome"];
			$npc = $_REQUEST["npc"];
			$status = $_REQUEST["shopstat"];
			$type = $_REQUEST["shoptype"];
			$document->setTitle("Editing successful!");
			$uid = $mysidia->user->uid;
			$shop_id = $mysidia->input->get("usid");			
			
			$document->add(new Comment("Your changes to {$shopName} have been saved!</br> Return to the <a href='/shopcp'>Shop CP</a>?"));
			$document->add(new Comment("DEBUG MESSAGE: NPC URL = {$npc}"));
			$mysidia->db->update("user_shops", array("type" => $type, "us_name" => $shopName, "description" => $description, "welcome_message" => $wm, "npc_url" => $npc, "status" => $status), "manager_id = $uid AND usid = $shop_id");
			return;
		}		
		else{
		    $shop = $this->getField("user_shop")->get();
		    $manager_id = $shop->manager_id;
		    $uid = $mysidia->user->uid;
		    $document->setTitle(" ");
		    //prevents any edits if the user doesn't own the shop
		    if($manager_id != $uid){$document->add(new Comment("You dont own this shop!</br> Return to the <a href='/shopcp'>Shop CP</a>?")); return;}
		    
			$document->addLangvar($this->lang->edit);			
            	$document->add(new Comment("
	<p><u><h2>Editing {$shop->us_name}</u></h2></p>					
	<form method='post' action='/shopcp/edit/{$shop->usid}'>
		<p><input type='text' class='form-control' placeholder='Shop name' id='shopname' name='shopname' maxlength='20' value='{$shop->us_name}' style='width:25%;'><small class='form-text text-muted'>20 characters max.</small></p>
		<p><textarea class='form-control' placeholder='Here you can enter a description for your shop' maxlength='400' name='desc' id='desc'>{$shop->description}</textarea></p>
		<p><textarea class='form-control' placeholder='Here you can enter your welcome message' maxlength='400' id='welcome' name='welcome'>{$shop->welcome_message}</textarea></p>
		<p><input type='text' class='form-control' placeholder='NPC image' id='npc' name='npc' maxlength='150' value='{$shop->npc_url}' style='width:25%;'><small class='form-text text-muted'>Must be the full url, including http://</small></p>
		<p><div class='form-check form-check-inline'>
			Shop Status:<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shopstat' id='shopstat' value='open' checked>&nbsp&nbsp&nbsp Open
			</label>
		</div>
		<div class='form-check form-check-inline'>
			<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shopstat' id='shopstat' value='closed'>&nbsp&nbsp&nbsp Closed
			</label>
		</div></p>
		<p><div class='form-check form-check-inline'>
			Shop Type:<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shoptype' id='shoptype' value='adopt' checked>&nbsp&nbsp&nbsp Adopt
			</label>
		</div>
		<div class='form-check form-check-inline disabled'>
			<label class='form-check-label'>
				<input class='form-check-input' type='radio' name='shoptype' id='shoptype' value='item' disabled>&nbsp&nbsp&nbsp Item
			</label>
		</div></p>
		<button type='submit' class='btn btn-primary'>Save Changes</button> <a href='/shopcp' class='btn btn-danger'>Cancel</a>
	</form>
", FALSE));
	    }
	}

    public function delete(){
	   	$mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("usid")){
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
        header("Refresh:3; URL='../../shopcp'");
    }
}
?>