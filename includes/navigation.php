<?php
$default = getModule("page");
$result = good_query('SELECT * FROM menu') or exit(mysql_error());
global $getHeaderCorpID;
$i=0;
while ($row = mysql_fetch_array($result)) {$allowed[] = $row['murl'];$i++;}
$wrt	=	wrt_table(0,0,0,'128','center');
$wrt	.=	'<tr><td>';

/*
	$wrt	.=	'<div id="container">';
	$wrt	.=	'<div id="image"><img class="darkborder" src="http://image.eveonline.com/Corporation/'.$G_corpID.'_128.png"></div>';
	$wrt	.=	'<div style="position: absolute; left: 10px; top: 100px;">';
	$wrt	.=	'<span style="font-weight: bold; color: #fff;">Moooooo...</span>';
	$wrt	.=	'</div></div>';
*/
	$pr2	=	'<script type="text/javascript">' . "\n";
	$pr2	.=	'$(document).ready(function(){';
	$pr2	.=	'	$(".newsloader").ready(function(){';
	$pr2	.=	'		$(".srv_status").fadeIn();';
	$pr2	.=	'		$(".srv_loader").hide().load("./includes/serverstatus.php", function() {';
	$pr2	.=	'			$(".srv_status").hide();';
	$pr2	.=	'			$(this).fadeIn();';
	$pr2	.=	'		});';
	$pr2	.=	'	});';
	$pr2	.=	'});';
	$pr2	.=	'</script>';
	$pr3	=	'<div class="text"><div class="srv_status" style="display: none;text-align:center;"><img src="./img/ghooloader2_s.gif" alt="loading" /></div><div class="srv_loader"></div></div>';
	//$wrt	.=	$pr2;
	//$wrt	.=	'<div class="logo"><img class="darkborder" src="http://image.eveonline.com/Corporation/'.$G_corpID.'_128.png"></div>';
	$wrt	.=	'<img class="darkborder" src="http://image.eveonline.com/Corporation/'.$G_corpID.'_128.png"><br />';

//$wrt	.=	'<img class="darkborder" src="http://image.eveonline.com/Corporation/'.$G_corpID.'_128.png"><br />';
$wrt	.=	'</td></tr><tr><td>';
if (isset($getHeaderTrusted)) {
	if ($getHeaderTrusted == 'Yes'){
		if ($getHeaderCorpID == $G_corpID) {
			$charRole = $_SERVER['HTTP_EVE_CORPROLE'];
				if($isDirector){
					$admin = true;
					$showAccess = '<font color="#00ff00">Full</font>';
				}elseif($isSecOfficer){
					$admin = false;
					$showAccess = '<font color="#c8de1b">Standard</font>';
				}else{
					$admin = false;
					$showAccess = '<font color="#ff7722">Basic</font>';
				}
		} else {
			$admin = false;
			$showAccess = '<font color="#ff3922">None</a>';
		}
		$spc='&nbsp;&nbsp;&nbsp;';
		//$wrt	.=	'</td></tr><tr><td>';
		$wrt	.=	'<table class="char" cellspacing="0" cellpadding="0" border="0"><tr><td width="32" class="charimg"><img class="darkborder" src="http://image.eveonline.com/Character/' . $getHeaderCharID . '_64.jpg"></td>
					<td class="chartext">
					<img style="border:none;" src="./img/yarr.gif">'.$getHeaderCharName.'<br />
					<img style="border:none;" src="./img/yarr.gif">Access<br />
					'.$spc.''.$showAccess.'<br /><br />
					<img style="border:none;" src="./img/yarr.gif"><a href="./?module=member_settings">Settings</a>';
		$wrt	.=	'</td></tr></table>';
		$wrt	.=	'</td></tr>';
		$wrt	.=	'<tr><td class="font_s" height="50"><img style="border:none;" src="./img/yarr.gif">Server Status<br />'.$pr2.$pr3.'</td></tr>';
		$wrt	.=	'</table>';
	}
}else{$wrt .= '</td></tr></table>';}


