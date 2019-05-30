<?php
class readbottleView extends View{
	public function index(){
	    $mysidia = Registry::get("mysidia");
     $document = $this->document; 
            $document->setTitle("<center>Read a message in a bottle</center>");   
              $document->add(new Comment("<b><center><a href='http://atrocity.mysidiahost.com/pages/view/thebeach'>Return to the Beach?</a> Or <a href='http://atrocity.mysidiahost.com/readbottle'>Read another message?</a></b></center>"));
$item = "Message in a bottle"; 
$hasitem = $mysidia->db->select("inventory", array("quantity"), "itemname ='{$item}' and owner='{$mysidia->user->username}'")->fetchColumn(); 
if($hasitem > 0){ 
        $document->add(new Comment("<b><center>Image of Ida here<img src='http://atrocity.mysidiahost.com/picuploads/png/b84db85b8a8230c0e225d5f36e5e8b78.png'></b></center>"));
    $document->add(new Comment("<b><center>Ida Opened your<img src='http://atrocity.mysidiahost.com/picuploads/png/5f24e1ce89e10e7a3bfab1c0f884fbd5.png'> {$item}!</b></center>"));
    $qty = 1; 
    $item = new PrivateItem($item, $mysidia->user->username); 
    $item->remove($qty, $mysidia->user->username);
}
else{
         $document->add(new Comment("<b><center>Image of Ida here<img src='http://atrocity.mysidiahost.com/picuploads/png/b84db85b8a8230c0e225d5f36e5e8b78.png'></b></center>"));
    $document->add(new Comment("<b><center>You don't have a <img src='http://atrocity.mysidiahost.com/picuploads/png/5f24e1ce89e10e7a3bfab1c0f884fbd5.png'> {$item}! Come back when you find one!</b><p>
    <a href='http://atrocity.mysidiahost.com/pages/view/thebeach'>Return to the Beach?</a></p></center>"));
    return;
{
$document->add(new Comment ("<center>
   <!DOCTYPE html>
<html>
<head>
	<title>Message</title>
  <link href='https://fonts.googleapis.com/css?family=Indie+Flower|Slabo+27px' rel='stylesheet'> 
  <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/skeleton/2.0.4/skeleton.min.css'>
</head>
<body>
  <div id='quote-box'>
    
  </div>
  
  <footer class='footer'>~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~</footer>
  </center></body>
</html>
<script>$(document).ready(function(){
  <script src='index.js'/>
  const quoteArr = [
  ['Live for a cause, not for applause, live life to express, not to impress, dont make your presense noticed, just make your absense felt.', 'Unknown'],
  ['Our greatest glory is not in never falling, but in rising every time we fall..', 'Confucious.'], 
  ['All our dreams can come true, if we have the courage to pursue them.','Walt Disney'], 
  ['It does not matter how slowly you go as long as you do not stop.', 'Confucious'], 
  ['Talent is a flame, Genius is a fire.', 'Bernard Williams'], 
['Genius is patience.', 'Isaac Newton'], 
  ['Making money is art and working is art and good business is the best art.', 'Andy Warhol'], 
  ['Everything youve ever wanted is on the other side of fear. .', 'George Addair'], 
  ['Success is not final, failure is not fatal: it is the courage to continue that counts..', 'Winston Churchill'],
  ['Hardships often prepare ordinary people for an extraordinary destiny. ..', 'C.S Lewis'],

  ['Believe in yourself. You are braver than you think, more talented than you know, and capable of more than you imagine..', 'Roy T. Bennett'],
  [' learned that courage was not the absence of fear, but the triumph over it. The brave man is not he who does not feel afraid, but he who conquers that fear...', 'Nelson Mandela'],
  ['There is only one thing that makes a dream impossible to achieve: the fear of failure...', 'Paulo Coelho'],
  ['Believe in yourself, take on your challenges, dig deep within yourself to conquer fears. Never let anyone bring you down. You got to keep going. ..', 'Chantal Sutherland'],
  ['Definiteness of purpose is the starting point of all achievement. ..', ' W. Clement Stone'],
  ['Too many of us are not living our dreams because we are living our fears...', ' Les Brown'],
  ['If you believe it will work out, you’ll see opportunities. If you believe it won’t, you will see obstacles...', 'Wayne Dyer'],
  ['Success means doing the best we can with what we have. Success is the doing, not the getting; in the trying, not the triumph. Success is a personal standard, reaching for the highest that is in us, becoming all that we can be..', ' Zig Ziglar'],
  ['If you set goals and go after them with all the determination you can muster, your gifts will take you places that will amaze you...', 'Les Brown'],
  ['Believe you can and you’re halfway there.. ..', 'Theodore Roosevelt'],
  ['Your mind is a powerful thing. When you fill it with positive thoughts, your life will start to change...', 'Unknown'],
  ['Don’t be pushed around by the fears in your mind. Be led by the dreams in your heart.  ..', 'Roy T. Bennett'],
  ['Strength doesn’t come from what you can do. It comes from overcoming the things you once thought you couldn’t. ..', ' Rikki Rogers'],
  ['Limitations live only in our minds. But if we use our imaginations, our possibilities become limitless. . ..', '—Jamie Paolinetti'],
  ['We may encounter many defeats but we must not be defeated.. ..', 'Maya Angelou'],
  ['Be so happy that when others look at you they become happy to. ..', 'Unkown'],
  ['The two most important days in your life are the day you are born and the day you find out why. –..', 'Mark Twain'],
];

const CurrentQuote = (props) => {
  return (
    <div>
      <h3 id='text'>{props.text}</h3>
      <h5 id='author'>{props.author}</h5>
    </div>
  )
};

 
class Quotes extends React.Component {
constructor(props){
  super(props);
  this.state = {
    
    author: '',
    
  }
  
}

 const index = Math.floor(Math.random() * quoteArr.length);
 this.setState({
   text: quoteArr[index][0],
   author: quoteArr[index][1],
    });
};

    
  render(){
    return (
      <div>
        <div>
          <CurrentQuote text={this.state.text} author={this.state.author}/>
          </div>
      
        <
          a 
           > 
        </a>
      </div>
    )

ReactDOM.render(<Quotes/>, document.getElementById('quote-box'))



    </center>

  });</script>")); 

}
}

<style>
body{
  margin: 0;
  padding: 0;
  background-image: url('https://previews.123rf.com/images/gl0ck33/gl0ck331208/gl0ck33120800007/14709094-old-parchment-paper-scroll.jpg');
}

#quote-box {
  background: white;
  opacity: .9;
  padding: 2rem 1rem 2rem;
  width: 60%;
  height: auto;
  margin: 5rem auto;
  border-radius: 2rem;
  text-align: center;
}

/*  {
  padding: 3rem;
} */

#text {
  font-family: 'Indie Flower', cursive;
}

#author {
  font-family: 'Slabo 27px', serif;
}

.footer{
  position: fixed;
  color: white;
  bottom: 0;
  width: 100%;
  text-align: center;
  background: black;
  opacity: .7;
  </style>
}

        }

    ?>