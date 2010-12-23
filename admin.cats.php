<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

if(!$session->isAdmin())
	header('Location: login.php');

$page = new Page('templates/admin.tpl.php');

ob_start();

?>
<div id="admin_cats">
<table>
<thead>
<tr>
	<th width="300">Category Name</th>
    <th>Link Count</th>
    <th></th>
</tr>
</thead>
<tbody>
<?php

$query = "SELECT `name`, `categories`.`ID`, COUNT(`links`.`ID`) AS 'c' FROM `categories` LEFT JOIN `links`".
	"ON `links`.`categoryID` = `categories`.`ID` GROUP BY `categories`.`ID`;";
	
$result = mysql_query($query);

while($row = mysql_fetch_assoc($result)) {
	echo '<tr><td width="300"><span class="editable item:name id:'.$row['ID'].'">'.$row['name'].'</span></td>'."\n";
	echo '<td>'.$row['c'].'</td><td><span class="deletable item:name id:'.$row['ID'].'">';
	echo '<img src="images/delete.gif" height="16" width="16" alt="Delete"  />';
	echo "</span></td></tr>\n";
}
?>
</tbody>
</table>
</div>
<p>
<span class="small" id="admin_cats_add"><img src="images/add.gif" height="12" width="12" /> <a href="#">click here to add a category</a></span>
<span class="small dimmed">(reload to edit)</span>
</p>
<script type="text/javascript">
<!-- Initialize in-place editing functions -->

window.addEvent('domready', function() {
	new eip($$('#admin_cats .editable'), 'admin.cats.update.php', {action: 'update', first_list: true});
});

window.addEvent('domready', function() {
	new dip($$('#admin_cats .deletable'), 'admin.cats.update.php', {action: 'delete', first_list: true});
});

window.addEvent('domready', function() {
	new aip('admin.cats.update.php', {action: 'add', first_list: true}, {addId: 'admin_cats_add'});
});

</script>
<br />
<span class="small dimmed">click on a category name to edit</span>
<?

$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Admin Categories',
	"page" => 'Categories',
	"body" => $body
));

$page->output();

mysql_close();
?>