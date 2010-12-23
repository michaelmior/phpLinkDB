<?php

require_once('lib/sessionmanager.php');
require_once('lib/form.php');

class Session {
	var $user;
	var $userID;
	var $level;
	var $time;
	var $loggedIn;
	var $userInfo = array();
	var $url;
	var $referrer;
	
	function Session() {
		$this->time = time();
		$this->startSession();
	}
	
	function startSession() {
		global $sm;
		
		session_start();
		
		$this->loggedIn = $this->checkLogin();
		
		if(!$this->loggedIn) {
			$this->user = $_SESSION['user'] = GUEST_NAME;
			$this->level = GUEST_LEVEL;
			$sm->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
		} else
			$sm->addActiveUser($this->user, $this->time);
			
		$sm->removeInactiveUsers();
		$sm->removeInactiveGuests();
		
		if(isset($_SESSION['url']))
			$this->referrer = $_SESSION['url'];
		else
			$this->referrer = '/';
			
		$this->url = $_SESSION['url'] = $_SERVER['PHP_SELF'];
	}
	
	function checkLogin() {
		global $sm;
		
		if(isset($_COOKIE['user']) && isset($_COOKIE['userID'])) {
			$this->user = $_SESSION['user'] = $_COOKIE['user'];
			$this->userID = $_SESSION['userID'] = $_COOKIE['userID'];
		}
		
		if(isset($_SESSION['user']) && isset($_SESSION['userID'])
			&& $_SESSION['user'] != GUEST_NAME) {
			if($sm->confirmUserID($_SESSION['user'], $_SESSION['userID'] != 0)) {
				unset($_SESSION['user']);
				unset($_SESSION['userID']);
				return false;
			}
			
			$this->userInfo = $sm->getUserInfo($_SESSION['user']);
			$this->user = $this->userInfo['username'];
			$this->userID = $this->userInfo['ID'];
			$this->level = $this->userInfo['level'];
			return true;
		} else
			return false;
	}
	
	function login($user, $pass, $remember = true) {
		global $sm, $form;
				
		$field = 'user';
		if(!$user || strlen($user = trim($user)) == 0)
			$form->setError($field, '* Username not entered');
		else {
			if(!eregi('^([a-z0-9]+)$', $user))
				$form->setError($field, '* Username not alphanumeric');
		}
		
		if(!$pass)
			$form->setError('password', '* Password not entered');
			
		if($form->numErrors > 0)
			return false;
		
		$result = $sm->confirmUserPass($user, $pass);
		
		if($result == 1)
			$form->setError('user', '* Username not found');
		else if($result == 2)
			$form->setError('password', '* Invalid password');
			
		if($form->numErrors > 0)
			return false;
		
		$this->userInfo = $sm->getUserInfo($user);
		$this->user = $_SESSION['user'] = $this->userInfo['username'];
		$this->userID = $_SESSION['userID'] = md5($this->generateRandStr(16));
		$this->level = $this->userInfo['level'];
		
		$sm->updateUserField($this->user, 'ID', $this->userID);
		$sm->addActiveUser($this->user, $this->time);
		$sm->removeActiveGuest($_SERVER['REMOTE_ADDR']);
		
		if($remember) {
			setcookie('user', $this->user, time() + COOKIE_EXPIRE, COOKIE_PATH);
			setcookie('userID', $this->userID, time() + COOKIE_EXPIRE, COOKIE_PATH);
		}
		
		return true;
	}
	
	function logout() {
		global $sm;
		
		if(isset($_COOKIE['user']) && isset($_COOKIE['userID'])) {
			setcookie('user', '', time() - COOKIE_EXPIRE, COOKIE_PATH);
			setcookie('userID', '', time() - COOKIE_EXPIRE, COOKIE_PATH);
		}
		
		unset($_SESSION['user']);
		unset($_SESSION['userID']);
		
		$this->loggedIn = false;
		
		$sm->removeActiveUser($this->user);
		$sm->addActiveGuest($_SERVER['REMOTE_ADDR'], $this->time);
		
		$this->user = GUEST_NAME;
		$this->level = GUEST_LEVEL;
	}
	
	function register($user, $pass, $pass2, $email) {
		global $form, $sm;
		
		$field = 'username';
		
		if(!$user || strlen($user = trim($user)) == 0)
			$form->setError($field, '* Username not entered');
		else if(strlen($user) < 5)
			$form->setError($field, '* Username below 5 characters');
		else if(strlen($user) > 30)
			$form->setError($field, '* Username above 30 characters');
		else if(!eregi('^([a-z0-9]+)$', $user))
			$form->setError($field, '* Username not alphanumeric');
		else if($sm->usernameTaken($user))
			$form->setError($field, '* Username already in use');

		$field = 'password';
		
		if(!$pass)
			$form->setError($field, '* Password not entered');
		else {
			if(strlen($pass) < 4)
				$form->setError($field, '* Password too short');
			else if(strlen($pass) > 20)
				$form->setError($field, '* Password too long');
		}
		
		if(strcmp($pass, $pass2))
			$form->setError('password2', '* Passwords do not match');
		
		$field = 'email';
		if(!$email || strlen($email = trim($email)) == 0)
			$form->setError($field, '* Email not entered');
		else {
			$regex = "^[_+a-z0-9-]+(\.[_+a-z0-9-]+)*"
                 ."@[a-z0-9-]+(\.[a-z0-9-]{1,})*"
                 ."\.([a-z]{2,}){1}$";
			if(!eregi($regex, $email))
				$form->setError($field, '* Email invalid');
		}
		
		if($form->numErrors > 0)
			return 1;
		else {
			if($sm->addNewUser($user, $pass, $email)) {
				return 0;
			} else
				return 2;
		}
	}
	
	function editAccount($curPass, $newPass, $email) {
	}
	
	function isAdmin() {
		return ($this->level == ADMIN_LEVEL ||
			$this->user == ADMIN_NAME);
	}
	
	function generateRandStr($len) {
		$chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
		$str = '';
		
		for($i = 0; $i < $len; $i++) {
			$pos = rand(0, strlen($chars) - 1);
			$str .= $chars{$pos};
		}
	}
};

$session = new Session;

$form = new Form;

?>