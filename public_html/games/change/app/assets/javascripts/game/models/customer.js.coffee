class Game.Customer extends Backbone.Model

  _prices:
    main: [0, 100, 100, 200, 300, 300, 400, 400, 500, 600, 700, 800, 900, 900, 1000, 1100, 1200, 1300, 1400, 1500, 1600, 1700, 1800, 1900]
    part: [0, 0, 5, 10, 20, 25, 29, 30, 40, 45, 49, 50, 50, 50, 75, 75, 79, 80, 90, 99, 99, 99, 99]


  initialize: ->
    @set('price', @_randomizePrice())
    @set('paid', @_randomizePaid())

  _randomizePrice: ->
    _.sample(@_prices.main) + _.sample(@_prices.part)

  _randomizePaid: ->
    paid = new Game.Cash()
    target = @get('price')
    while target > 0
      cash = @_randomChunk(target)
      target -= cash.value()
      paid.merge(cash)
    paid

  _randomChunk: (target)->
    random = Math.random()
    if target > 1000
      return new Game.Cash(1000: 1)
    if random <= 0.5
      @_smallerDenomRounded(target)
    else
      @_oneLargeDenomination(target)

  _smallerDenomRounded: (target)->
    roundDenominations = [25, 100, 500]
    roundTo = _.sample(roundDenominations)
    target = Math.ceil(target/roundTo) * roundTo
    cash = new Game.Cash()
    _.each roundDenominations.reverse(), (denomination)->
      amount = Math.floor(target / denomination)
      cash.add(denomination, amount)
      target = target % denomination
    cash

  _oneLargeDenomination: (target)->
    bigDenominations = _.filter(Game.DENOMINATIONS, (d)-> d > target)
    d = _.sample(bigDenominations)
    cash = new Game.Cash()
    cash.add(d)
    cash


  correctChange: ->
    @get('paid').value() - @get('price')