# Unit of denomination (1¢, 5¢, 10¢, 25¢, 50¢, 1$, 5$, 10$)
Game.DENOMINATIONS = [1, 5, 10, 25, 100, 500, 1000]
Game.dollar = 100
Game.isBill = (denomination) -> denomination >= Game.dollar
