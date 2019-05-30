<?php

return [
	'chances' => [
		// The chance of anything happening
    	'effect_chance' => 5,
        // The chance of an item or money being found
        'gift_chance' => 10,
        // Chance of the gift being an item, otherwise it's money
        'item_chance' => 10,
        // If money is found, randomize an amount to give.
        'money_amounts' => ['min'=>100, 'max'=>10000],
	],
	'found item' => 'I found a :item for you!',
	'found money' => 'Found :amount :currency!',
	'sayings' =>
	[
		'What an awesome day!',
		'Hey, did you know you\'re amazing?!',
		'Inner beauty is important!',
		'You look fantastic today!',
		'You\'re the best!!',
		'I love adventure!!',
		'Always look on the bright side of life. Otherwise it will be too dark to read.',
		'The realist sees reality as concrete. The optimist sees reality as clay',
		'It can be said of optimism that while sometimes mistaken, it is never sadly mistaken.',
	],
	'items' =>
	[
		'Worm' => 'ewwww its all wriggly!',
		'Cloverleafs' => 'I picked some Cloverleafs for you! Hope I bring you some luck!',
		'Flowers' => 'I picked some flowers for you.',
		'Fools gold' => 'I bet you werent fooled by this!',
		'Old bottle' => 'I bet the Bakeneko would love this old bottle!',
		'Pearls'  => 'These pearls were soooo shiny! I had to grab them! Even if that old lady didnt want me to!',
		'Plastic bracelet',
		'Rocks',
		'Rope piece',
		'Tin can'  => 'Lets make a phone out of this tin can and talk to each other all the time!',
		'Trash' => 'Im sorry I picked up this trash...but I couldnt resist..',
		'Wood logs',
		'Small Block of Cheese',
		'Ice worm',
		'Ice Cube',
		'Rock worm',
		'Scions casino coin' => 'I bet we could win big if we used it!',
		

	],
];