<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

include('showrater.php');

$page = new Page('templates/main.tpl.php');

ob_start();

if(isset($_GET['q'])) {

$q = $_GET['q'];
if(get_magic_quotes_gpc())
	$q = stripslashes($q);

$q = mysql_real_escape_string($q);

$query = "SELECT * FROM `links` WHERE MATCH(`title`, `description`) AGAINST('$q');";

require_once('lib/showlinks.php');
showLinks($query);

?>

<?
}
$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Search',
	"page" => 'Search',
	"body" => $body
));

$page->output();

mysql_close();
?>