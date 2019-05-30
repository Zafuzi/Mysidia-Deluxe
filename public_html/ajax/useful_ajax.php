<?php
// Collection of useful functions, so can do stuff in 'shorthand' like with Mysidia's classes.
// Tip: instead of setting up new DB connection for each function, pass it $db variable in the argument/parameters, so it uses same one

function sanitizeInput($pt){ // borrowed from Kyttias
$pt = trim($pt);
$pt = stripslashes($pt);
$pt = htmlspecialchars($pt);
$list = array('position','float','z-index','font-size'); $patterns = array(); 
foreach ($list as $v){ $patterns[]= '/'.$v.'\s*:\s*[^;"]*;?/'; } $pt = preg_replace($patterns,'', $pt);
$pt = html_entity_decode($pt); 
/* Because of the way DOMDocument() works below, unclosed HTML angle brackets will be considered errors and removed. */
/* Many emoticon faces and even the common <3 symbol utilize angle brackets! We're going to give a few safe harbor below... */
$pt = str_ireplace('<3','&#x2665;',$pt); $pt = str_ireplace('_<','_&lt;',$pt);  
$pt = str_replace('D<','D&lt;',$pt); $pt = str_replace('D:<','D:&lt;',$pt); $pt = str_replace('u<','u&lt;',$pt); 
$pto = str_replace('w<','w&lt;',$pt); $pt = str_replace('o<','o&lt;',$pt); $pt = str_replace('U<','U&lt;',$pt); 
$pt = str_replace('W<','W&lt;',$pt); $pt = str_replace('O<','O&lt;',$pt);
/* This will help prevent malicious Javascript inclusion so users don't click links that activate code. */
$pt = str_ireplace('<a href="j','<a href="## ',$pt); $pt = str_ireplace('onclick=',' ',$pt); $pt = str_ireplace('<script',' ',$pt); 
/* This will make sure all links open a new tab. */
$pt = str_ireplace('<a ','<a target="_BLANK" ',$pt); 
$pt = str_ireplace('<strike>','<s>',$pt); $pt = str_ireplace('</strike>','</s>',$pt);  $pt = preg_replace('/(<br>){1,}$/', '', $pt);
$doc = new DOMDocument();  $doc->loadHTML('<?xml encoding="UTF-8" >' . $pt); $pt = $doc->saveHTML(); 
/* This contains HTML tags that are exceptions: therefore ALLOWED and AREN'T going to be stripped out. */ 
$pt = strip_tags($pt,'<a><pre><code><b><i><img><center><u><s><em><sub><sup><strong><br><span><small>');  
$pt = trim($pt);  return $pt;
}


// First, fetching a griff, item or a user profile as an object. Up to you which versions to use
// In main script: $adopt = get_adopt(123,$db);  $name = $adopt['name'];
// Not gonna bother with checks here - just assume the thing exists to be fetched, like Mys' own queries

function get_adopt($aid,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_owned_adoptables` WHERE aid = '{$aid}' ORDER BY aid DESC LIMIT 1"); 
$adopt = $result->fetch_assoc();
return $adopt;
}

function get_enemy($eid,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_enemies` WHERE eid = '{$eid}' ORDER BY eid DESC LIMIT 1"); 
$enemy = $result->fetch_assoc();
return $enemy;
}

function get_profile($uid,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_users_profile` WHERE uid = '{$uid}' ORDER BY uid DESC LIMIT 1"); 
$profile = $result->fetch_assoc();
return $profile;
}

function get_user($uid,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_users` WHERE uid = '{$uid}' ORDER BY uid DESC LIMIT 1"); 
$user = $result->fetch_assoc();
return $user;
}

