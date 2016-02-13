<?php
//ob_start();
//pagetitle($G_siteTitle,"Docked");
//echo	'<br /><br /><br /><br /><b>Welcome to '.$G_corpName.'!</b>';
if (!isset($_GET['entry'])){
	$getPage = good_query_assoc("SELECT * FROM pages WHERE p_name='index'");
}else{
	$getPage = good_query_assoc("SELECT * FROM pages WHERE p_name='".$_GET['entry']."'");
}
//$getPage = good_query_assoc("SELECT * FROM pages ");


$wrt	=	'<table cellpadding="0" cellspacing="0" border="0" class="center" width="'.$tblWidth.'">';
$wrt	.=	'<tr><th class="ft_head left">'.$getPage['p_title'].'</th></tr>';
$wrt	.=	'';
//$wrt	.=	'<tr><td class="left">'.nl2br($getPage['p_content']).'</td></tr>';
$wrt	.=	'<tr><td class="left">'.$getPage['p_content'].'</td></tr>';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</table>';

if (empty($getPage['p_name'])){
	echo '<br /><br /><br /><br /><table class="center"><tr><th class="ft_head">Invalid/Non Existant Page Call!</th></tr><tr><td>Work it out!</td></tr></table>';
}else{
	echo $wrt;
}


//ob_flush();
?>