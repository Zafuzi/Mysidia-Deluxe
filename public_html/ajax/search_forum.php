<?php

include '../ajax/useful_ajax.php';
include '../ajax/ajax_pagination.php';

function get_permission($uid,$db){
  $sql = mysqli_query($db,"SELECT canpost FROM adopts_users_status WHERE uid = {$uid} LIMIT 1");
  $result = $sql->fetch_assoc(); $can = $result['canpost']; return $can; // should be 1 or 0
}
function get_usergroup($uid,$db){
  $sql = mysqli_query($db,"SELECT usergroup FROM adopts_users WHERE uid = {$uid} LIMIT 1");
  $result = $sql->fetch_assoc(); $group = $result['usergroup']; return $group;
}
function see_signatures($uid,$db){
  $sql = mysqli_query($db,"SELECT forumsigs FROM adopts_users_profile WHERE uid = {$uid} LIMIT 1");
  $result = $sql->fetch_assoc(); $seesigs = $result['forumsigs']; return $seesigs; // should be 1 or 0
}

function searchForum(){ 
	$uid = sanitizeInput($_POST['uid']); $thread = sanitizeInput($_POST['thread']);
	$author = sanitizeInput($_POST['author']); $whatdo = sanitizeInput($_POST['whatdo']);
	$text = sanitizeInput($_POST['text']); $area = sanitizeInput($_POST['area']);
	$sticky = sanitizeInput($_POST['sticky']); $uid = sanitizeInput($_POST['uid']);
	$title = sanitizeInput($_POST['title']); $type = sanitizeInput($_POST['type']);
	$page = sanitizeInput($_POST['page']);

	$conditions = array(); $conditions[] = "report = 0"; // optional, filter out reported stuff

	include("../inc/config.php"); $db = mysqli_connect(DBHOST, DBUSER, DBPASS, DBNAME);
	
	// this is the forum searching and thread/post pagination script.
	// creating/editing/reporting threads and posts is done in forumpost.php

// user enters name, we need number
if($author != ""){ 
  $stmt = "SELECT uid FROM `adopts_users` WHERE username = '{$author}' ORDER BY username DESC LIMIT 1"; 
  if($result = mysqli_query($db,$stmt)){ 
    $rows = mysqli_fetch_object(mysqli_query($db,$stmt));
    if(count($rows)){
      $them = $result->fetch_assoc(); $authorid = $them['uid']; $conditions[] = "author = {$authorid}";
    }else{return "Could not find that author. Are you sure the name is spelled correctly?";}
  }else{return "DB problem, could not look up author...";}
}

if($text != ""){ $conditions[] = "text LIKE '%{$text}%'"; }

// must avoid some search options that get in way, like 'thread' when looking for all posts, not within a thread
if($type == ""){ 
  if($thread != ""){ $conditions[] = "thread = {$thread}"; }
  if($sticky != ""){ $conditions[] = "sticky = {$sticky}"; }
}
// ... or that don't work, like 'area'/'title' when looking for posts
if($whatdo != 'search_posts'){
  if($area != ""){ $conditions[] = "area = {$area}"; }
  if($title != ""){ $conditions[] = "title LIKE '%{$title}%'"; }
}


if($whatdo == 'search_posts'){

	$cou = "SELECT COUNT(*) as 'count' FROM `adopts_forumposts` WHERE ".implode(' AND ', $conditions)." ORDER BY id"; 
	if($countsql = mysqli_query($db,$cou)){
	$check = mysqli_fetch_assoc($countsql); $totalrows = $check['count'];
	if($totalrows < 1){return "No posts match this criteria. Try something a little wider?";} 
	else{ $rowsperpage = 4;
	
	if(!$page){$page = 1;}  $limit = ($page - 1) * $rowsperpage;
	$upto = $page * $rowsperpage; $here = ($upto - $rowsperpage) + 1;  if($upto > $totalrows){$upto = $totalrows;}
	$lastpage = ceil($totalrows / $rowsperpage);
	$totalpages = ceil($totalrows / $rowsperpage);
	
	$paggy = getPageButtons($page,$totalrows,$rowsperpage);
	}
	}else{return "Could not count post results...";}
	
	$stmt = "SELECT * FROM `adopts_forumposts` WHERE ".implode(' AND ', $conditions)." ORDER BY id ASC LIMIT {$limit}, {$rowsperpage}"; 
	if($result = mysqli_query($db,$stmt)){ 
	$rows = mysqli_fetch_object(mysqli_query($db,$stmt));
	if(count($rows)){
	
	$replynum = 0;
	while($reply = $result->fetch_assoc()){ $replynum++;
	
	$postid = $reply['id']; $postauthor = $reply['author']; $posttext = $reply['text']; $postdate = $reply['posted'];
	$postthread = $reply['thread']; if($type != ''){ $thread = $reply['thread']; }
	$admins = array(1,2);
	if(in_array($uid,$admins) || $uid == $postauthor){$editbtn = "<div class='forum_edit_btn' data-id='{$postid}' data-what='post'>Edit</div>";}
	else{$editbtn = '';}
	if($uid != 0){$reportbtn = "<div class='forum_report_btn' data-id='{$postid}' data-what='post'>!</div>";
	  $can = get_permission($uid,$db); if($can == 0){$reportbtn = ''; $editbtn = '';} // stop banned users doing anything
	  $see = see_signatures($uid,$db); if(!$see){$seesigs = 1;}else{$seesigs = $see;} // show sigs by default
	}
	else{$editbtn = ''; $reportbtn = ''; $seesigs = 1;} // if not logged in, can't do anything
	
	// delete and silence btns weren't working well, so I stopped. You can enable and try to fix them if you want
	//if(in_array($uid,$admins)){$silencebtn = "<div class='forum_silence_btn' data-uid='{$postauthor}'>Silence</div>";
	//$deletebtn = "<div class='forum_deletepost_btn' data-id='{$postid}'>Delete</div>";}
	//else{$silencebtn = ''; $deletebtn = '';}
	
	$user = get_profile($postauthor,$db);
	if($user){ $useravatar = $user['avatar']; $username = $user['username']; $userposts = $user['forumposts'];
	$userrole = $user['userrole']; $signature = $user['signature'];
	$ug = get_usergroup($postauthor,$db); $ucan = get_permission($postauthor,$db);
	if($ug == 1 || $ug == 2){$symbol = "<img src='../../picuploads/icons/Adminlabel.png' style='vertical-align:middle;'> "; $postbit = 'admin';}
	  elseif($ug == 4){$symbol = "<img src='../../pics/20pxwhite.gif' style='vertical-align:middle;'> "; $postbit = 'mod';}
	  elseif($ug == 5){$symbol = "<img src='../../pics/tinyrab.png' style='vertical-align:middle;'> "; $postbit = 'banned';}
	  else{$symbol = ''; $postbit = 'member';}
	if($ucan != 1){$silent = "(Silent)";}else{$silent = '';}
	if($reply['report'] != 0){$reported = "(Reported)";}else{$reported = '';}
	}else{$username = '???'; $useravatar = 0; $userrole = '???'; $userposts = '?'; $postbit = 'banned';}
	
	if($seesigs == 1){ if($signature == ''){$postsig = '';}else{$postsig = "<hr><br>{$signature}";}
	}
	else{$postsig = '';}
	
	$table = "<div id='forum_post{$postid} class='forum_posthold'>
	  <div class='forum_postbit {$postbit}'>
	    {$symbol} <sub>{$userrole}</sub><br>
	    <a href='../../profile/view/{$postauthor}'><img src='{$useravatar}' style='max-height:100px; max-width:100px;'><br>
	    {$username}</a><br><sub>Posts: {$userposts}</sub>
	  </div> 
	  <div class='forum_posttext'>
	    <div class='forum_postinfo'><a href='../../gathering/thread/{$postthread}'>Reply {$replynum}</a> at {$postdate} {$editbtn} {$reportbtn} {$reported}
	      {$silencebtn} <span class='forum_silent{$post->author}'></span> {$deletebtn}</div><br>
	    <div id='forumpost_{$postid}'>{$posttext}</div><br>{$postsig}
	  </div>
	</div>";
	}
	
	$table .= "Page {$page}, showing posts {$here} - {$upto} out of <b>{$totalrows}</b> in total.<p>{$paggy}</p><script>$(function(){
	
	$('.pagi_btn').click(function(){ var page = $(this).data('page');
	$.ajax({ type: 'POST', url: '../../ajax/search_forum.php', data: { whatdo : 'search_posts', uid : {$uid}, page : page, thread : '{$thread}', text : '{$text}', author : '{$author}', type : '{$type}' },
	success: function(result){ $('#forum_reply_list').html(result); $('#forum_search_result').html(result); }
	}); return false; });
	
	});</script>";
	return $table;
	}else{return "No posts meet that criteria.";}
	}else{return "Cannot connect to database...";}
}


