Crafty.c 'CustomerPrice',

  init: ->
    @requires('2D, DOM, Text')
    .textFont(size: '30px')
    .attr(w: 110, h: 40, x: 592, y: 140)
    .css('text-align': 'center', 'text-decoration': 'underline')

  customer: (customer) ->
    @text(customer.get('price').toMoneyString())
    @