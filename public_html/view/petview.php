<?php 
 
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;
 
class PetView extends View{ 

    public function profile(){ 
        $mysidia = Registry::get('mysidia'); 
        $d = $this->document; 
        $adopt = $this->getField('adopt');
        $aid = $adopt->aid;
        $equip_check = $mysidia->db->select("equips", array("aid"), "aid='{$aid}'")->rowCount(); //if the pet isn't here already, add them
        if($equip_check == 0 OR $equip_check == NULL){$mysidia->db->insert("equips", array("aid" => $aid));}
        $isdead = $adopt->isdead; 
        $name = $adopt->getName();
        $minipet = $mysidia->db->select("items", array(), "itemname='{$adopt->getCompanion()}'")->fetchObject();
        if ($adopt->isFrozen() == 'yes') {$freeze = 'Unfreeze'; $play = 'Frozen';}
        else{$freeze = 'Freeze'; $play = "<a href='/levelup/click/{$adopt->aid}'>Play</a>";}
        
        if ($mysidia->user->username == $adopt->getOwner()){ 
            $manage_buttons = "<a href='/myadopts/manage/{$adopt->aid}'>Manage</a> | {$play} | <a href='/myadopts/bbcode/{$adopt->aid}'>Codes</a> | <a href='/myadopts/freeze/{$adopt->aid}'>$freeze</a> | <a href='/pound/pound/{$adopt->aid}'>Pound $name</a> | <a href='/pet/release/{$adopt->aid}'>Release $name</a>";
        }
        
        if($adopt->getCompanion() != "nocompanion"){
            $minipet_img = "{$minipet->imageurl}";
        }
        else{$minipet_img = "/picuploads/nothingset1.png";}
        
        $title = 'Viewing '; 
        if ($isdead) { 
            $title = '<img src="/picuploads/dead.png"> Here Lies '; 
            $name .= ' <img src="/picuploads/dead.png">'; 
            $adopt_image = "
            <div style='background:url({$mysidia->path->getAbsolute()}picuploads/paw.png); position:relative; height:248px; width:268px;'>
                <div style='background:url({$mysidia->path->getAbsolute()}picuploads/wreath.png);height:248px; width:268px;position:absolute;z-index:30;'></div>
                <div style='position:absolute;z-index:2;left:50px;bottom:10px'><img src='{$adopt->imageurl}'></div>
            </div>";
        } 
        else{ 
            $adopt_image = "<img src='{$adopt->getImage()}'>";
            if ($adopt->getOwner() == 'SYSTEM') { 
                $title = '<img src="/picuploads/shackle.png"> ' . $title; 
                $name .= '<img src="/picuploads/shackle.png">'; 
            } 
        } 
        if ($adopt->getOwner() == $mysidia->user->username) $title = 'Managing '; 
        $d->setTitle(' '); 
        
        if ($isdead == false) { 
            if ($adopt->getOwner() == 'SYSTEM') { 
                $ownership = "Owned by <a href='/profile/view/POUND'>The Pound</a><br><br>"; 
            }
            else{ 
                $ownership = "Owned by <a href='/profile/view/{$adopt->getOwner()}'>{$adopt->getOwner()}</a><br><br>"; 
            } 
        } 
        
        //handle equip forms!
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	        $equipped_weapon = $_REQUEST["my_weapon"];
	        $equipped_shield = $_REQUEST["my_shield"];
	        $equipped_hat = $_REQUEST["my_hat"];
	        $equipped_chest = $_REQUEST["my_chest"];
	        $equipped_pants = $_REQUEST["my_pants"];
	        $equipped_feet = $_REQUEST["my_feet"];
	        $equipped_acc = $_REQUEST["my_acc"];
	        
	        $chosen_item = $_REQUEST["my_item"];
	        
	        $what = $_REQUEST["action"];
	        
	        switch($what){
	            case "weapon":
	                $mysidia->db->update("equips", array("weapon" => $equipped_weapon), "aid = '{$aid}'");
	                break;
	            case "shield":
	                $mysidia->db->update("equips", array("shield" => $equipped_shield), "aid = '{$aid}'");
	                break;
	           case "hat":
	                $mysidia->db->update("equips", array("hat" => $equipped_hat), "aid = '{$aid}'");
	                break;
	           case "chest":
	                $mysidia->db->update("equips", array("chest" => $equipped_chest), "aid = '{$aid}'");
	                break;
	           case "pants":
	                $mysidia->db->update("equips", array("pants" => $equipped_pants), "aid = '{$aid}'");
	                break;
	           case "feet":
	                $mysidia->db->update("equips", array("feet" => $equipped_feet), "aid = '{$aid}'");
	                break;
	           case "accessory":
	                $mysidia->db->update("equips", array("accessory" => $equipped_acc), "aid = '{$aid}'");
	                break;
	           case "fav_item":
	                $mysidia->db->update("owned_adoptables", array("favitem" => $chosen_item), "aid = '{$aid}'");
	                break;
	        }
	    }
        
