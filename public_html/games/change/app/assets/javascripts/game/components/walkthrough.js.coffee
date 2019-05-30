Crafty.c "Walkthrough",
  steps: [
    {title: 'A Quick Tutorial', text: 'CHANG€ is an intense game about the eXtreme life of supermarket cashiers.'}
    {highlight:{x: 800, y: 100}, title: 'Time is money', text: 'The objective in CHANG€ is to get as many points in 60 seconds.'}
    {highlight:{x: 615, y: 125}, title: 'The Customer is always right...', text: 'Each round a new customer will come up and a receipt will be printed with the total the customer has to pay.'}
    {highlight:{x: 360, y: 100}, title: '... but annoying', text: 'The customer will place a certain amount of cash in front of you.'}
    {highlight:{x: 590, y: 420}, title: 'Money Money Money', text: 'You need to give out the correct change from your register by clicking on the different denominations.'}
    {highlight:{x: 260, y: 400}, title: 'It\'s OK to be wrong', text: 'If you took out too much of a denomination, just click on it to put it back in the cash register.'}
    {highlight:{x: 725, y: 500}, title: 'Ding!', text: 'Once you think you have the correct amount, push the cash tray closed.'}
    {highlight:{x: 560, y: 0}, title: 'Dong!', text: 'You will receive the most points if you get the exact amount correct.'}
    {highlight:{x: 765, y: 290}, title: 'Mo Money, Mo Problems', text: 'If you ever run out of a denomination, you can request a refill.'}
    {x: 150, keysOverlay:{visible: true}, highlight:{x: -60, y: -60}, title: 'Keyboard Fu', text: 'To play even faster you can use the keyboard.
        <ul>
          <li><strong>A,S,D</strong>give $1, $5, $10 </li>
          <li><strong>Z,X,C,V</strong>give 1¢, 5¢, 10¢, 25¢</li>
          <li><strong>SPACE</strong>to push the tray close</li>
          <li><strong>BACKSPACE</strong>to undo</li>
        </ul>'}
  {highlight:{x: -100, y: -100}, title: 'Feeling unlucky?', text: 'You can easily restart a game by pressing ESC and right afterwards SPACE.'}
  ]

  init: ->
    @requires('2D, DOM, HTML')
     .attr(w: 320, z: 1002, x: 330, y: 200)
      .setter('title', @title)
      .setter('text', @text)
      .setter('highlight', @highlight)
      .setter('keysOverlay', @keysOverlay)
    @_keys = Crafty.e('2D, DOM, Image, KeyboardTutorial').attr(w: 349, h: 316, x: 593, y:200, z: 1003, visible: false)
    @_highlight = Crafty.e('2D, DOM, Highlight').attr(w: 60, h: 60, x: -60, y: -60, z: 1001)
    @_skip = Crafty.e('2D, DOM, Text, Mouse, Skip')
            .attr(w: 32, h: 28, z: 1003, x: 330+320-32, y:200)
            .text('skip')
            .textFont(size: '11px/28px')
            .bind('Click', =>
          mixpanel.track('tutorial skipped', step: @_currentStep)
          @trigger('Ended')
      )
            .css('text-align': 'center')
    @attach(@_skip)
    @_currentStep = -1
    @step()
    @

  title: (title)->
    @_title = title
    @_refresh()

  text: (text) ->
    @_text = text
    @_refresh()

  highlight: (highlight)->
    @_highlight.attr(highlight)

  keysOverlay: (attrs)->
    @_keys.attr(attrs)

  _refresh: ->
    @replace("<div class='title'>#{@_title}</div><div class='text'>#{@_text}</div>")

  step: ->
    @_currentStep += 1
    if @_currentStep >= @steps.length
      @trigger('Ended')
      return
    mixpanel.track('tutorial view step', step: @_currentStep)
    @attr(@steps[@_currentStep])


