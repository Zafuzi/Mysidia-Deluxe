class Game.Score extends Backbone.Model

  defaults:
    points: 0
    combo: 1
    ticker: null

  SCORE_MULTIPLIER: 100
  TIME_BONUS_PER_SUCCESS: 2
  TIME_PENALTY_MULTIPLIER_PER_FAILURE: 1

  submit: (diff) ->
    if diff == 0
      @submitSuccess()
    else
     @submitFailure(diff)

  submitSuccess: ->
    @set('points', @get('points') + @get('combo') * @SCORE_MULTIPLIER)
    @set('combo', @get('combo') + 1)
    @trigger('success')
    @get('ticker').addTime(@TIME_BONUS_PER_SUCCESS)

  resetCombo: ->
    @set('combo', @defaults.combo)

  submitFailure: (diff) ->
    @set('points', @get('points') + @diffFailurePoints(diff))
    @resetCombo()
    @trigger('failure')
    @get('ticker').subtractTime(Math.ceil(@diffFailureTransform(diff) * @TIME_PENALTY_MULTIPLIER_PER_FAILURE))

  diffFailurePoints: (diff) ->
    @get('combo') * Math.max(0, (@SCORE_MULTIPLIER - (diff * diff)))

  diffFailureTransform: (diff) ->
    Math.log(diff)

  save: (callback = (->)) ->
    $.post(Config.urls.add_score,
      score:
        identifier: Game.settings.identifier()
        score: @get('points')
    ).success(callback)