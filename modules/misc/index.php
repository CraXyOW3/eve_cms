<?php
if (isset($_GET['entry']) && $_GET['entry']=='login_success'){
$time = good_query_assoc("SELECT global_pwd_interval FROM settings");

$wrt	=	'<table cellpadding="0" cellspacing="0" border="0" class="center" width="50%">';
$wrt	.=	'';
$wrt	.=	'<tr><th class="ft_head">Successful Login!</th></tr>';
$wrt	.=	'<tr>';
$wrt	.=	'<td class="left">';
$wrt	.=	'You have gained access to this site.<br />The site will ask for renewal of password authentication in two other cases.';
$wrt	.=	'<ol>';
$wrt	.=	'<li>Your authentcation period expires, that is within '.$time['global_pwd_interval'].' weeks.</li>';
$wrt	.=	'<li>You visit this site with another computer/internet address.</li>';
$wrt	.=	'</ol>';
$wrt	.=	'Password can change, if and when it does. it will be accessible thorugh the corp ingame bulletin!';
$wrt	.=	'</td>';
$wrt	.=	'</tr>';
$wrt	.=	'</table>';
$wrt	.=	'';
}
echo	$wrt;
?>