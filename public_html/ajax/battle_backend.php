<?php

include '../ajax/useful_ajax.php';

function battle(){
	$whatdo = sanitizeInput($_POST['whatdo']); $battleid = sanitizeInput($_POST['battleid']); $move = sanitizeInput($_POST['move']);
	
	include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	// wild battle backend script
	
if($whatdo == 'makemove'){

$success = ''; $report = ''; $finalmsg = ''; // finalmsg is for exp + other reward gain message, at battle's end

  $sql1 = "SELECT * FROM adopts_wildbattles WHERE id='{$battleid}' LIMIT 1";
  if($result1 = mysqli_query($db, $sql1)){
    $rows = mysqli_fetch_object(mysqli_query($db,$sql1));
    if(count($rows)){
    // battle exists
    $battle = $result1->fetch_assoc(); $gr = $battle['pet']; $en = $battle['enemy'];
    // assume that griff and monster exist
	$pet = get_adopt($gr,$db); $enemy = get_enemy($en,$db);
	$gname = $pet['name']; $gwins = $pet['wildwins']; $gdraws = $pet['wilddraws']; $glosses = $pet['wildlosses'];
	$ename = $enemy['name']; 
	
	// OK, we've got the battle and both sides. Where to start?! aaaa
	// I suppose the Flee/Surrender move should go first. Automatic loss for you, but griff won't lose any energy etc
	
	if($move == 'flee'){
	$glosses = $glosses + 1;
	   $end1 = "UPDATE adopts_wildbattles SET status = 0 WHERE id='{$battleid}'"; // close battle
	   $end2 = "UPDATE adopts_owned_adoptables SET inbattle = 'no', losses = '{$glosses}' WHERE aid='{$gr}'"; // remove from battle
	   if(mysqli_query($db, $end1)){
	    if(mysqli_query($db, $end2)){
	     $success = 'over'; $report = "<br>{$gname} gave up and ran away!</b>";
	   }else{$success = 'no'; $report = "Could not withdraw your pet from fight...";}
	  }else{$success = 'no'; $report = "Could not end fight...";}
	}
         
	else{ // not fleeing. let's fetch all the stats and set up some formulae!
	$gstrength = $pet['strength']; $gstamina = $pet['stamina']; $gspeed = $pet['speed']; $gsense = $pet['sense'];
	$estrength = $enemy['strength']; $estamina = $enemy['stamina']; $espeed = $enemy['speed']; $esense = $enemy['sense']; $emax = $enemy['maxlevel'];
	$ghp = $battle['ghp']; $ehp = $battle['ehp']; $enemylevel = mt_rand(1,$emax);
	
	// battle table holds the current, temporary HP values, like 34, out of 100 total.
	// if you want stat buffs/debuffs, you'll have to copy those stats into battle table too, to hold changed amounts
	
	// optional: use level to increase base stats here. I multiply lvl by 2 and add it on
	//$glevel = ($pet['currentlevel'] * 2); $elevel = ($enemylevel * 2);
	//$gstrength = $gstrength + $glevel; $gstamina = $gstamina + $glevel; $gspeed = $gspeed + $glevel; $gsense = $gsense + $glevel;
	//$estrength = $estrength + $elevel; $estamina = $estamina + $elevel; $espeed = $espeed + $elevel; $esense = $esense + $elevel;
	
	// measuring physical power. If one has >80 points and other <40, they'll do +50% and -50% damage to each other. 50% is the max range
	$gpower = $gstrength + $gstamina; $epower = $estrength + $estamina;
	if($gpower > $epower){ $diff = (($gpower - $epower) / ($gpower)) * 100;  $diff = ceil($diff); if($diff > 50){$diff = 50;}
	$diff = ($diff / 100); $gmod = (1 + $diff); $emod = (1 - $diff); }
	
	else{ $diff = (($epower - $gpower) / ($epower)) * 100;  $diff = ceil($diff); if($diff > 50){$diff = 50;}
	$diff = ($diff / 100); $gmod = (1 - $diff); $emod = (1 + $diff); }
	// we get decimals, ranging from 0.5 to 1.5, to multiply the physical attacks by later
	
	// um, I have to think of a formula for evasion still... some sort of comparison between the two speeds and senses
	
	// simple attacks. If user chose 'Own Choice' the griff will choose any move
	// optional: the less happy your griffin is, the more likely they'll disobey you and do own thing
	$rand1 = mt_rand(1,15); $gbite = ceil(($gspeed + $gstrength + $rand1) * $gmod);
	$rand2 = mt_rand(1,15); $gtackle = ceil(($gstrength + $gstamina + $rand2) * $gmod);
	$rand3 = mt_rand(1,15); $gtrick = ceil(($gsense + $gspeed + $rand3) * $gmod);
	$rand4 = mt_rand(1,15); $ebite = ceil(($espeed + $estrength + $rand4) * $emod);
	$rand5 = mt_rand(1,15); $etackle = ceil(($estrength + $estamina + $rand5) * $emod);
	$rand6 = mt_rand(1,15); $etrick = ceil(($esense + $espeed + $rand6) * $emod);
	$attacks = array('bite','tackle','trick');
	
	if($move == 'random'){ $move = $attacks[array_rand($attacks, 1)]; }
	$emove = $attacks[array_rand($attacks, 1)];
	
	// now carry out the move, whatever it is, and enemy retaliates if we didn't knock them out
	if($move == 'bite'){$ehp = $ehp - $gbite; $dmg = $gbite;}
	elseif($move == 'tackle'){$ehp = $ehp - $gtackle; $dmg = $gtackle;}
	else{$ehp = $ehp - $gtrick; $dmg = $gtrick;}
	// is enemy still up?
	if($ehp > 0){
	  if($emove == 'bite'){$ghp = $ghp - $ebite; $edmg = $ebite;}
	  elseif($emove == 'tackle'){$ghp = $ghp - $etackle; $edmg = $etackle;}
	  else{$ghp = $ghp - $etrick; $edmg = $etrick;}
	  
	  if($ghp > 0){ // we survived their counterattack
	    $upd1 = "UPDATE adopts_wildbattles SET ghp = '{$ghp}', ehp = '{$ehp}' WHERE id='{$battleid}'";
	    if(mysqli_query($db, $upd1)){
	    $success = 'yes'; $report = "<p>{$gname} used <b>{$move}</b>! Took {$dmg} energy.<br>{$ename} responded with <b>{$emove}</b>,  taking {$edmg} energy!</p>";
	    }else{$success = 'no'; $report = "Couldn't update energy...";}
	
	  }else{ // their counterattack defeated us
	  $glosses = $glosses + 1; $ghp = 0; 
	    $upd2 = "DELETE FROM adopts_wildbattles WHERE id='{$battleid}'";
	    $upd3 = "UPDATE adopts_owned_adoptables SET inbattle = 'no', wildlosses = '{$glosses}' WHERE aid='{$gr}'";
	    if(mysqli_query($db, $upd2)){
	     if(mysqli_query($db, $upd3)){
		
		$success = 'loss'; $report = "<p>{$gname}used <b>{$move}</b>! Took {$dmg} energy.<br>{$ename} responded with <b>{$emove}</b>,  taking {$edmg} energy!<br>Oh no, {$gname} is exhausted and had to run from the monster!</p>";
		
	     }else{$success = 'no'; $report = "Couldn't remove your pet from fight...";}
	    }else{$success = 'no'; $report = "Couldn't end fight...";}
	  }
	
	 }else{ // enemy was defeated by our attack, they couldn't retaliate
	   $gwins = $gwins + 1; $ehp = 0; $myname = $pet['owner'];
	   $upd7 = "DELETE FROM adopts_wildbattles WHERE id='{$battleid}'";
	   $upd8 = "UPDATE adopts_owned_adoptables SET inbattle = 'no', wildwins = '{$gwins}' WHERE aid='{$gr}'";
	   if(mysqli_query($db, $upd7)){
	     if(mysqli_query($db, $upd8)){
	   
		// get some XP. if you're below enemy's level you get more, if you're above them it decreases
		$glvl = $pet['currentlevel']; $elvl = $enemylevel; 
		$lvldiff = $elvl - $glvl;
		if($lvldiff < 0){$lvldiff = 1;} if($lvldiff > 20){$lvldiff = 30;}
		if($glvl > 50){$lvldiff = $lvldiff + 20;} elseif($glvl > 30){$lvldiff = $lvldiff + 10;}
		$randlvl = mt_rand(2,4); $randexp = $randlvl + $lvldiff; 
		
		//$giveexp = give_exp($gr,$randexp,$db); // extra message, output in victory div
		$giveexp = "no";
		if($giveexp == 'no'){ $finalmsg = "{$gname} could not earn EXP, oddly..."; }else{ $finalmsg = $giveexp; }
		
		$success = 'win'; $report = "<p>{$gname}used <b>{$move}</b>! Took {$dmg} energy.<br>{$ename} was defeated.<br><b>Congratulations! You won the fight.</b></p>";
		
	    }else{$success = 'no'; $report = "Couldn't remove your pet from fight...";}
	  }else{$success = 'no'; $report = "Couldn't end fight...";}
	  
	}
	// haven't added any backfiring/recoil moves yet, so there can't be draws
	
	} // end of non-flee
	
    
    }else{$success = 'no'; $report = "This fight could not be found. Maybe it ended already?";}
  }else{$success= 'no'; $report = "Database problem: could not connect, to look up fight...";}

return json_encode(array("success" => $success, "report" => $report, "newghp" => $ghp, "newehp" => $ehp, "finalmsg" => $finalmsg));

}


else return "No action chosen...";
}
echo battle();
?>