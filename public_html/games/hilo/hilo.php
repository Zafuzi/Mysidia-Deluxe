<!doctype html>
<html lang='en'>
<link rel='stylesheet' href='../../templates/bitbit/style-bitbit.css' type='text/css'>
<script src='//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
<body style="height: 100%; width: 700px; overflow-x:hidden; background: none;">
<base target="_parent" />
<link rel='stylesheet' href='../../games/hilo/hilo.css' type='text/css'>

<div class='hi_lo'>  
  <div class='card first'>?</div>  
  <div class='arrow-box'>
    <div class='guess higher'></div>
    or
    <div class='guess lower'></div>
  </div>  
  <div class='card second'>?</div>
  <br><br>
  <div class='finalscore'>
    <b>Plays Left Today</b>: <span class='plays'>20</span> of 20
    <br>
    <b>Score</b>: <span class='score'>0</span>
    <br>
    <span class='result'></span>
  </div>
  <span id='username' class='hidden'><?php echo $_GET["username"]; ?></span>  
</div>

<script src='../../games/hilo/hilo.js'></script>