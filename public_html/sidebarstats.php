<?php


$document->add(new Comment("img src='http://atrocity.mysidiahost.com/picuploads/png/f426b2d42e9b4b3cfed0ffffc6364b36.png'>", FALSE));
 $document->add(new Comment("<h4><b>Newest Users</b></h4>", FALSE));
        $newest_ten_users = $mysidia->db->select("users", array("username"), "1 ORDER BY username DESC LIMIT 5");
        while($username = $newest_ten_users->fetchColumn()){            
            $n_order++;     
            $document->add(new Comment("<b>{$n_order}.</b> <a href='../../profile/view/{$username}'>{$username}</a>"));
        }  
        $document->add(new Comment("img src='http://atrocity.mysidiahost.com/picuploads/png/5d4e173f80f5b0c3aa007fa6de60fb8f.png'>", FALSE));
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
?>