Crafty.scene 'game', ->
  Crafty.background('white')
  Game.soundtrack.volume()

  # initialization

  ui =
    backgroundEls:  Crafty.e('BackgroundElements')

    feedbackLabel:  Crafty.e('Notification')

    customerCash:   Crafty.e('CashPile').attr(x: 20, y: 115).dir('down')
    cashOut:        Crafty.e('CashPile').attr(x: 20, y: 400).dir('up')

    cashRegister:   Crafty.e('CashRegister')
    cashTray:       Crafty.e('CashTray')
    receipt:        Crafty.e('Receipt')
    ticker:         Crafty.e('Ticker')
    score:          Crafty.e('Score').attr(x: 574, y: 7)
    combo:          Crafty.e('Combo').attr(x: 559, y: 24)

    soundControls:  Crafty.e('SoundControls').attr(x: 895, y: 14).soundtrack(Game.soundtrack)
    foregroundEls:  Crafty.e('ForegroundElements')

  window.ui = ui
  currentCustomer = null
  round = 0
  player = new Game.Player()
  score = new Game.Score(ticker:ui.ticker)
  undoStack = []

  # event bindings

  moveFromTrayToOut = (denomination, skipUndo = false) ->
    return if ended
    player.get('cashInRegister').subtract(denomination)
    player.get('cashOut').add(denomination)
    undoStack.push(denomination) unless skipUndo
    Game.sfx.playDenomination(denomination)

  moveBackToTray = (denomination, skipUndo = false) ->
    return if ended
    player.get('cashOut').subtract(denomination)
    player.get('cashInRegister').add(denomination)
    undoStack.push(-1 * denomination) unless skipUndo
    Game.sfx.playDenomination(denomination)

  undo = ->
    top = undoStack.pop()
    if (top)
      denomination = Math.abs(top)
      if (top > 0) then moveBackToTray(denomination, true) else moveFromTrayToOut(denomination, true)

  refill = (denomination) ->
    ui.ticker.subtractTime(2)
    player.get('cashInRegister').add(denomination, 10)

  ui.cashTray.bind 'DenominationClick', moveFromTrayToOut
  ui.cashOut.bind 'DenominationClick', moveBackToTray

  ui.cashTray.bind 'Refill', refill
  ui.cashTray.bind('Submit', -> submitRound() if !ended)

  # methods

  fails = 0

  submitRound = ->
    trueDiff = currentCustomer.correctChange() - player.get('cashOut').value()
    difference = Math.abs(trueDiff)

    if difference > 0
      payingLess = trueDiff > 0
      fails += 1 if payingLess

      if payingLess
        if fails < Config.game.maxFails
          score.resetCombo()
          Game.sfx.playComboBroken()
          ui.feedbackLabel.showAngry()
          return
        else if payingLess
          score.submit(difference)
          Game.sfx.playUnacceptable()
          ui.feedbackLabel.showLeaving(difference.toMoneyString())
      else
        ui.feedbackLabel.showOver(difference.toMoneyString())

    else
      ui.feedbackLabel.showGood()
    score.submit(difference)

    fails = 0
    player.get('cashInRegister').merge(currentCustomer.get('paid'))
    player.set('cashOut', new Game.Cash())
    mixpanel.track('round submit', {difference: difference, round: round, score: score.get('points'), combo: score.get('combo'), timeLeft: ui.ticker.timeLeft(), wasCorrect: difference==0})
    generateNewRound()
    Game.sfx.playRegisterOpen()

  generateNewRound = ->
    mixpanel.track('round start', round: round, score: score.get('points'), combo: score.get('combo'), timeLeft: ui.ticker.timeLeft())
    currentCustomer = new Game.Customer()
    ui.receipt.customer(currentCustomer).animateUp()

    ui.cashTray.open()
    ui.customerCash.cash(currentCustomer.get('paid'))
    ui.cashOut.cash(player.get('cashOut'))
    undoStack = []
    round += 1

  ended = false

  endGame = ->
    Game.sfx.playGameover()
    mixpanel.track('game ended', score: score.get('points'), round: round)
    ended = true
    newHighscore = score.get('points') > Game.settings.currentHighscore()
    Game.settings.saveHighscore(score.get('points'))
    Game.soundtrack.lowVol()
    Crafty.e('Modal').fadeIn()
    menu = Crafty.e('MenuUI').titleText('Game Over').currentScore(score.get('points')).newHighscore(newHighscore).animate()
    score.save (result)->
      menu.updateScore(result)


  # run
  ui.score.scoreModel(score)
  ui.combo.scoreModel(score)
  ui.cashTray.cash(player.get('cashInRegister'))
  ui.ticker.bind('RoundTimeEnded', endGame)
  setTimeout((-> Game.sfx.playRegisterClose()), 200)
  mixpanel.track('game start')
  generateNewRound()

  setTimeout(( =>
    @bind 'KeyDown', (ev) ->
      return if ended

      if ev.key == Config.input.undo or ev.key == Config.input.alt_undo
        ev.originalEvent.preventDefault()
        ev.originalEvent.stopPropagation()
        undo()
      else if (ev.key == Config.input.submit) or (ev.key == Config.input.otherSubmit)
        submitRound()
      else if (ev.key == Config.input.quit)
        ui.ticker.declareEnd()
      else
        _.each Game.DENOMINATIONS, (d)->
          if ev.key == Config.input.money[d]
            try
              moveFromTrayToOut(d)
            catch
              refill(d)
  ), 100)
