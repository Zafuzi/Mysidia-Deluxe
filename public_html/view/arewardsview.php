  <?php
  
class arewards extends View{

    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
        $document->setTitle("Adminstrator rewards");
if($mysidia->user->status->admins != "yes"){
    $document->add(new Comment("Sorry! you're not an Administrator!!"));
    $document->add(new Comment("Thank you for collecting your paycheck!!"));
} else {
    }          
        if (strtotime($mysidia->user->lastday) < strtotime("-30 days")) {
            $document->add(new Comment("It has been at least 30 days since your last visit!", FALSE));
            // Give User Item
              $amount = 50000;
             $mysidia->user->changecash($amount);   
            $document->add(new Comment("You've recieved 50,000 beads!"));
            // Reset Timestamp
            $now = new DateTime();
            $today = $now->format('Y-m-d');
            $mysidia->db->update("users", array("lastday" => $today), "username = '{$mysidia->user->username}'");
        } else {
            $daysleft = strtotime($mysidia->user->lastday);
            $document->add(new Comment("We're sorry, 30 days have not yet passed! Please wait {$daysleft} more days!", FALSE));
        }  
    }
    
}
?>