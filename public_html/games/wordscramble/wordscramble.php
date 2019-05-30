<!doctype html>
<html lang='en'>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<body style="height: 100%; width: 700px; overflow-x:hidden; background: none;">
<base target="_parent" />
<link rel='stylesheet' href='../../games/wordscramble/wordscramble.css' type='text/css'>

<div class='wordscramble'>  
  <div id='scrambledword'>?</div>   
  <div id='userword'>
      Word:
      <input type='text' id='useranswer' value=''>
      <span class='guess'>Submit</span>
  </div>
  <br>
  <div class='finalscore'>
    <b>Plays Left Today</b>: <span class='plays'>20</span> of 20
    <br>
    <b>Score</b>: <span class='score'>0</span>
    <br>
    <span class='result'></span>
  </div>
  <span id='username' class='hidden'><?php echo $_GET["username"]; ?></span>  
</div>

<script src='../../games/wordscramble/wordscramble.js'></script>