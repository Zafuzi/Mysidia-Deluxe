<?php

include 'Fish.php';

class ExploreforestlakeView extends View{

	
	// The display text for the page.
	protected $lang = [
		'page_title' => 'Fishing in the Forest Lake',
		'area_description' => null,
		'would_you_like_to_fish' => 'Would you like to go fishing here?',
		'area_img' => 'http://i67.tinypic.com/1zxb4fk.jpg',
		'previous_area' => '<a href="/pages/view/Forestlake"><b>Go back to the Forest?</a></b>',
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
	private $bait = 'Worm bait';
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
		80  => ['Green goldfish', '/picuploads/png/ea0c2e09ddabdb09219dc51327eda1c6.png'],
		83  => ['Salmon', '/picuploads/png/1d582df0254184cfa7db4355d0f88456.png'],
		88  => ['Perch', '/picuploads/png/3b10be95eb860ceef037e1ec48032bd8.png'],
		92  => ['Tetra', '/picuploads/png/3a2bd74fe67aaf339aca053295a05fe3.png'],
		96  => ['Tilapia', '/picuploads/png/381485713a62701c02d9542270840c5f.png'],	
		100 => ['Trout', '/picuploads/png/64e477dc4e5f6bd8d067ca0069f383c6.png'],
		111 => ['Eel', '/picuploads/png/31cd0b3000b5c97920ca5b24c11c209b.png'],
		113 => ['Green angelfish', '/picuploads/png/055dfbad2fc20f9436fb07c4f4377037.png'],
		115 => ['Green and blue guppy', '/picuploads/png/e54874ea8a2b03d12da45f53621b4b6d.png'],
		117 => ['Green and magenta guppy', '/picuploads/png/e7a43df0325b27724e313928683b2ff4.png'],
		119 => ['Red lobster', '/picuploads/png/97cbb6c7b48e66c68a415d2e3a6bbcdc.png'],
		125 => ['Green betta fish', '/picuploads/png/879a6fc1961eb7d8e504e6579c267fed.png'],
		131 => ['Green koi', '/picuploads/png/95d261007e6933e5c9e0e098af07199a.png'],
		139 => ['Green tetra', '/picuploads/png/4181c20e206d7c27063ebd322aeae903.png']
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