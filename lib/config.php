<?php

//require_once('error.php');

$xml = simplexml_load_file('config.xml');

$title = $xml->siteTitle;

$hostName = $xml->hostName;

$dbHost = $xml->dbHost;
$dbName = $xml->dbName;
$dbUser = $xml->dbUser;
$dbPass = $xml->dbPass;

$dbLink = mysql_connect($dbHost, $dbUser, $dbPass);
mysql_select_db($dbName);

define('ADMIN_NAME', 'admin');
define('GUEST_NAME', 'Guest');
define('ADMIN_LEVEL', 9);
define('USER_LEVEL', 1);
define('GUEST_LEVEL', 0);

define("COOKIE_EXPIRE", 60*60*24);
define("COOKIE_PATH", "/");

?>