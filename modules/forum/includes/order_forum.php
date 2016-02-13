<?php
include('../../../config.php');
include('../../../includes/database.php');
foreach($_GET['item'] as $key=>$value) {
	mysql_query("UPDATE forum_cat SET cat_order = '".$key."' WHERE id ='".$value."';");
}
?>