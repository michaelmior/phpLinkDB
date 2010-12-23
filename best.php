<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

include('showrater.php');

$page = new Page('templates/main.tpl.php');

ob_start();

// Display links
require_once('lib/showlinks.php');
$numLinks = showLinks("SELECT `links`.`ID`, `links`.`title`, `links`.`description`, `links`.`url`,".
	" `links`.`outCount`, `links`.`dateModified` FROM `links`, `results`".
	" WHERE `points` > 0 AND `results`.`ID` = `links`.`ID` ORDER BY `points` DESC LIMIT 50;");

if($numLinks <= 0) {
	ob_clean();
	$body = 'No best links';
} else {
	$body = ob_get_clean();
}

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Best',
	"page" => 'Best',
	"body" => $body
));

$page->output();

mysql_close();
?>