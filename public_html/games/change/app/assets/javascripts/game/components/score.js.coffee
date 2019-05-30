Crafty.c 'Score',

  init: ->
    @requires('2D, DOM, Text, Tween')
    .textFont(size: '30px')
    .css('text-align': 'left')
    .bind('Remove', => @_score.off())

  scoreModel: (score) ->
    @_score = score
    @_score.on('change:points', @_update, @)
    @_update()
    @

  _update: ->
    @attr(y: 4).tween({y: 7}, 10)
    @text(@_score.get('points'))


