<?php 

require_once('lib/config.php');
require_once('lib/session.php');

global $session;

if(!$session->isAdmin())
	header('Location: login.php');

// Check if submitted
if(!isset($_POST))
	exit();

require_once('lib/config.php');

// Select appropriate action
switch($_POST['action']) {
	case 'update':
		// Update user
		if(isset($_POST['username'])) {
			// Update username
			$query = "UPDATE `users` SET `username` = '".$_POST['username']."' WHERE `ID` = '".$_POST['id']."';";
			mysql_query($query);
			echo $_POST['username'];
		} else if(isset($_POST['email'])) {
			// Update email
			$query = "UPDATE `users` SET `email` = '".$_POST['email']."' WHERE `ID` = '".$_POST['id']."';";
			mysql_query($query);
			echo $_POST['email'];
		} else {
			break;
		}
		
		break;
	case 'delete':
		// Delete user
		$query = "DELETE FROM `users` WHERE `ID` = '".$_POST['id']."';";
		mysql_query($query);
		
		$query = "DELETE FROM `reviews` WHERE `userID` = '".$_POST['id']."';";
		mysql_query($query);
		break;
}

?> 