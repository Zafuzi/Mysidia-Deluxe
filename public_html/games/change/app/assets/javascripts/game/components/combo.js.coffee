Crafty.c 'Combo',

  init: ->
    @requires('2D, DOM, Text, Tween')
    .textFont(size: '12px')
    .textColor('#ffffff')
    .css('text-align': 'left')
    .bind('Remove', => @_score.off())

  scoreModel: (score) ->
    @_score = score
    @_score.on('change:combo', @_update, @)
    @_score.on('success', => setTimeout((=> Game.sfx.playCombo(@_score.get('combo'))), 50))
    @_update()
    @

  _update: ->
    combo = @_score.get('combo')
    if combo >
      @attr(y: 20)
    else
      @attr(y: 28)
    @tween({y: 24}, 10)

    @text("x#{combo}")


