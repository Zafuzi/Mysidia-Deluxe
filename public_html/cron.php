<?php
class CronController extends AppController{

	public function __construct(){

	}

	public function index(){
	}
	
	
	public function daily(){ //these run once a day. They're simple, so they can all be crammed into one function to save site speed
	    $mysidia = Registry::get("mysidia");
	    //EXPLORE TIMES
	    $mysidia->db->update("users", array("exploretimes" => '0',
		"exploretimes_torasgame" => '0',
		"exploretimes_eyregame" => '0',
		"exploretimes_forestlake" => '0',
		"exploretimes_icelake" => '0',
		"exploretimes_forestmine1" => '0',
		"exploretimes_forestmine3" => '0',
		"exploretimes_forestmine4" => '0',
		"exploretimes_forestmine5" => '0',
		"exploretimes_forestmine6" => '0',
		"exploretimes_mountainlake" => '0',
		"exploretimes_forestmine2" => '0',
		"exploretimes_beachsearch" => '0',
		"exploretimes_searchocean" => '0',
		"exploretimes_backyard"=> '0',
		"exploretimes_attic"=> '0',
		));
	
		//bank interest!
		$percentage = 1; //the percentage you want to add. 1% seems reasonable for now
		$stmt = $mysidia->db->select("users");
		while($user = $stmt->fetchObject()){
			$balance = $user->bank;
			if($balance != "0" OR $balance != NULL){ //only add funds if the user's bank isn't empty. Otherwise, do nothing.
				$amount = ($percentage / 100) * $balance;
				$mysidia->db->update_increase("users", array("bank"), $amount, "username = '{$user->username}'");
			}
		}
		//bank end
		    
	}
	
	
	public function birthday(){
	$mysidia = Registry::get("mysidia");	
		$today = date("d/m/Y"); // For example, this prints the date in 0X/0X/XXXX format
		$my_birthday = "Insert_date_here"; //must use the same format as above
		
		$color_array = array("Red", "Light blue", "Yellow", "Purple"); //candy colors!
		$color = array_rand($color_array, 1); //picks 1 random color from the array
		
		$global_items = array("Ittermat Birthday Plushie", "Ittermat Balloon", "Ittermat Headband", "Ittermat Keyring", "Ittermats Tail", "Piece of Ittermats Birthday Cake"); //these go to everyone on your birthday
		$user_items = array("Piece of your birthday cake", "Black birthday cat balloon", "{$color} Ittermat Candy", "Birthday Noise makers"); //these go to just that user on their birthday
		
		$stmt = $mysidia->db->select("users");
		
		while($user = $stmt->fetchObject()){
			if($today == $my_birthday){ // Gifts for everyone!
			
				$pm = new PrivateMessage(); // We should send a PM, so they know where the items came from xD
					$pm->setsender('SYSTEM');
					$pm->setrecipient(htmlentities(addslashes(trim($user->username))));
					$pm->setmessage("the message title", "put your message here");
					$pm->post();
					
				foreach ($global_items as $item_name) { //now let's give them stuff!
					$item = new StockItem($item_name);
					$item->append(1, $user->username);
				}
			
			}
			
			elseif($today == $user->birthday){ //Gifts for them only		

				$pm = new PrivateMessage();
					$pm->setsender('SYSTEM');
					$pm->setrecipient(htmlentities(addslashes(trim($user->username))));
					$pm->setmessage("Happy Birthday!", "It's your birthday today! Some items have been added to your inventory in celebration.");
					$pm->post();
			
				foreach ($user_items as $item_name) {
					$item = new StockItem($item_name);
					$item->append(1, $user->username);
				}
			
			}
			
			else{} // It's nobody's birthday, so do nothing
		}
	}

}
?>