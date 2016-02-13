<?php
$showuntrained = false;
function simplexml2array($xml) {
	if (get_class($xml) == 'SimpleXMLElement') {
		$attributes = $xml->attributes();
		foreach($attributes as $k=>$v) {
			if ($v) $a[$k] = (string) $v;
		}
		$x = $xml;
		$xml = get_object_vars($xml);
	}
	if (is_array($xml)) {
		if (count($xml) == 0) return (string) $x; // for CDATA
		foreach($xml as $key=>$value) {
			$r[$key] = $this->simplexml2array($value);
		}
		if (isset($a)) $r['@attributes'] = $a;    // Attributes
		return $r;
	}
	return (string) $xml;
}

echo	'
<script type="text/javascript">
$(function() {
    $("#content h3.expand").toggler();
    $("#content div.demo").expandAll({trigger: "h3.expand", ref: "h3.expand"});
    $("#content div.other").expandAll({
      expTxt : "[Show]", 
      cllpsTxt : "[Hide]",
      ref : "ul.collapse",
      showMethod : "show",
      hideMethod : "hide"
    });
    $("#content div.post").expandAll({
      expTxt : "[Read this entry]", 
      cllpsTxt : "[Hide this entry]",
      ref : "div.collapse", 
      localLinks: "p.top a"    
    });    
});
</script>
';



$charxml = './cache/xml/recruiter/322985857.xml';
$xmlFile = file_get_contents($charxml); // check if file exists first ??

$xmlRead = new SimpleXMLElement($xmlFile);

$charName = $xmlRead->result->name;

$skills = $xmlRead->xpath("result/rowset[@name='skills']/row");
$i=0;
foreach($skills as $itums){
	$skillname = good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID=".$itums['typeID']."");
	//echo $itums['typeID'] .' - '.$skillname['typeName'].'<br />';
	$i++;
}

$skills2 = $xmlRead->xpath("result/rowset[@name='skills']/row");

$skillgrps = array('266','273','272','271','255','268','258','269','256','275','1044','270','278','257','989','274',);


$arrskills = $xmlRead->xpath("result/rowset[@name='skills']/row");
	foreach ($arrskills as $value){
		//$skillname = good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID=".$value['typeID']."");
		//echo $value['typeID'] .'<br>';
		//echo $skillname['typeName'] . '<img src="./img/recruiter/level'.$value['level'].'.gif">' . $value['typeID'];
		//echo '<br />';
	}

//echo $arrskills->
$wrt	=	'';
$wrt	.=	'<script type="text/javascript" src="./js/expand.js"></script>';
echo'<script type="text/javascript" src="./js/expand.js"></script>';
$wrt1	=	'<div id="content"><div class="demo ui-accordion ui-widget ui-helper-reset">';


