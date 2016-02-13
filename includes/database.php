<?php
global $_CONFIG;
$dbhandle = mysql_connect($_CONFIG['hostname'], $_CONFIG['username'], $_CONFIG['password']) or die("Unable to connect to MySQL");
$selected = mysql_select_db($_CONFIG['database'],$dbhandle) or die("Could not select examples");
?>