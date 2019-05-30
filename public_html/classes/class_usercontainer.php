<?php

use Resource\Native\Obj;

abstract class UserContainer extends Obj implements Container{
  // The abstract UserContainer class
     
  public function getcreator($fetchmode = "Members"){
     // The UserContainer usually consists of users
	 
	 switch($fetchmode){
	    case "Members":
          return new MemberCreator();
		  break;
        case "Visitors":
          return new VisitorCreator();
          break;
        default:
          return FALSE;		
     }
  }
  
  public abstract function gettotal();
} 
?>