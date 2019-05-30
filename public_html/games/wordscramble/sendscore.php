<?php

function sanitizeInput($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

if (isset($_POST['amt'])) {
	$score = sanitizeInput($_POST['amt']);
	$username = sanitizeInput($_POST['username']);
	$cookie_name = 'mysusername';
	$cookievalue = $_COOKIE[$cookie_name];
        if ($cookievalue != $username) {
            $warning = "Please do not exploit the system!";
            return $warning;
        }
        else{
            include("../../inc/config.php");  
	    $db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	    if ($db->connect_error) { die("Database connection failed!"); }

	    // Grab this user's info on this game from the database.
	    $sql = "SELECT * FROM adopts_games WHERE `username` = '{$username}' AND `game` = 'WordScramble'";
	    $result = mysqli_query($db, $sql);
	    $game = mysqli_fetch_array($result);

	// If there are still plays left for today's game...
	    if ($game['plays'] > 0){
		// Add score to user's money.
		$sql = "UPDATE adopts_users SET `money` = money + $score WHERE `username` = '{$username}'";	
		if ($db->query($sql) === TRUE) { echo "Score updated successfully!";	} else { echo "Error updating score: " . $db->error; }

		// Reduce the number of plays left available for this game by one & updates the timestamp to reflect current day of the year.
		$day = date('z');
		$plays = $game['plays'] - 1;
		$sql = "UPDATE adopts_games SET `plays` = '{$plays}', `timestamp` = '{$day}' WHERE `username` = '{$username}' AND `game` = 'WordScramble'";
		if ($db->query($sql) === TRUE) { echo "Game data updated successfully!"; } else { echo "Error updating game data: " . $db->error; }
	    }
	    $db->close();
	}
}

if (isset($_POST['plays'])) {
	$plays = sanitizeInput($_POST['plays']);
	$username = sanitizeInput($_POST['username']);
	$cookie_name = 'mysusername';
	$cookievalue = $_COOKIE[$cookie_name];
        if ($cookievalue != $username) {
            $warning = "Please do not exploit the system!";
            return $warning;
        }
        else{
	    include("../../inc/config.php");  
	    $db = new mysqli(DBHOST, DBUSER, DBPASS, DBNAME);
	    if ($db->connect_error) { die("Database connection failed!"); }
	    // Grab this user's info on this game from the database.
	    $sql = "SELECT * FROM adopts_games WHERE `username` = '{$username}' AND `game` = 'WordScramble'";
	    $result = mysqli_query($db, $sql);
	    $game = mysqli_fetch_array($result);

	   // Check if today matches the timestamp in the database.
	    if (date('z') != $game['timestamp']){
		// If the timestamp is different, reset plays to max and update the timestamp to today.
		$day = date('z');
		$sql = "INSERT INTO `adopts_games`(`plays`, `username`, `game`, `timestamp`) VALUES ('20', '{$username}', 'WordScramble', '{$day}') ON DUPLICATE KEY UPDATE `plays` = 20, `timestamp` = '{$day}'";
		if ($db->query($sql) === TRUE) { echo "20"; } else { echo "Error updating game data: " . $db->error; }
	    } else {
		// If the timestamp is the same, check how many plays are left.
		if ($game['plays'] <= 0){
			echo "GameOver"; 
		} else { echo $game['plays']; } 
	    }
	    $db->close();
	}
}

?>