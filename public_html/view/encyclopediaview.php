<?php
class EncyclopediaView extends View{

    public function index(){
        $mysidia = Registry::get("mysidia");
        $document = $this->document;        
        $document->setTitle("Encyclopedia");  
        $document->add(new Comment("<center><h2>Choose a species below</h1>"));
     
		$document->add(new Comment("<h2><u>Pets</u></h1>"));
		 $document->add(new Comment("<center><h2>Pets that have randomized genetics</h1>"));
        
        $document->add(new Comment("<a href='../encyclopedia/hounda'>Hounda</a>"));
		$document->add(new Comment("<a href='../encyclopedia/catari'>Catari</a>"));
		$document->add(new Comment("<a href='../encyclopedia/feesh'>Feesh</a><br><br>"));

     
		$document->add(new Comment("<h2><u>Companion Pets</u></h1>"));
		 $document->add(new Comment("<center><h2>Mini pets for your pet!</h2>"));
        
        $document->add(new Comment("<s><a href='http://atrocity.mysidiahost.com/pages/view/Minihoundacompanions'>Mini Houndas</a>"));
        
                $document->add(new Comment("<s><a href='../encyclopedia/hounda'>Mini Husky Houndas</a>"));
		$document->add(new Comment("<a href='http://atrocity.mysidiahost.com/pages/view/Minicataricompanions'>Mini Catari</a>"));
		$document->add(new Comment("<a href='../encyclopedia/feesh'>Special Cataris</s></a>"));
		
		    $document->add(new Comment("<s><a href='http://atrocity.mysidiahost.com/pages/view/Minihoundacompanions'>Rocks</a>"));
		
		$document->add(new Comment("<br><h2><u>Memorial Pets</u></h1>"));
		 $document->add(new Comment("<center><h2>Pets that are to commemorate the life of someones real life pet</h1>"));
		
		$document->add(new Comment("<a href='../encyclopedia/zoey'>Zoey</a>"));
		$document->add(new Comment("<a href='../encyclopedia/smoke'>Smoke</a>"));
		$document->add(new Comment("<a href='../encyclopedia/luv-bug'>Luv-Bug</a>"));
		$document->add(new Comment("<a href='../encyclopedia/chiku-banzai'>Chiku-Banzai</a></center>"));
	
	
    }
	
	
	
	
	/***************
		HOUNDAS
	***************/
    public function hounda(){
    $mysidia = Registry::get("mysidia"); 
    $document = $this->document;
    $species = "Hounda";
    $topclicks = $mysidia->db->select("owned_adoptables", array("totalclicks"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadopt = $mysidia->db->select("owned_adoptables", array("name"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadoptowner = $mysidia->db->select("owned_adoptables", array("owner"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $count = $mysidia->db->select("owned_adoptables", array(), "Type='{$species}'")->rowCount();
    $document->setTitle("<center>{$species}</center>");
    $document->add(new comment("<center><img src='/image/display/Hounda' /></center>"));
    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Basic info</th>
</tr>
<tr>
<td><b>Species:</b> {$species} <br></br><b>Height:</b> 18-22 inches at the shoulder <br></br><b>Group:</b> Canine <br></br><b>Rarity:</b> Common<br></br><b>Description:</b>  The loyalest of all pets, the Hounda will be your best friend forever! <br></br><b>Obtainable:</b> From the pound<br></br</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th></th>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Statistics</th>
</tr>
<tr>
<td><b>Amount In-Game:</b> {$count}<br></br><b>Top {$species}:</b> {$topadopt} with {$topclicks} clicks. (Owned by {$topadoptowner})</td>
</tr>
</table>"));

$document->add(new Comment("<a href='../encyclopedia'>Return to Encyclopedia</a>"));
    }
	
	
	
	
	
	
	
	
	
	
	
	
	
	
/***************
		CATARI
	***************/
    public function catari(){
    $mysidia = Registry::get("mysidia"); 
    $document = $this->document;
    $species = "Catari";
    $topclicks = $mysidia->db->select("owned_adoptables", array("totalclicks"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadopt = $mysidia->db->select("owned_adoptables", array("name"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadoptowner = $mysidia->db->select("owned_adoptables", array("owner"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $count = $mysidia->db->select("owned_adoptables", array(), "Type='{$species}'")->rowCount();
    $document->setTitle("<center>{$species}</center>");
    $document->add(new comment("<center><img src='/image/display/Catari' /></center>"));
    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Basic info</th>
</tr>
<tr>
<td><b>Species:</b> {$species} <br></br><b>Height:</b> 9.1 – 9.8 in at the shoulder<br></br><b>Group:</b> Feline <br></br><b>Rarity:</b> Common<br></br><b>Description:</b> The Catari is a race of many colors. shapes and sizes, the most versatile of the pets it is also the most lovable and kind.  <br></br><b>Obtainable:</b> From the pound<br></br</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th></th>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Statistics</th>
</tr>
<tr>
<td><b>Amount In-Game:</b> {$count}<br></br><b>Top {$species}:</b> {$topadopt} with {$topclicks} clicks. (Owned by {$topadoptowner})</td>
</tr>
</table>"));

$document->add(new Comment("<a href='../encyclopedia'>Return to Encyclopedia</a>"));
    }
	
	
	
	
	
	
	
	
	
	
	
	/***************
		FEESH
	***************/
    public function feesh(){
    $mysidia = Registry::get("mysidia"); 
    $document = $this->document;
    $species = "Feesh";
    $topclicks = $mysidia->db->select("owned_adoptables", array("totalclicks"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadopt = $mysidia->db->select("owned_adoptables", array("name"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadoptowner = $mysidia->db->select("owned_adoptables", array("owner"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $count = $mysidia->db->select("owned_adoptables", array(), "Type='{$species}'")->rowCount();
    $document->setTitle("<center>{$species}</center>");
    $document->add(new comment("<center><img src='/image/display/Feesh' /></center>"));
    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Basic info</th>
</tr>
<tr>
<td><b>Species:</b> {$species} <br></br><b>Length:</b> 5-9 inches<br></br><b>Group:</b> Fish <br></br><b>Rarity:</b> Common<br></br><b>Description:</b> The Feesh is a slightly tempermental breed...its Vain and not very nice-why did you take it home?  <br></br><b>Obtainable:</b> From the Pound<br></br</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th></th>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Statistics</th>
</tr>
<tr>
<td><b>Amount In-Game:</b> {$count}<br></br><b>Top {$species}:</b> {$topadopt} with {$topclicks} clicks. (Owned by {$topadoptowner})</td>
</tr>
</table>"));

$document->add(new Comment("<a href='../encyclopedia'>Return to Encyclopedia</a>"));
    }
	
	
	
	
		
	

	
	
	
	
	
		
	
	/***************
		Chiku-Banzai
	***************/
    public function chikubanzai(){
    $mysidia = Registry::get("mysidia"); 
    $document = $this->document;
    $species = "Chiku-Banzai";
    $topclicks = $mysidia->db->select("owned_adoptables", array("totalclicks"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadopt = $mysidia->db->select("owned_adoptables", array("name"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadoptowner = $mysidia->db->select("owned_adoptables", array("owner"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $count = $mysidia->db->select("owned_adoptables", array(), "Type='{$species}'")->rowCount();
    $document->setTitle("<center>{$species}</center>");
    $document->add(new comment("<center><img src='/image/display/chikubanzai' /></center>"));
    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Basic info</th>
</tr>
<tr>
<td><b>Species:</b> {$species} <br></br><b>Size:</b> 9 to 15 inches <br></br><b>Group:</b> Memorial <br></br><b>Rarity:</b> Uncommon<br></br><b>Description:</b>This pet is to commemorate the life of the awesome Chinchilla Chiku-Banzai- who passed away on 11-29-2014 <br></br><b>Obtainable:</b> From Smoke's memorial store<br></br</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th><b>Other Info</b></th>
</tr>
<tr>
<th>This pet cannot be bred, Placed in battle etc, and does not evolve</th>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Statistics</th>
</tr>
<tr>
<td><b>Amount In-Game:</b> {$count}<br></br><b>Top {$species}:</b> {$topadopt} with {$topclicks} clicks. (Owned by {$topadoptowner})</td>
</tr>
</table>"));

$document->add(new Comment("<a href='../encyclopedia'>Return to Encyclopedia</a>"));
    }
	
	
	
	
	
		
	
	/***************
		Luv-Bug
	***************/
    public function luvbug(){
    $mysidia = Registry::get("mysidia"); 
    $document = $this->document;
    $species = "Luv-Bug";
    $topclicks = $mysidia->db->select("owned_adoptables", array("totalclicks"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadopt = $mysidia->db->select("owned_adoptables", array("name"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadoptowner = $mysidia->db->select("owned_adoptables", array("owner"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $count = $mysidia->db->select("owned_adoptables", array(), "Type='{$species}'")->rowCount();
    $document->setTitle("<center>{$species}</center>");
    $document->add(new comment("<center><img src='/image/display/luvbug' /></center>"));
    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Basic info</th>
</tr>
<tr>
<td><b>Species:</b> {$species} <br></br><b>Size:</b> 8 and 12 inches<br></br><b>Group:</b> Memorial <br></br><b>Rarity:</b> Uncommon<br></br><b>Description:</b>  This pet is to commemorate the life of the Sweet adorable Guinea pig Luv-bug who passed away on 08-14-2015 <br></br><b>Obtainable:</b> From Smoke's memorial store<br></br</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th><b>Other Info</b></th>
</tr>
<tr>
<th>This pet cannot be bred, Placed in battle etc, and does not evolve</th>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Statistics</th>
</tr>
<tr>
<td><b>Amount In-Game:</b> {$count}<br></br><b>Top {$species}:</b> {$topadopt} with {$topclicks} clicks. (Owned by {$topadoptowner})</td>
</tr>
</table>"));

$document->add(new Comment("<a href='../encyclopedia'>Return to Encyclopedia</a>"));
    }
	
	
	
	
	
		
	
	/***************
		Zoey
	***************/
    public function zoey(){
    $mysidia = Registry::get("mysidia"); 
    $document = $this->document;
    $species = "Zoey";
    $topclicks = $mysidia->db->select("owned_adoptables", array("totalclicks"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadopt = $mysidia->db->select("owned_adoptables", array("name"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadoptowner = $mysidia->db->select("owned_adoptables", array("owner"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $count = $mysidia->db->select("owned_adoptables", array(), "Type='{$species}'")->rowCount();
    $document->setTitle("<center>{$species}</center>");
    $document->add(new comment("<center><img src='/image/display/zoey' /></center>"));
    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Basic info</th>
</tr>
<tr>
<td><b>Species:</b> {$species} <br></br><b>Size:</b>  About 5-6 inches in length, not including the tail which adds another 6 inches<br></br><b>Group:</b> Memorial <br></br><b>Rarity:</b> Uncommon<br></br><b>Description:</b> This pet is to commemorate the life of the Sweetest sugar glider ever, Zoey- who passed away on 10/2/15<br></br><b>Obtainable:</b> From Smoke's memorial store<br></br</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th><b>Other Info</b></th>
</tr>
<tr>
<th>This pet cannot be bred, Placed in battle etc, and does not evolve</th>
</tr>

</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Statistics</th>
</tr>
<tr>
<td><b>Amount In-Game:</b> {$count}<br></br><b>Top {$species}:</b> {$topadopt} with {$topclicks} clicks. (Owned by {$topadoptowner})</td>
</tr>
</table>"));

$document->add(new Comment("<a href='../encyclopedia'>Return to Encyclopedia</a>"));
    }
	
	
	
		
	
	/***************
		Smoke
	***************/
    public function smoke(){
    $mysidia = Registry::get("mysidia"); 
    $document = $this->document;
    $species = "Smoke";
    $topclicks = $mysidia->db->select("owned_adoptables", array("totalclicks"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadopt = $mysidia->db->select("owned_adoptables", array("name"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $topadoptowner = $mysidia->db->select("owned_adoptables", array("owner"), "Type='{$species}'", "1 ORDER BY totalclicks DESC LIMIT 1")->fetchColumn();
    $count = $mysidia->db->select("owned_adoptables", array(), "Type='{$species}'")->rowCount();
    $document->setTitle("<center>{$species}</center>");
    $document->add(new comment("<center><img src='/image/display/smoke' /></center>"));
    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Basic info</th>
</tr>
<tr>
<td><b>Species:</b> {$species} <br></br><b>Size:</b> About 5-6 inches in length, not including the tail which adds another 6 inches<br></br><b>Group:</b> Memorial <br></br><b>Rarity:</b> Uncommon<br></br><b>Description:</b>  A pet to memorialize the lovely wonderful sugar glider Smoke- Who passed away on 6-15-2015 <br></br><b>Obtainable:</b> From Smokes memorial store<br></br</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th><b>Other Info</b></th>
</tr>
<tr>
<th>This pet cannot be bred, Placed in battle etc, and does not evolve</th>
</tr>
<tr>
<td>In depth description goes here. It can include origins, date created, etc.</td>
</tr>
</table>"));

    $document->add(new Comment("<center><table class='myTable'>
<tr>
<th>Statistics</th>
</tr>
<tr>
<td><b>Amount In-Game:</b> {$count}<br></br><b>Top {$species}:</b> {$topadopt} with {$topclicks} clicks. (Owned by {$topadoptowner})</td>
</tr>
</table>"));

$document->add(new Comment("<a href='../encyclopedia'>Return to Encyclopedia</a>"));
    }
	
	
	
	
		

}