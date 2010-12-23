<?php

class Form {
	var $values = array();
	var $errors = array();
	var $numErrors = 0;
	
	function Form() {
		if(isset($_SESSION['values']) && isset($_SESSION['errors'])) {
			$this->values = $_SESSION['values'];
			$this->errors = $_SESSION['errors'];
			$this->numErrors = count($this->errors);
			
			unset($_SESSION['values']);
			unset($_SESSION['errors']);
		} else
			$this->numErrors = 0;
	}
	
	function setValue($field, $value) {
		$this->values[$field] = $value;
	}
	
	function setError($field, $errmsg) {
		$this->errors[$field] = $errmsg;
		$this->numErrors = count($this->errors);
	}
	
	function value($field) {
  	  if(array_key_exists($field,$this->values))
         return htmlspecialchars(stripslashes($this->values[$field]));
      else
         return '';
	}
	
	function error($field) {
	  if(array_key_exists($field,$this->errors)) {
         return '<span class="error">'.$this->errors[$field].'</span>';
      } else
         return '';
	}
	
	function getErrorArray() {
		return $this->errors;
	}

};

?>