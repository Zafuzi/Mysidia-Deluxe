<?php
class coinflipView extends View{

public function index(){
$mysidia = Registry::get("mysidia");
$document = $this->document;   
$document->setTitle('<center>Coinflip with Trent</center>');
$document->add(new Comment("<center><a href='http://atrocity.mysidiahost.com/arcade'>~Go back to the Arcade</a>"));
$document->add(new Comment ("
        Tries: <span class='coinflip_tries'>10</span><br>
        Your money: <b><span class='coinflip_money'>{$mysidia->user->money}</span></b><br>
        How much will you bet? <input class='coinflip_bet' type='number' min='1' value='50'>

        <p><button class='coinflip_btn'>Flip!</button></p>
        <b>Result:</b> <span class='coinflip_result'></span>

        <p>
            <div id='trent'>
                 <img src='http://atrocity.mysidiahost.com/picuploads/png/53dd9eaf7a9ccc31b481b927a2cbcb4c.png'>
            </div> 
        </p>
    </center>

<script>$(document).ready(function(){
    // our global variables, which will be changed by the functions. On game, 'money' will be user's money, fetched from mysidia.
    var money = {$mysidia->user->money};
    var name = '{$mysidia->user->username}';
    var bet = 50; // default bet amount
    var tries = 10; // to count how many tries/plays

    // flipping the coin.
    function toss(){
      // generate a number between 0 and 1.
      var coin = Math.random();
      // check and update the bet value.
      bet = $('.coinflip_bet').val();
     
      // if out of turns, dont do anything
      if (tries <= 0){
        $('#trent').html('<img src=\"http://atrocity.mysidiahost.com/picuploads/png/ff5d04dd47ed12b42c22284d6810f93a.png\">');

        $('.coinflip_result').text('You are all out of turns!');
      }
      else{
                // if it was greater than 0.85, yay!
      if (coin > 0.85){
        // double the bet, add it to money.
        var winnings = bet * 2;
        money = money + winnings;
        // update the money span with new amount.
        $('.coinflip_money').text(money);
        // and show message in result span.
        $('#trent').html('<img src=\"http://atrocity.mysidiahost.com/picuploads/png/dcbc18a889a557c069b94053c94daae5.png\">');

        $('.coinflip_result').html('Heads! Congratulations '+name+', you won '+winnings+' Beads. Trent is annoyed at you now.');
        // notice how the JS variable is inserted in the message, between + + ?
        // finally update the tries variable.
        tries = tries - 1;
        $('.coinflip_tries').text(tries);
      }
     
      else if (coin <= 0.85){
        // take away the bet amount from money.
        money = money - bet;
        $('.coinflip_money').text(money);
        // and write losing message.
        $('#trent').html('<img src=\"http://atrocity.mysidiahost.com/picuploads/png/caafea02b35cfa99852063b84c564eaa.png\">');

        $('.coinflip_result').text('Tails! Oh no '+name+'. You lost '+bet+' Beads...');
        // and update flips.
        tries = tries - 1;
        $('.coinflip_tries').text(tries);
      }
     
      // always good to have a backup in case of errors.
      // nothing is updated here.  it's not fair to waste a try if user has limited daily tries.
      else{
        $('#trent').html('<img src=\"http://atrocity.mysidiahost.com/picuploads/png/ff5d04dd47ed12b42c22284d6810f93a.png\">');

        $('.coinflip_result').text('Something went wrong... '+coin+'');
      }
      }

    }

    // we call that function when the button is clicked.
    $('.coinflip_btn').on('click', function(){ toss();});
  
    // later on game, will add AJAX call after toss(), so the user's money and daily tries will be updated to match these variables.

});</script>
")); 

    }

        }

    ?>