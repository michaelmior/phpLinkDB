<?php

header('Content-type: application/rss+xml');

require_once('lib/config.php');
require_once('lib/feedcreator.class.php');

$rss = new UniversalFeedCreator();
$rss->title = $title;
$rss->description = '';
$rss->link = $_SERVER['DOCUMENT_ROOT'];
$rss->syndicationURL = "http://".$_SERVER['HTTP_HOST'].$_SERVER[PHP_SELF];;

$query = "SELECT *, `categories`.`name` AS 'category' FROM `links`, `categories` WHERE ";

if(isset($_GET['catID']))
	$query .= "`categories`.`ID` = '".$_GET['catID']."' AND ";

$query .= '`categories`.`ID` = `links`.`categoryID` ORDER BY `dateAdded` LIMIT 10;';

$result = mysql_query($query);

if(!$result || mysql_num_rows($result) <= 0) {
	echo $rss->createFeed('2.0');
	exit;
}

while($row = mysql_fetch_assoc($result)) {
	if(!isset($rss->category) && isset($_GET['catID']))
		$rss->category = $row['category'];
		
	$item = new FeedItem();
	$item->title = $row['title'];
	$item->link = $row['url'];
	$item->description = $row['description'];
	$item->date = $row['dateModified'];
	$item->category = $row['category'];
	
	$rss->addItem($item);
}

echo $rss->createFeed('2.0');
?>