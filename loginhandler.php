<?php
require_once('./config.php');
require_once('./includes/database.php');
require_once('./includes/functions.php');
require_once('./includes/igb_headers.php');
session_start();
$pwdform = mysql_escape_string(trim($_POST['login']));
echo $pwdform;
$pwd = good_query_assoc("SELECT global_pwd FROM settings");
echo $pwd['global_pwd'];
if (empty($pwdform)){
$_SESSION['text'] = 'Login Password EMPTY!';
$_SESSION['type'] = 'warning';	
header("Location: ./");
}elseif ($pwdform==$pwd['global_pwd']) {
$date = strtotime(date('Y-m-d H:i:s'));
$charid = $getHeaderCharID;
$upd = good_query_assoc("UPDATE corp_members SET sec_ip='$ip', sec_global_pwd='1', sec_time='$date' WHERE char_id='$charid'");


//echo $date;
$_SESSION['text'] = 'Login Password ACCEPTED!';
$_SESSION['type'] = 'success';	
header("Location: ./?module=misc&entry=login_success");
}else{
$_SESSION['text'] = 'Login Password WRONG!';
$_SESSION['type'] = 'info';	
header("Location: ./");
}



?>