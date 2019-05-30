<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPAlchemyView extends View{

	public function index(){
	    parent::index();
	    $mysidia = Registry::get("mysidia");
		$stmt = $this->getField("stmt")->get();
        $document = $this->document;
		
        $fields = new LinkedHashMap;
		$fields->put(new String("alid"), NULL);
		$fields->put(new String("item"), new String("getItemImage"));
		$fields->put(new String("item2"), new String("getItemImage"));
		$fields->put(new String("item3"), new String("getItemImage"));
		$fields->put(new String("item4"), new String("getItemImage"));
		$fields->put(new String("item5"), new String("getItemImage"));
		$fields->put(new String("newitem"), new String("getItemImage"));			
		$fields->put(new String("alid::edit"), new String("getEditLink"));
		$fields->put(new String("alid::delete"), new String("getDeleteLink"));	
		
		$AlchemyTable = new TableBuilder("alchemy");
		$AlchemyTable->setAlign(new Align("center", "middle"));
		$AlchemyTable->buildHeaders("ID", "Item1", "Item2", "Item3", "Item4", "Item5", "New Item", "Edit", "Delete");
		$AlchemyTable->setHelper(new ItemTableHelper);
		$AlchemyTable->buildTable($stmt, $fields);
        $document->add($AlchemyTable);	
	}
	
	public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
	    if($mysidia->input->post("submit")){
		    $document->setTitle($this->lang->added_title);
			$document->addLangvar($this->lang->added);
			return;
		}
		
		$document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);
        $itemMap = $this->getField("itemMap");
		$recipeMap = $this->getField("recipeMap");
		
		$alchemyForm = new Form("createalchemy", "add", "post");
		$title = new Comment("Create new Alchemy Practice:");
		$title->setBold();
		$title->setUnderlined();
		$alchemyForm->add($title);
		
		$alchemyForm->add(new Comment("Select first ingredient item: ", FALSE));
		$items = new DropdownList("item");
		$items->add(new Option("None Selected", "none"));
        if($itemMap->size() > 0){
            $iterator = $itemMap->iterator();
            while($iterator->hasNext()){
                $item = $iterator->nextEntry();
                $items->add(new Option($item->getValue(), $item->getKey()));
            }
        }		
		$alchemyForm->add($items);		
		
		$alchemyForm->add(new Comment("Select second ingredient item: ", FALSE));
		$items2 = new DropdownList("item2");
		$items2->add(new Option("None Selected", "none"));
        if($itemMap->size() > 0){
            $iterator = $itemMap->iterator();
            while($iterator->hasNext()){
                $item2 = $iterator->nextEntry();
                $items2->add(new Option($item2->getValue(), $item2->getKey()));
            }
        }		
		$alchemyForm->add($items2);
		
		$alchemyForm->add(new Comment("Select third ingredient item(optional): ", FALSE));
		$items3 = new DropdownList("item3");
		$items3->add(new Option("None Selected", "0"));
        if($itemMap->size() > 0){
            $iterator = $itemMap->iterator();
            while($iterator->hasNext()){
                $item3 = $iterator->nextEntry();
                $items3->add(new Option($item3->getValue(), $item3->getKey()));
            }
        }		
		$alchemyForm->add($items3);
		
		$alchemyForm->add(new Comment("Select fourth ingredient item(optional): ", FALSE));
		$items4 = new DropdownList("item4");
		$items4->add(new Option("None Selected", "0"));
        if($itemMap->size() > 0){
            $iterator = $itemMap->iterator();
            while($iterator->hasNext()){
                $item4 = $iterator->nextEntry();
                $items4->add(new Option($item4->getValue(), $item4->getKey()));
            }
        }		
		$alchemyForm->add($items4);
		
		$alchemyForm->add(new Comment("Select fifth ingredient item(optional): ", FALSE));
		$items5 = new DropdownList("item5");
		$items5->add(new Option("None Selected", "0"));
        if($itemMap->size() > 0){
            $iterator = $itemMap->iterator();
            while($iterator->hasNext()){
                $item5 = $iterator->nextEntry();
                $items5->add(new Option($item5->getValue(), $item5->getKey()));
            }
        }		
		$alchemyForm->add($items5);
		
		$alchemyForm->add(new Comment("Select newly produced item: ", FALSE));
		$newitems = new DropdownList("newitem");
		$newitems->add(new Option("None Selected", "none"));
        if($itemMap->size() > 0){
            $iterator = $itemMap->iterator();
            while($iterator->hasNext()){
                $newitem = $iterator->nextEntry();
                $newitems->add(new Option($newitem->getValue(), $newitem->getKey()));
            }
        }		
		$alchemyForm->add($newitems);				
		$alchemyForm->add(new Comment("Chance for Alchemy to work: ", FALSE));
		$alchemyForm->add(new TextField("chance", 100, 6));
		
		$alchemyForm->add(new Comment("Select recipe item: ", FALSE));
		$recipes = new DropdownList("recipe");
		$recipes->add(new Option("None Selected", "none"));
        if($recipeMap->size() > 0){
            $iterator = $recipeMap->iterator();
            while($iterator->hasNext()){
                $recipe = $iterator->nextEntry();
                $recipes->add(new Option($recipe->getValue(), $recipe->getKey()));
            }
        }		
		$alchemyForm->add($recipes);			
		$alchemyForm->add(new Button("Create New Alchemy Practice", "submit", "submit"));
		$document->add($alchemyForm);
	}
	
	public function edit(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;	
		
	    if(!$mysidia->input->get("alid")){
		    // An item has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		elseif($mysidia->input->post("submit")){		
		    $document->setTitle($this->lang->edited_title);
			$document->addLangvar($this->lang->edited);
		    return;
		}
		else{
		    $alchemy = $this->getField("alchemy")->get();
		    $document->setTitle($this->lang->edit_title);
			$document->addLangvar($this->lang->edit);
		    $title = new Comment("Edit Alchemy Practice:");
		    $title->setBold();
		    $title->setUnderlined();
			
			$alchemyForm = new Form("edititem", $mysidia->input->get("alid"), "post");			
		    $alchemyForm->add($title);		
		    $alchemyForm->add(new Comment("Select first ingredient item: ", FALSE));
            $itemMap = $this->getField("itemMap");
		    $recipeMap = $this->getField("recipeMap");			
			
		    $items = new DropdownList("item");
		    $items->add(new Option("None Selected", "none"));
            if($itemMap->size() > 0){
                $iterator = $itemMap->iterator();
                while($iterator->hasNext()){
                    $item = $iterator->nextEntry();
                    $items->add(new Option($item->getValue(), $item->getKey()));
                }
            }
            $items->select($alchemy->item);			
		    $alchemyForm->add($items);		
		
		    $alchemyForm->add(new Comment("Select second ingredient item: ", FALSE));
		    $items2 = new DropdownList("item2");
		    $items2->add(new Option("None Selected", "none"));
            if($itemMap->size() > 0){
                $iterator = $itemMap->iterator();
                while($iterator->hasNext()){
                    $item2 = $iterator->nextEntry();
                    $items2->add(new Option($item2->getValue(), $item2->getKey()));
                }
            }		
            $items2->select($alchemy->item2);					
		    $alchemyForm->add($items2);		
			
			$alchemyForm->add(new Comment("Select third ingredient item: ", FALSE));
		    $items3 = new DropdownList("item3");
		    $items3->add(new Option("None Selected", "none"));
            if($itemMap->size() > 0){
                $iterator = $itemMap->iterator();
                while($iterator->hasNext()){
                    $item3 = $iterator->nextEntry();
                    $items3->add(new Option($item3->getValue(), $item3->getKey()));
                }
            }		
            $items3->select($alchemy->item3);					
		    $alchemyForm->add($items3);		
			
			$alchemyForm->add(new Comment("Select fourth ingredient item: ", FALSE));
		    $items4 = new DropdownList("item4");
		    $items4->add(new Option("None Selected", "none"));
            if($itemMap->size() > 0){
                $iterator = $itemMap->iterator();
                while($iterator->hasNext()){
                    $item4 = $iterator->nextEntry();
                    $items4->add(new Option($item4->getValue(), $item4->getKey()));
                }
            }		
            $items4->select($alchemy->item4);					
		    $alchemyForm->add($items4);		
			
			$alchemyForm->add(new Comment("Select fifth ingredient item: ", FALSE));
		    $items5 = new DropdownList("item5");
		    $items5->add(new Option("None Selected", "none"));
            if($itemMap->size() > 0){
                $iterator = $itemMap->iterator();
                while($iterator->hasNext()){
                    $item5 = $iterator->nextEntry();
                    $items5->add(new Option($item5->getValue(), $item5->getKey()));
                }
            }		
            $items5->select($alchemy->item5);					
		    $alchemyForm->add($items5);		
			
			
		
		    $alchemyForm->add(new Comment("Select newly produced item: ", FALSE));
		    $newitems = new DropdownList("newitem");
		    $newitems->add(new Option("None Selected", "none"));
            if($itemMap->size() > 0){
                $iterator = $itemMap->iterator();
                while($iterator->hasNext()){
                    $newitem = $iterator->nextEntry();
                    $newitems->add(new Option($newitem->getValue(), $newitem->getKey()));
                }
            }	
	        $newitems->select($alchemy->newitem);				
		    $alchemyForm->add($newitems);				
		    $alchemyForm->add(new Comment("Chance for Alchemy to work: ", FALSE));
		    $alchemyForm->add(new TextField("chance", $alchemy->chance, 6));
		
		    $alchemyForm->add(new Comment("Select recipe item: ", FALSE));
		    $recipes = new DropdownList("recipe");
		    $recipes->add(new Option("None Selected", "none"));
            if($recipeMap->size() > 0){
                $iterator = $recipeMap->iterator();
                while($iterator->hasNext()){
                    $recipe = $iterator->nextEntry();
                    $recipes->add(new Option($recipe->getValue(), $recipe->getKey()));
                }
            }	
			$recipes->select($alchemy->recipe);		
		    $alchemyForm->add($recipes);
			
		    $alchemyForm->add(new Button("Edit Alchemy Practice", "submit", "submit"));
		    $document->add($alchemyForm); 
	    }
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("alid")){
		    // An entry has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
    }
	
	public function settings(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;			
		if($mysidia->input->post("submit")){
			$document->setTitle($this->lang->settings_changed_title);
            $document->addLangvar($this->lang->settings_changed);
		    return;
		}
		
        $alchemySettings = $this->getField("alchemySettings");			
		$document->setTitle($this->lang->settings_title);
		$document->addLangvar($this->lang->settings);
		$settingsForm = new FormBuilder("settingsform", "settings", "post");
		$alchemySystem = new LinkedHashMap;
		$alchemySystem->put(new String("Enabled"), new String("enabled"));
		$alchemySystem->put(new String("Disabled"), new String("disabled"));
		$alchemyChance = clone $alchemySystem;
        $alchemyRecipe = clone $alchemySystem;		
		
		$settingsForm->buildComment("Alchemy System Enabled:   ", FALSE)->buildRadioList("system", $alchemySystem, $alchemySettings->system)
					 ->buildComment("Alchemy Success/Failure Enabled:   ", FALSE)->buildRadioList("chance", $alchemyChance, $alchemySettings->chance)
					 ->buildComment("Alchemy Recipe Usage Enabled:   ", FALSE)->buildRadioList("recipe", $alchemyRecipe, $alchemySettings->recipe)
		             ->buildComment("Alchemy Cost:	 ", FALSE)->buildTextField("cost", $alchemySettings->cost)					 
		             ->buildComment("Alchemy License Item:	 ", FALSE)->buildTextField("license", $alchemySettings->license)					 
					 ->buildComment("Usergroup(s) permitted to use alchemy(separate by comma):	", FALSE)->buildTextField("usergroup", ($alchemySettings->usergroup == "all")?$alchemySettings->usergroup:implode(",", $alchemySettings->usergroup))
					 ->buildButton("Change Alchemy Settings", "submit", "submit");
		$document->add($settingsForm);	
	}	
}	
?>