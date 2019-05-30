<?php

class New_battleView extends View{
    
    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document; 
        $document->setTitle("Battle");
        $document->add(new Comment("<h2>Training Arena</h2>", FALSE)); 
        $profile = $mysidia->user->getprofile();
        if ((int)$profile->getFavpetID() == 0) { 
            $document->addLangVar("<p>You don't have a companion, and you need one to battle!</p>"); 
        return; 
        } 
        $favpet = new OwnedAdoptable($profile->getFavpetID());    
        
        if ($favpet->currentlevel < 3){ 
            $document->add(new Comment("<br><a href='/pet/profile/{$favpet->aid}'><img src='{$favpet->getImage()}'></a>
            <br>Sorry, your companion looks too young to fight. Come back when they're older!
            ", FALSE)); 
      return; 
        }   
        
        if($favpet->currentlevel >= 3){

            $document->add(new Comment("<br><img src='{$favpet->getImage()}'></a><p>
            Welcome to the arena!</p>
            <div class='dueloptions'>
            <a href='/train'>Train? will change this later</a></div>
            ", FALSE));
         
        
        }
    }


   // changed 'area' to 'result' as that makes more sense here
   // changed 'battle' to 'duel'

    public function exploreButton($resultname, $image_link = "", $customtext = "", $customimg = ""){
        $document = $this->document;
            if (!$customtext){
                $str = str_replace("_", " ", $resultname); $btn_name = str_replace("*", "'", $str);
                $document->add(new Comment("
                    <form id='exploreform' action='' name='exploreform' method='post' role='form'>
                    <input id='result' name='result' type='hidden' value='{$resultname}'>
                    <button id='{$resultname}' value='' name='{$resultname}' type='submit'>
                    {$btn_name}
                    </button>
                    </form>
                ", FALSE));
            } 
            else {
                $customtext = str_replace("*", "'", $customtext);
                $document->add(new Comment("
                    <form id='exploreform' action='' name='exploreform' method='post' role='form'>
                    <input id='result' name='result' type='hidden' value='{$resultname}'>
                    <button id='{$resultname}' style='display: inline;' value='' name='{$resultname}' type='submit'>
                    {$customtext}
                    </button>
                    </form>
                ", FALSE));
            }
        return;
    }
    
    
	public function arena(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
        $document->setTitle("Challenging ...");
        
        $profile = $mysidia->user->getprofile();
        $mysidia->user->getprofile(); 
        if ((int)$profile->getFavpetID() == 0) { 
            $document->addLangVar("<p>You don't have a companion, and you need one to battle!</p>"); 
        return; 
        } 
        
        $favpet = new OwnedAdoptable($profile->getFavpetID());
        if ($favpet->currentlevel < 3){ 
            $document->add(new Comment("<p>Sorry, your companion looks too young to fight. Come back when they're older!</p>")); 
      return; 
        } 
        
        if($favpet->currentlevel >= 3){
            //$enemy = $mysidia->db->select("owned_adoptables", array(), "owner='{$mysidia->user->username}' ORDER BY RAND() LIMIT 1")->fetchObject();
        $enemy_list = array("dragonsnake", "slime");
		$enemy = $enemy_list[array_rand($enemy_list, 1)];
        $opname = $enemy;
        $favid = $favpet->aid;
        $petname = $favpet->name;
        $species = $favpet->type;
		
		switch($enemy){ //lets define the images
			case "slime":
				$slimes = array("darkblueslime1", "greenslime1");
				$rand_slime = $slimes[array_rand($slimes, 1)];
				$enemy_img = "/picuploads/enemies/slimes/{$rand_slime}.png";
				break;
			case "dragonsnake":
				$rand_ds = mt_rand(1,4);
				$enemy_img = "/picuploads/enemies/Dragonsnake/Dragonsnake{$rand_ds}.png";
				break;
		}
		
		switch($species){ //change attack names based on species. Functionally they do the same thing
		    case "Hounda":
		        $atk_name = "Bite";
		        break;
		    case "Catari":
		        $atk_name = "Scratch";
		        break;
            case "Feesh":
		        $atk_name = "Splash";
		        break;
		}
		
        // set scene
        //$places = array('bg1.jpg','bg2.jpg','bg3.jpg','bg4.jpg','bg5.jpg','bg6.jpg');
        //$area = $places[array_rand($places, 1)];
        $oplosses = array(' stumbled and fell!',' roared in anguish!',' turned and fled!');
        $oploss = $oplosses[array_rand($oplosses, 1)];
        
        // get enemy info
		$high_stats = mt_rand(100,200);
		$low_stats = mt_rand(10,50);
        $ophealth = $high_stats;
        $opsense = $low_stats;
        $opstamina = $low_stats;
        $opstrength = $low_stats;
        $opspeed = $low_stats;
        $opmagic = $low_stats;
        $opbite = $low_stats; + $low_stats;
        $optackle = $low_stats; + $low_stats;
        $optrick = $low_stats; + $low_stats;
        
        // get our info
        $health = $favpet->health;
        $mana = $favpet->mp;
        $bite = $favpet->speed + $favpet->strength;
        $tackle = $favpet->strength + $favpet->stamina;
        $trick = $favpet->sense + $favpet->speed;
        $sense = $favpet->sense;
        $speed = $favpet->speed;
        $stamina = $favpet->stamina;
        $strength = $favpet->strength;
        $magskill = $favpet->magicstat;
        
        // each elemental affinity brings stat boosts, along with having certain wearables, companions or treasures
        if ($favpet->element == 'Water'){$speed = $speed + 5; $strength = $strength + 5;}
        if ($favpet->element == 'Fire'){$strength = $strength + 10;}
        if ($favpet->element == 'Thunder'){$speed = $speed + 10;}
        if ($favpet->element == 'Ice'){$strength = $strength + 5; $stamina = $stamina + 5;}
        if ($favpet->element == 'Earth'){$stamina = $stamina + 10;}
        if ($favpet->element == 'Wind'){$sense = $sense + 10;}
        if ($favpet->element == 'Light'){$speed = $speed + 5; $sense = $sense + 5;}
        if ($favpet->element == 'Darkness'){$stamina = $stamina + 5; $sense = $sense + 5;}
        if ($favpet->companion == 'Sun Horse'){$magskill = $magskill + 4;}
        if ($favpet->companion == 'Gem Horse'){$magskill = $magskill + 8;}
        if ($favpet->companion == 'Bismuth Bird'){$magskill = $magskill + 10;}
        if ($favpet->tail == 'GoldTailRings' || $favpet->tail == 'SilverTailRings'){$stamina = $stamina + 3;}
        
        if ($enemy->element == 'Water'){$opspeed = $opspeed + 5; $opstrength = $opstrength + 5;}
        if ($enemy->element == 'Fire'){$opstrength = $opstrength + 10;}
        if ($enemy->element == 'Thunder'){$opspeed = $opspeed + 10;}
        if ($enemy->element == 'Ice'){$opstrength = $opstrength + 5; $opstamina = $opstamina + 5;}
        if ($enemy->element == 'Earth'){$opstamina = $opstamina + 10;}
        if ($enemy->element == 'Wind'){$opsense = $opsense + 10;}
        if ($enemy->element == 'Light'){$opspeed = $opspeed + 5; $opsense = $opsense + 5;}
        if ($enemy->element == 'Darkness'){$opstamina = $opstamina + 5; $opsense = $opsense + 5;}
        if ($enemy->companion == 'Sun Horse'){$opmagic = $opmagic + 4;}
        if ($enemy->companion == 'Gem Horse'){$opmagic = $opmagic + 8;}
        if ($enemy->companion == 'Bismuth Bird'){$opmagic = $opmagic + 10;}
        if ($enemy->tail == 'GoldTailRings' || $favpet->tail == 'SilverTailRings'){$opstamina = $opstamina + 3;}
        
        
        // modifier stuff
        $gstatus = 'normal';
        $estatus = 'normal';
        $gmod = 1;
        $emod = 1;
        
        // by default we have 5 or 10 percent dodge chance, depending if enemy is faster. 
        // if our griff has over 90 or 140 speed, add another 5 or 10 percent. 
            // imo it might be better to compare the two speeds and calculate percentages, instead of using absolute numbers
            // eg. if one side is 3x faster than other, or 1.2x, it should differ accordingly. But I'm too lazy to think of a formula yet
        if ($speed > $opspeed) { $gdodge = 10; $edodge = 5; }
        if ($speed <= $opspeed) { $gdodge = 5; $edodge = 10; }
        if ($speed > 90 && $speed <= 140) { $gdodge = $gdodge + 5; }
        if ($speed > 140) { $gdodge = $gdodge + 10; }
        
        // TO DO: finish function that randomly ends statuses, like flight/defend/berserk, and turns the fighter back to normal
        // unfortunately the function refuses to work, guess I need to redo it, or work this into every attack - chance to end other's status
        
        
        
        
        
        // results after battle... show instead of battlefield.
        // I'm a little worried about players refreshing the page after winning and getting the rewards again, and repeatedly injuring enemy
        // hmm, how to stop this?  maybe a time limit between battles? or battling the same enemy at least? once per day?
        
        if($mysidia->input->post("result")){
            $result = $mysidia->input->post("result");
            
            switch ($result){
                case "Win": 
                
                    // some sorta check here - if this griff has already beaten this other griff today, give nothing but message...
                
                    $prize = rand(40,90);
                    $ehe = $enemy->health - 1;
                    if ($ehe < 0){$ehe = 0;}
                    $een = $enemy->energy - 1;
                    if ($een < 0){$een = 0;}
                    $gen = $favpet->energy - 1;
                    if ($gen < 0){$gen = 0;}
                    $currentcash = $mysidia->user->money;
                    $newmoney = $prize + $currentcash;
                    $document->add(new Comment("<div style='width:700px;padding:20px;background-color:white;border-radius:5px;'>
                    <h2>Victory!</h2><p>
                    <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a> <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a></p>
                        Congratulations! That was a magnificent duel! {$petname} managed to overpower {$opname}.<p>You receive {$prize} currency for the victory.<br>(insert some skill gains and EXP here for griff too)<br>{$petname} now has <b>{$gen}</b> energy.
                        </p><a href='http://griffusion.elementfx.com/duel'>Eager for another match?</a></div><br>", FALSE));
                    $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                    $mysidia->db->update("owned_adoptables", array("trophies" => $newtrophy, "energy" => $gen), "aid='{$favid}'");
                    $mysidia->db->update("owned_adoptables", array("health" => $ehe, "energy" => $een), "aid='{$opid}'");
                    $thetime = date("jS M, H:i");
                    $message = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$favid.'\'><b>'.$petname.'</b></a> challenged and defeated <a href=\'levelup/publicprofile/'.$opid.'\'><b>'.$opname.'</b></a> in a duel.';
                    $message2 = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$opid.'\'><b>'.$opname.'</b></a> was challenged by <a href=\'levelup/publicprofile/'.$favid.'\'><b>'.$petname.'</b></a>, and defeated.';
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'battle', "mtext" => $message ));
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $opowner, "date" => $thetime, "mtype" => 'battle', "mtext" => $message2 ));
                    
                break;
                case "Draw": 
                    $prize = rand(20,40);
                    $een = $enemy->energy - 1;
                    if ($een < 0){$een = 0;}
                    $gen = $favpet->energy - 1;
                    if ($gen < 0){$gen = 0;}
                    $currentcash = $mysidia->user->money;
                    $newmoney = $prize + $currentcash;
                    $document->add(new Comment("<div style='width:700px;padding:20px;background-color:white;border-radius:5px;'>
                    <h2>Draw!</h2><p>
                    <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a> <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a></p>
                        Neither griffin was a clear winner, but elders were pleased to see {$opname} and {$petname}'s heartfelt attempts.<p>You're given {$prize} tokens as an encouragement for further training. Your griff has potential!<br>{$petname} now has <b>{$gen}</b> energy.
                        </p><a href='http://griffusion.elementfx.com/duel'>Want to try another match?</a></div><br>", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("energy" => $gen), "aid='{$favid}'");
                        $mysidia->db->update("owned_adoptables", array("energy" => $een), "aid='{$opid}'");
                    $thetime = date("jS M, H:i");
                    $message = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$favid.'\'><b>'.$petname.'</b></a> challenged <a href=\'levelup/publicprofile/'.$opid.'\'><b>'.$opname.'</b></a> in a duel, but it was a draw.';
                    $message2 = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$opid.'\'><b>'.$opname.'</b></a> was challenged by <a href=\'levelup/publicprofile/'.$favid.'\'><b>'.$petname.'</b></a>. Neither side won the duel.';
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'battle', "mtext" => $message ));
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $opowner, "date" => $thetime, "mtype" => 'battle', "mtext" => $message2 ));
                    
                break;
                case "Loss": 
                    $een = $enemy->energy - 1;
                    if ($een < 0){$een = 0;}
                    $gen = $favpet->energy - 1;
                    if ($gen < 0){$gen = 0;}
                    $he = $favpet->health - 1;
                    if ($he < 0){$he = 0;}
                    $document->add(new Comment("<div style='width:700px;padding:15px;background-color:white;border-radius:5px;'>
                    <h2>Defeated...</h2><p>
                    <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a> <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a></p>
                        That was an impressive victory for {$opname}.<p>{$petname} is slightly injured, not to mention embarrassed...
                        <br>{$petname} now has <b>{$gen}</b> energy and <b>{$he}</b> health left.
                        </p><a href='http://griffusion.elementfx.com/duel'>Want to try again?</a></div><br>", FALSE));
                    $mysidia->db->update("owned_adoptables", array("health" => $he, "energy" => $gen), "aid='{$favid}'");
                    $mysidia->db->update("owned_adoptables", array("energy" => $een), "aid='{$opid}'");
                    $thetime = date("jS M, H:i");
                    $message = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$favid.'\'><b>'.$petname.'</b></a> challenged <a href=\'levelup/publicprofile/'.$opid.'\'><b>'.$opname.'</b></a> to a duel, but was defeated.';
                    $message2 = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$opid.'\'><b>'.$opname.'</b></a> was challenged by <a href=\'levelup/publicprofile/'.$favid.'\'><b>'.$petname.'</b></a>, and won.';
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'battle', "mtext" => $message ));
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $opowner, "date" => $thetime, "mtype" => 'battle', "mtext" => $message2 ));
                        
                break;

            }
       return;
         
       }
        
        
        // begin the actual battlefield. JS was getting long so tucked it away
        
        include 'battlejavascript.php';

$document->add(new Comment("          
<style>
.item1 { grid-area: header; }
.item2 { grid-area: menu; }
.item3 { grid-area: main; }
.item4 { grid-area: right; }
.item5 { grid-area: footer; }

.grid-container {
  display: grid;
  grid-template-areas:
    'menu header right'
    'menu main right'
    'menu footer right';
  grid-gap: 10px;
  background-color: #c4c4c4;
  padding: 10px;
}
.grid-container > div {
  background-color: rgba(255, 255, 255, 0.8);
  text-align: center;
  padding: 20px 0;
}
#reports {width:400px;height:100px;padding:10px;margin-top:0px;margin-bottom:0px;margin-left:auto;margin-right:auto;border:2px solid black;border-radius:4px;background-color:white; overflow:auto;}
.dropdown {
    position: relative;
    display: inline-block;
}

.dropdown-content {
    display: none;
    position: absolute;
    left: -75px;
    background-color: #f9f9f9;
    min-width: 160px;
    box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
    padding: 12px 16px;
    z-index: 1;
}

.dropdown:hover .dropdown-content {
    display: block;
}
#healthBar, #enhealthBar { width:200px;height:20px;border:1px solid #111;background-color: #292929;}
#healthInner {height: 100%;color: #fff;text-align: right;line-height: 20px;width: 0;background-color: #63e530;}
#enhealthInner {height: 100%;color: #fff;text-align: right;line-height: 20px;width: 0;background-color: #63e530;}
#magicBar, #enhealthBar { width:200px;height:20px;border:1px solid #111;background-color: #292929;}
#magicInner {height: 100%;color: #fff;text-align: right;line-height: 20px;width: 0;background-color: #00a1ff;}
#enmagicInner {height: 100%;color: #fff;text-align: right;line-height: 20px;width: 0;background-color: #00a1ff;}
#expBar, #enhealthBar { width:200px;height:20px;border:1px solid #111;background-color: #292929;}
#expInner {height: 100%;color: #fff;text-align: right;line-height: 20px;width: 0;background-color: #ea8f9f;}
</style>

<div class='grid-container'>
    <div class='item1'>
        <img src='/picuploads/petinfoiconsmaller.png' style='position:relative; left:-200px;'>
        <p>
            <b>Hit Points</b></br>
            <div id='healthBar' style='margin-left: auto; margin-right: auto;'>
                <div id='healthInner' style='width:100%;'></div>
            </div>
            <b>Magic Points</b></br>
            <div id='magicBar' style='margin-left: auto; margin-right: auto;'>
                <div id='magicInner' style='width:100%;'></div>
            </div>
            <b>Experience Points</b></br>
            <div id='expBar' style='margin-left: auto; margin-right: auto;'>
                <div id='expInner' style='width:100%;'></div>
            </div>
        </p>
    </div>
    <div class='item2'>
        <h2>{$petname} - Lv {$favpet->currentlevel}</h2>
        <a href='levelup/publicprofile/{$favpet->aid}'><img src='{$favpet->getImage()}'></a>
        <p>
            <div class='dropdown'>
                <span><b><u>Fight!</u></b></span>
                <div class='dropdown-content'>
                    <button id='Bite'>{$atk_name}!</button></br>
                    <button id='defend'>Defend</button></br>
                    <button id='Trick'>Trick!</button></br>
                    <button id='Taunt'>Taunt!</button>
                </div>
            </div> | 
            <div class='dropdown'>
                <span><b><u>Info</u></b></span>
                <div class='dropdown-content'>
                    <div id='griffsense'>Sense: {$sense}</div></br>
                    <div id='griffspeed'>Speed: {$speed}</div></br>
                    <div id='griffstamina'>Stamina: {$stamina}</div></br>
                    <div id='griffstrength'>Strength: {$strength}</div></br>
                    <div id='griffmagic'>Magic: {$magskill}</div></br>
                    <div id='gevade'>Evasion: {$gdodge}</div></br>
                    <div id='gstate'>State: {$gstatus} - Mod: {$gmod}</div>
                </div>
            </div>
        </p>
    </div>
    <div class='item3' id='reports'>Let the battle commence!</div>  
    <div class='item4'>
        <h2>{$opname}</h2>
        <img src='{$enemy_img}' style='width:180px; height:auto;'>
	    <p> 
            <div class='dropdown'>
                <span><b><u>Info</u></b></span>
                <div class='dropdown-content'>
                    <div id='esense'>Sense: {$opsense}</div>
				    <div id='espeed'>Speed: {$opspeed}</div>
				    <div id='estamina'>Stamina: {$opstamina}</div>
				    <div id='estrength'>Strength: {$opstrength}</div>
				    <div id='eevade'>Evasion: {$edodge}</div>
				    <div id='estate'>State: {$estatus} - Mod: {$emod}</div>
                </div>
            </div>
        </p>
    </div>
    <div class='item5'>
        <img src='/picuploads/enemyinfoiconsmaller.png' style='position:relative; right:-200px;'></br>
	    <p>
		    <b>Hit Points</b></br>
    		<div id='enhealthBar' style='margin-left: auto; margin-right: auto;'>
			    <div id='enhealthInner' style='width:100%;'></div>
		    </div>
		    <b>Magic Points</b></br>
			    <div id='magicBar' style='margin-left: auto; margin-right: auto;'>
				    <div id='enmagicInner' style='width:100%;'></div>
			    </div>
	    </p>
    </div>
</div>", FALSE));

$document->add(new Comment("
<div id='victory' style='padding:70px 0;border:1px solid black;margin:auto;background-color:white;position:relative;top:-600px;display:none; text-align:center;'>
<h3>{$opname} {$oploss} {$petname} won the battle, congratulations!</h3><br></br>
<hr>
<p>You have earned...</br>(List rewards here...)</p>
<hr><br></br>", FALSE));
$this->exploreButton("Win", FALSE, "Claim your reward!");
$document->add(new Comment("<br>
</div>
<br>
<div id='drawn' style='padding:70px 0;border:1px solid black;margin:auto;background-color:white;position:relative;top:-600px;display:none; text-align:center;'>
The battle was a draw! Neither won this round.<br></br>", FALSE));
$this->exploreButton("Draw", FALSE, "A good effort!");
$document->add(new Comment("<br>
</div>
<br>
<div id='lost' style='padding:70px 0;border:1px solid black;margin:auto;background-color:white;position:relative;top:-600px;display:none; text-align:center;'>
Unfortunately you lost the battle, and {$petname} was injured.<br></br>", FALSE));
$this->exploreButton("Loss", FALSE, "Oh no!");
$document->add(new Comment("<br>
</div>
",FALSE));
         
    }
  } 
    
    ///PVP past this point!!!!
    
        public function griff(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
        $document->setTitle("Challenging ...");
        
        $profile = $mysidia->user->getprofile();
        $mysidia->user->getprofile(); 
        if ((int)$profile->getFavpetID() == 0) { 
            $document->addLangVar("<h2>Missing Griffin</h2><p>Hello, Keeper? ... It seems you have not brought a griffin with you.</p>
            Please select one from <a href='http://griffusion.elementfx.com/flock'>your flock</a>, and then come back if you wish to command them in battle.<br>In accordance with rules, duelling griffins must be reasonably healthy, and have reached adulthood.<br>Good luck!"); 
        return; 
        } 
        
        $favpet = new OwnedAdoptable($profile->getFavpetID());
        if ($favpet->stage < 4){ 
            $document->add(new Comment("<h2>Too young!</h2><br><a href='http://griffusion.elementfx.com/flock/manage/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a><p>Your griff is too young to battle yet.<p>Please come back with an adult if you want to fight!<br><br><a href='http://griffusion.elementfx.com/duel'>Return to Arena</a>", FALSE)); 
      return; 
        }  
        if ($favpet->health < 5 || $favpet->energy < 2){ 
            $document->add(new Comment("<h2>Too tired...</h2><br><a href='http://griffusion.elementfx.com/flock/manage/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a><p>Your griffin seems utterly exhausted! What a poor state!<br>You should let them rest for a while...</p>Please come back with a healthy one if you wish to battle.<br><br><a href='http://griffusion.elementfx.com/duel'>Return to Arena</a>", FALSE)); 
      return; 
        } 
        
        if($favpet->stage >= 4){
        
        // begin fetching battle stuff, opponent id
        
        $fullurl = $_SERVER['REQUEST_URI'];
        $scrub = explode('/',trim($fullurl,'/'));
        $opid  = end($scrub);
        
        $enemy = new OwnedAdoptable($opid);
        $opname = $enemy->name;
        $opowner = $mysidia->db->select("users", array("uid"), "username ='{$enemy->owner}'")->fetchColumn();
        $favid = $favpet->aid;
        $gname = $favpet->name;
        
        // check if griff is trying to fight itself x)
        if ($opid == $favid){ 
            $document->add(new Comment("<h2>Huh?</h2><br><a href='http://griffusion.elementfx.com/flock/manage/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a><p>Your griffin can't fight with themselves! Don't be silly...<p>Choose another opponent to challenge.</p><a href='http://griffusion.elementfx.com/duel'>Return to Arena</a>", FALSE)); 
            return; 
            } 
        
        // OK, another griff, but are they available for battling now? let's check their permission and health...
        
            if ($enemy->fightable == 'no'){ 
            $document->add(new Comment("<h2>Opponent is busy</h2><br><a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a><p>Sorry, {$opname} is not available for duelling right now. <br>Their Keeper has other plans for them.<p>You are welcome to try challenging another griffin instead!</p><a href='http://griffusion.elementfx.com/duel'>Return to Arena</a>", FALSE)); 
            return; 
            } 
            if ($enemy->health < 4 || $enemy->energy < 1){ 
            $document->add(new Comment("<h2>Opponent is resting</h2><br><a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a><p>Sorry, {$opname} is not in a fit state for duelling right now.<br>Wait a while and their Keeper should allow them to fight again.<p>You are welcome to try challenging another griffin instead!</p><a href='http://griffusion.elementfx.com/duel'>Return to Arena</a>", FALSE)); 
            return; 
            } 
        
        // their owner is OK with them being challenged? carry on then
        
        // set scene
        $places = array('bg1.jpg','bg2.jpg','bg3.jpg','bg4.jpg','bg5.jpg','bg6.jpg');
        $area = $places[array_rand($places, 1)];
        $oplosses = array(' stumbled and fell!',' roared in anguish!',' turned and fled!',' panicked and flew away!');
        $oploss = $oplosses[array_rand($oplosses, 1)];
        
        // get enemy info
        $ophealth = $enemy->hp;
        $opsense = $enemy->sense;
        $opstamina = $enemy->stamina;
        $opstrength = $enemy->strength;
        $opspeed = $enemy->speed;
        $opmagic = $enemy->magicstat;
        $opbite = $enemy->speed + $enemy->strength;
        $optackle = $enemy->strength + $enemy->stamina;
        $optrick = $enemy->sense + $enemy->speed;
        
        // get our info
        $health = $favpet->hp;
        $mana = $favpet->mp;
        $bite = $favpet->speed + $favpet->strength;
        $tackle = $favpet->strength + $favpet->stamina;
        $trick = $favpet->sense + $favpet->speed;
        $sense = $favpet->sense;
        $speed = $favpet->speed;
        $stamina = $favpet->stamina;
        $strength = $favpet->strength;
        $magskill = $favpet->magicstat;
        
        // each elemental affinity brings stat boosts, along with having certain wearables, companions or treasures
        if ($favpet->element == 'Water'){$speed = $speed + 5; $strength = $strength + 5;}
        if ($favpet->element == 'Fire'){$strength = $strength + 10;}
        if ($favpet->element == 'Thunder'){$speed = $speed + 10;}
        if ($favpet->element == 'Ice'){$strength = $strength + 5; $stamina = $stamina + 5;}
        if ($favpet->element == 'Earth'){$stamina = $stamina + 10;}
        if ($favpet->element == 'Wind'){$sense = $sense + 10;}
        if ($favpet->element == 'Light'){$speed = $speed + 5; $sense = $sense + 5;}
        if ($favpet->element == 'Darkness'){$stamina = $stamina + 5; $sense = $sense + 5;}
        if ($favpet->companion == 'Sun Horse'){$magskill = $magskill + 4;}
        if ($favpet->companion == 'Gem Horse'){$magskill = $magskill + 8;}
        if ($favpet->companion == 'Bismuth Bird'){$magskill = $magskill + 10;}
        if ($favpet->tail == 'GoldTailRings' || $favpet->tail == 'SilverTailRings'){$stamina = $stamina + 3;}
        
        if ($enemy->element == 'Water'){$opspeed = $opspeed + 5; $opstrength = $opstrength + 5;}
        if ($enemy->element == 'Fire'){$opstrength = $opstrength + 10;}
        if ($enemy->element == 'Thunder'){$opspeed = $opspeed + 10;}
        if ($enemy->element == 'Ice'){$opstrength = $opstrength + 5; $opstamina = $opstamina + 5;}
        if ($enemy->element == 'Earth'){$opstamina = $opstamina + 10;}
        if ($enemy->element == 'Wind'){$opsense = $opsense + 10;}
        if ($enemy->element == 'Light'){$opspeed = $opspeed + 5; $opsense = $opsense + 5;}
        if ($enemy->element == 'Darkness'){$opstamina = $opstamina + 5; $opsense = $opsense + 5;}
        if ($enemy->companion == 'Sun Horse'){$opmagic = $opmagic + 4;}
        if ($enemy->companion == 'Gem Horse'){$opmagic = $opmagic + 8;}
        if ($enemy->companion == 'Bismuth Bird'){$opmagic = $opmagic + 10;}
        if ($enemy->tail == 'GoldTailRings' || $favpet->tail == 'SilverTailRings'){$opstamina = $opstamina + 3;}
        
        
        // modifier stuff
        $gstatus = 'normal';
        $estatus = 'normal';
        $gmod = 1;
        $emod = 1;
        
        // by default we have 5 or 10 percent dodge chance, depending if enemy is faster. 
        // if our griff has over 90 or 140 speed, add another 5 or 10 percent. 
            // imo it might be better to compare the two speeds and calculate percentages, instead of using absolute numbers
            // eg. if one side is 3x faster than other, or 1.2x, it should differ accordingly. But I'm too lazy to think of a formula yet
        if ($speed > $opspeed) { $gdodge = 10; $edodge = 5; }
        if ($speed <= $opspeed) { $gdodge = 5; $edodge = 10; }
        if ($speed > 90 && $speed <= 140) { $gdodge = $gdodge + 5; }
        if ($speed > 140) { $gdodge = $gdodge + 10; }
        
        // TO DO: finish function that randomly ends statuses, like flight/defend/berserk, and turns the fighter back to normal
        // unfortunately the function refuses to work, guess I need to redo it, or work this into every attack - chance to end other's status
        
        
        
        
        
        // results after battle... show instead of battlefield.
        // I'm a little worried about players refreshing the page after winning and getting the rewards again, and repeatedly injuring enemy
        // hmm, how to stop this?  maybe a time limit between battles? or battling the same enemy at least? once per day?
        
        if($mysidia->input->post("result")){
            $result = $mysidia->input->post("result");
            
            switch ($result){
                case "Win": 
                
                    // some sorta check here - if this griff has already beaten this other griff today, give nothing but message...
                
                    $prize = rand(40,90);
                    $ehe = $enemy->health - 1;
                    if ($ehe < 0){$ehe = 0;}
                    $een = $enemy->energy - 1;
                    if ($een < 0){$een = 0;}
                    $gen = $favpet->energy - 1;
                    if ($gen < 0){$gen = 0;}
                    $currentcash = $mysidia->user->money;
                    $newmoney = $prize + $currentcash;
                    $document->add(new Comment("<div style='width:700px;padding:20px;background-color:white;border-radius:5px;'>
                    <h2>Victory!</h2><p>
                    <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a> <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a></p>
                        Congratulations! That was a magnificent duel! {$gname} managed to overpower {$opname}.<p>You receive {$prize} currency for the victory.<br>(insert some skill gains and EXP here for griff too)<br>{$gname} now has <b>{$gen}</b> energy.
                        </p><a href='http://griffusion.elementfx.com/duel'>Eager for another match?</a></div><br>", FALSE));
                    $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                    $mysidia->db->update("owned_adoptables", array("trophies" => $newtrophy, "energy" => $gen), "aid='{$favid}'");
                    $mysidia->db->update("owned_adoptables", array("health" => $ehe, "energy" => $een), "aid='{$opid}'");
                    $thetime = date("jS M, H:i");
                    $message = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$favid.'\'><b>'.$gname.'</b></a> challenged and defeated <a href=\'levelup/publicprofile/'.$opid.'\'><b>'.$opname.'</b></a> in a duel.';
                    $message2 = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$opid.'\'><b>'.$opname.'</b></a> was challenged by <a href=\'levelup/publicprofile/'.$favid.'\'><b>'.$gname.'</b></a>, and defeated.';
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'battle', "mtext" => $message ));
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $opowner, "date" => $thetime, "mtype" => 'battle', "mtext" => $message2 ));
                    
                break;
                case "Draw": 
                    $prize = rand(20,40);
                    $een = $enemy->energy - 1;
                    if ($een < 0){$een = 0;}
                    $gen = $favpet->energy - 1;
                    if ($gen < 0){$gen = 0;}
                    $currentcash = $mysidia->user->money;
                    $newmoney = $prize + $currentcash;
                    $document->add(new Comment("<div style='width:700px;padding:20px;background-color:white;border-radius:5px;'>
                    <h2>Draw!</h2><p>
                    <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a> <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a></p>
                        Neither griffin was a clear winner, but elders were pleased to see {$opname} and {$gname}'s heartfelt attempts.<p>You're given {$prize} tokens as an encouragement for further training. Your griff has potential!<br>{$gname} now has <b>{$gen}</b> energy.
                        </p><a href='http://griffusion.elementfx.com/duel'>Want to try another match?</a></div><br>", FALSE));
                        $mysidia->db->update("users", array("money" => $newmoney), "username='{$mysidia->user->username}'");
                        $mysidia->db->update("owned_adoptables", array("energy" => $gen), "aid='{$favid}'");
                        $mysidia->db->update("owned_adoptables", array("energy" => $een), "aid='{$opid}'");
                    $thetime = date("jS M, H:i");
                    $message = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$favid.'\'><b>'.$gname.'</b></a> challenged <a href=\'levelup/publicprofile/'.$opid.'\'><b>'.$opname.'</b></a> in a duel, but it was a draw.';
                    $message2 = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$opid.'\'><b>'.$opname.'</b></a> was challenged by <a href=\'levelup/publicprofile/'.$favid.'\'><b>'.$gname.'</b></a>. Neither side won the duel.';
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'battle', "mtext" => $message ));
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $opowner, "date" => $thetime, "mtype" => 'battle', "mtext" => $message2 ));
                    
                break;
                case "Loss": 
                    $een = $enemy->energy - 1;
                    if ($een < 0){$een = 0;}
                    $gen = $favpet->energy - 1;
                    if ($gen < 0){$gen = 0;}
                    $he = $favpet->health - 1;
                    if ($he < 0){$he = 0;}
                    $document->add(new Comment("<div style='width:700px;padding:15px;background-color:white;border-radius:5px;'>
                    <h2>Defeated...</h2><p>
                    <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$favpet->aid}'><img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a> <a href='http://griffusion.elementfx.com/levelup/publicprofile/{$opid}'><img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a></p>
                        That was an impressive victory for {$opname}.<p>{$gname} is slightly injured, not to mention embarrassed...
                        <br>{$gname} now has <b>{$gen}</b> energy and <b>{$he}</b> health left.
                        </p><a href='http://griffusion.elementfx.com/duel'>Want to try again?</a></div><br>", FALSE));
                    $mysidia->db->update("owned_adoptables", array("health" => $he, "energy" => $gen), "aid='{$favid}'");
                    $mysidia->db->update("owned_adoptables", array("energy" => $een), "aid='{$opid}'");
                    $thetime = date("jS M, H:i");
                    $message = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$favid.'\'><b>'.$gname.'</b></a> challenged <a href=\'levelup/publicprofile/'.$opid.'\'><b>'.$opname.'</b></a> to a duel, but was defeated.';
                    $message2 = '<b>'.$thetime.'</b> - <a href=\'flock/manage/'.$opid.'\'><b>'.$opname.'</b></a> was challenged by <a href=\'levelup/publicprofile/'.$favid.'\'><b>'.$gname.'</b></a>, and won.';
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'battle', "mtext" => $message ));
                    $mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $opowner, "date" => $thetime, "mtype" => 'battle', "mtext" => $message2 ));
                        
                break;

            }
       return;
         
       }
        
        
        // begin the actual battlefield. JS was getting long so tucked it away
        
        include 'battlejavascript.php';

$document->add(new Comment("          
<style>#container {background-image:url(http://griffusion.elementfx.com/backgrounds/{$area});background-repeat:repeat;}</style>
<br>
<div id='battlefield'>
<div id='imgholder'>
<div id='griffimg'><a href='levelup/publicprofile/{$favpet->aid}'>
<img src='http://griffusion.elementfx.com/griffsprite/{$favpet->aid}' width='240' height='163'></a></div>
<div id='enemyimg'><a href='levelup/publicprofile/{$opid}'>
<img src='http://griffusion.elementfx.com/griffsprite/{$opid}' width='240' height='163'></a></div>
</div>
<div id='namebars'><div id='griffname'>{$gname}</div> <div id='enemyname'>{$opname}</div></div>
<div id='reports'>Let the battle commence!</div>
<div id='statsbars'><div id='griffstats'>
<div id='griffhp' style='width:100px;display:inline-block;'>Energy: {$health}</div>
<div id='griffmp' style='width:90px;display:inline-block;margin-left:30px;'>Mana: {$mana}</div>
<div id='griffsense'>Sense: {$sense}</div>
<div id='griffspeed'>Speed: {$speed}</div>
<div id='griffstamina'>Stamina: {$stamina}</div>
<div id='griffstrength'>Strength: {$strength}</div>
<div id='griffmagic'>Magic: {$magskill}</div>
<div id='gevade'>Evasion: {$gdodge}</div>
<div id='gstate'>State: {$gstatus} - Mod: {$gmod}</div>
</div>
<div id='enemystats'>
<div id='enemyhealth'>Energy: {$ophealth}</div>
<div id='esense'>Sense: {$opsense}</div>
<div id='espeed'>Speed: {$opspeed}</div>
<div id='estamina'>Stamina: {$opstamina}</div>
<div id='estrength'>Strength: {$opstrength}</div>
<div id='emagic'>Magic: {$opmagic}</div>
<div id='eevade'>Evasion: {$edodge}</div>
<div id='estate'>State: {$estatus} - Mod: {$emod}</div>
</div>
</div>

<div id='actionbox'><br>Choose an action.
<br><button id='Bite'>Bite!</button> <button id='Tackle'>Tackle!</button> <button id='Trick'>Trick!</button> <button id='Fly'>Fly!</button>
.. <button id='defend'>Defend</button> <button id='taunt'>Taunt</button> 
<br>", FALSE));

$document->add(new Comment("<br>(unfinished <button>Force Field</button> <button>Burning Shield</button> <button>Something</button> )

<br></div>
<div id='victory' style='width:500px;padding:5px;border:1px solid black;margin:auto;background-color:white;position:relative;top:-75px;display:none;'>
Reward here.<br>", FALSE));
$this->exploreButton("Win", FALSE, "Claim your reward!");
$document->add(new Comment("<br>
</div>
<br>
<div id='drawn' style='width:500px;padding:5px;border:1px solid black;margin:auto;background-color:white;position:relative;top:-75px;display:none;'>
...<br>", FALSE));
$this->exploreButton("Draw", FALSE, "A good effort!");
$document->add(new Comment("<br>
</div>
<br>
<div id='lost' style='width:500px;padding:5px;border:1px solid black;margin:auto;background-color:white;position:relative;top:-75px;display:none;'>
...<br>", FALSE));
$this->exploreButton("Loss", FALSE, "Oh, well...");
$document->add(new Comment("<br>
</div>

</div>
<br>
</div>",FALSE));
         
    }
  } 
}    
?>