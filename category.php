<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

include('showrater.php');

$page = new Page('templates/main.tpl.php');

$catID = (int) mysql_real_escape_string($_GET['ID']);

ob_start();

require_once('lib/showlinks.php');
$numLinks = showLinks("SELECT * FROM `links` WHERE `categoryID` = '$catID';");

if($numLinks <= 0) {
	ob_clean();
	$body = 'No links in this category';
} else {
	$body = ob_get_clean();
}

$query = "SELECT `name` FROM `categories` WHERE `ID` = '$catID';";
$result = mysql_query($query);
$catName = mysql_result($result, 0, 'name');

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - '.$catName,
	"page" => $catName,
	"body" => $body
));

$page->output();

mysql_close();

?>