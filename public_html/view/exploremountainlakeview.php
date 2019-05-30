<?php

include 'Fish.php';

class ExploremountainlakeView extends View{

	
	// The display text for the page.
	protected $lang = [
	'page_title' => 'Fishing in the mountain Lake',
	'area_description' => null,
	'would_you_like_to_fish' => 'Would you like to go fishing here?',
	'area_img' => 'http://i65.tinypic.com/2e4ak4p.jpg',
	'previous_area' => '<a href="/pages/view/forestmountain2/"><b>Go back to the mountain?</a></b>',
	'equipment_error' => 'Woah there! You need a pole and bait to fish!',
	'out_of_turns' => 'It seems you have fished too much today, why don\'t you take a rest until tomorrow?',
	'failure' => 'You didn\'t catch anything. Better luck next time.',
	'success' => 'Oh look! You caught a ',
	'success_end' => '!',
	'adopt_caught' => 'Oh look! You caught a ',
	'adopt_caught_end' => 'egg!',
	'adopt_request' => 'Would you like to keep it?',
	'adopt_not_found' => 'Sorry, it got away.',
	'adopt_adopted' => 'Enjoy your new pet!',
	'cash' => 'Oh look! You found ',
	'cash_end' => ' cash!',
	'continue_fishing' => '<b>Continue Fishing?</b>',
	];

	// Bait & pole for the area
	private $bait = 'Rock Worm bait';
	private $pole = 'Fishing pole';

	// Amount of bait used per attempt;
	private $numBaitUsed = 1;

	private $failure_chance = 8;

	// from previous number to this number is a catch => ['Name of Prize', 'Image URL', 'if is an adopt then rarity'],
	// The rarity is the only thing that determines if this is an item or adopt!
	private $prizes = [
	20  => ['Bass', '/picuploads/png/2879896ec53a9ca6f0fe008ed741fcf9.png'],
	39  => ['Catfish', '/picuploads/png/c7c6b8aecbedb50364a4a1f337465205.png'],
	58  => ['Minnow', '/picuploads/png/97c91ea1a9b860bd200ed64613075c28.png'],
	67  => ['Goldfish', '/picuploads/png/c9ba65aaf86106d7dcad0ee866bfe9b5.png'],
	80  => ['Red goldfish', '/picuploads/png/30a47e833cff80e07ab124575857497e.png'],
	83  => ['Salmon', '/picuploads/png/1d582df0254184cfa7db4355d0f88456.png'],
	88  => ['Perch', '/picuploads/png/3b10be95eb860ceef037e1ec48032bd8.png'],
	92  => ['Tetra', '/picuploads/png/3a2bd74fe67aaf339aca053295a05fe3.png'],
	96  => ['Tilapia', '/picuploads/png/381485713a62701c02d9542270840c5f.png'],	
	100 => ['Trout', '/picuploads/png/64e477dc4e5f6bd8d067ca0069f383c6.png'],
	111 => ['Eel', '/picuploads/png/31cd0b3000b5c97920ca5b24c11c209b.png'],
	113 => ['Pink and blue betta', '/picuploads/png/61e5513f8f3633bdaa1e83c59201f92d.png'],
	115 => ['Koi', '/picuploads/png/21f89d053a521cbf79d1d05cc1483c22.png'],
	117 => ['Red koi', '/picuploads/png/f7e413516147c67e0cb747c17e2a18a2.png'],
	119 => ['Red lobster', '/picuploads/png/97cbb6c7b48e66c68a415d2e3a6bbcdc.png'],
	123 => ['Angel fish', '/picuploads/png/12ff6e2cdd07200d9b3ea54b3292126b.png'],
	126 => ['Red Betta', '/picuploads/png/f480293ae5703e783cc19fad62a01c35.png'],
	129 => ['Guppy', '/picuploads/png/2e4a3b5f9f127c7b523eae8c3da3651e.png'],
	132 => ['Purple tetra', '/picuploads/png/0df68a3590c07c5f29671489f821bd83.png'],
	136 => ['Salmon angelfish', '/picuploads/png/1a0d42b2867fb634795109979df7dfe8.png'],
	140 => ['Salmon Tetra', '/picuploads/png/03e814e2bc2ef2c41755917d9a510c15.png'],
	144 => ['Tan Guppy', '/picuploads/png/8880025bfca0e53ab5284e89118192fa.png'],
	149=> ['Tan Tetra', '/picuploads/png/4204339a35e19008d0c54f8ce91ddf7e.png'],
	153 => ['Walleye ', '/picuploads/png/21cade4cebcd98258585f30b0f33ce36.png'],
	156 => ['Yellow angelfish', '/picuploads/png/98a378add5def0b7ab4a63d7c3a0bb10.png'],
	161 => ['Yellow Betta fish ', '/picuploads/png/a8f962e8f465bae65e659a42c3c6dcb2.png'],
	165 => ['Yellow perch', '/picuploads/png/c473c280effb68c81a879a947ae50a8f.png'],
	190 => ['Blue and green betta', '/picuploads/png/cdd1352d557b66719c38cfe84d4aaab1.png'],
	210 => ['Rock betta ', '/picuploads/png/5ba0094170a43f8b6f5ffdb3ec56f79c.png'],
	230 => ['Rock lobster', '/picuploads/png/7554511a10196cdef8354492cb331fba.png'],
	];

	private $cash_prize = ['minAmount' => 5, 'maxAmount' => 20, 'chance' => 9];
	// For no cash prize possibility:
	// private $cash_prize = false;

	// The max number of fishing attempts.
	private $maxExploreTimes = 20;

	public function index()
	{
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$document->setTitle($this->lang['page_title']);
		
		if (!is_null($this->lang['area_description'])){
			$document->add(new Comment($this->lang['area_description']));
		}
		$document->add(new Comment($this->lang['previous_area']));
		$document->add(new Comment('<a href="'.$_SERVER['REQUEST_URI'].'/fish">'));
		$document->add(new Comment('<b>'.$this->lang['would_you_like_to_fish'].'</b></a>'));
		$document->add(new Comment("<img src='{$this->lang['area_img']}''>"));
	}
	
	public function fish(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$fish = new Fish($mysidia, $document, [
			'failure_chance' => $this->failure_chance,
			'pole' => $this->pole,
			'bait' => $this->bait,
			'numBaitUsed' => $this->numBaitUsed,
			'prizes' 	 => $this->prizes, 
			'cash_prize' => $this->cash_prize,
			'lang' => $this->lang,
			'maxExploreTimes' => $this->maxExploreTimes
			]);

		return;
	}
}