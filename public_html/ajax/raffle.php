<?php

include '../ajax/useful_ajax.php';

function raffle(){
	$whatdo = sanitizeInput($_POST['whatdo']); $uid = sanitizeInput($_POST['uid']); $username = sanitizeInput($_POST['username']); $raffle = sanitizeInput($_POST['raffle']); 
	$qty = sanitizeInput($_POST['qty']); $current = sanitizeInput($_POST['current']);

	include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	// this is for the Raffle minigame. Buying tickets, and a button for mods to give prizes/reset, for testing
	
	
if($whatdo == 'buy'){ $success = ''; $text = '';

  // optional, limit the number of tickets bought per draw.
  
  // you can send this var from the page, by getting the current number inside the span...
  if($current + $qty > 100){ $success = 'no'; $text = "Sorry, you can't buy more than 100 tickets per draw."; }
  
  // ... but if you wanna count properly, in case of user messing with page/JS, here it is.
  //if($countsql = mysqli_query($db,"SELECT COUNT(*) as 'count' FROM `adopts_raffle` WHERE uid = {$uid} AND raffle = {$raffle}")){
  //  $check = mysqli_fetch_assoc($countsql); $current = $check['count'];
  //  if($current + $qty > 100){$success = 'no'; $text = "Sorry, you can't buy more than 100 tickets per draw.";}
  //}else{$success = 'no'; $text = "Could not count your tickets so far...";}
  
  if($success == 'no'){ return json_encode(array("success" => $success, "text" => $text)); }
  
  // end optional
  
  
  // total cost
  if($raffle == 1){$ticket = 50;}else{$ticket = 100;} $price = $ticket * $qty;
  
  // check user's money
  if($result = mysqli_query($db,"SELECT money FROM adopts_users WHERE uid = {$uid} LIMIT 1")){
    $user = $result->fetch_assoc(); $money = $user['money'];
    if($money < $price){
      $afford = floor($money / $ticket);
      $success = 'no'; $text = "Looks like you can't afford that many tickets! You can buy up to {$afford} more.";
    }
  }else{$success = "no"; $text = "Could not check your finances...";}
  
  $num = 1; while($num < $qty){
    $stmt2 = "INSERT INTO adopts_raffle (`uid`, `username`, `raffle`) VALUES ('$uid', '$username', '$raffle')";
    if(!mysqli_query($db,$stmt2)){ $success = "no"; $text = "Could not buy new ticket..."; }
    $num++;
  }
  // if any of the inserts failed, stop and tell
  if($success == 'no'){ return json_encode(array("success" => $success, "text" => $text)); }
  
  // take money
  $money = $money - $price;
  if(!mysqli_query($db,"UPDATE adopts_users SET money = {$money} WHERE uid = {$uid}")){
    // they got tickets anyway, so send back new qty
    $tickets = $current + $qty;
    return json_encode(array("success" => 'money', "text" => "Could not take money! But you got {$qty} tickets anyway. Lucky.", "qty" => $tickets));
  }
  
  // if you didn't count tickets before, can count them now...
  //if($countsql = mysqli_query($db,"SELECT COUNT(*) as 'count' FROM `adopts_raffle` WHERE uid = {$uid} AND raffle = {$raffle}")){
  //  $check = mysqli_fetch_assoc($countsql); $tickets = $check['count'];
  //}else{$success = 'no'; $text = "Could not count your tickets so far...";}
  
  // ... or just add the qty
  $tickets = $current + $qty; $success = 'yes'; $text = "You purchased {$qty} tickets for {$price} tokens. Good luck!";
  
return json_encode(array("success" => $success, "qty" => $tickets, "text" => $text));
}



if($whatdo == 'end'){
  
  $mods = array(1,94); if(!in_array($uid,$mods)){return "Only mods or admins can end raffles.";}
  
  if($raffle == 1){
  
    // count all the tickets to calculate winnings
    if($countsql = mysqli_query($db,"SELECT COUNT(*) as 'count' FROM `adopts_raffle` WHERE raffle = 1")){
    $check = mysqli_fetch_assoc($countsql); $tickets = $check['count'];
    }else{return "Could not count all tickets so far...";}
    
    // choose random winner
    $stmt = "SELECT uid FROM adopts_raffle WHERE raffle = {$raffle} ORDER BY RAND() LIMIT 1";
    if($result = mysqli_query($db,$stmt)){
      $winner = $result->fetch_assoc(); $winnerid = $winner['uid'];
    }else{return "Could not select random winner...";}
    
    // get winner's current money
    $stmt2 = "SELECT money,username FROM adopts_users WHERE uid = {$winnerid} LIMIT 1";
    if($result2 = mysqli_query($db,$stmt2)){
      $user = $result2->fetch_assoc(); $money = $user['money']; $name = $user['username'];
    }else{return "Could not look up winner {$winnerid}'s money...";}
    
    // award money
    $prize = $tickets * 50; $money = $money + $prize; 
    $stmt3 = "UPDATE adopts_users SET money = {$money} WHERE uid = {$winnerid}";
    if(!mysqli_query($db,$stmt3)){return "Could not award winnings of {$prize} tokens to winner {$winnerid}...";}
    
    // send message to user about it... oughta make a function for this
    $title = "Raffle winnings!";
    $message = "Congratulations, {$name}! You're the winner of this week's lottery raffle.
    <p>You won <b>{$prize}</b> tokens. Go ahead and spend them however you like!</p>";
    $datenow = date('Y-m-d H:i:s'); $message = str_replace("'", "''", "$message"); $title = str_replace("'", "''", "$title");
    $stmt4 = "INSERT INTO adopts_messages (`fromuser`, `touser`, `status`, `datesent`, `messagetitle`, `messagetext`) VALUES ('1', '$winnerid', 'unread', '$datenow', '$title', '$message')";
    if(!mysqli_query($db,$stmt4)){return "Prize of {$prize} tokens awarded to user {$name} ({$winnerid}), but could not send message to them about it..."; }
    
    // finally clear tickets
    $stmt5 = "DELETE FROM adopts_raffle WHERE raffle = 1";
    if(!mysqli_query($db,$stmt5)){return "Prize of {$prize} tokens awarded to user {$name} ({$winnerid}), but could not delete tickets...";}
    
    // optional, update records table with winner id so it can be shown to public until the next winner.
    // I use this table to store rankings etc, like totals of each griff breed or top 10 richest users...
    // so they can be counted nightly instead of whenever page visited
    $stmt6 = "UPDATE adopts_records SET winners = '{$winnerid}', details = '{$prize}' WHERE name = 'raffle1'";
    if(mysqli_query($db,$stmt6)){
      return "Done! Prize of {$prize} tokens awarded to user {$name} ({$winnerid}), all reset.";
    }else{return "Prize of {$prize} tokens awarded to user {$name} ({$winnerid}), message sent, raffle reset, but could not update records table...";}
    
  }
  
  // bit different, looping through up to 10 item winners.
  if($raffle == 2){
  
    $stmt = "SELECT uid FROM adopts_raffle WHERE raffle = {$raffle} ORDER BY RAND() LIMIT 10";
    if($result = mysqli_query($db,$stmt)){
      $winners = array(); // loop through them, add uids to array
      while($winner = $result->fetch_assoc()){ $winnerid = $winner['uid']; $winners[] = $winnerid;}
    }else{return "Could not select random winners...";}
    
    // not sure how to deal with stuff not working inside a loop...
    // keep list, so mod can see what happened and maybe fix issues afterwards?
    $reward = ''; $won = array();
    
    foreach($winners as $winnerid){
	
	// choose prize from array, or could pick a rare-category or high-value thing from DB
	$items = array(183,184,185,186,187,188,189,190);
	$prize = $items[array_rand($items)]; $won[] = $prize; // add item id to array
	$iteminfo = get_itemfromid($prize,$db); $itemname = $iteminfo['itemname'];
	$reward .= "User <b>{$winnerid}</b> should win item <b>{$prize}</b> {$itemname}. ";
	$give = give_itemid($prize,1,$winnerid,$db);
	if($give == 'yes'){$reward .= "Prize was given. ";}else{$reward .= "Prize was <b>not</b> given.";}
	
	// now notify them, don't necessarily need to look up any details
	$title = "Raffle prize!";
	$message = "Congratulations! You're one of this week's raffle winners.<br></br>
	You won <b>{$itemname}</b>. It should be arriving in your inventory any minute now!<br><br>";
	$datenow = date('Y-m-d H:i:s'); $message = str_replace("'", "''", "$message"); $title = str_replace("'", "''", "$title");
	$stmt2 = "INSERT INTO adopts_messages (`fromuser`, `touser`, `status`, `datesent`, `messagetitle`, `messagetext`) VALUES ('15', '$winnerid', 'unread', '$datenow', '$title', '$message')";
	if(mysqli_query($db,$stmt2)){$reward .= " Message was sent.<br>";}else{$reward .= " Message was <b>not</b> sent.<br>";}
	
    } // end loop
    
    // turn the winner and prize arrays into lists
    $whowon = implode(',',$winners); $whatwon = implode(',',$won);
    
    // update records with them
    $stmt3 = "UPDATE adopts_records SET winners = '{$whowon}', details = '{$whatwon}' WHERE name = 'raffle2'";
    if(!mysqli_query($db,$stmt3)){return "Log: {$reward}<br><br>Could not update record though.";}
    
    // and delete
    $stmt4 = "DELETE FROM adopts_raffle WHERE raffle = 2";
    if(mysqli_query($db,$stmt4)){
      return "Log: {$reward}<br><br>All done!";
    }else{return "Log: {$reward}<br><br>Could not delete tickets though...";}
    
  }
  
}

}
echo raffle();
?>