<?php
// stuff for battle (duel) system
// this version gets the opponent's learned skills and adds them to array, so they respond to your moves only with the skills they know
// 'battletestview' contains the earlier version with an array of generic attacks

// check their skills
//$enemyskills = $mysidia->db->select("battleskills", array(), "aid='{$opid}'")->fetchObject();


$document->add(new Comment("<button onclick='history.go(-1);'>Return to last page</button><br><h2>{$opname} appears! {$gname} leaps to start the duel!</h2><br>

<script>
// here we set all the global variables, they'll keep being updated every round

ghp = {$health};
gtotal = ghp;
ehp = {$ophealth}
etotal = ehp;
mp = {$mana}
gmagic = {$magskill}
emagic = {$opmagic}
gsense = {$sense}
esense = {$opsense}
gstrength = {$strength}
estrength = {$opstrength}
gstamina = {$stamina}
estamina = {$opstamina}
gspeed = {$speed}
espeed = {$opspeed}
gdefend = 0;

gdodge = {$gdodge}
edodge = {$edodge}
gstatus = 'normal';
estatus = 'normal';
gmod = 1;
emod = 1;

$(function () {

// let's begin the action functions, now with comments! Enemy actions will be listed later.
// first, note the ID of the button (or div, image, other HTML element) and when you click, hover or whatever, start function
// in this case we only care for clicks

  $('#Bite').on('click', function () {
  
  // check if enemy still has some health. If they don't, the battle should have ended last round anyway, but these if's are needed, damnit
  
  if(ehp > 0){
  
  // generate a number and depending on range, either your attack misses and enemy gets a free shot, or your attack goes as normal
  
  var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < edodge) { $('<p>{$gname} tried to bite, but {$opname} dodged it!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > edodge) {
  
  // for some variation we generate another number up to 15, and add it to the otherwise-boring attack formula, based on stats
  
  var rand = Math.floor(Math.random() * 15) + 1;
  griffbite = {$bite} + rand;
  
  // update the enemy's HP, and any other stats you involved in this action
  
  ehp = ehp - griffbite;
  updateEnHealth(ehp);
  
  // now update the display on the page. Get the ID of each element - in this case 2 divs called enemyhealth, reports
  // first one has its HTML contents replaced, just a word and number
  // we want the reports box to keep messages from previous rounds though, so append the new contents instead of replacing
  
  // be careful with long sentences/paragraphs though, JS does not like multi-line stuff! I'll go over that issue later...
  // anyway we can include JS vars using +varname+ and mix them with PHP vars, HTML tags or whatever
  
    $('#enemyhealth').html('Health: <b>' +ehp+ '</b>');
    $('<p>{$gname} leaped forward and bit {$opname}, for ' +griffbite+ ' damage!</p>').fadeIn(500).appendTo('#reports');
    
    // we want the div to always focus on the latest round's message, so we automatically scroll down to the bottom
    
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    
    // the enemy's random action follows, IF your action didn't just defeat them:
    
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
    
    // all done? now they've acted, check if you still have HP and enemy doesn't. If so, call the function that displays winning message
    
    if (ehp <= 0 && ghp > 0){ youWon(); }
    }
    
    // here we check the other 2 conditions. If none of these if's are true, nothing happens and battle continues to next round
    
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
      if (ghp <= 0 && ehp > 0){ youLost(); }
  }
  });
  
  // done! now use similar structure for all other actions... take note of the MP checks and costs for magic spells

  
  $('#Tackle').on('click', function () {
  if(ehp > 0){
       var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < edodge) { $('<p>{$gname} tried to tackle, but {$opname} dodged it!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > edodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  var grifftackle = {$tackle} + rand;
  ehp = ehp - grifftackle;
  updateEnHealth(ehp);
  updateStats();
    $('<p>{$gname} launched a powerful tackle, dealing ' +grifftackle+ ' damage!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
     if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
     }
  });

  $('#Trick').on('click', function () {
  if(ehp > 0){
        var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < edodge) { $('<p>{$gname} tried to tackle, but {$opname} dodged it!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > edodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  var grifftrick = {$trick} + rand;
  ehp = ehp - grifftrick;
  updateEnHealth(ehp);
  updateStats();
    $('<p>{$gname} tricked {$opname} into hitting a wall, causing ' +grifftrick+ ' damage!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
     if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
    }
  });
  
  $('#Fly').on('click', function () {
  if(ehp > 0){
  gstatus = 'flight';
  if(estatus == 'flight'){emod = 1; gmod = 1;}
  else{emod = 0.6;}
    $('<p>{$gname} flew up into the air!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
      if (ehp <= 0 && ghp > 0){ youWon(); }
    
     if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
    }
  });
  
  $('#heal1').on('click', function () {
  if(mp < 10){
  $('<p>{$gname} does not have enough MP left to cast Healing Breeze!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 10){
  if(ehp > 0){
  var rand = Math.floor(Math.random() * 15) + 1;
  griffheal = Math.round((gmagic / 2) + rand);
  ghp = ghp + griffheal;
  updateHealth(ghp);
  mp = mp - 10;
  updateStats();
    $('<p>{$gname} healed themselves for ' +griffheal+ ' HP! Used 10 MP.</p>').fadeIn(500).appendTo('#reports');
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
  });
  
  $('#heal2').on('click', function () {
  if(mp < 20){
  $('<p>{$gname} does not have enough MP left to cast Healing Glow!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 20){
  if(ehp > 0){
  var rand = Math.floor(Math.random() * 15) + 1;
  griffheal = gmagic + rand;
  ghp = ghp + griffheal;
  updateHealth(ghp);
  mp = mp - 20;
  updateStats();
    $('<p>{$gname} healed themselves for ' +griffheal+ ' HP! Used 20 MP.</p>').fadeIn(500).appendTo('#reports');
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
  });
  
  $('#heal3').on('click', function () {
  if(mp < 30){
  $('<p>{$gname} does not have enough MP left to cast Healing Aura!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 30){
  if(ehp > 0){
  var rand = Math.floor(Math.random() * 15) + 1;
  griffheal = (gmagic * 2) + rand;
  ghp = ghp + griffheal;
  updateHealth(ghp);
  mp = mp - 30;
  updateStats();
    $('<p>{$gname} healed themselves for ' +griffheal+ ' HP! Used 30 MP.</p>').fadeIn(500).appendTo('#reports');
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
  });
  
  $('#ice1').on('click', function () {
  if(mp < 10){
  $('<p>{$gname} does not have enough MP left to cast Icy Breeze!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 10){
  if(ehp > 0){
       var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < edodge) { mp = mp - 10;
       $('<p>{$gname} cast Icy Breeze, but {$opname} dodged it! Wasted 10 MP...</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > edodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  griffice = Math.round(((gmagic + gsense) / 2) + rand);
  ehp = ehp - griffice;
  updateEnHealth(ehp);
  mp = mp - 10;
  updateStats();
    $('<p>{$gname} cast Icy Breeze, dealing ' +griffice+ ' damage! Used 10 MP.</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
     }
  });
  
  $('#ice2').on('click', function () {
  if(mp < 30){
  $('<p>{$gname} does not have enough MP left to cast Frostbite!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 30){
  if(ehp > 0){
      var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < edodge) { mp = mp - 30;
       $('<p>{$gname} cast Frostbite, but {$opname} dodged it! Wasted 30 MP...</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > edodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  griffice = gmagic + gsense + rand;
  ehp = ehp - griffice;
  updateEnHealth(ehp);
  mp = mp - 30;
  updateStats();
    $('<p>{$gname} cast Frostbite, dealing ' +griffice+ ' damage! Used 30 MP.</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    if (ehp > 0){ enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
     }
  });
  
  $('#ice3').on('click', function () {
  if(mp < 50){
  $('<p>{$gname} does not have enough MP left to cast Blizzard Blast!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 50){
   if(ehp > 0){
       var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < edodge) { mp = mp - 50;
       $('<p>{$gname} cast Blizzard Blast, but {$opname} dodged it! Wasted 50 MP...</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > edodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  griffice = ((gmagic + gsense) * 2) + rand;
  ehp = ehp - griffice;
  updateEnHealth(ehp);
  mp = mp - 50;
  updateStats();
    $('<p>{$gname} cast Blizzard Blast, dealing ' +griffice+ ' damage! Used 50 MP.</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); }
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
      if (ghp <= 0 && ehp > 0){ youLost(); }
      }
  });
  
  $('#buff1').on('click', function () {
  if(mp < 5){
  $('<p>{$gname} does not have enough MP left to cast Magic Aid!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 5){
  if(ehp > 0){
  var rand = Math.floor(Math.random() * 15) + 1;
  gsense = Math.round(gsense * 1.2);
  gspeed = Math.round(gspeed * 1.2);
  gstamina = Math.round(gstamina * 1.2);
  gstrength = Math.round(gstrength * 1.2);
  mp = mp - 5;
  updateStats();
    $('<p>{$gname} cast Magic Aid, buffing physical stats by 1.2x! Used 5 MP.</p>').fadeIn(500).appendTo('#reports');
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); } 
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
  });
  
  $('#buff2').on('click', function () {
  if(mp < 40){
  $('<p>{$gname} does not have enough MP left to cast Magic Guard!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
  }
  if(mp >= 40){
  if(ehp > 0){
  var rand = Math.floor(Math.random() * 15) + 1;
  gsense = Math.round(gsense * 1.5);
  gspeed = Math.round(gspeed * 1.5);
  gstamina = Math.round(gstamina * 1.5);
  gstrength = Math.round(gstrength * 1.5);
  mp = mp - 40;
  updateStats();
    $('<p>{$gname} cast Magic Guard, buffing physical stats by 1.5x! Used 40 MP.</p>').fadeIn(500).appendTo('#reports');
    if (ehp > 0) { enemyact[Math.floor(Math.random() * enemyact.length)](); } 
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
  }  
      if (ghp <= 0 && ehp <= 0){ youDrew(); }
     if (ghp <= 0 && ehp > 0){ youLost(); }
  });
  
  $('#taunt').on('click', function () {
  if(ehp > 0){
    $('<p>{$gname} rudely gestured at {$opname}, angering them and damaging their focus!</p>').fadeIn(500).appendTo('#reports');
    enemyact[Math.floor(Math.random() * enemyact.length)](); 
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
    if (ghp <= 0 && ehp <= 0){ youDrew(); }
    if (ghp <= 0 && ehp > 0){ youLost(); }
  });
  
  // the defend action is tough because the enemy functions are self-contained; changes are done and message shown, you can't alter it afterwards
  // so uhhh, instead this action 'sets a flag' that you're in defensive mode. Variable counts down for next 3 turns, reducing damage from enemy
  // basically like a temporary shield
  
  $('#defend').on('click', function () {
  if(ehp > 0){
  gdefend = 3;
    $('<p>{$gname} goes into defensive mode, hoping to avoid damage from {$opname}s next few attacks!</p>').fadeIn(500).appendTo('#reports');
    enemyact[Math.floor(Math.random() * enemyact.length)](); 
      if (ehp <= 0 && ghp > 0){ youWon(); }
    }
    if (ghp <= 0 && ehp <= 0){ youDrew(); }
    if (ghp <= 0 && ehp > 0){ youLost(); }
  });
  
  
  
  // now the enemy's side
  
  var enemyact = [eSlam, eClaw, eScreech, 
  
  ",FALSE));
  
  
  // add moves, if enemy knows them. It could work the JS way, enemyact.push, but this way is a bit shorter so why not... 
  
  if($enemyskills->HealingBreeze == "unlocked"){  $document->add(new Comment("  eHeal1,  ",FALSE));  }
  if($enemyskills->HealingGlow == "unlocked"){  $document->add(new Comment("  eHeal2,  ",FALSE));  }
  if($enemyskills->HealingAura == "unlocked"){  $document->add(new Comment("  eHeal3,  ",FALSE));  }
  if($enemyskills->IcyBreeze == "unlocked"){  $document->add(new Comment("  eIce1,  ",FALSE));  }
  if($enemyskills->Frostbite == "unlocked"){  $document->add(new Comment("  eIce2,  ",FALSE));  }
  if($enemyskills->BlizzardBlast == "unlocked"){  $document->add(new Comment("  eIce3,  ",FALSE));  }
  if($enemyskills->MagicAid == "unlocked"){  $document->add(new Comment("  eBuff1,  ",FALSE));  }
  if($enemyskills->MagicGuard == "unlocked"){  $document->add(new Comment("  eBuff2,  ",FALSE));  }
  
  // let's also have moves attached to companion creatures and held items, yay more strategy for players to consider
  
  if($enemy->companion == "Wyandotte" || $enemy->companion == "Barred Rock" || $enemy->companion == "Chabo")
  {  $document->add(new Comment("  eChicken,  ",FALSE));  }
  
  if($enemy->treasure == "Cypris Doll"){  $document->add(new Comment("  eDoll,  ",FALSE));  }
  
  // just be aware that there is no MP for enemies. Because there's no AI and they're dimwits
  // it would be too easy if they ran out of MP and then wasted most of their turns. So I let them use spells/abilities forever
  
  
  $document->add(new Comment("eFly, eWhoops];
  
  function eSlam() {
       var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < gdodge) { 
       $('<p>{$opname} tried to slam into {$gname}, but it was dodged!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > gdodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  attack = (20 + rand) + emod; 
  ghp = ghp - attack;
  updateHealth(ghp);
      $('<p>{$opname} slammed into {$gname}, knocking them over for ' +attack+ ' damage!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
    }
      }
      
  function eClaw() {
       var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < gdodge) { 
       $('<p>{$opname} tried to scratch {$gname}, but it was avoided!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > gdodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  attack = (20 + rand) + emod; 
  ghp = ghp - attack;
  updateHealth(ghp);
      $('<p>{$opname} whizzed past, clawing at {$gname} for ' +attack+ ' damage!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
    }
      }
      
  function eChicken() {
       var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < gdodge) { 
       $('<p>{$opname} sent a horde of chickens flying out, but {$gname} dodged them!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > gdodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  attack = (30 + rand) + emod; 
  ghp = ghp - attack;
  updateHealth(ghp);
      $('<p>{$opname} sent a horde of chickens clawing at {$gname} for ' +attack+ ' damage!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
    }
      }
  
  function eScreech() {
       var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < gdodge) { $('<p>{$opname} started screeching, but it had no effect on {$gname}!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > gdodge) {
  gsense = gsense * 0.8;
      $('<p>{$opname} suddenly lets out a piercing screech and distracts {$gname}s senses!</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
    }
      }
      
  function eFly() {
  estatus = 'flight';
  if (gstatus == 'flight'){gmod = 1; emod = 1;}
  else{gmod = 0.6;}
      $('<p>{$opname} flies into the air, making them harder to hit.</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
  
  
  function eHeal1() {
  var rand = Math.floor(Math.random() * 15) + 1;
  eheal = Math.round((emagic / 2) + rand);
  ehp = ehp + eheal;
  updateEnHealth(ehp);
      $('<br>{$opname} cast Healing Breeze and regained ' +eheal+ ' HP!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
  function eHeal2() {
  var rand = Math.floor(Math.random() * 15) + 1;
  eheal = emagic + rand;
  ehp = ehp + eheal;
  updateEnHealth(ehp);
      $('<br>{$opname} cast Healing Glow and regained ' +eheal+ ' HP!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
  function eHeal3() {
  var rand = Math.floor(Math.random() * 15) + 1;
  eheal = (emagic * 2) + rand;
  ehp = ehp + eheal;
  updateEnHealth(ehp);
      $('<br>{$opname} cast Healing Aura and regained ' +eheal+ ' HP!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
      
      
  function eIce1() {
  var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < gdodge) { 
       $('<p>{$opname} tried to cast Icy Breeze but {$gname} avoided it!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > gdodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  espell = Math.round(((emagic + esense) / 2) + rand);
  ghp = ghp - espell;
  updateHealth(ghp);
      $('<br>{$opname} cast Icy Breeze, dealing ' +espell+ ' damage! Brr!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
    }
      }
  function eIce2() {
  var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < gdodge) { 
       $('<p>{$opname} tried to cast Frostbite but {$gname} avoided it!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > gdodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  espell = emagic + esense + rand;
  ghp = ghp - espell;
  updateHealth(ghp);
      $('<br>{$opname} cast Frostbite, dealing ' +espell+ ' damage! Brr!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
    }
      }
  function eIce3() {
  var dodge = Math.floor(Math.random() * 100) + 1; 
       if (dodge < gdodge) { 
       $('<p>{$opname} tried to cast Blizzard Blast but {$gname} avoided it!</p>').fadeIn(500).appendTo('#reports');
       enemyact[Math.floor(Math.random() * enemyact.length)](); }
    if (dodge > gdodge) {
  var rand = Math.floor(Math.random() * 15) + 1;
  espell = ((emagic + esense) * 2) + rand;
  ghp = ghp - espell;
  updateHealth(ghp);
      $('<br>{$opname} cast Blizzard Blast, dealing ' +espell+ ' damage! Brr!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
    }
      }
  
  
  function eBuff1() {
  esense = Math.round(esense * 1.2);
  espeed = Math.round(espeed * 1.2);
  estamina = Math.round(estamina * 1.2);
  estrength = Math.round(estrength * 1.2);
      $('<br>{$opname} cast Magic Aid, multiplying their physical stats by 1.2x!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
  function eBuff2() {
  esense = Math.round(esense * 1.5);
  espeed = Math.round(espeed * 1.5);
  estamina = Math.round(estamina * 1.5);
  estrength = Math.round(estrength * 1.5);
      $('<br>{$opname} cast Magic Guard, multiplying their physical stats by 1.5x!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
  
  
  
  function eDoll() {
  var rand = Math.floor(Math.random() * 20) + 1;
  heal = 40 + rand;
  ehp = ehp + heal;
  updateEnHealth(ehp);
      $('<br>{$opname} somehow?? used their toy griffin doll to heal ' +heal+ ' HP!<br>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
  
  function eWhoops() {
  var rand = Math.floor(Math.random() * 30) + 1;
  rock = 20 + rand;
  ehp = ehp - rock;
  updateEnHealth(ehp);
  ghp = ghp - rock;
  updateHealth(ghp);
      $('<p>{$opname} tries to leap around {$gname} but they collide! ' +rock+ ' damage each.</p>').fadeIn(500).appendTo('#reports');
    var latest = document.getElementById('reports');
    latest.scrollTop = latest.scrollHeight;
    updateStats();
      }
  
  
  // status effects can't last forever, so call a function every round with a 1/4 chance to end them, and reset attack modifiers to 1
  // unfortunately this refuses to work... :(
  
//  function checkStatus() {
//     if (gstatus == 'flight'){ var rand1 = Math.floor(Math.random() * 4) + 1; if rand1 = 2 
// {gstatus = 'normal'; msg = '{$gname} lands back on the ground.'; }  else {msg = '{$gname} continues flying.'; }  }
//     if (gstatus == 'defend'){ var rand2 = Math.floor(Math.random() * 4) + 1; if rand2 = 2 
// {gstatus = 'normal'; msg = '{$gname} stops being defensive, looking to attack again.'; } else {msg = '{$gname} remains defensive.'; } }
//     if (gstatus == 'berserk'){ var rand3 = Math.floor(Math.random() * 4) + 1; if rand3 = 2 
// {gstatus = 'normal'; msg = '{$gname} comes back to their senses.'; } else {msg = '{$gname} is still berserk.'; } }
// else { msg = '{$gname} circles the arena, watching {$opname} closely.';}
//      $('<p>' +msg+ '</p>').fadeIn(500).appendTo('#reports');
      
//     if (estatus == 'flight'){ var rand4 = Math.floor(Math.random() * 4) + 1; if rand4 = 2 
// {estatus = 'normal'; emsg = '{$opname} lands back on the ground.'; } else {emsg = '{$opname} continues flying.'; }  }
//     if (estatus == 'defend'){ var rand5 = Math.floor(Math.random() * 4) + 1; if rand5 = 2 
// {estatus = 'normal'; emsg = '{$opname} stops being defensive, looking to attack again.'; } else {emsg = '{$opname} remains defensive.'; } }
//     if (estatus == 'berserk'){ var rand6 = Math.floor(Math.random() * 4) + 1; if rand6 = 2 
// {estatus = 'normal'; emsg = '{$opname} comes back to their senses.'; } else {emsg = '{$opname} is still berserk.'; } }
// else { emsg = '{$opname} circles the arena, watching {$opname} closely.';}
//      $('<p>' +emsg+ '</p>').fadeIn(500).appendTo('#reports'); 
      
//    var latest = document.getElementById('reports');
//    latest.scrollTop = latest.scrollHeight;
//      }
  
  
  // call this after most of your actions. Since you don't know if battle will end only after yours (you knock out enemy)
  // but it could be omitted in cases where you're sure enemy will act after you - like when you heal. It'll be called during their action
  
  function updateStats() {
    $('#griffhp').html('Health: <b>' +ghp+ '</b>');
    $('#griffmp').html('Mana: <b>' +mp+ '</b>');
    gspeed = Math.round(gspeed);
    $('#griffspeed').html('Speed: <b>' +gspeed+ '</b>');
    gsense = Math.round(gsense);
    $('#griffsense').html('Sense: <b>' +gsense+ '</b>');
    gstamina = Math.round(gstamina);
    $('#griffstamina').html('Stamina: <b>' +gstamina+ '</b>');
    gstrength = Math.round(gstrength);
    $('#griffstrength').html('Strength: <b>' +gstrength+ '</b>');
    $('#griffmagic').html('Magic: <b>' +gmagic+ '</b>');
    $('#gevade').html('Evasion: <b>' +gdodge+ '%</b>');
    $('#gstate').html('Status: <b>' +gstatus+ ' - Mod: ' +gmod+ '</b>');
    $('#enemyhealth').html('Health: <b>' +ehp+ '</b>');
    $('#espeed').html('Speed: <b>' +espeed+ '</b>');
    $('#esense').html('Sense: <b>' +esense+ '</b>');
    $('#estamina').html('Stamina: <b>' +estamina+ '</b>');
    $('#estrength').html('Strength: <b>' +estrength+ '</b>');
    $('#eevade').html('Evasion: <b>' +edodge+ '%</b>');
    $('#emagic').html('Magic: <b>' +emagic+ '</b>');
    $('#estate').html('Status: <b>' +estatus+ ' - Mod: ' +emod+ '</b>');
  }
  
  // and these are quite clear. Note how they display losers' HP as zero, otherwise we'd likely see negative numbers and that's not pretty
  
  function youWon() {
      $('#enemyhealth').html('Health: <b>0</b>');
      $('#victory').show();
      }
  function youDrew() {
      $('#griffhp').html('Health: <b>0</b>');
      $('#enemyhealth').html('Health: <b>0</b>');
      $('#drawn').show();
      }
  function youLost() {
      $('#griffhp').html('Health: <b>0</b>');
      $('#lost').show();
      }
      
      function updateHealth(ghp) {
    var newpercent = Math.round((ghp / gtotal) * 100);
        $('#healthInner').animate({ width: newpercent + '%' }, 500);
    }
    function updateEnHealth(ehp) {
    var newpercente = Math.round((ehp / etotal) * 100);
        $('#enhealthInner').animate({ width: newpercente + '%' }, 500);
    }

});

</script>

",FALSE));

?>