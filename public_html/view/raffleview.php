<?php
class RaffleView extends View{
	
	public function index(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Raffle"); // browser title
	$uid = $mysidia->user->uid; $mods = array(1,94);
	$username = $mysidia->user->username;
	
	// count how many tickets have been bought already, for the 2 raffle types.
	$tickets1 = $mysidia->db->select("raffle", array("id"), "uid = {$uid} AND raffle = 1")->rowCount();
	$tickets2 = $mysidia->db->select("raffle", array("id"), "uid = {$uid} AND raffle = 2")->rowCount();
	$max1 = 100 - $tickets1; $max2 = 100 - $tickets2;
	
	// look up previous winners from records table
	$winners1 = $mysidia->db->select("records", array("winners","details"), "name = 'raffle1'")->fetchObject();
	$uid1 = $winners1->winners; $prize1 = $winners1->details; // one winner and money prize
	$name1 = $mysidia->db->select("users", array("username"), "uid = '{$uid1}'")->fetchColumn();
	
	$winners2 = $mysidia->db->select("records", array("winners","details"), "name = 'raffle2'")->fetchObject();
	$array1 = explode(',',$winners2->winners); $array2 = explode(',',$winners2->details); // several uids and prize ids
	$winnerinfo = '';
	$winnercount = count($array1); // in case fewer than 10, count how many winners there were
	$num = 1; while($num < $winnercount){
	  $winnerid = $array1[$num - 1]; $prize = $array2[$num - 1]; // get the uid and item id in correct positions in arrays
	  $name = $mysidia->db->select("users", array("screenname"), "uid = {$winnerid}")->fetchColumn();
	  $itemname = $mysidia->db->select("items", array("itemname"), "id = {$prize}")->fetchColumn();
	  $winnerinfo .= "<b>{$name}</b> won {$itemname}! ";
	  $num++;
	}
	
	// if mod/admin is visiting page, show some stats and buttons to manually end raffles
	if(in_array($uid,$mods)){
	  $total1 = $mysidia->db->select("raffle", array("id"), "raffle = 1")->rowCount();
	  $total2 = $mysidia->db->select("raffle", array("id"), "raffle = 2")->rowCount();
	  $extra = "<br><br>So far, <b>{$total1}</b> tickets have been bought for raffle 1, and <b>{$total2}</b> for raffle2.
	  <br>Want to reset?
	  <br><br><button class='raffle_end' data-raffle='1'>End raffle 1</button><br><span class='raffle_end_1'></span>
	  <br><br><button class='raffle_end' data-raffle='2'>End raffle 2</button><br><span class='raffle_end_2'></span>";
	}else{$extra = '';}
	
	$document->add(new Comment("<center><p>
	<img src='http://atrocity.mysidiahost.com/picuploads/png/4258b4fbad97944d958ae8aaec453d24.png'><p>
	<b> Gabby says:</b> You have to buy tickets if you want to win.....
	<p>
	<a href='http://atrocity.mysidiahost.com/shop/browse/Gabbys Gambles'>Buy scratchoffs</a> ~ <a href='http://atrocity.mysidiahost.com/pages/view/Scratchoffs'> Turn in scratchoffs</a>
	<p> Winners are drawn at the end of the week.<br>
	Last week's winners: <b>{$name1}</b> won {$prize1} tokens! {$winnerinfo}</p>
	
	<div class='light round10 pad10'>
	<b>Raffle 1: Money</b>
	<br>One winner will receive all the money, like a lottery. Tickets cost 50 tokens.
	<br>Tickets bought: <span class='raffle_tickets_1'>{$tickets1}</span>
	<br>How many? <input type='number' class='raffle_input_1' value='1' min='1' max='{$max1}'> 
	<button class='raffle_buy' data-raffle='1'>Purchase</button>
	<br><span class='raffle_bought_1'></span>
	</div>
	<br><br>
	<div class='light round10 pad10'>
	<b>Raffle 2: Goodies</b>
	<br>Up to 10 winners will receive rare-ish items. Tickets cost 100 tokens.
	<br>Tickets bought: <span class='raffle_tickets_2'>{$tickets2}</span>
	<br>How many? <input type='number' class='raffle_input_2' value='1' min='1' max='{$max2}'> 
	<button class='raffle_buy' data-raffle='2'>Purchase</button>
	<br><span class='raffle_bought_2'></span></center>
	</div>
	
	{$extra}
	
	<script>$(function(){
	
	$('.raffle_buy').click(function(){
	var raffle = $(this).data('raffle'); var qty = parseInt($('.raffle_input_'+raffle).val());
	
	// optional, could count current tickets later. 
	// make sure to use parseInt so vars are numbers, or JS may think 15 + 6 is 156... 
	var current = parseInt($('.raffle_tickets_'+raffle).html());
	
	// also optional
	if(current + qty > 100){ $('.raffle_bought_'+raffle).html('Sorry, you can buy a maximum of 100 tickets per draw.'); return; }
	
	$.ajax({ type: 'POST', dataType: 'json', url: 'http://atrocity.mysidiahost.com/ajax/raffle.php', data: { whatdo : 'buy', qty : qty, raffle : raffle, current : current, uid : {$uid}, username : '{$username}' },
	success: function(result){
	  $('.raffle_bought_'+raffle).html(result.text); 
	  if(result.success == 'money'){ $('.raffle_tickets_'+raffle).html(result.qty); }
	  if(result.success == 'yes'){ $('.raffle_tickets_'+raffle).html(result.qty); } // and update user's money bar, forgot the name
	}
	}); return false; });
	
	// extra buttons for ending, if want
	$('.raffle_end').click(function(){
	var raffle = $(this).data('raffle');
	$.ajax({ type: 'POST', url: 'http://atrocity.mysidiahost.com/ajax/raffle.php', data: { whatdo : 'end', raffle : raffle, uid : {$uid}, username : '{$username}' },
	success: function(result){ $('.raffle_end_'+raffle).html(result); }
	}); return false; });
	
	});</script>",FALSE));
	
	}
	
}
?>