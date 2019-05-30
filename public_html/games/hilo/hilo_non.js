$(function() {
    checkPlays();
});

var plays = 20;
var score = 0;
var first = 1 + Math.floor(Math.random()*16);

$('.first').html(first);

$('.guess').click(function(){
  if (plays >= 0){
    var second = 1 + Math.floor(Math.random()*16);
    $('.second').html(second);
    if ($(this).hasClass('higher')){
      if (first <= second){
        resultIs('correct', second);
        sendScore(25);
      } else {
        resultIs('incorrect', second);
        sendScore(0);
      }
    }
    if ($(this).hasClass('lower')){
      if (first >= second){
        resultIs('correct', second);
        sendScore(25);
      } else {
        resultIs('incorrect', second);
        sendScore(0);
      }
    }
  }
});

function resultIs(result, second){
  $('.result').html(result);
  $('.result').fadeIn(1000, function(){
    $('.first').fadeOut(500);
      $('.second').fadeOut(500, function(){    
      $('.first').html(second);
      first = second;
      plays = plays - 1;
      $('.first').fadeIn(500);
      $('.second').html('?');
      $('.second').fadeIn(500);      
      $('.plays').html(plays);
      if (result == 'correct'){
        score = score + 25;
        current = parseFloat(window.parent.$('.money').text());
        window.parent.$('.money').fadeTo(100, 0.1);
        window.parent.$('.money').text((current + score));
        window.parent.$('.money').fadeTo(100, 1);
      }
      $('.score').html(score);
      if (plays <= 0){
        disableGame();
      }
    });
  }); 
  $('.result').fadeOut(500);
}

function sendScore(amt) {
  var values = {
    'username': $("#username").text(),
    'amt': amt
  };
  $.ajax({
    url: "sendscore.php",
    type: "POST",
    data: values,
  }).done(function(status){
    if (status == "GameOver"){
      disableGame();
    } else {
      $('.plays').html(status);
      plays = status;
    }
  });
}

function disableGame(){
  $('.plays').html("0");
  $('.guess').off('click');
  $('.guess').css( 'cursor', 'not-allowed' );
  $('.arrow-box').fadeTo('slow', 0.3);
  $('.first').html('game');
  $('.second').html('over');
  $('.finalscore').html("<b>Plays Left Today:</b> 0 of 20<h2>See You Tomorrow!</h2>");
}

function checkPlays(){
  var values = {
    'username': $("#username").text(),
    'plays': 'check'
  };
  $.ajax({
    url: "sendscore.php",
    type: "POST",
    data: values,
  }).done(function(status){
    if (status == "GameOver"){
      disableGame();
    } else {
      $('.plays').html(status);
      plays = status;
    }
  });
}