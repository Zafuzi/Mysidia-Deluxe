#= require ./denomination

# Holds an integer money amount divided into concrete denominations from Game.DENOMINATIONS
class Game.Cash extends Backbone.Model

  # Set up a new amount object
  # options:
  #   defaults: amount for each multiplier by default
  #   1,5,50...: specific amounts for each multiplier
  constructor: (@options = {}) ->
    super()
    for denomination in Game.DENOMINATIONS
      value = Math.max(0, @options[denomination] || @options.defaults || 0)
      @set(denomination, value)

  # calculate the value for all the money
  value: ->
    v = 0
    for denomination,multiplier of @attributes
      v += denomination * multiplier
    v

  valueString: (withSymbol = true) ->
    @value().toMoneyString(withSymbol)

  # value for specific denomination
  valueFor: (denomination) ->
    @amountOf(denomination) * denomination

  # get the amount of a specific denomination
  amountOf: (denomination) ->
    @get(denomination)

  # Add amounts for a specific denomination
  add: (denomination, value = 1) ->
    throw "Unsupported denomination #{denomination}" if not denomination in Game.DENOMINATIONS
    @set(denomination, @get(denomination) + value)

  # Remove amounts from a denomination
  subtract: (denomination, value = 1) ->
    throw "Can't subtract under 0" if (@get(denomination) - value) < 0
    @set(denomination, @get(denomination) - value)

  merge: (cash)->
    for denomination in Game.DENOMINATIONS
      @add(denomination, cash.amountOf(denomination))