$total_sp = 0;
foreach($skillgrps as $sgroups){
	$groupname = good_query_assoc("SELECT typeName,typeID,groupID FROM eve_db_invtypes WHERE groupID=".$sgroups." AND published=1");
	$wrt	.=	'<tr><td class="ft_head" colspan="3">'.$groupname['typeName'].'</td></tr>';
	$wrt1	.=	'<h3 class="expand ui-accordion-header ui-helper-reset ui-state-active ui-corner-top">'.$groupname['typeName'].'</h3>';
	$wrt	.=	'<tr>';
	//$wrt	.=	'<td><img src="./img/recruiter/'.$sgroups.'.png"></td><td><img src="./img/recruiter/'.$sgroups.'.jpg">'.$sgroups.'</td>';
	$wrt	.=	'</tr>';
	$grouptypes = good_query_table("SELECT * FROM eve_db_invtypes WHERE groupID=".$sgroups." AND published=1");

	$wrt1	.=	'<div class="collapse ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">' . wrt_table(0,0,0,'100%','center');

	foreach($grouptypes as $itum){
		//$wrt	.=	'<tr><td>'.$itum['typeName'].'</td></tr>';
		$skills = $xmlRead->xpath("result/rowset[@name='skills']/row[@typeID='".$itum['typeID']."']");
		//$wrt	.=	'<tr><td>'.$skills.'</td></tr>';
			$xml2json = json_encode($skills);
			$finished = json_decode($xml2json,TRUE);
		//echo'<pre>';print_r($finished);echo'</pre><hr>';
		if ($finished){$skill_id = $finished[0]['@attributes']['typeID'];}else{$skill_id = 0;}
		
		if ($itum['typeID']==$skill_id){
			$skill_level = $finished[0]['@attributes']['level'];
			$skill_points = $finished[0]['@attributes']['skillpoints'];
			if ($skill_level==5){$skillbook='Complete';}else{$skillbook='Partial';}
			$total_sp = $total_sp + $skill_points;
				if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
				$evenOdd = !$evenOdd;
			$wrt	.=	'<tr><td class="bcell'.$odder.'"><img src="./img/recruiter/skillBook'.$skillbook.'.png"></td><td class="bcell'.$odder.'">'.$itum['typeName'].'</td><td class="bcell'.$odder.'"><img src="./img/recruiter/level'.$skill_level.'.gif"></td></tr>';
			$wrt1	.=	'<tr><td class="bcell'.$odder.'" width="20"><img src="./img/recruiter/skillBook'.$skillbook.'.png"></td><td class="bcell'.$odder.'">'.$itum['typeName'].'</td><td class="bcell'.$odder.'" width="100"><img src="./img/recruiter/level'.$skill_level.'.gif"></td></tr>';
		}else{
			if ($showuntrained){
			$wrt	.=	'<tr><td>Not learned!</td></tr>';
			}
		}
		//$wrt	.=	'<tr><td>'.$itum['typeID'].'-'.$skill_id.'</td></tr>';
	}
	$wrt1	.=	'</table></div>';
	//$wrt	.=	'<tr><td>asd</td></tr>';
	
	
}



$wrtc	=	'<tr><td colspan="3">';
	$wrtc	.=	wrt_table(0,0,0,'100%','center');
	$wrtc	.=	'<tr>';
	$wrtc	.=	'	<td>Name</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->name.'</td>';
	$wrtc	.=	'	<td>Intelligence</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->attributes->intelligence.'</td>';
	$wrtc	.=	'</tr>';
	$wrtc	.=	'<tr>';
	$wrtc	.=	'	<td>Corporation</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->corporationName.'</td>';
	$wrtc	.=	'	<td>Perception</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->attributes->perception.'</td>';
	$wrtc	.=	'</tr>';
	$wrtc	.=	'<tr>';
	$wrtc	.=	'	<td>Skills</td>';
	$wrtc	.=	'	<td>'.$i.'</td>';
	$wrtc	.=	'	<td>Charisma</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->attributes->charisma.'</td>';
	$wrtc	.=	'</tr>';
	$wrtc	.=	'<tr>';
	$wrtc	.=	'	<td>Skillpoints</td>';
	$wrtc	.=	'	<td>'.$total_sp.'</td>';
	$wrtc	.=	'	<td>Willpower</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->attributes->willpower.'</td>';
	$wrtc	.=	'</tr>';
	$wrtc	.=	'<tr>';
	$wrtc	.=	'	<td>Race / Bloodline</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->race.' / '.$xmlRead->result->bloodLine.'</td>';
	$wrtc	.=	'	<td>Memory</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->attributes->memory.'</td>';
	$wrtc	.=	'</tr>';
	$wrtc	.=	'<tr>';
	$wrtc	.=	'	<td>Balance</td>';
	$wrtc	.=	'	<td>'.$xmlRead->result->balance.'</td>';
	$wrtc	.=	'</tr>';
	$wrtc	.=	'</table>';
$wrtc	.=	'</td></tr>';




//echo	wrt_table(0,0,0,'80%','center').$wrtc.$wrt.'</table>';
//echo	wrt_table(0,0,0,'80%','center').$wrtc.'</table>'.$wrt1;

echo wrt_table(0,0,0,'80%','center').$wrtc.'</table>';
echo wrt_table(0,0,0,'80%','center').'<tr><td>'.$wrt1.'</td></tr></table>';
?>