<?php

require_once('lib/config.php');
require_once('lib/template.php');

require_once('lib/session.php');

$page = new Page('templates/main.tpl.php');

ob_start();

$query = "SELECT * FROM `categories` ORDER BY `name` ASC;";
$result = mysql_query($query);

if(mysql_num_rows($result) > 0) {
?>

<table width="500" border="0" id="categoryTable">

		<?php		
		while($row = mysql_fetch_assoc($result)) {
		  $query = "SELECT COUNT(*) AS 'cl' FROM `links` WHERE `links`.`categoryID` = ".$row['ID'].";";
		  $result2 = mysql_query($query);
		  if($result2 && mysql_num_rows($result2) > 0)
		    $cl = mysql_result($result2, 0, 'cl');
		  else $cl = 0;
		?>
          <tr>
            <td width="30">&nbsp;</td>
            <td><a href="category.php?ID=<?php echo $row['ID']; ?>"><?php echo $row['name']; ?></a>
              &nbsp;&nbsp;<span class="dimmed">(<?php echo $cl; ?>)</span></td>
  </tr>
  <?php } ?>
</table>
<?php
} else { ?>

No categories in database

<?php
}

$body = ob_get_clean();

$page->replace_tags(array(
	"site_title" => $title.'',
	"page_title" => $title.' - Home',
	"page" => "Categories",
	"body" => $body
));

$page->output();

mysql_close();
?>