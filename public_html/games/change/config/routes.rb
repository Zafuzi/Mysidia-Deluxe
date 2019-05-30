Change::Application.routes.draw do

  get 'highscores', to: 'scores#highscores'
  post 'score', to: 'scores#add_score', as: 'add_score'

  get '*path', to: 'application#root'
  root to: 'application#root'
end
