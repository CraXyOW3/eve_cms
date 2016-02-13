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
    $("#contentchar h3.expand").toggler();
    $("#contentchar div.demo").expandAll({trigger: "h3.expand", ref: "h3.expand"});
    $("#contentchar div.other").expandAll({
      expTxt : "[Show]", 
      cllpsTxt : "[Hide]",
      ref : "ul.collapse",
      showMethod : "show",
      hideMethod : "hide"
    });
    $("#contentchar div.post").expandAll({
      expTxt : "[Read this entry]", 
      cllpsTxt : "[Hide this entry]",
      ref : "div.collapse", 
      localLinks: "p.top a"    
    });    
});
</script>
';

$wrtc='';
$wrt1='';
$wrt_chr='';
if ($handle = opendir('cache/recruiter')) {
	$wrt_chr .='<ul id="reclist">';
		while (false !== ($entry = readdir($handle))) {
			if ($entry != "." && $entry != "..") {
				//echo "$entry\n";
					//$filename="delimited.txt";
					$filename='cache/recruiter/'.$entry;
					$fh=fopen($filename, 'r');
					$data=fread($fh, filesize($filename));
					fclose($fh);
					$splitcontents=explode("|", $data);
						//print_r($splitcontents);
					//echo '<a href="">' . $splitcontents[0] . '</a> <br />';
					if(!file_exists('./cache/xml/recruiter/'.$splitcontents[1].'_chars.xml')){
						$charlistact='';
						$wrt_chr .= '<li class="red"><a href="./?module=data&part=recruiter&a=charlist&id='.$splitcontents[1].'">' . $splitcontents[0] . '</a></li>';
					}else{
						if(isset($_GET['id'])){if($_GET['id']==$splitcontents[1]){$charlistact=' active';}else{$charlistact='';}}else{$charlistact='';}
						$wrt_chr .= '<li class="green'.$charlistact.'"><a href="./?module=admin&part=recruiter&id='.$splitcontents[1].'">' . $splitcontents[0] . '</a></li>';
					}
			}
		}
	$wrt_chr .='</ul>';
    closedir($handle);
}




