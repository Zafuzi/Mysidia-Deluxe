Crafty.c 'Notification',

  colors:
    positive: '#2A7311'
    negative: '#B31919'

  responses:
    good: ['Great', 'Awesome!', 'Thanks!', 'Yeah!', 'KTHXBYE', 'Gratzi', 'Merci', 'Olé']
    over: ['HA Sucker {0}', 'Thanks for the extra {0}', 'You gave me {0} extra']
    leaving: ['Come on already', 'What\'s the holdup?' , 'Your still missing {0}', 'NO! STOP BEING WRONG', 'You\'re off by {0} - GOODBYE SIR']
    angry: ['NO', 'NOPE', 'HEY that\'s not enough', 'Incorrect', 'Wrong']


  init: ->
    @requires('2D, DOM, Text, Tween')
      .attr(x: 60, y: 250, w: 460, h: 40, z: 10000)
      .textFont(size: '32px')
      .css('text-align': 'center')
    @_yBase = null
    @

  showGood: ->
    @showPositive(_.sample(@responses.good))

  showAngry: ->
    @showNegative(_.sample(@responses.angry))

  showOver: (amount) ->
    @showNegative(_.sample(@responses.over).format(amount))

  showLeaving: (amount) ->
    @showNegative(_.sample(@responses.leaving).format(amount))

  showPositive: (text)->
    @textColor(@colors.positive)
    .showAnimated(text)

  showNegative: (text)->
    @textColor(@colors.negative)
    .showAnimated(text)

  showAnimated: (text)->
    @_yBase ||= @_y
    @text(text).attr(alpha: 1, y: @_yBase).tween({
      alpha: 0,
      y: @_yBase - 50
    }, 70)
