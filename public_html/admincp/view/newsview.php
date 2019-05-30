<?php

use Resource\Native\String;
use Resource\Collection\LinkedList;
use Resource\Collection\LinkedHashMap;

class ACPNewsView extends View{
    
    private $editor;
    
    public function index(){
        //parent::index();
        $mysidia = Registry::get("mysidia");
        $document = $this->document;    
        $document->setTitle("Manage News And Comments");
        
        $pagesTable = new TableBuilder("news");
        $pagesTable->setAlign(new Align("center", "middle"));
        
        $pagesTable->buildHeaders("News Title", "Author", "Date", "Edit", "Publish/Save", "Delete", "View Comments", "View News");
        
        $allnews = $this->getField("news")->get();
        
        if($mysidia->input->post("submit")){
            $id = $mysidia->input->post("submit");
            $newsObj = new News($id);
            $newsObj->saveDraft();
            $document->add(new Comment("<b>Successfully saved news as draft</b>",TRUE));            
        }
        
        if($mysidia->input->post("submit1")){
            $id = $mysidia->input->post("submit1");
            $newsObj = new News($id);
            $newsObj->post();
            $document->add(new Comment("<b>Successfully added and published news.</b>",TRUE));
        }
        
        if($mysidia->input->post("submit2")){
            $id = $mysidia->input->post("submit2");
            $newsObj = new News($id);
            $document->add(new Comment("Are you sure you wish to delete this news?",TRUE));
            $form = new Form("title","","post");
            $form->add(new Button("Yes","submit5",$id));
            $document->add($form);        
            
        }
        if($mysidia->input->post("submit5")){
            $id = $mysidia->input->post("submit5");
            $mysidia->db->delete("news","id = {$id}");
            $document->add(new Comment("Successfully deleted news",TRUE));
            $allnews = $mysidia->db->select("news",array("id"),"");
        }
            
        while($news = $allnews->fetchColumn()){
            $newsObj = new News($news);
            $cells = new LinkedList;
            ($newsObj->getPosted() == "yes")? $draft = "":$draft = "(draft)";
            $title = "{$newsObj->getTitle()} {$draft}";
            $cells->add(new TCell($title));
            $cells->add(new TCell($newsObj->getUserObject()->getUsername()));
            $cells->add(new TCell($newsObj->getDate()));
            $cells->add(new TCell(new Link("admincp/news/edit/{$news}","Edit")));
            
            $form = new Form("title","","post");
            $form->add(new Button("Save As Draft","submit",$news));
            $form2 = new Form("title","","post");
            $form2->add(new Button("Publish","submit1",$news));
            $form3 = new Form("title","","post");
            $form3->add(new Button("Delete","submit2",$news));
                    
            ($newsObj->getPosted() == "yes")? $cells->add(new TCell($form)) : $cells->add(new TCell($form2));
            $cells->add(new TCell($form3));
            $cells->add(new TCell(new Link("admincp/news/viewcomments/{$news}","View Comments")));
            $cells->add(new TCell(new Link("news/view/{$news}","View News On Site")));
            $pagesTable->buildRow($cells);    
        }
        
        $document->add($pagesTable);
        $document->add(new Comment("<a href='/admincp/news/create'>Create</a>",TRUE));
       
    }
    
    public function viewcomments(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle("editing comments");
        $news = $this->getField("news");
        
        $newsComments = $news->getComments();
        
        
        $pagesTable = new TableBuilder("news");
        $pagesTable->setAlign(new Align("center", "middle"));
        
        $pagesTable->buildHeaders("Author", "Date", "Content", "Edit", "Delete");
        
        if($mysidia->input->post("submit")){
            $document->add(new Comment("Are you sure you wish to delete this comment?",FALSE));
            $id = $mysidia->input->post("submit");
            $form = new Form("title","","post");
            $form->add(new Button("Yes","submit2",$id));
            $document->add($form);

        }
                    
        if($mysidia->input->post("submit2")){
                $id = $mysidia->input->post("submit2");
                //echo $id;
                $mysidia->db->delete("newscomments","id = {$id}");
                $document->add(new Comment("<b>Comment deleted successfully.</b>",FALSE));
                $news = $this->getField("news2");
                $newsComments = $news->getComments();
        }
            
        while($newsID = $newsComments->fetchColumn()){
            try{
                $newsComment = new NewsComments($newsID);
                $cells = new LinkedList;
                $cells->add(new TCell($newsComment->getUserObject()->getUsername()));
                $cells->add(new TCell($newsComment->getDate()));
                $cells->add(new TCell($newsComment->getContent()));
                $cells->add(new TCell(new Link("admincp/news/editcomment/{$newsComment->getID()}","Edit")));
                $form = new Form("form","","post");
                $form->add(new Button("Delete","submit",$newsID));
                $cells->add(new TCell($form));
                $pagesTable->buildRow($cells);
            }
            catch(NoPermissionException $e){
                
            }
            
        }
        
        $document->add($pagesTable);
    }
    
