Crafty.scene "menu", ->
  Crafty.background('white')


  Crafty.e('BackgroundElements')
  Crafty.e('MenuUI').titleText('CHANG€').animate()

  Crafty.e('SoundControls').attr(x: 895, y: 14, z: 400).soundtrack(Game.soundtrack)
  Game.soundtrack.start() unless Game.soundtrack.get('isPlaying')
  Game.soundtrack.lowVol()

  mixpanel.track('view menu')

