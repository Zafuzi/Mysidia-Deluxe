<?php
class winbigwheelView extends View{
	
	public function index(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Scion's win big or lose big wheel");
	$uid = $mysidia->user->uid;
	// count the number of plays for each game, for user convenience
	$spins = $mysidia->db->select("users_profile", array("wbwheel"), "uid = {$uid}")->fetchColumn();
	if(!$spins){$spins = 0;}
	$spinsleft = 3 - $spins; if($spinsleft < 1){$spinsleft = 0;} $spinmsg = "You have <b>{$spinsleft}</b> spins left today.";
	// haven't moved Kyttias' hilo game here yet
	
	$document->add(new Comment("<h2>Games</h2><p>.</p>
	<a href='../../games/wbwheel'><button class='button_general'>Wheel</button></a><br>{$spinmsg}<br> ",FALSE));
	}
	
	public function wbwheel(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Spin the Wheel!");
	$uid = $mysidia->user->uid;
	
	// count spins already
	$spins = $mysidia->db->select("users_profile", array("wbwheel"), "uid = {$uid}")->fetchColumn();
	if(!$spins){$spins = 0; $purchase = 'none';}else{$purchase = 'block'; // whether to show buy button at first
	  if($spins > 2){$canspin = 'display:none;';}else{$canspin = '';} // whether to show spinner or not
	}
	
	$document->add(new Comment("<h1>Spin the Wheel</h1>
	<p> You get 3 free spins daily, and can buy 3 more if you have Scions casino coin.</p>
	
	<div class='winbigwheel_wheel_buyoption' style='display:{$purchase};'>
	  You can buy 3 more spins for one Scions casino coin<button class='winbigwheel_wheel_buybtn'>Purchase!</button>
	  <br><span class='winbigwheel_wheel_buyresult'></span>
	</div>
	
	<div class='winbigwheel_wheel_container'>
	  <div class='winbigwheel_wheel'></div>
	  <button class='winbigwheel_wheel_spinner' style='{$canspin}'><span>Spin!</span><div class='pointer'></div></button>
	</div>
	<p><div class='winbigwheel_wheel_prize'>Go on, give it a whirl!</div>
	<br><div class='winbigwheel_wheel_result'></div><br>
	<div class='winbigwheel_wheel_spun'>Spins: {$spins}</div></p>
	
	<style>
	/* the box that holds the wheel. It's fixed in the middle no matter the size of box */
	.winbigwheel_wheel_container {position:relative;width:880px;min-height:530px;margin:10px auto;border-radius:10px;padding:10px;text-align:center;}
	/* note, my lines are a bit wonky, you need to make each segment exactly equal, however many there are */
	.winbigwheel_wheel {position:absolute;top:50%;left:50%;margin-top:-250px;margin-left:-250px;width:500px;height:500px; background-color:red;background-image: url('http://atrocity.mysidiahost.com/picuploads/png/04a100fd8cd9a4694ec3fa448b3779a9.png'); background-repeat:no-repeat;border-radius:100%;}
	/* positioned in middle of wheel. Could use an image instead of this shape */
	.winbigwheel_wheel_spinner {cursor: pointer;color:white;font-weight:bold;border:none;position:absolute;width:50px;height:50px;top:240px;left:415px;border-radius:100%;z-index:60;background-color:blue;}
	/* the arrow at top of spinner, again could be included in image */
	.winbigwheel_wheel_spinner .pointer {position:absolute;width:0;height:0;top:-8px;left:15px;border-left:10px solid transparent;border-right:10px  solid transparent;border-bottom:10px solid blue;}
	</style>
	
	<script>
	// the names or numbers of each segment. You might need to spin your wheel to see what goes where, to match image
	var segments = [{name:'red'},{name:'orange'},{name:'yellow'},{name:'green'},{name:'teal'},{name:'dkblue'},{name:'purple'},{name: 'fuschia'}, {name: 'pink'}];
	// number of times user has spun today
	var spun = {$spins};
	$(function(){
	 
	var r = $('.winbigwheel_wheel').fortune(segments);
	
	var spinWheel = function(){
	  $('.winbigwheel_wheel_spinner').off('click');
	  $('.winbigwheel_wheel_spinner span').fadeOut(300);
	  r.spin().done(function(segment){
	    // now we have a result generated. Clear the text about buying item, for neatness
	    $('.winbigwheel_wheel_buyresult').html('');
	    $('.winbigwheel_wheel_prize').html('You landed on... <b>'+segment.name+'</b>!');
	    // do AJAX
	    checkResult(segment.name);
	    // update on page
	    spun = spun + 1; $('.winbigwheel_wheel_spun').html('Spins: '+spun);
	    $('.winbigwheel_wheel_spinner').on('click', spinWheel);
	    // see if user has hit limit
	    if(spun > 2){
	      $('.winbigwheel_wheel_spinner').fadeOut(400); // hide spinner to prevent more clicks
	      $('.winbigwheel_wheel_spun').append('<br>All done! Come back tomorrow for more spins!'); // and tell user
	       $('.winbigwheel_wheel_buyoption').fadeIn(300); // and show the option to buy
	    }else{
	      $('.winbigwheel_wheel_spinner span').fadeIn(300); // after spin done, show 'Spin!' again
	    }
	  });
	};

	$('.winbigwheel_wheel_spinner').on('click', spinWheel);
	
	// could have this inside the spin function, or separately here
	function checkResult(segment){
	$.ajax({ type: 'POST', url: '../../ajax/winbigwheel.php', data: { uid : {$uid}, whatdo : 'wheel', target : segment },
	success: function(result){ $('.winbigwheel_wheel_result').html(result); }
	}); return false; }
	
	// buying more spins. This option only appears if users have spun already.
	// it actually reduces the already-spun number, rather than increasing max
	$('.winbigwheel_wheel_buybtn').click(function(){
	$.ajax({ type: 'POST', dataType: 'json', url: '../../ajax/winbigwheel.php', data: { uid : {$uid}, whatdo : 'buywheel' },
	success: function(result){ $('.winbigwheel_wheel_buyresult').html(result.text);
	  if(result.success == 'yes'){ 
	    $('.winbigwheel_wheel_spun').html('Spins: 0'); spun = 0;
	    $('.winbigwheel_wheel_spinner,.games_wheel_spinner span').fadeIn(400);
	    $('.winbigwheel_wheel_result').html('');
	  }
	}
	}); return false;});
	
	});</script>",FALSE));
	}
	
}
?>
