<?php

use Resource\Native\String;
use Resource\Collection\LinkedList;

class StatsView extends View{
	
	public function index(){
	    $mysidia = Registry::get("mysidia");
		$document = $this->document;		
	    $document->setTitle($this->lang->title);
	    /* Newest Users */
        $document->add(new Comment("<h4><b>Newest Users</b></h4>", FALSE));
        $newest_ten_users = $mysidia->db->select("users", array("username"), "1 ORDER BY username DESC LIMIT 5");
        while($username = $newest_ten_users->fetchColumn()){            
            $n_order++;     
            $document->add(new Comment("<b>{$n_order}.</b> <a href='../../profile/view/{$username}'>{$username}</a>"));
        }  

	    $stat_totalclicks = $mysidia->db->select("vote_voters")->rowCount();
	     $today = date("Y-m-d");
$weekago = date("Y-m-d", strtotime("-7 days"));
$monthago = date("Y-m-d", strtotime("-1 month"));
$stat_weeklyclicks = $mysidia->db->select("vote_voters", array(), "date >= '{$weekago}' and date <= '{$today}'")->rowCount();
$stat_monthlyclicks = $mysidia->db->select("vote_voters", array(), "date >= '{$monthago}' and date <= '{$today}'")->rowCount(); 
$thisuser = $mysidia->input->get("user");
$stat_weeklyclicks = $mysidia->db->select("vote_voters", array(), "date >= '{$weekago}' and date <= '{$today}' and username = '{$thisuser}'")->rowCount();
    $stat_monthlyclicks = $mysidia->db->select("vote_voters", array(), "date >= '{$monthago}' and date <= '{$today}' and username = '{$thisuser}'")->rowCount();
      
      
    /* Top 10 Users With Most Interactions This WEEK */
      $document->add(new Comment("<br><h4><b>Most clicks this week</b></h4>", FALSE));      
$top10Users_weekly = $mysidia->db->query("SELECT username, COUNT(username) AS interactions FROM adopts_vote_voters WHERE date >= '{$weekago}' and date <= '{$today}' GROUP BY username ORDER BY COUNT(*) DESC LIMIT 5")->fetchAll();
        for($i = 0; $i< count($top10Users_weekly); $i++){ 
            $order_w = $i + 1; 
if ($top10Users_weekly[$i]['username'] != NULL){
            $document->add(new Comment("No.{$order_w}: <a href='../../profile/view/{$top10Users_weekly[$i]['username']}'>{$top10Users_weekly[$i]['username']} ({$top10Users_weekly[$i]['interactions']})</a>")); 
}
        }
        
/* Top 10 Users With Most Interactions This MONTH */
  $document->add(new Comment("<br><h4><b>Most clicks this month</b></h4>", FALSE));  
$top10Users_monthly = $mysidia->db->query("SELECT username, COUNT(username) AS interactions FROM adopts_vote_voters WHERE date >= '{$monthago}' and date <= '{$today}' GROUP BY username ORDER BY COUNT(*) DESC LIMIT 5")->fetchAll();
        for($i = 0; $i< count($top10Users_monthly); $i++){ 
            $order_m = $i + 1; 
if ($top10Users_monthly[$i]['username'] != NULL){
            $document->add(new Comment("No.{$order_m}: <a href='../../profile/view/{$top10Users_monthly[$i]['username']}'>{$top10Users_monthly[$i]['username']} ({$top10Users_monthly[$i]['interactions']})</a>")); 
}
        }  
        
        
		$document->addLangvar($this->lang->default.$this->lang->top10.$this->lang->top10_text);
		$document->add($this->getTable("top10", $this->getField("top10")));
		$document->addLangvar($this->lang->random.$this->lang->random_text);
        $document->add($this->getTable("rand5", $this->getField("rand5")));		
	} 

    private function getTable($name, LinkedList $list){
		$table = new TableBuilder($name);
		$table->setAlign(new Align("center", "middle"));
	    $table->buildHeaders("Adoptable Image", "Adoptable Name", "Adoptable Owner", "Total Clicks", "Current Level");	
	    $table->setHelper(new AdoptTableHelper);
		
		$iterator = $list->iterator();
		while($iterator->hasNext()){
		    $adopt = $iterator->next();
			$cells = new LinkedList;
			$cells->add(new TCell($table->getHelper()->getLevelupLink($adopt)));
		    $cells->add(new TCell($adopt->getName()));
			$cells->add(new TCell($table->getHelper()->getOwnerProfile($adopt->getOwner())));
			$cells->add(new String($adopt->getTotalClicks()));
			$cells->add(new TCell($adopt->getCurrentLevel()));
            $table->buildRow($cells);			
		}
		return $table;
    }	
}
?>