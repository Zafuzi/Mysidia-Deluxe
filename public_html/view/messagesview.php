<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class MessagesView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;
	    $document->setTitle($this->lang->access_title);
        $document->addLangvar($this->lang->access, TRUE);
		
		$total = $mysidia->user->getallpms();
		$pages = new Pagination($total, 9, "messages");
        $pages->setPage($mysidia->input->get("page"));	
		
		$in_messages = $mysidia->db->select("messages", array(), "touser='{$mysidia->user->username}' ORDER BY id DESC LIMIT {$pages->getLimit()},{$pages->getRowsperPage()}");
		
		//layout change!	
		$document->add(new Comment("<center>"));
		$document->add(new Comment("<a href='/messages/newpm'><img src='/picuploads/mail/newmessage1.png'></a> <a href='/messages/draft'><img src='/picuploads/mail/editldrafttbutton.png'></a> <a href='/messages/outbox'><img src='/picuploads/mail/sentmail1.png'></a>"));
		$document->add(new Comment("<style>
		.mail-container {
			background-image: url('/picuploads/mail/mailbg1.png');
			background-size: cover;
			background-repeat: none;
			width: 716px;
			height:366px;
			text-align:center;
			vertical-align: middle;
			line-height:40px;
		}
		</style>"));
		$document->add(new Comment("
		<div class='mail-container'>"));
		while ($inbox = $in_messages->fetchObject()){
			if($inbox->status == "read"){
				$document->add(new Comment("<div style='background-image: url(/picuploads/mail/mailpin1read.png);
display: inline-block; width: 180px!important; height: 90px!important;background-size: cover;background-repeat: none;font-size:10px;'><a href='messages/delete/{$inbox->id}' style='color:#ad0000;'><b>X</b></a><a href='messages/read/{$inbox->id}'>
			<span style='float:left; line-height:15px; margin-top:15px; margin-left:15px;overflow:auto;'>From: {$inbox->fromuser}</span></br>
			<span style='line-height:15px;'>To: {$inbox->touser}</br>{$inbox->messagetitle}</span>
			</a></div>", FALSE));
			}
			else{
				$document->add(new Comment("<div style='background-image: url(/picuploads/mail/mailpin1unread.png);
display: inline-block; width: 180px!important; height: 90px!important;background-size: cover;background-repeat: none;font-size:10px;'><a href='messages/delete/{$inbox->id}' style='color:#ad0000;'><b>X</b></a><a href='messages/read/{$inbox->id}'>
			<span style='float:left; line-height:15px; margin-top:15px; margin-left:15px;overflow:auto;'>From: {$inbox->fromuser}</span></br>
			<span style='line-height:15px;'>To: {$inbox->touser}</br>{$inbox->messagetitle}</span>
			</a></div>", FALSE));
}
		}
		$document->add(new Comment("</div>"));
		$document->add(new Comment("</center>"));
		//layout changes end here.
		
		$stmt = $this->getField("stmt")->get();
		$pagination = $this->getField("pagination");
		if($stmt->rowCount() == 0){
		    $document->addLangvar($this->lang->read_empty);
		    return;
		}
		$document->addLangvar($pages->showPage());
	}
	
	public function read(){
		$mysidia = Registry::get("mysidia");
		$message = $this->getField("message");		
		$document = $this->document;
		$document->setTitle($mysidia->lang->read_title.$this->message->fromuser);
		$document->add($message->getMessage());	
	}
	
	public function newpm(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		
	    if($mysidia->input->post("submit")){
			$document->setTitle($mysidia->lang->global_action_complete);
			if($mysidia->input->post("draft") == "yes") $document->addLangvar($this->lang->draft_sent);
			elseif($mysidia->input->post("draftedit") == "yes") $document->addLangvar($this->lang->draft_edited);
			else{
				$document->setTitle($this->lang->sent_title);
				$document->addLangvar($this->lang->sent);
			}
			return;
		}
		
	    $document->setTitle($mysidia->lang->send_title);
		$document->addLangvar($mysidia->lang->send);		
$message = new PrivateMessage; 
// CHANGES START HERE

$title = "(no subject)"; // this way it'll never be blank
if($mysidia->input->get("id")){ // if there's an get value
    $where = trim($mysidia->input->get("id")); // trim the value
     if (!ctype_digit($where)) { // if its not numeric only
        $user = $where; // create a message to this user
    } else if (ctype_digit($where)){ // if it IS numeric only then it's a reply, so pull data        
        $oldMessage = new PrivateMessage($where); 
        $js = "<script>$('.content h2').text('Reply To Message');</script>"; // optional
        $user = $oldMessage->fromuser;            
        $title = "RE: ".$oldMessage->messagetitle;    
        $msg = "› {$user} wrote: ".$oldMessage->messagetext;
    }
}

// CHANGES END HERE
$editor = $message->getEditor();  	
		
        $pmForm = new Form("pmform", "", "post");		
		$pmForm->add(new Comment("Message Recipient: ", FALSE));
		$pmForm->add(new TextField("recipient", $user, 50));
		$pmForm->add(new Comment("Message Title: ", FALSE));
		$pmForm->add(new TextField("mtitle", $title, 50));
		$pmForm->add(new Comment("Message Text: ", FALSE));
		$pmForm->add(new Comment($editor->editor("mtext", $msg)));
		$pmForm->add(new CheckBox("Send a Copy to Outbox", "outbox", "yes"));
		$pmForm->add(new CheckBox("Save as Draft", "draft", "yes"));
		$pmForm->add(new Button("Send PM", "submit", "submit"));
		$document->add($pmForm);
	}
	
	public function delete(){
		$document = $this->document;
		$document->setTitle($this->lang->delete_title);
        $document->addLangvar($this->lang->delete);
	}
	
	public function outbox(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
	    $document->setTitle($mysidia->user->username.$this->lang->outbox_title);
        $document->addLangvar($this->lang->outbox);
		
		$pages = new Pagination($total, 9, "messages/outbox");
        $pages->setPage($mysidia->input->get("page"));	
		
		$out_messages = $mysidia->db->select("folders_messages", array(), "fromuser='{$mysidia->user->username}' AND folder='outbox' ORDER BY mid DESC LIMIT {$pages->getLimit()},{$pages->getRowsperPage()}");
		
        $pagination = $this->getField("pagination");
		
		//layout change!	
		$document->add(new Comment("<center>"));
		$document->add(new Comment("<a href='/messages'><img src='/picuploads/mail/backtomessages1.png'></a>"));
		$document->add(new Comment("<style>
		.mail-container {
			background-image: url('/picuploads/mail/mailbg1.png');
			background-size: cover;
			background-repeat: none;
			width: 716px;
			height:366px;
			text-align:center;
			vertical-align: middle;
			line-height:40px;
		}
		</style>"));
		$document->add(new Comment("
		<div class='mail-container'>"));
		while ($outbox = $out_messages->fetchObject()){
			if($outbox->status == "read"){
				$document->add(new Comment("<div style='background-image: url(/picuploads/mail/mailpin1read.png);
display: inline-block; width: 180px!important; height: 90px!important;background-size: cover;background-repeat: none;font-size:10px;'><a href='/messages/outboxdelete/{$outbox->mid}' style='color:#ad0000;'><b>X</b></a><a href='/messages/outboxread/{$outbox->mid}'>
			<span style='float:left; line-height:15px; margin-top:15px; margin-left:15px;overflow:auto;'>From: {$outbox->fromuser}</span></br>
			<span style='line-height:15px;'>To: {$outbox->touser}</br>{$outbox->messagetitle}</span>
			</a></div>", FALSE));
			}
			else{
				$document->add(new Comment("<div style='background-image: url(/picuploads/mail/mailpin1unread.png);
display: inline-block; width: 180px!important; height: 90px!important;background-size: cover;background-repeat: none;font-size:10px;'><a href='/messages/outboxdelete/{$outbox->mid}' style='color:#ad0000;'><b>X</b></a><a href='/messages/outboxread/{$outbox->mid}'>
			<span style='float:left; line-height:15px; margin-top:15px; margin-left:15px;overflow:auto;'>From: {$outbox->fromuser}</span></br>
			<span style='line-height:15px;'>To: {$outbox->touser}</br>{$outbox->messagetitle}</span>
			</a></div>", FALSE));
}
		}
		$document->add(new Comment("</div>"));
		$document->add(new Comment("</center>"));
		//layout changes end here.
		
		
		$document->addLangvar($pages->showPage());
	}
	
	public function outboxread(){
		$document = $this->document;
		$message = $this->getField("message");
	    $document->setTitle($this->lang->read_title.$message->fromuser);  
		$document->add($message->getMessage());
	}
	
	public function outboxdelete(){
		$document = $this->document;
		$document->setTitle($this->lang->delete_title);
        $document->addLangvar($this->lang->delete);
	}
	
	public function draft(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
	    $document->setTitle($mysidia->user->username.$this->lang->draft_title);
        $document->addLangvar($this->lang->draft);		   		   
		   
		$pagination = $this->getField("pagination");
		
		$pages = new Pagination($total, 9, "messages/draft");
        $pages->setPage($mysidia->input->get("page"));	
		
		$draft_messages = $mysidia->db->select("folders_messages", array(), "fromuser='{$mysidia->user->username}' AND folder='draft' ORDER BY mid DESC LIMIT {$pages->getLimit()},{$pages->getRowsperPage()}");
		
		//layout change!	
		$document->add(new Comment("<center>"));
		$document->add(new Comment("<a href='/messages'><img src='/picuploads/mail/backtomessages1.png'></a>"));
		$document->add(new Comment("<style>
		.mail-container {
			background-image: url('/picuploads/mail/mailbg1.png');
			background-size: cover;
			background-repeat: none;
			width: 716px;
			height:366px;
			text-align:center;
			vertical-align: middle;
			line-height:40px;
		}
		</style>"));
		$document->add(new Comment("
		<div class='mail-container'>"));
		while ($drafts = $draft_messages->fetchObject()){
				$document->add(new Comment("<div style='background-image: url(/picuploads/mail/mailpin1draft.png);
display: inline-block; width: 180px!important; height: 90px!important;background-size: cover;background-repeat: none;font-size:10px;'><a href='/messages/draftdelete/{$drafts->mid}' style='color:#ad0000;'><b>X</b></a><a href='/messages/draftedit/{$drafts->mid}'>
			<span style='float:left; line-height:15px; margin-top:15px; margin-left:15px;overflow:auto;'>From: {$drafts->fromuser}</span></br>
			<span style='line-height:15px;'>To: {$drafts->touser}</br>{$drafts->messagetitle}</span>
			</a></div>", FALSE));
		}
		$document->add(new Comment("</div>"));
		$document->add(new Comment("</center>"));
		//layout changes end here.
		
		
		$document->addLangvar($pages->showPage());
	}
	
	public function draftedit(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;		
		$document->setTitle($this->lang->draft_edit_title.$mysidia->user->username);
		$document->addLangvar($this->lang->draft_edit);		
		$message = $this->getField("message");
		$editor = $message->getEditor();		
        $draftForm = new Form("pmform", "../newpm", "post");
		
		$draftForm->add(new Comment("Message Recipient: ", FALSE));
		$draftForm->add(new TextField("recipient", $message->touser, 50));
		$draftForm->add(new Comment("Message Title: ", FALSE));
		$draftForm->add(new TextField("mtitle", $message->messagetitle, 25));
		$draftForm->add(new Comment("Message Text: ", FALSE));
		$draftForm->add(new Comment($editor->editor("mtext", $message->format($message->messagetext))));
		$draftForm->add(new CheckBox("Send a Copy to Outbox", "outbox", "yes"));
		$draftForm->add(new CheckBox("Save as Draft", "draft", "yes"));
		$draftForm->add(new PasswordField("hidden", "draftid", $message->mid));
		$draftForm->add(new Button("Send PM", "submit", "submit"));
		$document->add($draftForm);
	}
	
	public function draftdelete(){
		$document = $this->document;
		$document->setTitle($this->lang->delete_title);
        $document->addLangvar($this->lang->delete);
	}
	
	    public function report(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
        if($mysidia->input->post("submit")){        
            $document->setTitle($this->lang->reported_title);
            $document->addLangvar($this->lang->reported);
            return;
        }                
        $message = $this->getField("message");
        $admin = $this->getField("admin");
        
        $reportForm = new Form("reportform", "", "post");
        $reportForm->add(new Comment("<b>Report To:</b> ", FALSE));
        $reportForm->add(new TextField("recipient", $admin->username)); 
        $reportForm->add(new Comment("<b>Reason:</b> ", FALSE));
        $reportForm->add(new TextField("reason", "Spam", 50));
        $reportForm->add(new PasswordField("hidden", "mfrom", $message->fromuser));  
        $reportForm->add(new PasswordField("hidden", "mtitle", $this->format($message->messagetitle)));
        $reportForm->add(new PasswordField("hidden", "mtext", $this->format($message->messagetext)));
        $reportForm->add(new Button("Report", "submit", "submit"));    
        
        $document->setTitle($this->lang->report_title);
        $document->addLangvar($this->lang->report);
        $document->add($reportForm); 
    }

    public function format($text){
        $text = html_entity_decode($text);
        $text = stripslashes($text);
        $text = str_replace("&nbsp;"," ",$text);
        $text = str_replace("'","'",$text);
        return $text;
    }  
}
?>