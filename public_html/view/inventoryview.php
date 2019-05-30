<?php

use Resource\Collection\LinkedList;

class InventoryView extends View
{

    public function index()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle($mysidia->lang->inventory);

        $inventory = $this->getField("inventory");

        $items = $inventory->getAll();

        while ($row = $items->fetch(PDO::FETCH_OBJ, PDO::FETCH_ORI_NEXT)) {
            $itemsArray[] = $row;
            $categoryArray[] = $row->category;
        }
        $categories = array_unique($categoryArray);

        $stats = $inventory->getStats()->fetchAll(PDO::FETCH_CLASS, 'Item');
        $statsArray = [];
        foreach ($stats as $s) {
            $statsArray[$s->id] = $s;
        }
        ?>

        <div id="tabs" class="c-tabs no-js">

        <?php

        foreach ($categories as $tab) {
            $document->add(new Comment("<a href='#' class='c-tabs-nav__link'>$tab</a>", FALSE));
        }

        $document->add(new Comment(" <style>
                .sc_item {
                  display: inline-table;
                  padding: 5px;
                  text-align: center;
                  font-family: 'Trebuchet MS', Helvetica, sans-serif;
                  font-size: 14px;
                  margin-bottom: 3px;
                  width: 120px;
              }
              .s_panel {
                  border-radius: 2px;
                  border: 1px solid #CCC;
                  background-color: #FBFDF2;  
              }
          </style> 

          <div class='c-tab is-active'>
            <div class='c-tab__content'>", FALSE));

        //   $iids = $inventory->getiids();
        //   for($i = 0; $i < $iids->length(); $i++){
        //     $item = $inventory->getitem($iids[$i]);

        $total = count($itemsArray);
        for($i=0;$i<$total;$i++) {

            if ($i != 0 AND ($itemsArray[$i]->category != $itemsArray[$i-1]->category))
            {
                $document->add(new Comment('</div></div><div class="c-tab"><div class="c-tab__content">'));
             }
                    

            $item = $itemsArray[$i];

            $usage = $this->item_functions($item);

            if (isset($statsArray[$item->id])){
                $usage .= '<br><b>stat effects</b>: ';
                $s = $statsArray[$item->id];
                $petstats = ['happiness', 'closeness', 'hunger', 'thirst'];
                foreach ($petstats as $ps) {
                    if ($s->$ps != 0) {
                        $usage .= '<br>'. ucwords($ps) . ': ' .$s->$ps;
                    }
                }
            }

            # Rendering items now
            if($item->stat_mod != "none"){$battle_use = "<br>+{$item->value} {$item->stat_mod}";}
            else{$battle_use = " ";}
            
            //Alignment images!
            if($item->element == "void"){$element = "<img src='http://atrocity.mysidiahost.com/picuploads/alignments/voidelement1.png' style='height:30px; width:auto;'><br/>";}
            elseif($item->element == "sky"){$element = "<img src='http://atrocity.mysidiahost.com/picuploads/alignments/skyelement1.png' style='height:30px; width:auto;'><br/>";}
            elseif($item->element == "arcane"){$element = "<img src='http://atrocity.mysidiahost.com/picuploads/alignments/arcaneelement1.png' style='height:30px; width:auto;'><br/>";}
            elseif($item->element == "life"){$element = "<img src='http://atrocity.mysidiahost.com/picuploads/alignments/lifeelement1.png' style='height:30px; width:auto;'><br/>";}
            else{$element = " ";}
            //Rarity images!
            if($item->rarity == "Common"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/common.png'/><br/>";}
            elseif($item->rarity == "Uncommon"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/uncommon.png'/><br/>";}
            elseif($item->rarity == "Rare"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/Rare.png'/><br/>";}
            elseif($item->rarity == "Super rare"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/superrare.png'/><br/>";}
            elseif($item->rarity == "Holiday"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/Holiday.png'/><br/>";}
            elseif($item->rarity == "Event"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/Event.png'/><br/>";}
            elseif($item->rarity == "Special"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/special.png'/><br/>";}
            elseif($item->rarity == "Promo"){$rarity = "<img src='http://atrocity.mysidiahost.com/picuploads/Items/promo.png'/><br/>";}
            else{$rarity = " ";}
            
            $document->add(new Comment("
                <div class=\"s_panel sc_item\">
                    <img rel=\"tooltip\" title=\"{$rarity}{$item->description} <em>{$usage}{$battle_use}<br></em>\" src=\"{$item->imageurl}\"/><br/>{$element}
                    <b>{$item->itemname}</b><br> Own &times;{$item->quantity}<br/>", FALSE));

            # If item is consumable, add use button
            if ($item->consumable == "yes") {
                $useForm = new FormBuilder("useform", "inventory/uses", "post");
                $useForm->setLineBreak(FALSE);
                $useForm->buildPasswordField("hidden", "action", "uses")
                    ->buildPasswordField("hidden", "itemname", $item->itemname)
                    ->buildButton("Use", "use", "use");
                $document->add($useForm);
            }
            
            # Add sellback button so long as the item is not a key item
            $sellback = $item->price / 2;
           
            if ($item->category != "Key Items") {
                $sellForm = new FormBuilder("sellform", "inventory/sell", "post");
                $sellForm->setLineBreak(FALSE);
                $sellForm->buildPasswordField("hidden", "action", "sell")
                    ->buildPasswordField("hidden", "itemname", $item->itemname)
					->buildPasswordField("hidden", "priced", $sellback);

                $quantity = new TextField("quantity");
                $quantity->setSize(3);
                $quantity->setMaxLength(3);
                $quantity->setLineBreak(FALSE);

                $sell = new Button("Sell for {$sellback} each", "sell", "sell");
                $sell->setLineBreak(FALSE);

                $sellForm->add($quantity);
                $sellForm->add($sell);
                $document->add($sellForm);
            }

            $document->add(new Comment("</div>", FALSE));

        } # END item for loop

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

    } # END index function  			

    public function uses()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if ($mysidia->input->post("aid")) {
            $message = (string)$this->getField("message");
            $document->setTitle($mysidia->lang->global_action_complete);
            $document->addLangvar($message);
            return;
        }

        $item = $this->getField('item');
        $statmessage = [];
        foreach (['hunger','thirst','closeness','happiness'] as $stat) {
            if ($item->$stat != 0) {
                $statmessage[] = ucwords($stat).': '.$item->$stat;
            }
        }
        if (!empty($statmessage)){
            $statmessage = implode('<br>',$statmessage);
            $statmessage = '<br><b>stat effects</b>:<br>'.$statmessage;
        }
        else{
            $statmessage = null;
        }
        $document->addLangvar('Using <u>'.$item->itemname .'</u>.<i><br>'.$item->description.'<br>'.$this->item_functions($item).$statmessage.'</i><br><br>');

        $petMap = $this->getField("petMap");
        $document->setTitle($mysidia->lang->select_title);
        $document->addLangvar($mysidia->lang->select);
        $chooseFrom = new Form("chooseform", "uses", "post");

        $adoptable = new DropdownList("aid");
        $adoptable->add(new Option("None Selected", "none"));
        if ($petMap->size() > 0) {
            $iterator = $petMap->iterator();
            while ($iterator->hasNext()) {
                $adopt = $iterator->nextEntry();
                $adoptable->add(new Option($adopt->getValue(), $adopt->getKey()));
            }
        }
        $chooseFrom->add($adoptable);

        $chooseFrom->add(new PasswordField("hidden", "itemname", $mysidia->input->post("itemname")));
        $chooseFrom->add(new PasswordField("hidden", "validation", "valid"));
        $chooseFrom->add(new Button("Choose this Adopt", "submit", "submit"));
        $document->add($chooseFrom);
    }

    public function sell()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle($this->lang->global_transaction_complete);
        $document->addLangvar("{$this->lang->sell}{$mysidia->input->post("quantity")} {$mysidia->input->post("itemname")} {$this->lang->sell2}");
    }

    public function toss()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        if ($mysidia->input->get("confirm")) {
            $document->setTitle($this->lang->global_action_complete);
            $document->addLangvar("{$this->lang->toss}{$mysidia->input->post("itemname")}{$this->lang->toss2}");
            return;
        }

        $document->setTitle($this->lang->toss_confirm);
        $document->addLangvar($this->lang->toss_warning);

        $confirmForm = new FormBuilder("confirmform", "toss/confirm", "post");
        $confirmForm->buildPasswordField("hidden", "action", "toss")
            ->buildPasswordField("hidden", "itemname", $mysidia->input->post("itemname"))
            ->buildButton("Please Toss", "confirm", "confirm");
        $document->add($confirmForm);
    }

    public function alchemy()
    {
        $mysidia = Registry::get("mysidia");
        $document = $this->document;

        if ($mysidia->input->post("iid") and $mysidia->input->post("iid2")) {
            $alchemy = $this->getField("alchemy");
            $newitem = $alchemy->getNewItem()->itemname;
            $document->setTitle($this->lang->alchemy_success);
            $document->addLangvar($this->lang->alchemy_newitem . $newitem . $this->lang->alchemy_newitem2);
            return;
        }

        $document->setTitle($this->lang->alchemy_title);
        $document->add(new Comment("<center><img src=http://i65.tinypic.com/33o5oud.jpg'' /></center>"));
        $document->add(new Comment("<b>Laric Says:  </b>", FALSE));
        $document->addLangvar($this->lang->alchemy);
        $itemMap = $this->getField("itemMap");
        $settings = $this->getField("settings");
        $alchemyFrom = new Form("alchemyform", "alchemy", "post");
        $alchemyFrom->add(new Comment("<b>Cost of performing Alchemy: {$settings->cost} {$mysidia->settings->cost}</b><br>"));

        $alchemyFrom->add(new Comment($mysidia->lang->alchemy_choose));
        $items = new DropdownList("iid");
        $items->add(new Option("None Selected", "none"));
        if ($itemMap->size() > 0) {
            $iterator = $itemMap->iterator();
            while ($iterator->hasNext()) {
                $item = $iterator->nextEntry();
                $items->add(new Option($item->getValue(), $item->getKey()));
            }
        }
        $alchemyFrom->add($items);

        $alchemyFrom->add(new Comment($mysidia->lang->alchemy_choose2));
        $items2 = new DropdownList("iid2");
        $items2->add(new Option("None Selected", "none"));
        if ($itemMap->size() > 0) {
            $iterator = $itemMap->iterator();
            while ($iterator->hasNext()) {
                $item2 = $iterator->nextEntry();
                $items2->add(new Option($item2->getValue(), $item2->getKey()));
            }
        }
        $alchemyFrom->add($items2);
		
		$alchemyFrom->add(new Comment($mysidia->lang->alchemy_choose3));
        $items3 = new DropdownList("iid3");
        $items3->add(new Option("0", "none"));
        if ($itemMap->size() > 0) {
            $iterator = $itemMap->iterator();
            while ($iterator->hasNext()) {
                $item3 = $iterator->nextEntry();
                $items3->add(new Option($item3->getValue(), $item3->getKey()));
            }
        }
        $alchemyFrom->add($items3);
		
		$alchemyFrom->add(new Comment($mysidia->lang->alchemy_choose4));
        $items4 = new DropdownList("iid4");
        $items4->add(new Option("0", "none"));
        if ($itemMap->size() > 0) {
            $iterator = $itemMap->iterator();
            while ($iterator->hasNext()) {
                $item4 = $iterator->nextEntry();
                $items4->add(new Option($item4->getValue(), $item4->getKey()));
            }
        }
        $alchemyFrom->add($items4);
		
		$alchemyFrom->add(new Comment($mysidia->lang->alchemy_choose5));
        $items5 = new DropdownList("iid5");
        $items5->add(new Option("0", "none"));
        if ($itemMap->size() > 0) {
            $iterator = $itemMap->iterator();
            while ($iterator->hasNext()) {
                $item5 = $iterator->nextEntry();
                $items5->add(new Option($item5->getValue(), $item5->getKey()));
            }
        }
        $alchemyFrom->add($items5);
		
		
		
        $alchemyFrom->add(new Button("Mix them together!", "submit", "submit"));
        $document->add($alchemyFrom);
    }

    private function item_functions($item) {
        # Descriptions of the item functions
            switch ($item->function) {
                case "Click1":
                    $usage = "<br/><b>use:</b> Feed a pet to give them {$item->value} EXP.";
                    break;
                case "Click2":
                    $usage = "<br/><b>use:</b> Feed a pet to set their EXP to {$item->value}.";
                    break;
                case "Click3":
                    $usage = "<br/><b>use:</b> Resets EXP earned today to 0.";
                    break;
                case "Level1":
                    $usage = "<br/><b>use:</b> Raises the Level of your pet by {$item->value}.";
                    break;
                case "Level2":
                    $usage = "<br/><b>use:</b> Sets the Level of your pet to {$item->value}.";
                    break;
                case "Level3":
                    $usage = "<br/><b>use:</b> Makes your pet Level 0 again!";
                    break;
                case "Gender":
                    $usage = "<br/><b>use:</b> Swaps the gender of your pet to its opposite!";
                    break;
                case "Key":
                    $usage = "<br><b>Use:</b> Takes up space";
                    break;
                case "Valuable":
                    $usage = "<br><b>Use</b>:This Item is worth something!!";
                    break;
                case "Recipe":
                    $usage = "<br><b>Use</b>:Needed for alchemy and crafting";
                    break;
                default;
                    $usage = "";
                    break;
            }  # End item function descriptions        
            return $usage;
    }
}