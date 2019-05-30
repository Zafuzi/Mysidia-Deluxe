 <?php
class TrainView extends View{
    
    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document; 
        $document->setTitle("Stat Training");
                    $document->add(new Comment("Welcome to the Gym. People from all across the land come here to train their pets and prep them for battle.<br>
                    <center><b>Each training session costs 5000 Beads.</b></center><br><br>
                    To train your pet it must be an adult, and it must be set as your assigned companion.", FALSE)); 
        $profile = $mysidia->user->getprofile();
        $mysidia->user->getprofile(); 
        if ((int)$profile->getFavpetID() == 0) { 
            $document->addLangVar('<br><br>It seems you do not yet have not assigned a companion! Assign one and then come back.'); 
        return; 
        } 
        $favpet = new OwnedAdoptable($profile->getFavpetID());    
        
        if ($favpet->currentlevel < 3){ 
            $document->add(new Comment("<br><br>Woah, sorry there! Your pet isn't old enough to train, yet! Come back with an adult if you want to train!", FALSE)); 
      return; 
        } 
        if($favpet->currentlevel = 3){
            $document->add(new Comment("To train, select the stat that you would like to work on.<br><br>
                    <center><b>{$favpet->name}'s Stats</b><br>
                    <u>Se | Sp | Str | Stm</u><br>
                    {$favpet->sense} | {$favpet->speed} | {$favpet->strength} | {$favpet->stamina}<br>", FALSE));
            $this->exploreButton("Train_Sense", FALSE, "Train Sense");
            $this->exploreButton("Train_Speed", FALSE, "Train Speed");
            $this->exploreButton("Train_Strength", FALSE, "Train Strength");
            $this->exploreButton("Train_Stamina", FALSE, "Train Stamina");
        } # END no area selected

        /* If an area is selected: */
        if($mysidia->input->post("area")){
            
            $area = $mysidia->input->post("area"); // This has apostrophes as *s instead, just like the exploreButtons above!
            $str = str_replace("_", " ", $area);
            $areaname = str_replace("*", "'", $str); // This one has apostrophes instead of asterisks.

            $document->setTitle("{$areaname}");
                $increase = rand(1,5);
                $sense = $favpet->sense;
                $newsense = $sense + $increase;
                $speed = $favpet->speed;
                $newspeed = $speed + $increase;
                $strength = $favpet->strength;
                $newstrength = $strength + $increase;
                $stamina = $favpet->stamina;
                $newstamina = $stamina + $increase;
        
            switch ($area){
                # First one is the default response that will happen unless something specific is specified:
                case $areaname: $document->add(new Comment("<br><br>Oops, something has gone wrong.", FALSE));
                break;

                
                case "Train_Sense": 
                    $currentcash = $mysidia->user->money;
                    $newmoney = $currentcash - 300;
                        $document->add(new Comment("<br><b>The Session:</b><br> {$favpet->name} feels more one with Nature!<br><br>
                        {$favpet->name} gained {$increase} Sense from this session!", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("sense" => $newsense), "aid='{$profile->getFavpetID()}'");
                break;
                case "Train_Speed": 
                    $currentcash = $mysidia->user->money;
                    $newmoney = $currentcash - 5000;
                        $document->add(new Comment("<br><b>The Session:</b><br> {$favpet->name} Feels Faster!<br><br>
                        {$favpet->name} gained {$increase} Speed from this session!", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("speed" => $newspeed), "aid='{$profile->getFavpetID()}'");
                break;
                case "Train_Strength": 
                    $currentcash = $mysidia->user->money;
                    $newmoney = $currentcash - 300;
                        $document->add(new Comment("<br><b>The Session:</b><br>{$favpet->name} Feels Stronger!<br><br>
                        {$favpet->name} gained {$increase} Strength from this session!", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("strength" => $newstrength), "aid='{$profile->getFavpetID()}'");
                break;
                case "Train_Stamina": 
                    $currentcash = $mysidia->user->money;
                    $newmoney = $currentcash - 300;
                        $document->add(new Comment("<br><b>The Session:</b><br> {$favpet->name} Feels like they have more endurance!<br><br>
                        {$favpet->name} gained {$increase} Stamina from this session!", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("stamina" => $newstamina), "aid='{$profile->getFavpetID()}'");
                break;

            }

            return;
        }
    }

    public function exploreButton($areaname, $image_link = "", $customtext = "", $customimg = ""){
        $document = $this->document;
        
        if ($image_link){ /* Image Links */
            
             if (!$customimg){ /* Area Logo Image */
                 $imgname = str_replace("*", "'", $areaname);
                $document->add(new Comment("
                    <form id='exploreform' action='train' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-text btn-sm' value='train' name='{$areaname}' type='submit'>
                    <img src=\"./images/{$imgname}_logo.png\"/>
                    </button>
                    </form>
                ", FALSE)); 
             }
             
             else { /* Custom Link Image */
                 $imgname = str_replace("*", "'", $customimg);
                $document->add(new Comment("
                    <form id='exploreform' action='train' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-text btn-sm' value='train' name='{$areaname}' type='submit'>
                    <img src=\"./images/{$imgname}\"/>
                    </button>
                    </form>
                ", FALSE)); 
             }
        } 
        
        else { /* Text-Only Links */
            
            if (!$customtext){ /* Area Name Button */
                $str = str_replace("_", " ", $areaname); $btn_name = str_replace("*", "'", $str);
                $document->add(new Comment("
                    <form id='exploreform' action='train' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-violet btn-sm' value='train' name='{$areaname}' type='submit'>
                    {$btn_name}
                    </button>
                    </form>
                ", FALSE));
            } 
            
            else { /* Custom Link Text */
                $customtext = str_replace("*", "'", $customtext);
                $document->add(new Comment("
                    <form id='exploreform' action='train' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-violet btn-sm' style='display: inline;' value='train' name='{$areaname}' type='submit'>
                    {$customtext}
                    </button>
                    </form>
                ", FALSE));
            }
        }
        return;
    }
}    
?> 