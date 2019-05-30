<?php

include '../ajax/useful_ajax.php';

function get_permission($uid,$db){ // all optional
  $sql = mysqli_query($db,"SELECT canpost FROM adopts_users_status WHERE uid = {$uid} LIMIT 1");
  $result = $sql->fetch_assoc(); $can = $result['canpost']; return $can; // should be 1 or 0
}
function get_usergroup($uid,$db){
  $sql = mysqli_query($db,"SELECT usergroup FROM adopts_users WHERE uid = {$uid} LIMIT 1");
  $result = $sql->fetch_assoc(); $group = $result['usergroup']; return $group;
}
function get_area($id,$db){
  $sql = mysqli_query($db,"SELECT * FROM adopts_forumareas WHERE id = {$id} LIMIT 1");
  $result = $sql->fetch_assoc(); return $result;
}

function forum(){
	$whatdo = sanitizeInput($_POST['whatdo']); $uid = sanitizeInput($_POST['uid']); 
	$target = sanitizeInput($_POST['target']); // if replying to/editing/reporting a thread or post
	$text = sanitizeInput($_POST['text']); // text of post, thread, report
	$title = sanitizeInput($_POST['title']); // used when making a thread
	$view = $_POST['view']; $sticky = $_POST['sticky']; $area = $_POST['area']; // also for threads

	include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	// this is the forum script. Could use useful_ajax functions but I think forums are a more sensitive area?
	// it gets awkward if posts, threads etc don't exist.
	// so here are longer versions with checks. Shorten if you want

// replying to a thread
if($whatdo == 'create_post'){

  if($text != "" && strlen($text) > 10 && strlen($text) < 1000){
   // look up user's forum permission
   $stmt1 = "SELECT canpost FROM adopts_users_status WHERE uid = {$uid}";
   if($result1 = mysqli_query($db,$stmt1)){ $user = $result1->fetch_assoc();
	if($user['canpost'] == "yes"){ // if got permission...
	  $stmt2 = "SELECT forumposts FROM adopts_users_profile WHERE uid = {$uid}";
	  if($result2 = mysqli_query($db,$stmt2)){ // if got user's count...
	   $userp = $result2->fetch_assoc(); $newnum = $userp['forumposts'] + 1;
	   $datenow = date("D jS M, H:i:s");
	   $text = str_replace("'", "''", "$text"); // change ' to '' to avoid messing up query
	   $stmt3 = "INSERT INTO adopts_forumposts (`posted`, `thread`, `author`, `text`) VALUES ('$datenow', '$target', '$uid', '$text')";
	   if (mysqli_query($db,$stmt3)){ // if added post...
	      $stmt4 = "UPDATE adopts_users_profile SET forumposts = {$newnum} WHERE uid = {$uid}";
	      if (mysqli_query($db,$stmt4)){ // if updated user's post count...
	        $lastpost = date('Y-m-d H:i:s');
	        $stmt5 = "UPDATE adopts_forumthreads SET lastpost = '{$lastpost}' WHERE id = {$target}";
	        if (mysqli_query($db,$stmt5)){ // if added lastpost timestamp to thread...
	          return "Post added!";
	        }else{return "Database error: Could not update thread's lastpost timestamp...";}
	      }else{return "Database error: Could not update your post count...";}
	    }else{return "Database error: Could not send your post...";}
	  }else{return "Database connection problem: Could not look up your post count...";}
	}else{return "It looks like you are banned from posting on the forum.";}
      }else{return "Database problem: Could not look up your posting permission...";}
  }else{return "You wrote too little, or too much. Replies should be between 10 and 1000 characters long.";}
  
}

// for editing. Gets current text of a post, to show in textarea popup
elseif($whatdo == 'edit_post'){
  
  $stmt1 = "SELECT canpost FROM adopts_users_status WHERE uid = {$uid}";
   if($result1 = mysqli_query($db,$stmt1)){ $user = $result1->fetch_assoc(); 
	if($user['canpost'] == "yes"){
	  $stmt2 = "SELECT author, text FROM adopts_forumposts WHERE id = {$target}";
	  if($result2 = mysqli_query($db,$stmt2)){
	    $post = $result2->fetch_assoc(); $currenttext = $post['text']; $author = $post['author']; $admins = array(1,2);
	    if($uid == $author || in_array($uid,$admins)){
	      return $currenttext;
	    }else{return "This ({$target}) is not your post to edit.";}
	  }else{return "Database problem: Could not look up this post, {$target}...";}
	}else{return "It looks like you are banned from using the forum.";}
     }else{return "Database problem: Could not look up your posting permission...";}

}

// update with new text from that textarea
elseif($whatdo == 'edit_post_submit'){

  if($text != "" && strlen($text) > 10 && strlen($text) < 1000){
   $stmt1 = "SELECT * FROM adopts_users WHERE uid = {$uid}";
   if($result1 = mysqli_query($db,$stmt1)){  
      $user = $result1->fetch_assoc(); 
      if($user['canpost'] == "yes"){
	$group = $user['usergroup'];
	$stmt3 = "SELECT * FROM adopts_forumposts WHERE id = {$target}";
	if($result3 = mysqli_query($db,$stmt3)){ // if looked up post...
	   $post = $result3->fetch_assoc(); $author = $post['author'];
	   if($author == $uid || $group == 1 || $group == 4){ // check user is editing own post, or user is mod/admin
	       $text = str_replace("'", "''", $text);
	       $stmt5 = "UPDATE adopts_forumposts SET text='{$text}' WHERE id = {$target}";
	       if(mysqli_query($db,$stmt5)){ // if updated post...
	         return "Post updated!";
	       }else{return "Database error: Could not update post...";}
	     }else{return "Hey, this is not your post to edit!";}
	   }else{return "Database problem: Could not look up post...";}
	}else{return "It looks like you are banned from posting on the forum.";}
     }else{return "Database connection problem: Could not look up your posting permission...";}
  }else{return "You wrote too little, or too much. Posts should be between 10 and 1000 characters long.";}
  
}

// create a thread, with opening post
if($whatdo == 'create_thread'){

  if($title != "" && strlen($title) > 5 && strlen($title) < 50){
  if($text != "" && strlen($text) > 10 && strlen($text) < 1000){
   $stmt1 = "SELECT * FROM adopts_users_status WHERE uid = {$uid}";
   if($result1 = mysqli_query($db,$stmt1)){ 
     $user = $result1->fetch_assoc(); 
     if($user['canpost'] == "yes"){
	$group = $user['usergroup'];
	if($group == 1 || $group == 4 || ($group != 1 && $group != 4 && $target != 30)){
	     
	   $datenow = date("D jS M, H:i:s"); $datetime = date('Y-m-d H:i:s');
	   $title = str_replace("'", "''", "$title"); $text = str_replace("'", "''", "$text");
	   $stmt3 = "INSERT INTO adopts_forumthreads (`sticky`, `view`, `title`, `posted`, `area`, `author`, `text`, `lastpost`) VALUES ('0', '2', '$title', '$datenow', '$target', '$uid', '$text', '$datetime')";
	     if (mysqli_query($db,$stmt3)){
	        return "Thread created!";
	     }else{return "Database error: Could not create your thread...";}
	    
	   }else{return "Hey, these are the Imperial Quarters! Only high authorities may start discussions here... how did you even get in?";}
	}else{return "It looks like you are banned from posting on the forum.";}
     }else{return "Database problem: Could not look up your posting permission...";}
  }else{return "Opening posts should be between 10 and 1000 characters long.";}
  }else{return "Titles should be between 5 and 50 characters long.";}
  
}


// if thread creator is normal user, they can edit the title, text, icon. If admin, can also move, lock, sticky thread
elseif($whatdo == 'edit_thread'){
  $user = get_user($uid,$db); $usergroup = $user['usergroup'];
  if($usergroup == 5){return "Looks like you are banned.";}
  if($user['canpost'] == "no"){return "You are banned from using the forum.";}
  
  // get current info
  $stmt = "SELECT * FROM adopts_forumthreads WHERE id = {$target}";
  if ($result = mysqli_query($db,$stmt)){
    $thread = $result->fetch_assoc(); $title = $thread['title']; $text = $thread['text']; $icon = $thread['icon'];
    $sticky = $thread['sticky']; $view = $thread['view']; $area = $thread['area'];
    $thearea = get_area($area,$db); $areaname = $thearea['name'];
  
  $editform = "<div id='forum_editthread_contents'>
  Title: <input type='text' maxlength='30' id='forum_editthread_title' value='{$title}'>
  <br>Icon: <img src='../../pics/ui/forum{$icon}.gif'>
  <select id='forum_editthread_icon'><option value='1'>Black griffin</option><option value='2'>White griffin</option>
  <option value='3'>Orange griffin</option><option value='4'>Running griffin</option></select>
  <br>Opening post: <textarea id='forum_editthread_text' style='resize:none'>{$text}</textarea>";
  
  if($usergroup == 1 || $usergroup == 4){
    $editform .= "<br>Make sticky? <select id='forum_editthread_sticky'><option value='0'>No</option><option value='1'>Yes</option></select>
    <br>View status: <select id='forum_editthread_view'>
      <option value='0'>Mod view only</option><option value='1'>Mod reply only</option><option value='2'>Public</option>
    </select>
    <br>Move thread? <select id='forum_editthread_area'>
<option value='{$area}'>- {$areaname} -</option> <option value='1'>Imperial Office</option><option value='2'>Academy</option><option value='3'>-- New Arrivals</option><option value='4'>Hatchery</option><option value='5'>-- Genetic Talk</option><option value='6'>-- Menagerie</option><option value='7'>Egg to Elder</option><option value='8'>Training Grounds</option><option value='9'>-- Mage Wars</option><option value='10'>Day to Day </option><option value='11'>My Island</option><option value='12'>-- Craft Corner</option><option value='13'>-- Growing and Building</option><option value='14'>World Map</option><option value='15'>-- Scholars' Hall</option><option value='16'>Marketplace</option><option value='17'>-- Griffin Trades</option><option value='18'>-- Item Trades</option><option value='19'>-- Feeling Generous</option><option value='20'>Customisation</option><option value='21'>-- Appearances and Patterns</option><option value='22'>-- Adornments</option><option value='23'>-- Hello, Handsome</option><option value='25'>Storytellers</option><option value='26'>-- Character Showcase</option><option value='27'>-- Non Roleplay</option><option value='28'>City Square</option><option value='29'>-- Party Tent</option><option value='30'>Imperial Quarters</option>
   </select>";
  }
  
  $editform .= "<br><button id='forum_editthread_submit' class='button_general'>Update!</button></div>
  <br><span id='forum_editthread_result'></span>
  <script>$(function(){
  
  $('#forum_editthread_submit').click(function() {
  var title = $('#forum_editthread_title').val(); var text = $('#forum_editthread_text').val();
  var icon = $('#forum_editthread_icon').val(); ";
  
  if($usergroup == 1 || $usergroup == 4){ // mods, admins can change these values
    $editform .= "var sticky = $('#forum_editthread_sticky').val(); var view = $('#forum_editthread_view').val(); 
    var area = $('#forum_editthread_area').val(); ";
  }else{ // keep same values
    $editform .= "var sticky = {$sticky}; var view = {$view}; var area = {$area};";
  }
  
  $editform .= "$.ajax({ type: 'POST', url: '../../ajax/forumpost.php', data: { whatdo : 'edit_thread_submit', uid : {$uid}, target : {$target}, title : title, text : text, area : area, icon : icon, sticky : sticky, view : view },
  success: function(result){ $('#forum_editthread_result').html(result);
    if(result == 'Changes saved!'){ $('#forum_editthread_contents').hide(); $('#forum_thread_text').html(text);
    $('#forum_thread_title').html(title); // superficially updating page, no need to refresh
    }
  }
  }); return false; });
  
  });</script>";
  
  return $editform;
  }else{return "Could not find thread. Did someone delete it already?";}
}

