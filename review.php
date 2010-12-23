<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

$page = new Page('templates/main.tpl.php');

global $session;

// Check if value submitted
if(isset($_POST['review'])) {
	// Check if the user is logged in
	if(!$session->checkLogin()) {
		$body = 'Sorry, you must <a href="login.php">login</a> to submit reviews';
	} else {
	
	// Get form values
	$linkID = $_POST['linkID'];
	$review = $_POST['review'];
	
	if(get_magic_quotes_gpc()) {
		$linkID = stripslashes($linkID);
		$review = stripslashes($review);
	}
	
	$linkID = mysql_real_escape_string($linkID);
	$review = mysql_real_escape_string($review);
	
	// Get user ID
	$query = "SELECT `ID` FROM `users` WHERE `username` = '".$session->user."';";
	$result = mysql_query($query);
	$userID = mysql_result($result, 0, 'ID');
	
	// Add review
	$query = "INSERT INTO `reviews` (`userID`, `linkID`, `review`) VALUES ('$userID', '$linkID', '$review');";
	$result = mysql_query($query);
	
	if($result)
		$body = '<p>Thank you for submitting your review. Close this window to continue browsing</p>';
	else
		$body = 'Error submitting review';
}} else {
	$body = 'Error submitting review';
}

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Review',
	"page" => 'Review',
	"body" => $body
));

$page->output();

mysql_close();
?>