if($whatdo == 'search_threads'){

	$cou = "SELECT COUNT(*) as 'count' FROM `adopts_forumthreads` WHERE ".implode(' AND ', $conditions)." ORDER BY id"; 
	if($countsql = mysqli_query($db,$cou)){
	$check = mysqli_fetch_assoc($countsql); $totalrows = $check['count'];
	if($totalrows < 1){return "No threads match this criteria. Try something a little wider?";} 
	else{ $rowsperpage = 4;
	
	if(!$page){$page = 1;}  $limit = ($page - 1) * $rowsperpage;
	$upto = $page * $rowsperpage; $here = ($upto - $rowsperpage) + 1; if($upto > $totalrows){$upto = $totalrows;}
	$lastpage = ceil($totalrows / $rowsperpage);
	$totalpages = ceil($totalrows / $rowsperpage);
	
	$paggy = getPageButtons($page,$totalrows,$rowsperpage);
	}
	}else{return "Could not count thread results...";}
	
	$stmt = "SELECT * FROM `adopts_forumthreads` WHERE ".implode(' AND ', $conditions)." ORDER BY lastpost DESC LIMIT {$limit}, {$rowsperpage}"; 
	if($result = mysqli_query($db,$stmt)){ 
	$rows = mysqli_fetch_object(mysqli_query($db,$stmt));
	if(count($rows)){
	
	while ($thread = $result->fetch_assoc()) {
	
	$ttitle = $thread['title']; $tauthor = $thread['author']; $ticon = $thread['icon']; $tposted = $thread['posted'];
	$lastpost = $thread['lastpost']; $tid = $thread['id']; $view = $thread['view']; 
	if($view != 2){$warn = "[!]";}else{$warn = '';}
	
	$cou2 = "SELECT COUNT(*) as 'count' FROM `adopts_forumposts` WHERE thread = {$tid} ORDER BY id"; 
	if($countsql2 = mysqli_query($db,$cou2)){
	$check2 = mysqli_fetch_assoc($countsql2); $replies = $check2['count'];
	}else{$replies = '?';}
	
	// get detail of author
	$authy = get_profile($tauthor,$db);
	if($authy){ $aav = $authy['avatar']; $aname = $authy['username']; }
	else{$aav = 0; $aname = '???';}
	
	// get detail of last post in this thread
	if($replies > 0){
	$getlast = "SELECT author, posted FROM adopts_forumposts WHERE thread = {$tid} ORDER BY id DESC LIMIT 1";
	if($getresult = mysqli_query($db,$getlast)){ $lpost = $getresult->fetch_assoc(); $lauthor = $lpost['author'];
	  $lprof = get_profile($lauthor,$db); $lav = $lprof['avatar']; $lname = $lprof['username']; $ldate = $lpost['posted'];
	  $last = "<img src='../../pics/avs/{$lav}.gif' style='width:30px;height:30px;vertical-align:middle;'> {$lname}<sub><br>at {$ldate}</sub>";
	}else{$last = "???";} // don't wanna disrupt this script by throwing an error
	}else{$last = 'None';}
	
	//if($type != ''){ $area = $thread['area']; }
	
	$table .= "<div class='forum_thread'>
	  <div class='divicon forum_normal'><img src='../../pics/{$ticon}.gif'> </div>
	  <div class='divtitle forum_normal'><a href='../../gathering/thread/{$tid}'>{$warn} {$ttitle}</a></div>
	  <div class='divauthor forum_normal'><img src='../../pics/avs/{$aav}.gif' style='width:30px;height:30px;vertical-align:middle;'> <a href='../../profile/view/{$tauthor}'> {$aname}</a><sub><br>at {$tposted}</sub></div>
	  <div class='divreplies forum_normal'>{$replies}</div>
	  <div class='divlatest forum_normal'>{$last}</div>
	</div>";
	}
	
	$table .= "<p>{$paggy}</p>
	<script>$(document).ready(function() {
	
	$('.pagi_btn').click(function() { var page = $(this).data('page');
	$.ajax({ type: 'POST', url: '../../ajax/search_forum.php', data: { whatdo : 'search_threads', page : page, area : '{$area}', sticky :  '{$sticky}', author : '{$author}', text : '{$text}', title : '{$title}' },
	success: function(result){ $('#forum_thread_list').html(result); $('#forum_search_result').html(result); }
	}); return false; });
	
	});</script>";
	return $table;
	}else{return "No threads meet that criteria.";}
	}else{return "Cannot connect to database...";}
}

}
echo searchForum();
?> 