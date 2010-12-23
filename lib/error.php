<?php
// Turns off all error reporting
error_reporting(0); 

function userErrorHandler($errno, $errmsg, $filename, $linenum, $vars) 
{
    // Timestamp for the error entry
    $dt = date('Y-m-d H:i:s (T)');

    // Define an array of error strings
    $errortype = array (
                E_ERROR => 'Error',
                E_WARNING => 'Warning',
                E_PARSE => 'Parsing Error',
                E_NOTICE => 'Notice',
                E_CORE_ERROR => 'Core Error',
                E_CORE_WARNING => 'Core Warning',
                E_COMPILE_ERROR => 'Compile Error',
                E_COMPILE_WARNING => 'Compile Warning',
                E_USER_ERROR => 'User Error',
                E_USER_WARNING => 'User Warning',
                E_USER_NOTICE => 'User Notice',
                E_STRICT => 'Runtime Notice'
                );
    // Set of errors for which a var trace will be saved
    $user_errors = array(E_USER_ERROR, E_USER_WARNING, E_USER_NOTICE);
  
    $err = "<errorentry>\r\n";
    $err .= "\t<datetime>" .$dt. "</datetime>\r\n";
    $err .= "\t<errornum>" .$errno. "</errornum>\r\n";
    $err .= "\t<errortype>" .$errortype[$errno]. "</errortype>\r\n";
    $err .= "\t<errormsg>" .$errmsg. "</errormsg>\r\n";
    $err .= "\t<scriptname>" .$filename. "</scriptname>\r\n";
    $err .= "\t<scriptlinenum>" .$linenum. "</scriptlinenum>\r\n";

    if (in_array($errno, $user_errors)) {
        $err .="\t<vartrace>".wddx_serialize_value($vars,'Variables')."</vartrace>\r\n";
    }
    $err .= "</errorentry>\r\n\r\n";

    // Save to the error log file
    error_log($err, 3, 'error.log');
}
$old_error_handler = set_error_handler('userErrorHandler');
?>