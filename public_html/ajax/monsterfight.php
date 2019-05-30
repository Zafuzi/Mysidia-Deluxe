<?php
function sanitizeInput($pt){  // in case user sends sth weird, somehow
$pt = trim($pt);
$pt = stripslashes($pt);
$pt = htmlspecialchars($pt);
return $pt;
}

function monstersRargh(){
	$aid = sanitizeInput($_POST['aid']); $username = sanitizeInput($_POST['username']); $whatdo = sanitizeInput($_POST['whatdo']);
	$battleid = sanitizeInput($_POST['battleid']); $move = sanitizeInput($_POST['move']); $enemy = sanitizeInput($_POST['enemy']); $favpetID = sanitizeInput($_POST['favpetID']);
	
	include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	//return "testing";
	
if($whatdo == 'startbattle'){ // accepted offer on monsters page, create new battle with it, if griff is suitable

 if ((int)$favpetID == 0) {return "<p>You don't have a companion, and you need one to battle!</p>";}
 if($enemy == ''){return "Huh? There are no monsters around after all.";} // not sure how this'd happen but you never know

$sql = "SELECT * FROM adopts_owned_adoptables WHERE aid='{$favpetID}' ORDER BY aid ASC LIMIT 1";
if ($result = mysqli_query($db, $sql)){ 
 $pet = $result->fetch_assoc(); $owner = $pet['owner']; // check we own griff right now, in case of trade or sth
 $stage = $pet['currentlevel']; $health = $pet['health']; $gname = $pet['name'];
 $ghp = $pet['health'];
 /* 
 Optional: check current location, if you want certain monsters to only appear in some places.
 This will stop players messing with multiple open pages/tabs to start fights after leaving an area.
 You could also send a location var from page, and then check this; if they're different, warn player and/or choose a different monster now
 $location = $pet['location']; 
 */
 if($username == $owner){
  if($stage > 2 && $health > 10){
   // see if enemy exists, get its max HP to start the fight with
   $sql2 = "SELECT * FROM adopts_enemies WHERE eid='{$enemy}' ORDER BY eid ASC LIMIT 1";
   if($result2 = mysqli_query($db, $sql2)){
    $en = $result2->fetch_assoc(); $ehp = 100;
   
	// both sides are good to go, create a new battle, get its ID using the code, and return that number
	$code = substr(md5(uniqid(mt_rand(), true)) , 0, 18);
	$newbattle = "INSERT INTO adopts_wildbattles (`code`, `status`, `enemy`, `maxehp`, `ehp`, `pet`, `maxphp`, `php`)  VALUES ('$code', '1', '$enemy', '$ehp', '$ehp', '$favpetID', '$ghp', '$ghp')";
	 if (mysqli_query($db,$newbattle)){ 
	  $sql3 = "SELECT * FROM adopts_wildbattles WHERE code='{$code}'";
	  if ($result3 = mysqli_query($db, $sql3)){
	   $bat = $result3->fetch_assoc(); $bid = $bat['id'];
	   // optional: set griff to 'busy in battle' status, so they can't do anything else until it's over somehow
	   $sql4 = "UPDATE adopts_owned_adoptables SET inbattle = '{$bid}' WHERE aid='{$favpetID}'";
	      
	   if (mysqli_query($db, $sql4)){
		// finally! return the ID so page can redirect user to the battle.
		// Must be a number, no letters etc, or jQuery won't be able to differentiate it from the other messages
		return $bid; 
		
	  }else{return "Could not enter your pet in fight...";}
	 }else {return "Could not fetch fight ID...";}
	}else{return "Could not begin fight...";}
   
   }else{return "Could not look up enemy.";}
  }else{return "{$gname} is not fit to fight right now.";}
 }else{return "You are not {$gname}'s owner!";}
}else{return "Could not look up pet info.";}

}


else if($whatdo == 'makemove'){ // in battle, griff does an attack or whatever

$success = ''; $texty = ''; $errormsg = ''; $finalmsg = '';

  $sql1 = "SELECT * FROM adopts_wildbattles WHERE id='{$battleid}' LIMIT 1";
  if($result1 = mysqli_query($db, $sql1)){
    $rows = mysqli_fetch_object(mysqli_query($db,$sql1));
    if(count($rows)){
    // battle exists
      $battle = $result1->fetch_assoc(); $gr = $battle['pet']; $en = $battle['enemy']; $bstatus = $battle['status'];
      if($bstatus == 1){
      $sql2 = "SELECT * FROM adopts_owned_adoptables WHERE aid='{$gr}'";
      $sql3 = "SELECT * FROM adopts_enemies WHERE eid='{$en}'";
      if($result2 = mysqli_query($db, $sql2)){
       $rows2 = mysqli_fetch_object(mysqli_query($db,$sql2));
       if(count($rows2)){
	 if($result3 = mysqli_query($db, $sql3)){
	 $rows3 = mysqli_fetch_object(mysqli_query($db,$sql3));
	 if(count($rows3)){
	 // griff and enemy exist
	   $pet = $result2->fetch_assoc(); $enemy = $result3->fetch_assoc();
	   $gname = $pet['name']; $gwins = $pet['wildwins']; $gdraws = $pet['wilddraws']; $glosses = $pet['wildlosses'];
	   $ename = $enemy['name']; 
	
	// OK, we've got the battle and both sides. Where to start?! aaaa
	// I suppose the Flee/Surrender move should go first. Automatic loss for you, but griff won't lose any energy etc
	
	if($move == 'flee'){
	$glosses = $glosses + 1;
	   $end1 = "UPDATE adopts_wildbattles SET status = 0 WHERE id='{$battleid}'"; // close battle
	   $end2 = "UPDATE adopts_owned_adoptables SET inbattle = 'no' WHERE aid='{$gr}'"; // remove from battle
	   if(mysqli_query($db, $end1)){
	    if(mysqli_query($db, $end2)){
	     $success = 'over'; $texty = "<br>{$gname} gave up and ran away!</b>";
	   }else{$success = 'no'; $errormsg = "Could not withdraw your pet from fight...";}
	  }else{$success = 'no'; $errormsg = "Could not end fight...";}
	}
         
	else{ // not fleeing. let's fetch all the stats and set up some formulae!
	$gstrength = $pet['strength']; $gstamina = $pet['stamina']; $gspeed = $pet['speed']; $gsense = $pet['sense'];
	$estrength = $enemy['strength']; $estamina = $enemy['stamina']; $espeed = $enemy['speed']; $esense = $enemy['sense'];
	$ghp = $battle['php']; $ehp = $battle['ehp']; $enemylevel = mt_rand(1,10);
	
	// battle table holds the current, temporary HP values, like 34, out of 100 total.
	// if you want stat buffs/debuffs, you'll have to copy those stats into battle table too, to hold changed amounts
	
	// optional: use level to increase base stats here. I multiply lvl by 2 and add it on
	$glevel = ($pet['currentlevel'] * 2); $elevel = ($enemylevel * 2);
	$gstrength = $gstrength + $glevel; $gstamina = $gstamina + $glevel; $gspeed = $gspeed + $glevel; $gsense = $gsense + $glevel;
	$estrength = $estrength + $elevel; $estamina = $estamina + $elevel; $espeed = $espeed + $elevel; $esense = $esense + $elevel;
	
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
	    $upd1 = "UPDATE adopts_wildbattles SET php = '{$ghp}', ehp = '{$ehp}' WHERE id='{$battleid}'";
	    if(mysqli_query($db, $upd1)){
	    $success = 'yes'; $texty = "<p>{$gname} {$warn} used <b>{$move}</b>! Took {$dmg} energy.<br>{$ename} responded with <b>{$emove}</b>,  taking {$edmg} energy!</p>";
	    }else{$success = 'no'; $errormsg = "Couldn't update energy...";}
	
	  }else{ // their counterattack defeated us
	  $glosses = $glosses + 1; $ghp = 0; 
	    $upd2 = "UPDATE adopts_wildbattles SET ghp = '0', ehp = '{$ehp}', status = '0' WHERE id='{$battleid}'";
	    $upd3 = "UPDATE adopts_owned_adoptables SET inbattle = 'no' WHERE aid='{$gr}'";
	    if(mysqli_query($db, $upd2)){
	     if(mysqli_query($db, $upd3)){
		
		$success = 'loss'; $texty = "<p>{$gname} {$warn} used <b>{$move}</b>! Took {$dmg} energy.<br>{$ename} responded with <b>{$emove}</b>,  taking {$edmg} energy!<br>Oh no, {$gname} is exhausted and had to run from the monster!</p>";
		
	     }else{$success = 'no'; $errormsg = "Couldn't remove your pet from fight...";}
	    }else{$success = 'no'; $errormsg = "Couldn't end fight...";}
	  }
	
	 }else{ // enemy was defeated by our attack, they couldn't retaliate
	   $gwins = $gwins + 1; $ehp = 0; $myname = $pet['owner'];
	   $upd7 = "UPDATE adopts_wildbattles SET php = '{$ghp}', ehp = '0', status = '0' WHERE id='{$battleid}'";
	   $upd8 = "UPDATE adopts_owned_adoptables SET inbattle = 'no', wildwins = '{$gwins}' WHERE aid='{$favpetID}'";
	   if(mysqli_query($db, $upd7)){
	     if(mysqli_query($db, $upd8)){
	   
		// get some XP. if you're below enemy's level you get more, if you're above them it decreases
		$glvl = $pet['currentlevel']; $elvl = $enemylevel; 
		$lvldiff = $elvl - $glvl;
		if($lvldiff < 0){$lvldiff = 1;} if($lvldiff > 20){$lvldiff = 30;}
		if($glvl > 50){$lvldiff = $lvldiff + 20;} elseif($glvl > 30){$lvldiff = $lvldiff + 10;}
		$randlvl = mt_rand(2,4); $randexp = $randlvl + $lvldiff; 
		$newexp = $pet['totalclicks'] + $randexp;
		$exp1 = "UPDATE adopts_owned_adoptables SET totalclicks = '{$newexp}' WHERE aid = '{$favpetID}'";
		if(mysqli_query($db, $exp1)){
		$finalmsg = "{$gname} gained <b>{$randexp}</b> EXP!"; // extra message, output in victory div
		
		$success = 'win'; $texty = "<p>{$gname} {$warn} used <b>{$move}</b>! Took {$dmg} energy.<br>{$ename} was defeated.<br><b>Congratulations! You won the fight.</b><br>(was monster killed? ran away? if wild breed, chance to capture them now, or find an egg of theirs nearby?<br>either way, give items dropped by monster)</p>";
		
		$nextlvl = $glvl + 1; if($glvl == 100){$nextlvl = 100;}
		 $exp2 = "SELECT * FROM adopts_levels WHERE adoptiename = 'n' AND thisislevel='{$nextlvl}'";
		 if($getlevel = mysqli_query($db, $exp2)){
		  $nuu = $getlevel->fetch_assoc(); $requiredexp = $nuu['requiredclicks'];
		  if($newexp >= $requiredexp){
		    $exp3 = "UPDATE adopts_owned_adoptables SET currentlevel = '{$nextlvl}' WHERE aid='{$favpetID}'";
		    if(mysqli_query($db, $exp3)){
			$finalmsg .= "... and reached a new level!"; 
		    }else{$success = 'no'; $errormsg = "Could not update level...";}
		  } // not enough for next level
		 }else{$success = 'no'; $errormsg = "Could not look up EXP requirement for next level...";}
		
		
		}else{$success = 'no'; $errormsg = "Could not award EXP...";}
		// end of exp-giving section
		
	    }else{$success = 'no'; $errormsg = "Couldn't remove your griffin from fight...";}
	  }else{$success = 'no'; $errormsg = "Couldn't end fight...";}
	  
	}
	// haven't added any backfiring/recoil moves yet, so there can't be draws
	
	} // end of non-flee
	
	}else{$success = 'no'; $errormsg = "Could not fetch monster's details.";}
	}else{$success = 'no'; $errormsg = "Database problem: could not look up monster...";}
       }else{$success = 'no'; $errormsg = "Could not fetch your griffin's details.";}
      }else{$success = 'no'; $errormsg = "Database problem: could not look up your griffin...";}
     }else{$success = 'no'; $errormsg = "This fight seems to have ended. No more moves may be made.";}
    }else{$success = 'no'; $errormsg = "Database problem: could not find this fight, ID ".$battleid."...";}
  }else{$success= 'no'; $errormsg = "Database problem: could not connect...";}

return json_encode(array("success" => $success, "errormsg" => $errormsg, "report" => $texty, "newhp" => $ghp, "newehp" => $ehp, "finalmsg" => $finalmsg));

}


else return "No action chosen...";
}
echo monstersRargh();
?>