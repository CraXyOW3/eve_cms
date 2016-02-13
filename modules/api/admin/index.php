<?php
include($module_dir.'api/config.php');
$api = good_query_assoc("SELECT * FROM api");

$wrt	=	'
<script>
	$(function() {
		$( "input:submit, input:button").button();
		$( "button#insert").button({
            icons: {
                primary: "ui-icon-disk"
            },
            text: true
		});
	});
</script>
';


$wrt	.=	wrt_table(0,0,0,'100%','center');
$wrt	.=	'<tr><td><form action="'.$module_data.'&a=apiupdate" method="post" name="apiupdate">';
$wrt	.=	wrt_table(0,0,0,'100%','center');
$wrt	.=	'<tr><th>keyID</th><th>vCode</th></tr>';
$wrt	.=	'<tr><td><input type="text" size="10" name="keyID" value="'.$api['keyID'].'"></td><td><input type="text" size="90" name="vCode" value="'.$api['vCode'].'"></td></tr>';
$wrt	.=	'<tr><td colspan="2"><input type="submit" name="submit" value="Update"></td></tr>';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</table></form>';
$wrt	.=	'</td><td>';
$wrt	.=	wrt_table(0,0,0,'100%','center');
$cache = good_query_table("SELECT * FROM cacheduntil JOIN apiaddresses WHERE apiaddresses.addressID=cacheduntil.addressID");
$wrt	.=	'<tr><th colspan="3">Cache State\'s</th></tr>';
$wrt	.=	'<tr><th>key</th><th>xml</th><th>Expire</th></tr>';
foreach($cache as $crow){
	$wrt	.=	'<tr><td>';
	$wrt	.=	$crow['keyID'];
	$wrt	.=	'</td><td>';
	$wrt	.=	$crow['apiSheetName'];
	$wrt	.=	'</td><td>';
	$wrt	.=	$crow['cacheexpire'];
	$wrt	.=	'';
	$wrt	.=	'</td></tr>';
}
$wrt	.=	'';
$wrt	.=	'</table>';
$wrt	.=	'';
$wrt	.=	'</td></tr>';
$wrt	.=	'</table>';
$wrt	.=	'Create an API with Character in Director Role, tick "Killog" and "MemberTracking".<br />';
$wrt	.=	'<a href="https://support.eveonline.com/api/">EVE Onlines API page</a>';



echo $wrt;
?>