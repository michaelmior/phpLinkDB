<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

if(!$session->isAdmin())
	header('Location: login.php');

$page = new Page('templates/admin.tpl.php');

// Check if form was submitted
if($_POST['add']) {
	// Get form values
	$linkTitle = $_POST['title'];
	$url = $_POST['url'];
	$category = $_POST['category'];
	$description = $_POST['description'];
	
	if(get_magic_quotes_gpc()) {
		$linkTitle = stripslashes($linkTitle);
		$url = stripslashes($url);
		$category = stripslashes($category);
		$description = stripslashes($description);
	}
	
	$linkTitle = mysql_real_escape_string($linkTitle);
	$url = mysql_real_escape_string($url);
	$category = mysql_real_escape_string($category);
	$description = mysql_real_escape_string($description);
	
	// Get the ID of the current user
	global $session;
	$user = $session->user;
	$query = "SELECT `ID` FROM `users` WHERE `username` = '$user';";
	$result = mysql_query($query);
	
	if(mysql_num_rows($result) > 0)
		$userID = mysql_result($result, 0, 'ID');
	else
		$userID = 0;
	
	// Add link
	$query = "INSERT INTO `links` (`categoryID`, `submittedBy`, `title`, `description`, `url`, `dateAdded`, `dateModified`)".
		" VALUES ('$category', '$userID', '$linkTitle', '$description', '$url', NOW(), NOW());";
	$result = mysql_query($query);
	
	if($result)
		$body = 'Link successfully added';
	else 
		$body = 'Error adding link';
} else {

ob_start();

$query = "SELECT * FROM `categories`;";
$result = mysql_query($query);

if(mysql_num_rows($result) > 0) {

?>

<form name="add" action="admin.links.add.php" method="post">
<fieldset>
<p>
<label for="title">Title</label>
<input type="text" name="title" size="50" maxlength="100" /><br /><br />
<label for="url">URL</label>
<input type="text" name="url" size="50" maxlength="500" /><br /><br />
<label for="category">Category</label>
<select name="category">
<?php

while($row = mysql_fetch_assoc($result)) {
	echo '<option value="'.$row['ID'].'">'.$row['name']."</option>\n";
}

?>
</select><br /><br />
<label for="description">Description</label>
<textarea name="description" rows="10" cols="40"></textarea>
</p>
<input type="hidden" name="add" value="1" />
<label for="submit">&nbsp;</label>&nbsp;
<input type="submit" value="Add" />
</fieldset>
</form>
<?php

$body = ob_get_clean();

} else { $body = 'Please add one or more categories before adding links'; }
}

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Admin Links',
	"page" => 'Links',
	"body" => $body
));

$page->output();

mysql_close();
?>