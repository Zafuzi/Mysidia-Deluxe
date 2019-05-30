<?php

class eyrechatview extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
        	$document->setTitle("Chatting with Eyre");   

			$document->add(new Comment(" 
        <script src='Twineexplore/twine.js'></script> 
		<script src='Twineexplore/Twine.css'></script> 
    <tw-story></tw-story>

		<tw-storydata name='Eyre chat' startnode='1' creator='Twine' creator-version='2.2.1' ifid='B7EC61F9-7A22-4A3A-8A92-2801B3B37F78' zoom='1' format='Harlowe' format-version='2.1.0' options='' hidden><style role='stylesheet' id='twine-user-stylesheet' type='text/twine-css'>
			tw-sidebar tw-icon.redo {
				display: none;
			}
			tw-sidebar tw-icon.undo {
				display: none;
			}
		</style>
		<script role='script' id='twine-user-script' type='text/twine-javascript'></script>
		
		<tw-passagedata pid='1' name='Approach Eyre' tags='' position='0,200' size='100,100'>
			<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/iad1af6f15c66c811/version/1523541598/image.png'>
			(link-goto: \"<b><u>~Approach the strange cat~</b></u>\", (either:  \"Eyre Attack\", \"Eyre Ignore\", \"Eyre Angry\", \"Eyre Answers\", \"Eyre attack\", \"Eyre ignores\", \"Eyre Attack\", \"Eyre Ignores\", \"Eyre Angry\" ))
		</tw-passagedata>
		<tw-passagedata pid='2' name='Eyre Ignore' tags='' position='0,0' size='100,100'>
		<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ia3116b37d4e45443/version/1486187178/image.png'>
<p>The strange cat turns to look at you..but ignores you completely...and after a few minutes of completely awkward silence you decide to <a title='http://atrocity.mysidiahost.com/pages/view/cemetary2/' href='http://atrocity.mysidiahost.com/pages/view/cemetary2/' target='_blank'>just leave...</a></p></tw-passagedata><tw-passagedata pid='3' name='Eyre Attack' tags='' position='0,96' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/iba0cbd66fa6b10e8/version/1486187195/image.png'>
<p>The only response you seem to get from the strange cat is his claws in your face!!!<br /> <br /> YEOWCH!<br /> <br /> <a title='http://atrocity.mysidiahost.com/pages/view/cemetary2/' href='http://atrocity.mysidiahost.com/pages/view/cemetary2/' target='_blank'>You decide to just leave..</a></p></tw-passagedata><tw-passagedata pid='4' name='Eyre Angry' tags='' position='0,304' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ie24acb54a03f1b67/version/1486187151/image.png'>
<p>The strange cat turns to look at you and simply tells you to <a title='http://atrocity.mysidiahost.com/pages/view/cemetary2/' href='http://atrocity.mysidiahost.com/pages/view/cemetary2/' target='_blank'>Go away!</a></p></tw-passagedata><tw-passagedata pid='5' name='Eyre answers' tags='' position='0,434' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i8b4220fee51bce44/version/1523541803/image.png'>
(color: red)['What do you want idiot? Cant you see Im busy?']

(color: white)[You reply with:]
(color:purple)[
1.[['What are you doing here?'->What are you doing here?]]
2.[['Are you all by yourself?'->Are you all by yourself?]]
3. <a href='http://atrocity.mysidiahost.com/eyrecard'>*Bribe Eyre with a Hanafuda card*</a>]</tw-passagedata><tw-passagedata pid='6' name='What are you doing here?' tags='' position='125,199' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i8b4220fee51bce44/version/1523541803/image.png'>
(color: red)['Im visiting a grave...what does it look like?']

(color: white)[Then you ask if she](color:purple)[ [['Was someone important'->Was someone important]] ]
</tw-passagedata><tw-passagedata pid='7' name='Are you all by yourself?' tags='' position='134,313' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i8b4220fee51bce44/version/1523541803/image.png'>
(color: red)['No moron Im not by myself....']

(color: white)[You respond:]
(color:purple)[
1.[['~Oh...Sorry...You just looked so sad sitting there all alone...'->~Oh...Sorry...You just looked so sad sitting there all alone...]]
2.<a href='http://atrocity.mysidiahost.com/pages/view/cemetary2/'>My bad I&#39;ll just leave now..</a>] </tw-passagedata><tw-passagedata pid='8' name='Was someone important' tags='' position='241,109' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i03f46e664f4f607c/version/1523541763/image.png'>
(color: red)['Thats none of your business! Now <a href=http://atrocity.mysidiahost.com/pages/view/cemetary2/'>go away!'<a>] 
</tw-passagedata><tw-passagedata pid='9' name='~Oh...Sorry...You just looked so sad sitting there all alone...' tags='' position='246,233' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i8b4220fee51bce44/version/1523541803/image.png'>
(color: red)['I already told you...Im NOT by myself! and even if I was- I dont care!']

(color: white)[You reply?:]
(color:purple)[
1.[['Don&#39;t you have any friends?'->~Don&#39;t you have any friends?]]
2.[['Can I sit with you for a while?'->~Can I sit with you for a while?]] ]</tw-passagedata><tw-passagedata pid='10' name='~Don&#39;t you have any friends?' tags='' position='389,249' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/id23acda1bdcbf5b0/version/1523541777/image.png'>
(color: red)['Friends?? What are those?? If you mean those I tolerate than thats a different story...']

(color: white)[You reply?:]
(color:purple)[
1.[['So you have people you tolerate?'->So you have people you tolerate?]]]
</tw-passagedata><tw-passagedata pid='11' name='~Can I sit with you for a while?' tags='' position='384,121' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i03f46e664f4f607c/version/1523541763/image.png'>
(color: red)['No you can&#39;t sit with me!!! now <a href=http://atrocity.mysidiahost.com/pages/view/cemetary2/'>go away!'<a>] 
</tw-passagedata><tw-passagedata pid='12' name='So you have people you tolerate?' tags='' position='494,247' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i44a560383cb1739d/version/1523541790/image.png'>
(color: red)['They arent people I tolerate...they&#39;re Other Bakeneko...']

(color: white)[You reply?:]
(color:purple)[
1.[['Other Bakeneko?? whats a bakeneko?'->Other Bakeneko?? whats a bakeneko?]]
2.[['Can I meet them??'->Can I meet them??]] ]</tw-passagedata><tw-passagedata pid='13' name='Other Bakeneko?? whats a bakeneko?' tags='' position='600,281' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i8b4220fee51bce44/version/1523541803/image.png'>
(color: red)['Are you really THAT Stupid?? We&#39;re Demon cats! EVIL...VERY EVIL!']

(color: white)[You reply?:]
(color:purple)[
1.[['Sounds awesome!! Can I meet them?'->Sounds awesome!! Can I meet them?]]
2.<a href='http://atrocity.mysidiahost.com/pages/view/cemetary2/'> Okay no evil for me- Im going to leave..</a> ]</tw-passagedata><tw-passagedata pid='14' name='Can I meet them??' tags='' position='597,173' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i44a560383cb1739d/version/1523541790/image.png'>
(color: red)['Yea, why not?? I&#39;ll take you to them... but not all of them are as nice as me!']

(color: white)[You reply?:]
(color:purple)[
1.<a href='http://atrocity.mysidiahost.com/pages/view/Bakenekoshrinefront'> Follow Eyre?</a>
2.<a href='http://atrocity.mysidiahost.com/pages/view/Cemetary2'>Run away?</a> ]</tw-passagedata><tw-passagedata pid='15' name='Sounds awesome!! Can I meet them?' tags='' position='714,291' size='100,100'><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i44a560383cb1739d/version/1523541790/image.png'>
(color: red)['Yea, why not?? I&#39;ll take you to them... but not all of them are as nice as me!']

(color: white)[You reply?:]
(color:purple)[
1.<a href='http://atrocity.mysidiahost.com/pages/view/Bakenekoshrinefront'> Follow Eyre?</a>
2.<a href='http://atrocity.mysidiahost.com/pages/view/Cemetary2'>Run away?</a> ]</tw-passagedata></tw-storydata>

        "));

			
			
	}
}
?>
