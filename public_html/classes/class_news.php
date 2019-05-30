<?php

use Resource\Native\Obj;
use Resource\Native\Arrays;

class News extends Obj {


    private $id;
    private $user;
    private $title;
    private $content;
    private $date;
    private $posted;
    private $comments;
    private $allowcomment;

     public function __construct($id){
         $mysidia = Registry::get("mysidia");
         $whereClause = "id = '{$id}'";
         $row = $mysidia->db->select("news",array(),$whereClause)->fetchObject();
         if(!is_object($row)) throw new NoPermissionException("News doesn't exist");
         foreach($row as $key => $val){
                    $this->$key = $val;              
            }
            $this->comments = $mysidia->db->select("newscomments",array("id"),"newsID = {$this->id} ORDER BY date,id");    
        }
        
        public function getID(){
            return $this->id;
    }
    
    public function getUser(){
        return $this->user;
    }
    
    public function getUserObject(){
        $mysidia = Registry::get("mysidia");
        $user = new Member($this->user);
        return $user;
    }
    public function getTitle(){
        return $this->title;
    }
    
    public function getContent(){
        return $this->content;
    }
    
    public function getDate(){
        return $this->date;
    }
    
    public function getPosted(){
        return $this->posted;
    }
    
    public function getAllowComment(){
        return $this->allowcomment;
    }
    
    public function changeAllowComment($allow){
        $mysidia = Registry::get("mysidia");
        if($this->allowcomment != $allow){
            $this->allowcomment = $allow;
            $mysidia->db->update("news",array("allowcomment" => $this->allowcomment),"id = {$this->id}");
        }
        
    }
    
    public function addComment($content,$date,$user){
        $mysidia = Registry::get("mysidia");		
        $mysidia->db->insert("newscomments",array("comment" => $this->format($content), "date" => $date, "userID" => $user, "newsID" => $this->id));
        $this->comments = $mysidia->db->select("newscomments",array("id"),"newsID = {$this->id} ORDER BY date,id");
    }
    
    private function format($text){
             $text = html_entity_decode($text);
             $text = stripslashes($text);
             return $text;
        }
    
    public function saveDraft(){
        $mysidia = Registry::get("mysidia");
        $todayDate = $this->todayDate();
        if($this->date != $todayDate) $this->newDate($todayDate);
        $this->posted = "no";
        $mysidia->db->update("news",array("posted" => $this->posted),"id = {$this->id}");
    }
    
    public function post(){
        $mysidia = Registry::get("mysidia");
        $todayDate = $this->todayDate();
        if($this->date != $todayDate) $this->newDate($todayDate);
        $this->posted = "yes";
        $mysidia->db->update("news",array("posted" => $this->posted),"id = {$this->id}");
    }
        
        public function editContent($content){
            $mysidia = Registry::get("mysidia");
            $this->content = $content;
            $mysidia->db->update("news",array("content" => $this->content),"id = {$this->id}");
        }
        
        public function editTitle($title){
             $mysidia = Registry::get("mysidia");
            $this->title = $title;
            $mysidia->db->update("news",array("title" => $this->title),"id = {$this->id}");
        }
        
        public function todayDate(){
            $dateTime = new DateTime;
            $date = $dateTime->format('Y-m-d H:i:s');
            return $date;
        }
        public function newDate($date){
            $mysidia = Registry::get("mysidia");
            $this->date = $date;
            $mysidia->db->update("news",array("date" => $this->date),"id = {$this->id}");
        }
        
        public function getCommentNumber(){
            $count = $this->comments->rowCount();
            return $count;
        }
        
        public function getComments(){
            return $this->comments;
        }
        
}

?>