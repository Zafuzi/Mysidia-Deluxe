<?php

use Resource\Native\String;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class MyadoptsView extends View{

    /**
     * @throws Exception
     */
    public function index(){
    	$document = $this->document;
    	$document->setTitle($this->lang->title);

    	$groups = $this->getField('groups');


    	$document->add($this->getField('pet_storage_info'));

    	$pagination = $this->getField("pagination");
    	$stmt = $this->getField("stmt")->get();
    	if($stmt->rowCount() == 0){
    		$document->addLangvar($this->lang->empty);
    		return;
    	}

    	$adopts = $stmt->fetchAll(PDO::FETCH_CLASS,'OwnedAdoptable');

    	foreach ($adopts as $a)
    	{
            if ($a->class == 'Colorful') {
              $categoryArray[] = $a->type;
            }
            else{
              $categoryArray[] = $a->class;
            }
    	}

    	$categories = array_unique($categoryArray);

    	$document->add(new Comment('<div id="tabs" class="c-tabs no-js">',false));

    	foreach ($categories as $tab) {
    		$document->add(new Comment("<a href='#' class='c-tabs-nav__link'>$tab</a>", FALSE));
    	}

    	$i = 0;
        // Style for inventory like display.
    	$document->add(new Comment('<style>
    		.sc_pet {
    			display: inline-table;
    			padding: 5px;
    			text-align: center;
    			font-family: "Trebuchet MS", Helvetica, sans-serif;
    			font-size: 14px;
    			margin-bottom: 3px;
    			height: 300px;
    		}
    		.s_pet_panel {
    			border-radius: 2px;
    			border: 1px solid #CCC;
    		}
    	</style>', FALSE));


    	$document->add(new Comment("<div class='c-tab is-active'>
    		<div class='c-tab__content'>", FALSE));

        foreach ($adopts as $adopt) {
            if ($adopts[$i]->class == 'Colorful') {
                $adopts[$i]->class = $adopts[$i]->type;
                $adopts[$i]->type = 'Colorful';
            }
        	if ($i != 0 AND ($adopts[$i]->class != $adopts[$i-1]->class))
        	{
        		$document->add(new Comment('</div></div>',false));
        		$document->add(new Comment('<div class="c-tab"><div class="c-tab__content">',false));
            }

            // Display Like Inventory System
            $document->add(new Comment("<div class='s_pet_panel sc_pet'>"));
            $document->add(new Comment("<em>{$adopt->getName()}</em>",false));
            $document->add($adopt->getGender("gui"));
            $document->add(new Link("myadopts/manage/{$adopt->getAdoptID()}", "<br><img src='{$adopt->getImageFromWithin()}'>"));
            
               
                                     
                                $document->add(new Comment("<br>Total Clicks: {$adopt->getTotalClicks()} for Current Level: {$adopt->getCurrentLevel()}",false));
            $document->add(new Comment("</div>", FALSE));

			$i++;
		}
        //$document->add($adoptTable);

		$document->add(new Comment(
			"</div></div><script src='/js/otherTabs.js'></script>
			<script>
				var myTabs = tabs({
					el: '#tabs',
					tabNavigationLinks: '.c-tabs-nav__link',
					tabContentContainers: '.c-tab'
				});

				myTabs.init();
			</script>", FALSE));

        $document->addLangvar($pagination->showPage());

    }
 public function manage(){ 
            
        $mysidia = Registry::get("mysidia"); 
        $aid = $this->getField("aid")->getValue(); 
        $name = $this->getField("name")->getValue(); 
        $image = $this->getField("image"); 
        $trophies = $mysidia->db->select("owned_adoptables", array("trophies"), "aid = '{$aid}'")->fetchColumn();
 
//Sale start
        $sale_lookup = $mysidia->db->select("adopt_stock", array("aid"), "aid='{$aid}'")->rowCount();
        $adoptshop_lookup = $mysidia->db->select("user_shops", array("usid"), "manager_id='{$mysidia->user->uid}' AND type='adopt'")->rowCount();
            if ($sale_lookup == NULL OR $sale_lookup == '0'){$sale_status = "not for sale"; $dont_sell = "checked"; $sell = " ";}
            else{$sale_status = "for sale"; $sell = "checked"; $dont_sell = " ";}
            if ($adoptshop_lookup == NULL OR $adoptshop_lookup == '0'){$sale_manage = "Sorry! You don't own an adopt shop. <a href='/shopcp'>Why not make one?</a>";}
            else{
                $shop_id = $mysidia->db->select("user_shops", array("usid"), "manager_id = '{$mysidia->user->uid}'")->fetchColumn();
                $sale_manage = "<div class='card' style='text-align:center;'>
            <div class='card-text'>
                <p><h2>This adopt is {$sale_status}.</h2></p>
                <form method='post' action='/myadopts/manage/{$aid}'>
                <p><div class='form-check form-check-inline'>
                    Price:<label class='form-check-label'>
                        <input type='number' class='form-control' value='1' min='1' max='100' name='price' id='price' style='width:70px;'>
                    </label>
                </div>
                <div class='form-check form-check-inline'>
                    Candy Price:<label class='form-check-label'>
                        <input type='number' class='form-control' value='0' min='0' max='100' name='gem_price' id='gem_price' style='width:70px;'>
                    </label>
                </div></p>
                <p><div class='form-check form-check-inline'>
            For Sale:<label class='form-check-label'>
                <input class='form-check-input' type='radio' name='sell' id='sell' value='yes' {$sell}>&nbsp&nbsp&nbsp Yes
            </label>
        </div>
        <div class='form-check form-check-inline'>
            <label class='form-check-label'>
                <input class='form-check-input' type='radio' name='sell' id='sell' value='no' {$dont_sell}>&nbsp&nbsp&nbsp No
            </label>
        </div></p>
                <p><button type='submit' class='btn btn-primary'>Save changes</button></p>
            </form>
            </div>
        </div>";}
       
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $price = $_REQUEST["price"];
            $gem_price = $_REQUEST["gem_price"];
            $on_sale = $_REQUEST["sell"];          
                if($on_sale == "no"){ //delete pet from stock
                    $mysidia->db->delete("adopt_stock", "aid = $aid");
                }
                else{
                    if ($sale_lookup == NULL){ //Create row if one does not exist
                        $mysidia->db->insert("adopt_stock", array("usid" => $shop_id, "aid" => $aid, "adopt_name" => $name, "price" => $price, "premium_price" => $gem_price));
                    }
                    else{ //Update row, since one already exists
                        $mysidia->db->update("adopt_stock", array("price" => $price, "premium_price" => $gem_price), "aid = '{$aid}'");
                    }
                }
        }
       
         //Sale end

        $document = $this->document;         
        $document->setTitle("Managing {$name}"); 
             
        $document->add($image); 
        $document->add(new Comment("<br><br>This page allows you to manage {$name}.  Click on an option below to change settings.<br> 
 <left>{$name} has {$trophies} Battle Trophies!</left><br>")); 
        $document->add(new Link("pet/profile/$aid", ' View Public Profile', TRUE)); 
        $document->add(new Image("templates/icons/add.gif")); 
        $document->add(new Link("levelup/click/{$aid}", " Level Up {$name}", TRUE)); 
        $document->add(new Image("templates/icons/stats.gif")); 
        $document->add(new Link("myadopts/stats/{$aid}", " Get Stats for {$name}", TRUE)); 
        $document->add(new Image("templates/icons/bbcodes.gif")); 
        $document->add(new Link("myadopts/bbcode/{$aid}", " Get BBCodes / HTML Codes for {$name}", TRUE)); 
        $document->add(new Image("templates/icons/title.gif")); 
        $document->add(new Link("myadopts/rename/{$aid}", " Rename {$name}", TRUE));  
        $document->add(new Image("templates/icons/trade.gif")); 
        $document->add(new Link("myadopts/trade/{$aid}", " Change Trade status for {$name}", TRUE));  
        $document->add(new Image("templates/icons/freeze.gif")); 
        $document->add(new Link("myadopts/freeze/{$aid}", " Freeze or Unfreeze {$name}", TRUE));  
        $document->add(new Image("templates/icons/delete.gif")); 
        $document->add(new Link("pound/pound/{$aid}", " Pound {$name}", TRUE));
		$document->add(new Image("templates/icons/add.gif"));
		$document->add(new Link("myadopts/raise/{$aid}", " Get More Clicks", TRUE)); 
		$document->add(new Comment("{$sale_manage}")); 
		
         
    }  
    public function stats(){
    	$mysidia = Registry::get("mysidia");
    	$adopt = $this->getField("adopt");		
    	$image = $this->getField("image");
    	$stmt = $this->getField("stmt")->get();

    	$document = $this->document;			
    	$document->setTitle($adopt->getName().$this->lang->stats);
    	$document->add($image);	
    	$document->add($adopt->getStats());					   				       
    	$document->addLangvar("<h2>{$adopt->getName()}'s Voters:</h2><br>{$this->lang->voters}<br><br>");	

    	$fields = new LinkedHashMap;
    	$fields->put(new String("username"), new String("getUsername"));
    	$fields->put(new String("date"), NULL);
    	$fields->put(new String("username::profile"), new String("getProfileImage"));
    	$fields->put(new String("username::message"), new String("getPMImage"));

    	$voterTable = new TableBuilder("voters", 500);
    	$voterTable->setAlign(new Align("center"));
    	$voterTable->buildHeaders("User", "Date Voted", "Profile", "PM");
    	$voterTable->setHelper(new UserTableHelper);
    	$voterTable->buildTable($stmt, $fields);
    	$document->add($voterTable);
    }

    public function bbcode(){
    	$mysidia = Registry::get("mysidia");
    	$adopt = $this->getField("adopt");			
    	$document = $this->document;
    	$document->setTitle($this->lang->bbcode.$adopt->getName()); 
    	$document->addLangvar($this->lang->bbcode_info);
    	$document->add(new Comment("<br>"));

    	$forumComment = new Comment("Forum BBCode: ");		
    	$forumComment->setUnderlined();
    	$forumcode = "[url={$mysidia->path->getAbsolute()}levelup/click/{$adopt->getAdoptID()}][img]{$mysidia->path->getAbsolute()}levelup/siggy/{$adopt->getAdoptID()}[/img][/url]";		
    	$forumArea = new TextArea("forumcode", $forumcode, 4, 50);
    	$forumArea->setReadOnly(TRUE);

    	$altComment = new Comment("Alternative BBCode: ");		
    	$altComment->setUnderlined();
    	$altcode = "[url={$mysidia->path->getAbsolute()}levelup/click/{$adopt->getAdoptID()}][img]{$mysidia->path->getAbsolute()}get/{$adopt->getAdoptID()}\"[/img][/url]";
    	$altArea = new TextArea("altcode", $altcode, 4, 50);
    	$altArea->setReadOnly(TRUE);

    	$htmlComment = new Comment("HTML BBCode: ");		
    	$htmlComment->setUnderlined();
    	$htmlcode = "<a href='{$mysidia->path->getAbsolute()}levelup/click/{$adopt->getAdoptID()}' target='_blank'>
<img src='{$mysidia->path->getAbsolute()}levelup/siggy/{$adopt->getAdoptID()}' border=0></a>";
    	$htmlArea = new TextArea("htmlcode", $htmlcode, 4, 50);
    	$htmlArea->setReadOnly(TRUE);

    	$document->add($forumComment);
    	$document->add($forumArea);
    	$document->add($altComment);
    	$document->add(($mysidia->settings->usealtbbcode == "yes")?$altArea:new Comment("The Admin has disabled Alt BBCode for this site."));
    	$document->add($htmlComment);
    	$document->add($htmlArea);
    }

    public function rename(){
    	$mysidia = Registry::get("mysidia");
    	$adopt = $this->getField("adopt");		
    	$image = $this->getField("image");		
    	$document = $this->document;

    	if($mysidia->input->post("submit")){
    		$document->setTitle($this->lang->rename_success_title);
    		$document->add($image);
    		$message = "<br>{$this->lang->rename_success}{$mysidia->input->post("adoptname")}. 
    		You can now manage {$mysidia->input->post("adoptname")} on the";
    		$document->addLangvar($message);
    		$document->add(new Link("myadopts/manage/{$adopt->getAdoptID()}", "My Adopts Page"));
    		return;
    	}

    	$document->setTitle($this->lang->rename.$adopt->getName());
    	$document->add($image);
    	$document->addLangvar("<br />{$this->lang->rename_default}{$adopt->getName()}{$this->lang->rename_details}<br />");

    	$renameForm = new FormBuilder("renameform", "", "post");
    	$renameForm->buildTextField("adoptname")->buildButton("Rename Adopt", "submit", "submit");
    	$document->add($renameForm);		   
    }

    public function updatebio(){
 
        $mysidia = Registry::get('mysidia');
        $adopt = $this->getField('adopt');
        $d = $this->document;
        $d->setTitle($this->lang->updatebio . $adopt->getName());
        $d->addLangvar('<form method="post"><textarea name="bio" rows="10" cols="50">'.$adopt->getBio().'</textarea><br><input type="submit" name="submit" value="Update Bio"></form>');
      
    }

    public function trade(){
    	$mysidia = Registry::get("mysidia");
    	$aid = $this->getField("aid")->getValue();		
    	$image = $this->getField("image");	
    	$message = $this->getField("message")->getValue();		
    	$document = $this->document;
    	$document->setTitle($this->lang->trade);
    	$document->add($image);
    	$document->addLangvar($message);
    }

    public function freeze(){
    	$mysidia = Registry::get("mysidia");
    	$adopt = $this->getField("adopt");		
    	$image = $this->getField("image");	
    	$message = $this->getField("message")->getValue();			
    	$document = $this->document;		
    	$document->setTitle($this->lang->freeze);	

    	if($mysidia->input->get("confirm") == "confirm"){
    		$document->addLangvar($message);
    		$document->add(new Link("myadopts/manage/{$adopt->getAdoptID()}", "My Adopts Page"));        
    	}	 
    	else{
    		$document->add($image);
    		$document->add(new Comment("<br /><b>{$adopt->getName()}'s Current Status: "));

    		if($adopt->isfrozen() == "yes"){			    
    			$document->add(new Image("templates/icons/freeze.gif", "Frozen"));
    			$document->add(new Comment("Frozen<br<br>"));
    			$document->add(new Comment($this->lang->freeze));
    			$document->add(new Image("templates/icons/unfreeze.gif", "Unfreeze"));
                $document->addLangvar("<form method='post''><input type='submit' name='confirm' value='Unfreeze {$adopt->getName()}' class='button'></form>");
    			//$document->add(new Link("myadopts/freeze/{$adopt->getAdoptID()}/confirm", "Unfreeze this Adoptable", TRUE));
    		}
    		else{
    			$document->add(new Image("templates/icons/unfreeze.gif", "Not Frozen"));
    			$document->add(new Comment("Not Frozen<br><br>"));
    			$document->add(new Comment($this->lang->freeze));
    			$document->add(new Image("templates/icons/freeze.gif", "Greeze"));
                $document->addLangvar("<form method='post'><input type='submit' name='confirm' value='Freeze {$adopt->getName()}' class='button'></form>");
    			//$document->add(new Link("myadopts/freeze/{$adopt->getAdoptID()}/confirm", "Freeze this Adoptable", TRUE));
    		}
    		$document->add(new Comment("<br><br>"));
    		$document->add(new Image("templates/icons/warning.gif"));
    		$document->addLangvar($this->lang->freeze_warning);
    	}
    }

    public function release(){
        $document = $this->document;        
        $document->setTitle($this->lang->released);
        $document->addLangvar($this->lang->pet_released);  
    }
	
	public function raise(){
 
        $mysidia = Registry::get('mysidia');
        $adopt = $this->getField('adopt');
        $d = $this->document;
        $d->setTitle('Advertise Pet Raising');
		$d->addLangvar('You can advertise your pet to get more clicks. It costs 300 beads as a base price, then 20 beads for every click you want added. Notice, there are absolutely no refunds, for any reason. Once your pet earns this many clicks, they will no longer be advertised. But will remain in advertisement until desired clicks are achieved. This number is added onto the total number of clicks, not the total clicks itself.');
        if($adopt->getTotalClicks() >= $adopt->advertclicktotal){
			$d->addLangvar('<center><form method="post"><input type="number" min="0" max="100" name="number" value="0" /><br><input type="submit" name="submit" value="Advertise"></form></center>');
		}
		else{
			$remaining = $adopt->advertclicktotal - $adopt->getTotalClicks();
			$d->addLangvar('<div style="color:red;text-align:center;">Your pet is already being advertised until they receive another '.$remaining.' clicks.</div>');
		}
      
    }
	
	
}