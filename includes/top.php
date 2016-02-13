<?php
require_once('database.php');
include('./includes/functions.php');
include('./includes/igb_headers.php');
?>
<html>
<head>
<title>Gung-Ho Corporation Site</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="css/stylesheet.css" />
<link rel="stylesheet" href="css/merged.css" />
<link rel="stylesheet" href="css/jquery.cluetip.css" />
<script type="text/javascript" src="./js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="./js/jquery.graphup.pack.js"></script>
<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" href="css/ui-darkness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="./js/jquery.tooltip.min.js"></script>
<script type="text/javascript" src="./js/jquery.notify.js"></script>
<script type="text/javascript" src="./js/jtip.js"></script>
<script type="text/javascript" src="./js/site.js"></script>
<script type="text/javascript" src="./js/jquery.cluetip.all.min.js"></script>
<?php
include('./includes/securitycheck.php');
?>
</head>
<body>

<div id="loadingpage" align="center"><div id="loadingpage_content"><br /><img src="./img/ghooloader2.gif" /></div></div>
<?php
echo alert_check();
$row_title = good_query_assoc("SELECT * FROM settings");
if (isset($_GET['module'])) {
	if (isset($_GET['part'])) {
	$row = good_query_assoc("SELECT url,title FROM navigation WHERE url='".$_GET['module']."&part=".$_GET['part']."'");
	}elseif (isset($_GET['entry'])) {
	$row = good_query_assoc("SELECT url,title FROM navigation WHERE url='".$_GET['module']."&entry=".$_GET['entry']."'");
	}else{
	$row = good_query_assoc("SELECT url,title FROM navigation WHERE url='".$_GET['module']."'");
	}
	$ttle	=	$row['title'];
}elseif (empty($_GET['module'])) {
	$ttle	=	'Docked';
}else{
	$ttle	=	'Other';
}
	$wrt	=	'<br /><table cellpadding="0" cellspacing="0" border="0" class="center tabwidth"><tr>
				<td class="hset htitle"><span class="corptitle">Corporation</span>';
	$wrt	.=	pageheader($row_title['site_title'],$ttle);
	$wrt	.=	'</td>
				</tr></table>';
echo	$wrt;
?>