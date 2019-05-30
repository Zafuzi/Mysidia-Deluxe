 <?php
class Adminrewards extends View{

    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
        $document->setTitle("Administrator Rewards");    
        if (strtotime($mysidia->user->lastday) < strtotime("-30 days")) {
            $document->add(new Comment("It has been at least 30 days since your last visit!", FALSE));
            $amount = 50000;
$mysidia->user->changecash($amount);  
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
$amount = 50000;
$mysidia->user->changecash($amount); 