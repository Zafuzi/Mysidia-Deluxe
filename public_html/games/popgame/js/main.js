window.onload = function () {
  'use strict';

  var game
    , ns = window['tapjuggler'];

  game = new Phaser.Game(320, 480, Phaser.AUTO, 'tapjuggler-game');
  game.state.add('boot', ns.Boot);
  game.state.add('preloader', ns.Preloader);
  game.state.add('menu', ns.Menu);
  game.state.add('game', ns.Game);
  game.state.add('social', ns.Social);

  game.state.start('boot');
};