function get_itemfromname($itemname,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_items` WHERE itemname = '{$itemname}' ORDER BY itemname DESC LIMIT 1"); 
$item = $result->fetch_assoc();
return $item;
}

function get_itemfromid($itemid,$db){
$result = mysqli_query($db,"SELECT * FROM `adopts_items` WHERE id = '{$itemid}' ORDER BY id DESC LIMIT 1"); 
$item = $result->fetch_assoc();
return $item;
}


// To give an item:  give_item("Turquoise Prism",5,1,$db);  and similar for take_item
// It will happen invisibly unless you put 'return' before it, in which case you'll get the message.
// These 'magic' versions are useful for moderator page. You choose item/qty/user/give or take, and it tells you what they have. Let me know if you wanna borrow that

function magicgive_item($itemname,$quantity,$uid,$db){

 $item = get_itemfromname($itemname,$db);  $itemid = $item['id']; $cat = $item['category']; $trad = $item['tradable'];
 $user = get_profile($uid,$db); $uname = $user['screenname'];

  $sql2 = "SELECT * FROM adopts_inventory WHERE itemid = '{$itemid}' AND owner = '{$uid}'";
  if($result2 = mysqli_query($db, $sql2)){
    $rows2 = mysqli_fetch_object(mysqli_query($db,$sql2));
    if(count($rows2)){ // already in inventory, add more
      $inv = $result2->fetch_assoc(); $iid = $inv['iid']; $oldqty = $inv['quantity']; $newqty = $oldqty + $quantity;
      $sql3 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
      if(mysqli_query($db, $sql3)){
        return "User {$uid} ({$uname}) had {$oldqty} of {$itemname}, now has {$newqty}!";
      }else{return "User {$uid} ({$uname}) currently has {$oldqty} of {$itemname}, cannot increase to {$newqty}...";}
    }
    else{ // got none in inventory, create new row. gotta look up item for its category, tradable y/n
      $sql3 = "INSERT INTO adopts_inventory (`category`, `itemid`, `owner`, `quantity`, `tradable`)  VALUES ('$cat', '$itemid', '$uid', '$quantity', '$trad')";
      if(mysqli_query($db, $sql3)){
        return "User {$uid} ({$uname}) now has {$quantity} of {$itemname}!";
      }else{return "Could not give user {$uid} ({$uname}) {$quantity} of {$itemname}...";}
    }
  }else{return "Could not connect to DB...";}
  
}

function magictake_item($itemname,$quantity,$uid,$db){

 $item = get_itemfromname($itemname,$db);  $itemid = $item['id'];
 $user = get_profile($uid,$db); $uname = $user['screenname'];

  $sql = "SELECT * FROM adopts_inventory WHERE itemid = {$itemid} AND owner = '{$uid}'";
  if($result = mysqli_query($db, $sql)){
    $rows = mysqli_fetch_object(mysqli_query($db,$sql));
    if(count($rows)){ // already in inventory, take some
      $inv = $result->fetch_assoc(); $iid = $inv['iid']; $oldqty = $inv['quantity']; $newqty = $oldqty - $quantity;
      
      if($newqty < 1){ // delete the inventory row
       $sql2 = "DELETE FROM adopts_inventory WHERE iid = '{$iid}' AND owner = {$uid}";
       if(mysqli_query($db, $sql2)){
          return "User {$uid} ({$uname}) now has none of {$itemname}.";
        }else{return "User {$uid} ({$uname}) had {$oldqty} of {$itemname}, should take {$quantity}, cannot remove all...";}
      }
      else{ // update to lower qty
       $sql2 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
       if(mysqli_query($db, $sql2)){
         return "User {$uid} ({$uname}) had {$oldqty} of {$itemname}, now has {$newqty}!";
       }else{return "User {$uid} ({$uname}) currently has {$oldqty} of {$itemname}, cannot reduce to {$newqty}...";}
      }

    }else{return "User {$uid} ({$uname}) already has no {$itemname} to take...";}
  }else{return "Could not connect to DB...";}
  
}


// generic versions, only send back 'yes' or 'no'
function give_item($itemname,$quantity,$uid,$db){

 $item = get_itemfromname($itemname,$db);  $itemid = $item['id']; $cat = $item['category']; $trad = $item['tradable'];
 $user = get_profile($uid,$db); $uname = $user['screenname'];

  $sql2 = "SELECT * FROM adopts_inventory WHERE itemid = '{$itemid}' AND owner = '{$uid}'";
  if($result2 = mysqli_query($db, $sql2)){
    $rows2 = mysqli_fetch_object(mysqli_query($db,$sql2));
    if(count($rows2)){ // already in inventory, add more
      $inv = $result2->fetch_assoc(); $iid = $inv['iid']; $oldqty = $inv['quantity']; $newqty = $oldqty + $quantity;
      $sql3 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
      if(mysqli_query($db, $sql3)){
        return "yes";
      }else{return "no";}
    }
    else{ // got none in inventory, create new row. gotta look up item for its category, tradable y/n
      $sql3 = "INSERT INTO adopts_inventory (`category`, `itemid`, `owner`, `quantity`, `tradable`)  VALUES ('$cat', '$itemid', '$uid', '$quantity', '$trad')";
      if(mysqli_query($db, $sql3)){
        return "yes";
      }else{return "no";}
    }
  }else{return "no";}
  
}

function take_item($itemname,$quantity,$uid,$db){

 $item = get_itemfromname($itemname,$db);  $itemid = $item['id'];
 $user = get_profile($uid,$db); $uname = $user['screenname'];

  $sql = "SELECT * FROM adopts_inventory WHERE itemid = {$itemid} AND owner = '{$uid}'";
  if($result = mysqli_query($db, $sql)){
    $rows = mysqli_fetch_object(mysqli_query($db,$sql));
    if(count($rows)){ // already in inventory, take some
      $inv = $result->fetch_assoc(); $iid = $inv['iid']; $oldqty = $inv['quantity']; $newqty = $oldqty - $quantity;
      
      if($newqty < 1){ // delete the inventory row
       $sql2 = "DELETE FROM adopts_inventory WHERE iid = '{$iid}' AND owner = {$uid}";
       if(mysqli_query($db, $sql2)){
          return "yes";
        }else{return "no";}
      }
      else{ // update to lower qty
       $sql2 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
       if(mysqli_query($db, $sql2)){
         return "yes";
       }else{return "no";}
      }

    }else{return "no";}
  }else{return "no";}
  
}

// and here's the version using item id instead of name. useful for trade system

function give_itemid($itemid,$quantity,$uid,$db){

 $item = get_itemfromid($itemid,$db); $cat = $item['category']; $trad = $item['tradable'];

  $sql2 = "SELECT * FROM adopts_inventory WHERE itemid = '{$itemid}' AND owner = '{$uid}'";
  if($result2 = mysqli_query($db, $sql2)){
    $rows2 = mysqli_fetch_object(mysqli_query($db,$sql2));
    if(count($rows2)){ // already in inventory, add more
      $inv = $result2->fetch_assoc(); $iid = $inv['iid']; $oldqty = $inv['quantity']; $newqty = $oldqty + $quantity;
      $sql3 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
      if(mysqli_query($db, $sql3)){
        return "yes";
      }else{return "no";}
    }
    else{ // got none in inventory, create new row. gotta look up item for its category, tradable y/n
      $sql3 = "INSERT INTO adopts_inventory (`category`, `itemid`, `owner`, `quantity`, `tradable`)  VALUES ('$cat', '$itemid', '$uid', '$quantity', '$trad')";
      if(mysqli_query($db, $sql3)){
        return "yes";
      }else{return "no";}
    }
  }else{return "no";}
  
}

function take_itemid($itemid,$quantity,$uid,$db){
 $user = get_profile($uid,$db);
 
  $sql = "SELECT * FROM adopts_inventory WHERE itemid = {$itemid} AND owner = '{$uid}'";
  if($result = mysqli_query($db, $sql)){
    $rows = mysqli_fetch_object(mysqli_query($db,$sql));
    if(count($rows)){ // already in inventory, take some
      $inv = $result->fetch_assoc(); $iid = $inv['iid']; $oldqty = $inv['quantity']; $newqty = $oldqty - $quantity;
      
      if($newqty < 1){ // delete the inventory row
       $sql2 = "DELETE FROM adopts_inventory WHERE iid = '{$iid}' AND owner = {$uid}";
       if(mysqli_query($db, $sql2)){
          return "yes";
        }else{return "no";}
      }
      else{ // update to lower qty
       $sql2 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
       if(mysqli_query($db, $sql2)){
         return "yes";
       }else{return "no";}
      }

    }else{return "no";}
  }else{return "no";}
  
}


// buying and selling, makes shopping and clearing inventory very fast!
// you could just use the give/take functions after changing user's money, but I like to return custom messages here.

// for buying, we'll give the stuff before taking money, to avoid any complaints
function buy_item($itemname,$quantity,$uid,$db){
 
 $item = get_itemfromname($itemname,$db); $itemid = $item['id']; $price = $item['price']; $cat = $item['category']; $trad = $item['tradable'];
 $user = get_user($uid,$db); $money = $user['money'];
 $totalprice = $price * $quantity;
 if($totalprice > $money){ $maxnum = floor($money / $price);
 return "Sorry, it seems you don't have enough tokens for this purchase!<br>You can afford to buy up to {$maxnum} of this item.";}
 
 $newmoney = $money - $totalprice;
 $sql3 = "UPDATE adopts_users SET money = {$newmoney} WHERE uid = {$uid}";
 
 $sql1 = "SELECT * FROM adopts_inventory WHERE itemid = {$itemid} AND owner = '{$uid}'";
 if($result = mysqli_query($db, $sql1)){
  $rows = mysqli_fetch_object(mysqli_query($db,$sql1));
  
  if(count($rows)){ // already in inventory, add more
     $inv = $result->fetch_assoc(); $iid = $inv['iid']; $oldqty = $inv['quantity']; $newqty = $oldqty + $quantity;
     $sql2 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
     if(mysqli_query($db, $sql2)){
      if(mysqli_query($db, $sql3)){
        return "You purchased {$quantity} of {$itemname}, for {$totalprice} tokens.<br>You now have {$newqty} of this item, and {$newmoney} tokens.";
      }else{return "Could not carry out purchase...";}
     }else{return "You currently have {$oldqty} of {$itemname}, cannot increase to {$newqty}...";}
    }
    else{ // got none in inventory, create new row. gotta look up item for its category, tradable y/n
     $sql2 = "INSERT INTO adopts_inventory (`category`, `itemid`, `owner`, `quantity`, `tradable`)  VALUES ('$cat', '$itemid', '$uid', '$quantity', '$trad')";
     if(mysqli_query($db, $sql2)){
      if(mysqli_query($db, $sql3)){
        return "You purchased {$quantity} of {$itemname}, for {$totalprice} tokens.<br>You now have {$newmoney} tokens.";
      }else{return "Could not carry out purchase...";}
     }else{return "Could not add {$quantity} of {$itemname} to your inventory...";}
    }
    
 }else{return "Could not connect to DB...";}
  
}

// and here, give users payment before taking items
function sell_item($itemname,$quantity,$uid,$db){

 $sql = "SELECT * FROM adopts_inventory WHERE itemid = {$itemid} AND owner = '{$uid}'";
 if($result = mysqli_query($db, $sql)){
  $rows = mysqli_fetch_object(mysqli_query($db,$sql));
  if(count($rows)){
   $inv = $result->fetch_assoc(); $iid = $inv['iid']; $currentqty = $inv['quantity'];
   if($currentqty >= $quantity){
 
 $item = get_itemfromname($itemname,$db); $itemid = $item['id']; $price = $item['price'];
 $user = get_user($uid,$db); $money = $user['money'];
 $totalsale = $price * $quantity; $newmoney = $money + $totalsale; $newqty = $currentqty - $quantity;
 $sql2 = "UPDATE adopts_users SET money = {$newmoney} WHERE uid = {$uid}";
 if(mysqli_query($db, $sql2)){
  
  if($newqty < 1){ // delete the inventory row
       $sql2 = "DELETE FROM adopts_inventory WHERE iid = '{$iid}' AND owner = {$uid}";
       if(mysqli_query($db, $sql2)){
          return "You have sold {$quantity} of {$itemname}, for {$totalsale} tokens.<br>Now you have {$newmoney} tokens, and none of this item left.";
        }else{return "You currently have {$currentqtyqty} of {$itemname}, should take {$quantity}, cannot remove all...";}
      }
      else{ // update to lower qty
       $sql2 = "UPDATE adopts_inventory SET quantity = {$newqty} WHERE iid = {$iid}";
       if(mysqli_query($db, $sql2)){
         return "You have sold {$quantity} of {$itemname}, for {$totalsale} tokens.<br>You now have {$newqty} of this item left, and {$newmoney} tokens.";
       }else{return "You currently have {$currentqty} of {$itemname}, cannot reduce to {$newqty}...";}
      }
  
 }else{return "Could not carry out the sale...";}
 
 }else{return "You only have {$currentqty} of this item - you cannot sell {$quantity}!";}
 }else{return "It seems you don't have any of that item!";}
 }else{return "Could not connect to DB...";}
}



?>