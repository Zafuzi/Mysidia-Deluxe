 <?php
/* This is the Battle Mod view page. This page is created based on the explore script created by Kyttias, so credit for the base of that goes to her. The ability to select and use the favepet was from RestlessThoughts, as posted on this thread; http://mysidiaadoptables.com/forum/showthread.php?t=4827&page=3
*This mod is entirely a collection of what Abronsyth has learned from messing around with mods created by wonderful users such as the two mentioned above.
 */
class BattleView extends View{
    
    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document; 
        $document->setTitle("Battle");
                    $document->add(new Comment("<br>", FALSE)); 
        $profile = $mysidia->user->getprofile();
        $mysidia->user->getprofile(); 
        if ((int)$profile->getFavpetID() == 0) { 
            $document->addLangVar('<br><br>It seems you do not yet have not assigned a companion! Assign one and then come back.'); 
        return; 
        } 
        $favpet = new OwnedAdoptable($profile->getFavpetID());    
        
        if ($favpet->currentlevel < 3){ 
            $document->add(new Comment("<br><br>Woah, sorry there! Your companion isn't old enough to battle, yet! Come back with an adult companion if you want to compete!", FALSE)); 
      return; 
        } 
        if($favpet->currentlevel = 3){
/*Random Opponent Stats*/ 
$opsense = rand(1,100); 
$opstamina = rand(1,100); 
$opstrength = rand(1,100); 
$opspeed = rand(1,100); 
$images = rand(1,3);  
if($images = 1) {
$opimage = "<img src='http://atrocity.mysidiahost.com/image/display/Catari'/>";
}
elseif($images = 2) {
$opimage = "<img src='http://atrocity.mysidiahost.com/image/display/Hounda'/>";
}
elseif($images = 3) {
$opimage = "<img src='http://atrocity.mysidiahost.com/image/display/Feesh'/>";
}  
    /*Below determines how many trophies the pet earns by winning a batttle.*/
        $trophies = $favpet->trophies;
        $newtrophy = $trophies + 1;
            $document->add(new Comment("<center>You enter the battle arena with {$favpet->name} at your side. Waiting at the opposite end of the arena is your opponent!<br>
            To engage in battle, select an attack from below. If you would not like to battle, you may simply leave this page.<br>", FALSE));
            $this->exploreButton("Use_Bite", FALSE, "Bite");
            $this->exploreButton("Use_Tackle", FALSE, "Tackle");
            $this->exploreButton("Use_Trick", FALSE, "Trick</center>");
        } 
        if($mysidia->input->post("area")){
            
            $area = $mysidia->input->post("area");

            $document->setTitle("Battle");
        
            switch ($area){
                case "Use_Bite": 
                    $opbite = $opspeed + $opstrength;
                    $bite = $favpet->speed + $favpet->strength;
                    $prize = rand(100,5000);
                    $currentcash = $mysidia->user->money;
                    $newmoney = $prize + $currentcash;
                    if($bite > $opbite){
                        $document->add(new Comment("<br><br><table align='center' border='0px'>
                <tr>
                    <td width='40%' style='text-align:left;vertical-align:bottom;'>
                    
                    <img src='{$favpet->getImage()}'/>  <i>{$favpet->name}</i><br>
                    <b>Sense:</b> {$favpet->sense}<br>
                    <b>Speed:</b> {$favpet->speed}<br>
                    <b>Strength:</b> {$favpet->strength}<br>
                    <b>Stamina:</b> {$favpet->stamina}<br>
                    </td>
                    <td width='20%'>
                    <center><b>VS</b></center>
                    </td>
                    <td width='40%' style='text-align:right;vertical-align:bottom'>
                    {$opimage}
                    <i>Opponent</i><br>
                    <b>Sense:</b> {$opsense}<br>
                    <b>Speed:</b> {$opspeed}<br>
                    <b>Strength:</b> {$opstrength}<br>
                    <b>Stamina:</b> {$opstamina}<br>
                    </td>
                </tr>
            </table><br><center>Your pet dives in and attacks your opponent with a bite dealing {$bite} damage.
                        <br>The opponent counters the attack with {$opbite} damage, but it isn't enough!<br>
                        Your pet has won, and brought you {$prize} currency! Furthermore, {$favpet->name} has won a trophy!</center><br><br>", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("trophies" => $newtrophy), "aid='{$profile->getFavpetID()}'");
                    }
                    else{
                        $document->add(new Comment("<br><br><table align='center' border='0px'>
                <tr>
                    <td width='40%' style='text-align:left;vertical-align:bottom;'>
                    <img src='{$favpet->getImage()}'/>  
                    <i>{$favpet->name}</i><br>
                    <b>Sense:</b> {$favpet->sense}<br>
                    <b>Speed:</b> {$favpet->speed}<br>
                    <b>Strength:</b> {$favpet->strength}<br>
                    <b>Stamina:</b> {$favpet->stamina}<br>
                    </td>
                    <td width='20%'>
                    <center><b>VS</b></center>
                    </td>
                               <td width='40%' style='text-align:right;vertical-align:bottom'>
                               {$opimage}<br>
                                                  <i>Opponent</i><br>
                    <b>Sense:</b> {$opsense}<br>
                    <b>Speed:</b> {$opspeed}<br>
                    <b>Strength:</b> {$opstrength}<br>
                    <b>Stamina:</b> {$opstamina}<br>
                    </td>
             </tr>               

            </table><br><center>Your pet dives in and attacks your opponent with a bite dealing {$bite} damage.
                        <br>The opponent counters the attack with {$opbite} damage, and manages to over power {$favpet->name}!<br>
                        Unfortunately your pet lost...better luck next time!</center><br><br>", FALSE));
                    }
                break;
                case "Use_Tackle": 
                    $optackle = $opstrength + $opstamina;
                    $tackle = $favpet->strength + $favpet->stamina;
                    $prize = rand(25,50);
                    $currentcash = $mysidia->user->money;
                    $newmoney = $prize + $currentcash;
                    if($tackle > $optackle){
                        $document->add(new Comment("<br><br>
                        <table align='center' border='0px'>
                    <tr>
                    <td width='40%' style='text-align:left;vertical-align:bottom;'>
                    <img src='{$favpet->getImage()}'/> 
                    <i>{$favpet->name}</i><br>
                    <b>Sense:</b> {$favpet->sense}<br>
                    <b>Speed:</b> {$favpet->speed}<br>
                    <b>Strength:</b> {$favpet->strength}<br>
                    <b>Stamina:</b> {$favpet->stamina}<br>
                    </td>
                    <td width='20%'>
                    <center><b>VS</b></center>
                    </td>
                    <td width='40%' style='text-align:right;vertical-align:bottom'>
                    {$opimage}
                    <i>Opponent</i><br>
                    <b>Sense:</b> {$opsense}<br>
                    <b>Speed:</b> {$opspeed}<br>
                    <b>Strength:</b> {$opstrength}<br>
                    <b>Stamina:</b> {$opstamina}<br>
                    </td>
                </tr>
            </table><br><center>Your pet launches forward and slams into the opponent, dealing {$tackle} damage!
                        <br>The opponent counters the attack with {$optackle} damage, but it isn't enough!<br>
                        Your pet has won, and brought you {$prize} currency! Furthermore, {$favpet->name} has won a trophy!</center><br><br>", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("trophies" => $newtrophy), "aid='{$profile->getFavpetID()}'");
                    }
                    else{
                        $document->add(new Comment("<br><br>
                        <table align='center' border='0px'>
                    <tr>
                    <td width='40%' style='text-align:left;vertical-align:bottom;'>
                    <img src='{$favpet->getImage()}'/>  
                    <i>{$favpet->name}</i><br>
                    <b>Sense:</b> {$favpet->sense}<br>
                    <b>Speed:</b> {$favpet->speed}<br>
                    <b>Strength:</b> {$favpet->strength}<br>
                    <b>Stamina:</b> {$favpet->stamina}<br>
                    </td>
                    <td width='20%'>
                    <center><b>VS</b></center>
                    </td>
                    <td width='40%' style='text-align:right;vertical-align:bottom'>
                    {$opimage}
                    <i>Opponent</i><br>
                    <b>Sense:</b> {$opsense}<br>
                    <b>Speed:</b> {$opspeed}<br>
                    <b>Strength:</b> {$opstrength}<br>
                    <b>Stamina:</b> {$opstamina}<br>
                    </td>
                </tr>
            </table><br><center>Your pet launches forward and slams into the opponent, dealing {$tackle} damage!
                        <br>The opponent counters the attack with {$opbite} damage, and manages to over power {$favpet->name}!<br>
                        Unfortunately your pet lost...better luck next time!</center><br><br>", FALSE));
                    }
                break;
                case "Use_Trick": 
                    $optrick = $opsense + $opspeed;
                    $trick = $favpet->sense + $favpet->speed;
                    $prize = rand(25,50);
                    $currentcash = $mysidia->user->money;
                    $newmoney = $prize + $currentcash;
                    if($trick > $optrick){
                        $document->add(new Comment("<br><br>
                        <table align='center' border='0px'>
                    <tr>
                    <td width='40%' style='text-align:left;vertical-align:bottom;'>
                    <img src='{$favpet->getImage()}'/>  
                    <i>{$favpet->name}</i><br>
                    <b>Sense:</b> {$favpet->sense}<br>
                    <b>Speed:</b> {$favpet->speed}<br>
                    <b>Strength:</b> {$favpet->strength}<br>
                    <b>Stamina:</b> {$favpet->stamina}<br>
                    </td>
                    <td width='20%'>
                    <center><b>VS</b></center>
                    </td>
                    <td width='40%' style='text-align:right;vertical-align:bottom'>
                    {$opimage}
                    <i>Opponent</i><br>
                    <b>Sense:</b> {$opsense}<br>
                    <b>Speed:</b> {$opspeed}<br>
                    <b>Strength:</b> {$opstrength}<br>
                    <b>Stamina:</b> {$opstamina}<br>
                    </td>
                </tr>
            </table><br><center>Your pet taunts the opponent and dashes out of the way at the last minute, tricking the opponent into running at the wall, dealing {$trick} damage!
                        <br>The opponent counters the attack with {$optrick} damage, but it isn't enough!<br>
                        Your pet has won, and brought you {$prize} currency! Furthermore, {$favpet->name} has won a trophy!</center><br><br>", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("trophies" => $newtrophy), "aid='{$profile->getFavpetID()}'");
                    }
                    else{
                        $document->add(new Comment("<br><br>
                        <table align='center' border='0px'>
                    <tr>
                    <td width='40%' style='text-align:left;vertical-align:bottom;'>
                    <img src='{$favpet->getImage()}'/>  
                                      <i>{$favpet->name}</i><br>
                    <b>Sense:</b> {$favpet->sense}<br>
                    <b>Speed:</b> {$favpet->speed}<br>
                    <b>Strength:</b> {$favpet->strength}<br>
                    <b>Stamina:</b> {$favpet->stamina}<br>
                    </td>
                    <td width='20%'>
                    <center><b>VS</b></center>
                    </td>
                    <td width='40%' style='text-align:right;vertical-align:bottom'>
                    {$opimage}
                    <i>Opponent</i><br>
                    <b>Sense:</b> {$opsense}<br>
                    <b>Speed:</b> {$opspeed}<br>
                    <b>Strength:</b> {$opstrength}<br>
                    <b>Stamina:</b> {$opstamina}<br>
                    </td>
                </tr>
            </table><br><center>Your pet taunts the opponent and dashes out of the way at the last minute, tricking the opponent into running at the wall, dealing {$trick} damage!
                        <br>The opponent counters the attack with {$optrick} damage, and manages to over power {$favpet->name}!<br>
                        Unfortunately your pet lost...better luck next time!</center><br><br>", FALSE));
                    }
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
                    <form id='exploreform' action='battle' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-text btn-sm' value='battle' name='{$areaname}' type='submit'>
                    <img src=\"./images/{$imgname}_logo.png\"/>
                    </button>
                    </form>
                ", FALSE)); 
             }
             
             else { /* Custom Link Image */
                 $imgname = str_replace("*", "'", $customimg);
                $document->add(new Comment("
                    <form id='exploreform' action='battle' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-text btn-sm' value='battle' name='{$areaname}' type='submit'>
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
                    <form id='exploreform' action='battle' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-violet btn-sm' value='battle' name='{$areaname}' type='submit'>
                    {$btn_name}
                    </button>
                    </form>
                ", FALSE));
            } 
            
            else { /* Custom Link Text */
                $customtext = str_replace("*", "'", $customtext);
                $document->add(new Comment("
                    <form id='exploreform' action='battle' name='exploreform' method='post' role='form'>
                    <input id='area' name='area' type='hidden' value='{$areaname}'>
                    <button id='{$areaname}' class='btn-violet btn-sm' style='display: inline;' value='battle' name='{$areaname}' type='submit'>
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