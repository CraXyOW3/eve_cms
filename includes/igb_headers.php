<?php
if (isset($_SERVER['HTTP_EVE_TRUSTED'])) {
	$getHeaderTrusted = $_SERVER['HTTP_EVE_TRUSTED'];
if ($_SERVER['HTTP_EVE_TRUSTED']=='Yes') {
//Collecting all headers once so i can abuse them !
	$getHeaderCorpID = $_SERVER['HTTP_EVE_CORPID'];
	$getHeaderCharID = $_SERVER['HTTP_EVE_CHARID'];
	$getHeaderCharName = $_SERVER['HTTP_EVE_CHARNAME'];
	$getHeaderSolSysName = $_SERVER['HTTP_EVE_SOLARSYSTEMNAME'];
	$getHeaderCorpRole = $_SERVER['HTTP_EVE_CORPROLE'];
}}
$corp_row = good_query_assoc("SELECT corp_id FROM settings");
$G_corpID = $corp_row['corp_id'];
$ip=$_SERVER['REMOTE_ADDR'];
$evenOdd = true;
?>