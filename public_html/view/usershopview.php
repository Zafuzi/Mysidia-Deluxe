 <?php
class UsershopView extends View{

    public function index(){
      
        $mysidia = Registry::get("mysidia");
        $document = $this->document;  
        $document->add(new Comment("<title>User Shops</title>"));
        $document->setTitle("User Shops");  
        
        $stmt = $mysidia->db->select("user_shops", array("usid"), "status='open'");
        if($stmt->rowCount() == 0){
		$document->add(new Comment("There aren't any shops open! Why not try back later?"));
        	return;
        }
		$document->add(new Comment("<p>Below is a list of all the shops created by other players! Why not take a look around? You might find some good deals!</p>"));
		$document->add(new Comment("<p>Or maybe you want to <a href='http://atrocity.mysidiahost.com/shopcp'>manage your own shops?</a></p>"));
		$document->add(new Comment("<center><table style='text-align:center;border-collapse:collapse;'>
  			<thead>
    			<tr>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Name</th>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Description</th>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Type</th>
      			<th style='text-align:center;border: 2px solid #7F7F7F;padding:8px;'>Action</th>
		    	</tr>
 			</thead>
  			<tbody>", FALSE));
  		while($usid = $stmt->fetchColumn()){
		    $shop_info = $mysidia->db->select("user_shops", array(), "usid='{$usid}'")->fetchObject(); 
			$document->add(new Comment("<tr>
     				<td style='border: 2px solid #7F7F7F;padding:8px;'>{$shop_info->us_name}</td>
				<td style='border: 2px solid #7F7F7F;padding:8px;'>{$shop_info->description}</td>
				<td style='border: 2px solid #7F7F7F;padding:8px;'>{$shop_info->type} shop</td>
				<td style='border: 2px solid #7F7F7F;padding:8px;'>
					<a href='/usershop/browse/{$usid}' class='btn btn-primary' style='width:100%; height:auto;'>Visit</a>
				</td>

    				</tr>", FALSE));
		} 
		$document->add(new Comment("</tbody></table></center>"));
    }
    
    public function browse(){
      
        $mysidia = Registry::get("mysidia");
        $document = $this->document;  
        $shop_id = $this->getField("shop_id");
        $shop_info = $mysidia->db->select("user_shops", array(), "usid='{$shop_id}'")->fetchObject();
        $manager_name = $mysidia->db->select("users", array("username"), "uid = '{$shop_info->manager_id}'")->fetchColumn();
        $adopt_list = $mysidia->db->select("adopt_stock", array("aid"), "usid='{$shop_id}'");
        $username = $mysidia->user->username;
        $stmt = $adopt_list;
        $document->add(new Comment("<title>{$shop_info->us_name}</title>"));
        $document->setTitle("{$shop_info->us_name}");  

		if ($_SERVER['REQUEST_METHOD'] == 'POST') { //This is when the user clicks "buy"!
			$adoptID = $_REQUEST["buy"];
			$adopt_price = $_REQUEST["adopt_price"];
			$adopt_premium_price = $_REQUEST["adopt_premium_price"];
			$adopt_name = $_REQUEST["adopt_name"];			
			$money_check = $mysidia->db->select("users", array("money"), "uid = '{$mysidia->user->uid}'")->fetchColumn();
				if($money_check < $adopt_price){
					$document->add(new Comment("<p>Whoops! You don't have enough money to buy this pet!</p> <a href='/usershop/browse/{$shop_id}'>Continue shopping?</a>"));
					return;
				}
				else{		
					$document->add(new Comment("
						<p>You bought {$adopt_name} with the ID #{$adoptID}</p>
						<p>You can <a href='/usershop/browse/{$shop_id}'>continue shopping</a> or <a href='/myadopts/manage/{$adoptID}'>visit your new pet now</a>.</p>
						"));
					//Change ownership	
					$mysidia->db->update("owned_adoptables", array("owner" => $username, "originalowner" => $manager_name), "aid = '$adoptID'");
					$adopt_owner = $mysidia->db->select("owned_adoptables", array("owner"), "aid = '{$adoptID}'")->fetchColumn();
					//exchange currency
					$mysidia->db->update_increase("users", array("money"), $adopt_price, "uid = {$shop_info->manager_id}");
					$mysidia->db->update_increase("users", array("premiumcurrency"), $adopt_premium_price, "uid = {$shop_info->manager_id}");
					$mysidia->db->update_decrease("users", array("money"), $adopt_price, "uid = {$mysidia->user->uid}");
					$mysidia->db->update_decrease("users", array("premiumcurrency"), $adopt_premium_price, "uid = {$mysidia->user->uid}");
					//remove the pet from the shop
			 		$mysidia->db->delete("adopt_stock", "aid='{$adoptID}'");
			 		//Send a notification to the manager
			 		$pm = new PrivateMessage();
    					$pm->setsender('SYSTEM');
    					$pm->setrecipient(htmlentities(addslashes(trim($username))));
    					$pm->setmessage("You sold a pet!", "{$adopt_name} has been adopted by {$adopt_owner}!");
    					$pm->post();			 		
					return;
				}		
		}
		if($shop_info->manager_id == $mysidia->user->uid){
			$document->add(new Comment("<a href='/shopcp' class='btn btn-warning'>Edit</a>"));
		}
		$document->add(new Comment("<a href='http://atrocity.mysidiahost.com/usershop' class='btn btn-warning'>Back to user shop list</a>"));
		$document->add(new Comment("
			<style>
			        .s_top {
				        overflow:hidden;
                  		display: block;
                	}
                	.sc_npc_text{  
                 		width: 300px;             
                  		height: 70px;
                  		padding: 15px;
                  		margin: 10px;
                  		font-family: 'Trebuchet MS', Helvetica, sans-serif;
                  		overflow: auto;
                  		float:none;
                	}
                	.sc_npc_img{  
                  		width: 40%;
                  		float:none;
                	}
                	.sc_item {
                  		display: inline-table;
                  		padding: 5px;
                  		text-align: center;
                  		font-family: 'Trebuchet MS', Helvetica, sans-serif;
                  		font-size: 14px;
                  		margin-bottom: 3px;
                  		height: 200px;
                  		width: 200px;
                	}
                	.s_panel {
                  		border-radius: 2px;
                  		border: 1px solid #CCC;
                  		background-color: #FBFDF2;  
                	}
            		</style>
            		<!-- START Container for Text and NPC -->
                	<center>
                	    <div class='s_top s_container'>
                    	    <div class='sc_npc_img'>
                    		    <img src='{$shop_info->npc_url}' class='img-fluid'>
                    		</div>
                    	    <div class='s_panel sc_npc_text'>
                    			{$shop_info->welcome_message}
                    	    </div>              
                	    </div>
                    </center>
            		<!-- END Container for Text and NPC -->
            		<!-- START Container for Items -->
                  	<div class='s_container' style='white-space: nowrap;'>    
        		", FALSE));
        
        	while($aid = $stmt->fetchColumn()){
                $adopt = new OwnedAdoptable($aid);
                $price = $mysidia->db->select("adopt_stock", array("price"), "aid='{$aid}'")->fetchColumn();
                $premium_price = $mysidia->db->select("adopt_stock", array("premium_price"), "aid='{$aid}'")->fetchColumn();
                if($premium_price == NULL OR $premium_price == '0'){$gems = "";}
                else{$gems = "</br>{$premium_price} <i class='fa fa-diamond' style='color:blue'></i>";}
                $image = $adopt->getImage();

		# Now let's render each adopt icon, name, and price
		$document->add(new Comment("
                	<div class='s_panel sc_item'>
				<a href='/myadopts/manage/{$aid}'><img src='{$image}' style='height: 100px; width:auto;'></a></br>
				<b>{$adopt->name}</b>
				<p>{$price} Beads, {$gems} Candy</p>
				", FALSE));
                if($shop_info->manager_id == $mysidia->user->uid){}
                else{
                	$document->add(new Comment("
                		<form method='post' action='/usershop/browse/{$shop_id}'>
                			<input type='hidden' name='adopt_price' id='adopt_price' value='{$price}'>
                			<input type='hidden' name='adopt_premium_price' id='adopt_premium_price' value='{$price}'>
                			<input type='hidden' name='adopt_name' id='adopt_name' value='{$adopt->getName()}'>
                			<button class='btn btn-success' type='submit' value='{$aid}' name='buy' id='buy'>Buy</button>
                		</form>
                	", FALSE));
                 }			
           	 # Now we finish off the item by closing its div
            	 $document->add(new Comment("</div>", FALSE));         				
        	}
        	# And that's a wrap
        	$document->add(new Comment("</div><!-- END Container for Items -->", FALSE));                             
    }
}
?>