    public function editcomment(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle("editing comments");
        $newsComment = $this->getField("newscomments");
        $editor = $this->getField("editor")->get();
        
        if($mysidia->input->post("submit")){
                $newsComment->setContent($mysidia->input->post("commentcontent"));
                $document->add(new Comment("<b>Edited news comment successfully. Text displayed is the old one.<br></b>",FALSE));
                $newsComment = $this->getField("newscomments");
                $editor = $this->getField("editor")->get();
        }
        
        $document->add(new Comment("Author: {$newsComment->getUserObject()->getUsername()} / Date: {$newsComment->getDate()}",FALSE));
        $form = new Form("form","","post");
        
        $form->add(new Comment($editor,FALSE));
        $form->add(new Button("Submit","submit","submit"));
        $document->add($form);
    }
    
    public function edit(){    
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle("Edit");
        
        
            $news = $this->getField("news");                    
            if($mysidia->input->post("submit")){
            
            ($mysidia->input->post("allowcomments"))?$allow = "yes":$allow = "no";
            
            $news->editTitle($mysidia->input->post("newstitle"));
            $news->editContent($this->format($mysidia->input->post("pagecontent")));
            $news->changeAllowComment($allow);
            
            if($mysidia->input->post("submit") == "submitDraft"){
                $news->saveDraft();
            }
            
            else{
                $news->post();
            }
            $document->add(new Comment("<b>Successfully changed news.</b>"));
        }
        
        $editor = $this->getField("editor")->get()->editor("pagecontent", $this->format($news->getContent()));
        $form = new Form("title","","post");
        $form->add(new Comment("<b>Date</b>:{$news->getDate()} and <b>Author</b>: {$news->getUserObject()->getUsername()} and <b>Published</b>: {$news->getPosted()}"));
        $form->add(new Comment("<b>Title</b>:"));
        $form->add(new TextField("newstitle",$news->getTitle()));
        $form->add(new Comment("<b>Contents</b>:"));
        $form->add(new Comment($editor));
        $comments = new CheckBox("Allow comments on this news", "allowcomments", 1, "array");
        if($news->getAllowComment() == "yes")
            $comments->setChecked("allowcomments");
        $comments2 = new CheckBox("Send message to all users notifying about the existence of an update", "allowmessage", 2, "array");
        $form->add($comments);
        $form->add($comments2);
        $form->add(new Button("Save as draft","submit","submitDraft"));
        $form->add(new Button("Publish","submit","submitPublish"));
        $document->add($form);
        
    
    }
    
    public function create(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;
        $document->setTitle("Create");
        
        if($mysidia->input->post("submit")){
            $todayDate = new DateTime;
            $date = $todayDate->format('Y-m-d H:i:s');
        
            ($mysidia->input->post("allowcomments"))?$allow = "yes":$allow = "no";
                
            
            if($mysidia->input->post("submit") == "submitDraft"){
                            
            $mysidia->db->insert("news",array("title" => $mysidia->input->post("newstitle"), "content" => $this->format($mysidia->input->post("pagecontent")), "user" => $mysidia->user->uid, "date" => $date, "posted" => "no","allowcomment" => $allow));
            }
            
            else{
                            
            $mysidia->db->insert("news",array("title" => $mysidia->input->post("newstitle"), "content" => $this->format($mysidia->input->post("pagecontent")), "user" => $mysidia->user->uid, "date" => $date, "posted" => "yes","allowcomment" => $allow));
            
                if($mysidia->input->post("allowmessage")){
                    //$mysidia->db->insert("");
                }
            }
            $document->add(new Comment("<b>Successfully changed news. Fill this page again to create a new post. Click <a href='/news' target='_blank'>here</a> to see the news page.</b>"));
        }
        $todayDate = new DateTime;
        $date = $todayDate->format('Y-m-d');
        $editor = $this->getField("editor")->get();
        $form = new Form("title","","post");
        $form->add(new Comment("<b>Date</b>:{$date} and <b>Author</b>: {$mysidia->user->username} and <b>Published</b>: No"));
        $form->add(new Comment("<b>Title</b>:"));
        $form->add(new TextField("newstitle",""));
        $form->add(new Comment("<b>Contents</b>:"));
        $form->add(new Comment($editor));
        $comments = new CheckBox("Allow comments on this news", "allowcomments", 1, "array");
        $comments2 = new CheckBox("Send message to all users notifying about the existence of an update", "allowmessage", 2, "array");
        $form->add($comments);
        $form->add($comments2);
        $form->add(new Button("Save as draft","submit","submitDraft"));
        $form->add(new Button("Publish","submit","submitPublish"));
        $document->add($form);
    }
    
        private function format($text){
         $text = html_entity_decode($text);
         $text = stripslashes($text);
         return $text;
    }
}
?>