<?php
class ArcadeView extends View{
	
	public function index(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle('Welcome to the Atrocity Bear Arcade!!');
		$document->add(new Comment("
		    <style>
		        .game-li{
                    display: inline-block;
                    background: none !important;
                    border: none !important;
                }
                .game-img{
                    width:150px;
                    height:70px;
                }
                .games {
                    grid-area: main;
                    overflow:auto;
                    width:650px;
                    }
                .description {
                    grid-area: right;
                    width:250px;
                }
                .game-container {
                    display: grid;
                    grid-template-areas: 'main main main main right right';
                    grid-template-columns: repeat(auto-fill, minmax(600px, 600px));
                    grid-gap: 5px;
                    background-color: black;
                    padding: 5px;
                    width:99%;
                    height:500px;
                }
                .game-container>div {
                    background-color: #848484;
                    text-align: center;
                    padding: 10px;
                    height:480px;
                }
		    </style>
		"));
		$gamecount = $mysidia->db->select("arcade", array("id"))->rowCount();
		if($gamecount == 0 || $gamecount == NULL){
		    $document->add(new Comment("That's weird...There are no games!")); //not sure why this would happen, but just in case
		    return;
		}
		else{
		    $arcade = $mysidia->db->select("arcade", array(), "available='yes'"); //fetch ALL the games!...that are open at least
		    $arcade2 = $mysidia->db->select("arcade", array(), "available='yes'"); //No idea why I need this, but apparently I do
		    $document->add(new Comment("<div id='tabs'>
                <div class='game-container'>
                    <div class='games'>
                        <h2>Games List</h2>
                        <ul style='background:none; border:none; padding-left:40px;'>", FALSE));
		    while($game = $arcade->fetchObject()){
		        $document->add(new Comment("<li class='game-li'><a href='#{$game->id}'><img class='game-img' src='{$game->img}'></a></li>", FALSE));
		    }
		    $document->add(new Comment("</ul></div><div class='description'>", FALSE));
		    while($game_info = $arcade2->fetchObject()){
		        $document->add(new Comment("<div id='{$game_info->id}'>
                        <p>
                            <h3>{$game_info->name}</h3>
                            {$game_info->description}
                            <br></br>
                            <a href='{$game_info->link}'><img src='http://atrocity.mysidiahost.com/picuploads/PlayButton.png'></a>
                        </p>
                    </div>", FALSE));
		    }
            $document->add(new Comment("</div></div>", FALSE));
		}
	}
	
	public function jigsaw(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Jigsaw - Griffusion");
	$uid = $mysidia->user->uid;
	// count the number of plays today
	$plays = $mysidia->db->select("users_activity", array("jigsaw"), "uid = {$uid}")->fetchColumn();
	
	$document->add(new Comment("<h2>Jigsaw</h2><p>Create the image by dragging pieces into the correct positions. The harder the puzzle, the better prize you might win! You can play as many times as you like, but only claim 3 prizes per day.</p>
	<style>
	.snappuzzle-wrap {position:relative;display:block;}
	.snappuzzle-pile {position:relative;}
	.snappuzzle-piece {cursor:move;}
	.snappuzzle-slot {position:absolute;background:#fff;opacity:0.8;}
	.snappuzzle-slot-hover {background:#eee;}
	.choose:hover {cursor:pointer;border:1px solid red;border-radius:5px;}
	.chosen {border:2px solid red;border-radius:5px;}
	</style>
	
	<div class='games_jigsaw_container' style='border:1px solid grey;background:#fafafa;margin:30px 0;padding:10px;text-align:center'>
	<img class='games_jigsaw_source' src='http://griffusion.elementfx.com/pics/bgs/nest1.jpg'>
	<div class='games_jigsaw_pile' style='border:1px dotted red;margin:10px'></div>
	</div>
	<div class='games_jigsaw_solved' style='z-index:60;border:2px solid grey;border-radius:10px;background-color:white;padding:10px;min-height:200px;width:600px;display:none;text-align:center;position:fixed;top:50%;left:50%;margin-top:-200px;margin-left:-300px;'>
	<h2>Well done!</h2>
	<button class='games_jigsaw_claim'>Claim a prize</button><br><span class='games_jigsaw_result'></span><br>
	<img class='games_jigsaw_choose' data-pic='1' src='http://griffusion.elementfx.com/pics/bgs/nest1.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='2' src='http://griffusion.elementfx.com/pics/bgs/nest2.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='3' src='http://griffusion.elementfx.com/pics/bgs/nest3.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='4' src='http://griffusion.elementfx.com/pics/bgs/nest4.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='5' src='http://griffusion.elementfx.com/pics/bgs/nest5.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='6' src='http://griffusion.elementfx.com/pics/bgs/nest6.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='7' src='http://griffusion.elementfx.com/pics/bgs/nest7.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='8' src='http://griffusion.elementfx.com/pics/bgs/nest8.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='9' src='http://griffusion.elementfx.com/pics/bgs/nest9.jpg' style='height:50px;width:auto;'>
	<img class='games_jigsaw_choose' data-pic='10' src='http://griffusion.elementfx.com/pics/bgs/nest10.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='11' src='http://griffusion.elementfx.com/pics/bgs/nest11.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='12' src='http://griffusion.elementfx.com/pics/bgs/nest12.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='13' src='http://griffusion.elementfx.com/pics/bgs/nest13.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='14' src='http://griffusion.elementfx.com/pics/bgs/nest14.jpg' style='height:50px;width:auto;'> 
	<img class='games_jigsaw_choose' data-pic='15' src='http://griffusion.elementfx.com/pics/bgs/nest15.jpg' style='height:50px;width:auto;'>
	<br><button class='games_jigsaw_restart' data-grid='3'>Easy (3 x 3)</button>
	<button class='games_jigsaw_restart' data-grid='5'>Hmm (5 x 5)</button>
	<button class='games_jigsaw_restart' data-grid='7'>You sure? (7 x 7)</button>
	</div>
	<script src='https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js'></script>
	<script src='https://goodies.pixabay.com/jquery/snap-puzzle/jquery.snap-puzzle.js'></script>
	
	<script>$(function(){ var image = 1; var difficulty = 3; var claimed = {$plays};
	
	$('.games_jigsaw_claim').click(function(){
	if(claimed > 2){ $('.games_jigsaw_result').html('You have already claimed 3 prizes today. You can carry on completing puzzles just for fun, though!'); $('.games_jigsaw_claim').fadeOut(); return; }
	$.ajax({ type: 'POST', dataType: 'json', url: '../../ajax/minigames.php', data: { uid : {$uid}, whatdo : 'jigsaw', target : difficulty },
	success: function(result){ $('.games_jigsaw_result').html(result.text); $('.games_jigsaw_claim').fadeOut();
	  if(result.success == 'yes'){claimed = result.plays; }
	  if(result.success == 'done'){claimed = 3;}
	}
	}); return false; });
	
	$('.games_jigsaw_choose').click(function(){ 
	  $('.games_jigsaw_choose').removeClass('chosen'); image = $(this).data('pic'); $(this).addClass('chosen');
	});
	
	function updateImage(){ $('.games_jigsaw_source').attr('src','http://griffusion.elementfx.com/pics/bgs/nest'+image+'.jpg'); }
	
	function start_puzzle(x){ $('.games_jigsaw_solved').fadeOut(300); difficulty = x;
	$('.games_jigsaw_source').snapPuzzle({ rows: x, columns: x, pile: '.games_jigsaw_pile', containment: '.games_jigsaw_container',
	  onComplete: function(){ 
	  $('.games_jigsaw_source').fadeOut(300).fadeIn(300);  $('.games_jigsaw_solved').fadeIn(300);
	  if(claimed < 3){ $('.games_jigsaw_claim').show(); }else{ $('.games_jigsaw_claim').hide(); }
	  }
	});
	}
	
	$('.games_jigsaw_pile').height($('.games_jigsaw_source').height()); start_puzzle(3);
	
	$('.games_jigsaw_restart').click(function(){ $('.games_jigsaw_result').html('');
	  $('.games_jigsaw_source').snapPuzzle('destroy'); updateImage(); start_puzzle($(this).data('grid'));
	});

	$(window).resize(function(){ 
	  $('.games_jigsaw_pile').height($('.games_jigsaw_source').height()); $('.games_jigsaw_source').snapPuzzle('refresh');
	});
	
	});</script>
	<p><a href='../../arcade'>Back to Games</a></p>",FALSE));
	}
	
	public function memory(){
	$mysidia = Registry::get("mysidia");
	$document = $this->document;
	$document->setTitle("Memory - Griffusion");
	$uid = $mysidia->user->uid;
	// count the number of plays today
	$plays = $mysidia->db->select("users_activity", array("memory"), "uid = {$uid}")->fetchColumn();
	
	$document->add(new Comment("<h2>Memory</h2><p>Click on a card to flip it over and see what the image is. Select two matching cards to remove them from the board. The fewer turns you take, the better the prize you might win! You can claim up to 3 prizes per day.</p>
	<style>
	.match_cards {width:100%;display:flex;flex-flow:row wrap;justify-content:center;}
	.match_cards div{width:150px;height:100px;margin:5px;border:2px solid grey;border-radius:5px;box-shadow: 0 2px 5px rgba(0,0,0,0.5);background-image: url('https://image.shutterstock.com/mosaic_250/1427210/556229497/stock-photo-old-paper-texture-556229497.jpg');z-index:2;}
	.match_cards div:hover {cursor:pointer;opacity:0.8;}
	.match_cards div img {display:none;width:100%;height:100%;}
	</style>
	
	Cards flipped: <span class='match_counter'>0</span> &nbsp &nbsp &nbsp &nbsp <button class='match_restart'>Restart</button>
	<br><div class='games_match_finished' style='display:none;'>You found all the pairs! 
	<button class='games_match_claim'>Claim a prize</button><br><span class='games_match_result'></span></div><br>
	<div class='match_cards'></div>
	
	<script>$(function(){
	
	var BoxOpened = ''; var ImgOpened = ''; var clicks = 0; var ImgFound = 0; var claimed = {$plays};
	
	$('.games_match_claim').click(function(){
	if(claimed > 2){ $('.games_match_result').html('You have already claimed 3 prizes today. You can carry on playing just for fun, though!'); $('.games_match_claim').fadeOut(); return; }
	$.ajax({ type: 'POST', dataType: 'json', url: 'http://atrocity.mysidiahost.com/ajax/minigames.php', data: { uid : {$uid}, whatdo : 'memory' },
	success: function(result){ $('.games_match_result').html(result.text); 
	  if(result.success == 'yes'){claimed = result.plays; $('.games_match_claim').fadeOut(); } 
	}
	}); return false; });
	
	var ImgSource = [
	'http://www.chalani.net/webphotos/jivesouthern.jpg',
	'http://www.chalani.net/dbphotos/tussock_tanya.jpg',
	'https://i.pinimg.com/236x/73/ff/cd/73ffcddfa42998882dbb4f41a7e0f8b7--horse-pictures-horse-breeds.jpg',
	'https://image.shutterstock.com/image-photo/british-shorthair-cat-isolated-on-260nw-684452320.jpg',
	'https://image.shutterstock.com/image-photo/cat-cute-little-ginger-kitten-260nw-1297577623.jpg',
	'https://image.shutterstock.com/image-photo/ortrait-longhair-persian-cat-260nw-520694341.jpg',
	'https://comps.canstockphoto.com/cat-persian-extreme-pictures_csp33885780.jpg',
	'https://us.123rf.com/450wm/neelsky/neelsky1109/neelsky110900122/10505533-portrait-of-a-royal-bengal-tiger-alert-and-staring-at-the-camera.jpg',
	'https://comps.canstockphoto.com/african-lion-picture_csp3469761.jpg',
	'https://st.depositphotos.com/1325441/1966/i/450/depositphotos_19661835-stock-photo-lion-king-of-the-wild.jpg'
	];
	
	$('.match_restart').click(function(){ restart(); });

	function RandomFunction(max,min){ return Math.round(Math.random() * (max - min) + min); }
	
	function ShuffleImages(){
	  var ImgAll = $('.match_cards').children();
	  var ImgThis = $('.match_cards'+' div:first-child');
	  var ImgArr = [];
	  for(var i = 0; i < ImgAll.length; i++){
		ImgArr[i] = $('#'+ImgThis.attr('id')+' img').attr('src');
		ImgThis = ImgThis.next();
	  }
	  ImgThis = $('.match_cards'+' div:first-child');
	  for(var z = 0; z < ImgAll.length; z++){
		var RandomNumber = RandomFunction(0, ImgArr.length - 1);
		$('#'+ImgThis.attr('id')+' img').attr('src', ImgArr[RandomNumber]);
		ImgArr.splice(RandomNumber, 1);
		ImgThis = ImgThis.next();
	  }
	}

	function restart(){ ShuffleImages();
	  $('.match_cards'+' div img').hide(); $('.match_cards'+' div').css('visibility', 'visible');
	  clicks = 0; BoxOpened = ''; ImgOpened = ''; ImgFound = 0; $('.match_counter').html(clicks);
	  $('.games_match_finished').fadeOut(300);
	}
	
	function OpenCard(){
	  var id = $(this).attr('id');
	  if($('#'+id+' img').is(':hidden')){
		$('.match_cards'+' div').unbind('click', OpenCard);
		$('#'+id+' img').fadeIn(300);
		if(ImgOpened == ''){
		  BoxOpened = id; ImgOpened = $('#'+id+' img').attr('src');
		  setTimeout(function(){ $('.match_cards'+' div').bind('click', OpenCard) }, 300);
		}else{
		  CurrentOpened = $('#'+id+' img').attr('src');
		  if(ImgOpened != CurrentOpened){
			setTimeout(function(){
			  $('#'+id+' img').fadeOut(300); $('#'+BoxOpened+' img').fadeOut(300);
			  BoxOpened = ''; ImgOpened = ''; }, 400);
		  }else{
			$('#'+id+' img').parent().css('visibility', 'hidden');
			$('#'+BoxOpened+' img').parent().css('visibility', 'hidden');
			ImgFound++; BoxOpened = ''; ImgOpened = '';
		  }
		  setTimeout(function(){ $('.match_cards'+' div').bind('click', OpenCard) }, 400);
		}
		clicks++; $('.match_counter').html(clicks);

		if(ImgFound == ImgSource.length){ $('.games_match_finished').fadeIn(300); $('.games_match_result').html('');
		  if(claimed < 3){ $('.games_match_claim').show(); }
		}
	  }
	}

	for(var y = 1; y < 3; y++){
	  $.each(ImgSource, function(i, val){ $('.match_cards').append(\"<div id='card\"+y+i+\"'><img src='\"+val+\"'>\"); });
	}
	$('.match_cards'+' div').click(OpenCard);
	ShuffleImages();

	});</script>
	<p><a href='../../arcade'>Back to Games</a></p>",FALSE));
	}
}