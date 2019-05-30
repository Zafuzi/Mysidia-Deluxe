<?php

class ForumView extends View{

	public function index(){
	    $mysidia = Registry::get("mysidia");
	    
	    //Show special message to admins
	    if($mysidia->user->usergroup == 1){$staff_msg = "<p>Since you are an admin, you have access to all of the boards!</p>";}
	    else{$staff_msg = " ";}
	    
	    //Some conditional stuff so users can only see their own alignment board
	    $alignment = $mysidia->user->alignment;
	    switch ($alignment){
	        case "dark":
	            $align_name = "Dark Ghost";
	            $align_board = "<a class='subforumbtn' href='../../forum/area/2'><b>Dark Ghost</b></a>";
	            break;
	        case "light":
	            $align_name = "Light Dragon";
	            $align_board = "<a class='subforumbtn' href='../../forum/area/2'><b>Light Dragon</b></a>";
	            break;
	        case "knowledge":
	            $align_name = "Knowledge Seeker";
	            $align_board = "<a class='subforumbtn' href='../../forum/area/2'><b>Knowledge Seeker</b></a>";
	            break;
	        case "collector":
	            $align_name = "Brave Collector";
	            $align_board = "<a class='subforumbtn' href='../../forum/area/2'><b>Brave Collector</b></a>";
	            break;
	    }
	    
	    $document = $this->document;        
	    $document->setTitle("<center>Forum</center>");
	    $document->add(new Comment("<center><p>Welcome to the Atrocity forums!</br>Click on the box of the parent board to view sub-boards.</p> {$staff_msg}"));
	    $document->add(new Comment("<script>
	            $(document).ready(function(){
	                $('.inf').hide();
	                $('.subf').click(function () { $(this).animate({width: 800},300).find('.inf').toggle(300); });
	            });
	        </script>",FALSE));
            $document->add(new Comment("
            <!--OFFICIAL BOARD-->
	           <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat clearfix'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/1'><b>Official</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(1)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>For official stuff, like news and important announcements.</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: Official Events, Official Info, Official Rules, Official Polls, Site Art</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat clearfix'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Official events</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(2)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Participate in site-wide events!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat clearfix'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Official info</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(3)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Official information or links about the site.</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat clearfix'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Official rules</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(4)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Make sure to read these and stay out of trouble!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat clearfix'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Official polls</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(5)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Participate in various polls for the site. Your vote counts!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat clearfix'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Site Art</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(6)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Here you can submit art to be used on the site!</p>
	                    </div>
	                </div>
		        </div></br>
	       <!--CHAT BOARD-->
                <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/2'><b>General Discussion</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(7)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Talk about the site or anything else here!</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: Introductions, Off-topic</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Introductions</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(8)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Whether you're new to the site or just returning, introduce yourself here!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Off-topic</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(9)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>A place where you can discuss all sorts of things</p>
	                    </div>
	                </div>
		        </div></br>
		    <!--SUPPORT BOARD-->
                <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/2'><b>Questions and support</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(10)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>A place to ask questions and get help!</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: Bug Reports</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Bug Reports</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(11)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Report any bugs and glitches you find!</p>
	                    </div>
	                </div>
		        </div></br>
		    <!--ADVERTISING BOARD-->
                <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/2'><b>Advertising</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(12)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>A place to sell or trade things with other users!</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: Shops, Pets, Trades</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Shops</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(13)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Advertise your user shop!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Pets</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(14)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Sell your pets here!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Trades</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(15)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>A place to organize trades with other users</p>
	                    </div>
	                </div>
		        </div></br>
		    <!--CREATIVE BOARD-->
                <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/2'><b>Creative Corner</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(16)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Get creative and show off your skills!</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: Art, Writing, Poetry, Other</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Art</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(17)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Share your art here!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Writing</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(18)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>A place for sharing stories, poems, and other written works!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Other</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(19)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>A place for other hobbies!</p>
	                    </div>
	                </div>
		        </div></br>", FALSE));
		        
		        if($mysidia->user->usergroup == 1){ //if user is an admin, show all alignment boards
		            $document->add(new Comment("<!--ALIGNMENT BOARD-->
                <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/2'><b>Alignments Area</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(20)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Topics related to the different alignments go here!</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: Dark Ghost, Light Dragon, Brave Collector, Knowledge Seeker</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Dark Ghost</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(21)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Talk with other members of your alignment!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Light Dragon</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(22)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Talk with other members of your alignment!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Brave Collector</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(23)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Talk with other members of your alignment!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Knowledge Seeker</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(24)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Talk with other members of your alignment!</p>
	                    </div>
	                </div>
		        </div></br>", FALSE));
		        }
		        elseif($mysidia->user->isloggedin == FALSE){}//show nothing here
		        //Need to properly add area numbers!
		        else{$document->add(new Comment("<!--ALIGNMENT BOARD-->
                <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/2'><b>Alignments Area</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: #</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Topics related to the different alignments go here!</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: {$align_name}</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                {$align_board}
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: #</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Talk with other members of your alignment!</p>
	                    </div>
	                </div>
		        </div></br>", FALSE));}
	        $document->add(new Comment("
		    <!--GAME BOARD-->
                <div class='subf'>
                    <div class='board_holder'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='forumbtn' href='../../forum/area/2'><b>Game Corner</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(25)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Play different forum-based games!</p>
                            <p style='text-align:left; font-size:12px;'>Sub-boards: Pet Showcase, Word Games, Rabbit Doubt</p>
	                    </div>
	                </div></br>
                    <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Pet Showcase</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(26)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Show off your in-game pets!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Word Games</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(27)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>A place to play word-based games!</p>
	                    </div>
	                </div>
	                <div class='sub_board_holder inf'>
                        <div class='forumcat'>
                            <div class='boardhead'>
                                <a class='subforumbtn' href='../../forum/area/2'><b>Rabbit Doubt</b></a>
                            </div>
                            <p style='float:right; line-height:30px;'>
                                Threads: {$this->getThreads(28)}</br>
                                Posts: #
                            </p>
                            <p style='height:60px; line-height:60px;'>Play Rabbit Doubt here!</p>
	                    </div>
	                </div>
		        </div></br>
	", FALSE));  
        $document->add(new Comment("</center>"));
	}
	
	public function area(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("forum"); $uid = $mysidia->user->uid; $admins = array(1,94);
	
	$fullurl = $_SERVER['REQUEST_URI']; $scrub = explode('/',trim($fullurl,'/')); $area = end($scrub);
	$back = "<a href='../../forum'><button class='button_general'>Back to Main Forum</button></a>";
	
	// no area number...
	if($area == 'area'){$document->add(new Comment("<h1>Hmm?</h1><p>An area of discussion wasn't chosen. Where are we?</p>{$back}",FALSE)); return;}
	// area 30 is only for admins/mods to view
	if($area == 30 && !in_array($uid,$admins)){$document->add(new Comment("<h1>Excuse me!</h1><p>Some guards hurry to stop you from entering the corridor.<br>Only authorities are permitted to enter the Imperial Quarters. Sorry!</p>{$back}",FALSE)); return;}
	
	// all good, fetch this area's name, bg, description
	$category = $mysidia->db->select("forumareas", array(), "id = {$area}")->fetchObject();
	if(!$category){ $document->add(new Comment("<h1>Hmm?</h1><p>That area couldn't be found.</p>{$back}",FALSE)); return; }
	else{ $name = $category->name; $desc = $category->description; }
	
	$allthreads = $mysidia->db->select("forumthreads", array(), "area = {$area}")->rowCount();
	
	$document->add(new Comment("{$back} <h1>{$name}</h1>
	<p><b>{$desc}</b></p>There are <b>{$allthreads}</b> discussions going on here.<br>",FALSE));
	
	// hi guest
	if(!$mysidia->user->isloggedin){ $document->add(new Comment("<div class='guest'>Hello, guest! Are you a tourist, or just forgot your  documents?<br>You're welcome to <a href='register'><b>Register</b></a> or <a href='login'><b>Log In</b></a> if you want to take part in discussions here.</div>", FALSE)); }
	
	// set up 'table' headings, and add a fake topic that links to rules page
	if($allthreads != 0){ $document->add(new Comment("
	<div class='forum_thread'>
	  <div class='divicon forum_top'>Icon</div>
	  <div class='divtitle forum_top'>Title</div>
	  <div class='divauthor forum_top'>Author</div>
	  <div class='divreplies forum_top'>Replies</div>
	  <div class='divlatest forum_top'>Latest Reply</div>
	</div>
	<div class='forum_thread'>
	  <div class='divicon forum_sticky'><img src='../../pics/20pxegg.png'></div>
	  <div class='divtitle forum_sticky'><a href='../../guide/forum'><b>Universal Forum Rules</b></a></div>
	  <div class='divauthor forum_sticky'>Admin</div>
	  <div class='divreplies forum_sticky'>---</div>
	  <div class='divlatest forum_sticky'>---</div>
	</div>",FALSE));
	
	// start getting Sticky important threads, at the top always
	$stickies = $mysidia->db->select("forumthreads", array(), "sticky = 1 AND area = {$area}")->rowCount();
	if($stickies > 0){ $sti = $mysidia->db->select("forumthreads", array("id"), "sticky = 1 AND area = {$area} ORDER BY id ASC LIMIT 20"); 
	while($stid = $sti->fetchColumn()){ 
	$sticky = $mysidia->db->select("forumthreads", array(), "id = {$stid}")->fetchObject();
	// count replies, if there are some, get info of latest reply
	$sreplies = $mysidia->db->select("forumposts", array(), "thread = {$stid}")->rowCount();
	// get username of the thread starter
	$poster = $mysidia->db->select("users_profile", array(), "uid = {$sticky->author}")->fetchObject();
	// get last post info
	$lpost = $mysidia->db->select("forumposts", array(), "thread='{$stid}' ORDER BY id DESC LIMIT 1")->fetchObject();
	  if(!$lpost){$latest = "None";}
	  else{$lposter = $mysidia->db->select("users_profile", array(), "uid = {$lpost->author}")->fetchObject();
	  $latest = "<img src='../../pics/avs/{$lposter->avatar}.gif' style='width:30px;height:30px;vertical-align:middle;'> {$lposter->username}<sub><br>at {$lpost->posted}</sub>";}
	$document->add(new Comment("<div class='forum_thread'>
	  <div class='divicon forum_sticky'><img src='../../pics/{$sticky->icon}.gif'></div>
	  <div class='divtitle forum_sticky'><a href='../../forum/thread/{$stid}'><b>[Sticky]</b> {$sticky->title}</a></div>
	  <div class='divauthor forum_sticky'><img src='../../pics/avs/{$poster->avatar}.gif' style='width:30px;height:30px;vertical-align:middle;'>  <a href='../../profile/view/{$poster->username}'> {$poster->username}</a><sub><br>at {$sticky->posted}</sub></div>
	  <div class='divreplies forum_sticky'>{$sreplies}</div>
	  <div class='divlatest forum_sticky'>{$latest}</div>
	</div>",FALSE));
	} // end sticky loop. Won't bother with paginating, there shouldn't be many
	} // no stickies
	
	// now normal threads 
	if($allthreads - $stickies > 0){
	
	// for pagination, gotta start with page 1
	$page = 1; $rowsperpage = 4; $limit = ($page - 1) * $rowsperpage; $totalrows = $allthreads - $stickies;
	  $upto = $page * $rowsperpage; $here = ($upto - $rowsperpage) + 1; if($upto > $totalrows){$upto = $totalrows;}
	$lastpage = ceil($totalrows / $rowsperpage);
	$totalpages = ceil($totalrows / $rowsperpage);
	$pagi = new AjaxPagination;  $paggy = $pagi->getPageButtons($page,$totalrows,$rowsperpage);
	
	$document->add(new Comment("<div id='forum_thread_list'>",FALSE));
	
	$thr = $mysidia->db->select("forumthreads", array("id"), "sticky = 0 AND area = {$area} ORDER BY lastpost DESC LIMIT {$limit}, {$rowsperpage}");
	while($thid = $thr->fetchColumn()){
	$thread = $mysidia->db->select("forumthreads", array(), "id = {$thid}")->fetchObject();
	// if thread is censored, change icon and
	$tview = $thread->view; if($tview == 0){$icon = 'x'; $warn = '[!]';}else{$icon = $thread->icon; $warn = '';}
	// count replies, if there are some, get info of latest reply
	$treplies = $mysidia->db->select("forumposts", array(), "thread = {$thid}")->rowCount();
	// get username of the thread starter
	$tposter = $mysidia->db->select("users_profile", array(), "uid = {$thread->author}")->fetchObject();
	// get last post info
	$lpost2 = $mysidia->db->select("forumposts", array(), "thread= {$thid} ORDER BY id DESC LIMIT 1")->fetchObject();
	  if(!$lpost2){$latest2 = "None";}
	  else{$lposter2 = $mysidia->db->select("users_profile", array(), "uid = {$lpost2->author}")->fetchObject();
	  $latest2 = "<img src='../../pics/avs/{$lposter2->avatar}.gif' style='width:30px;height:30px;vertical-align:middle;'> {$lposter2->username}<sub><br>at {$lpost2->posted}</sub>";}
	$document->add(new Comment("<div class='forum_thread'>
	  <div class='divicon forum_normal'><img src='../../pics/{$icon}.gif'> </div>
	  <div class='divtitle forum_normal'><a href='../../forum/thread/{$thid}'>{$warn} {$thread->title}</a></div>
	  <div class='divauthor forum_normal'><img src='{$tposter->avatar}' style='width:30px;height:30px;vertical-align:middle;'> <a href='../../profile/view/{$tposter->username}'> {$tposter->username}</a><sub><br>at {$thread->posted}</sub></div>
	  <div class='divreplies forum_normal'>{$treplies}</div>
	  <div class='divlatest forum_normal'>{$latest2}</div>
	</div> ",FALSE));
	} // end thread loop
	$document->add(new Comment("<p>{$paggy}</p></div><br>",FALSE)); // end div, include pagination buttons
	
	}else{ $document->add(new Comment("<p>There are no ordinary threads in this area at the moment.</p>",FALSE)); }
	
	}else{ $document->add(new Comment("<p>There are no threads of any kind in this area at the moment.</p>",FALSE)); }
	// finished all threads. Now show thread making options, if user can. Always show area list below
	
	$areamove = "Visit another area? <select id='forum_area_list'><option value='1'>Imperial Office</option><option value='2'>Academy</option><option value='3'>-- New Arrivals</option><option value='4'>Hatchery</option><option value='5'>-- Genetic Talk</option><option value='6'>-- Menagerie</option><option value='7'>Egg to Elder</option><option value='8'>Training Grounds</option><option value='9'>-- Mage Wars</option><option value='10'>Day to Day</option><option value='11'>My Island</option><option value='12'>-- Craft Corner</option><option value='13'>-- Growing and Building</option><option value='14'>World Map</option><option value='15'>-- Scholars' Hall</option><option value='16'>Marketplace</option><option value='17'>-- Griffin Trades</option><option value='18'>-- Item Trades</option><option value='19'>-- Feeling Generous</option><option value='20'>Customisation</option><option value='21'>-- Appearances and Patterns</option><option value='22'>-- Adornments</option><option value='23'>-- Hello, Handsome</option><option value='25'>Storytellers</option><option value='26'>-- Character Showcase</option><option value='27'>-- Non Roleplay</option><option value='28'>City Square</option><option value='29'>-- Party Tent</option><option value='30'>Imperial Quarters</option>
	</select> <button id='forum_area_btn'>Go!</button>
	<script>$(function(){
	
	$('#forum_area_btn').click(function(){ var area = $('#forum_area_list').val();
	window.location.href = '../../forum/area/' + area; });
	
	});</script>";

	// rule out all those who can't make threads...
	if(!$mysidia->user->isloggedin){$document->add(new Comment("You are not logged in! Please do so, to create threads.
	<p>{$areamove}</p>",FALSE)); return; }
	
	if($area == 30 && !in_array($uid,$admins)){ $document->add(new Comment("Only admins may create threads in this area.
	<p>{$areamove}</p>",FALSE)); return; }
	
	$canpost = $mysidia->db->select("users_status", array("canpost"), "uid = {$uid}")->fetchColumn();
	if($canpost == "no"){ $document->add(new Comment("You are not permitted to create threads or post in the forum.
	<p>{$areamove}</p>",FALSE)); return;}
	
	// nah we're good
	$document->add(new Comment("<br><button id='forum_newthread_btn' class='button_general'>Create New Thread</button><br>
	<div id='forum_newthread_box' style='min-height:250px;background-color:white;border:1px solid grey;border-radius:10px;padding:10px;margin:10px auto;display:none;'>
	  <div id='forum_newthread_contents'>
	  Enter the thread title: <input id='forum_newthread_title' type='text' maxlength='30' value='New thread'>
	  <br>Write the contents of the opening post:<br><textarea id='forum_newthread_text' style='resize:none;'>This thread is about...</textarea>
	  <br><button id='forum_newthread_submit' class='button_general'>Submit!</button>
	  </div>
	  <div id='forum_newthread_result'>...</div>
	</div><p>{$areamove}</p>
	
	<script>$(function(){ 
	
	// ajax pagination
	$('.pagi_btn').click(function(){ var page = $(this).data('page');
	$.ajax({ type: 'POST', url: '../../ajax/search_forum.php', data: { whatdo : 'search_threads', page : page, sticky : 0, area : {$area} },
	success: function(result){ $('#forum_thread_list').html(result); }
	}); return false; });
	
	$('#forum_newthread_btn').click(function(){ $('#forum_newthread_box').toggle(); });
	
	$('#forum_newthread_submit').click(function(){
	var text = $('#forum_newthread_text').val(); var icon = $('#forum_newthread_icon').val(); var title = $('#forum_newthread_title').val();
	// hmm, mods/admins should get more options here...
	// for now, they must edit thread after creating.
	$.ajax({ type: 'POST', url: '../../ajax/forumpost.php', data: { whatdo : 'create_thread', uid : {$uid}, title : title, text : text, target : {$area} },
	success: function(result){ $('#forum_newthread_result').html(result);
	  if(result == 'Thread created!'){ $('#forum_newthread_contents').hide(); location.reload(); }
	}
	}); return false; });
	
	});</script>",FALSE)); 
	
	}
	
	public function thread(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;        
	$document->setTitle(" "); $uid = $mysidia->user->uid; $admins = array(1,94);
	
	$fullurl = $_SERVER['REQUEST_URI']; $scrub = explode('/',trim($fullurl,'/')); $num = end($scrub);
	$back = "<a href='../../forum'><button class='button_general'>Shall we return to the index?</button></a>
	<meta http-equiv='refresh' content='1; url=/forum'>";
	
	// if no thread number
	if($num == 'thread'){ $document->add(new Comment("<h1>Hmm?</h1><p>No discussion was found here. Where are we?</p>{$back}",FALSE)); return; }
	// look up thread
	$thread = $mysidia->db->select("forumthreads", array(), "id = {$num}")->fetchObject();
	if(!$thread){ $document->add(new Comment("<h1>Hmm?</h1><p>No discussion was found here.</p>{$back}",FALSE)); return; }
	// if in admin area
	if($thread->area == 30 && !in_array($uid,$admins)){ $document->add(new Comment("<h1>Excuse me!</h1>
	<p>Some guards hurry to stop you from entering the corridor. Only authorities are permitted to enter the Imperial Quarters. Sorry!
	</p>{$back}",FALSE)); return; }
	// if censored
	if($thread->view == 0 && !in_array($uid,$admins)){ $document->add(new Comment("<h1>Excuse me!</h1><p>This thread is <b>locked</b> to ordinary Masters.<br>Only Admins or Moderators can view it.</p>{$back}",FALSE)); return; }
	
	// all good
	$area = $mysidia->db->select("forumareas", array(), "id = {$thread->area} ")->fetchObject();
	$replies = $mysidia->db->select("forumposts", array(), "thread = {$num}")->rowCount();
	if($thread->view == 1){$locked = "This thread is <b>locked</b> to ordinary Masters.<br>Only Admins or Moderators can add new replies.";}else{$locked = '';}
	
	$document->add(new Comment("<a href='../../forum/area/{$thread->area}'><button class='button_general'><< Back to <b>{$area->name}</b></button></a><br>
	<p>There are {$replies} replies to this thread.<br>{$lockstatus}</p>",FALSE));
	
	// hello guest
	if(!$mysidia->user->isloggedin){ $document->add(new Comment("<div class='guest'>Hello, guest! Are you a tourist, or just forgot  your documents?<br>You're welcome to <a href='register'><b>Register</b></a> or <a href='login'><b>Log In</b><a> if you want to take part in discussions here.</div>", FALSE));}
	
	
	// if you are mod/admin, or this is your own thread, add button to bring up Edit Thread box
	if(in_array($uid,$admins) || $uid == $thread->author){
	$document->add(new Comment("
	<div id='forum_editthread_box'><b>Editing Thread</b> <div id='forum_editthread_hide'>[close]</div>
	  <div id='forum_editthread_form'> (AJAX should generate the form here!) </div>
	</div>",FALSE));
	}
	
	// begin with the opening post. It's not actually a post, but part of the thread
	$author = $mysidia->db->select("users_profile", array("username","nickname","signature","avatar","forumposts"), "uid = {$thread->author}")->fetchObject();
	$aug = $mysidia->db->select("users", array("usergroup"), "uid = {$thread->author}")->fetchColumn();
	  if($aug == 1 || $aug == 2){$asymbol = "<img src='../../picuploads/icons/Adminlabel.png' style='vertical-align:middle;'> "; $apostbit = 'admin';}
	  elseif($aug == 4){$asymbol = "<img src='../../pics/20pxwhite.gif' style='vertical-align:middle;'> "; $apostbit = 'mod';}
	  elseif($aug == 5){$asymbol = "<img src='../../pics/tinyrab.png' style='vertical-align:middle;'> "; $apostbit = 'banned';}
	  else{$asymbol = ''; $apostbit = 'member';}
	
	// see if you wanna see signatures or not. For guests they appear by default
	if($mysidia->user->isloggedin){ $seesigs = $mysidia->db->select("users_profile", array("forumsigs"), "uid = {$uid}")->fetchColumn();
	}else{$seesigs = 1;}
	if($seesigs == 1){$threadsig = "<hr><br>{$author->signature}";}
	else{$threadsig = '';}
	
	// don't show guests report btn
	if(!$mysidia->user->isloggedin){$reportthread = '';}
	else{$reportthread = "<div class='forum_report_btn' data-id='{$thread->id}' data-what='thread'>!</div>";}
	if(in_array($uid,$admins) || $uid == $post->author){$editbtn = "<div class='edit_btn' id='edit_btn'>Edit</div>";} else{$editbtn = ' ';}
	
	
	$document->add(new Comment("
	<div class='forum_posthold'>
	  <div class='boardhead' style='width:814px;'><h2><span id='forum_thread_title'>{$thread->title}</span></h2></div>
	  <div class='forum_postbit {$apostbit}'>
	    {$asymbol} <sub>{$author->nickname}</sub><br>
	    <a href='../../profile/view/{$author->username}'><img src='{$author->avatar}' style='max-width:100px; max-height:100px;'><br>
	    {$author->username}</a><br> <sub>Posts: {$author->forumposts}</sub>
	  </div>
	  <div class='forum_posttext'>
	    <div class='forum_postinfo'>Thread created: {$thread->posted} {$editbtn} {$reportthread}</div><br>
	    <span id='forum_thread_text'>{$thread->text}</span><br>{$threadsig}
	  </div>
	</div>
	
	<div id='forum_report_box'>Report post? <div id='forum_report_hide'>[x]</div><br>
	  Write the reason:<br><textarea id='forum_report_reason' style='padding:5px;margin:0px;width:150px;height:100px;resize:none;' maxlength='200'>...</textarea><br>
	  <button id='forum_report_submit'>Submit</button><br>
	  <div id='forum_report_result'></div>
	</div>
	
	<div id='forum_edit_box'>Edit post? <div id='forum_edit_hide'>[x]</div><br>
	  <div id='forum_edit'>New text:<br><textarea id='forum_edit_text' class='editarea' maxlength='1000'>...</textarea></div><br>
	  <button id='forum_edit_submit'>Submit</button><br>
	  <div id='forum_edit_result'></div>
	</div>",FALSE));
	
	// for pagination, gotta start with page 1
	$page = 1; $rowsperpage = 4; $limit = ($page - 1) * $rowsperpage; $totalrows = $replies; // counted earlier
	  $upto = $page * $rowsperpage; $here = ($upto - $rowsperpage) + 1; if($upto > $totalrows){$upto = $totalrows;}
	$lastpage = ceil($totalrows / $rowsperpage);
	$totalpages = ceil($totalrows / $rowsperpage);
	$pagi = new AjaxPagination;  $paggy = $pagi->getPageButtons($page,$totalrows,$rowsperpage);
	
	// and now we have the posts to initially fetch
	$reps = $mysidia->db->select("forumposts", array("id"), "thread = {$num} ORDER BY id ASC LIMIT {$limit}, {$rowsperpage}");
	
	$document->add(new Comment("<div id='forum_reply_list'><span id='forum_action_result'></span>",FALSE));
	
	// start looping through replies
	$replynum = 0;
	//$reps = $mysidia->db->select("forumposts", array("id"), "thread = {$num} ORDER BY id ASC LIMIT 40");
	while($rid = $reps->fetchColumn()){ $replynum++;
	$post = $mysidia->db->select("forumposts", array(), "id = {$rid}")->fetchObject();
	// get details of replier
	$poster = $mysidia->db->select("users_profile", array("username","nickname","signature","avatar","forumposts"), "uid = {$post->author}")->fetchObject();
	$puser = $mysidia->db->select("users", array("usergroup"), "uid = {$post->author}")->fetchObject();
	$pcan = $mysidia->db->select("users_status", array("canpost"), "uid = {$post->author}")->fetchColumn();
	$pug = $puser->usergroup;
	  if($pug == 1 || $pug == 2){$psymbol = "<img src='../../picuploads/icons/Adminlabel.png' style='vertical-align:middle;'> "; $ppostbit = 'admin';}
	  elseif($pug == 4){$psymbol = "<img src='../../pics/20pxwhite.gif' style='vertical-align:middle;'> "; $ppostbit = 'mod';}
	  elseif($pug == 5){$psymbol = "<img src='../../pics/tinyrab.png' style='vertical-align:middle;'> "; $ppostbit = 'banned';}
	  else{$psymbol = ''; $ppostbit = 'member';}
	if($pcan != "yes"){$silent = "(Silent)";}else{$silent = '';}
	if($post->report != 0){$reported = "(Reported)";}else{$reported = '';}
	
	// if mod/admin, can silence user or delete post
	if(in_array($uid,$admins)){$silencebtn = "<div class='forum_silence_btn' data-uid='{$post->author}'>Silence</div>";
	$deletebtn = "<div class='forum_deletepost_btn' data-id='{$post->id}'>Delete Post</div>";}
	else{$silencebtn = ''; $deletebtn = '';}
	
	// if this is user's own post, or a mod/admin is viewing, show edit button
	if(in_array($uid,$admins) || $uid == $post->author){$editbtn = "<div class='forum_edit_btn' data-id='{$post->id}' data-what='post'>Edit</div>";} else{$editbtn = ' ';}
	// to avoid spam, don't show this or report button to guests
	if(!$mysidia->user->isloggedin){$editbtn = ''; $reportbtn = ''; $uid = 0;}
	else{$reportbtn = "<div class='forum_report_btn' data-id='{$post->id}' data-what='post'>!</div>";}
	
	if($seesigs == 1){ if($poster->signature == ''){$postsig = '';}else{$postsig = "<hr><br>{$poster->signature}";}
	}
	else{$postsig = '';}
	
	$document->add(new Comment("
	<div id='forum_post{$post->id}' class='forum_posthold'>
	  <div class='forum_postbit {$ppostbit}'>
	    {$psymbol} <sub>{$poster->nickname}</sub><br>
	    <a href='../../profile/view/{$author->username}'><img src='{$poster->avatar}' style='max-height:100px; max-width:100px;'><br>
	    {$poster->username}</a><br><sub>Posts: {$poster->forumposts}</sub>
	  </div> 
	  <div class='forum_posttext'>
	    <div class='forum_postinfo'>Reply {$replynum} at {$post->posted} {$editbtn} {$reportbtn} {$reported} 
	     {$silencebtn} <span class='forum_silent{$post->author}'></span> {$deletebtn}</div><br>
	    <div id='forumpost_{$post->id}'>{$post->text}</div><br>{$postsig}
	  </div>
	</div>",FALSE));
	} // end reply loop
	
	// end of posts div, include pagination buttons again
	$document->add(new Comment("<span id='forum_action_result'></span><p>{$paggy}</p></div><br>",FALSE));
	
	// now if user is logged in, has permission to post, and if thread is reply-enabled, show box to submit post.
	if(!$mysidia->user->isloggedin){$canpost = "no";}
	else{
	  if($thread->view != 2 && !in_array($uid,$admins)){$canpost = "no";}
	  else{ $canpost = $mysidia->db->select("users_status", array("canpost"), "uid={$uid}")->fetchColumn(); }
	}
	if($canpost == "no"){ $document->add(new Comment("You cannot reply to this thread, because you are not logged in, or because it has been locked.",FALSE)); }
	else{ // all the stuff for posting
	
	$me = $mysidia->db->select("users_profile", array(), "uid={$uid}")->fetchObject();
	
	$document->add(new Comment("<script>$(function() { 
	
	var typeselected = 'thread'; var idselected = 0; var postid = 0;
	// change these global vars when edit or report box is called up, to track ID of target thread/post
	
	// ajax pagination
	$('.pagi_btn').click(function(){ var page = $(this).data('page');
	$.ajax({ type: 'POST', url: '../../ajax/search_forum.php', data: { whatdo : 'search_posts', page : page, thread : {$num}, uid : {$uid} },
	success: function(result){ $('#forum_reply_list').html(result); }
	}); return false; });
	
	// show edit thread box. The options form will be sent back with its own JS for sending
	$('#edit_btn').click(function(){ $('#forum_editthread_box').show(); 
	  $.ajax({ type: 'POST', url: '../../ajax/forumpost.php', data: { whatdo : 'edit_thread', target : {$num}, uid : {$uid} },
	  success: function(result){ $('#forum_editthread_form').html(result); }
	}); return false; });
	$('#forum_editthread_hide').click(function(){ $('#forum_editthread_box').hide(); });
	
	// show report box, positioned relative to this report button
	$(document).on('click','.forum_report_btn',function(){
	  idselected = $(this).data('id'); typeselected = $(this).data('what'); // are we reporting a post or thread?
	  $('#forum_report_result').html(typeselected+','+idselected);
	  var pos = $(this).position(); var width = $(this).outerWidth();
	  $('#forum_report_box').css({ position: 'absolute', top: (pos.top + 30) + 'px', left: (pos.left - 150) + 'px' }).fadeIn(400);
	  $('#forum_report_reason,#forum_report_submit').show(); // after report send, these are hidden. Show again for new box
	});
	$('#forum_report_hide').click(function(){ $('#forum_report_box').fadeOut(400); });
	
	// send report
	$('#forum_report_submit').click(function(){
	  var reason = $('#forum_report_reason').val(); var target = idselected; var icon = typeselected;
	  $.ajax({ type: 'POST', url: '../../ajax/forumpost.php', data: { whatdo : 'report', uid : {$uid}, text : reason, target : target, icon : icon  },
	  success: function(result){
	    if(result == 'Report submitted.' || result == 'Already reported. Thanks though!' || result == 'Reported, not updated...'){ 
	      $('#forum_report_reason').val(''); $('#forum_report_reason,#forum_report_submit').hide();
	    }
	    $('#forum_report_result').html(result);
	  }
	}); return false; });
	
	// silence naughty user
	$(document).on('click','.forum_silence_btn',function(){
	  var silent = $(this).data('uid'); $('#forum_action_result').html('Silencing user '+silent+'...');
	  $.ajax({ type: 'POST', url: '../../ajax/forumpost.php', data: { whatdo : 'silence', target : silent, uid : {$uid} },
	  success: function(result){ $('#forum_action_result').html(result);
	    if(result == 'Silenced!'){ $('.forum_silent'+silent).html(result); }
	  }
	}); return false; });
	
	// delete a post
	$(document).on('click','.forum_deletepost_btn',function(){
	  var badpost = $(this).data('id'); $('#forum_action_result').html('Deleting post '+badpost+'...');
	  $.ajax({ type: 'POST', url: '../../ajax/forumpost.php', cache : false, data: { whatdo : 'delete_post', target : badpost, uid : {$uid} },
	  success: function(result){ $('#forum_action_result').html(result);
	    if(result == 'Deleted!'){ $('#forum_post'+badpost).fadeOut(400); }
	  }
	}); return false; });
	
	// brings up post edit box with textarea, and fetches current post contents to put in it
	$(document).on('click','.forum_edit_btn',function(){
	postid = $(this).data('id'); var pos2 = $(this).position(); var width = $(this).outerWidth();
	$('#forum_edit_box').css({ position: 'absolute', top: (pos2.top + 25) + 'px', left: (pos2.left - 520) + 'px' }).fadeIn(400);
	$('#forum_edit_text').show().val('...');
	$.ajax({ type: 'POST', url: '../../ajax/forumpost.php', cache : false, data: { whatdo : 'edit_post', target : postid, uid : {$uid} },
	  beforeSend : function(){ $('#forum_edit_text').val('...'); $('#forum_edit_result').html('Looking up post '+postid+'...'); },
	  success: function(result){ $('#forum_edit_text').val(result); $('#forum_edit_result').html(''); $('#forum_edit_submit').show(); }
	}); return false; });
	$('#forum_edit_hide').click(function() {  $('#forum_edit_text').val(''); $('#forum_edit_box').fadeOut(400); });
	
	// send the contents of edit textarea
	$('#forum_edit_submit').click(function(){
	var text = $('#forum_edit_text').val();
	$.ajax({ type: 'POST', url: '../../ajax/forumpost.php', data: { whatdo : 'edit_post_submit', uid : {$uid}, text : text, target : postid },
	success: function(result){ $('#forum_edit_result').html(result);
	  if(result == 'Post updated!'){ $('#forumpost_'+postid).html(text); // superficially replace old text of post
	  $('#forum_edit_submit').hide(); $('#forum_edit_text').val('...');
	  $('#forum_edit_box').fadeOut(400);
	  }
	}
	}); return false; });
	
	// send new post
	$('#forum_reply_submit').click(function(){
	var text = $('#html-output').val();
	$.ajax({ type: 'POST', url: '../../ajax/forumpost.php', cache : false, data: { whatdo : 'create_post', uid : {$uid}, text : text, target : '{$num}' },
	beforeSend : function(){ $('#forum_reply_result').html('Sending...'); },
	success: function(result){ $('#forum_reply_result').html(result);
	  if(result == 'Post added!'){ $('#forum_reply_text').val(''); }
	  location.reload();
	  // keep textarea open. You can see your new post by loading last page. Not sure how to jump to last page :/
	}
	}); return false; });
	
	});</script>
	
	<p>Would you like to reply to this thread?<br>
	Please be reminded of the <a href='../../guide/forum'><b>Forum Rules</b></a>, and check spelling and grammar before sending.</p>
	<div class='forum_postbit member'>
	  <sub>{$me->nickname}</sub><br>
	  <img src='{$me->avatar}' style='max-width:130px; max-height:130px;'><br>
	  {$me->username}<br>
	  <sub>Posts: {$me->forumposts}</sub>
	</div>
	
	<div class='forum_posttext'>
	  <div id='editor' class='pell' style='resize:none;'></div>
	  <textarea id='html-output' style='width:100%;height:200px;resize:none;display:none;'></textarea><br>
	  <button id='forum_reply_submit' class='button_general'>Send reply!</button>
	  <div id='forum_reply_result'> </div>
	</div>",FALSE));
	}
	
	}
	
	
	public function search(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Search Forum"); 
	
	if(!$mysidia->user->isloggedin){ $document->add(new Comment("<h2>Hi, guest!</h2><p>Sorry, the forum search is available to members only.</p><a href='../../forum'>Back to forum</a>",FALSE)); return; }
	$uid = $mysidia->user->uid;
	
	$document->add(new Comment("<h2>Search the Forum</h2><p>You can look for specific threads or posts here.</p>
	(if thread) <b>Title:</b> <input type='text' id='forum_search_title' maxlength='40'>
	<br>(if thread) <b>Area:</b> <select id='forum_search_area'><option value=''>Anywhere</option>
<option value='1'>Imperial Office</option><option value='2'>Academy</option><option value='3'>-- New Arrivals</option><option value='4'>Hatchery</option><option value='5'>-- Genetic Talk</option><option value='6'>-- Menagerie</option><option value='7'>Egg to Elder</option><option value='8'>Training Grounds</option><option value='9'>-- Mage Wars</option><option value='10'>Day to Day</option><option value='11'>My Island</option><option value='12'>-- Craft Corner</option><option value='13'>-- Growing and Building</option><option value='14'>World Map</option><option value='15'>-- Scholars' Hall</option><option value='16'>Marketplace</option><option value='17'>-- Griffin Trades</option><option value='18'>-- Item Trades</option><option value='19'>-- Feeling Generous</option><option value='20'>Customisation</option><option value='21'>-- Appearances and Patterns</option><option value='22'>-- Adornments</option><option value='23'>-- Hello, Handsome</option><option value='25'>Storytellers</option> <option value='26'>-- Character Showcase</option><option value='27'>-- Non Roleplay</option><option value='28'>City Square</option><option value='29'>-- Party Tent</option>
	</select>
	<br><b>Text/Opening post:</b><br><textarea id='forum_search_text'></textarea>
	<br><b>Author:</b> <input type='text' id='forum_search_author'>
	<br><b>What:</b> <select id='forum_search_type'><option value='posts'>Posts</option><option value='threads'>Threads</option></select>
	<br><button id='forum_search_submit' class='button_general'>Search!</button>
	<br><div id='forum_search_result'></div>
	
	<script>$(function() { 
	
	$('#forum_search_submit').click(function() {
	var text = $('#forum_search_text').val(); var title = $('#forum_search_title').val();
	var author = $('#forum_search_author').val(); var type = $('#forum_search_type').val();
	var area = $('#forum_search_area').val(); var whatdo = 'search_'+type;
	$.ajax({ type: 'POST', url: '../../ajax/search_forum.php', 
	data: { whatdo : whatdo, type : 'search', uid : {$uid}, title : title, text : text, author : author, area : area },
	success: function(result){ $('#forum_search_result').html(result); }
	}); return false; });
	
	});</script>",FALSE));
	
	}
	
	private function getThreads($area){
	    $mysidia = Registry::get("mysidia");
	    $allthreads = $mysidia->db->select("forumthreads", array(), "area = {$area}")->rowCount();
	    if($allthreads == 0 || $allthreads == NULL){return "0";}
	    else{return $allthreads;}
	}
	
	private function getPosts($area){ //Will add later...
	    $mysidia = Registry::get("mysidia");
	    $allthreads = $mysidia->db->select("forumthreads", array(), "area = {$area}")->rowCount();
	    if($allthreads == 0 || $allthreads == NULL){return "0";}
	    else{return $allthreads;}
	}
	
}
?>