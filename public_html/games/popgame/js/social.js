(function() {
  'use strict';

  function Social() {

    this.startTxt = null;
    this.tweet = null;
    this.bg = null;
    this.nextAnime = false;
    this.test = 0;
  }

  Social.prototype = {

    create: function () {
      var x = this.game.width / 2
        , y = this.game.height / 2;
      
      this.stage.backgroundColor = '#5bbcec';
      this.tweet = this.add.sprite(x,-100,'twitter');

      //this.logo.fixedToCamera = true;
      this.tweet.anchor.setTo(0.5, 0.5);
      this.tweet.inputEnabled = true;
      this.tweet.input.useHandCursor = true;
      this.tweet.events.onInputDown.add(this.sendTweet,this);
     // y = y + this.logo.height +50;
      //this.startTxt = this.add.bitmapText(x, y, 'TAP TO START', {font: '12px minecraftia', align: 'center'});
      //this.startTxt = this.game.add.text(x, y, 'text here', { font: '20px pecita', fill: '#fff', align: 'center' });
      this.startTxt = this.add.sprite(x,500,'retry');

      this.startTxt.anchor.setTo(0.5, 0.5);
      this.startTxt.inputEnabled = true;
      this.startTxt.input.useHandCursor = true;
      //this.startTxt.inputEnabled = true;
      //this.startTxt.input.useHandCursor = true;
      this.startTxt.events.onInputDown.add(this.reset,this);  
      //this.input.onDown.add(this.onDown, this);
    },

    update: function () {
      var x = this.game.width / 2
        , y = this.game.height / 2;    
      var tweety = y - 50;
      var texty = y + 80;
      this.tweet.y += (tweety - this.tweet.y)*0.1;
      this.startTxt.y += (texty - this.startTxt.y)*0.1;
      if(this.test == 0){
      }

        

    },
    reset: function () {
      //this.nextAnime = true;
      //alert();
      //window.location.href = "https://twitter.com/intent/tweet?text=I just popped "+count+" dots in !pop. Beat that: https://dl.dropboxusercontent.com/u/2302094/tapJuggler/index.html";
      this.game.state.start('game');
    },
    sendTweet: function () {
      //this.nextAnime = true;
      //alert();
      
      window.location.href = "https://twitter.com/intent/tweet?button_hashtag=popgame&text=I just popped "+count+" dots in !pop, a game where you create serene explosions of color!  http://spritewrench.github.io/-pop/ via @spritewrench";
    }
  };

  window['tapjuggler'] = window['tapjuggler'] || {};
  window['tapjuggler'].Social = Social;

}());
