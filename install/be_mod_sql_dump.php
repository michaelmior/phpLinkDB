<?php function module_sql_dump ($step) { $step['arguments']=base64_decode($step['arguments']);$step['arguments']=unserialize($step['arguments']);require "temp_config.php";$_20.='Connecting to database server...'."\n";$dbh=@mysql_connect($temp_config[$step['arguments']['dbhost']],$temp_config[$step['arguments']['dbuser']],$temp_config[$step['arguments']['dbpass']]) or die(_5("Could not connect to database server. If you have not created the database user on the server, do this now.<br /><br />If they are created server, this error usually means that your database username, password, or host was incorrect.  To fix this, edit your configuration file and temp_config.php and Refresh this step."));$_20.='Selecting database...'."\n";if (!mysql_select_db($temp_config[$step['arguments']['dbname']],$dbh)) { $_20.='Attempting to create database...'."\n";mysql_query('CREATE DATABASE '.$temp_config[$step['arguments']['dbname']]) or die(_5("Database does not exist and BuildExec could not create it for you. Please create the database."));mysql_select_db($temp_config[$step['arguments']['dbname']],$dbh);$_20.='Database created.'."\n";} if (!empty($step['arguments']['version'])){ if (version_compare(mysql_get_server_info(),$step['arguments']['version'],"<") == 1) { die(_5("Your MySQL version will not properly execute this application."));}}$_E=fopen($_REQUEST['step'].'_setup.sql','r');$file=fread($_E,800000);fclose($_E);$file=str_replace("\r\n","\n",$file);$_66=explode("\n",$file);$_20.='Executing SQL file...'."\n";while (list($_38,$_39) = each($_66)) {$_39=trim($_39);;if (substr($_39,0,1) == '-' or substr($_39,0,1) == '#') { unset($_66[$_38]);}}$_62=implode("\n",$_66);$_37=explode(';' . "\n",$_62);while (list($_38,$_39)=each($_37)) { while (list($name,$_1D)=each($temp_config)) { $_39=str_replace('{tempconfig_'.$name.'}',$_1D,$_39);} reset($temp_config); $_39=trim($_39);if (!empty($_39)) { if(!mysql_query($_39)) { die(_5("Error on line $_38 of Query:<br />"."<pre>".$_39."</pre><br />".mysql_error()));} } } $_20.='SQL File executed successfully.';return array( 'description'=> $_20,'processtext'=> FALSE,'processurl'=> FALSE,'processdisabled'=> FALSE );} ?>