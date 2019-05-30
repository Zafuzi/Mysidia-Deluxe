<?php

class AjaxPagination extends GUIContainer{

/*
// to be used with jQuery AJAX, so different to the normal pagination.
// you start with page 1, and some things loaded by default, in this case a bunch of Ungrouped griffs
// clicking the buttons will send new page number to flock search script, so it sends back a different bunch of griffs

// example of using on a page:

$totalrows = $mysidia->db->select("owned_adoptables", array("aid"), "master = {$uid} AND stage > 1 AND pet_group = '0' AND nest = '0'")->rowCount();

$page = 1; $rowsperpage = 8; $limit = ($page - 1) * $rowsperpage;
$lastpage = ceil($totalrows / $rowsperpage);
$totalpages = ceil($totalrows / $rowsperpage);

$pagi = new AjaxPagination;  $paggy = $pagi->getPageButtons($page,$totalrows,$rowsperpage);

// normal Mysidia loop, show Ungrouped griffs whenever flock page is first visited
while($aid = $stmt->fetchColumn()){ ..... }

// then {$paggy} in the HTML to add the buttons, inside the div with the things-to-load, so they'll all get overwritten with new results

*/

public function getPageButtons($page,$totalrows,$rowsperpage){

if(!$page){$page = 1;}
$limit = $page - 1 * $rowsperpage;
$lastpage = ceil($totalrows / $rowsperpage);

$pagination = " ";
$lpm1 = $lastpage - 1;
$prev = $page - 1;
$next = $page + 1;

// could use CSS file for buttons, or do it here
$pagination .= "<p><div class='pagination' style='padding:5px;margin:5px;'>
<style>
.pagisize {padding:5px;border-radius:5px;margin:3px;}
.pagi_btn {background-color:white;border:1px solid #c6a981;} .pagi_btn:hover {background-color:#f9efc0;cursor:pointer;}
.pagi_current {background-color:#f9d03b;border:1px solid #bc7f29;}
.pagi_disabled {background-color:#b5b1ab;border:1px solid #726f6a;}
</style>";

if($lastpage > 1){
 if($page > 1){ $pagination .= "<button class='pagi_btn pagisize' data-page='{$prev}'>« Prev</button>"; }
 else{ $pagination .= "<button class='pagi_disabled pagisize'>« Prev</button>"; }
			
 if($lastpage < 9){	
    for($counter = 1; $counter <= $lastpage; $counter++){
	if($counter == $page){ $pagination .= "<button class='pagi_current pagisize'>{$counter}</button>"; }
	else{ $pagination .= "<button class='pagi_btn pagisize' data-page='{$counter}'>{$counter}</a>"; }
    }
 }
 elseif($lastpage >= 9){
   if($page < 4){
     for($counter = 1; $counter < 6; $counter++){
	if($counter == $page){ $pagination .= "<button class='pagi_current pagisize'>{$counter}</button>"; }
	else{ $pagination .= "<button class='pagi_btn pagisize' data-page='{$counter}'>{$counter}</button>"; }
     }
     $pagination .= "...";
     $pagination .= "<button class='pagi_btn pagisize' data-page='{$lpm1}'>{$lpm1}</button>";
     $pagination .= "<button class='pagi_btn pagisize' data-page='{$lastpage}'>{$lastpage}</button>";
  }
  elseif($lastpage - 3 > $page && $page > 1){
     $pagination .= "<button class='pagi_btn pagisize' data-page='1'>1</button>";
     $pagination .= "<button class='pagi_btn pagisize' data-page='2'>2</button>";
     $pagination .= "...";
     for($counter = $page - 1; $counter <= $page + 1; $counter++){
	if($counter == $page){ $pagination .= "<button class='pagi_current pagisize'>{$counter}</button>"; }
	else{ $pagination .= "<button class='pagi_btn pagisize' data-page='{$counter}'>{$counter}</button>"; }
     }
     $pagination .= "...";
     $pagination .= "<button class='pagi_btn pagisize' data-page='{$lpm1}'>$lpm1</button>";
     $pagination .= "<button class='pagi_btn pagisize' data-page='{$lastpage}'>{$lastpage}</button>";
  }
  else{
     $pagination .= "<button class='pagi_btn pagisize' data-page='1'>1</button>";
     $pagination .= "<button class='pagi_btn pagisize' data-page='2'>2</button>";
     $pagination .= "...";
     for($counter = $lastpage - 4; $counter <= $lastpage; $counter++){
	if ($counter == $page){ $pagination .= "<button class='pagi_current pagisize'>{$counter}</button>"; }
	else{ $pagination .= "<button class='pagi_btn pagisize' data-page='{$counter}'>{$counter}</button>"; }
     }
   }
 }
		
 if ($page < $counter - 1){ $pagination .= "<button class='pagi_btn pagisize' data-page='{$next}'>Next »</button>"; }
 else{ $pagination .= "<button class='pagi_disabled pagisize'>Next »</button>"; }
 $pagination .= "</div></p>";
}	
					
return $pagination;

}

}
?>