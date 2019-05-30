<?php

use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class BreedingView extends View{
	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->title);
		$document->addLangvar($this->lang->default.$this->lang->money);
		$settings = $this->getField('settings');
        $document->addLangvar("{$settings->cost} {$mysidia->settings->cost}");
        $document->addLangvar($this->lang->warning.$this->lang->select);
		$cost = $this->getField("cost")->getValue();

		$femaleMap = $this->values['femaleMap'];
		$maleMap = $this->values['maleMap'];
		$form = '<form method="post" action="/breeding/breed">';
		$form .= '<label for="female">Female:</label>';
		if (count($femaleMap) == 0) {
			$form .= $this->lang->female;
		}else{
			$form .= '<select name="female"><option>None Selected</option>';
			foreach ($femaleMap as $female){
				$form .= "<option value='{$female->aid}'>{$female->name} the {$female->type} #{$female->aid}</option>";
			}
			$form .='</select><br>';
		}
		$form .= '<label for="male">Male:</label>';
		if (count($maleMap) == 0) {
			$form .= $this->lang->male;
		}else{
			$form .= '<select name="male"><option>None Selected</option>';
			foreach ($maleMap as $male){
				$form .= "<option value='{$male->aid}'>{$male->name} the {$male->type} #{$male->aid}</option>";
			}
			$form .='</select><br>';
		}

		$form .= '<input type="submit" value="Breed Now!">';
		$form .= '</form>';
		$document->addLangvar($form);

		try{
			hasTooManyPets();
		} catch (Exception $e) {
			$this->document->add(new Comment($e->getMessage()));
			return false;
		}
	}

	public function breed(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle("Breeding is Successful!");

		try{
			hasTooManyPets();
		} catch (Exception $e) {
			$this->document->add(new Comment($e->getMessage()));
			return false;
		}
		
		$offspring = $this->values['offspring'];

		$document->add(new Comment("Congratulations! Breeding is successful, you have acquired a new baby {$offspring->species} from this breeding."));
        $document->add(new Comment("Click on the link below to manage your baby {$offspring->species} now!"));
		$document->addLangvar("<img src='{$offspring->base64()}'><br><a href='/myadopts/manage/{$this->values['aid']}'>Manage Baby</a>");

	}






	public function OLDindex(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    if($mysidia->input->post("submit")){
		    $links = $this->getField("links"); 
			if($links instanceof LinkedList){
                $breeding = $this->getField("breeding");
			    $document->setTitle("Breeding is Successful!");
                $document->add(new Comment("Congratulations! Breeding is successful, you have acquired {$breeding->countOffsprings()} baby Pets from this breeding."));
                $document->add(new Comment("Click on one of the links below to manage your Pets now!"));
                $iterator = $links->iterator();
				while($iterator->hasNext()) $document->add($iterator->next());			
			}
            else{
                $document->setTitle($this->lang->fail_title);
				$document->addLangvar($this->lang->fail);
            }			
			return;
		}
		
		$cost = $this->getField("cost")->getValue();
		$femaleMap = $this->getField("femaleMap");
		$maleMap = $this->getField("maleMap");
		$document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default.$this->lang->money);
        $document->addLangvar("{$settings->cost} {$mysidia->settings->cost}");
        $document->addLangvar($this->lang->warning.$this->lang->select);
		
		$breedingForm = new Form("breedingform", "breeding", "post");	    
        $breedingForm->add(new Comment("Female: ", FALSE));
        if($femaleMap instanceof LinkedHashMap){
	   	    $female = new DropdownList("female");
            $female->add(new Option("None Selected", "none"));            
            $female->fillReverse($femaleMap);
        }
        else $female = new Comment($this->lang->female, FALSE);
		$breedingForm->add($female);  
    
        $breedingForm->add(new Comment("Male: ", FALSE));
        if($maleMap instanceof LinkedHashMap){
		    $male = new DropdownList("male");
            $male->add(new Option("None Selected", "none"));
            $male->fillReverse($maleMap);
        }
        else $male = new Comment($this->lang->male, FALSE);

	    $breedingForm->add($male);		
		$breedingForm->add(new PasswordField("hidden", "breed", "yes"));
        $breedingForm->add(new Button("Breed Now!", "submit", "submit"));
        $document->add($breedingForm);	
	}
}