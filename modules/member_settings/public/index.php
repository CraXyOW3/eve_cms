<?php
include('modules/member_settings/config.php');
//Will require access mask 524296 for standings and skillsheet
$wrt = '';
$charid=$_SERVER['HTTP_EVE_CHARID'];

$wrt .= wrt_table(0,0,0,'100%','center');
$wrt .= '<tr><th class="ft_head" colspan="2">Member Settings</th></tr>';
$wrt .= '<tr>';
$wrt .= '<td width="30%">';
$wrt .= 'The API information used on the site is for.';
$wrt .= '<ol>';
$wrt .= '<li>Coordinating individual standings towards corporation standings used in the Agent Locator Agent.</li>';
$wrt .= '<li>Making diagram of member competence depending on skills for preset ship set\'s.</li>';
$wrt .= '</ol>';
$wrt .= '';
$wrt .= 'For the API to work properly it needs<br />"Private Information -> CharacterSheet"<br />and<br />"Public Information -> Standings"<br />The mask will be 524296<br />';
$wrt .= '<a href="https://support.eveonline.com/api/Key/CreatePredefined/524296" target="_blank">Predefined Key Link</a>';
$wrt .= '</td>';
$wrt .= '<td><form action="./?module=data&part=member_settings&s=apiset" method="post">';
$wrt .= '<fieldset>';
$wrt .= '<legend>API Settings</legend>';
$wrt .= '';
	$api_row = good_query_assoc("SELECT * FROM corp_members WHERE char_id='$charid'");
	if(empty($api_row['api_keyid']) || $api_row['api_keyid']=='0'){
		$str_keyid='';
		$str_vcode='';
	}else{
		$str_keyid=$api_row['api_keyid'];
		$str_vcode=$api_row['api_vcode'];
	}
$wrt .= 	wrt_table(0,0,0,'100%');
$wrt .= 	'<tr><td>keyID</td><td><input type="text" name="keyid" value="'.$str_keyid.'"></td></tr>';
$wrt .= 	'<tr><td>vCode</td><td><input type="text" name="vcode" value="'.$str_vcode.'" size="90"></td></tr>';
$wrt .= 	'<tr><td>&nbsp;</td><td><input type="submit" value="Update"></td></tr>';
$wrt .= 	'</table>';
$wrt .= '';
$wrt .= '</fieldset>';
$wrt .= '</form>';
$wrt .= '';
$wrt .= '<fieldset>';
$wrt .= '<legend>Standings Database</legend>';
		$charxml = './cache/xml/hud/'.$_SERVER['HTTP_EVE_CHARID'].'.xml';
		$xmlFile = file_get_contents($charxml);
		$xmlRead = new SimpleXMLElement($xmlFile);
		//$LastUpdated = $xmlRead->xpath("currentTime");
		$LastUpdated = $xmlRead->xpath("currentTime");
		//echo $LastUpdated[0];
		//echo'<pre>';print_r($LastUpdated);echo'</pre>';
$wrt .= 'Last update: ' . $LastUpdated[0].'<br />';
$wrt .= '';
$wrt .= '<form action="./?module=data&part=member_settings&s=standings" method="post"><input type="submit" value="Update"></form>';
$wrt .= '</fieldset>';
$wrt .= '</td>';
$wrt .= '</tr>';
$wrt .= '';
$wrt .= '</table>';
$wrt .= '';
$wrt .= '';



echo $wrt;
$wrt = null;
?>

