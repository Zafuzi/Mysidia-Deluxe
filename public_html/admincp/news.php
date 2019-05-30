<?php

class ACPNewsController extends AppController{

    const PARAM = "pageurl";
    private $editor;
    
    public function __construct(){    
        parent::__construct();
        include_once("../inc/ckeditor/ckeditor.php");     
        $mysidia = Registry::get("mysidia");
        $this->editor = new CKEditor;    
        $this->editor->basePath = '../../../inc/ckeditor/';
        if($mysidia->usergroup->getpermission("canmanagecontent") != "yes"){
            throw new NoPermissionException("You do not have permission to manage users.");
        }
    }
    
    public function index(){
        parent::index();
        $mysidia = Registry::get("mysidia");
        $allnews = $mysidia->db->select("news",array("id"),"");
        $this->setField("news",new DatabaseStatement($allnews));
        
    }

    public function viewcomments(){
    $mysidia = Registry::get("mysidia");
    $pageURL = 'http';
         if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         $pageURL .= "://";
         if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
          }
         $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
        
        $news = new News($id);
        $this->setField("news",$news);
        
         
         if($mysidia->input->post("submit2")){
             $news = new News($id);
            $this->setField("news2",$news);
         }

    }
    
    public function editcomment(){
        $mysidia = Registry::get("mysidia");
        $pageURL = 'http';
         if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         $pageURL .= "://";
         if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
          }
         
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
        
        $newsComment = new NewsComments($id);
        $comment = $this->format($newsComment->getContent());
        
        if($mysidia->input->post("submit")){
            if(!$mysidia->input->post("commentcontent"))
                throw new BlankFieldException("No content");
            else
                $comment = $this->format($newsComment->getContent());
        }
                
        $this->setField("newscomments",$newsComment);
        $editor2 = $this->editor->editor("commentcontent",$comment);
        $this->setField("editor",new DataObject($editor2));
        
    }
    
    public function edit(){
        $mysidia = Registry::get("mysidia");
        if($mysidia->input->post("submit")){
            if(!$mysidia->input->post("newstitle")) throw new BlankFieldException("No title");
            if(!$mysidia->input->post("pagecontent")) throw new BlanKFieldException("No content");
            }
            
        $pageURL = 'http';
         if ($_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
         $pageURL .= "://";
         if ($_SERVER["SERVER_PORT"] != "80") {
          $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
         } else {
          $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
          }
         
        $parts = Explode('/', $pageURL);
        $id = $parts[count($parts) - 1];
        
        $news = new News($id);
        $this->setField("news",$news);
        $editor = $this->editor;
        $this->setField("editor",new DataObject($editor));
    }
    
    public function create(){
    $mysidia = Registry::get("mysidia");
        if($mysidia->input->post("submit")){
            if(!$mysidia->input->post("newstitle")) throw new BlankFieldException("No title");
            if(!$mysidia->input->post("pagecontent")) throw new BlanKFieldException("No content");
        }
        
        $editor = $this->editor->editor("pagecontent", "");    
        $this->setField("editor",new DataObject($editor));				$mysidia->db->update("users", array("news_notify" => ('1')));
    }
    
            private function format($text){
         $text = html_entity_decode($text);
         $text = stripslashes($text);
         return $text;
    }
}
?>