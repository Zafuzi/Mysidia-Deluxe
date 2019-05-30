Crafty.c 'DenominationPile',
  randomizers:
    bill:
      rotation: 4
      x: 5
      y: 2
    coin:
      rotation: 3
      x: 5
      y: 3

  _yDiff: 10
  _amount: 0

  init: ->
    _.bindAll(@, '_createDenomination')
    @requires('2D, DOM, Mouse')
    @denominations = []

  yDiff: (ydiff)->
    @_yDiff = ydiff
    @

  denomination: (denomination) ->
    @_denomination = denomination
    @

  amount: (amount) ->
    @_amount = amount
    _.times amount - @denominations.length, =>
      @_createDenomination().move('e', @_x).move('s', @_y)
    @_show(amount)
    @

  _show: (x) ->
    _.each @denominations, (el, idx) ->
      if idx < x
        el.visible = true
      else
        el.visible = false

  _createDenomination: ->
    item = Crafty.e('Denomination, Mouse').denomination(@_denomination)
    if Game.isBill(@_denomination)
      item.scale(0.4)
    else
      item.scale(0.6)
    item.origin('center').attr(rotation: @_random('rotation'), x: @_random('x'), y: @_random('y') + (@_yDiff * @denominations.length))
    @attach(item)
    item.bind('Click', => @trigger('Click'))
    @denominations.push(item)
    item

  _random: (attr)->
    randomize = if Game.isBill(@_denomination) then @randomizers.bill else @randomizers.coin
    _.random(-1 * randomize[attr], randomize[attr])