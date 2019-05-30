<?php

// File ID: functions_items.php
// Purpose: Provides specific functions defined for items

function items_valuable($item, $adopt){
  if (check_stats() == true){
    $note = "{$item->itemname} has been used on {$adopt->name}.";
    $item->remove(); 
    return $note;
  }
  return "The item {$item->itemname} is a valuable item, which cannot be used on any adoptable but may sell for a good deal of money.";
}
function items_chiku1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $mysidia->db->update("owned_adoptables", array("type" => 'Chiku-Banzai'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "The item has been successfully used on your adoptable, it is now a {$adopt->type}!<br>";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  //Update item quantity...
  $delitem = $item->remove(); 
  return $note;
} 

function items_equipment($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $note = "<b>{$adopt->name}</b> has successfully equipped the {$item->itemname}!<br>";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} equipped <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a> with a(n) {$item->itemname}.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  //Update item quantity...
  $delitem = $item->remove(); 
  return $note;
}

function items_luv1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $mysidia->db->update("owned_adoptables", array("type" => 'Luv-Bug'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "The item has been successfully used on your adoptable, it is now a {$adopt->type}!<br>";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  //Update item quantity...
  $delitem = $item->remove(); 
  return $note;
} 
function items_zoey1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $mysidia->db->update("owned_adoptables", array("type" => 'Zoey'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "The item has been successfully used on your adoptable, it is now a {$adopt->type}!<br>";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  //Update item quantity...
  $delitem = $item->remove(); 
  return $note;
} 
function items_smoke1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $mysidia->db->update("owned_adoptables", array("type" => 'Smoke'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "The item has been successfully used on your adoptable, it is now a {$adopt->type}!<br>";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  //Update item quantity...
  $delitem = $item->remove(); 
  return $note;
} 

function items_level1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $newlevel = $adopt->currentlevel + $item->value;
  $lev = $mysidia->db->select("levels", array(), "adoptiename='{$adopt->type}' and thisislevel ='{$newlevel}'")->fetchObject();
  
    //Check if the adoptable's level is already at maximum.    
  if(!is_object($lev)){
    // object not created, the level is already at maximum.
    $note = "Unfortunately, your selected adoptable's level cannot be raised by using item {$item->itemname}.";
  }
  else{
    //Update item quantity...
    $delitem = $item->remove();
    //Execute the script to update adoptable's level and clicks.
    $mysidia->db->update("owned_adoptables", array("currentlevel" => $newlevel, "totalclicks" => $lev->requiredclicks), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
    $note = "Congratulations, the item {$item->itemname} raised your adoptable's level by {$item->value}";
	// Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
	// Done.
  }
  return $note;
}

function items_level2($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $newlevel = $item->value;
  $lev = $mysidia->db->select("levels", array(), "adoptiename='{$adopt->type}' and thisislevel ='{$newlevel}'")->fetchObject();

    //Check if the adoptable's level is already at maximum.    
  if(!is_object($lev)){
    // object not created, the level is already at maximum.
    $note = "Unfortunately, your selected adoptable's level cannot be raised by using item {$item->itemname}.";
  }
  else{
    //Update item quantity...
    $delitem = $item->remove(); 
    //Execute the script to update adoptable's level and clicks.
	$mysidia->db->update("owned_adoptables", array("currentlevel" => $newlevel, "totalclicks" => $lev->requiredclicks), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
    $note = "Congratulations, the item {$item->itemname} increases your adoptable's level to {$item->value}";
	// Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  }
  return $note;
}

function items_level3($item, $adopt){
  $mysidia = Registry::get("mysidia");
  //Update item quantity...
  $delitem = $item->remove();
    //Execute the script to update adoptable's level and clicks.
  $mysidia->db->update("owned_adoptables", array("currentlevel" => 0, "totalclicks" => 0), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "Congratulations, the item {$item->itemname} has reset the level and clicks of your adoptable.";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}

function items_click1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $newclicks = $adopt->totalclicks + $item->value;
  $mysidia->db->update("owned_adoptables", array("totalclicks" => $newclicks), "aid='{$adopt->aid}'and owner='{$item->owner}'");
  $note = "By using {$item->itemname}, the adoptable's total number of clicks has raised by {$item->value}<br>";
  //Now lets check if the adoptable has reached a new level.
  
  $ownedAdopt = new OwnedAdoptable($adopt->aid);
  if($ownedAdopt->hasNextLevel()){
      //new level exists, time to check if the total clicks have reached required minimum clicks for next level.
	 $nextLevel = $ownedAdopt->getNextLevel();
	 $requiredClicks = $nextLevel->getRequiredClicks();
     if($newclicks >= $requiredClicks and $requiredClicks != 0 and $requiredClicks != ""){
	    // We need to level this adoptable up...
        $mysidia->db->update("owned_adoptables", array("currentlevel" => $nextLevel->getLevel()), "aid ='{$adopt->aid}' and owner='{$item->owner}'");		     
        $note .= "And moreover, it has gained a new level!";
     }
  }
  //Update item quantity...
  $delitem = $item->remove(); 
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}

function items_click2($item, $adopt){
  $mysidia = Registry::get("mysidia");
  $newclicks = $item->value;
  $mysidia->db->update("owned_adoptables", array("totalclicks" => $newclicks), "aid='{$adopt->aid}'and owner='{$item->owner}'");
  $note = "By using {$item->itemname}, the adoptable's total number of clicks has raised by {$item->value}<br>";
  //Now lets check if the adoptable has reached a new level.
  
  $ownedAdopt = new OwnedAdoptable($adopt->aid);
  if($ownedAdopt->hasNextLevel()){
      //new level exists, time to check if the total clicks have reached required minimum clicks for next level.
	 $nextLevel = $ownedAdopt->getNextLevel();
	 $requiredClicks = $nextLevel->getRequiredClicks();
     if($newclicks >= $requiredClicks and $requiredClicks != 0 and $requiredClicks != ""){
	    // We need to level this adoptable up...
        $mysidia->db->update("owned_adoptables", array("currentlevel" => $nextlevel), "aid ='{$adopt->aid}' and owner='{$item->owner}'");	  
        $note .= "And moreover, it has gained a new level!";
     }
  }

  //Update item quantity...
  $delitem = $item->remove(); 
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}

function items_click3($item, $adopt){ 
  $mysidia = Registry::get("mysidia");
  $date = date('Y-m-d'); 
  $mysidia->db->delete("vote_voters", "adoptableid = '{$adopt->aid}' and date='{$date}'");
  //Update item quantity...
  $delitem = $item->remove(); 
  $note = "By using item {$item->name}, you have make your adoptables eligible for clicking by everyone again!";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}

function items_breed1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  // Update the lastbred info.
  $mysidia->db->update("owned_adoptables", array("lastbred" => 0), "aid ='{$adopt->aid}' and owner='{$item->owner}'");	
  $note = "The item has been successfully used on your adoptable, it can breed again!<br>";
  //Update item quantity...
  $delitem = $item->remove(1, $item->owner);  
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}

function items_breed2($item, $adopt){
  $mysidia = Registry::get("mysidia");
  // Note this function exists but is not useful until Mys v1.3.2, when adoptables can carry/attach items.
  $mysidia->db->update("owned_adoptables", array("lastbred" => 0), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "The item has been successfully used on your adoptable, it can breed again!<br>";
  //Update item quantity...
  $delitem = $item->remove(); 
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}
function items_alts1($item, $adopt){
  $mysidia = Registry::get("mysidia");
  // First lets check if alternative image exists for an adoptable at this level.
  $lev = $mysidia->db->select("levels", array(), "adoptiename='{$adopt->type}' and thisislevel ='{$adopt->currentlevel}'")->fetchObject();
  if($lev->alternateimage == ""){
      // The alternate image does not exist, cannot convert adoptable into its alternate form
    $note = "It appears that your adoptable does not have an alternate image at its given level...<br>";
  }
  
  else{
      // The alternate image exists, conversion between primary and alternate image is possible.
    switch($adopt->usealternates){
      case "yes": 
        $mysidia->db->update("owned_adoptables", array("usealternates" => 'no'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");		
        $note = "Your adoptable has assume the species primary form.";
        break;
      default:
        $mysidia->db->update("owned_adoptables", array("usealternates" => 'yes'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");	   
        $note = "Your adoptable {$adopt->name} has assume the species alternate form.";
    }
    //Update item quantity...
    $delitem = $item->remove();   
	// Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
    return $note;    
	}
}

function items_alts2($item, $adopt){
  $note = "This feature will be available soon after we redesign the adoptable class, enjoy!";
  return $note;
}

function items_recipe($item, $adopt){
  if (check_stats($item) == false){
    return "The item {$item->itemname} is a recipe item, which is only useful if you are preforming alchemy.";
  }
  $note = "The item {$item->itemname} is a recipe item, which is more useful if you are performing alchemy. However your {$adopt->name} has greedily used it up anyway!";
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  $item->remove();
  return $note;
}

function items_name1($item, $adopt){
  $note = "umm just realized that people can change adoptables names freely, will have to think about it later.";
  return $note;
}

function items_name2($item, $adopt){
  $note = "For now the items can only be used on adoptables, so user-based item usage will be implemented later.";
  return $note;
}

/* Increase players pet storage size */
function items_space($item) {
  $mysidia = Registry::get("mysidia");
  $max = $mysidia->user->getStatus()->max_pets;
  $limit = $mysidia->getSettings()->maximumpets;
  if ($max >= $limit) return $mysidia->lang->global_sitewide_maximum_pets_reached;
  $newMax = $max+$item->value;
  if ($newMax > $limit) return "Sorry but you can't use {$item}, it'd increase your size beyond the site pet limits.";

  $mysidia->db->update('users_status', ['max_pets'=>$newMax], "username='{$mysidia->user->username}'");
  $delitem = $item->remove();
  return $mysidia->lang->global_size_increase_item_used;
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} and can now store more pets!";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
}

function items_key($item) {
  if (check_stats($item) == false) {
    return "This {$item->itemname} can not be used on your pet.";
  }
  $item->remove(); 
  return $item->itemname . ' has been used.';
}


function check_stats($item) {
  $stats = ['hunger', 'thirst', 'closeness', 'happiness'];
  foreach ($stats as $s) {
    if ($item->$s != 0) {
      return TRUE;
    }
  }
}
function items_unbindingcompanion($item, $adopt){
  $mysidia = Registry::get("mysidia");
  if ($adopt->companion != "nocompanion") {  
    $itemgive = new StockItem($adopt->companion);  
    $itemgive->append(1, $mysidia->user->username);  
    } 

  $mysidia->db->update("owned_adoptables", array("companion" => 'nocompanion'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "You use the <b>{$item->itemname}</b> on your pet, breaking the bond between it and its companion. The companion has been returned to your inventory!<br /><br /> <a href='/inventory'><button type='button'>Return to Inventory</button></a><br>";
  //Update item quantity...
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b>'s companion.</a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  $delitem = $item->remove(); 
  return $note;
} 


function items_unbindingitem($item, $adopt){
  $mysidia = Registry::get("mysidia");
  
  if ($adopt->item != "noitem") {  
    $itemgive = new StockItem($adopt->item);  
    $itemgive->append(1, $mysidia->user->username);  
    } 

  $mysidia->db->update("owned_adoptables", array("item" => 'noitem'), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "You use the <b>{$item->itemname}</b> on your pet, breaking the bond between it and its held item. The held item has been returned to your inventory!<br /><br /> <a href='/inventory'><button type='button'>Return to Inventory</button></a><br>";
  //Update item quantity...
  $delitem = $item->remove();
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} used a(n) {$item->itemname} on <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b>'s favorite item.</a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}

function items_companion($item, $adopt){
  $mysidia = Registry::get("mysidia");
  
  if ($adopt->companion != "nocompanion") {  
    $itemgive = new StockItem($adopt->companion);  
    $itemgive->append(1, $mysidia->user->username);  
    } 
    
  $companion = $item->itemname;
  $mysidia->db->update("owned_adoptables", array("companion" => $companion), "aid ='{$adopt->aid}' and owner='{$item->owner}'");
  $note = "You have given your pet a <b>{$item->itemname}</b>! It will now show up in your pet's profile. <br /><br /> <a href='http://mysgardia.com/inventory'><button type='button'>Return to Inventory</button></a><br>";
  //Update item quantity...
  $delitem = $item->remove(); 
  // Create message and store it.
	$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} gave a(n) {$item->itemname} to <a href='myadopts/manage/{$adopt->aid}'><b>{$adopt->name}</b></a>.";
	$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'item', "mtext" => $message ));
  // Done.
  return $note;
}  

?>