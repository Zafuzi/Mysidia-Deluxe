<?php
include '../ajax/useful_ajax.php';

function games(){ 
	$whatdo = sanitizeInput($_POST['whatdo']); $uid = sanitizeInput($_POST['uid']); $target = sanitizeInput($_POST['target']);
	
	include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);

if($whatdo == 'memory'){ // this one is very simple. I decided not to use the click number

  // check how many times claimed today
  $sql = "SELECT memory FROM `adopts_users_activity` WHERE uid = {$uid}";
  if($result = mysqli_query($db,$sql)){
    $mem = $result->fetch_assoc(); $memory = $mem['memory'];
    if($memory < 3){ $memory = $memory + 1;
      
      // fetch a prize, from huge random list
      $prizes = array(257,258,259,261,262,265,268,273,274,277,280,283,284,285,286,291,292,303,304,305,306,307,308,309,312,313,314,340,341,1,
      2,3,4,5,361,362,363,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380342,343,344,345,346,347,348,350,351,
      353,355,356,358,359,360,26,27,28,31,32,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,
      71,72,73,74,75,76, 77,78,79,80,89,90,91,92);
	$prize = $prizes[array_rand($prizes,1)]; $give = give_itemid($prize,1,$uid,$db); 
	if($give == 'yes'){ $item = get_itemfromid($prize,$db); $itemname = $item['itemname'];
	  $message = "Here you go!<br>You received a free <b>{$itemname}</b>.";
	}else{ return json_encode(array("success" => 'no', "text" => "Could not send an item to your inventory! Try again?")); }
      
      // prize was given, update
      $sql2 = "UPDATE `adopts_users_activity` SET memory = {$memory} WHERE uid = {$uid}";
      if(mysqli_query($db,$sql2)){
        return json_encode(array("success" => 'yes', "text" => $message, "plays" => $memory));
      }
      
    }else{ return json_encode(array("success" => 'done', "text" => "You have already claimed 3 prizes today. Come back tomorrow!")); }
  }else{ return json_encode(array("success" => 'no', "text" => "DB problem, could not check how many prizes claimed today...")); }

}


if($whatdo == 'jigsaw'){ // can claim 3 rewards per day, and tougher puzzle means better rewards

  // check how many times claimed today
  $sql = "SELECT jigsaw FROM `adopts_users_activity` WHERE uid = {$uid}";
  if($result = mysqli_query($db,$sql)){
    $jiggy = $result->fetch_assoc(); $jigsaw = $jiggy['jigsaw'];
    if($jigsaw < 3){ $jigsaw = $jigsaw + 1;
      
      // fetch a prize
      if($target == 3){ // easiest puzzle, 3x3, get a food item
	$prizes = array(257,258,259,261,262,265,268,273,274,277,280,283,284,285,286,291,292,303,304,305,306,307,308,309,312,313,314,340,341, 342,343,344,345,346,347,348,350,351,353,355,356,358,359,360);
	$prize = $prizes[array_rand($prizes,1)]; $give = give_itemid($prize,1,$uid,$db); 
	if($give == 'yes'){ $item = get_itemfromid($prize,$db); $itemname = $item['itemname'];
	  $message = "Food!<br>You received a free <b>{$itemname}</b>.";
	}else{ return json_encode(array("success" => 'no', "text" => "Could not send an item to your inventory! Try again?")); }
      }
      
      if($target == 5){ // mid puzzle, 5x5, get a craft item
	$prizes = array(26,27,28,31,32,42,43,44,45,46,47,48,49,50,51,52,53,54,55,56,57,58,59,60,61,62,63,64,65,66,67,68,69,70,71,72,73,74,75,76, 77,78,79,80,89,90,91,92);
	$prize = $prizes[array_rand($prizes,1)]; $give = give_itemid($prize,1,$uid,$db); 
	if($give == 'yes'){ $item = get_itemfromid($prize,$db); $itemname = $item['itemname'];
	  $message = "Time to get creative!<br>You received a free <b>{$itemname}</b>.";
	}else{ return json_encode(array("success" => 'no', "text" => "Could not send an item to your inventory! Try again?")); }
      }
      
      if($target == 7){ // harder puzzle, 7x7, get literature or wearable item
	$prizes = array(1,2,3,4,5,361,362,363,364,365,366,367,368,369,370,371,372,373,374,375,376,377,378,379,380);
	$prize = $prizes[array_rand($prizes,1)]; $give = give_itemid($prize,1,$uid,$db); 
	if($give == 'yes'){ $item = get_itemfromid($prize,$db); $itemname = $item['itemname'];
	  $message = "Something to read!<br>You received a free <b>{$itemname}</b>.";
	}else{ return json_encode(array("success" => 'no', "text" => "Could not send an item to your inventory! Try again?")); }
      }
      
      // prize was given, update
      $sql2 = "UPDATE `adopts_users_activity` SET jigsaw = {$jigsaw} WHERE uid = {$uid}";
      if(mysqli_query($db,$sql2)){
        return json_encode(array("success" => 'yes', "text" => $message, "plays" => $jigsaw));
      }
      
    }else{ return json_encode(array("success" => 'done', "text" => "You have already claimed 3 prizes today. Come back tomorrow!")); }
  }else{ return json_encode(array("success" => 'no', "text" => "DB problem, could not check how many prizes claimed today...")); }

}


}
echo games();
?>