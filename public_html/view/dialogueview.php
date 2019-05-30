 <?php
class DialogueView extends View{   
 
    public function index(){ 
        $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
        $document->setTitle("Talk to Eyre");        
    $random = mt_rand (1,100); 

    if($random <= 100 && $random > 40){  //60% chance
            $document->add(new Comment("<center><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ie24acb54a03f1b67/version/1486187151/image.png'><br>''The strange cat turns to look at you and simply tells you to <a href=http://atrocity.mysidiahost.com/pages/view/cemetary2/> Go away!''</a><br>")); 
        } 
    elseif($random <= 40 && $random > 20){ //20% chance
    $either_or = rand(1,2);
        if($either_or == 1){
                      $document->add(new Comment("<center><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ia3116b37d4e45443/version/1486187178/image.png'><br>''The strange cat turns to look at you..but ignores you completely...and after a few minutes of completely awkward silence you decide to <a href=http://atrocity.mysidiahost.com/pages/view/cemetary2/> Just leave.''</a><br>"));
        }
        else{ 
                $document->add(new Comment("<center><img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/iba0cbd66fa6b10e8/version/1486187195/image.png'><br>''The only response you seem to get from the strange cat is his claws in your face!!! YEOWCH! <a href=http://atrocity.mysidiahost.com/pages/view/cemetary2/> You decide to Just leave.</a>''<br>")); 
        } 
           
        }  
    elseif($random <= 20 && $random > 1){ //20% chance
    $introForm = new FormBuilder("introform", "/dialogue/eyre", "post");
                   $introForm->buildButton("Talk!", "submit", "submit"); #text inside button, id/name, value 
                $document->add($introForm);
         
                
}
    }
    
    public function eyre(){
    $mysidia = Registry::get("mysidia"); 
        $document = $this->document; 
        $document->setTitle("Talk to Eyre");
        if($mysidia->input->post("submit")){
            $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i2cd8f5223630b41e/version/1424205227/image.png'><br>''What do you want idiot...? Cant you see Im busy???''<br>")); 
                $talkForm2 = new FormBuilder("talkform2", "/dialogue/eyre", "post"); 
                $talkForm2->buildButton("''What are you Doing here?''", "action2", "submit"); #text inside button, id/name, value 
                $document->add($talkForm2);
                $talkForm3 = new FormBuilder("talkform3", "/dialogue/eyre", "post");
                   $talkForm3->buildButton("''Are you all by yourself?''", "action3", "submit"); #text inside button, id/name, value 
                $document->add($talkForm3);                 
        }
        elseif($mysidia->input->post("action2")){
            $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ie8707e247cb7b40c/version/1424205517/image.png'><br>''I'm visiting a grave idiot...what does it look like?''"));  
                $talkForm4 = new FormBuilder("talkform4", "/dialogue/eyre", "post"); 
                $talkForm4->buildButton("''Was She someone important?''", "action4", "submit"); #text inside button, id/name, value 
                $document->add($talkForm4);     
        return;}
        
        elseif($mysidia->input->post("action3")){
            $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i3c6b1dd2b4aed423/version/1486187311/image.png'><br>''No, moron...I'm not by myself...''"));  
                $talkForm6 = new FormBuilder("talkform6", "/dialogue/eyre", "post"); 
                $talkForm6->buildButton("''Oh..Sorry, you looked so sad sitting there all alone..''", "action6", "submit"); #text inside button, id/name, value 
                $document->add($talkForm6);     
                $talkForm7 = new FormBuilder("talkform7", "/dialogue/eyre", "post"); 
                $talkForm7->buildButton("<a href='http://atrocity.mysidiahost.com/pages/view/cemetary2/'>''my bad, I'll just leave now...''</a>", "action7", "submit"); #text inside button, id/name, value 
                $document->add($talkForm7);     
        return;}
        
        elseif($mysidia->input->post("action4")){
    $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i12b4bf828a8457ca/version/1486187284/image.png'><br>''That's NONE of your business!!<br> Now <a href='http://atrocity.mysidiahost.com/pages/view/cemetary2/'>GO AWAY!!!''</a><p>"));    
        return;
        }
         
        elseif($mysidia->input->post("action6")){
            $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i3c6b1dd2b4aed423/version/1486187311/image.png'><br>''I already told you...Im NOT by myself! and even if I was- I dont care!''"));  
                $talkForm8 = new FormBuilder("talkform8", "/dialogue/eyre", "post"); 
                $talkForm8->buildButton("''Don't you have any friends?''", "action10", "submit"); #text inside button, id/name, value 
                $document->add($talkForm8);     
                $talkForm9 = new FormBuilder("talkform9", "/dialogue/eyre", "post"); 
                $talkForm9->buildButton("''Can I sit with you for a while?''", "action9", "submit"); #text inside button, id/name, value 
                $document->add($talkForm9);     
        return;
        } 
        
        elseif($mysidia->input->post("action9")){
                $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i12b4bf828a8457ca/version/1486187284/image.png'><br>''That's NONE of your business!!<br> Now <a href='http://atrocity.mysidiahost.com/pages/view/cemetary2/'>GO AWAY!!!''</a><p>"));     
        return;
        } 
         
        elseif($mysidia->input->post("action10")){
            $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ie79007d330f114ce/version/1424206170/image.png'><br>''Friends?? What are those?? If you mean those I tolerate than thats a different story...''"));  
                $talkForm11 = new FormBuilder("talkform13", "/dialogue/eyre", "post"); 
                $talkForm11->buildButton("''So you have people you tolerate?''", "action11", "submit"); #text inside button, id/name, value 
                $document->add($talkForm11);     
                     
        return;
        } 
        
        elseif($mysidia->input->post("action11")){
            $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/ie79007d330f114ce/version/1424206170/image.png'><br>''They aren't people I tolerate, they're bakeneko!''"));  
                $talkForm12 = new FormBuilder("talkform12", "/dialogue/eyre", "post"); 
                $talkForm12->buildButton("''Can I meet them?''", "action12", "submit"); #text inside button, id/name, value 
                $document->add($talkForm12);     
                     
        return;}
        
        elseif($mysidia->input->post("action12")){
            $document->add(new Comment("<img src='https://image.jimcdn.com/app/cms/image/transf/none/path/s954f60e9238b8421/image/i1c2f03ae671bb140/version/1486273299/image.png'><br>''Yea, why not?? I'll take you to them... but not all of them are as nice as me!''"));  
                $talkForm13 = new FormBuilder("talkform13", "/dialogue/eyre", "post"); 
                $talkForm13->buildButton("<a href='http://atrocity.mysidiahost.com/pages/view/Bakenekoshrinefront'>''I'll follow you!''</a>", "action15", "submit"); #text inside button, id/name, value 
                $document->add($talkForm13);
        return;
        }
        else{
            $document->add(new Comment("Hey! You're not allowed to access this page!")); 
        }
    }
}
?> 