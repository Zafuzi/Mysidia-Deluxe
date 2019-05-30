<?php

use Resource\Native\String;
use Resource\Collection\ArrayList;

class Alchemy extends Model{
  // The item class.

    protected $alid;
    protected $item;
    protected $item2;
	protected $item3;
	protected $item4;
	protected $item5;
    protected $newItem;
	protected $chance;
	protected $recipe;
	protected $validator;
	protected $settings;
	
    public function __construct($iid, $iid2, $iid3, $iid4, $iid5, AlchemySetting $settings){
	    $mysidia = Registry::get("mysidia");
	    $this->item = new PrivateItem($iid);
		$this->item2 = new PrivateItem($iid2);
		$this->item3 = new PrivateItem($iid3);
		$this->item4 = new PrivateItem($iid4);
		$this->item5 = new PrivateItem($iid5);
		$this->settings = $settings;		
		$this->loadValidator();
		
	    $whereClause = "
				(
					item = '{$this->item->id}'
						OR item = '{$this->item2->id}'
						OR item = '{$this->item3->id}'
						OR item = '{$this->item4->id}'
						OR item = '{$this->item5->id}'
				)
				and 
				(
					item2 = '{$this->item->id}'
						OR item2 = '{$this->item2->id}'
						OR item2 = '{$this->item3->id}'
						OR item2 = '{$this->item4->id}'
						OR item2 = '{$this->item5->id}'
				)
				and 
				(
					item3 = '{$this->item->id}'
						OR item3 = '{$this->item2->id}'
						OR item3 = '{$this->item3->id}'
						OR item3 = '{$this->item4->id}'
						OR item3 = '{$this->item5->id}'
				)
				and 
				(
					item4 = '{$this->item->id}'
						OR item4 = '{$this->item2->id}'
						OR item4 = '{$this->item3->id}'
						OR item4 = '{$this->item4->id}'
						OR item4 = '{$this->item5->id}'
				)
				and 
				(
					item5 = '{$this->item->id}'
						OR item5 = '{$this->item2->id}'
						OR item5 = '{$this->item3->id}'
						OR item5 = '{$this->item4->id}'
						OR item5 = '{$this->item5->id}'
				)";		
		
		
		$alchemy = $mysidia->db->select("alchemy", array(), $whereClause)->fetchObject();
	    if(!is_object($alchemy)) throw New ItemException("alchemy_invalid");
		
        $this->alid = $alchemy->alid;
        $this->newItem = new StockItem($alchemy->newitem);
        $this->chance = $alchemy->chance;	
		$this->recipe = ($alchemy->recipe and $alchemy->recipe != "none")?new Item($alchemy->recipe):NULL;
		$this->usergroup = $alchemy->usergroup;
    }
	
	public function getItem(){
	    return $this->item;
	}
	
	public function getItem2(){
	    return $this->item2;
	}
	
	public function getNewItem(){
	    return $this->newItem;
	}
	
	public function getChance(){
	    return $this->chance;
	}
	
	public function getRecipe(){
	    return $this->recipe;
	}
	
	public function getUsergroup(){
	    return $this->usergroup;
	}

    public function mix(){
	    $this->validator->validate();
        $this->consume();
        $this->produce();		
    }
	
    public function consume(){
	    $this->item->remove();
		$this->item2->remove();
    }
 
	public function produce(){
	    $mysidia = Registry::get("mysidia");
		$mysidia->user->changecash(-1*$this->settings->cost);
		$this->newItem->append(1, $mysidia->user->username);
	}
	
	protected function loadValidator(){
	    $validations = new ArrayList;
		$validations->add(new String("items"));
		$validations->add(new String("license"));
		$validations->add(new String("cost"));
		$validations->add(new String("recipe"));
		$validations->add(new String("usergroup"));
		$validations->add(new String("chance"));
        $this->validator = new AlchemyValidator($this, $this->settings, $validations);		
	}

    protected function save($field, $value){
	    return FALSE;
    }	 
}
?> 