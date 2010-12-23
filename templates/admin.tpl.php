<?php require_once('lib/session.php'); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>{page_title}</title>
<link href="styles.css" rel="stylesheet" type="text/css" />
<link href="admin.css" rel="stylesheet" type="text/css" />
<script src="SpryAssets/SpryMenuBar.js" type="text/javascript"></script>
<script src="js/mootools.js" type="text/javascript"></script>
<script src="js/edit-in-place.js" type="text/javascript"></script>
<script src="js/delete-in-place.js" type="text/javascript"></script>
<script src="js/add-in-place.js" type="text/javascript"></script>
<link href="SpryAssets/SpryMenuBarHorizontal.css" rel="stylesheet" type="text/css" />
<link rel="icon" href="favicon.ico" type="image/vnd.microsoft.icon">
</head>

<body class="main">

<div id="container">
  <div id="header">
  	<img src="images/logo.png" width="75" height="75" style="float: left; margin: 5px 20px 0 0;" />
    <h1>{site_title}</h1>
    <span id="topRight">
    <div id="user">Welcome, <?php global $session; echo $session->user; ?>!&nbsp;&nbsp;
    <?php
	  if($session->user == 'Guest')
	    echo '<a href="login.php">(Login)</a>';
	?>
    <br /><br /></div>
    </span>
    
    <span>    </span>
  <!-- end #header --></div>

    <ul id="MenuBar1" class="MenuBarHorizontal">
      <li><a href="admin.php">Main</a></li>
      <li><a href="admin.links.php">Links</a></li>
      <li><a href="admin.cats.php">Categories</a></li>
      <li><a href="admin.users.php">Users</a></li>
  </ul>
  <div id="mainContent"> <h1>{page}</h1>
  {body}  
  <p>&nbsp;</p>
  </div>
  <div id="footer">
    <?php
	$query = "SELECT COUNT(*) AS 'tc' FROM `categories`;";
	$result = mysql_query($query);
	$tc = mysql_result($result, 0, 'tc');
	
	$query = "SELECT COUNT(*) AS 'tl' FROM `links`;";
	$result = mysql_query($query);
	$tl = mysql_result($result, 0, 'tl');
	
	global $session;
	global $sm;
	
	$av = $sm->calcNumActiveUsers() + $sm->calcNumActiveGuests();
	$ru = $sm->getNumMembers();
	?>
    <p>Total Categories: <?php echo $tc; ?>  Total Links: <?php echo $tl; ?>
    Users Online: <?php echo $av; ?> Registered Users: <?php echo $ru; ?>
    <!--Searches Performed:   Hits Out:  -->
    <br />
    &copy; 2007, Michael Mior</p>
  <!-- end #footer --></div>
<!-- end #container --></div>
<script type="text/javascript">
<!--
var MenuBar1 = new Spry.Widget.MenuBar("MenuBar1", {imgDown:"SpryAssets/SpryMenuBarDownHover.gif", imgRight:"SpryAssets/SpryMenuBarRightHover.gif"});
//-->
</script>
</body>
</html>