<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

$page = new Page('templates/main.tpl.php');

ob_start();

?>
<p style="line-height: 1.5em;">
The phpLinkDB application is designed to maintain a databse of website links
for the purpoes of creating a useful web portal for users of the application.
It was initially developed by <a href="mailto:michael@mior.ca">Michael Mior</a>
in the fall of 2007 for the requirements of the Database Systems
course at the <a href="http://www.uoit.ca/">University of Ontario Institute of
Technology</a>.
</p>
<?

$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - About',
	"page" => 'About',
	"body" => $body
));

$page->output();

mysql_close();
?>