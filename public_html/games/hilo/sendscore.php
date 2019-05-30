<?php
/* What game is it, how many daily plays are there? */
$game_name = "HiLo";
$number_of_plays = 20;

/* This function will help sanitize input to prevent errors. */
function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

/* Find when and who! */
$day = date('z');
$username = sanitizeInput($_POST['username']);

/* This sets up the database connection. */
include("../../inc/config.php");  
$db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
if ($db->connect_error) { die("Database connection failed!"); }

/* Grab this user's info on this game from the database. */
$game_data = "SELECT * FROM adopts_games WHERE `username` = '{$username}' AND `game` = '{$game_name}'";
$result = mysqli_query($db, $game_data);
$game = mysqli_fetch_array($result);

/* If no data is found with the user having ever played before... create some! */
if (!$game) {
	$sql = "INSERT INTO `adopts_games`(`plays`, `username`, `game`, `timestamp`) VALUES ('{$number_of_plays}', '{$username}', '{$game_name}', '{$day}')";
	if ($db->query($sql) === FALSE) { echo "Error creating new game data: " . $db->error; }
}

/* If a score is being sent through post data, do this. */
if (isset($_POST['amt'])) {
	$score = sanitizeInput($_POST['amt']);
	// If there are still plays left for today's game...
	if ($game['plays'] > 0){
		// Add score to user's money.
		$sql = "UPDATE adopts_users SET `money` = money + $score WHERE `username` = '{$username}'";	
		if ($db->query($sql) === TRUE) { echo "Score updated successfully!"; } else { echo "Error updating score: " . $db->error; }

		// Reduce the number of plays left available for this game by one & updates the timestamp to reflect current day of the year.
		$plays_left = $game['plays'] - 1;
		$sql = "UPDATE adopts_games SET `plays` = '{$plays_left}', `timestamp` = '{$day}' WHERE `username` = '{$username}' AND `game` = '{$game_name}'";
		if ($db->query($sql) === TRUE) { echo "Game data updated successfully!"; } else { echo "Error updating game data: " . $db->error; }
	}
}

if (isset($_POST['plays'])) {
	// Check if today matches the timestamp in the database.
	if (date('z') != $game['timestamp']){
		// If the timestamp is different, reset plays to max and update the timestamp to today.
		$sql = "UPDATE adopts_games SET `plays` = '{$number_of_plays}', `timestamp` = '{$day}' WHERE `username` = '{$username}' AND `game` = '{$game_name}'";
		if ($db->query($sql) === TRUE) { echo "{$number_of_plays}"; } else { echo "Error updating time stamp: " . $db->error; }
	} else {
		// If the timestamp is the same, send back the state of the game.
		if ($game['plays'] <= 0){ echo "GameOver"; } else { echo $game['plays']; } 
	}
}

$db->close();
?>