Crafty.c 'CashPile',

  _xPositions:
    1: 0
    5: 50
    10: 110
    25: 150
    50: 150
    100: 220
    500: 320
    1000: 420

  init: ->
    @requires('2D, DOM')
    @_piles = {}
    @_dir = 'down'
    @_cash = null

  dir: (dir) ->
    @_dir = dir
    _.each Game.DENOMINATIONS, (denomination) =>
      @_createDenominationPile(denomination)
    @

  cash: (cash) ->
    @_cash.off() if @_cash?
    @_cash = cash
    _.each Game.DENOMINATIONS, (denomination) =>
      pile = @_piles[denomination]
      pile.amount(cash.amountOf(denomination))
      @_cash.on("change:#{denomination}", => pile.amount(@_cash.amountOf(denomination)))
    @

  _createDenominationPile: (denomination)->
    ydiff = if @_dir == 'down' then 10 else -10
    pile = Crafty.e('DenominationPile')
                  .denomination(denomination)
                  .yDiff(ydiff)
                  .attr(x: @_x + @_xPositions[denomination], y: @_y)
                  .bind('Click', => @trigger('DenominationClick', denomination))
    @_piles[denomination] = pile
    @attach(pile)
