<?php 

if(!$session->isAdmin())
	header('Location: login.php');

// Check if submitted
if(!isset($_POST))
	exit();

require_once('lib/config.php');

// Select appropriate action
switch($_POST['action']) {
	case 'update':
		// Update link
		if(isset($_POST['title'])) {
			// Update title
			$query = "UPDATE `links` SET `title` = '".$_POST['title']."' WHERE `ID` = '".$_POST['id']."';";
			mysql_query($query);
			echo $_POST['title'];
		} else if(isset($_POST['description'])) {
			// Update description
			$query = "UPDATE `links` SET `description` = '".$_POST['description']."' WHERE `ID` = '".$_POST['id']."';";
			mysql_query($query);
			echo $_POST['description'];
		} else if(isset($_POST['url'])) {
			// Update description
			$query = "UPDATE `links` SET `url` = '".$_POST['url']."' WHERE `ID` = '".$_POST['id']."';";
			mysql_query($query);
			echo $_POST['url'];
		} else {
			break;
		}
		
		break;
	case 'delete':
		// Delete link
		$query = "DELETE FROM `links` WHERE `ID` = '".$_POST['id']."';";
		mysql_query($query);
		break;
}

?> 