<?php
$module_dir='modules/';
//Database config
$_CONFIG = array(
'hostname' => '',
'username' => '',
'password' => '',
'database' => '',
);
$G_corpID = "";
$G_corpName = "";
$G_siteTitle = "";
$G_domain = "http://127.0.0.1/";
$G_author = "";
$G_site_admin = "";
$logFile = true; //self explanatory!
$logFilePattern = 'log/log_manual_Y'.date('Y').'_M'.date('m').'_W'.date('W').'.log';
$ip=$_SERVER['REMOTE_ADDR'];
$curUrl = (!empty($_SERVER['HTTPS'])) ? "https://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'] : "http://".$_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
$skillgrps = array('266','273','272','271','255','268','258','269','256','275','1044','270','278','257','989','274',);

// own design param
$tblWidth="98%";
?>