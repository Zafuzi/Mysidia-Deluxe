Crafty.c 'ScaleableImage',
  init: ->
    @requires('2D, DOM, Image')

  scale: (value) ->
    @_scale = value
    @attr(w: @_w * value, h: @_h * value)
    @