<?php
require_once('lib/config.php');
require_once('lib/session.php');

// Log out the user
global $session;
$session->logout();

// Redirect to the previous page
header('Location: '.$_SERVER['HTTP_REFERER']);

?>