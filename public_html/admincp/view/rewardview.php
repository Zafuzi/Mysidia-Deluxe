<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ACPRewardView extends View{
  
	public function index(){
	    parent::index();		
		$stmt = $this->getField("stmt")->get();		
		$document = $this->document;		
		$promoTable = new TableBuilder("promocode");
		$promoTable->setAlign(new Align("center", "middle"));
		$promoTable->buildHeaders("ID", "User", "Code", "View Rewards");
		$promoTable->setHelper(new TableHelper);
		
        $fields = new LinkedHashMap;
		$fields->put(new String("pid"), NULL);
		$fields->put(new String("user"), NULL);
		$fields->put(new String("code"), NULL);	
        $fields->put(new String("pid::reward"), new String("getRewardLink"));			
		$promoTable->buildTable($stmt, $fields);
        $document->add($promoTable);	
	}
	
    public function browse(){
		$stmt = $this->getField("stmt")->get();	
 		$document = $this->document;		
		$document->setTitle($this->lang->browse_title);
		$document->addLangvar($this->lang->browse);	
		$rewardTable = new TableBuilder("reward");
		$rewardTable->setAlign(new Align("center", "middle"));
		$rewardTable->buildHeaders("ID", "Type", "Reward", "Quantity", "Delete");
		$rewardTable->setHelper(new TableHelper);      

        $fields = new LinkedHashMap;
		$fields->put(new String("rid"), NULL);
		$fields->put(new String("type"), NULL);
		$fields->put(new String("reward"), NULL);	
		$fields->put(new String("quantity"), NULL);	
        $fields->put(new String("rid::delete"), new String("getDeleteLink"));			
		$rewardTable->buildTable($stmt, $fields);
        $document->add($rewardTable);	
    }

	public function add(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("promo")){
            $this->index();
            return;
        }
	    if($mysidia->input->post("submit")){			
		    $document->setTitle($this->lang->added_title);
			$document->addLangvar($this->lang->added);
            header("Refresh:3; URL='../../reward'");
			return;
		}
		
		$document->setTitle($this->lang->add_title);
		$document->addLangvar($this->lang->add);		
        $promo = $this->getField("promo")->get();		
		$rewardForm = new Form("addform", $mysidia->input->get("promo"), "post");
		$rewardForm->add(new Comment("<br><u>Create A New Reward for Promocode: {$promo->code}:</u><br>", TRUE, "b"));
        $rewardForm->add(new PasswordField("hidden", "code", $promo->code));
		$rewardForm->add(new Comment("Type:(adoptables or items)")); 
		$typesList = new RadioList("type");
		$typesList->add(new RadioButton(" Adoptables", "type", "Adopt"));
		$typesList->add(new RadioButton(" Items", "type", "Item"));
		$rewardForm->add($typesList);
		$rewardForm->add(new Comment("Reward: the adoptable type or item name your member can obtain by entering this promocode."));
		$rewardForm->add(new TextField("reward"));		
		$rewardForm->add(new Comment("Quantity:(if the reward type is item, how many items does this reward contain? It does not work for adoptables)"));
		$rewardForm->add(new TextField("quantity", 1, 6));
		$rewardForm->add(new Button("Create Reward", "submit", "submit"));
		$document->add($rewardForm);				
	}
	
	public function delete(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        if(!$mysidia->input->get("promo")){
		    // A reward has yet been selected, return to the index page.
		    $this->index();
			return;
		}
		$document->setTitle($this->lang->delete_title);
		$document->addLangvar($this->lang->delete);
        header("Refresh:3; URL='../../reward'");
	}
}