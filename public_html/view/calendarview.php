<?php
class CalendarView extends View{
	
	public function index(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Advent Calendar");
	$uid = $mysidia->user->uid;
	$username = $mysidia->user->username;
	
	$calendar = $mysidia->db->select("users_profile", array("calendar"), "uid = {$uid}")->fetchColumn();
	
	// fetch the list of potentially lucky pets!
	$stmt1 = $mysidia->db->select("owned_adoptables", array("aid","name"), "owner = '{$username}' AND currentlevel > 1 ORDER BY RAND() DESC LIMIT 20");
	$mypets = ''; while($pet = $stmt1->fetchObject()){ $mypets .= "<option value='{$pet->aid}'>{$pet->name}</option>"; }
	
	// check which boxes have been opened, and add to display list.
	// can't open any with higher number than today - and for user convenience, today's is highlighted if not opened
	$myboxes = explode(",",$calendar); $num = 1; $today = date('d'); $boxes = '';
	while($num < 31){
	  if(in_array($num,$myboxes)){ $boxes .= "<div id='calendar_box{$num}' class='calendar_box calendar_opened'>{$num}</div>"; }
	  else{
	    if($num == $today){ $boxes .= "<div id='calendar_box{$num}' class='calendar_box calendar_today' data-box='{$num}'>{$num}</div>"; }
	    elseif($num > $today){ $boxes .= "<div id='calendar_box{$num}' class='calendar_box calendar_notyet'>{$num}</div>"; }
	    else{ $boxes .= "<div id='calendar_box{$num}' class='calendar_box calendar_closed' data-box='{$num}'>{$num}</div>"; }
	    }
	$num++; }
	
	$document->add(new Comment("
	<p>The Season of Love is upon us! Last month we all crafted countless gift boxes - it was a good distraction while hunkering down and avoiding the snow, wasn't it?
	<br>Now it's time to start counting down and making wishes for the next year. And open gifts, of course!<br>Every day you can choose a lucky pet to open one of your boxes.
	</p>
	<style>
	.calendar_background {width:800px;height:500px;background-image:url('../../picuploads/advent BG.png');background-size:cover;border-radius:10px;margin:auto;position:relative;}
	
	.calendar_box {width:80px;height:60px;border:0px solid grey;border-radius:5px;position:absolute;font-size:30px;color:rgb(214, 46, 46);transition:0.3s;}

	/* add styles for each type of box, if you want */
	.calendar_opened {background-color:transparent;}
	.calendar_closed {background-color:rgba(55, 62, 30, 0.2);}
	.calendar_today {background-color:rgba(13,61,0,0.5);}
	.calendar_notyet {background-color:rgba(0,0,0,0.5);}
	
	/* add a nice glow when hovering over openable box */
	.calendar_today:hover,.calendar_closed:hover {cursor:pointer;-webkit-box-shadow:0px 0px 15px 10px rgba(255,240,107,1);-moz-box-shadow:0px 0px 15px 10px rgba(255,240,107,1);box-shadow: 0px 0px 15px 10px rgba(255,240,107,1);transition:0.3s;}
	
	/* every individual box needs to be positioned - could randomise it with php, but then they might srsly overlap... */
	#calendar_box1 {top:117px;left:258px;}
	#calendar_box2 {top:79px;left:587px;}
	#calendar_box3 {top:320px;left:703px;}
	#calendar_box4 {top:177px;left:170px;}
	#calendar_box5 {top:315px;left:194px;}
	#calendar_box6 {top:155px;left:473px;}
	#calendar_box7 {top:27px;left:325px;}
	#calendar_box8 {top:120px;left:22px;}
	#calendar_box9 {top:289px;left:538px;}
	#calendar_box10 {top:331px;left:397px;}
	#calendar_box11 {top:186px;left:670px;}
	#calendar_box12 {top:422px;left:42px;}
	#calendar_box13 {top:25px;left:491px;}
	#calendar_box14 {top:342px;left:79px;}
	#calendar_box15 {top:392px;left:673px;}
	#calendar_box16 {top:111px;left:695px;}
	#calendar_box17 {top:160px;left:360px;}
	#calendar_box18 {top:249px;left:124px;}
	#calendar_box19 {top:30px;left:118px;}
	#calendar_box20 {top:203px;left:570px;}
	#calendar_box21 {top:416px;left:361px;}
	#calendar_box22 {top:357px;left:530px;}
	#calendar_box23 {top:265px;left:27px;}
	#calendar_box24 {top:91px;left:443px;}
	#calendar_box25 {top:288px;left:284px;}
	#calendar_box26 {top:403px;left:266px;}
	#calendar_box27 {top:13px;left:630px;}
	#calendar_box28 {top:109px;left:140px;}
	#calendar_box29 {top:240px;left:448px;}
	#calendar_box30 {top:214px;left:269px;}
	#calendar_box31 {top:54px;left:257px;}
	
	/* popup box with gift info */
	#calendar_open_result {width:600px;min-height:300px;padding:10px;background-color:white;border:1px solid grey;border-radius:10px;position:fixed;top:50%;left:50%;margin-top:-150px;margin-left:-300px;}
	</style>
	
	<div class='calendar_background'>{$boxes}</div>
	<br></br>
	<center><p>Chosen box: <b><span id='calendar_chosenbox'>?</span></b> <select id='calendar_grifflist'>{$mypets}</select> 
	<button class='button_general' id='calendar_choose_griff'>It's your turn!</button></p></center>
	<span id='calendar_open_error'></span>
	
	<div id='calendar_open_result' style='display:none;'>
	  <b>Opening Box</b> <span id='calendar_open_close'>[close]</span>
	  <p><div id='calendar_open_inner'>Gift info should appear here!</div></p>
	</div>
	
	
	<script>var box = 0; // need global var to update
	$(function(){
	
	// select a box. Nothing happens if you click on one already open, or too early to open
	$('.calendar_closed,.calendar_today').click(function(){ 
	  box = $(this).data('box'); $('#calendar_chosenbox').html(box);
	});
	
	// opening box
	$('#calendar_choose_griff').click(function(){
	  var aid = $('#calendar_grifflist').val();
	  $.ajax({ type: 'POST', dataType: 'json', url: '../../ajax/calendar.php', data: { whatdo : 'open', target : box,  uid : {$uid}, aid : aid, username : '{$username}' },
	  success: function(result){
	    if(result.success == 'yes'){
	      $('#calendar_open_inner').html(result.text); $('#calendar_open_result').fadeIn(400);
	      // must update that box div so it's now opened and can't be clicked again
	      $('#calendar_box'+box).removeClass('calendar_closed').removeClass('calendar_today').addClass('calendar_opened'); 
	    }
	    else{ $('#calendar_open_error').html(result.text); }
	  }
	}); return false;});
	
	// close the opening box div
	$('#calendar_open_close').click(function(){ 
	  $('#calendar_open_result').fadeOut(400); $('#calendar_open_inner').html(''); 
	});
	
	});</script>
	
	",FALSE));
	}
}
?>