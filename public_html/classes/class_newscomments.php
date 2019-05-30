<?php

use Resource\Native\Obj;
use Resource\Native\Arrays;

class NewsComments extends Obj {


    private $id;
    private $userID;
    private $newsID;
    private $comment;
    private $date;

     public function __construct($id){
         $mysidia = Registry::get("mysidia");
         $whereClause = "id = '{$id}'";
         $row = $mysidia->db->select("newscomments",array(),$whereClause)->fetchObject();
         if(!is_object($row)) throw new NoPermissionException("News comment doesn't exist");
         foreach($row as $key => $val){
                    $this->$key = $val;              
            }    
        }
        
        public function getID(){
            return $this->id;
    }
    
    public function getUser(){
        return $this->userID;
    }
    
    public function getUserObject(){
        $mysidia = Registry::get("mysidia");
        $user = new Member($this->userID);
        return $user;
    }
    
    public function getNews(){
        return $this->newsID;
    }
    
    public function getNewsObject(){
        $mysidia = Registry::get("mysidia");
        $news = new News($this->newsID);
        return $news;
    }
    
    public function getContent(){
        return $this->comment;
    }
    
    public function getDate(){
        return $this->date;
    }
        
        public function todayDate(){
            $dateTime = new DateTime;
            $date = $dateTime->format('Y-m-d H:i:s');
            return $date;
        }    
        
        public function setContent($content){
            $mysidia = Registry::get("mysidia");
            $this->content = $content;
            $mysidia->db->update("newscomments",array("comment" => $this->content),"id = {$this->id}");
        }
        

}

?>