<?php

use Resource\Native\Str;
use Resource\Collection\HashMap;

class RegisterController extends AppController{

    public function __construct(){
        parent::__construct("guest");
    }
	
	public function index(){
	    $mysidia = Registry::get("mysidia");		
	    if($mysidia->input->post("submit")){
		    $mysidia->session->validate("register");	
            $validinput = array("username" => $mysidia->input->post("username"), "password" => $mysidia->input->post("pass1"), "email" => $mysidia->input->post("email"), "birthday" => $mysidia->input->post("birthday"), 'gender' => $mysidia->input->post('gender'),  
                                "ip" => $mysidia->input->post("ip"), "answer" => $mysidia->input->post("answer"), "tos" => $mysidia->input->post("tos"));
            $validator = new RegisterValidator($mysidia->user, $validinput);
            $validator->validate();
            
            $default_avatars = array("hounda_basic", "catari_basic");
            $rand_avatar = array_rand($default_avatars, 1);

            if($mysidia->input->post('avatar') == NULL || empty($mysidia->input->post('avatar'))){$avatar = "http://atrocity.mysidiahost.com/picuploads/default_avatars/{$default_avatars[$rand_avatar]}.png";}
            else{$avatar = $mysidia->input->post('avatar');}
            
            validate_avatar($avatar);
  
            if(!$validator->triggererror()){
	            $mysidia->user->register();	
				include("inc/config_forums.php");
	            if($mybbenabled == 1){
                    include_once("functions/functions_forums.php");   
                    mybbregister();
                    mybbrebuildstats();
                }
	            $mysidia->user->login($mysidia->input->post("username"));
            }
            else throw new RegisterException($validator->triggererror());  
			$mysidia->session->terminate("register");
			return;
		}
		$mysidia->session->assign("register", 1, TRUE);		
	}              
}
?>