// sending those edits
elseif($whatdo == 'edit_thread_submit'){

  if($title != "" && strlen($title) > 5 && strlen($title) < 50){
  if($text != "" && strlen($text) > 10 && strlen($text) < 1000){
   $stmt1 = "SELECT canpost, usergroup FROM adopts_users WHERE uid = {$uid}";
   if($result1 = mysqli_query($db,$stmt1)){
     $user = $result1->fetch_assoc(); $usergroup = $user['group'];
     $can_post = get_permission($uid,$db);
	if($can_post == "yes"){
	    
	  $stmt2 = "SELECT author FROM adopts_forumthreads WHERE id = {$target}";
	  if($result2 = mysqli_query($db,$stmt2)){
	    $thread = $result2->fetch_assoc(); $author = $thread['author'];
	    if($author == $uid || $usergroup == 1 || $usergroup == 4){
	     
	   $title = str_replace("'", "''", $title); $text = str_replace("'", "''", $text);
	   $stmt3 = "UPDATE adopts_forumthreads SET sticky = {$sticky}, view = {$view}, title = '{$title}', area = {$area}, text = '{$text}', icon = {$icon} WHERE id = {$target}";
	     if (mysqli_query($db,$stmt3)){
	        return "Changes saved!";
	     }else{return "Database error: Could not edit thread...";}
	    
	    }else{return "This is not your thread to edit.";}
	  }else{return "Could not find thread. Did someone delete it already?";}
	}else{return "It looks like you are banned from posting on the forum.";}
     }else{return "Database problem: Could not look up your posting permission...";}
  }else{return "Opening posts should be between 10 and 1000 characters long.";}
  }else{return "Titles should be between 5 and 50 characters long.";}

}

