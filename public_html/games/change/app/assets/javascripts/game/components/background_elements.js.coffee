Crafty.c 'BackgroundElements',
  init: ->
    @background = Crafty.e('2D, DOM, background').attr(x: 0, y:0, w: Config.window.width, h: Config.window.height)
    @table = Crafty.e('2D, DOM, table').attr(x: 0, y:(Config.window.height - 450), w: Config.window.width, h: 450)