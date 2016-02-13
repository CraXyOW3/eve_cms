<?php
function dec2bin($_indec, $_pad=64, $_bitorder=1) {
$digits="01";
$retval="";
bcscale(0);
while($_indec>1) {
	$rmod=bcmod($_indec,2);
	$_indec=bcdiv($_indec,2);
	$retval=$digits[$rmod].$retval;
}
$retval=$digits[intval($_indec)].$retval;
if ($_bitorder==1) {
$retval=strrev(str_pad($retval, $_pad, "0", STR_PAD_LEFT));
	} else {
		$retval=str_pad($retval, $_pad, "0", STR_PAD_LEFT);
	}
	return (string)$retval;
}
//if (isset($_SERVER['HTTP_EVE_TRUSTED'])) {
if ((isset($_SERVER['HTTP_EVE_TRUSTED'])) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes') {
if( substr( dec2bin($getHeaderCorpRole), 0, 1 )=='1' && $getHeaderCorpID == $G_corpID) {$isDirector = true;} else {$isDirector = false;} // director role
if( substr( dec2bin($getHeaderCorpRole), 8, 1 )=='1' && $getHeaderCorpID == $G_corpID) {$isAccountant = true;} else {$isAccountant = false;} // accountant role
if( substr( dec2bin($getHeaderCorpRole), 7, 1 )=='1' && $getHeaderCorpID == $G_corpID) {$isPersonel = true;} else {$isPersonel = false;} //personelmanager role
if( substr( dec2bin($getHeaderCorpRole), 9, 1 )=='1' && $getHeaderCorpID == $G_corpID) {$isSecOfficer = true;} else {$isSecOfficer = false;} // security officer role
if( substr( dec2bin($getHeaderCorpRole), 10, 1 )=='1' && $getHeaderCorpID == $G_corpID) {$isFacMan = true;} else {$isFacMan = false;} // factory manager role
if( substr( dec2bin($getHeaderCorpRole), 11, 1 )=='1' && $getHeaderCorpID == $G_corpID) {$isStatMan = true;} else {$isStatMan = false;} // station manager role
if( substr( dec2bin($getHeaderCorpRole), 12, 1 )=='1' && $getHeaderCorpID == $G_corpID) {$isAudit = true;} else {$isAudit = false;} // auditor role
//}


//echo $ip;
$checkSec = good_query_assoc("SELECT * FROM corp_members WHERE char_id=$getHeaderCharID");
//echo $checkSec['char_id'];
if (empty($checkSec['sec_ip']) && ($getHeaderCorpID==$G_corpID)){
	//ip is empty, then request password and insert ip and password check!
	//echo'wae';
	require_once('./includes/loginform.php');
}else{

	$week = good_query_assoc("SELECT global_pwd_interval FROM settings");
	//check if ip is the same and if interval is met!
	if ($checkSec['sec_time'] < strtotime('-'.$week['global_pwd_interval'].' weeks') && ($getHeaderCorpID==$G_corpID)) {
		require_once('./includes/loginform.php');
	}elseif (($checkSec['sec_ip'] != $ip) && ($getHeaderCorpID==$G_corpID)) {
		require_once('./includes/loginform.php');
	}
	$charLastTime = ceil((time() - strtotime($checkSec['sec_time']))/86400 );

}
}
?> 
