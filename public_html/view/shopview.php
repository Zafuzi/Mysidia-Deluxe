<?php

use Resource\Collection\LinkedList;

class ShopView extends View{
	
	public function index(){
		$document = $this->document;
	    $document->setTitle($this->lang->access);
		
		$typeForm = new Form("shoptypes", "shop", "post");
		$typeSelection = new DropdownList("shoptype");
		$typeSelection->add(new Option("Itemshop", "itemshop"));
		$typeSelection->add(new Option("Adoptshop", "adoptshop"));
		$typeForm->add($typeSelection);
		$typeForm->add(new Button("Go", "submit", "submit"));
		$document->add($typeForm);
		
		        $shopList = $this->getField("shopList"); 
        $document->addLangvar($this->lang->select);
        $shopTable = new TableBuilder("shoplist");
        $shopTable->setAlign(new Align("center", "middle"));
        $shopTable->buildHeaders("Enter", "Description", "Location");    
        $shopTable->setHelper(new ShopTableHelper);         
        
        $iterator = $shopList->iterator();
        while($iterator->hasNext()){
            $entry = $iterator->next();
            $shop = $shopList->createshop($entry->getKey());
            $cells = new LinkedList;
            $cells->add(new TCell($shopTable->getHelper()->getShopStatus($shop)));
            
            if($shop->status == "open") {
                $cells->add(new TCell($shop->description));
                $cells->add(new TCell($shop->category));
                # $cells->add(new TCell($shopTable->getHelper()->getSalestax($shop->salestax)));    
            }    
            if($shop->status == "closed") { 
                $cells->add(new TCell(""));
                $cells->add(new TCell("Not Open."));
                $cells->add(new TCell("")); 
            }    
            $shopTable->buildRow($cells);
        }  		 
        
        $document->add($shopTable);  
	}
	
	public function browse(){
		$document = $this->document;			        
		$document->setTitle($this->lang->welcome);
        $shop = $this->getField("shop");
        $shop->display();
	}
	
	public function purchase(){
        $mysidia = Registry::get("mysidia");
		$cost = $this->getField("cost");
		$document = $this->document;
		
	    if($mysidia->input->post("shoptype") == "itemshop"){
		    $document->setTitle($this->lang->global_transaction_complete);
	        $document->addLangvar("{$this->lang->purchase_item}{$cost->getValue()} {$mysidia->settings->cost}");
		}
		elseif($mysidia->input->post("shoptype") == "adoptshop"){
   			$document->setTitle($this->lang->global_transaction_complete);
	        $document->addLangvar("{$this->lang->purchase_adopt}{$cost->getValue()} {$mysidia->settings->cost}");	  
		}

		$shoplink = '/shop/browse/'.$mysidia->input->get('shop');
		$document->addLangvar("<p><a href='$shoplink'>{$mysidia->input->get('shop')}</a></p>");
		$this->redirect(2, $shoplink);
	}
}