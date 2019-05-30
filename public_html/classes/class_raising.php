<?php



use Resource\Native\Obj;

use Resource\Native\Arrays;



final class Raising extends Obj {



	private $adopts;

	private $total;

    private $settings;

	private $pagination = FALSE;

  

    public function __construct(){

		$mysidia = Registry::get("mysidia");

	    $this->settings = new RaisingSetting($mysidia->db);

		if($this->settings->system == "disabled") throw new RaisingException("system");

    }

	

	public function getAdopts(){

		if(!$this->adopts){

	        $mysidia = Registry::get("mysidia");

            $conditions = $this->getConditions();

            $fetchMode = $this->getFetchMode($conditions);

			$stmt = $mysidia->db->select("owned_adoptables", array("aid"), $conditions.$fetchMode);

            if($stmt->rowCount() == 0) throw new RaisingException("empty");		

			$ids = $stmt->fetchAll(PDO::FETCH_COLUMN);

			$this->adopts = Arrays::fromArray($ids);

            $this->total = $this->adopts->getSize();

        }

        return $this->adopts;		

	}

	

	private function getConditions(){

		$mysidia = Registry::get("mysidia");

		$conditions = "isfrozen != 'yes'";

        //if(is_numeric($this->settings->level)) $conditions .= " and currentlevel <= '{$this->settings->level}'";
		
		$conditions .=" and adopts_owned_adoptables.advertclicktotal > adopts_owned_adoptables.totalclicks";

	    if($this->settings->species){

		    foreach($this->settings->species as $species) $conditions .= " and adopts_owned_adoptables.type != '{$species}'";  				

		}      $date = new DateTime;

               $datetime = $date->format('Y-m-d');

                $user = $mysidia->user;

                

//take adoptable IDs that have been clicked by the user in today's date

        $idsM = $mysidia->db->select("vote_voters", array("adoptableid"), "date='{$datetime}' and username='{$user->username}'")->fetchAll(PDO::FETCH_COLUMN);

        $adoptsIDs = new ArrayObject($idsM);

        

//append to the conditions string an aid restrictions (aid can't be equal to the IDs in idsM) - yes, for each adoptable it has to compare its ID to all of the IDs ._.

        for($index = 0; $index < sizeof($adoptsIDs); $index++)

        {

            //echo $datetime;

            $conditions .= " and aid != '{$adoptsIDs[$index]}'";

        }  

		//if($this->settings->owned != "yes") $conditions .= " and owner != '{$mysidia->user->username}'";

		return $conditions;

	}

	

	private function getFetchMode($conditions){

	    $mysidia = Registry::get("mysidia");

	    if($this->settings->display == "all"){

		    $total = $mysidia->db->select("owned_adoptables", array("aid"), $conditions)->rowCount();	

            $this->pagination = new Pagination($total, $this->settings->number, "levelup/raising");

			$this->pagination->setPage($mysidia->input->get("page"));

            $fetchMode = " ORDER BY currentlevel LIMIT {$this->pagination->getLimit()},{$this->pagination->getRowsperPage()}";			

		}

		else $fetchMode = " ORDER BY RAND() DESC LIMIT {$this->settings->number}";

		return $fetchMode;

	}

	

    public function getTotalAdopts(){

	    if(!$this->total) $this->getAdopts();

	    return $this->total;

	}

	

	public function getTotalRows(){

	    return ceil($this->total / $this->settings->columns);

	}

	

	public function getTotalColumns(){

	    return ($this->total < $this->settings->columns)?$this->total:$this->settings->columns; 

	}

	

	public function getPagination(){

	    return $this->pagination;

	}

	

	public function getStats($adopt){

	    foreach($this->settings->info as $info){

		    $method = "get".$info;

		    $stats .= "{$info}: {$adopt->$method()}<br>";

		}

		return $stats;

	}



    public function joinedListing()

    {

        $mysidia = Registry::get('mysidia');

        $conditions = $this->getConditions();

        $fetchMode = $this->getFetchMode($conditions);

        $stmt = $mysidia->db->join('adoptables','owned_adoptables.type = adoptables.type')

            ->join('levels', 'owned_adoptables.type = levels.adoptiename')

            ->select(

                "owned_adoptables",

                array(PREFIX.'owned_adoptables`.*, `primaryimage','alternateimage','eggimage'),

                $conditions.' and '.PREFIX.'owned_adoptables.currentlevel = '.PREFIX.'levels.thisislevel'.$fetchMode

            );

        $this->total = $stmt->rowCount();

        if($this->total == 0) throw new RaisingException("empty");

        $adopts = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $this->adopts = Arrays::fromArray($adopts);

        return $this->adopts;

    }



    public function getStatsFromArray($adopt) {

        $stats = null;

        foreach($this->settings->info as $info)

        {

            $stats .= $adopt[strtolower($info)].'<br>';

        }

        return $stats;

    }



    public function getImageFromArray($adopt) {

        if ($adopt['imageurl'] != null) {

        	if (file_exists($adopt['imageurl'])) return $adopt['imageurl'];

        		$a = new OwnedAdoptable($adopt['aid']);

        		return $a->getImage();

        }

        if ($adopt['currentlevel'] == 0) return $adopt['eggimage'];

        if ($adopt['usealternates'] == 'yes') return $adopt['alternateimage'];

        return $adopt['primaryimage'];

    }

}