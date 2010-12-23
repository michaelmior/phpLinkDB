<?php
function showrater($id){

$res = mysql_query("SELECT votes, points FROM results WHERE id='$id'");
$row = mysql_fetch_row($res);
$votes = $row[0];
$points = $row[1];

if(empty($votes) || empty($points)){
	$votes = 1;
	$points = 1;
}
$average = round($points / $votes);
$average;
$perc = ($average / 5) * 100;

	echo "<span class=\"inline-rating\">
<ul class=\"star-rating\">
<li class=\"current-rating\" style=\"width:$perc%;\"></li>
<li><a href=\"vote.php?id=$id&amp;value=1\" title=\"Vote::1 star out of 5\" class=\"one-star toolTipImg\" id=\"$id\" rel=\"1\">1</a></li>
<li><a href=\"vote.php?id=$id&amp;value=2\" title=\"Vote::2 stars out of 5\" class=\"two-stars toolTipImg\" id=\"$id\" rel=\"2\">2</a></li>
<li><a href=\"vote.php?id=$id&amp;value=3\" title=\"Vote::3 stars out of 5\" class=\"three-stars toolTipImg\" id=\"$id\" rel=\"3\">3</a></li>
<li><a href=\"vote.php?id=$id&amp;value=4\" title=\"Vote::4 stars out of 5\" class=\"four-stars toolTipImg\" id=\"$id\" rel=\"4\">4</a></li>
<li><a href=\"vote.php?id=$id&amp;value=5\" title=\"Vote::5 stars out of 5\" class=\"five-stars toolTipImg\" id=\"$id\" rel=\"5\">5</a></li>
</ul></span>";
}
?>
