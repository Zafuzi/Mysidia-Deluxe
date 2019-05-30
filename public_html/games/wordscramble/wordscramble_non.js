$(function() {
    checkPlays();
});

var plays = 20;
var score = 0;

var words = ["caterpillar", "butterfly", "flower"];
var word = words[Math.floor(Math.random() * words.length)];
String.prototype.shuffle = function() {
    var a = this.split(""),
    n = a.length;
    for (var i = n - 1; i > 0; i--) {
        var j = Math.floor(Math.random() * (i + 1));
        var tmp = a[i];
        a[i] = a[j];
        a[j] = tmp;
    }
    return a.join("");
}
var scrambledWord = word.shuffle();

$('#scrambledword').html(scrambledWord);

$('.guess').click(function(){
  if (plays >= 0){
      var userword = document.getElementById('useranswer').value;
      if (userword == word){
        resultIs('Correct');
        sendScore(25);
      } 
      else {
        resultIs('Incorrect');
        sendScore(0);
      }
  }
});

function resultIs(result, second){
    $('.result').html(result);
    $('.result').fadeIn(1000, function(){
        $('#useranswer').val('');
        $('#scrambledword').fadeOut(500);
        words = ["caterpillar", "butterfly", "flower"];
        word = words[Math.floor(Math.random() * words.length)];
        String.prototype.shuffle = function() {
            var a = this.split(""),
            n = a.length;
            for (var i = n - 1; i > 0; i--) {
                var j = Math.floor(Math.random() * (i + 1));
                var tmp = a[i];
                a[i] = a[j];
                a[j] = tmp;
            }
            return a.join("");
        }
        scrambledWord = word.shuffle();
        plays = plays - 1;
        $('#scrambledword').html(scrambledWord);
        $('#scrambledword').fadeIn(500);    
        $('.plays').html(plays);
        if (result == 'Correct'){
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
  });
}

function disableGame(){
  $('.plays').html("0");
  $('.guess').off('click');
  $('.guess').css( 'cursor', 'not-allowed' );
  $('#useranswer').css( 'cursor', 'not-allowed' );
  $('.arrow-box').fadeTo('slow', 0.3);
  $('#scrambledword').html('Game Over');
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