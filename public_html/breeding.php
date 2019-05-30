<?php



use Resource\Native\Integer;

use Resource\Native\Str;

use Resource\Native\Null;

use Resource\Collection\LinkedList;

use Resource\Native\Arrays;



class BreedingController extends AppController{



	public function __construct(){

		parent::__construct("member");

		$mysidia = Registry::get("mysidia");		

		$userStatus = $mysidia->user->getstatus();

		if($userStatus->canbreed == "no") throw new NoPermissionException("permission");		

	}



	public function index(){

		$mysidia = Registry::get("mysidia");

		$settings = new BreedingSetting($mysidia->db);

		$this->setField('settings', $settings);

		if($settings->system != "enabled") throw new InvalidActionException("system");

		$this->setField("cost", new Integer($settings->cost));



		$current = new DateTime;

		$lasttime = $current->getTimestamp() - (($settings->interval) * 24 * 60 * 60);



		$stmt = $mysidia->db->join('adoptables','owned_adoptables.type = adoptables.type')

		->select(

			"owned_adoptables",

			array(PREFIX.'owned_adoptables`.*, `class'),

			PREFIX."owned_adoptables.currentlevel >= {$settings->level} AND ".PREFIX."adoptables.class = 'Colorful' AND lastbred <= '$lasttime' AND gender = 'm' AND owner = '{$mysidia->user->username}' ORDER BY 'type', 'name'"

			);

		$this->values['maleMap'] = $stmt->fetchAll(PDO::FETCH_OBJ);

		$stmt = $mysidia->db->join('adoptables','owned_adoptables.type = adoptables.type')

		->select(

			"owned_adoptables",

			array(PREFIX.'owned_adoptables`.*, `class'),

			PREFIX."owned_adoptables.currentlevel >= '{$settings->level}' AND ".PREFIX."adoptables.class = 'Colorful' AND lastbred <= '$lasttime' AND gender = 'f' AND owner = '{$mysidia->user->username}' ORDER BY 'type', 'name'"

			);

		$this->values['femaleMap'] = $stmt->fetchAll(PDO::FETCH_OBJ);

	}



	public function breed(){

		$mysidia = Registry::get("mysidia");



		hasTooManyPets();



		$settings = new BreedingSetting($mysidia->db);

		if($settings->system != "enabled") throw new InvalidActionException("system");

		$female = (int) $mysidia->input->post("female");

		$male = (int) $mysidia->input->post("male");

		if($female == null or $male == null){

			throw new InvalidIDException("none_select");

		}



		$female = new OwnedAdoptable($female, $mysidia->user->username);

		$male = new OwnedAdoptable($male, $mysidia->user->username);

		$validator = new BreedingValidator($female, $male, $settings, new ArrayObject(array("class", "gender", "owner", "species", "interval", "level", "capacity", "number", "cost", "usergroup", "item", "chance")));

		try{

			$validator->validate();

			if ($female->getType() != $male->getType()){

				throw new BreedingException('You must breed the same type of pet together.');

			}

		}catch(BreedingException $bre){                

			$status = $bre->getmessage();

			$validator->setStatus($status);

			throw new InvalidActionException($status);

		}



		// Validations past, breed pets.

		$breeding = new services\ColorBreeding\ColorBreeding();

		$breedingStyles = ['straightColorMerge','colorBrighten','colorDarken','colorMergePlusWhite','colorMergePlusBlack','favorsPa','favorsMa'];

		$style = $breedingStyles[array_rand($breedingStyles)];

		$child = $breeding->breed(['sire'=>json_decode($male->genetics, true),'dam'=>json_decode($female->genetics, true)], $style);

		$imagechild = new services\Image\ColorImage();

		$imagechild->setSpecies($female->getType());

		$imagechild->age = 0;

		$imagechild->create($child);

		$this->values['offspring'] = $imagechild;

		$mysidia->db->insert("owned_adoptables", ["type" => $female->getType(), "name" => $female->getType(), "owner" => $mysidia->user->username, "breeder" => $mysidia->user->username, "currentlevel" => 0, "totalclicks" => 0, 

			"imageurl" => NULL, "usealternates" => 'no', "tradestatus" => 'notfortrade', "isfrozen" => 'no', "gender" => $imagechild->gender, "offsprings" => 0, "lastbred" => 0, 'genetics' => json_encode($imagechild->genetics), 'sire_id'=>$male->getAdoptID(), 'dam_id'=>$female->getAdoptID()]);
		// get the current time, and create the message text
		$thetime = date("jS M, g:i");
		$message = "<b>{$thetime}</b> - {$female->getName()} and {$male->getName()} had a baby!";
		// add the notification to table
		$mysidia->db->insert("usernoti", array("messageid" => NULL, "userid" => $mysidia->user->uid, "date" => $thetime, "mtype" => 'pets', "mtext" => $message ));	
		$this->values['aid'] = $mysidia->db->lastId;

		$validator->setStatus("complete");

	}

	

	public function OLDindex(){

		$mysidia = Registry::get("mysidia");

		$settings = new BreedingSetting($mysidia->db);

		if($settings->system != "enabled") throw new InvalidActionException("system");

		

		if($mysidia->input->post("submit")){

			if($mysidia->input->post("female") == "none" or $mysidia->input->post("male") == "none"){

				throw new InvalidIDException("none_select");

			}

			

			try{

				$female = new OwnedAdoptable($mysidia->input->post("female"), $mysidia->user->username);

				$male = new OwnedAdoptable($mysidia->input->post("male"), $mysidia->user->username);

				$breeding = new Breeding($female, $male, $settings); 

				$validator = $breeding->getValidator("all");

				$validator->validate();

			}

			catch(AdoptNotfoundException $ane){

				throw new InvalidIDException("none_exist");

			}

			catch(BreedingException $bre){                

				$status = $bre->getmessage();

				$validator->setStatus($status);

				throw new InvalidActionException($status);

			}

			

			if($settings->method == "advanced") $species = $breeding->getBabySpecies();

			$breeding->getBabyAdopts($species);

			$breeding->breed($adopts);

			$num = $breeding->countOffsprings();



			if($num > 0){

				$offsprings = $breeding->getOffsprings();

				$offspringID = $mysidia->db->select("owned_adoptables", array("aid"), "1 ORDER BY aid DESC LIMIT 1")->fetchColumn() - $num + 1;

				$links = new LinkedList;

				foreach($offsprings as $offspring){

					$image = $offspring->getEggImage("gui");

					$links->add(new Link("myadopts/manage/{$offspringID}", $image));

					$offspringID++;

				}

				$this->setField("links", $links);

			}

			else $this->setField("links", new Null);

			$this->setField("breeding", $breeding);		

			return;

		}



		$this->setField("cost", new Integer($settings->cost));

		$current = new DateTime;

		$lasttime = $current->getTimestamp() - (($settings->interval) * 24 * 60 * 60);



		$stmt = $mysidia->db->select("owned_adoptables", array("name", "aid"), "owner = '{$mysidia->user->username}' AND gender = 'f' AND currentlevel >= {$settings->level} AND lastbred <= '{$lasttime}'");

		$female = ($stmt->rowcount() == 0)?new Null:$mysidia->db->fetchMap($stmt);

		$this->setField("femaleMap", $female);



		$stmt = $mysidia->db->select("owned_adoptables", array("name", "aid"), "owner = '{$mysidia->user->username}' AND gender = 'm' AND currentlevel >= {$settings->level} AND lastbred <= '{$lasttime}'");

		$male = ($stmt->rowcount() == 0)?new Null:$mysidia->db->fetchMap($stmt);

		$this->setField("maleMap", $male);

	}

}