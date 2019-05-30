<?php

use Resource\Native\Integer;
use Resource\Collection\ArrayList;
use Resource\Utility\Curl;

class LevelupController extends AppController{

    const PARAM = "aid";
	private $adopt;
    private $settings;

    public function __construct(){
        parent::__construct();
        $this->settings = new LevelSetting;
		$mysidia = Registry::get("mysidia");

		if($mysidia->input->action() == "click" or $mysidia->input->action() == "siggy") $this->adopt = new OwnedAdoptable($mysidia->input->get("aid"));
		if($mysidia->user instanceof Member){
		    $status = $mysidia->user->getstatus();   
			if($status->canlevel == "no") throw new InvalidActionException("banned");
		}	
    }
	
	public function index(){
		throw new InvalidActionException("global_action");
	}
	
	public function click(){
	    $mysidia = Registry::get("mysidia");
		$date = new DateTime;
		$ip = secure($_SERVER['REMOTE_ADDR']);

		if ($this->adopt->isdead == true) {
			throw new LevelupException('dead');
		}

		if($this->settings->system != "enabled") throw new NoPermissionException("disabled");
        elseif($this->adopt->hasVoter($mysidia->user, $date)){
		    $message = ($mysidia->user instanceof Member)?"already_leveled_member":"already_leveled_guest";
		    $message2 = " Or <a href='/pet/profile/{$this->adopt->aid}'>click here</a> to visit the pet's profile.";
		    $lang = Registry::get("lang");
		    throw new LevelupException($lang->lang[$message] . $message2);
	    }
		elseif($this->adopt->isFrozen() == "yes") throw new LevelupException("frozen");
        elseif($mysidia->user->getVotes() > $this->settings->number) throw new LevelupException("number");
        elseif($this->settings->owner == "disabled" and $this->adopt->getOwner() == $mysidia->user->username){
 			throw new LevelupException("owner");	           
        }
		else{
		    $newClicks = $this->adopt->getTotalClicks() + 1;
			$this->adopt->setTotalClicks($newClicks, "update");
	        $mysidia->db->insert("vote_voters", array("void" => NULL, "date" => $date->format('Y-m-d'), "username" => $mysidia->user->username, "ip" => $ip, "adoptableid" => $mysidia->input->get("aid")));		 
			
			if($this->adopt->hasNextLevel()){
	            $nextLevel = $this->adopt->getNextLevel();
				$requiredClicks = $nextLevel->getRequiredClicks();
	            if($requiredClicks and $newClicks >= $requiredClicks) $this->adopt->setCurrentLevel($nextLevel->getLevel(), "update");
	        }
			
            $plugin = $mysidia->db->select("acp_hooks", array(), "pluginname = 'itemdrop' and pluginstatus = 1")->fetchObject();
            if($mysidia->user instanceof Member and is_object($plugin)){
                $item = $mysidia->db->select("adoptables", array("dropitem", "droprate"), "type = '{$this->adopt->getType()}'")->fetchObject();
                if(!empty($item->dropitem) and $item->droprate > 0){
                    $candrop = "yes";
                    $droprand = mt_rand(0, 99);
                    if($droprand < $item->droprate){
                        // Item has dropped, now process the event!
                        $itemrand = explode(",", $item->dropitem);
                        $num = count($itemrand);

                        if(count($itemrand) == 1) $actualitem = $itemrand[0];
                        else{
                            $actualrand = mt_rand(0, $num - 1);
                            $actualitem = $itemrand[$actualrand];
                        }

                        $newitem = new StockItem($actualitem, 1);
                        $newitem->assign($mysidia->user->username);
                        $newitem->append(1); 
                        $dropstatus = new Integer(1);
                    }
                }    
            }  			
			
			$reward = $mysidia->user->clickreward($this->settings->reward);
		    $mysidia->user->changecash($reward);			
            $this->setField("adopt", $this->adopt);
            $this->setField("reward", new Integer($reward));
            if(!isset($dropstatus)) $dropstatus = false;
            $this->setField("dropstatus", ($dropstatus)?$dropstatus:new Integer(0));
            $this->setField("dropitem", $newitem?$newitem:new Integer(0));
         
		}
	}

