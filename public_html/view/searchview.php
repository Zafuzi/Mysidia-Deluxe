<?php

use Resource\Collection\LinkedList;

class SearchView extends View{

    public function index(){
        $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->title);
        $document->addLangvar($this->lang->default);
        $document->addLangvar('<center><table><tr>');
        $document->addLangvar("<td><a href='search/user'><center><img src='/picuploads/searchusers.png'></a><center></td>");
        $document->addLangvar("<td><a href='search/adopt'><center><img src='/picuploads/searchpets.png'></a><center></td>");
        $document->addLangvar("<td><a href='search/item'><center><img src='/picuploads/searchitems.png'></a><center></td>");
        $document->addLangvar("<td><a href='search/page'><center><img src='/picuploads/searchpages.png'></a><center></td>");
        $document->addLangvar('</tr><tr>');
        $document->addLangvar("<td><a href='search/user'><center>Search <br> Users</a><center></td>");
        $document->addLangvar("<td><a href='search/adopt'><center>Search <br> Adoptables</a><center></td>");
        $document->addLangvar("<td><a href='search/item'><center>Search <br>Items</a><center></td>");
        $document->addLangvar("<td><a href='search/page'><center><s>Search <br> Pages</s></a><center></td>");
        $document->addLangvar('</center></tr></table>');
    }

    public function user(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->user);
		
	    if($mysidia->input->post("submit")){
		    $userList = $this->getField("userList");
			$iterator = $userList->iterator();
		    $searchTable = new TableBuilder("searchresult");
			$searchTable->setAlign(new Align("center"));
			$searchTable->buildHeaders("ID", "Name", "Email", "Usergroup", "Joindate", "Befriend", "Trade");	
	        $searchTable->setHelper(new SearchTableHelper); 
					
			while($iterator->hasNext()){
			    $user = $iterator->next();
				$cells = new LinkedList;
				$cells->add(new TCell($user->uid));
				$cells->add(new TCell($searchTable->getHelper()->getUserProfile($user->username)));
				$cells->add(new TCell($user->getemail()));
				$cells->add(new TCell($searchTable->getHelper()->getUsergroup($user->usergroup->gid)));
				$cells->add(new TCell($user->membersince));
				$cells->add(new TCell($searchTable->getHelper()->getFriendRequest($user->uid)));
				$cells->add(new TCell($searchTable->getHelper()->getTradeOffer($user->uid)));
				$searchTable->buildRow($cells);
			}
		    $document->add($searchTable);		
			return;
		}

		$searchForm = new FormBuilder("searchform", "user", "post");
		$searchForm->buildComment("Username: ", FALSE)
		           ->buildTextField("name")
		           ->buildComment("Email: ", FALSE)
				   ->buildTextField("email");

        $groupMap = $this->getField("groupMap");
        $usergroups = new DropdownList("group");
        $usergroups->add(new Option("None Selected", "none"));
        $usergroups->fill($groupMap);		
        $searchForm->add(new Comment("Usergroup: ", FALSE));
        $searchForm->add($usergroups);

		$searchForm->buildComment("Birthday:", FALSE)
				   ->buildTextField("birthday")
				   ->buildComment("JoinDate:", FALSE)
				   ->buildTextField("joindate")
				   ->buildButton("Search", "submit", "submit");
        $document->add($searchForm);	
	}
	
	public function adopt(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->adopt);		
	    if($mysidia->input->post("submit")){
		    $adoptList = $this->getField("adoptList");
			$iterator = $adoptList->iterator();
		    $searchTable = new TableBuilder("searchresult");
			$searchTable->setAlign(new Align("center"));
			$searchTable->buildHeaders("ID", "Name", "Type", "Owner", "Level", "Gender", "Trade");	
	        $searchTable->setHelper(new SearchTableHelper); 
					
			while($iterator->hasNext()){
			    $adopt = $iterator->next();
				$cells = new LinkedList;
				$cells->add(new TCell($adopt->getAdoptID()));
				$cells->add(new TCell($searchTable->getHelper()->getAdoptName($adopt->getAdoptID(), $adopt->getName())));
				$cells->add(new TCell($adopt->getType()));
				$cells->add(new TCell($searchTable->getHelper()->getUserProfile($adopt->getOwner())));
				$cells->add(new TCell($adopt->getCurrentLevel()));
				$cells->add(new TCell($searchTable->getHelper()->getGenderImage($adopt->getGender())));
				$cells->add(new TCell($searchTable->getHelper()->getTradeStatus($adopt->getAdoptID(), $adopt->getTradeStatus())));
				$searchTable->buildRow($cells);
			}
		    $document->add($searchTable);			
			return;
		}

		$searchForm = new FormBuilder("searchform", "adopt", "post");
		$searchForm->buildComment("Name: ", FALSE)
		           ->buildTextField("name")
		           ->buildComment("Type: ", FALSE)
				   ->buildTextField("type")
				   ->buildComment("Owner:", FALSE)
				   ->buildTextField("owner")
				   ->buildComment("Gender:", FALSE)
				   ->buildTextField("gender")
				   ->buildComment("MinLevel:", FALSE)
				   ->buildTextField("minlevel")
				   ->buildButton("Search", "submit", "submit");
        $document->add($searchForm);	
	}

    public function item(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang->item);
		
	    if($mysidia->input->post("submit")){
		    $ItemList = $this->getField("itemList");
			$iterator = $ItemList->iterator();
			$searchTable = new TableBuilder("searchresult");
			$searchTable->setAlign(new Align("center"));
			$searchTable->buildHeaders("ID", "Name", "Category", "Description", "Function", "Shop", "Base Price", "Amount in-game");	
	        $searchTable->setHelper(new SearchTableHelper); 
					
			while($iterator->hasNext()){
			    $item = $iterator->next();
			    //gonna need to fetch from inventory...
			    $item_stmt = $mysidia->db->select("inventory", array("quantity"), "itemname = '$item->itemname' ORDER BY iid");
			    $item_amount = 0;
			    while($itemfetch = $item_stmt->fetchColumn()){
			        $item_amount = $item_amount + $itemfetch;
			    }
			    //That should do it I guess?
			    $cells = new LinkedList;
				$cells->add(new TCell($item->id));
				$cells->add(new TCell($item->itemname));
				$cells->add(new TCell($item->category));
				$cells->add(new TCell($item->description));
				$cells->add(new TCell($item->function));
				$cells->add(new TCell($searchTable->getHelper()->getShopLink($item->shop)));
				$cells->add(new TCell($item->price));
				$cells->add(new TCell($item_amount));
				$searchTable->buildRow($cells);
			}
		    $document->add($searchTable);			
			return;
		}

		$searchForm = new FormBuilder("searchform", "item", "post");
		$searchForm->buildComment("Itemname: ", FALSE)
		           ->buildTextField("name")
		           ->buildComment("Category: ", FALSE)
				   ->buildTextField("category");

        $funcList = $this->getField("funcList");
        $functions = new DropdownList("function");
        $functions->add(new Option("None Selected", "none"));
        $functions->fill($funcList);
        $searchForm->add(new Comment("Function: ", FALSE));
        $searchForm->add($functions);

		$searchForm->buildComment("Shop:", FALSE)
				   ->buildTextField("shop")
                   ->buildComment("MaxPrice:", FALSE)
				   ->buildTextField("maxprice")
				   ->buildButton("Search", "submit", "submit");
        $document->add($searchForm);	
	}
}
?>