<?php
if (isset($getHeaderTrusted)){if($getHeaderTrusted=='No'){echo "no can do!";}else{if($getHeaderCorpID==$G_corpID) { // auth part
if (empty($_GET['mode'])) {
	//view board
	require_once($module_dir.'forum/public/viewforum.php');
}elseif($_GET['mode']=='view'){
	//view topic
	require_once($module_dir.'forum/public/viewtopic.php');
}elseif($_GET['mode']=='edit'){
	//view topic
	require_once($module_dir.'forum/public/editpost.php');
}elseif($_GET['mode']=='newtopic'){
	//view topic
	require_once($module_dir.'forum/public/createtopic.php');
}elseif($_GET['mode']=='threads'){
	//view topic
	require_once($module_dir.'forum/public/viewthreads.php');
}
}}}
?>