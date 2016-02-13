<?php
if (isset($_SERVER['HTTP_EVE_TRUSTED'])) {if ($_SERVER['HTTP_EVE_TRUSTED'] == 'No') {echo "no can do!";} else {$CHAR_CORPID = $_SERVER['HTTP_EVE_CORPID'];if ($CHAR_CORPID == $G_corpID) {

if(isset($_GET['a'])){
	if($_GET['a']=='give'){$stat=1;$msg='Given';}elseif($_GET['a']=='remove'){$stat=0;$msg='Removed';}
	$char = mysql_real_escape_string($_GET['id']);
	$_SESSION['text'] = 'User Site Access Was '.$msg.'';
	$_SESSION['type'] = 'success';
	mysql_query("UPDATE corp_members SET sec_site_admin='$stat' WHERE char_id='$char'");
	redirect('./?module=admin&part=users'); exit();
}


}}}
?>