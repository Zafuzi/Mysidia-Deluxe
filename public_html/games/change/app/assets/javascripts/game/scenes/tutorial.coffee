Crafty.scene 'tutorial', ->
  ui =
    backgroundEls:  Crafty.e('BackgroundElements')

    feedbackLabel:  Crafty.e('Notification').attr(x: 160, y: 250, w: 260, h: 40)

    customerCash:   Crafty.e('CashPile').attr(x: 20, y: 115).dir('down')
    cashOut:        Crafty.e('CashPile').attr(x: 20, y: 400).dir('up')

    cashRegister:   Crafty.e('CashRegister')
    cashTray:       Crafty.e('CashTray')
    receipt:        Crafty.e('Receipt')
    ticker:         Crafty.e('Ticker').walkthrough('01:00')
    score:          Crafty.e('Score').attr(x: 574, y: 7)
    combo:          Crafty.e('Combo').attr(x: 559, y: 24)

    soundControls:  Crafty.e('SoundControls').attr(x: 895, y: 14).soundtrack(Game.soundtrack)
    foregroundEls:  Crafty.e('ForegroundElements')
    modal:          Crafty.e('Modal, Mouse')
    walkthrough:    Crafty.e('Walkthrough')

  window.ui = ui
  currentCustomer = new Game.Customer()
  currentCustomer.set(price: 350, paid: new Game.Cash(500: 1))
  player = new Game.Player()
  player.get('cashInRegister').subtract(1000, 10)
  player.get('cashOut').add(100, 1)
  score = new Game.Score(ticker:ui.ticker, points: 300, combo: 2)

  ui.receipt.customer(currentCustomer)
  ui.customerCash.cash(currentCustomer.get('paid'))
  ui.cashOut.cash(player.get('cashOut'))
  ui.cashTray.open()

  # run
  ui.score.scoreModel(score)
  ui.combo.scoreModel(score)
  ui.cashTray.cash(player.get('cashInRegister'))

  ui.modal.bind('Click', => ui.walkthrough.step())
  @bind 'KeyDown', (ev) ->
    if ev.key == Config.input.submit
      ui.walkthrough.step()

  ui.walkthrough.bind 'Ended', =>
    Game.settings.sawTutorial()
    Crafty.scene('menu')

  mixpanel.track('view tutorial', firstTime: Game.settings.didSeeTutorial())