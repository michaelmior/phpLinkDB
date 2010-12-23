<?php
$id 		= $_GET['id'];
$value 		= $_GET['value'];

$address 	= $_SERVER['REMOTE_ADDR'];

require_once('lib/config.php');
require_once('showrater.php');

$myIP = mysql_query("SELECT count FROM ips WHERE ip = '$address' AND countID = '$id' ");
$resultingIP = mysql_fetch_row($myIP);
$count = $resultingIP[0];

if(!empty($resultingIP[0])){

			if($count > 0){
				die("<script language=\"javascript\">alert('You have already voted!')</script>");
			}	
}else{
	$row = mysql_query("SELECT * FROM results WHERE id='$id'");
	$row = mysql_fetch_row($row);
	
	if(!empty($row[0])){
		$votes = $row[1] + 1;
		$points = $row[2];
		$points += $value;
		mysql_query("UPDATE results SET votes='$votes', points = '$points' WHERE id = '$id' ") or die(mysql_error());
		mysql_query("INSERT INTO ips(ip,count,countID) VALUES('$address','1','$id')") or die(mysql_error());
	}else{
		mysql_query("INSERT INTO ips(ip,count,countID) VALUES('$address','1','$id')") or die(mysql_error());
		mysql_query("INSERT INTO results(id,votes,points) VALUES('$id','1','$value')")or die(mysql_error());
	}
}

		
?>