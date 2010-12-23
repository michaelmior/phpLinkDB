<?php

require_once('lib/config.php');

class SessionManager {
	private static $pInstance;
	
	var $numActiveUsers;
	var $numActiveGuests;
	var $numMembers;

	private function __construct() {}
	private function __clone() {}
	
	public static function getInstance() {
		if(!self::$pInstance)
			self::$pInstance = new SessionManager();
		
		return self::$pInstance;
	}
	
	private function SessionManager() {
		$this->numMembers = -1;
		
		$this->calcNumActiveUsers();
		$this->calcNumActiveGuests();
	}
	
	function confirmUserPass($user, $pass) {
		if(get_magic_quotes_gpc()) {
	  		$user = stripslashes($user);
			$pass = stripslashes($pass);
		}
	
	  $user = mysql_real_escape_string($user);
	  $pass = mysql_real_escape_string($pass);
	
	  $query = "SELECT *, UNHEX(MD5(CONCAT('$pass',`salt`))) AS 'p' FROM `users` WHERE `username` = '$user';";
	  $result = mysql_query($query);
	  
	  if(!$result || (mysql_num_rows($result) < 1))
	    return 1;
	
	  $row = mysql_fetch_assoc($result);
	  
	  if($row['password'] == $row['p'])
	  	return 0;
	  else
	  	return 2;
	}
	
	function confirmUserID($user, $userID) {
		if(!get_magic_quotes_gpc($user))
			$user = stripslashes($user);
			
		$query = "SELECT * FROM `users` WHERE `username` = '"
			. mysql_real_escape_string($user) . "';";
		$result = mysql_query($query);
		
		if(!$result || (mysql_num_rows($result) < 1))
			return 1;
		else
			return 0;
	}
	
	function usernameTaken($user) {
		if(get_magic_quotes_gpc())
			$user = stripslashes($user);
		$user = mysql_real_escape_string($user);
		
		$query = "SELECT `username` FROM `users` WHERE `username` = '".$user."';";
		$result = mysql_query($query);
		
		return (mysql_num_rows($result) > 0);
	}
	
	function addNewUser($user, $pass, $email) {
		// Prepare values for query
		if(get_magic_quotes_gpc()) {
			$user = stripslashes($user);
			$pass = stripslashes($pass);
			$email = stripslashes($email);
		}
	
		// Calculate user privilege level
		if(strcasecmp($user, ADMIN_NAME) == 0)
		  $ulevel = ADMIN_LEVEL;
		else
		  $ulevel = GUEST_LEVEL;
		
		// Generate random salt value
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$salt = '';
		
		for($i = 0; $i < 8; $i++) {
			$pos = rand(0, strlen($chars) - 1);
			$salt .= $chars{$pos};
		}
		
		// Add user
		$query = "INSERT INTO `users` (`level`, `username`, `password`, `salt`, `email`) VALUES ('"
			. $ulevel . "', '" . mysql_real_escape_string($user) . "', UNHEX(MD5('" . mysql_real_escape_string($pass)
			. "$salt')), '" . $salt . "', '" . mysql_real_escape_string($email) . "');";
			
		return mysql_query($query);
	}
	
	function updateUserField($user, $field, $value) {
		$query = "UPDATE `users` SET `".$field."` = '".$value."' WHERE `username` = '".$user."';";
		
		return mysql_query($query);
	}
	
	function getUserInfo($user) {
		$query = "SELECT * FROM `users` WHERE `username` ='".$user."';";
	
		$result = mysql_query($query);
		
		if(!$result || (mysql_num_rows($result) < 1))
			return NULL;
		
		return mysql_fetch_assoc($result);
	}
	
	function getNumMembers() {
		$query = "SELECT COUNT(*) AS 'c' FROM `users`;";
		$result = mysql_query($query);
		
		$this->numMembers = mysql_result($result, 0, 'c');
		
		return $this->numMembers;
	}
	
	function calcNumActiveUsers() {
		$query = "SELECT COUNT(*) AS 'c' FROM `activeUsers`;";
		$result = mysql_query($query);
		
		$this->numActiveUsers = mysql_result($result, 0, 'c');
		
		return $this->numActiveUsers;
	}
	
	function calcNumActiveGuests() {
		$query = "SELECT COUNT(*) AS 'c' FROM `activeGuests`;";
		$result = mysql_query($query);
		
		$this->numActiveGuests = mysql_result($result, 0, 'c');
		
		return $this->numActiveGuests;
	}
	
	function addActiveUser($user, $time) {
		$query = "REPLACE INTO `activeUsers` VALUES('$user', '$time');";
		$result = mysql_query($result);
		
		$this->calcNumActiveUsers();
	}
	
	function addActiveGuest($ip, $time) {
		$query = "REPLACE INTO `activeGuests` VALUES('$ip', '$time');";
		$result = mysql_query($query);
		
		$this->calcNumActiveGuests();
	}
	
	function removeActiveUser($user) {
		$query = "DELETE FROM `activeUsers` WHERE `username` = '$user';";
		$result = mysql_query($query);
		
		$this->calcNumActiveUsers();
	}
	
	function removeActiveGuest($ip) {
		$query = "DELETE FROM `activeGuests` WHERE `ip` = '$ip';";
		$result = mysql_query($query);
		
		$this->calcNumActiveGuests();
	}
	
	function removeInactiveUsers() {
		$timeout = time() - 15 * 60;
		$query = "DELETE FROM `activeusers` WHERE `timestamp` < '$timeout';";
		mysql_query($query);
		$this->calcNumActiveUsers();
	}
	
	function removeInactiveGuests() {
		$timeout = time() - 5 * 60;
		$query = "DELETE FROM `activeguests` WHERE `timestamp` < '$timeout';";
		mysql_query($query);
		$this->calcNumActiveGuests();
	}
};

$sm = SessionManager::getInstance();

?>