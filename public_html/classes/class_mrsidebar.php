<?php

/**
 * The MRSidebar Class, extends from the parent Sidebar Class.
 * It modifies the behavior of Sidebar class so that it's compatible with theme Midnight Sidebar.
 * @category Resource
 * @package Widget
 * @author Hall of Famer 
 * @copyright Mysidia Adoptables Script
 * @link http://www.mysidiaadoptables.com
 * @since 1.3.4
 * @todo Not much at this point.
 *
 */

class MRSidebar extends Sidebar{

	/**
	 * The topLinks property, it defines a specialized topLinks div for use. 
	 * @access protected
	 * @var Division
    */
    protected $topLinks;

	/**
     * The setDivision method, setter method for property $division.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
	 * @param GUIComponent  $module
     * @access protected
     * @return Void
     */
    protected function setDivision(GUIComponent $module){
	    if(!$this->division){
		    $this->division = new Division;
            $this->division->setID("topbar");
            $this->topLinks = new Division;
            $this->topLinks->setID("links");
            $this->division->add($this->topLinks);
		}	
		$this->topLinks->add($module);
    }
	
	/**
     * The setMoneyBar method, setter method for property $moneyBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setMoneyBar(){
	    $mysidia = Registry::get("mysidia");
        $this->moneyBar = new Link("donate");
        $donate = 'Donate($';
        $donate .= "{$mysidia->user->money})";
        $this->moneyBar->setText($donate);       
        $this->moneyBar->setTitle("You currently have {$mysidia->user->money} {$mysidia->settings->cost}");         
        $this->setDivision($this->moneyBar);
    }
	
	/**
     * The setLinksBar method, setter method for property $linksBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setLinksBar(){
        $mysidia = Registry::get("mysidia");
		$stmt = $mysidia->db->select("links", array("id", "linktext", "linkurl"), "linktype = 'sidelink' ORDER BY linkorder");
		if($stmt->rowCount() == 0) Throw new Exception("There is an error with sidebar links, please contact the admin immediately for help.");

		while($sideLink = $stmt->fetchObject()){
		    $link = new Link($sideLink->linkurl);
			$link->setText($sideLink->linktext);
			if($sideLink->linkurl == "messages"){
			    $num = $mysidia->db->select("messages", array("touser"), "touser='{$mysidia->user->username}' and status='unread'")->rowCount();
				if($num > 0) $link->setText("<b>{$link->getText()} ({$num})</b>");
			}
		    $this->setDivision($link);
		}

		if($mysidia->user instanceof Admin){
		    $adminCP = new Link("admincp/", FALSE, FALSE);
		    $adminCP->setText("AdminCP"); 
            $adminCP->setTitle("Go to AdminCP");
            $this->setDivision($adminCP);	
		}

        //$this->setDivision($this->linksBar);    
    }
	
	/**
     * The setWolBar method, setter method for property $wolBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setWolBar(){
	    $mysidia = Registry::get("mysidia");
		$this->wolBar = new Link("online");
        $online = $mysidia->db->select("online", array(), "username != 'Visitor'")->rowCount();
	    $offline = $mysidia->db->select("online", array(), "username = 'Visitor'")->rowCount();
        $this->wolBar->setText("{$online} users online");
        $this->wolBar->setTitle("This site currently has {$online} members and {$offline} guests.");
        $this->setDivision($this->wolBar); 		
    }
	
	/**
     * The setLoginBar method, setter method for property $loginBar.
	 * It is set internally upon object instantiation, cannot be accessed in client code.
     * @access protected
     * @return Void
     */
    protected function setLoginBar(){
        $mysidia = Registry::get("mysidia");
	    $this->loginBar = new Form("login", "login", "post");
        $this->loginBar->add(new Comment(" username: ", FALSE));
        $this->loginBar->setLineBreak(FALSE);

        $username = new TextField("username");
        $username->setLineBreak(FALSE);
        $password = new PasswordField("password", "password", "", TRUE);
        $password->setLineBreak(FALSE);
        $button = new Button("Log In", "submit", "submit");
        $button->setLineBreak(FALSE); 

        $this->loginBar->add($username);
        $this->loginBar->add(new Comment(" password: ", FALSE));
        $this->loginBar->add($password);	
		$this->loginBar->add($button);
					   
        $register = new Link("register");
        $register->setText("Register New Account");
        $register->setLineBreak(FALSE);
        $forgot = new Link("forgotpass");
		$forgot->setText("Forgot Password?");
        $forgot->setLineBreak(FALSE);
        $online = $mysidia->db->select("online", array(), "username != 'Visitor'")->rowCount();
	    $offline = $mysidia->db->select("online", array(), "username = 'Visitor'")->rowCount();
		$wol = new Link("online");
        $wol->setText("{$online} users online");		
        $wol->setTitle("This site currently has {$online} members and {$offline} guests.");

		$this->loginBar->add($register);
		$this->loginBar->add($forgot);
        $this->loginBar->add($wol);
		$this->setDivision($this->loginBar); 	
    }
}
?>