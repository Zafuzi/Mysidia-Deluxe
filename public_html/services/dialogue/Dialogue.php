<?php
namespace services\dialogue;

class Dialogue {
	
	public $conversation = [
		'intro' => [
			'img'=> 'https://image.jimcdn.com/app/cms/image/transf/dimension=337x1024:format=png/path/s954f60e9238b8421/image/ife6a461459318896/version/1425591940/image.png',
			'text'=>'You decide to approach the strange cat- He just stares at you for a moment before you decide to ask anything.<br/>
    			<br/>
    			Some of the cats are actually rather nice in a way...<br/>',
    		'options' => ['part two'=>'<span class="player_talk">~"What are you doing?"</span>']
			],
		'part two' => [
			'img' => 'https://image.jimcdn.com/app/cms/image/transf/dimension=337x1024:format=png/path/s954f60e9238b8421/image/ibf080c8c9b60dbf0/version/1425592054/image.png',
			'text' => '<span class="hoshi_talk">"I\'m watching the exit of the maze..."</span>',
			'options' => ['part three' => '<span class="player_talk">~"Maze?"</span>'],
		],
		'part three' => [
			'img' => 'https://image.jimcdn.com/app/cms/image/transf/dimension=337x1024:format=png/path/s954f60e9238b8421/image/i570b2ee143d95924/version/1425592123/image.png'
			'text' => '<span class="hoshi_talk">"Oh yes... there\'s a rather hard Maze back there...Poor sod went in weeks ago..and still hasn\'t come out..."</span>',
			'options' => ['part four' => '<span class="player_talk">~"...shouldnt you go get them?"</span>'],
		],
		'part four' => [
			'img' => 'https://image.jimcdn.com/app/cms/image/transf/dimension=337x1024:format=png/path/s954f60e9238b8421/image/i47b789f921ee807d/version/1425592275/image.png',
			'text' => '<span class="hoshi_talk">"Why would I do that?... Hes the one who decided to go in there...Makes him NOT here..."</span><br><br>
				<span class="player_talk">~"...oh..."</span><br><br>
				You cant help but be curious....A maze?? Might be fun...',
			'options' => ['part five' => '<span class="player_talk">~"Can I go in?"</span>']
		],
		'step' => [
			'img' => '',
			'text' => '',
			'options' => []
		],
	];
}