class ScoresController < ApplicationController

  def add_score
    score_model = Score.create(score_params)
    render json: serialize_result(score_model)
  end

  def highscores
    @scores = Score.highest
  end

  private

  def score_params
    params.require(:score).permit(:identifier, :score)
  end

  def serialize_result(score_model)
    {
        your:{
            score: score_model.score,
            index: score_model.index_of
        },
        best:{
            score: Score.best.score
        }
    }
  end
end