// these are both admin-only, of course! mods can edit posts, hide or move threads to admin area, but not fully delete anything

// NOTE: deletion was working, but the JS/page side was buggy, so I stopped.
// leaving here in case you want to try it again. Will move it to moderation script

elseif($whatdo == 'delete_post'){
  $stmt1 = "SELECT usergroup FROM adopts_users WHERE uid = {$uid}";
  if($result1 = mysqli_query($db,$stmt1)){ $user = $result1->fetch_assoc(); $ug = $user['usergroup'];
   if($ug == 1){
   // it doesn't matter if post exists or not. Can still attempt the SQL anyway, I think?
   // bit pointless to look-up and count first...
     $stmt2 = "DELETE FROM adopts_forumposts WHERE id = {$target}";
     if(mysqli_query($db,$stmt2)){
       return "Deleted!"; // back on page, fade-out this post div
     }else{return "DB problem, could not delete post...";}
   }else{return "It seems you are not an admin. Only they can delete things.";}
  }else{return "DB problem, could not look up your usergroup.";}
}

elseif($whatdo == 'delete_thread'){
  $stmt1 = "SELECT usergroup FROM adopts_users WHERE uid = {$uid}";
  if($result1 = mysqli_query($db,$stmt1)){ $user = $result1->fetch_assoc(); $ug = $user['usergroup'];
   if($ug == 1){
     $stmt2 = "DELETE FROM adopts_forumposts WHERE thread = {$target}";
     $stmt3 = "DELETE FROM adopts_forumthreads WHERE id = {$target}";
     if(mysqli_query($db,$stmt2)){
     if(mysqli_query($db,$stmt3)){
       return "Thread and replies deleted!"; // back on page, direct admin back to area, nowt to see here
     }else{return "DB problem, deleted replies but not thread itself...";}
     }else{return "DB problem, could not delete replies...";}
   }else{return "It seems you are not an admin. Only they can delete things.";}
  }else{return "DB problem, could not look up your usergroup.";}
}

