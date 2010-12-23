<?php function showLinks($query) { 

$result = mysql_query($query);
$numLinks = mysql_num_rows($result);
?>


<script src="SpryAssets/SpryCollapsiblePanel.js" type="text/javascript"></script>
<script src="js/mootools.js" type="text/javascript"></script>
<script src="js/rate.js" type="text/javascript"></script>
<link href="SpryAssets/SpryCollapsiblePanel.css" rel="stylesheet" type="text/css">

<?php $i=1; while($row = mysql_fetch_assoc($result)) { ?>
<div class="link">
<div class="linkTitle"><a href="out.php?linkID=<?php echo $row['ID']; ?>" target="_blank"><?php echo $row['title']; ?></a><br /><br />
<?php showrater($row['ID']); ?>
<?php

// Get vote count
$query = "SELECT * FROM `results` WHERE `id` = '".$row['ID']."';";
$result3 = mysql_query($query);

if(mysql_num_rows($result3) == 0)
	$v = 0;
else
	$v = mysql_result($result3, 0, 'votes');

if($v==1)
	$v = '1 vote';
else
	$v = $v.' votes';

// Get hit count
if($row['outCount'] == 1)
	$c = '1 hit';
else
	$c = $row['outCount'].' hits';

 ?>
<span class="dimmed small">(<?php echo "$v, $c"; ?>) - Modified: <?php echo date("j M y", strtotime($row['dateModified']));?></span>
</div>
<p class="linkDescription"><?php echo $row['description']; ?></p>

<?php
  
$query = "SELECT * FROM `reviews` WHERE `linkID` = '".$row['ID']."';";
$result2 = mysql_query($query);

$numComments = mysql_num_rows($result2);

?>
<div id="CollapsiblePanel<?php echo $i; ?>" class="CollapsiblePanel<?php echo $i; ?>">

<div class="CollapsiblePanelTab" tabindex="0">Reviews <span class="dimmed">(<?php echo mysql_num_rows($result2); ?>)</span></div>

<div class="CollapsiblePanelContent small">

<?php global $session; if($session->checkLogin()) {
$query = "SELECT * FROM `reviews`, `users` ".
	"WHERE `userID` = `users`.`ID` AND `linkID` = '".$row['ID']."' AND `username` = '".$session->user."';";
$result3 = mysql_query($query);

if(mysql_num_rows($result3) == 0) {
?>
Enter a review:
<form action="review.php" method="post" target="_blank">
<textarea name="review" cols="70" rows="5"></textarea>
<input type="hidden" name="linkID" value="<?php echo $row['ID']; ?>" /><br />
<input type="hidden" name="review" value="1" /><br />
<input type="submit" name="submit" value="Submit" />
</form>
<hr />
<?php  }} else { ?>
Please <a href="login.php">login</a> to write reviews.
<hr />
<?php }

$query = "SELECT `review`, `username` FROM `reviews`, `users`".
	" WHERE `linkID` = '".$row['ID']."' AND `reviews`.`userID` = `users`.`ID`;";
$result4 = mysql_query($query);

while($row2 = mysql_fetch_assoc($result4)) {

echo '<blockquote><p>&#8220;'.$row2['review']."&#8221;</p>\n";
echo '<span class="small">--'.$row2['username'].'</span></blockquote>';

?>
<hr />
<? } ?>
</div>
</div>
<br />

<!-- AddThis Bookmark Button BEGIN -->
<script type="text/javascript">
  addthis_url    = '<?php echo $row['url']; ?>';
  addthis_title  = '<?php echo $row['title']; ?>';
  addthis_pub    = 'uoitguy';
</script><script type="text/javascript" src="http://s7.addthis.com/js/addthis_widget.php?v=12" ></script>
<!-- AddThis Bookmark Button END -->
</div>

<?php $i++; } ?>

<script type="text/javascript">

<?php $j=1; while($j<=$i) {?>
var CollapsiblePanel<?php echo $j; ?> = new Spry.Widget.CollapsiblePanel("CollapsiblePanel<?php echo $j; ?>", {contentIsOpen:false});
<?php $j++; } ?>

</script>

<?php

return $numLinks;

} ?>