if (!isset($_GET['id'])){
	$wrtc='Select a candidate!';
	$wrt1='';
} else {

//$charxml = './cache/xml/recruiter/322985857.xml';

	if(!file_exists('./cache/xml/recruiter/'.$_GET['id'].'_chars.xml')){

	}else{
		//$file=fopen("welcome.txt","r");
		//echo'else';
		$charxml = './cache/xml/recruiter/'.$_GET['id'].'_chars.xml';
		$xmlFile = file_get_contents($charxml);
		$xmlRead = new SimpleXMLElement($xmlFile);
			//$accChars = $xmlRead->result->rowset->row->name;
			$accChars = $xmlRead->xpath("result/rowset[@name='characters']/row");
			$ic=0;
			//$wrtc .= '<div class="recruiter"><ul>';
			$wrtc .= wrt_table(0,0,0,'100%','center reclisttable').'<tr>';
			foreach($accChars as $curChars){
				if(!file_exists('./cache/xml/recruiter/'.$_GET['id'].'_id_'.$curChars['characterID'].'_character.xml')){
					//$wrtc .= '<li class="red"><a href=".?module=data&part=recruiter&a=charsheet&id='.$_GET['id'].'&sheet='.$curChars['characterID'].'"><span id="inp"><img title="'.$curChars['name'].'" src="http://image.eveonline.com/Character/'.$curChars['characterID'].'_32.jpg"></a></span> [<span id="inp"><a title="Click to delete the cache of this character." href="">x</a></span>]</li>';
					$wrtc .= '<td width="32" class="center"><a href=".?module=data&part=recruiter&a=charsheet&id='.$_GET['id'].'&sheet='.$curChars['characterID'].'"><img class="red" title="'.$curChars['name'].'" src="http://image.eveonline.com/Character/'.$curChars['characterID'].'_32.jpg"></a></td>';
					$wrtc .= '<td width="200"><ul id="recr"><li>'.$curChars['name'].'</li><li class="red">not cached</li></ul></td>';
				}else{
					//$wrtc .= '<li class="green"><span id="inp"><img title="'.$curChars['name'].'" src="http://image.eveonline.com/Character/'.$curChars['characterID'].'_32.jpg"></span><a href=".?module=admin&part=recruiter&id='.$_GET['id'].'&sheet='.$curChars['characterID'].'">' . $curChars['name'] . '</a> [<span id="inp"><a title="Click to delete the cache of this character." href="">x</a></span>]</li>';
					$wrtc .= '<td width="32" class="center"><a href=".?module=admin&part=recruiter&a=charsheet&id='.$_GET['id'].'&sheet='.$curChars['characterID'].'"><img class="green" title="'.$curChars['name'].'" src="http://image.eveonline.com/Character/'.$curChars['characterID'].'_32.jpg"></a></td>';
					$wrtc .= '<td width="200"><ul id="recr"><li>'.$curChars['name'].'</li><li class="green">cached</li></ul></td>';
				}
			}
			//$wrtc .= '</ul></div>';
			$wrtc .='<td>&nbsp;</td>';
			$wrtc .= '</tr></table>';
	}




if (isset($_GET['sheet'])){

	$charxml = './cache/xml/recruiter/'.$_GET['id'].'_id_'.$_GET['sheet'].'_character.xml';
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

	//$skillgrps = array('266','273','272','271','255','268','258','269','256','275','1044','270','278','257','989','274',);


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
	$wrt1	.=	'<div id="contentchar"><div class="demo ui-accordion ui-widget ui-helper-reset">';


	$total_sp = 0;
	foreach($skillgrps as $sgroups){
		$groupname = good_query_assoc("SELECT typeName,typeID,groupID FROM eve_db_invtypes WHERE groupID=".$sgroups." AND published=1");
		$grouptypes = good_query_table("SELECT * FROM eve_db_invtypes WHERE groupID=".$sgroups." AND published=1");
		$total_sp_grp = 0;
										foreach($grouptypes as $itum){
											$skills = $xmlRead->xpath("result/rowset[@name='skills']/row[@typeID='".$itum['typeID']."']");
												$xml2json = json_encode($skills);
												$finished = json_decode($xml2json,TRUE);
											if ($finished){$skill_id = $finished[0]['@attributes']['typeID'];}else{$skill_id = 0;}
											if ($itum['typeID']==$skill_id){
												$skill_points = $finished[0]['@attributes']['skillpoints'];
												$total_sp_grp = $total_sp_grp + $skill_points;
											}
										}
		$wrt	.=	'<tr><td class="ft_head" colspan="3">'.$groupname['typeName'].'</td></tr>';
		$wrt1	.=	'<h3 class="expand ui-accordion-header ui-helper-reset ui-state-active ui-corner-top">'.$groupname['typeName'].' - '.$total_sp_grp.'sp</h3>';
		$wrt	.=	'<tr>';
		//$wrt	.=	'<td><img src="./img/recruiter/'.$sgroups.'.png"></td><td><img src="./img/recruiter/'.$sgroups.'.jpg">'.$sgroups.'</td>';
		$wrt	.=	'</tr>';

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
				$total_sp_grp = $total_sp_grp + $skill_points;
			}else{
				if ($showuntrained){
				$wrt	.=	'<tr><td>Not learned!</td></tr>';
				}
			}
			//$wrt	.=	'<tr><td>'.$itum['typeID'].'-'.$skill_id.'</td></tr>';
		}
		$wrt1	.=	'</table></div>';
		//$wrt	.=	'<tr><td>asd</td></tr>';
		
//echo'<pre>';
//print_r($total_sp_grp);
//echo $total_sp_grp;
//echo'</pre>';		
	}

	$wrtc	.=	'<tr><td colspan="3">';
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
	}
}





//echo	wrt_table(0,0,0,'80%','center').$wrtc.$wrt.'</table>';
//echo	wrt_table(0,0,0,'80%','center').$wrtc.'</table>'.$wrt1;
echo wrt_table(0,0,0,'80%','center') . '<tr><td width="150">'.$wrt_chr.'</td><td>';
	echo wrt_table(0,0,0,'80%','center').$wrtc.'</table>';
	echo wrt_table(0,0,0,'80%','center').'<tr><td>'.$wrt1.'</td></tr></table>';
echo '</td></tr></table>';
?>