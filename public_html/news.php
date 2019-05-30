<?php

use Resource\Native\String;
use Resource\Native\Float;
use Resource\Collection\ArrayList;

class NewsController extends AppController{

    public function __construct(){
        parent::__construct("member");    
    }
    
    public function index(){
    
        $mysidia = Registry::get("mysidia");
        $allnews = $mysidia->db->select("news",array("id"),"posted = 'yes' ORDER BY date DESC");
        $count = $allnews->rowCount();
        if($count == 0) throw new NoPermissionException("There are currently no news to display.");
        $this->setField("allnews",new DatabaseStatement($allnews));        

    }
    
    public function view(){
        $mysidia = Registry::get("mysidia");
        $pageURL = 'http';
         if (isset($_SERVER['HTTPS']) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         $pageURL .= "://";
         if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
          }
         
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
        $news = new News($id);
        
        if($news->getPosted() == "no")
        {
            if($mysidia->usergroup->getpermission("canmanagecontent") != "yes")//rootadmins, admins and artists
            {
                throw new NoPermissionException("This message doesn't exist or isn't yet viewable.");
            }
        }
        
        /*include_once("inc/ckeditor/ckeditor.php");     
        $editor = new CKEditor;    
            $editor->basePath = '../../inc/ckeditor/';
            $editor2 = $editor->editor("commentcontent", "Write here");
            $this->setField("editor",new DataObject($editor2));*/
            
            if($mysidia->input->post("submit")){
                if(!$mysidia->input->post("commentcontent"))
                    throw new BlankFieldException("No content or content has an invalid character.");
                if($mysidia->usergroup->getpermission("canadopt") != "yes")
                    throw new NoPermissionException("No permission");
                if($news->getPosted() == "no")
                    throw new NoPermissionException("Can't post comments to drafts.");
                if($this->commentAlreadyExists($mysidia->input->post("commentcontent"),$id))
                    throw new NoPermissionException("Oops, seems like you tried to post the same comment.");
                if($news->getAllowComment() == "no")
                    throw new NoPermissionException("No comments allowed on this news post.");
            }  
            
            $news = new News($id);     
            $this->setField("news",$news);

    }
    
    private function commentAlreadyExists($comment, $newsID){
        $mysidia = Registry::get("mysidia");
        $count = $mysidia->db->select("newscomments",array("id"),"comment = '{$comment}' and newsID = '{$newsID}' LIMIT 1")->rowCount();
        return ($count > 0);
    }
    
}