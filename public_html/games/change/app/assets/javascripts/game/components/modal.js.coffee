Crafty.c 'Modal',

  init: ->
    @requires('2D, DOM, Tween')
      .attr(x:0, y:0, w:Config.window.width, h:Config.window.height, z:520)

  fadeIn: ->
    @attr(alpha: 0)
     .tween({alpha: 1}, 100)
