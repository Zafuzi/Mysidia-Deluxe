<?php

// File ID: functions.php
// Purpose: Provides basic sitewide functions

$attr = getattributes(); 

// Begin functions definition:

function __autoload($name) {
  // The autoload function, a bit messy if you ask me
  $class_path = strtolower("classes/class_{$class}");  
  $dir = (defined("SUBDIR"))?"../":"";
  if(file_exist("{$dir}{$class_path}.php")) include("{$dir}{$class_path}.php");
  else{
	$abstract_path = strtolower("classes/abstract/abstract_{$class}");
	$interface_path = strtolower("classes/interfaces/interface_{$class}");
	if(file_exist("{$dir}{$abstract_path}.php")) include("{$dir}{$abstract_path}.php");
    elseif(file_exist("{$dir}{$interface_path}.php")) include("{$dir}{$interface_path}.php");
	else throw new Exception("Fatal Error: Class {$class} either does not exist!");
  }
}

function is_assoc($arr) {
   // From php.net, will help a lot in future
   return (is_array($arr) && count(array_filter(array_keys($arr),'is_string')) == count($arr));
}

function checkrb($field, $value){
   $button = ($field == $value)?" checked":"";
   return $button;
}

function secure($data) {
	//This function performs security checks on all incoming form data
	if(is_array($data) and SUBDIR != "AdminCP") die("Hacking Attempt!");
	$data = htmlentities($data);
    $data = addslashes($data);	
	$data = strip_tags($data, '');
	return $data;
}

function redirect($url,$permanent = false){
    if($permanent) header("HTTP/1.1 301 Moved Permanently'");
    header("Location: ".$url);
    exit();
}      

function replace($old, $new, $template) {
	//This function replaces template values
	$template = str_replace($old, $new, $template);
	return $template;
}

function codegen($length, $symbols = 0){
	$set = array("a","A","b","B","c","C","d","D","e","E","f","F","g","G","h","H","i","I","j","J","k","K","l","L","m","M","n","N","o","O","p","P","q","Q","r","R","s","S","t","T","u","U","v","V","w","W","x","X","y","Y","z","Z","1","2","3","4","5","6","7","8","9");
	$str = '';
	
	if($symbols == 1){
	  $symbols = array("~","`","!","@","$","#","%","^","+","-","*","/","_","(","[","{",")","]","}");
	  $set = array_merge($set, $symbols);
	}

	for($i = 1; $i <= $length; ++$i)
	{
		$ch = mt_rand(0, count($set)-1);
		$str .= $set[$ch];
	}

	return $str;
}

function passencr($username, $password, $salt){
    $mysidia = Registry::get("mysidia");
    $pepper = $mysidia->settings->peppercode;
    $password = md5($password);
    $newpassword = sha1($username.$password);
    $finalpassword = hash('sha512', $pepper.$newpassword.$salt);
    return $finalpassword;
}     

function ipgen($ip){
	$ip_long = ip2long($ip);

	if(!$ip_long){
		$ip_long = sprintf("%u", ip2long($ip));		
		if(!$ip_long){
			return 0;
		}
	}

	if($ip_long >= 2147483648) $ip_long -= 4294967296;
	return $ip_long;
}

function get_rand_id($length){
    if($length>0){ 
    $rand_id="";
      for($i=1; $i<=$length; $i++){
        mt_srand((double)microtime() * 1000000);
        $num = mt_rand(1,36);
        $rand_id .= assign_rand_value($num);
      }
    }
    return $rand_id;
} 

function timeconverter($unit){
	switch($unit){
		case "secs":
			$converter = 1;
			break;
		case "minutes":	
            $converter = 60;
            break;
	    case "hours":	
            $converter = 3600;
            break;
        case "weeks":
            $converter = 604800;
            break; 
        case "months":
            $converter = 2592000;
            break;
		case "years":
            $converter = 31536000;
            break;	
        default:
             $converter = 86400;			   
    }
	return $converter;	
}

function getadmimages() {
    $mysidia = Registry::get("mysidia");
	$formcontent = "";
	$stmt = $mysidia->db->select("filesmap", array());
	while($row = $stmt->fetchObject()) {
		$wwwpath = $row->wwwpath;   
		$friendlyname= $row->friendlyname; 
		$formcontent .= "<option value='{$wwwpath}'>{$friendlyname}</option>";
	}
	return $formcontent;
}

function globalsettings(){
    $mysidia = Registry::get("mysidia");
	$settings = new stdclass;
   	$stmt = $mysidia->db->select("settings", array());
	while($row = $stmt->fetchObject()){
	  $property = $row->name;
	  $settings->$property = $row->value;
	}
	return $settings;
}

