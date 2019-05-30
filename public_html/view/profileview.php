<?php

use Resource\Native\String;
use Resource\Collection\LinkedHashMap;

class ProfileView extends View{
	
	public function index(){
		$pagination = $this->getField("pagination");
		$users = $this->getField("users");		
		$document = $this->document;	
		$document->setTitle($this->lang->title);		
        $document->addLangvar($this->lang->memberlist);
		
		$iterator = $users->iterator();
		while($iterator->hasNext()){
		    $entry = $iterator->next();
			$username = (string)$entry->getKey();
			$usergroup = (string)$entry->getValue();
		    if(cancp($usergroup) == "yes") $document->add(new Image("templates/icons/star.gif"));
			$document->add(new Link("profile/view/{$username}", $username, TRUE));
		}
		$document->addLangvar($pagination->showPage());
	}
	
	public function view(){
		$mysidia = Registry::get("mysidia");
		$user = $this->getField("user");
		$profile = $this->getField("profile");
		$current_user = $mysidia->db->select("users_profile", array(), "username='{$mysidia->input->get('user')}'")->fetchObject();
		$current_user_i2 = $mysidia->db->select("users", array(), "username='{$mysidia->input->get('user')}'")->fetchObject();
		$alignment = $current_user_i2->alignment;
		$online_check = $mysidia->db->select("online", array("username"), "username='{$mysidia->input->get('user')}'")->rowCount();
		if($online_check > 0){$online = "<font color='green'>ONLINE</font>";}
		else{$online = "<font color='red'>OFFLINE</font>";}
		if ($current_user->favpet != "0"){
			$favpet = new OwnedAdoptable($current_user->favpet);
		$favpet_image = "<h2>Companion</h2></br><center><a href='/pet/profile/{$current_user->favpet}'><img src='{$favpet->getImage()}' style='height:150px; width:auto;'></a></center>";
		}
		else{
			$favpet_image = "This user doesn't have a companion!";
		}
		
		switch($alignment){
			case "light":
					$group_image = "<h2>Light Dragon</h2></br><center><img src='/picuploads/alignments/lightdragon1.png' style='height:150px; width:auto;'></center>";
					break;
				case "dark":
					$group_image = "<h2>Dark Ghost</h2></br><center><img src='/picuploads/alignments/garkalignment1.png' style='height:150px; width:auto;'></center>";
					break;
				case "collector":
					$group_image = "<h2>Brave Collector</h2></br><center><img src='/picuploads/alignments/collectorrat1.png' style='height:150px; width:auto;'></center>";
					break;
				case "knowledge":
					$group_image = "<h2>Knowledge Seeker</h2></br><center><img src='/picuploads/alignments/knowledgeowl1.png' style='height:150px; width:auto;'></center>";
					break;			
				case "none":
					$group_image = "This user has no alignment yet!</br><a href='/alignments'>View alignments</a></center>";
					break;
		}
		$document = $this->document;
		$document->setTitle($this->lang->profile);
		//main box start!
		$document->add(new Comment("
		<div style='border-radius: 25px; border: 5px solid #7f7f7f; padding: 10px; overflow:auto;'>
		<div style='border-radius: 25px; border: 5px solid #7f7f7f; padding: 10px; float:right;'>{$group_image}</div>
		<div style='border-radius: 25px; border: 5px solid #7f7f7f; padding: 10px; float:right;'>{$favpet_image}</div>
			<img src='{$current_user->avatar}' class='float-left' style='height:100px; width:100px;'>
			<p>
				<b>Status:</b> {$online}</br>
				<b>Member Since:</b> {$current_user_i2->membersince}</br>
				<b>Gender:</b> {$current_user->gender}</br>
				<b>Favorite color:</b> {$current_user->color}</br>
				<b>Nickname:</b> {$current_user->nickname}</br>
				<b>About:</b> {$current_user->bio}</br>
			</p>
			<p>
				<a href='/messages/newpm/{$mysidia->input->get('user')}'>Message</a> | <a href='/trade/offer/{$member->uid}'>Trade</a> | <a href='/friends/request/{$member->uid}'>Become friend!</a>
			</p>
			<hr style='height:5px; background-color: #7f7f7f;'>",false));
			
			$document->add(new Comment('<div id="tabs" class="c-tabs no-js"><div class="c-tabs-nav">',false));
        $document->add(new Comment('<a href="#" class="c-tabs-nav__link outer-nav__link is-active">Pets</a>
            <a href="#" class="c-tabs-nav__link outer-nav__link">Visitor Message</a>
    <a href="#" class="c-tabs-nav__link outer-nav__link">Friends</a>
    <a href="#" class="c-tabs-nav__link outer-nav__link">Contact Info</a>
    <a href="#" class="c-tabs-nav__link outer-nav__link">Trophies</a>
     <a href="#" class="c-tabs-nav__link outer-nav__link">Medals</a>
     <a href="#" class="c-tabs-nav__link outer-nav__link">Collectibles</a>
    </div>',false));

        // Adopts Tab
        $document->add(new Comment('<div class="c-tab outer-tab is-active">
    <div class="c-tab__content">',false));
        if($user->getadopts()) $document->addLangvar($this->lang->noadopts);
        else $profile->display("adopts");
	 
	    // Visitor Message
        $document->add(new Comment('</div></div><div class="c-tab outer-tab">
    <div class="c-tab__content">',false));
		$vmTitle = new Comment($mysidia->input->get("user").$this->lang->VM_member);
		$vmTitle->setBold();
		$vmTitle->setUnderlined();
		$document->add($vmTitle);
	    $profile->display("vmessages");
	 
	    if(!$mysidia->user->isloggedin) $document->addLangvar($this->lang->VM_guest);
	    elseif(!$mysidia->user->status->canvm) $document->addLangvar($this->lang->VM_banned);
	    else{
			$document->addLangvar($this->lang->VM_post);
		    $vmForm = new Form("vmform", "{$mysidia->input->get("user")}", "post");
			$vmForm->add(new PasswordField("hidden", "user", $user->username));
			$vmForm->add(new TextArea("vmtext", "", 4, 50));
			$vmForm->add(new Button("Post Comment", "submit", "submit"));
		    if($mysidia->input->post("vmtext")){
				$reminder = new Paragraph;
				$reminder->add(new Comment("You may now view your conversation with {$user->username} from ", FALSE));
				$reminder->add(new Link("vmessage/view/{$mysidia->input->post("touser")}/{$mysidia->input->post("fromuser")}", "Here"));
				$document->addLangvar($this->lang->VM_complete);
				$document->add($reminder);
			}	
			else $document->add($vmForm);
	    }


	    // Friends
        $document->add(new Comment('</div></div><div class="c-tab outer-tab">
    <div class="c-tab__content">',false));
        $profile->display("friends", $user);

	    // Contact Info	
        $document->add(new Comment('</div></div><div class="c-tab outer-tab">
    <div class="c-tab__content">',false));
	    $user->getcontacts();
	    $user->formatcontacts();
	    $profile->display("contactinfo", $user->contacts);
	    
	    // The last tab: Trophies!	
        $document->add(new Comment('</div></div><div class="c-tab outer-tab">
    <div class="c-tab__content">',false));
        $trophies = $mysidia->db->select("inventory", array(), "owner='{$user->username}' AND category='Trophy'");
        if($trophies == NULL){
            $document->add(new Comment("This user has no Trophies!"));
        }
        else{
            $document->add(new Comment("<center>"));
            while($trophy = $trophies->fetchObject()){
                $trophy_info = $mysidia->db->select("items", array(), "itemname='{$trophy->itemname}'")->fetchObject();
                $document->add(new Comment("<img style='display: inline-table;' src='{$trophy_info->imageurl}' rel='tooltip' title='<em>{$trophy->itemname}</em><hr>{$trophy_info->description}'>", FALSE));
            }
                    $document->add(new Comment('</div></div><div class="c-tab outer-tab">
    <div class="c-tab__content">',false));
        $medals = $mysidia->db->select("inventory", array(), "owner='{$user->username}' AND category='Medal'");
        if($medals == NULL){
            $document->add(new Comment("This user has no Medals!"));
        }
                    else{
            $document->add(new Comment("<center>"));
            while($medal = $medals->fetchObject()){
                $medal_info = $mysidia->db->select("items", array(), "itemname='{$medal->itemname}'")->fetchObject();
                $document->add(new Comment("<img style='display: inline-table;' src='{$medal_info->imageurl}' rel='tooltip' title='<em>{$medal->itemname}</em><hr>{$medal_info->description}'>", FALSE));
            }
                                $document->add(new Comment('</div></div><div class="c-tab outer-tab">
    <div class="c-tab__content">',false));
        $collectibles = $mysidia->db->select("inventory", array(), "owner='{$user->username}' AND category='Collectible'");
        if($collectibles == NULL){
            $document->add(new Comment("This user has no Collectibles!!"));
        }
                    else{
            $document->add(new Comment("<center>"));
            while($collectible = $collectibles->fetchObject()){
                $collectible_info = $mysidia->db->select("items", array(), "itemname='{$collectible->itemname}'")->fetchObject();
                $document->add(new Comment("<img style='display: inline-table;' src='{$collectible_info->imageurl}' rel='tooltip' title='<em>{$collectible->itemname}</em><hr>{$collectible_info->description}'>", FALSE));
            }
            $document->add(new Comment("</center>"));
        }
	    
        $document->add(new Comment('</div></div>
</div>
<script src="/js/otherTabs.js"></script>
<script>
  var myTabs = tabs({
    el: "#tabs",
    tabNavigationLinks: ".outer-nav__link",
    tabContentContainers: ".outer-tab"
  });
  myTabs.init();

  var petTabs = tabs({
                    el: "#pettabs",
                    tabNavigationLinks: ".pet-nav",
                    tabContentContainers: ".pet-tab"
                });

                  petTabs.init();
</script>',false));
			
		$document->add(new Comment('</div>',false));//main box end!
	}
}
	    
	}
	public function diary(){
		$mysidia = Registry::get("mysidia");
		$document = $this->document;
		$user = $this->getField("user");
		$profile = $this->getField("profile");
		$current_user = $mysidia->db->select("users_profile", array(), "username='{$mysidia->input->get('user')}'")->fetchObject();
		$current_user_i2 = $mysidia->db->select("users", array(), "username='{$mysidia->input->get('user')}'")->fetchObject();
		$alignment = $current_user_i2->alignment;
		$document->setTitle("<center>{$current_user_i2->username}'s Diary</center>");
		
		switch($alignment){
			case "light":
					$group_image = "<h2>Light Dragon</h2></br><center><img src='/picuploads/alignments/lightdragon1.png' style='height:150px; width:auto;'></center>";
					break;
				case "dark":
					$group_image = "<h2>Dark Ghost</h2></br><center><img src='/picuploads/alignments/garkalignment1.png' style='height:150px; width:auto;'></center>";
					break;
				case "collector":
					$group_image = "<h2>Brave Collector</h2></br><center><img src='/picuploads/alignments/collectorrat1.png' style='height:150px; width:auto;'></center>";
					break;
				case "knowledge":
					$group_image = "<h2>Knowledge Seeker</h2></br><center><img src='/picuploads/alignments/knowledgeowl1.png' style='height:150px; width:auto;'></center>";
					break;			
				case "none":
					$group_image = "This user has no alignment yet!</br><a href='/alignments'>View alignments</a></center>";
					break;
		}
		
		$document->add(new Comment("
			<h2>User Activity</h2>
			<div style='width:700px;padding:15px;background-color:white;text-align:left;max-height:200px;overflow:auto;'>"));
		$usern = $mysidia->db->select("usernoti", array("mtext"), "userid='{$current_user_i2->uid}' and mtype='user' ORDER BY messageid DESC LIMIT 20");

		while($usermsg = $usern->fetchColumn()){ 
			$n_order++; 
			$document->add(new Comment("<br> {$usermsg}"));
		}		
		$document->add(new Comment("</div><br><br>
			<h2>Pet news</h2>
				<div style='width:700px;padding:15px;background-color:white;text-align:left;max-height:200px;overflow:auto;'>"));
		$petsn = $mysidia->db->select("usernoti", array("mtext"), "userid='{$current_user_i2->uid}' and mtype='pets' ORDER BY messageid DESC LIMIT 20");

		while($petsmsg = $petsn->fetchColumn()){ 
			$n_order++; 
			$document->add(new Comment("<br> {$petsmsg}"));
		}
		$document->add(new Comment(" </div><br><br>
			<h2>Item usage</h2>
			<div style='width:700px;padding:15px;background-color:white;text-align:left;max-height:200px;overflow:auto;'>"));
		$itemn = $mysidia->db->select("usernoti", array("mtext"), "userid='{$current_user_i2->uid}' and mtype='item' ORDER BY messageid DESC LIMIT 20");

		while($itemmsg = $itemn->fetchColumn()){ 
			$n_order++; 
			$document->add(new Comment("<br> {$itemmsg}"));
		}
		$document->add(new Comment(" </div><br><br>
			<h2>Item purchases</h2>
			<div style='width:700px;padding:15px;background-color:white;text-align:left;max-height:200px;overflow:auto;'>"));
		$shopn = $mysidia->db->select("usernoti", array("mtext"), "userid='{$current_user_i2->uid}' and mtype='shop' ORDER BY messageid DESC LIMIT 20");

		while($shopmsg = $shopn->fetchColumn()){ 
			$n_order++; 
			$document->add(new Comment("<br> {$shopmsg}"));
		}
		$document->add(new Comment("</div><br>"));				
	}
	
}
?>