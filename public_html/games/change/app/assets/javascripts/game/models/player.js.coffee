class Game.Player extends Backbone.Model

  DEFAULT_AMOUNT_OF_DENOMINATION = 10

  defaults: ->
    cashInRegister: new Game.Cash(defaults: DEFAULT_AMOUNT_OF_DENOMINATION)
    cashOut:        new Game.Cash()