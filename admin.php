<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

if(!$session->isAdmin())
	header('Location: login.php');

$page = new Page('templates/admin.tpl.php');

ob_start();

?>
<link href="admin.css" rel="stylesheet" type="text/css" />

<div id="gmenu">
<span class="adminnav"><a href="admin.links.php"><img src="images/links.png" height="110" width="100" /><br />Links</a></span>
<span class="adminnav"><a href="admin.cats.php"><img src="images/cat.png" height="110" width="102" /><br />Categories</a></span>
<span class="adminnav"><a href="admin.users.php"><img src="images/users.png" height="110" width="82" /><br />Users</a></span>
</div>
<?

$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Administration',
	"page" => "Administration",
	"body" => $body
));

$page->output();

mysql_close();
?>