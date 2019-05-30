Crafty.scene "loading", ->
  Crafty.background('black')
  Crafty.e('2D, DOM, Text')
    .text('loading...')
    .textColor('#FFFFFF')
    .textFont(size: '15px')
    .css('text-align':'right')
    .attr(w: Config.window.width - 30, h: 30, y: Config.window.height - 30)

  Game.soundtrack = new Game.Soundtrack()

  assets = _.map(Game.images, (v,k) -> v)
  mixpanel.track('loading started')
  mixpanel.identify(Game.settings.identifier())
  Crafty.load(assets, ->
      mixpanel.track('loading done')
      if Game.settings.didSeeTutorial()
        Crafty.scene('menu')
      else
        Crafty.scene('tutorial')
  )