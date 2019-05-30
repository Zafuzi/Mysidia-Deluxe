<?php

use Resource\Collection\ArrayList;

class AlchemyValidator extends Validator{

    private $alchemy;
    private $settings;
	private $validations;
	private $status;

    public function __construct(Alchemy $alchemy, AlchemySetting $settings, ArrayList $validations){
	    $this->alchemy = $alchemy;	
	    $this->settings = $settings;
		$this->validations = $validations;
	}
	
	public function getValidations(){
	    return $this->validations;
	}
	
	public function setValidations(ArrayList $validations, $overwrite = FALSE){
	    if($overwrite) $this->validations = $validations;
		else{
		    $iterator = $validations->iterator();
			while($iterator->hasNext()){
			    $this->validations->append($iterator->next());
			}
		}
	}
	
	public function getStatus(){
	    return $this->status;
	}

    public function setStatus($status = ""){
        $this->status = $status;
    }

    public function validate(){
        $iterator = $this->validations->iterator();
        while($iterator->hasNext()){		
		    $validation = $iterator->next();
			$method = "check{$validation->capitalize()}";
		    $this->$method();
		}
		return TRUE;		 
    }
	
	private function checkItems(){
	    if(!$this->alchemy->getItem() or !$this->alchemy->getItem2()) throw new ItemException("alchemy_empty");
		else{
		    if($this->alchemy->getItem()->quantity < 1 or $this->alchemy->getItem2()->quantity < 1){
			    throw new ItemException("alchemy_insufficient");
			}
			return TRUE;
		}
	}

    private function checkChance(){
	    if($this->settings->chance == "disabled") return TRUE;
		$chance = $this->alchemy->getChance();
		$rand = rand(0, 99);
		if($rand < $chance) return TRUE;
		else{
            $this->alchemy->consume();
            throw new ItemException("alchemy_chance");
        }
    }
	
    private function checkCost(){
	    if($this->settings->cost == 0) return TRUE;
	    $mysidia = Registry::get("mysidia");		
		if($mysidia->user->money >= $this->settings->cost) return TRUE;
		else throw new ItemException("alchemy_cost");
    }	

	private function checkLicense(){
	    if(!$this->settings->license) return TRUE;
		$mysidia = Registry::get("mysidia");
		$license = new PrivateItem($this->settings->license, $mysidia->user->username);
		if($license->quantity >= 1) return TRUE;
		else throw new ItemException("alchemy_license");
	}
	
    private function checkRecipe(){
        if($this->settings->recipe == "disabled" or !$this->alchemy->getRecipe()) return TRUE;
		$mysidia = Registry::get("mysidia");
		$recipe = new PrivateItem($this->alchemy->getRecipe()->itemname, $mysidia->user->username);
		if($recipe->quantity >= 1) return TRUE;
		else throw new ItemException("alchemy_recipe");
    }
	
	private function checkUsergroup(){
	    if($this->settings->usergroup == "all") return TRUE;
	    $mysidia = Registry::get("mysidia");		
		foreach($this->settings->usergroup as $usergroup){
		    if($mysidia->user->usergroup->gid == $usergroup) return TRUE;   
		}		
		throw new ItemException("alchemy_usergroup");
	}
}
?>