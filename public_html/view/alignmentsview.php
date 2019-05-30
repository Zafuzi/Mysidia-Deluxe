 <?php
class AlignmentsView extends View{

    public function index(){
      
        $mysidia = Registry::get("mysidia");
		$uid = $mysidia->user->uid;
		$alignment = $mysidia->db->select("users", array("alignment"), "uid = '$uid'")->fetchColumn();
        $document = $this->document;        
        $document->setTitle("<center>Choose your alignment!</center>");
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		    $choice = $_REQUEST['fb'];
			switch ($choice){
				case "light":
					$group = "Light Dragon";
					break;
				case "dark":
					$group = "Dark Ghost";
					break;
				case "collector":
					$group = "Brave Collector";
					break;
				case "knowledge":
					$group = "Knowledge Seeker";
					break;
			}
				$document->add(new Comment("<center>You have joined the <b>{$group}</b> alignment! <a href='/alignments'>Go back?</a></center>"));
				$mysidia->db->update("users", array("alignment" => $choice), "uid = '$uid'");
				// get the current time, and create the message text
				$thetime = date("jS M, g:i");
				$message = "<b>{$thetime}</b> - {$mysidia->user->username} joined the {$group} alignment!";
				// add the notification to table
				$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'pets', "mtext" => $message ));	
				return;
		}
		
		
		$document->add(new Comment("
		<center>
		<p><b>You can only choose one alignment.</b> If you want to get it changed you need to contact an admin!</p>
		<p>Please note that whatever alignment you choose is only for fun! Joining a bad alignment doesn't make you a bad person, just like choosing a good alignment doesn't make you better than anyone else. It's only meant to be an addition to immersement, and a fun way to add some competition to the game. <b>Alignments don't exempt you from the site rules</b>, so you still must follow them!</p>
		</center>"));
		
		$document->add(new Comment("<style>
		label > input{ /* HIDE RADIO */
  visibility: hidden; /* Makes input not-clickable */
  position: absolute; /* Remove input from document flow */
}
label > input + img{ /* IMAGE STYLES */
  cursor:pointer;
  border:2px solid transparent;
}
label > input:checked + img{ /* (RADIO CHECKED) IMAGE STYLES */
  border:5px solid #666666;
}

.grid-container {
  display: grid;
  grid-template-columns: auto auto auto auto;
  padding: 10px;
}
.grid-item {
  font-size: 30px;
  text-align: center;
}
		</style>"));
		
		
		if($alignment == "none"){ //if the user isn't in a group, let them choose one! Otherwise, all they can do is hover.
			$document->add(new Comment("
		
		<form action='alignments' method='post'>
<div class='grid-container'>
  <div class='grid-item'>
    <label>
      <input type='radio' name='fb' value='light' />
      <img rel='tooltip' title='<em>You are wise, caring and giving, you
 always put others first- and have no
problems stopping to help someone in
need- The shirt off your back you will
gladly give, and for your compassion
you can soar high as though you had
wings. You dream big, you love deeply,
and you are a light in a dark room.</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/lightdragon1.png'>
    </label>
  </div>
  <div class='grid-item'>
    <label>
      <input type='radio' name='fb' value='dark'/>
      <img rel='tooltip' title='<em>Like a shadow sneaking about,
  you live for the darkness in others hearts,
  and you do all you can to bring it out-
  always wanting to snuff out the light you will
  do whatever it takes to make others miserable-
  You steal cheat and lie, and you have no
  remorse...the only thing you care about
  is making others as miserable as you are.</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/garkalignment1.png'>
    </label>
  </div>
  <div class='grid-item'>
    <label>
      <input id='fb3' type='radio' name='fb' value='collector' />
      <img rel='tooltip' title='<em>Never willing to cause confrontation,
your main goal is to save, collect, gather,
and find what you can to keep what you
can...like a sort of packrat you look for
what you feel you must have...one of
everything, and more of everything else....
you will go through any lengths to retrieve
these things, face any danger necessary,
and travel any distance to make sure your
collection is complete. You are the king of your
own created kingdom.</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/collectorrat1.png'>
    </label>
  </div>
  <div class='grid-item'>
    <label>
      <input id='fb4' type='radio' name='fb' value='knowledge' />
      <img rel='tooltip' title='<em>You seek the ultimate truths, the ultimate
knowledge and ultimate wisdom, you will go
as far as needed to collect intelligence, stories..
.folk tales, words. Puzzles are easy for you,
and you do not back down from a challenge..
.in fact its not a challenge-
Its a special experience
. you will never falter in your goal to
figure out the knowledge of the world...
Or better yet? the universe..</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/knowledgeowl1.png'>
    </label>
  </div>
  <div class='grid-item'>Light Dragon</div>
  <div class='grid-item'>Dark Ghost</div>
  <div class='grid-item'>Brave Collector</div>
  <div class='grid-item'>Knowledge Seeker</div>
</div>

<p style='float:right;'><button type='submit' value='submitbutton'>Pick this alignment!</button></p>
</form>
		"));
		}
		else{
			
			$document->add(new Comment("		
		<form action='alignments' method='post'>
<div class='grid-container'>
  <div class='grid-item'>
      <img rel='tooltip' title='<em>You are wise, caring and giving, you
 always put others first- and have no
problems stopping to help someone in
need- The shirt off your back you will
gladly give, and for your compassion
you can soar high as though you had
wings. You dream big, you love deeply,
and you are a light in a dark room.</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/lightdragon1.png'>
  </div>
  <div class='grid-item'>
      <img rel='tooltip' title='<em>Like a shadow sneaking about,
  you live for the darkness in others hearts,
  and you do all you can to bring it out-
  always wanting to snuff out the light you will
  do whatever it takes to make others miserable-
  You steal cheat and lie, and you have no
  remorse...the only thing you care about
  is making others as miserable as you are.</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/garkalignment1.png'>
  </div>
  <div class='grid-item'>
      <img rel='tooltip' title='<em>Never willing to cause confrontation,
your main goal is to save, collect, gather,
and find what you can to keep what you
can...like a sort of packrat you look for
what you feel you must have...one of
everything, and more of everything else....
you will go through any lengths to retrieve
these things, face any danger necessary,
and travel any distance to make sure your
collection is complete. You are the king of your
own created kingdom.</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/collectorrat1.png'>
  </div>
  <div class='grid-item'>
      <img rel='tooltip' title='<em>You seek the ultimate truths, the ultimate
knowledge and ultimate wisdom, you will go
as far as needed to collect intelligence, stories..
.folk tales, words. Puzzles are easy for you,
and you do not back down from a challenge..
.in fact its not a challenge-
Its a special experience
. you will never falter in your goal to
figure out the knowledge of the world...
Or better yet? the universe..</em>' src='http://atrocity.mysidiahost.com/picuploads/alignments/knowledgeowl1.png'>
  </div>
  <div class='grid-item'>Light Dragon</div>
  <div class='grid-item'>Dark Ghost</div>
  <div class='grid-item'>Brave Collector</div>
  <div class='grid-item'>Knowledge Seeker</div>
</div>
</form>
		"));
			
		}
		
    }
}
?>