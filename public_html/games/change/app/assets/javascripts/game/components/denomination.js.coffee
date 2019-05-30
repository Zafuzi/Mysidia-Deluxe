Crafty.c 'Denomination',
  init: ->
    @requires('2D, DOM, Image, ScaleableImage')
     .origin('center')
     .attr(z: 300)
    @

  denomination: (denomination) ->
    @_denomination = denomination
    @image(@_imageMapping[denomination])
    @addComponent(@_classMapping[denomination])

  _imageMapping:
    1: Game.images.oneCent
    5: Game.images.fiveCent
    10: Game.images.tenCent
    25: Game.images.quarter
    100: Game.images.oneDollar
    500: Game.images.fiveDollar
    1000: Game.images.tenDollar

  _classMapping:
    1: 'oneCent'
    5: 'fiveCent'
    10: 'tenCent'
    25: 'quarter'
    100: 'oneDollar'
    500: 'fiveDollar'
    1000: 'tenDollar'