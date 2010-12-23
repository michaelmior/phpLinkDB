<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

if(!$session->isAdmin())
	header('Location: login.php');

$page = new Page('templates/admin.tpl.php');

ob_start();

$query = "SELECT `links`.`ID`, `title`, `description`, `url`, `outCount`, `categories`.`name` as 'category' FROM `links` ".
	"LEFT JOIN `categories` ON `categories`.`ID` = `links`.`categoryID`;";
	
$result = mysql_query($query);

if(mysql_num_rows($result) > 0) {

?>
<p>
<span class="small"><img src="images/add.gif" height="12" width="12" />
<a href="admin.links.add.php">click here to add a link</a></span>
</p>
<?php } ?>
<div id="admin_links">
<?php

while($row = mysql_fetch_assoc($result)) { ?><br>
<div class="admin_link_item">
<div class="admin_link_title" style="float: left;">
<span class="editable item:title id:<?php echo $row['ID']; ?>"><?php echo $row['title']; ?></span>
<a href="admin.links.delete.php?linkID=<?php echo $row['ID']; ?>">
<img src="images/delete.gif" height="16" width="16" alt="Delete" border="0" style="display: inline; float: right;" /></a></div>

<div class="admin_link_cat small dimmed"><strong>Category:</strong> <?php echo $row['category']; ?></div><br />
<div class="admin_link_desc editable item:description id:<?php echo $row['ID']; ?>"><?php echo $row['description']; ?></div><br />
<div class="admin_link_url">
<span class="small dimmed editable item:url id:<?php echo $row['ID']; ?>">
<?php echo $row['url']; ?> <a href="<?php echo $row['url']; ?> ">go</a></span></div><br />
<span class="small dimmed">Hits: <?php echo $row['outCount']; ?></span>
</div>
<?php } ?>
</div>
<p>
<span class="small"><img src="images/add.gif" height="12" width="12" />
<a href="admin.links.add.php">click here to add a link</a></span>
</p>
<script type="text/javascript">

window.addEvent('domready', function() {
	new eip($$('#admin_links .editable'), 'admin.links.update.php', {action: 'update', first_list: true});
});

</script>
<br />
<span class="small dimmed">click on a link title, description, or URL to edit</span>
<?

$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Admin Links',
	"page" => 'Links',
	"body" => $body
));

$page->output();

mysql_close();
?>