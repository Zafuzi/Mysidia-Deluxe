<?php

// include '../ajax/useful_ajax_griff.php';
// include '../ajax/useful_ajax.php';
// don't know if ittermat already has these files, if not, here are the relevant functions

function get_pet($aid,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_owned_adoptables` WHERE aid = '{$aid}' ORDER BY aid DESC LIMIT 1"); 
$pet = $result->fetch_assoc(); return $pet;
}

function get_itemfromid($itemid,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_items` WHERE id = '{$itemid}' ORDER BY id DESC LIMIT 1"); 
$item = $result->fetch_assoc(); return $item;
}

function give_itemid($itemid,$quantity,$username,$db){
 $item = get_itemfromid($itemid,$db); $cat = $item['category']; $itemname = $item['itemname'];
  $sql2 = "SELECT * FROM adopts_inventory WHERE itemname = '{$itemname}' AND owner = '{$username}'";
  if($result2 = mysqli_query($db, $sql2)){
    $rows2 = mysqli_fetch_object(mysqli_query($db,$sql2));
    if(count($rows2)){ // already in inventory, add more
      $inv = $result2->fetch_assoc(); $itemname = $inv['itemname']; $oldqty = $inv['quantity']; $newqty = $oldqty + $quantity;
      $sql3 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE itemname = {$itemname}";
      if(mysqli_query($db, $sql3)){
        return "yes";
      }else{return "no";}
    }
    else{ // got none in inventory, create new row. gotta look up item for its category,
      $sql3 = "INSERT INTO adopts_inventory (`category`, `itemname`, `owner`, `quantity`, `status`)  VALUES ('$cat', '$itemname', '$username', '$quantity', 'Available')";
      if(mysqli_query($db, $sql3)){
        return "yes";
      }else{return "no";}
    }
  }else{return "no";}
}


function calendar(){
    $aid = $_POST['aid']; $username = $_POST['username']; $uid = $_POST['uid']; $whatdo = $_POST['whatdo']; $target = $_POST['target'];
    
    include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
    
    // an advent calendar! User clicks on a still-open box to select it, and chooses a pet who will open it.
    // user gets an item, and the lucky pet gets a boost to their health/energy/trust.
    // user can open missed boxes from previous days. You might prefer to make another array of 'smaller gift' items, for boxes from previous days.
    
if($whatdo == 'open'){
  if($target == '' || $target == 0){ return json_encode(array("success" => 'no', "text" => "You haven't chosen a box!")); }
  if($aid == '' || $aid == 0){ return json_encode(array("success" => 'no', "text" => "You haven't chosen a pet to open the box!")); }
  $today = date('d'); if($target > $today){ return json_encode(array("success" => 'no', "text" => "Hey, too early! You can open that box later!")); }

  $pet = get_pet($aid,$db); $name = $pet['name']; $owner = $pet['owner'];
  $health = $pet['health']; $energy = $pet['energy']; $trust = $pet['trust'];
  if($owner != $username){ return json_encode(array("success" => 'no', "text" => "{$name} isn't in your pet!")); }
 
  if($result = mysqli_query($db,"SELECT calendar FROM `adopts_users_profile` WHERE uid = {$uid}")){
    $result2 = $result->fetch_assoc(); $calendar = $result2['calendar'];
  }else{ return json_encode(array("success" => 'no', "text" => "DB problem, could not look up your opened boxes...")); }
  
  $myboxes = explode(",",$calendar);
  if(in_array($target,$myboxes)){ return json_encode(array("success" => 'no', "text" => "Hey, it seems you have already opened box {$target}!")); }
  
  // all good, generate gifts for both owner and pet.
  
  // choose an item ID from array. Later add chance of MP upgrade, money etc
  $gifts = array(776,777,773,774,775,778,779,780,781,782,783,784,785,786,793,794,795);
  $gift = $gifts[array_rand($gifts, 1)]; $give = give_itemid($gift,1,$username,$db); 
  if($give != 'yes'){ return json_encode(array("success" => 'no', "text" => "Oops, {$name} was unable to pull the gift out of the box! Try again?")); }
  $item = get_itemfromid($gift,$db); $itemname = $item['itemname']; $mastergift = "You received 1 x <b>{$itemname}</b>!";

  
  // add target box number to user's opened list, and update
  $calendar .= "{$target},";
  $stmt2 = "UPDATE `adopts_users_profile` SET calendar = '{$calendar}' WHERE uid = {$uid}";

   if(mysqli_query($db,$stmt2)){$success = 'yes'; $text = "{$name} opened box {$target}! Oooh! {$mastergift}";}
   else{$success = 'no'; $text = "You got {$itemname}! But couldn't update your opened-boxes list... lucky you!";}


return json_encode(array("success" => $success, "text" => $text));
}

}
echo calendar();
?>