if (empty($getHeaderTrusted)) {
	$wrt .= '<ul id="navlist">';
	$wrt .= '<li><a href="./?module=page">Mainpage</a></li>';
	$wrt .= '<li><a href="./?module=page&entry=_oog">OOG</a></li>';
	$wrt .= '</ul>';
}elseif($getHeaderCorpID!=$G_corpID){
	$wrt .= '
		<script type="text/javascript">
		function delayedRedirect(){
			window.location = "./"
		}
		</script>
	';
	$wrt .= '<ul id="navlist">';
	$wrt .= '<li><a href="./?module=page">Mainpage</a></li>';
	$wrt .= '<li><a href="./?module=page&entry=_what_is">What is this?</a></li>';
	$wrt .= '<li><a href="#" onclick="CCPEVE.requestTrust(\'http://'.$_SERVER['HTTP_HOST'].'\'); setTimeout(\'delayedRedirect()\', 6000); return false;">Trust Site</a></li>';
	$wrt .= '</ul>';
	$wrt .= '</td></tr></table>';
	//$wrt .= $_SERVER['HTTP_HOST'];
}

/*
if (isset($getHeaderTrusted)) {
if ($getHeaderTrusted == 'No') {
	$wrt .= '<ul>';
	$wrt .= '<li>Mainpage</li>';
	$wrt .= '<li><a href="#" onclick="CCPEVE.requestTrust(\''.$G_domain.'\'); setTimeout(\'delayedRedirect()\', 4000); return false;">Trust Site</a></li>';
	$wrt .= '</ul>';
}
}
*/
//$wrt .=	'</ul>';

if (isset($_GET['module']) && $_GET['module']=='data' || isset($_GET['module']) && $_GET['module']=='cron') {$showMenu=false;}else{$showMenu=true;}



if (isset($getHeaderTrusted)) {if ($getHeaderTrusted == 'Yes'){if($getHeaderCorpID==$G_corpID){

if ($showMenu){ //hiding menu during redirects for avoiding headers alrdy sent.
$sec_site = good_query_assoc("SELECT sec_site_admin FROM corp_members WHERE char_id=".$getHeaderCharID."");
if ($sec_site['sec_site_admin']){
$whereclause = "('1','2','3','4')";
}elseif($isDirector){
$whereclause="('1','2','3')";
}elseif($isSecOfficer){
$whereclause="('1','2')";
}else{
$whereclause="('1')";
}

$wrt	.=	'<ul id="navlist">';

$check_navi = good_query_value("SELECT count(*) FROM navigation");
if ($check_navi){
$navigation = good_query_table("SELECT * FROM navigation WHERE (access in ".$whereclause.") ORDER BY s_order ASC");
	foreach($navigation as $row){
		if($row['istitle']){
			$wrt	.=	'<li>'.$row['name'].'</li>';
		}else{
			$wrt	.=	'<li><a class="ld" href="./?module='.$row['url'].'">'.$row['name'].'</a></li>';
		}
	}
}
//check if basic navigation is setup!
	$checkNav = good_query_table("SELECT * FROM navigation ORDER BY s_order ASC");
	$preconf=0;
	foreach($checkNav as $checkN){
		if ($checkN['url']=='admin&part=settings'){$preconf++;}
		if ($checkN['url']=='admin&part=navigation'){$preconf++;}	
	}
	if ($preconf!=2){
		$wrt	.=	'<li>Base Configuration</li>';
		$wrt	.=	'<li><a href="./?module=admin&part=navigation">Configure Navigation.</a></li>';
		$wrt	.=	'<li><a href="./?module=admin&part=settings">Configure Settings.</a></li>';
	}
	$preconf=0;
//end basic nav setup.
$wrt	.=	'</ul>';


}
}}}
echo	$wrt;
$wrt = null;
?>