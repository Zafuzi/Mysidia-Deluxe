<?php
namespace services\Crons;

$file = dirname(__DIR__).'/../inc/config.php';
include($file);
$db = new \PDO('mysql:host=localhost;dbname=atrocity_mysidia', DBUSER, DBPASS);
//$db = new \PDO('mysql:host=localhost;dbname=atrocity_mysidia', 'root', '');

/*
$stmt = $db->prepare('INSERT INTO adopts_adoptable_stats (`aid`,`stat`,`value`) VALUES (:aid, :stat, :value)');
$stmt->bindParam(':aid', $aid);
$stmt->bindParam(':stat', $stat);
$stmt->bindParam(':value', $value);
$aid = 1;
$stat = 'test';
$value = 'pass';
$stmt->execute();

$db = null;
exit;
*/

// Dead Pets check if have any kids
$stmt = $db->query('SELECT aid FROM adopts_owned_adoptables WHERE isdead = 1');
$ids1 = killPets($stmt, $db);
if (count($ids1['deleteIds']) > 0){
	$deleteFromDatabase = implode(',', $ids1['deleteIds']);
	$stmt = $db->query("DELETE FROM adopts_owned_adoptables WHERE aid IN($deleteFromDatabase)");
}

// Pound updates
$stmt = $db->query('SELECT aid FROM adopts_pounds WHERE currentowner="SYSTEM" AND DATE(datepound) <= DATE(CURDATE()-1)');
$ids = killPets($stmt, $db);
$deleteFromPoundIds = array_unique(array_merge($ids['deadIds'], $ids['deleteIds']));
if (count($deleteFromPoundIds) > 0){
	$poundIds = implode(',',$deleteFromPoundIds);
	$db->query("DELETE FROM adopts_pounds WHERE aid IN($poundIds)");
}

if (count($ids['deleteIds']) > 0){
	$deleteFromDatabase = implode(',', $ids['deleteIds']);
	$db->query("DELETE FROM adopts_owned_adoptables WHERE aid IN($deleteFromDatabase)");
}

if (count($ids['deadIds']) > 0){
	$setAsDead = implode(',', $ids['deadIds']);
	$stmt = $db->query("UPDATE adopts_owned_adoptables SET isdead=1, isrunaway=0, owner='SYSTEM' WHERE aid IN($setAsDead)");
}

function killPets($stmt, $db) {
	$deleteIds = [];
	$deadIds = [];
	$baby_query = 'SELECT aid FROM adopts_owned_adoptables WHERE sire_id = :id OR dam_id = :id';
	$babyQuery = $db->prepare($baby_query);
	foreach ($stmt as $poid) {
		$poid = (int) $poid['aid'];
		// Check if pet has offspring, if not we can delete it
		$babyQuery->execute([':id'=>$poid]);
		$babies = $babyQuery->rowCount();
		if ($babies == 0){
			// No offspring, safe to delete.
			$deleteIds[] = $poid;
			$pictures = glob($_SERVER['DOCUMENT_ROOT'].'/picuploads/pets/'.$poid.'*.png');
			foreach ($pictures as $pic){
				unlink($pic);
			}
		}else{
			// Add to array to set as dead in database.
			$deadIds[] = $poid;
		}
	}
	return ['deadIds'=>$deadIds, 'deleteIds'=>$deleteIds];
}

// Lower all stats, except for frozen and dead pets.
$stmt = $db->prepare('UPDATE `adopts_adoptable_stats` JOIN `adopts_owned_adoptables` ON adopts_owned_adoptables.aid = adopts_adoptable_stats.id SET `happiness` = `happiness`-5, `closeness`=`closeness`-5, `hunger`=`hunger`-5, `thirst`=`thirst`-5 WHERE adopts_owned_adoptables.isfrozen = "no" AND adopts_owned_adoptables.isdead = 0');
$stmt->execute();

/*
$stmt = $db->prepare('INSERT INTO adopts_adoptable_stats (`aid`,`stat`,`value`) VALUES (:aid, :stat, :value)');
$stmt->bindParam(':aid', $aid);
$stmt->bindParam(':stat', $stat);
$stmt->bindParam(':value', $value);
$aid = 1;
$stat = 'test';
$value = 'pass';
$stmt->execute();
*/

$db = null;