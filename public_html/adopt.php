<?php

use Resource\Native\Integer;
use Resource\Native\Str;
use Resource\Native\Arrays;
use Resource\Native\Null;

class AdoptController extends AppController{
	const species = 'species';

	public function __construct(){
		parent::__construct("member");
		$mysidia = Registry::get("mysidia");
		if($mysidia->usergroup->getpermission("canadopt") != "yes"){
			throw new NoPermissionException("permission");
		}	
	}

	public function index() {
		$mysidia = Registry::get("mysidia");
		$adopts = $mysidia->db->select("adoptables", array('type', 'description','cost'), "shop='none' AND class = 'Colorful'");
		$this->setField("adopts", new DatabaseStatement($adopts));
	}

	public function adopt() {
		$mysidia = Registry::get("mysidia");

		$species = $mysidia->input->get('species')->getValue();
		$adopts = $mysidia->db->select("adoptables", array('id', 'description','cost'), "shop='none' AND type='$species' AND class = 'Colorful'")->fetchAll(PDO::FETCH_OBJ);
		if (trim($species) == null OR $adopts == null){
			header('Location: /adopt');
			return;
		}
		$this->setField('species', new Str($species));

		for ($i=1;$i<4;$i++){
            $image = new services\Image\ColorImage();
            $image->setOwner(null);
            $image->age = 0;
            $image->setSpecies($species);
            $image->random();
            $_SESSION['adopt'.$i] = $image;
        }
	}

