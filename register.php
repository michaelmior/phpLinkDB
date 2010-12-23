<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

global $session;
global $form;

// Check if user has submitted form
if(isset($_POST['register'])) {
	// Attempt registration
	$register = $session->register($_POST['username'], $_POST['password'], $_POST['password2'], $_POST['email']);

	// Inform of successful registration
	if($register == 0) {
		$page = new Page('templates/main.tpl.php');
		$page->replace_tags(array(
			"site_title" => $title.'',
			"page_title" => $title.' - Registration Successful',
			"page" => 'Registration Successful',
			"body" => 'You have successfully registered.  Click <a href="login.php">here</a> to login.'
		));
		$page->output();
		mysql_close();
		exit();
	}
}

$page = new Page('templates/main.tpl.php');

ob_start();
?>
<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
<fieldset>
<p>
<label for="username">Username</label>
<input name="username" size="20" maxlength="50" type="text" />
<?php echo $form->error('username'); ?><br /><br />
<label for="password">Password</label>
<input name="password" size="20" maxlength="20" type="password" />
<?php echo $form->error('password'); ?><br /><br />
<label for="password">Confirm</label>
<input name="password2" size="20" maxlength="20" type="password" />
<?php echo $form->error('password2'); ?><br /><br />
<label for="email">Email</label>
<input name="email" size="20" maxlength="50" type="text" />
<?php echo $form->error('email'); ?><br />
</p>
<input name="register" value="1" type="hidden" />
<label for="submit">&nbsp;</label>&nbsp;
<input name="submit" value="Register" type="submit" />
</fieldset>
</form>
<?
$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Register',
	"page" => 'Register',
	"body" => $body
));

$page->output();

mysql_close();

?>