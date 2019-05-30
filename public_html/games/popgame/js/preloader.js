(function() {
  'use strict';

  function Preloader() {
    this.asset = null;
    this.ready = false;
    this.music = null;
  }

  Preloader.prototype = {

    preload: function () {
      this.asset = this.add.sprite(160, 240, 'preloader');
      this.asset.anchor.setTo(0.5, 0.5);

      //this.load.onLoadComplete.addOnce(this.onLoadComplete, this);
      this.load.setPreloadSprite(this.asset);

      this.load.image('twitter', 'assets/twitter.png');
      this.load.image('facebook', 'assets/facebook.png');
      this.load.image('retry', 'assets/retry.png');
      
      this.load.image('tapToStart', 'assets/tapToStart.png');
      this.load.image('help', 'assets/help.png');

      
      
      this.load.image('ball1', 'assets/bigBall1.png');
      this.load.image('ball2', 'assets/bigBall2.png');
      this.load.image('ball3', 'assets/bigBall3.png');
      this.load.image('ball4', 'assets/bigBall4.png');
      this.load.image('outline', 'assets/outLine.png');
      
      
      this.load.image('scoreBar', 'assets/bar.png');
      
      
      
      this.load.image('musicOn', 'assets/musicOn.png');
      this.load.image('musicOff', 'assets/musicOff.png');
      
      

      this.load.image('logoBall', 'assets/logoBall.png');
      
      this.load.image('background', 'assets/bg.png');
      this.load.image('background2', 'assets/bg1.png');
      
      //music from @LimeFaceX
      this.load.audio('someChords', ['assets/Gold.mp3', 'assets/Gold.ogg']);   

      
    },

    create: function () {
      this.asset.cropEnabled = false;
    },

    update: function () {
      if (this.ready===false && this.cache.isSoundDecoded('someChords') ) {
        this.ready=true;
        //hide loading css
        document.getElementById('ball').style.display = 'none';
        //show game
        document.getElementById('tapjuggler-game').style.display = 'block';
        this.game.state.start('menu');
        
      }
    },

    onLoadComplete: function () {
      this.ready = true;
    }
  };

  window['tapjuggler'] = window['tapjuggler'] || {};
  window['tapjuggler'].Preloader = Preloader;

}());
