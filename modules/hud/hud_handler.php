<?php
include('../../config.php');
include('../../includes/database.php');
include('../../includes/functions.php');
if (isset($_GET['set'])) {
	if($_GET['set']=='jumps'){
		$charid=mysql_real_escape_string($_GET['char_id']);
		$jumps=mysql_real_escape_string($_GET['jumps']);
		mysql_query("UPDATE corp_members SET ag_loc_jumps='$jumps' WHERE char_id=$charid");
	}elseif($_GET['set']=='aglvl'){
		$charid=mysql_real_escape_string($_GET['char_id']);
		$aglvl=mysql_real_escape_string($_GET['aglvl']);
		mysql_query("UPDATE corp_members SET ag_loc_lvl='$aglvl' WHERE char_id=$charid");
	}
}
?>