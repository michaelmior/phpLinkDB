<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

$page = new Page('templates/admin.tpl.php');

// Check if form was submitted
if($_GET['delete']) {
	// Get form values
	$linkID = $_GET['linkID'];
	
	if(get_magic_quotes_gpc())
		$linkID = stripslashes($linkID);

	$linkID = mysql_real_escape_string($linkID);

	// Delete link
	$query = "DELETE FROM `links` WHERE `ID` = '$linkID';";
	$result = mysql_query($query);
	
	if($result)
		$body = 'Link successfully deleted';
	else 
		$body = 'Error deleting link';
		
} else { $body = 'Error deleting link'; }

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Admin Links',
	"page" => 'Links',
	"body" => $body
));

$page->output();

mysql_close();
?>