// quickly stop a user posting, from a button on any thread/post. Mods/admins only
// I couldn't get this button to work at all, not sure what issue was. Maybe you'll have more luck
elseif($whatdo == 'silence'){
  $stmt1 = "SELECT usergroup FROM adopts_users WHERE uid = {$uid}";
  if($result1 = mysqli_query($db,$stmt1)){ $user = $result1->fetch_assoc(); $ug = $user['usergroup'];
   if($ug == 1 || $ug == 4){
     $stmt2 = "UPDATE adopts_users_status SET canpost = 'no' WHERE uid = {$target}";
     if(mysqli_query($db,$stmt2)){
       return "Silenced!";
     }else{return "DB problem, could not silence user {$target}...";}
   }else{return "It seems you are not an admin or moderator.";}
  }else{return "DB problem, could not look up your usergroup.";}
}

// creates a thread in admin forum. Might be better to make a separate table/mod area just for game reports of all kinds?
// well, this sets 'report' column to 1. Posts/threads needn't be reported over and over
/*
elseif($whatdo == 'report'){
  if($text != ""){
   $stmt1 = "SELECT * FROM adopts_users WHERE uid = {$uid}";
   if ($result1 = mysqli_query($db,$stmt1)){ $user = $result1->fetch_assoc(); 
	if($user['canpost'] == 1){
	
	if($icon == 'thread'){$stmt2 = "SELECT report FROM adopts_forumthreads WHERE id = {$target}";}
	elseif($icon == 'post'){$stmt2 = "SELECT report FROM adopts_forumposts WHERE id = {$target}";}
	else{return "Huh? Thread or post?";} // dunno how this could happen but hey
	if($result2 = mysqli_query($db,$stmt2)){ $naughty = $result2->fetch_assoc(); $reported = $naughty['report'];
	  if($reported != 0){return "Already reported. Thanks though!";}
	
	   $datenow = date('Y-m-d H:i:s'); $username = $user['screenname']; $title = "Report: {$icon} {$target}";
	   $aboutreport = "User ".$uid." ({$username}) has reported <a href='../../gathering/{$icon}/{$target}'>{$icon} ID {$target}</a>.<br><br>Reason: {$text}";
	   $aboutreport = str_replace("'", "''", $aboutreport);
	   $stmt3 = "INSERT INTO adopts_forumthreads (`sticky`, `view`, `title`, `posted`, `area`, `author`, `text`, `lastpost`, `icon`) VALUES ('0', '1', '$title', '$datenow', '30', '$uid', '$aboutreport', '$datenow', 'report')";
	     if(mysqli_query($db,$stmt3)){
	       if($icon == 'thread'){$sql = "UPDATE adopts_forumthreads SET report = 1 WHERE id = {$target}";}
	       elseif($icon == 'post'){$sql = "UPDATE adopts_forumposts SET report = 1 WHERE id = {$target}";}
	       if(mysqli_query($db,$sql)){ 
	         return "Report submitted.";
	       }else{return "Reported, not updated...";}
	     }else{return "DB problem: Could not submit report.";}
	     
	}else{return "Could not check if reported already...";}
	
	}else{return "You are banned from using the forum.";}
     }else{return "DB problem: Could not look up your permission.";}
  }else{return "Please include a reason.";}
}
*/
// and this is another option, submitting it to a separate reports table. Whatever you prefer
elseif($whatdo == 'report'){
  if($icon != ""){
  if($text != ""){
   $stmt1 = "SELECT * FROM adopts_users WHERE uid = {$uid}";
   if ($result1 = mysqli_query($db,$stmt1)){ $user = $result1->fetch_assoc();
	if($user['canpost'] == "yes"){
	
	if($icon == 'thread'){$stmt2 = "SELECT report FROM adopts_forumthreads WHERE id = {$target}"; $type = 2;}
	elseif($icon == 'post'){$stmt2 = "SELECT report FROM adopts_forumposts WHERE id = {$target}"; $type = 1;}
	else{return "Huh? Thread or post?";} // dunno how this could happen but hey
	if($result2 = mysqli_query($db,$stmt2)){ $naughty = $result2->fetch_assoc(); $reported = $naughty['report'];
	  if($reported != 0){return "Already reported. Thanks though!";}
	
	   $datenow = date('Y-m-d H:i:s'); $text = str_replace("'", "''", $text);
	   $stmt3 = "INSERT INTO adopts_reports (`type`, `uid`, `target`, `reason`, `thetime`) VALUES ('$type', '$uid', '$target', '$text', '$datenow')";
	     if(mysqli_query($db,$stmt3)){
	       if($icon == 'thread'){$sql = "UPDATE adopts_forumthreads SET report = 1 WHERE id = {$target}";}
	       elseif($icon == 'post'){$sql = "UPDATE adopts_forumposts SET report = 1 WHERE id = {$target}";}
	       if(mysqli_query($db,$sql)){ 
	         return "Report submitted.";
	       }else{return "Reported, not updated...";}
	     }else{return "DB problem: Could not submit report.";}
	     
	}else{return "Could not check if reported already...";}
	
	}else{return "You are banned from using the forum.";}
     }else{return "DB problem: Could not look up your permission.";}
  }else{return "Please include a reason.";}
  }else{return "Report type not clear...";} // should be either 'post' or 'thread'
}

else{ return "No action chosen..."; }
}
echo forum();
?>