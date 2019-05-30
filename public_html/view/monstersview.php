<?php

class MonstersView extends View{

	public function index(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Monsters");
	
	$mon = $mysidia->db->select("enemies", array(), "area='any' OR area='ice' ORDER BY RAND() LIMIT 1")->fetchObject(); //randomly select monster from table
	$mid = $mon->eid;
	
	$profile = $mysidia->user->getprofile();
	if ((int)$profile->getFavpetID() == 0) { 
            $document->addLangVar("<p>You don't have a companion, and you need one to battle!</p>"); 
        return; 
        }
        
    $favpet = new OwnedAdoptable($profile->getFavpetID());
    $favpetID = $profile->getFavpetID(); //need this so I can pass it to ajax...
    
    if ($favpet->currentlevel < 3){ 
            $document->add(new Comment("<br><a href='/pet/profile/{$favpet->aid}'><img src='{$favpet->getImage()}'></a>
            <br>Sorry, your companion looks too young to fight. Come back when they're older!
            ", FALSE)); 
      return; 
        }
	
	$aah = "<div id='aah'>A wild <b>{$mon->name}</b> looks threatening. What to do?<br>
	<button id='ignorebtn'>Ignore it</button> <button id='fightbtn' data-monster='{$mid}'>Fight it</button></div>";
	
	$document->add(new Comment("<h1>Monsters!</h1><p>There's a chance for random monsters to attack you here. Oh, here's one!<br>
	Your current companion is <b>{$favpet->name}</b>.",FALSE));
	
	
	$document->add(new Comment("{$aah}<p><span id='attack_result'></span></p>
	<script>$(function() {
	
	$('#ignorebtn').click(function() { $('#aah').fadeOut(500); });
	
	$('#fightbtn').click(function() {
	var enemy = $(this).data('monster'); var aid = $('#fighter').val(); var username = '{$mysidia->user->username}'; var favpetID = '{$favpetID}';
	
	$.ajax({  type: 'POST', url: '/ajax/monsterfight.php', data: { whatdo : 'startbattle', aid : aid, username : username, enemy : enemy, favpetID : favpetID },
	success: function(result){ 
	  if( $.isNumeric(result) ){  // if everything went OK, we got the id number of new battle...
	  $('#attack_result').html('The fight begins! Raargh!'); 
	  window.location.replace('/monsters/fight/'+result); } // go to the fight now
	  else{ $('#attack_result').html(result); } // error msg
	 }
	}); return false; });
	
	});</script>
	", FALSE));
	
	}
	
	public function fight(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Monster Fight");
	
	// check that this battle ID exists, and one of your griffs is in it. Not necessarily your active one
	$fullurl = $_SERVER['REQUEST_URI'];
	$scrub = explode('/',trim($fullurl,'/'));
	$bid = end($scrub);
	$battle = $mysidia->db->select("wildbattles", array(), "id='${bid}'")->fetchObject();
	// exists?
	if($bid == 'fight' || !$battle){ $document->add(new Comment("<h2>Silence...</h2><p>There is nothing going on here.</p><meta http-equiv='refresh' content='1; url=/monsters'>",FALSE)); return; }
	// yours?
	$owner = $mysidia->db->select("owned_adoptables", array("owner"), "aid='{$battle->pet}'")->fetchColumn();
	if($owner != $mysidia->user->username){ $document->add(new Comment("<h2>None of your business!</h2>
	<p>None of your griffins are involved here.</p><meta http-equiv='refresh' content='1; url=/monsters'>",FALSE)); return; }
	// still going on?
	if($battle->status == 'over'){ $document->add(new Comment("<h2>Silence...</h2>
	<p>Nothing happening here. The fight already ended.</p><meta http-equiv='refresh' content='1; url=/monsters'>",FALSE)); return; }
	
	// start getting stuff
	$griff = $mysidia->db->select("owned_adoptables", array(), "aid='{$battle->pet}'")->fetchObject();
	$enemy = $mysidia->db->select("enemies", array(), "eid='{$battle->enemy}'")->fetchObject();
	$enemy_img = $mysidia->db->select("enemies", array("image_url"), "eid='{$battle->enemy}'")->fetchColumn();
	
	// our stats. These won't be passed to AJAX, just nice to show the numbers in initial display
        $health = $griff->health; $sense = $griff->sense; $speed = $griff->speed; $stamina = $griff->stamina; $strength = $griff->strength;
        $bite = $speed + $strength; $tackle = $strength + $stamina; $trick = $sense + $speed;
	// enemy stats
        $ophealth = 100; $opsense = $enemy->sense; $opstamina = $enemy->stamina; $opstrength = $enemy->strength;
        $opspeed = $enemy->speed; $opbite = $opspeed + $opstrength; $optackle = $opstrength + $opstamina; $optrick = $opsense + $opspeed;
        
        $species = $griff->type;
        
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
	
	$document->add(new Comment("
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
        <h2>{$griff->name} - Lv {$griff->currentlevel}</h2>
        <img src='{$griff->imageurl}'>
        <p>
            <div class='dropdown'>
                <span><b><u>Fight!</u></b></span>
                <div class='dropdown-content'>
                    <button class='choosemove' data-move='bite'>{$atk_name}!</button></br>
                    <button class='choosemove' data-move='tackle'>Tackle!</button> 
                    <button class='choosemove' data-move='trick'>Trick!</button></br>
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
    <div class='item3' id='reports'><b>{$enemy->name}</b> leaps forward to battle!</div>  
    <div class='item4'>
        <h2>{$enemy->name}</h2>
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
	</div>"));
//<button onclick='history.go(-1);'>Return to last page (TESTING ONLY!)</button>
	$document->add(new Comment("
	<div class='backtoflock'><button class='choosemove' data-move='flee' style='height:30px;width:100px;margin:5px;background-color:#f9ac9d;border:1px solid #7c2a1a;'>Surrender!</button></div>
	</p>


<p><span id='uhoh'></span></p>

<div id='victorybox' class='endbox'><h2>Victory!</h2><br>{$griff->name} defeated the monster!<br><span id='expgained'></span></p><button onclick='window.history.back();'>Return to last page</button></div>
<div id='drawbox' class='endbox'><h2>Draw!</h2>{$griff->name} and the monster fought but there was no clear winner - the monster eventually fled...</p><button onclick='window.history.back();'>Return to last page</button></div>
<div id='defeatbox' class='endbox'><h2>Defeat!</h2><br>Ouch, {$griff->name} lost the fight, and narrowly escaped.<br><button onclick='window.history.back();'>Return to last page</button></div>

<script>
$(function() { 
var maxhp = {$health}; var maxehp = {$ophealth};

function updateHealth(ghp) { 
var newpercent = Math.round((ghp / maxhp) * 100);
$('#healthInner').animate({ width: newpercent + '%' }, 500);
}
function updateEnHealth(ehp) {
var newpercent = Math.round((ehp / maxehp) * 100);
$('#enhealthInner').animate({ width: newpercent + '%' }, 500);
}

    // single function is used for all the buttons. They share a class, but you can store other data in each button
    $('.choosemove').click(function () {
	var battleid = {$bid};
	var move = $(this).data('move'); 
	$.ajax({  type: 'POST', async: false, dataType: 'json', url: '/ajax/monsterfight.php', 
	data: { whatdo : 'makemove', move : move, battleid : battleid },
	success: function(results){ 
	
	 // now we have an array. To pick out different values, use results.this or results.that
	 // must match what you called them in script
	 
	 if(results.success == 'no'){ $('#uhoh').html(results.errormsg); } // sth went wrong, show error msg
	 
	 else if(results.success == 'over'){ $('#reports').append(results.report);  // used when fleeing, send back to forest
	 var latest = document.getElementById('reports'); latest.scrollTop = latest.scrollHeight;
	 history.go(-1); }
	 
	 else if(results.success == 'win'){ $('#reports').append(results.report);
	 updateHealth(results.newhp); updateEnHealth(results.newehp);
	  $('#griffhealth').html(results.newhp); $('#enemyhealth').html(results.newehp);
	  var latest = document.getElementById('reports'); latest.scrollTop = latest.scrollHeight;
	  $('#victorybox').show(); $('#expgained').html(results.finalmsg);
	 } 
	 else if(results.success == 'loss'){ $('#reports').append(results.report);
	 updateHealth(results.newhp); updateEnHealth(results.newehp);
	  $('#griffhealth').html(results.newhp); $('#enemyhealth').html(results.newehp);
	  var latest = document.getElementById('reports'); latest.scrollTop = latest.scrollHeight;
	  $('#defeatbox').show();
	 } 
	 else if(results.success == 'draw'){ $('#reports').append(results.report);
	 updateHealth(results.newhp); updateEnHealth(results.newehp);
	  $('#griffhealth').html(results.newhp); $('#enemyhealth').html(results.newehp);
	  var latest = document.getElementById('reports'); latest.scrollTop = latest.scrollHeight;
	  $('#drawbox').show();
	 } 
	 
	 else{ $('#uhoh').html('');  // move was carried out successfully, both still fighting, clear any previous error msg
	  $('#reports').append(results.report); 
	  updateHealth(results.newhp); updateEnHealth(results.newehp);
	  $('#griffhealth').html(results.newhp); $('#enemyhealth').html(results.newehp);
	  var latest = document.getElementById('reports'); latest.scrollTop = latest.scrollHeight;
	 }
	 
	}
	});  return false;
    });
    
});
</script>

",FALSE));
	
	}

}
?>