	public function siggy(){
	    $mysidia = Registry::get("mysidia");
        // The adoptable is available, let's collect its info
	    $usingimage = "no";
	    $image = $this->adopt->getImage(); 

	    if ($this->adopt->getClass() == 'Colorful') {
	    	$i = Registry::get('cImage');
	    	$file = $this->adopt->getAdoptID(). '-'.$this->adopt->getCurrentLevel();
			$filename = $_SERVER['DOCUMENT_ROOT'].'/picuploads/pets/'.$file.'.png';
	    	$i->setImage($filename)->addName($this->adopt->getOwner());
	    	$i->display();
	    	return;
	    }
	  
	    $usegd = $mysidia->settings->gdimages;
	    $imageinfo = @getimagesize($image);
	    $imagemime = $imageinfo["mime"]; // Mime type of the image file, should be a .gif file...

	    if(function_exists('imagegif') and $usegd == "yes" and $imagemime == "image/gif"){
	        $usingimage = "yes"; //Turn the template system off
            $type = $this->adopt->getType();
            list($width, $height, $type, $attr) = getimagesize($image); // The size of the original adoptable image

	        // Lets create the new target image, with a size big enough for the text for the adoptable
	        $newheight = $height + 72;
            $newwidth = ($newwidth < 250)?250:$width;
            $img_temp = imagecreatetruecolor($newwidth, $newheight); 
            $alphablending = true;  
		 
    	    // Lets create the image and save its transparency  
            $img_old = @imagecreatefromgif($image);  
            imagealphablending($img_old, true);  
            imagesavealpha($img_old, true);
   
            // Lets copy the old image into the new image with  
            ImageCopyResampled($img_temp, $img_old, 0, 0, 0, 0, $width, $height, $width, $height);    
	        $textheight = $width + 2;
	        $image = $img_temp;
            $bgi = imagecreatetruecolor($newwidth, $newheight);
            $color = imagecolorallocate($bgi, 51, 51, 51);
		 
		    // Build text for siggy
            $str1 = "Name: ".$this->adopt->getName();
            $str2 = "Owner: ".$this->adopt->getOwner();
	        $str3 = "Click Here to Feed Me!";
	        $str4 = "More Adopts at:";
	        $str5 = "www.".constant("DOMAIN");

            // Renger Image
	        imagestring ($image, 12, 0, $textheight,  $str1, $color);
	        imagestring ($image, 12, 0, $textheight + 13,  $str2, $color);
	        imagestring ($image, 12, 0, $textheight + 26,  $str3, $color);
	        imagestring ($image, 12, 0, $textheight + 42,  $str4, $color);
	        imagestring ($image, 12, 0, $textheight + 55,  $str5, $color);
	        $background = imagecolorallocate($image, 0, 0, 0);  
            ImageColorTransparent($image, $background);  
 
            // At the very last, let's clean up temporary files
	        header("Content-Type: image/GIF");
	        ImageGif ($image);
	        imagedestroy($image);
	        imagedestroy($img_temp);
	        imagedestroy($img_old);
	        imagedestroy($bgi);

	    }
	    else{  	
	            // We are going to try and get this image the old fashioned way...
            $extList = array();
	        $extList['gif'] = 'image/gif';
	        $extList['jpg'] = 'image/jpeg';
	        $extList['jpeg'] = 'image/jpeg';
	        $extList['png'] = 'image/png';

	        //Define the output file type
	        $contentType = 'Content-type: '.$extList[ $imageinfo['extension'] ];

	        if($imageinfo['extension'] =! "image/gif" and $imageinfo['extension'] =! "image/jpeg" and $imageinfo['extension'] =! "image/png"){	         
	            throw new InvalidIDException("The file Extension is not allowed!");
	        }
	        else{
                // File type is allowed, so proceed
	            $status = "";
	            header($contentType);
                $curl = new Curl($image);
				$curl->setHeader();
				$curl->exec();
				$curl->close();
	        } 
	    }
	}
	
	public function daycare(){		
		$daycare = new Daycare;
		$adopts = $daycare->getAdopts();
		$this->setField("daycare", $daycare);
	}
	
	public function raising(){		
		$raising = new Raising;
		$adopts = $raising->getAdopts();
		$this->setField("raising", $raising);
	}
}