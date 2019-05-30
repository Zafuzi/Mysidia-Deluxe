<?php

define("SUBDIR", "Install");
include("../inc/config.php");

try{
    $dsn = "mysql:host=".constant("DBHOST").";dbname=".constant("DBNAME");
    $prefix = constant("PREFIX");
    $adopts = new PDO($dsn, DBUSER, DBPASS); 
}
catch(PDOException $pe){
    die("Could not connect to database, the following error has occurred: <br><b>{$pe->getmessage()}</b>");  
} 

$adopts->query("INSERT INTO ".constant("PREFIX")."acp_hooks VALUES  (NULL, 'Alchemy Plugin v1.3.4 by Hall of Famer', 'http://www.mysidiaadoptables.com/forum/showthread.php?t=4368', 'alchemy', 1)");		 
$adopts->query("INSERT INTO ".constant("PREFIX")."items_functions VALUES (NULL, 'Recipe', 'no', 'This item function defines items that acts as recipe for alchemy practices.')");
$adopts->query("CREATE TABLE ".constant("PREFIX")."alchemy (alid int NOT NULL AUTO_INCREMENT PRIMARY KEY, item int DEFAULT 0, item2 int DEFAULT 0, newitem int DEFAULT 0, chance int DEFAULT 0, recipe int DEFAULT 0)");
$adopts->query("CREATE TABLE ".constant("PREFIX")."alchemy_settings (asid int NOT NULL AUTO_INCREMENT PRIMARY KEY, name varchar(20), value varchar(40))");

$adopts->query("INSERT INTO ".constant("PREFIX")."alchemy_settings (asid, name, value) VALUES (1, 'system', 'enabled')");
$adopts->query("INSERT INTO ".constant("PREFIX")."alchemy_settings (asid, name, value) VALUES (2, 'chance', 'enabled')");
$adopts->query("INSERT INTO ".constant("PREFIX")."alchemy_settings (asid, name, value) VALUES (3, 'recipe', 'enabled')");
$adopts->query("INSERT INTO ".constant("PREFIX")."alchemy_settings (asid, name, value) VALUES (4, 'cost', 500)");
$adopts->query("INSERT INTO ".constant("PREFIX")."alchemy_settings (asid, name, value) VALUES (5, 'license', '')");
$adopts->query("INSERT INTO ".constant("PREFIX")."alchemy_settings (asid, name, value) VALUES (6, 'usergroup', 'all')");

echo "Successfully carried out database operations for Alchemy Mod.";
	
?>