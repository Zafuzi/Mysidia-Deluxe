Crafty.c 'CustomerPrice',

  init: ->
    @requires('2D, DOM, Text')
    .textFont(size: '30px')
    .attr(w: 110, h: 40, x: 0, y: 50, z: 520)
    .css('text-align': 'center', 'text-decoration': 'underline')

  customer: (customer) ->
    @text(customer.get('price').toMoneyString())
    @

Crafty.c 'Receipt',
  _height: 117
  _ypos: 89

  init: ->
    _.bindAll(@, '_showCustomerPrice')
    @requires('2D, DOM, receipt, Tween')
      .attr(w: 110, h: @_height)
    @customePrice = Crafty.e('CustomerPrice')
    @attach(@customePrice)
      .attr(x: 592, y: @_ypos, z: 520)
    @bind('TweenEnd', @_showCustomerPrice)
    @

  yPos: (@_ypos) ->
    @

  heightForAnimation: (@_height) ->
    @

  animateUp: ->
    @attr(y: @_ypos + @_height, h: 0)
    .tween({
        y: @_ypos
        h: @_height
      }, 30)
    @customePrice.alpha = 0
    @

  _showCustomerPrice: ->
    @customePrice.alpha = 1

  customer: (customer)->
    @customePrice.customer(customer)
    @