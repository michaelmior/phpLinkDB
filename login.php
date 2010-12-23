<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

global $session;
global $form;

// If the user is already logged in, redirect to home page
if($session->checkLogin()) {
	header('Location: index.php');
}

// Check if user has submitted login form
if(isset($_POST['login'])) {
	// Attempt login
	$login = $session->login($_POST['username'], $_POST['password']);
	
	// Check if login failed
	if(!$login) {
		$_SESSION['values'] = $_POST;
		$_SESSION['errors'] = $form->getErrorArray();
	}
	
	header('Location: '.$session->referrer);
}

$page = new Page('templates/main.tpl.php');

ob_start();
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset>
<p>
<label for="username">Username</label>
<input name="username" size="20" maxlength="50" type="text" value="<?php echo $form->value('user'); ?>"/>
<?php echo $form->error('user'); ?><br />
<label for="password">Password</label>
<input name="password" size="20" maxlength="20" type="password" />
<?php echo $form->error('password'); ?><br />
</p>
<input name="login" value="1" type="hidden" />
<label for="submit">&nbsp;</label>&nbsp;
<input name="submit" value="Login" type="submit" />
</fieldset>
</form>
<p style="text-align: center;"><a href="register.php">Register here</a></p>
<?
$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Login',
	"page" => 'Login',
	"body" => $body
));

$page->output();

mysql_close();

?>