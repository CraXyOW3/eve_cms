<?php
$strLocation='./../';
include('./../config.php');
include('./../includes/functions.php');
include('./../includes/database.php');

$sql = good_query_table("SELECT * FROM feeds WHERE enabled='1'");

echo'<pre>';
print_r($sql);
echo'</pre>';

foreach($sql as $row){
	echo $row['tag'].'<br>';
	echo $row['url'].'<br>';
	$xmlFile = file_get_contents($row['url']);
	file_put_contents($strLocation."cache/xml/feeds_" . $row['tag'] . "_prepare.xml", $xmlFile);
	$feedsLocal = $strLocation."cache/xml/feeds_" . $row['tag'] . "_prepare.xml";
								$string = file_get_contents($feedsLocal);
								$xmlRead = new SimpleXMLElement($string);
			//do some error checking
			
			
			//if error check is good then rename
			rename($strLocation."cache/xml/feeds_" . $row['tag'] . "_prepare.xml", $strLocation."cache/xml/feeds_" . $row['tag'] . ".xml");
}
?>