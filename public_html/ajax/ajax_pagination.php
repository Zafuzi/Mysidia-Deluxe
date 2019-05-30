<?php

// a rewrite of Mysidia's class_pagination. This creates the correct next/prev/number buttons to match search results
// instead of them being links, they should have data-page so jQuery can send new AJAX query with that

function getPageButtons($page,$totalrows,$rowsperpage){

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

?>