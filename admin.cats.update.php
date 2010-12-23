<?php 

require_once('lib/config.php');
require_once('lib/session.php');

global $session;

if(!$session->isAdmin())
	header('Location: login.php');

// Check if form was submitted
if(!isset($_POST))
	exit();

require_once('lib/config.php');

// Select appropriate action
switch($_POST['action']) {
	case 'update':
		// Update category
		$query = "UPDATE `categories` SET `name` = '".$_POST['name']."' WHERE `ID` = '".$_POST['id']."';";
		mysql_query($query);
		echo $_POST['name'];
		break;
	case 'delete':
		// Delete associated links
		$query = "DELETE FROM `links` WHERE `categoryID` = '".$_POST['id']."';";
		mysql_query($query);
		
		// Delete category
		$query = "DELETE FROM `categories` WHERE `ID` = '".$_POST['id']."';";
		mysql_query($query);
		
		break;
	case 'add':
		// Add a new category
		$query = "INSERT INTO `categories` (`name`) VALUES ('New Category');";
		mysql_query($query);
		
		$query = "SELECT LAST_INSERT_ID();";
		$result = mysql_query($query);
		$id = mysql_result($result, 0);
		
		// Output the new row
		echo '<td width="300"><span class="editable item:name id:$id">New Category</span></td>'."\n";
		echo '<td>0</td><td><span class="deletable item:name id:$id">';
		echo '<img src="images/delete.gif" height="16" width="16" alt="Delete"  />';
		echo "</span></td>\n";
		break;
}

?> 