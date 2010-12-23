<?php
    function module_server_check ($step) {
        $step['arguments'] = base64_decode($step['arguments']);
        $step['arguments'] = unserialize($step['arguments']);
        ob_start();
        phpinfo(INFO_MODULES);
        $_28 = ob_get_contents();
        ob_end_clean();
        $_29 = explode("<h2", $_28);
        $_2A = array();
        foreach($_29 as $_2B) {
            preg_match("/<a name=\"module_([^<>]*)\">/", $_2B, $_2C);
            preg_match_all("/<tr[^>]*> <td[^>]*>(.*)<\/td> <td[^>]*>(.*)<\/td>/Ux", $_2B, $_2D);
            preg_match_all("/<tr[^>]*> <td[^>]*>(.*)<\/td> <td[^>]*>(.*)<\/td> <td[^>]*>(.*)<\/td>/Ux", $_2B, $_2E);
            foreach($_2D[0] as $_2F => $_2B) {
                $_2A[trim($_2C[1])][trim(strip_tags($_2D[1][$_2F]))] = array(strip_tags(trim($_2D[2][$_2F])));
            }
            foreach($_2E[0] as $_2F => $_2B) {
                $_2A[trim($_2C[1])][trim(strip_tags($_2E[1][$_2F]))] = array(strip_tags(trim($_2E[2][$_2F])), strip_tags($_2E[3][$_2F]));
            }
        }
        
        while (list($name, $_30) = each($step['arguments'])) {
            switch ($name) {
                case 'php':
                if (version_compare(phpversion(), $_30, '>=') == 1) {
                    $_20 .= module_server_check_okay('PHP '.$_30.' Installed');
                } else {
                    $_20 .= module_server_check_fail('PHP '.$_30.' Not Installed');
                }
                break;
                case 'gd':
                if (extension_loaded('gd')) {
                    $_2A['gd']['GD Version']['0'] = str_replace('bundled (', '', $_2A['gd']['GD Version']['0']);
                    $_2A['gd']['GD Version']['0'] = substr($_2A['gd']['GD Version']['0'], '0', '1');
                    if (version_compare($_2A['gd']['GD Version']['0'], $_30, 'eq') == 1) {
                        $_20 .= module_server_check_okay('GD '.$_30.' Installed');
                    } else {
                        $_20 .= module_server_check_fail('GD '.$_30.' Not Installed');
                    }
                } else {
                    $_20 .= module_server_check_fail('GD '.$_30.' Not Installed');
                }
                break;
                case 'apache':
                if (is_array($_2A['apache']) or is_array($_2A['apache2handler'])) {
                    $_20 .= module_server_check_okay('Apache Installed');
                } else {
                    $_20 .= module_server_check_fail('Apache Not Installed');
                }
                break;
                case 'curl':
                if (function_exists(curl_version)) {
                    $_31 = curl_version();
                } else {
                    $_20 .= module_server_check_fail('Curl '.$_30.' Not Installed');
                    break;
                }
                if (is_array($_31)) {
                    if (version_compare($_31['version'], $_30, '>=') == 1) {
                        $_20 .= module_server_check_okay('Curl '.$_30.' Installed');
                    } else {
                        $_20 .= module_server_check_fail('Curl '.$_30.' Not Installed');
                    }
                } else {
                    if (version_compare($_31, $_30, '>=') == 1) {
                        $_20 .= module_server_check_okay('Curl '.$_30.' Installed');
                    } else {
                        $_20 .= module_server_check_fail('Curl '.$_30.' Not Installed');
                    }
                }
                break;
                case 'domxml':
                if (function_exists(domxml_version)) {
                    $_32 = domxml_version();
                } else {
                    $_20 .= module_server_check_fail('DOM XML '.$_30.' Not Installed');
                    break;
                }
                if (version_compare($_32, $_30, '>=') == 1) {
                    $_20 .= module_server_check_okay('DOM XML '.$_30.' Installed');
                } else {
                    $_20 .= module_server_check_fail('DOM XML '.$_30.' Not Installed');
                }
                break;
                case 'zend':
                if (function_exists(zend_version)) {
                    $_33 = zend_version();
                } else {
                    $_20 .= module_server_check_fail('Zend '.$_30.' Not Installed');
                    break;
                }
                if (version_compare($_33, $_30, '>=') == 1) {
                    $_20 .= module_server_check_okay('Zend '.$_30.' Installed');
                } else {
                    $_20 .= module_server_check_fail('Zend '.$_30.' Not Installed');
                }
                break;
                case 'ioncube':
                if (extension_loaded('ionCube Loader')) {
                    $_20 .= module_server_check_okay('IonCube Loaders Installed');
                } else {
                    $_20 .= module_server_check_fail('IonCube Loaders Not Installed');
                }
                break;
                case 'ssh2':
                if (extension_loaded('ssh2')) {
                    $_20 .= module_server_check_okay('SSH2 PHP Extension Installed');
                } else {
                    $_20 .= module_server_check_fail('SSH2 PHP Extension Not Installed');
                }
                break;
                case 'tokenizer':
                if (extension_loaded('tokenizer')) {
                    $_20 .= module_server_check_okay('Session PHP Extension Installed');
                } else {
                    $_20 .= module_server_check_fail('Session PHP Extension Not Installed');
                }
                break;
                case 'standard':
                if (extension_loaded('tokenizer')) {
                    $_20 .= module_server_check_okay('Standard PHP Extension Installed');
                } else {
                    $_20 .= module_server_check_fail('Standard PHP Extension Not Installed');
                }
                break;
                case 'sockets':
                if (extension_loaded('tokenizer')) {
                    $_20 .= module_server_check_okay('Sockets PHP Extension Installed');
                } else {
                    $_20 .= module_server_check_fail('Sockets PHP Extension Not Installed');
                }
                break;
                case 'mcrypt':
                if (function_exists('mcrypt_encrypt')) {
                    $_20 .= module_server_check_okay('mcrypt Library Installed');
                } else {
                    $_20 .= module_server_check_fail('mcrypt Library Not Installed');
                }
                break;
                case 'session':
                if (extension_loaded('tokenizer')) {
                    $_20 .= module_server_check_okay('Session PHP Extension Installed');
                } else {
                    $_20 .= module_server_check_fail('Session PHP Extension Not Installed');
                }
                break;
                case 'posix':
                if (extension_loaded('posix')) {
                    $_20 .= module_server_check_okay('Posix PHP Extension Installed');
                } else {
                    $_20 .= module_server_check_fail('Posix PHP Extension Not Installed');
                }
                break;
                case 'ctype':
                if (extension_loaded('ctype')) {
                    $_20 .= module_server_check_okay('Ctype PHP Extension Installed');
                } else {
                    $_20 .= module_server_check_fail('Ctype PHP Extension Not Installed');
                }
                break;
                case 'safemode':
                   $safemode = ini_get('register_globals');
                   if (($safemode == 0) || (empty($safemode))) {
                      $_20 .= module_server_check_okay('SAFE MODE is OFF');
                   } else {
                      $_20 .= module_server_check_fail('SAFE MODE is ON');
                   }
                break;
                
                case 'registerglobals':
                   $register_globals = ini_get('register_globals');
                   if (($register_globals == 0) || (empty($register_globals))) {
                      $_20 .= module_server_check_okay('REGISTER GLOBALS is OFF');
                   } else {
                      $_20 .= module_server_check_fail('REGISTER GLOBALS is ON');
                   }
                break;
                
                case 'sqlite':
                if (function_exists(sqlite_libversion)) {
                    $_34 = sqlite_libversion();
                } else {
                    $_20 .= module_server_check_fail('SQLite '.$_30.' Not Installed');
                    break;
                }
                if (version_compare($_34, $_30, '>=') == 1) {
                    $_20 .= module_server_check_okay('SQ
                        Lite '.$_30.' Installed');
                } else {
                    $_20 .= module_server_check_fail('SQLite '.$_30.' Not Installed');
                }
                break; case 'mod_rewrite':if (strstr($_2A['apache']['Loaded Modules']['0'], 'mod_rewrite')) {
                    $_20 .= module_server_check_okay('mod_rewrite Installed');
                } else {
                    $_20 .= module_server_check_fail('mod_rewrite Not Installed');
                }
                break; case 'mod_security':if (strstr($_2A['apache']['Loaded Modules']['0'], 'mod_security')) {
                    $_20 .= module_server_check_okay('mod_security Installed');
                } else {
                    $_20 .= module_server_check_fail('mod_security Not Installed');
                }
                break; case 'freetype':if ($_2A['gd']['FreeType Support']['0'] == 'enabled') {
                    $_20 .= module_server_check_okay('FreeType Installed');
                } else {
                    $_20 .= module_server_check_fail('FreeType Not Installed');
                }
                break; case 'calendar':if ($_2A['calendar']['Calendar support']['0'] == 'enabled') {
                    $_20 .= module_server_check_okay('PHP Calendar Enabled');
                } else {
                    $_20 .= module_server_check_fail('PHP Calendar Not Enabled');
                }
                break; case 'ftp':if ($_2A['ftp']['FTP support']['0'] == 'enabled') {
                    $_20 .= module_server_check_okay('PHP FTP Enabled');
                } else {
                    $_20 .= module_server_check_fail('PHP FTP Not Enabled');
                }
                break; case 'bcmath':if ($_2A['bcmath']['BCMath support']['0'] == 'enabled') {
                    $_20 .= module_server_check_okay('PHP BCMath Enabled');
                } else {
                    $_20 .= module_server_check_fail('PHP BCMath Not Enabled');
                }
                break; case 'zlib':if ($_2A['zlib']['ZLib Support']['0'] == 'enabled') {
                    $_20 .= module_server_check_okay('PHP ZLib Enabled');
                } else {
                    $_20 .= module_server_check_fail('PHP ZLib Not Enabled');
                }
                break;
            }
        }
        if ($GLOBALS["_35"] != TRUE) {
            return array('description' => $_20, 'processtext' => FALSE, 'processurl' => FALSE, 'processdisabled' => FALSE );
        } else {
            return array('description' => $_20, 'processtext' => FALSE, 'processurl' => FALSE, 'processdisabled' => TRUE );
        }
    }
    function module_server_check_okay ($_1E) {
        return '<span style="color:green">OKAY</span>-'.$_1E."\n";
    }
    function module_server_check_fail ($_1E) {
        $GLOBALS["_35"] = TRUE; return '<span style="color:red">FAIL</span>-'.$_1E."\n";
    }
?>



