Crafty.c 'MenuUI',

  init: ->
    @requires('2D, DOM')

    @recipet = Crafty.e('Receipt').attr(x:300, y:40, w: 360, h:600).yPos(40).heightForAnimation(600)
    @logo = Crafty.e('2D, DOM, Text, Logo').textFont(size: '65px').textColor("#373838").attr(w: 360, x: 300, y: 100, z: 1001)
    credits = Crafty.e('2D, DOM, Text').text('A game by Rothschild Games<br>@shayhdavidson & @yonbergman').textFont(size: '12px').textColor("#373838").attr(w: 320, x: 320, y: 500, z: 1001).css('text-align':'center')

    Game.sfx.playRegisterOpen()

    showButton = Crafty.e("Button")
    .text("Start Game")
    .attr(x: 300, y: 200)
    .bind('Click', => @_start())

    helpButton = Crafty.e("Button, Last")
    .text("Tutorial")
    .attr(x: 300, y: 240)
    .bind('Click', => @_help())

    @attach(@recipet)

    @recipet.attach(@logo)
    @recipet.attach(showButton)
    @recipet.attach(helpButton)
    @recipet.attach(credits)

    if Game.settings.hasSavedHighscore()
      @highScoreTitle = Crafty.e('2D, DOM, Text, Highscore').textFont(size: '25px').textColor("#373838").attr(w: 360, x: 300, y: 382, z: 1001).text('Highscore')
      @recipet.attach(@highScoreTitle)
      @highScoreText = Crafty.e('2D, DOM, Text, Logo').textFont(size: '20px').textColor("#656347").attr(w: 360, x: 300, y: 432, z: 1001).text(Game.settings.currentHighscore())
      @recipet.attach(@highScoreText)

    setTimeout((=> @bind('KeyDown', @_startWithSpace)), 1000)

  titleText: (text) ->
    @logo.text(text)
    @

  newHighscore: (value) ->
    return @ unless value
    @highScoreTitle.textColor("#ff0000")
    @highScoreTitle.text("NEW HIGHSCORE!")
    @

  currentScore: (value) ->
    @scoreTitle = Crafty.e('2D, DOM, Text, Highscore').textFont(size: '20px').textColor("#373838").attr(w: 360, x: 300, y: 300, z: 1001).text('Final Score')
    @recipet.attach(@scoreTitle)
    @scoreLabel = Crafty.e('2D, DOM, Text, Logo').textFont(size: '20px').textColor("#656347").attr(w: 360, x: 300, y: 350, z: 1001).text(value)
    @recipet.attach(@scoreLabel)
    @

  updateScore: (result) ->
    text = escape("I just got #{result.your.score} points on CHANGE,\nI\'m number #{result.your.index} in the world.\nTry your luck http://change-game.herokuapp.com?tweet #ggo13")
    href = "<a class='share' href='https://twitter.com/intent/tweet?text=#{text}' target='_blank'><i class='fa fa-twitter'></i>Share Score</a>"
    @scoreLabel.text("{0}  <small>\#{1} worldwide</small> {2}".format(result.your.score, result.your.index, href))

  animate: ->
    @recipet.animateUp()
    @

  _startWithSpace: (e) ->
    return unless e.key == Crafty.keys['SPACE']
    @_start()

  _start: ->
    @unbind('KeyDown', @_startWithSpace)
    Crafty.scene "game"

  _help: ->
    @unbind('KeyDown', @_startWithSpace)
    Crafty.scene "tutorial"
