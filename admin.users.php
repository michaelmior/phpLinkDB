<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

if(!$session->isAdmin())
	header('Location: login.php');

$page = new Page('templates/admin.tpl.php');

ob_start();

?>
<div id="admin_users">
<table>
<thead>
<tr>
	<th>Username</th>
    <th>Email</th>
    <th></th>
</tr>
</thead>
<tbody>
<?php

$query = "SELECT `username`, `email` FROM `users`;";
	
$result = mysql_query($query);

while($row = mysql_fetch_assoc($result)) {
	echo '<tr><td width="300"><span class="editable item:user id:'.$row['ID'].'">'.$row['username'].'</span></td>'."\n";
	echo '<td width="300"><span class="editable item:email id:'.$row['ID'].'">'.$row['email'].'</span></td>'."\n";
	echo '<td><img src="images/delete.gif" height="16" width="16" alt="Delete"  /></td>';
	echo "</span></td></tr>\n";
}
?>
</tbody>
</table>
</div>
<script type="text/javascript">
<!-- Initialize in-place editing functions -->

window.addEvent('domready', function() {
	new eip($$('#admin_users .editable'), 'admin.users.update.php', {action: 'update', first_list: true});
});

window.addEvent('domready', function() {
	new dip($$('#admin_users .deletable'), 'admin.users.update.php', {action: 'delete', first_list: true});
});

</script>
<br />
<span class="small dimmed">click on a username or email to edit</span>
<?

$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Admin Users',
	"page" => 'Users',
	"body" => $body
));

$page->output();

mysql_close();
?>