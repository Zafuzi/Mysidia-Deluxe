<?php

class NewsView extends View{
    
    public function index(){
    
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
            $document->setTitle("<center>News</center>");
			$mysidia->db->update("users", array("news_notify" => ('0')), "username = '{$mysidia->user->username}'");
            $document->add(new Comment("<center><img src='http://i66.tinypic.com/1z6urnm.jpg'></center>"));
    
            $allnews = $this->getField("allnews")->get();
            $count = $allnews->rowCount();
            $pagesTotal = ceil($count/2);
            $document->add(new Comment("<script type='text/javascript' src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>
            <script>            
                     var current = 1;
                 var max = current * 2;
                 var min = 1;
                     
            $(document).ready(function(){
                
                $('fieldset+br').hide();
                $('[name^=news]').hide();
                
                for(var i = min; i <= max; i++)
                  {
                      $('[name=news' + i +']').show();
                      $('[name=news' + i +']+br').show();
                  }     
                  
                  $('span[id^=page]').click(function(){
                      current = $(this).html();
                      max = current * 2;
                      oldMax = (current - 1) * 2;
                    
                      min = oldMax + 1;
                  
                      $('fieldset+br').hide();
                      $('[name^=news]').hide();
                      
                  for(var i = min; i <= max; i++)
                  {
                      $('[name=news' + i +']').show();
                      $('[name=news' + i +']+br').show();
                  } 
                  
                      
                  });
                });
            </script>"));
            $document->add(new Comment("<span class='pages'><center>"));
            for($page = 1; $page <= $pagesTotal; $page++)
            {
                $document->add(new Comment("<span id='page{$page}' class='page'>{$page}</span> | ",FALSE));              
            }
            
            
            $document->add(new Comment("</center></span><br><div id='news' class='news'>"));
            $index = 0;
            while($news = $allnews->fetchColumn())
            {
                $newsObj = new News($news);
                $index++;
                $newsField = new Fieldset("news$index");
                  $comments = $newsObj->getCommentNumber();
                $newsField->add(new Comment("<span class='date'>Date: {$newsObj->getDate()}</span><br>",FALSE));
                $newsField->add(new Comment("<span class='title'>{$newsObj->getTitle()}</span>",FALSE));
                $newsField->add(new Comment("<span class='author'>by <a href='/profile/view/{$newsObj->getUserObject()->getUsername()}' target='_blank'>{$newsObj->getUserObject()->getUsername()}</a></span>",FALSE));
                $newsField->add(new Comment("<span class='comment'><a href='/news/view/{$newsObj->getID()}'>Comments({$comments})</a></span><br>",FALSE));
                $newsField->add(new Comment("<span class='content'><img class='authorimg' src='{$newsObj->getUserObject()->getprofile()->getavatar()}'>{$newsObj->getContent()}</span>",FALSE));
                
                $document->add($newsField);
            }
            
            $document->add(new Comment('</div>'));    
    }
    
    public function view(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $news = $this->getField("news");
        ($news->getPosted() == "yes")? $newsState = " ":$newsState = "(draft)";
        $newsName = $news->getTitle();
        $newsContent = $news->getContent();
        $newsAuthor = $news->getUserObject()->getUsername();
        $newsDate = $news->getDate();
        $newsComments = $news->getComments();
        $document->setTitle("news");
        
        $document->add(new Comment("<div id='news' class='news'>"));
        $newsField = new Fieldset("news");
        $newsField->add(new Comment("<span class='date'>Date: {$newsDate}</span><br>",FALSE));
            $newsField->add(new Comment("<span class='title'>{$newsName}{$newsState}</span>",FALSE));
            $newsField->add(new Comment("<span class='author'>by <a href='/profile/view/{$newsAuthor}' target='_blank'>{$newsAuthor}</a></span>",FALSE));
            $newsField->add(new Comment("<span class='content'><p><img class='authorimg' src='{$news->getUserObject()->getprofile()->getavatar()}'>{$newsContent}<p></span>",FALSE));
        $document->add($newsField);
        $document->add(new Comment("<h1>comments</h1>",FALSE));
        
        if($mysidia->input->post("submit")){
            $todayDate = new DateTime;
            $date = $todayDate->format('Y-m-d H:i:s');
            $content = $mysidia->input->post("commentcontent");
            $user = $mysidia->user->uid;
            $newsID = $news->getID();
            
            $news->addComment($content,$date,$user);
			
					//send the administrator (Ittermat) a notice that this news comment has been added to
					$pm = new PrivateMessage(); // Send the winner a pm
						$pm->setsender('Ittermat');
						$pm->setrecipient('Ittermat');
						$pm->setmessage("Comment In News", "You have a new comment in your news. <a href='/news/view/{$newsID}'>CLICK HERE</a> to see the news post.");  
						$pm->post(); 
			
            $document->add(new Comment("<b>Successfully added comment.</b>",FALSE));
            
        }
        
        $newsComments = $this->getField("news")->getComments();
        if($newsComments->rowCount() != 0){
        while($commentID = $newsComments->fetchColumn()){
            $comment = new NewsComments($commentID);
            $commentField = new Fieldset("comment{$comment->getID()}");
            $commentField->add(new Comment("<span class='cdate'>Date: {$comment->getDate()}</span><br>",FALSE));
            $commentField->add(new Comment("<span class='cauthor'>by <a href='https://atrocity.mysidiahost.com/profile/view/{$comment->getUserObject()->getUsername()}' target='_blank'>{$comment->getUserObject()->getUsername()}</a></span>",FALSE));
            $commentField->add(new Comment("<span class='ccontent'><p><img src='{$comment->getUserObject()->getprofile()->getavatar()}'>{$comment->getContent()}<p></span>",FALSE));
            $document->add($commentField);
        }
        }
        else{
            $document->add(new Comment("No comments yet."));
        }
        
        if($news->getAllowComment() == "yes"){
        $commentForm = new Form("comment","","post");
        $commentForm->add(new TextArea("commentcontent", "", 4, 50));
        $commentForm->add(new Button("Submit","submit","submit"));
        $document->add($commentForm);
        $document->add(new Comment('</div>'));
        }
        else{
            $document->add(new Comment("<b>This page doesn't allow any more comments.</b>"));
        }
    }

    
}
?>