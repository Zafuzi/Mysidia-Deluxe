<?php

class Mazeview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("Shrine Maze");   

			$document->add(new Comment(" 
        <script src='Twineexplore/twine.js'></script>
		<script src='Twineexplore/Twine.css'></script> 
        <tw-story></tw-story>

		<tw-storydata name='Bakeneko shrine' startnode='1' creator='Twine' creator-version='2.2.1' ifid='50CD8A05-A2AE-4383-A349-0C3663B0C8D1' zoom='1' format='Harlowe' format-version='2.1.0' options='' hidden><style role='stylesheet' id='twine-user-stylesheet' type='text/twine-css'>
		tw-sidebar tw-icon.redo {
			display: none;
		}
		tw-sidebar tw-icon.undo {
			display: none;
		}</style>
		<script role='script' id='twine-user-script' type='text/twine-javascript'></script>
		<tw-passagedata pid='1' name='bMaze 1' tags=''>
			<p>You decide to attempt the maze...And what a maze it is... Its hard to see... hard to tell where anything is... but you do see some small yellow painted arrows in the dirt telling you which way its possible to go....</p>
			<p>You swear you can Hear The cat laugh at you as you decide to take your first steps...</p>
			<img src='http://atrocity.mysidiahost.com/picuploads/jpg/4e41618b0804d1f59112ca933583bf19.jpg' width='600px' height='500px'>
			<b>(link-goto: '~Go forward~', (either:  'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4' ))</b>
		</tw-passagedata>
		<tw-passagedata pid='2' name='bMaze 2' tags=''>
			<img src='/picuploads/jpg/0b7bc163be5df8dd71b7db6d2f3de17a.jpg' width='600px' height='500px'>
			<b>(link-goto: '~Go forward~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4'  ))</b>
		</tw-passagedata>
		<tw-passagedata pid='3' name='bmaze3' tags=''>
			<img src='/picuploads/jpg/b1a16b4986a1995a6b805a4c27ed7fe8.jpg' width='600px' height='500px'>
			<b>(link-goto: '~Go forward~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4' ))   |  (link-goto: '~Go Left~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4',  'bMaze 2', 'bmaze3', 'Bmaze4' ))  |  (link-goto: '~Go right~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4' ))</b>
		</tw-passagedata>
		<tw-passagedata pid='4' name='Bmaze4' tags=''>
			<img src='/picuploads/jpg/431fff8684f797ce73a8d121b4afa003.jpg' width='600px' height='500px'>
			<b type='button'>(link-goto: '~Go forward~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4' ))  |  (link-goto: '~Go right~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bmaze5' ))</b>
		</tw-passagedata>
		<tw-passagedata pid='5' name='bmaze 6' tags=''>
			<img src='/picuploads/jpg/f748424de57ae10274382d62d8bc2c46.jpg' width='600px' height='500px'>
			<a href='http://atrocityextra.jimdo.com/forest/bakenekoshrinemaze/hoshi-goodjob-win/'> You won! Go to Hoshi!</a>
		</tw-passagedata>
		<tw-passagedata pid='6' name='bmaze5' tags=''>
			<img src='/picuploads/jpg/431fff8684f797ce73a8d121b4afa003.jpg' width='600px' height='500px'>
			<b>(link-goto: '~Go forward~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4' ))  |  (link-goto: '~Go right~', (either: 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bMaze 2', 'bmaze3', 'Bmaze4', 'bmaze 6' ))</b>
		</tw-passagedata></tw-storydata>
        "));
		$document->add(new Comment("<p><a href='/pages/view/Shrinesandgarden'> Go back to the shrine sand garden</a></p>"));
	}
}
?>
