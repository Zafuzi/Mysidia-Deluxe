class Game.Settings

  toggleMute: (value) ->
    store.set('mute', value)

  isSoundMuted: ->
    value = store.get('mute')
    if value == undefined
      store.set('mute', false)
      false
    else
      value

  currentHighscore: ->
    value = store.get('highscore')
    return 0 if (value == undefined)
    return value

  hasSavedHighscore: ->
    value = store.get('highscore')
    value != undefined

  saveHighscore: (score) ->
    value = store.get('highscore')
    if value == undefined
      store.set('highscore', score)
    else
      store.set('highscore', score) if score > value


  didSeeTutorial: ->
    value = store.get('tutorial')
    if value == undefined
      false
    else
      value

  sawTutorial: ->
    store.set('tutorial', true)

  identifier: ->
    idn = store.get('identifier')
    store.set('identifier', generateUUID()) unless idn
    store.get('identifier')