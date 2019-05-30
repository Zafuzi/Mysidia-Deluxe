<?php

use Resource\Native\Str;
use Resource\Native\Obj;

class Event extends Obj {

    public $eid;
    public $name;
    public $startson;
    public $endson;
  
    public function __construct($eid){
        if ($eid == -1) {$this->eid = -1; return;}
    $mysidia = Registry::get("mysidia");
    $row = $mysidia->db->select("events", array(), "eid ='{$eid}'")->fetchObject();

    if(!is_object($row)) throw new Exception("Invalid Event specified");
        // loop through the anonymous object created to assign properties
        foreach($row as $key => $val){
            $this->$key = $val;         
        }
    }

  public function isActive() {
      if ($this->eid == -1) return true;
     $isActive = false;
     $startson_s = explode('-', $this->startson);
     $endson_s = explode('-', $this->endson);
     $today = date('d-m');     
     $today_s = explode('-', $today);
          
      if($startson_s[1] == $endson_s[1]){
         if($today_s[1] == $startson_s[1] && $today_s[0] >= $startson_s[0] && $today_s[0] < $endson_s[0]){
                 $isActive = true;
         }
      }
      else if($startson_s[1] < $endson_s[1]){
          
          if($today_s[1] >= $startson_s[1] && $today_s[1] <= $endson_s[1]){
              if($today_s[1] == $startson_s[1]){
                  if($today_s[0] >= $startson_s[0])
                      $isActive = true;
              }
              else if($today_s[1] == $endson_s[1]){
                  if($today_s[0] < $endson_s[0])
                      $isActive = true;
              }
             else
                    $isActive = true;          
          }
                    
      }    
      else {
      
          if($today_s[1] >= $startson_s[1] || $today_s[1] <= $endson_s[1]){
              if($today_s[1] == $startson_s[1]){
                  if($today_s[0] >= $startson_s[0])
                      $isActive = true;
              }
              else if($today_s[1] == $endson_s[1]){
                  if($today_s[0] < $endson_s[0])
                      $isActive = true;
              }
             else
                    $isActive = true;          
          }      
      
      }
         
     return $isActive;
  }
  
}