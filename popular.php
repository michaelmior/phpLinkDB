<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

include('showrater.php');

$page = new Page('templates/main.tpl.php');

ob_start();

// Display links
require_once('lib/showlinks.php');
$numLinks = showLinks("SELECT * FROM `links` WHERE `outCount` > 0 ORDER BY `outCount` DESC LIMIT 50;");

if($numLinks <= 0) {
	ob_clean();
	$body = 'No popular links';
} else {
	$body = ob_get_clean();
}

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Popular',
	"page" => 'Popular',
	"body" => $body
));

$page->output();

mysql_close();
?>