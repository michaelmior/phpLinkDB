<?php

require_once('lib/config.php');

// Check for valid link ID
if(!isset($_GET['linkID'])) {
	header('Location: index.php');
	die();
}

// Query for link information
$query = "SELECT * FROM `links` WHERE `ID` = '".$_GET['linkID']."';";
$result = mysql_query($query);

if(mysql_num_rows($result) <=0) {
	header('Location: index.php');
	die();
}

$row = mysql_fetch_assoc($result);

// Get link information
$url = $row['url'];
$c = $row['outCount'] + 1;
$id = $row['ID'];

// Update vistor count
$query = "UPDATE `links` SET `outCount` = '$c' WHERE `ID` = '$id';";
$result = mysql_query($query);

// Redirect to url
header('Location: '.$url);

?>