<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

include('showrater.php');

$page = new Page('templates/main.tpl.php');

ob_start();

require_once('lib/showlinks.php');
$numLinks = showLinks("SELECT * FROM `links` WHERE `dateModified` > SUBDATE(NOW(), INTERVAL 1 DAY) LIMIT 50;");

if($numLinks <= 0) {
	ob_clean();
	$body = 'No new links';
} else {
	$body = ob_get_clean();
}

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - New',
	"page" => 'New',
	"body" => $body
));

$page->output();

mysql_close();
?>