	public function finish(){
		$mysidia = Registry::get("mysidia");
		if (!isset($_SESSION['adopt'.$mysidia->input->post('adopt')])) {
			header('Location: /adopt');
			return;
		}

		$pet = $_SESSION['adopt'.$mysidia->input->post('adopt')];
		$species = $pet->species;
		$name_array = array($species, "Neo", "Morpheus", "Trinity", "Cypher", "Abel", "Abigail", "Abner", "Abraham", "Acacia", "Addison", "Adrian", "Alex", "Alexis", "Andy", "Angel", "Ariel", "Arron", "Ashley", "Ashton", "Aubrey", "Avery", "Baby", "Bailey", "Billy", "Blaine", "Blair", "Brett", "Brice", "Caden", "Cameron", "Carmen", "Carmine", "Carson", "Cary", "Casey", "Cassidy", "Cecil", "Chandler", "Christian", "Cody", "Connor", "Corey", "Cullen", "Dakota", "Dallas", "Dana", "Darren", "Darryl", "Delaney", "Devon", "Donovan", "Anika", "Dew", "Drew", "Duncan", "Dustin", "Dylan", "Elisha", "Ellery", "Emerson", "Erin", "Evan", "Fabian", "Florian", "Francis", "Glen", "Hadley", "Haiden", "Harley", "Hayden", "Hayley", "Hunter", "Ira", "Israel", "Jade", "Jaden", "James", "Jamie", "Jan", "Jerry", "Jesse", "Jordan", "Jude", "Julian", "Justice", "Kadin", "Kelly", "Kelsey", "Kendall", "Kennedy", "Kerry", "Kiley", "Kimberley", "Lane", "Lee", "Leslie", "Lindsay", "Logan", "London", "Lonnie", "Lucian", "Mackenzie", "Madison", "Mallory", "Marley", "Mason", "McKenna", "Meredith", "Michael", "Montana", "Morgan", "Moriah", "Nevada", "Noel", "Orion", "Paris", "Parker", "Payton", "Perry", "Quinn", "Raphael", "Ravenel", "Reagan", "Reed", "Reese", "Regan", "Rene", "Riley", "Robin",  "Ryan", "Sage", "Scout",  "Sean", "Shane", "Shane",  "Shelby", "Silver", "Skye",  "Skylar", "Sonny", "Spencer",  "Stacy", "Stormy", "Sunny", "Sydney", "Taylor", "Terry",  "Tony", "Tory", "Tracy ", "Tyler", "Tyne", "Wallace", "Wesley", "Whitney", "Wynne", "Zane", "Tank");
        $rand_name = array_rand($name_array);
        $name = $name_array[$rand_name];

		$mysidia->db->insert("owned_adoptables", array("aid" => NULL, "type" => $species, "name" => $name, "owner" => $mysidia->user->username, "breeder" => $mysidia->user->username, "currentlevel" => 0, "totalclicks" => 0, "code" => 0, 
			"imageurl" => NULL, "usealternates" => 'no', "tradestatus" => 'notfortrade', "isfrozen" => 'no', "gender" => $pet->gender, "offsprings" => 0, "lastbred" => 0, "genetics" => json_encode($pet->genetics)));
		$this->setField('aid',new Str($mysidia->db->lastId));
		// get the current time, and create the message text
		$thetime = date("jS M, g:i");
	$message = "<b>{$thetime}</b> - {$mysidia->user->username} adopted one {$name} egg.";
		// add the notification to table
		$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'pets', "mtext" => $message ));	
		$this->setField('petGenetics', new Str(json_encode($pet->genetics)));
		$this->setField('species', new Str($name));
		unset($_SESSION['adopt'.$mysidia->input->post('adopt')]);
	}
	




	public function OLDindex(){
		$mysidia = Registry::get("mysidia");		
		if($mysidia->input->post("submit")){
			$this->access = "member";
			$this->handleAccess();
			$id = $mysidia->input->post("id");
			if($mysidia->session->fetch("adopt") != 1 or !$id) throw new InvalidIDException("global_id");			
			
			$adopt = new Adoptable($id);			    
			$conditions = $adopt->getConditions();
			if(!$conditions->checkConditions()) throw new NoPermissionException("condition");
			
			$name = (!$mysidia->input->post("name"))?$adopt->getType():$mysidia->input->post("name");
			$alts = $adopt->getAltStatus();
			$code = $adopt->getCode();
			$gender = $adopt->getGender();
			$sense = rand(10,100);     
                        $speed = rand(10,100); 
                        $strength = rand(10,100); 
                        $stamina = rand(10,100); 
			$mysidia->db->insert("owned_adoptables", array("aid" => NULL, "type" => $adopt->getType(), "name" => $name, "owner" => $mysidia->user->username, "currentlevel" => 0, "totalclicks" => 0, "code" => $code, 
				"imageurl" => NULL, "usealternates" => $alts, "tradestatus" => 'notfortrade', "isfrozen" => 'no', "gender" => $gender, "offsprings" => 0, "lastbred" => 0, "sense" => $sense, "speed" => $speed, "strength" => $strength, "stamina" => $stamina  ));

			$aid = $mysidia->db->select("owned_adoptables", array("aid"), "code='{$code}' and owner='{$mysidia->user->username}'")->fetchColumn();
			$this->setField("aid", new Integer($aid));
			$this->setField("name", new Str($name));			
			$this->setField("eggImage", new Str($adopt->getEggImage()));
			return;
		}
		
		$mysidia->session->assign("adopt", 1, TRUE);
		$ids = $mysidia->db->select("adoptables", array("id"), "shop='none'")->fetchAll(PDO::FETCH_COLUMN);
		$total = ($ids)?count($ids):0;
		
		if($total == 0) $adopts = new Null;
		else{		
			$adopts = new Arrays($total);
			$available = 0;
			
			foreach($ids as $id){
				$adopt = new Adoptable($id);
				$conditions = $adopt->getConditions();	
				if($conditions->checkConditions()) $adopts[$available++] = $adopt;	
			}
			
			if($available == 0) $adopts = new Null;
			else $adopts->setSize($available);			
		}		
		if($adopts instanceof Null) throw new InvalidActionException("adopt_none");
		$this->setField("adopts", $adopts);
	}
}