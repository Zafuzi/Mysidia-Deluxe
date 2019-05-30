Number::toMoneyString = (withSymbol = true) ->
  s = (@/100).toFixed(2)
  s = "$" + s if withSymbol
  s