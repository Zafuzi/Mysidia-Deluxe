<?php

class InventoryController extends AppController{

    const PARAM = "confirm";

    public function __construct(){
        parent::__construct("member");
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$inventory = new Inventory($mysidia->user);
        if($inventory->gettotal() == 0) throw new InvalidIDException("inventory_empty");
		$this->setField("inventory", $inventory);
	}
			
	public function uses(){
		$mysidia = Registry::get("mysidia");
		$document = $mysidia->frame->getDocument();
		$item = new PrivateItem($mysidia->input->post("itemname"), $mysidia->user->username);   
        if($item->iid == 0) throw new ItemException("use_none");
		
		if($mysidia->input->post("aid")){
		    if(!$item->checktarget($mysidia->input->post("aid")) or $mysidia->input->post("validation") != "valid"){
			    throw new ItemException("use_fail");
            }
		    elseif(!$item->randomchance()){
                $item->remove();
				throw new ItemException("use_effect");
            }
            else{ 
			    $message = $item->apply($mysidia->input->post("aid")); 
				$this->setField("message", $message);
			}	
            return;			
		}

        $stmt = $mysidia->db->select("owned_adoptables", array("aid", "name"), "owner = '{$mysidia->user->username}'");
        $map = $mysidia->db->fetchMap($stmt);
		$this->setField("petMap", $map);
		$this->setField('item', $item);
	}
	
	public function sell(){
		$mysidia = Registry::get("mysidia");
		$item = new PrivateItem($mysidia->input->post("itemname"), $mysidia->user->username);   
        if($item->iid == 0) throw new ItemException("sell_none");
		
        if(!$mysidia->input->post("quantity")) throw new ItemException("sell_empty");
        elseif($item->quantity < $mysidia->input->post("quantity")) throw new ItemException("sell_quantity");
        else $item->sell($mysidia->input->post("quantity"));
	}
	
	public function toss(){
	    $mysidia = Registry::get("mysidia");
		$item = new PrivateItem($mysidia->input->post("itemname"), $mysidia->user->username);  
	    if($item->iid == 0) throw new ItemException("toss_none");
		
		if($mysidia->input->get("confirm")){
			$item->toss();
	        return;
		}		
	}
	
	public function alchemy(){
	    $mysidia = Registry::get("mysidia");
		$settings = new AlchemySetting($mysidia->db);
		if($settings->system == "disabled") throw new ItemException("alchemy_disabled");
		
		if($mysidia->input->post("iid") and $mysidia->input->post("iid2") and $mysidia->input->post("iid3") and $mysidia->input->post("iid4") and $mysidia->input->post("iid5")){
		    $alchemy = new Alchemy($mysidia->input->post("iid"), $mysidia->input->post("iid2"), $mysidia->input->post("iid3"), $mysidia->input->post("iid4"), $mysidia->input->post("iid5"), $settings);
			$alchemy->mix();
			$this->setField("alchemy", $alchemy);
            return;
		}
		
		$stmt = $mysidia->db->select("inventory", array("iid", "itemname"), "owner = '{$mysidia->user->username}'");
		$map = $mysidia->db->fetchMap($stmt);
		$this->setField("itemMap", $map);
		$this->setField("settings", $settings);
	}
}
?>