function getattributes(){
  // This function defines default attributes for html table, form and other stuff...
  $attr = new stdclass;

  // Get default attributes for html tables...	
	$attr->table = new stdclass;
	$attr->table->align = "center";
	$attr->table->style = "";
	$attr->table->background = array();
	$attr->table->border = 1;
	$attr->table->cellpadding = "";
	$attr->table->cellspacing = "";
	$attr->table->frame = "";
	$attr->table->rules = "";
	$attr->table->summary = "";
	$attr->table->width = "";	
	
	// Get default attributes for html forms...
	$attr->form = new stdclass;
	$attr->form->action = "index.php";
	$attr->form->accept = "";
	$attr->form->enctype = "";
	$attr->form->method = "post";
	$attr->form->name = "form";
	$attr->form->target = "";
	
	// All done, at least for this time being... 
    return $attr;	
}

function getpoundsettings(){
  // This function defines default attributes for html table, form and other stuff...
	$settings = new stdclass; 
	$mysidia = Registry::get("mysidia");
   	$stmt = $mysidia->db->select("pound_settings", array());
	while($row = $stmt->fetchObject()){
      $property = $row->varname;
      foreach($row as $key => $val){       
        @$settings->$property->$key = $val;
      }
	}
	return $settings;
}

function randomColor($mt=false){
    if ($mt) return [mt_rand(1,255),mt_rand(1,255),mt_rand(1,255)];
    return [rand(1,255),rand(1,255),rand(1,255)];
}

function randomShade($key,$mt=false){
    $color = randomColor($mt);
    rsort($color);
    if ((int)$color[0]<50){
        return randomShade($key,$mt);
    }

    switch($key) {
        case 'pink':
        return [$color[0],round($color[0]*(rand(10,80)/100)),round($color[0]*(rand(50,90)/100))];
    }
}

// http://php.net/manual/en/function.shuffle.php#94697
function shuffle_assoc($array){
	if (!is_array($array)) return $array;
	$keys = array_keys($array);
    shuffle($keys);
    $new = [];
    foreach ($keys as $key){
        $new[$key] = $array[$key];
    }
    return $new;
}

// http://php.net/manual/en/function.scandir.php#110570
function dirToArray($dir) { 
   
   $result = array(); 

   $cdir = scandir($dir); 
   foreach ($cdir as $key => $value) 
   { 
      if (!in_array($value,array(".",".."))) 
      { 
         if (is_dir($dir . DIRECTORY_SEPARATOR . $value)) 
         { 
            $result[$value] = dirToArray($dir . DIRECTORY_SEPARATOR . $value); 
         } 
         else 
         { 
            $result[] = $value; 
         } 
      } 
   } 
   
   return $result; 
}

function getOverride($path, $geneArray, $overrides=[]) {
	$domOrRec = 'recessive';
    if (isset($geneArray['dominant'])) {$domOrRec = 'dominant';}
    
    $markingParts = dirToArray($path.'markings'.DIRECTORY_SEPARATOR.$domOrRec.DIRECTORY_SEPARATOR.$geneArray[$domOrRec][0]);
    if (count($markingParts) == 1) {
        return $overrides;
    }
    foreach ($markingParts as $key=>$mp) {
        if (is_array($mp) && mt_rand(0,3)==0) {
            $overrides[$domOrRec][$geneArray[$domOrRec][0]][$key] = true;
        }
    }
    return $overrides;
}

function validate_avatar($link) {
  $default = 'templates/icons/default_avatar.gif';
  if ($link == $default) return $link;
  $type = minimime($link);
  if ($type == false) throw new Exception('This is not an image.');
  if ($type == 'image/gif') {
    if (!$img = @imagecreatefromgif($link)) {
      throw new Exception('This is not a suitable gif image.');
      return $default;
    }
    return $link;
  }
  if ($type == 'image/png') {
    if (!$img = @imagecreatefrompng($link)) {
      throw new Exception('This is not a suitable png image.');
      return $default;
    }
    return $link;
  }
  if ($type == 'image/jpeg') {
    if (!$img = @imagecreatefromjpeg($link)) {
      throw new Exception('This is not a suitable jpeg image.');
      return $default;
    }
    return $link;
  }

  throw new Exception('This is not an image.');

  return $default;
}

function minimime($fname) {
    $fh=fopen($fname,'rb');
    if ($fh) { 
        $bytes6=fread($fh,6);
        fclose($fh); 
        if ($bytes6===false) return false;
        if (substr($bytes6,0,3)=="\xff\xd8\xff") return 'image/jpeg';
        if ($bytes6=="\x89PNG\x0d\x0a") return 'image/png';
        if ($bytes6=="GIF87a" || $bytes6=="GIF89a") return 'image/gif';
        return 'application/octet-stream';
    }
    return false;
}