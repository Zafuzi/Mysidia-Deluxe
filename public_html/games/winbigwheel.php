<?php


include '../ajax/minigames.php';
//include '../ajax/useful_ajax.php';
function winbigwheel(){ 
	$whatdo = sanitizeInput($_POST['whatdo']); $uid = sanitizeInput($_POST['uid']); $target = sanitizeInput($_POST['target']);
	
	include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	// script for minigame prizes
	
if($whatdo == 'wbwheel'){
  
  // first check if this user has spun already. The 'games' DB table is cleared every night
  $sql = "SELECT wbwheel FROM `adopts_users_profile` WHERE uid = {$uid} ORDER BY uid LIMIT 1"; 
  if($result = mysqli_query($db,$sql)){
    
    $prof = $result->fetch_assoc(); $plays = $prof['wbwheel']; $newplays = $plays + 1;
    if($plays > 2){return "You have already spun 3 times today, come back tomorrow!";}
    // go ahead and add 1 spin
    $upd = "UPDATE `adopts_users_profile` SET wbwheel = {$newplays} WHERE uid = {$uid}";
     if(mysqli_query($db,$upd)){
       $continue = 'yes';
     }else{return "DB problem, could not update your spins...";}
   
  }else{return "DB problem, could not check your daily spins...";}
  
  // we've spun, now generate prize and message. Target is the number/name of the segment. These can be in any order
  
  if($target == 'red'){ // get random amount of beads
  
  $money = mt_rand(10000,300000);
    if($result = mysqli_query($db,"SELECT money FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $mymoney = $user['money']; $newmoney = $mymoney + $money;
       if(mysqli_query($db,"UPDATE `adopts_users` SET money = {$newmoney} WHERE uid = {$uid}")){
    $message = "You received <b>{$amount}</b> beads!";}
    
  }
  elseif($target == 'orange'){ // lose a random amount of candy (premium currency)
  
   $premium_currency = mt_rand(10,30);
    if($result = mysqli_query($db,"SELECT premium currency FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $premium_currency = $user['premiumcurrency']; $newpremium_currency = $mypremium_currency - $premium_currency;
       if(mysqli_query($db,"UPDATE `adopts_users` SET premium currency = {$newpremium_currency} WHERE uid = {$uid}")){
    $message = "You lost<b>{$amount}</b> candy!!";}
    
  }
  elseif($target == 'yellow'){ // get a random item on site (any item)
  
    $prizes = array(257,258,259,261,262,265,268,273,274,277,280,283,284,285,286,291,292,303,304,305,306,307,308,309,312,313,314,340,341, 342,343,344,345,346,347,348,350,351,353,355,356,358,359,360);
    $prize = $prizes[array_rand($prizes,1)];
    $qty = mt_rand(1,3); $give = give_itemid($prize,1,$uid,$db); 
    if($give != 'yes'){ $next = 'default'; } // try the backup plan
    else{ $item = get_itemfromid($prize,$db); $itemname = $item['itemname'];
    $message = "You received <b>{$qty} x {$itemname}</b> from storage.";}
    
  }
  elseif($target == 'green'){ // Get random amount of beads taken away
  
   $money = mt_rand(10000,300000);
    if($result = mysqli_query($db,"SELECT money FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $mymoney = $user['money']; $newmoney = $mymoney - $money;
       if(mysqli_query($db,"UPDATE `adopts_users` SET money = {$newmoney} WHERE uid = {$uid}")){
    $message = "You lost<b>{$amount}</b> beads!";}
    
    
  }
  elseif($target == 'teal'){ // Get given a random amount of candy (premium currency
    
       $premium_currency = mt_rand(10,30);
    if($result = mysqli_query($db,"SELECT premiumcurrency FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $premium_currency = $user['premiumcurrency']; $newpremium_currency = $mypremium_currency + $premium_currency;
       if(mysqli_query($db,"UPDATE `adopts_users` SET premiumcurrency = {$newpremium_currency} WHERE uid = {$uid}")){
    $message = "You won<b>{$amount}</b> candy!!";}
       }else{$next = 'default';}
    }else{$next = 'default';}
  
  }
  elseif($target == 'dkblue'){ // Given random amount of beads
  
  $money = mt_rand(100000,3000000);
    if($result = mysqli_query($db,"SELECT money FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $mymoney = $user['money']; $newmoney = $mymoney + $money;
       if(mysqli_query($db,"UPDATE `adopts_users` SET money = {$newmoney} WHERE uid = {$uid}")){
    $message = "You received <b>{$amount}</b> beads!";}
       }else{$next = 'default';}
    }else{$next = 'default';}
    
  }
  elseif($target == 'purple'){ // loses random amount of candy
    
   $premium_currency = mt_rand(10,30);
    if($result = mysqli_query($db,"SELECT premiumcurrency FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $premium_currency = $user['premiumcurrency']; $newpremium_currency = $mypremium_currency - $premium_currency;
       if(mysqli_query($db,"UPDATE `adopts_users` SET premiumcurrency = {$newpremium_currency} WHERE uid = {$uid}")){
    $message = "You lost<b>{$amount}</b> candy!!";}
    
        }else{$next = 'default';}
      }else{$next = 'default';}
   
      
  }
  elseif($target == 'fuschia'){ // loses random amount of beads
    $money = mt_rand(100000,3000000);
    if($result = mysqli_query($db,"SELECT money FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $mymoney = $user['money']; $newmoney = $mymoney - $money;
       if(mysqli_query($db,"UPDATE `adopts_users` SET money = {$newmoney} WHERE uid = {$uid}")){
    $message = "You lost<b>{$amount}</b> beads!";}
    }else{ $next = 'default'; } // perhaps user does not have a suitable pet
    
  }
    elseif($target == 'pink'){ // wins random amount of candy
       $premium_currency = mt_rand(10,30);
    if($result = mysqli_query($db,"SELECT premiumcurrency FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $premium_currency = $user['premiumcurrency']; $newpremium_currency = $mypremium_currency + $premium_currency;
       if(mysqli_query($db,"UPDATE `adopts_users` SET premiumcurrency = {$newpremium_currency} WHERE uid = {$uid}")){
    $message = "You won<b>{$amount}</b> candy!!";}
    }else{ $next = 'default'; } // perhaps user does not have a suitable griff
    
  }
  
  else{ $next = 'default'; } // target didn't match others
  
  if($next == 'default'){  // have a backup in case the target didn't match others, or proper prize could not be given
    $money = mt_rand(100,300);
    if($result = mysqli_query($db,"SELECT money FROM `adopts_users` WHERE uid = {$uid}")){
       $user = $result->fetch_assoc(); $mymoney = $user['money']; $newmoney = $mymoney + $money;
       if(mysqli_query($db,"UPDATE `adopts_users` SET money = {$newmoney} WHERE uid = {$uid}")){
         $message = "It's unclear what happened... no {$target} reward was forthcoming.<br>Instead, please accept <b>{$money}</b> beads as compensation!";
       }else{return "DB problem, could not award your tokens...";}
    }else{return "DB problem, could not look up your tokens...";}
  }
  
  return $message; // and we're done! The JS on the page can update spin count etc
}


elseif($whatdo == 'buywheel'){
  // the item 185, for example, is used to buy 3 more spins. Actually reduces your spun number by 3; the max is always 20
  $token = check_inventory(856,$uid,$db);
  if($token == 'no'){ return json_encode(array("success" => 'no', "text" => "DB problem, could not check your inventory...")); }
  if($token == 0){ return json_encode(array("success" => 'no', "text" => "It seems you don't have (item name) right now.")); }
  // got the item, reset
    $sql = "UPDATE `adopts_users_profile` SET wbwheel = 0 WHERE uid = {$uid}";
    if(mysqli_query($db,$sql)){
      
     // now try to take the item
     $take = take_itemid(856,1,$uid,$db);
     if($take != 'yes'){ return json_encode(array("success" => 'yes', "text" => "Updated spins, but could not take item...")); }
     // done!
     return json_encode(array("success" => 'yes', "text" => "Item accepted! You can spin again!"));
     
     }else{ return json_encode(array("success" => 'no', "text" => "DB problem, could not update your spins...")); }

}


}
echo games();
?>