        //new profile start!
        $d->add(new Comment( 
            "<style>
                .grid-container {
                    display: grid;
                    grid-template-columns: auto auto;
                    padding: 10px;
                }
                .grid-item {
                    background-color: rgba(255, 255, 255, 0.8);
                    border: 4px solid #7f7f7f;
                    padding: 20px;
                    text-align: center;
                }
            </style>"));
        $item_find = $mysidia->db->select("owned_adoptables", array("favitem"), "aid='{$aid}'")->fetchColumn();
        if($item_find == "noitem" or $item_find == NULL){
            $item_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $item_info = $mysidia->db->select("items", array(), "itemname='{$item_find}'")->fetchObject();
            $item_image = "<img src='{$item_info->imageurl}' rel='tooltip' title='{$item_info->itemname}<hr>{$item_info->description}'>";
        }
        $d->add(new Comment( 
            "<div class='grid-container'>
                <div class='grid-item'>
                    <h2>{$title}{$name}</h2>{$ownership}<hr>
                    <p>{$adopt_image}</p>
                    {$manage_buttons}
                    <div class='grid-container' style='grid-column-gap:20px;'>
                        <div class='grid-item'>Companion<hr><img src='{$minipet_img}'></div>"));
        $d->add(new Comment("
            <div class='grid-item'>
                Favorite Item<hr>
                {$item_image}"));
        if ($adopt->getOwner() == $mysidia->user->username){
            //itemform!
        $item_list = $mysidia->db->select("inventory", array(), "owner ='{$mysidia->user->username}' ORDER BY itemname");

        $d->addLangvar("
	       <form method='post' action=''>
		        <select name='my_item' id='my_item'>
			        <option value='noitem'>None Selected</option>
        ");
        while($item = $item_list->fetchObject()){
	        $d->add(new Comment("<option value='{$item->itemname}'>{$item->itemname}</option>"));
        }
        
        $d->addLangvar("
		    <br><br>
		        <input type='hidden' name='action' value='fav_item'>
		        <input type='submit' value='Equip'>
	        </form>
        ");
        }
        //itemform end!
                    $d->add(new Comment("</div></div></div><div class='grid-item'>"));
        
        //tabs start
        $d->add(new Comment('<div id="tabs" class="c-tabs no-js"><div class="c-tabs-nav">',false));
        if ($adopt->class != 'Colorful') { 
            $d->addLangVar("<a href='#' class='c-tabs-nav__link'>Bio</a><a href='#' class='c-tabs-nav__link'>About</a>"); 
            $d->addLangVar("</div><div class='c-tab is-active'><div class='c-tab__content'>{$adopt->getBio()}</div></div><div class='c-tab'> 
                <div class='c-tab__content'>{$adopt->getDescription()}</div></div>"); 
        }
        else{ 
            $d->addLangVar("<a href='#' class='c-tabs-nav__link'>Bio</a><a href='#' class='c-tabs-nav__link'>Skills</a><a href='#' class='c-tabs-nav__link'>Lineage</a><a href='#' class='c-tabs-nav__link'>Offspring</a><a href='#' class='c-tabs-nav__link'>Stats</a>"); 
            $d->addLangVar("</div><div class='c-tab is-active'> 
                <div class='c-tab__content'>"); 
            if ($mysidia->user->username == $adopt->getOwner()){ 
                $d->addLangvar('<a href="/myadopts/updatebio/'.$adopt->aid.'">Click Here to Update Bio</a><br><br>'); 
            } 
            $d->addLangvar("{$adopt->getBio()}</div></div> 
                <div class='c-tab'><div class='c-tab__content'><b>Battle Trophies:</b> {$adopt->trophies}<br><br>
                    <b>Sense:</b> {$adopt->sense}<br> 
                    <b>Speed:</b> {$adopt->speed}<br> 
                    <b>Strength:</b> {$adopt->strength}<br> 
                    <b>Stamina:</b> {$adopt->stamina}<br></div></div>"); 

            // Lineage 
            include('pedigree.php'); 

            $offspring = []; $parent = 'sire_id'; 
            if ($adopt->getGender() == 'f') $parent = 'dam_id'; 
            $offspring = $mysidia->db->select('owned_adoptables', [], "$parent = {$adopt->aid}")->fetchAll(PDO::FETCH_CLASS,'OwnedAdoptable'); 

            $d->addLangVar("<div class='c-tab'><div class='c-tab__content'><b>Offspring</b>"); 
            if (count($offspring) == 0) $d->addLangVar('<hr>None.'); 
            foreach ($offspring as $baby) { 
                $d->addLangVar("<hr><a href='/pet/profile/{$baby->aid}'>{$baby->name}<br><img src='{$baby->getImage()}'></a>"); 
            } 
             
            $d->addLangVar('</div></div>'); 

            $d->addLangVar("<div class='c-tab'><div class='c-tab__content'>"); 
            $d->addLangvar("<b>Personality:</b> {$adopt->personality()}<br> 
                <b>Happiness:</b> {$adopt->happiness}/50<br> 
                <b>Hunger:</b> {$adopt->hunger}/50<br> 
                <b>Thirst:</b> {$adopt->thirst}/50<br> 
                <b>Closeness:</b> {$adopt->closeness}/50<br> 
                "); 
                 
            $d->add($adopt->getStats()); 
            if ($adopt->breeder != null) { 
                $d->addLangvar("<br><br><b>Breeder:</b> <a href='/profile/view/{$adopt->breeder}'>{$adopt->breeder}</a>"); 
                 
            }
            $d->addLangvar("</div></div>");
            //tabs end
        }
        
        $equip_info = $mysidia->db->select("equips", array(), "aid='{$aid}'")->fetchObject();
        $weapon_info = $mysidia->db->select("items", array(), "itemname='{$equip_info->weapon}'")->fetchObject();
        $shield_info = $mysidia->db->select("items", array(), "itemname='{$equip_info->shield}'")->fetchObject();
        $hat_info = $mysidia->db->select("items", array(), "itemname='{$equip_info->hat}'")->fetchObject();
        $chest_info = $mysidia->db->select("items", array(), "itemname='{$equip_info->chest}'")->fetchObject();
        $pants_info = $mysidia->db->select("items", array(), "itemname='{$equip_info->pants}'")->fetchObject();
        $feet_info = $mysidia->db->select("items", array(), "itemname='{$equip_info->feet}'")->fetchObject();
        $acc_info = $mysidia->db->select("items", array(), "itemname='{$equip_info->accessory}'")->fetchObject();
        
        //equip images!
        if($equip_info->weapon == "none"){
            $weapon_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $weapon_image = "<img src='{$weapon_info->imageurl}' rel='tooltip' title='{$equip_info->weapon}</br>(+{$weapon_info->value} {$weapon_info->stat_mod})'>";
        }
        
        if($equip_info->shield == "none"){
            $shield_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $shield_image = "<img src='{$shield_info->imageurl}' rel='tooltip' title='{$equip_info->shield}</br>(+{$shield_info->value} {$shield_info->stat_mod})'>";
        }
        
        if($equip_info->hat == "none"){
            $hat_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $hat_image = "<img src='{$hat_info->imageurl}' rel='tooltip' title='{$equip_info->hat}</br>(+{$hat_info->value} {$hat_info->stat_mod})'>";
        }
        
        if($equip_info->chest == "none"){
            $chest_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $chest_image = "<img src='{$chest_info->imageurl}' rel='tooltip' title='{$equip_info->chest}</br>(+{$chest_info->value} {$chest_info->stat_mod})'>";
        }
        
        if($equip_info->pants == "none"){
            $pants_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $pants_image = "<img src='{$pants_info->imageurl}' rel='tooltip' title='{$equip_info->pants}</br>(+{$pants_info->value} {$pants_info->stat_mod})'>";
        }
        
        if($equip_info->feet == "none"){
            $feet_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $feet_image = "<img src='{$feet_info->imageurl}' rel='tooltip' title='{$equip_info->feet}</br>(+{$feet_info->value} {$feet_info->stat_mod})'>";
        }
        
        if($equip_info->accessory == "none"){
            $acc_image = "<img src='/picuploads/nothingset1.png'>";
        }
        else{
            $acc_image = "<img src='{$acc_info->imageurl}' rel='tooltip' title='{$equip_info->accessory}</br>(+{$acc_info->value} {$acc_info->stat_mod})'>";
        }
        //images end!
        
        $d->add(new Comment( "</div></div></div><p></p>"));
        //now for equips!
        $d->add(new Comment("
        <div class='grid-container'>
            <div class='grid-item'><h2>Weapons</h2><hr>
                <div class='grid-container' style='grid-column-gap:20px;'>
                    <div class='grid-item'>
                        Main Weapon<hr>
                        {$weapon_image}"));
                        if ($adopt->getOwner() == $mysidia->user->username){
                            //weaponform!
                            $weapon_list = $mysidia->db->select("inventory", array(), "owner = '{$mysidia->user->username}' AND status = 'Available' AND category = 'Weapon'");

                            $d->addLangvar("
	                            <form method='post' action=''>
		                            <select name='my_weapon' id='my_weapon'>
			                            <option value='none'>None Selected</option>
                            ");
                            while($weapon = $weapon_list->fetchObject()){
	                            $d->add(new Comment("<option value='{$weapon->itemname}'>{$weapon->itemname}</option>"));
                            }
        
                             $d->add(new Comment("
		                        <br><br>
		                        <input type='hidden' name='action' value='weapon'>
		                        <input type='submit' value='Equip'>
	                            </form>
                            "));
                        //weaponform end!
                        }
                    $d->add(new Comment("</div>
                    <div class='grid-item'>
                        Shield<hr>
                        {$shield_image}"));
                        if ($adopt->getOwner() == $mysidia->user->username){
                            //shieldform!
                            $shield_list = $mysidia->db->select("inventory", array(), "owner = '{$mysidia->user->username}' AND status = 'Available' AND category = 'Shield'");

                            $d->addLangvar("
	                            <form method='post' action=''>
		                            <select name='my_shield' id='my_shield'>
			                            <option value='none'>None Selected</option>
                            ");
                            while($shield = $shield_list->fetchObject()){
	                            $d->add(new Comment("<option value='{$shield->itemname}'>{$shield->itemname}</option>"));
                            }
        
                            $d->addLangvar("
		                        <br><br>
		                        <input type='hidden' name='action' value='shield'>
		                        <input type='submit' value='Equip'>
	                            </form>
                            ");
                        //shieldform end!
                        }
                    $d->add(new Comment("</div>
                        </div>
                        </div>
                        <div class='grid-item'>
                            <h2>Armor</h2><hr>
                            <div class='grid-container' style='grid-gap:20px; grid-template-columns: auto auto auto;'>
                                <div class='grid-item'>
                                    Helmet/Hat<hr>
                                    {$hat_image}"));
                    if ($adopt->getOwner() == $mysidia->user->username){
                        //hatform!
                            $hat_list = $mysidia->db->select("inventory", array(), "owner = '{$mysidia->user->username}' AND status = 'Available' AND category = 'Helmet'");

                            $d->addLangvar("
	                            <form method='post' action=''>
		                            <select name='my_hat' id='my_hat'>
			                            <option value='none'>None Selected</option>
                            ");
                            while($hat = $hat_list->fetchObject()){
	                            $d->add(new Comment("<option value='{$hat->itemname}'>{$hat->itemname}</option>"));
                            }
        
                            $d->addLangvar("
		                        <br><br>
		                        <input type='hidden' name='action' value='hat'>
		                        <input type='submit' value='Equip'>
	                            </form>
                            ");
                        //hatform end!
                    }
                        $d->add(new Comment("</div>
                            <div class='grid-item'>
                                    Chest<hr>
                                    {$chest_image}"));
                        if ($adopt->getOwner() == $mysidia->user->username){
                            //chestform!
                            $chest_list = $mysidia->db->select("inventory", array(), "owner = '{$mysidia->user->username}' AND status = 'Available' AND category = 'Chest'");

                            $d->addLangvar("
	                            <form method='post' action=''>
		                            <select name='my_chest' id='my_chest'>
			                            <option value='none'>None Selected</option>
                            ");
                            while($chest = $chest_list->fetchObject()){
	                            $d->add(new Comment("<option value='{$chest->itemname}'>{$chest->itemname}</option>"));
                            }
        
                            $d->addLangvar("
		                        <br><br>
		                        <input type='hidden' name='action' value='chest'>
		                        <input type='submit' value='Equip'>
	                            </form>
                            ");
                        //chestform end!
                        }
                        $d->add(new Comment("</div>
                            <div class='grid-item'>
                                    Pants<hr>
                                    {$pants_image}"));
                        if ($adopt->getOwner() == $mysidia->user->username){
                            //pantsform!
                            $pants_list = $mysidia->db->select("inventory", array(), "owner = '{$mysidia->user->username}' AND status = 'Available' AND category = 'Pants'");

                            $d->addLangvar("
	                            <form method='post' action=''>
		                            <select name='my_pants' id='my_pants'>
			                            <option value='none'>None Selected</option>
                            ");
                            while($pants = $pants_list->fetchObject()){
	                            $d->add(new Comment("<option value='{$pants->itemname}'>{$pants->itemname}</option>"));
                            }
        
                            $d->addLangvar("
		                        <br><br>
		                        <input type='hidden' name='action' value='pants'>
		                        <input type='submit' value='Equip'>
	                            </form>
                            ");
                        //pantsform end!
                        }
                        
                        $d->add(new Comment("</div>
                            <div class='grid-item'>
                                    Feet<hr>
                                    {$feet_image}"));
                        if ($adopt->getOwner() == $mysidia->user->username){
                            //feetform!
                            $feet_list = $mysidia->db->select("inventory", array(), "owner = '{$mysidia->user->username}' AND status = 'Available' AND category = 'Feet'");

                            $d->addLangvar("
	                            <form method='post' action=''>
		                            <select name='my_feet' id='my_feet'>
			                            <option value='none'>None Selected</option>
                            ");
                            while($feet = $feet_list->fetchObject()){
	                            $d->add(new Comment("<option value='{$feet->itemname}'>{$feet->itemname}</option>"));
                            }
        
                            $d->addLangvar("
		                        <br><br>
		                        <input type='hidden' name='action' value='feet'>
		                        <input type='submit' value='Equip'>
	                            </form>
                            ");
                        //feetform end!
                        }
                        
                        $d->add(new Comment("</div>
                            <div class='grid-item'>
                                    Accessory<hr>
                                    {$acc_image}"));
                        if ($adopt->getOwner() == $mysidia->user->username){
                            //accform!
                            $acc_list = $mysidia->db->select("inventory", array(), "owner = '{$mysidia->user->username}' AND status = 'Available' AND category = 'Accessory'");

                            $d->addLangvar("
	                            <form method='post' action=''>
		                            <select name='my_acc' id='my_acc'>
			                            <option value='none'>None Selected</option>
                            ");
                            while($acc = $acc_list->fetchObject()){
	                            $d->add(new Comment("<option value='{$acc->itemname}'>{$acc->itemname}</option>"));
                            }
        
                            $d->addLangvar("
		                        <br><br>
		                        <input type='hidden' name='action' value='accessory'>
		                        <input type='submit' value='Equip'>
	                            </form>
                            ");
                        //accform end!
                        }
                        
                        $d->add(new Comment("</div></div></div></div>"));
        
        //new profile end

        $d->add(new Comment( 
            "<script src='/js/otherTabs.js'></script> 
            <script> 
                var myTabs = tabs({ 
                    el: '#tabs', 
                    tabNavigationLinks: '.c-tabs-nav__link', 
                    tabContentContainers: '.c-tab' 
                }); 

                myTabs.init(); 
            </script>", FALSE)); 
    } 

    public function release(){ 
        $d = $this->document; 
        $adopt = $this->getField('adopt'); 
        $d->setTitle($this->lang->release); 
        $d->addLangvar($adopt->getName().'<br>'.$adopt->getImage('gui').'<br><br>'); 
        $d->addLangvar($this->lang->release_warning); 
        $d->addLangvar('<br><br><form method="post" action="/myadopts/release/'.$adopt->aid.'"><label for="password">Type your password below to confirm:</label><br><input type="password" name="password"><br><input type="submit" value="Release Pet?"></form>'); 
    } 

    public function bio(){ 
     
        $d = $this->document; 
        $adopt = $this->getField('adopt'); 
         
        $d->setTitle('Update Bio'); 
        $d->addLangvar($adopt->getName().'<br>'.$adopt->getImage('gui').'<br><br>'); 
        $d->addLangvar('<form method="post"><textarea name="bio">'.$adopt->bio.'</textarea><br><input type="submit" value="Update Bio" name="submit"></form>'); 
           
    } 
     

} 