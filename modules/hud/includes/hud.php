<?php
//$con2 = mysql_connect("localhost","root","nsjsd");
//if (!$con2)
//	{die('Could not connect: ' . mysql_error());}
//mysql_select_db("gungho", $con2);
//mysql_select_db("evedata_cruc", $con2);

include('../../../config.php');
include('../../../includes/database.php');
include('../../../includes/functions.php');
$charid=$_SERVER['HTTP_EVE_CHARID'];

//echo'<hr>';
$currsystem='30001380';
//$currsystem='30000145';
//$currsystem = $_SERVER['HTTP_EVE_SOLARSYSTEMID'];
/*

$nr_jumps=3;
$agent_level=2;
$agent_corporation=0;
$i=0;
$gets = mysql_query("SELECT msj.fromSolarSystemID AS fromss, msj.toSolarSystemID AS toss, ss.ssname AS sname,ss.systemid AS systemid FROM solarsystems ms INNER JOIN mapsolarsystemjumps msj ON ms.systemid=msj.fromSolarSystemID LEFT JOIN solarsystems ss ON msj.toSolarSystemID=ss.systemid WHERE ms.systemID='$currsystem';");
	while($rowsys = mysql_fetch_array($gets)){
		if($rowsys['systemid']<>$currsystem){
			$tstarr[]=array($rowsys['sname']=>$rowsys['systemid']);
			$i++;
		}
	}
echo'<pre>';
//print_r($tstarr);
echo'</pre>';

*/

echo '<link rel="stylesheet" href="./css/hud.css" />';
$i=1;
//$il=3; //limit from 3-5
$il=1;




$crp_sql="SELECT * FROM eve_db_npccorp";
$crp_result=mysql_query($crp_sql);
$data=array();
while($field=mysql_fetch_assoc($crp_result)){
	$data[]=$field;
	//$data[]=$field['corpID'];
}

echo'<pre>';
//print_r($data);
echo'</pre>';


@list($get_jumps,$get_lvl) = good_query_list("SELECT ag_loc_jumps,ag_loc_lvl FROM corp_members WHERE char_id='$charid'");





echo '<select class="jumps">';
while($i<=5){
	if($get_jumps==$i){$g_j=' selected="selected"';}else{$g_j='';}
	echo '<option value="'.$i.'"'.$g_j.'>' . $i . '</option>';
	$i++;
}
echo '</select> jumps.<div class="jumps_load"></div>';

echo '<select class="aglvl">';
while($il<=5){
	if($get_lvl==$il){$g_l=' selected="selected"';}else{$g_l='';}
	echo '<option value="'.$il.'"'.$g_l.'>' . $il . '</option>';
	$il++;
}
echo '</select> agent lvl and above.<div class="aglvl_load"></div>';


echo '


<script type="text/javascript">
$(\'.jumps\').change(function() {
	$(\'.jumps_load\').load("./modules/hud/hud_handler.php?set=jumps&char_id='.$charid.'&jumps="+$(this).val()+"");
});
$(\'.aglvl\').change(function() {
	$(\'.aglvl_load\').load("./modules/hud/hud_handler.php?set=aglvl&char_id='.$charid.'&aglvl="+$(this).val()+"");
});
</script>





';

if($get_lvl=='0'){$cur_lvl='3';}else{$cur_lvl=$get_lvl;}
function getagents($solsystem){
	$retval='';
	global $charid, $G_corpID, $cur_lvl;
	//$get_ag = mysql_query("SELECT * FROM eve_db_agentloc WHERE ag_sol_id='".$solsystem."'");
	$get_ag = mysql_query("SELECT * FROM eve_db_agentloc WHERE ag_sol_id='".$solsystem."' AND ag_lvl>='".$cur_lvl."'");
		if($get_ag){
			//echo '<ul class="loc">';
			$retval .= wrt_table(0,0,0,'100%','');
			while($row_a=mysql_fetch_array($get_ag)){
				//$avail = good_query_assoc("SELECT * FROM cache_ag_standings WHERE (char_id='$charid' OR char_id='0000$G_corpID' OR char_id='0001$G_corpID') AND fromID='$row_a[ag_crp]' AND standings>='3'");
				$stand_pilot = good_query_assoc("SELECT * FROM cache_ag_standings WHERE (char_id='$charid' OR char_id='0000$G_corpID' OR char_id='0001$G_corpID') AND fromID='$row_a[ag_crp]' AND standings>='3'");
				$stand_corp = good_query_assoc("SELECT cags.fromID,cags.standings FROM cache_ag_standings cags INNER JOIN eve_db_chrfactions fac ON (cags.fromID=fac.corporationID)");
				//$stand_corp = good_query_assoc("SELECT cags.fromID FROM cache_ag_standings cags INNER JOIN eve_db_chrfactions fac ON (cags.fromID=fac.corporationID)WHERE (char_id='$charid' OR char_id='0000$G_corpID' OR char_id='0001$G_corpID') AND fromID='$row_a[ag_crp]' AND standings>='3'");
				if ($stand_pilot['fromID'] || $stand_corp['fromID']){
					//echo'<pre>';print_r($stand_pilot);echo'</pre>';
					$tst='';
					if($row_a['ag_lvl']=='1'){
						$aglvl='contact';
						$ag_lvl='1';
						$ag_stand='-1';
							if($stand_pilot['standings']>'-1' || $stand_corp['standings']>'-1'){
								$tst='l1avail';
								$show=true;
							}else{$show=false;}
					}elseif($row_a['ag_lvl']=='2'){
						$aglvl='contact';
						$ag_lvl='2';
						$ag_stand='1';
							if($stand_pilot['standings']>'1' || $stand_corp['standings']>'1'){
								$tst='l2avail';
								$show=true;
							}else{$show=false;}
					}elseif($row_a['ag_lvl']=='3'){
						$aglvl='contact3';
						$ag_lvl='3';
						$ag_stand='3';
							if($stand_pilot['standings']>'3' || $stand_corp['standings']>'3'){
								$tst='l3avail';
								$show=true;
							}else{$show=false;}
					}elseif($row_a['ag_lvl']=='4'){
						$aglvl='contact4';
						$ag_lvl='4';
						$ag_stand='5';
							if($stand_pilot['standings']>'5' || $stand_corp['standings']>'5'){
								$tst='l4avail';
								$show=true;
							}else{$show=false;}
					}else{
						$aglvl='contact';
						$ag_lvl='';
						$show=false;
					}
					//echo '<li class="'.$aglvl.'"><img height="32" align="left" src="http://image.eveonline.com/Corporation/'.$row_a['ag_crp'].'_32.png"> <a href="#" onclick="CCPEVE.showInfo(1377, '.$row_a['ag_id'].')">'.$row_a['ag_name'].'</a> <a href="#" onclick="CCPEVE.startConversation('.$row_a['ag_id'].')"><img src="./img/hud/bubble.png"></a></li>'.PHP_EOL;
					//$retval .= '<li style="height: 32px; width:400px; margin:4 0 0 4; border-bottom:1px solid #c0c0c0;" class="'.$aglvl.'"><span id="inp"><span title="chartip"><img title="'.$row_a['ag_st_name'].'" height="32" align="left" src="http://image.eveonline.com/Corporation/'.$row_a['ag_crp'].'_32.png"></span></span> <a href="javascript:void(0)" onclick="CCPEVE.showInfo(1377, '.$row_a['ag_id'].')">'.$row_a['ag_name'].'</a> <a href="javascript:void(0)" onclick="CCPEVE.startConversation('.$row_a['ag_id'].')"><img src="./img/hud/bubble.png"></a></li>'.PHP_EOL;
					if($show){
						$retval .= '
							<tr>
								<td colspan="2"><img src="./img/hud/l'.$ag_lvl.'.png"></td><td rowspan="2" width="32" class="ag_b_bot"><img title="'.$row_a['ag_st_name'].'" src="http://image.eveonline.com/Corporation/'.$row_a['ag_crp'].'_32.png"></td><td class="ag_b_bot" rowspan="2"><a href="javascript:void(0)" onclick="CCPEVE.showInfo(1377, '.$row_a['ag_id'].')">'.$row_a['ag_name'].'</a></td>
							</tr>
							<tr>
								<td class="ag_b_bot" width="16"><a href="javascript:void(0)" onclick="CCPEVE.setDestination('.$row_a['ag_st_id'].')"><img title="Set Destination" src="./img/hud/set.png"></a></td><td class="ag_b_bot" width="16"><a href="javascript:void(0)" onclick="CCPEVE.startConversation('.$row_a['ag_id'].')"><img title="Start Conversation" src="./img/hud/bubble.png"></a></td>
							</tr>
							';
						//<a href="#" onclick="CCPEVE.setDestination('.$row_a['ag_sol_id'].')">set_route</a> -
						//<a href="#" onclick="CCPEVE.startConversation('.$row_a['ag_id'].')">convo</a>
					}
					$tst='';
				}
					//echo '<li class="'.$aglvl.'"><img align="left" src="http://image.eveonline.com/Corporation/'.$row_a['ag_crp'].'_32.png"> <a href="#" onclick="CCPEVE.showInfo(1377, '.$row_a['ag_id'].')">'.$row_a['ag_name'].'</a> <br /> <a href="#" onclick="CCPEVE.setDestination('.$row_a['ag_sol_id'].')">set_route</a> - <a href="#" onclick="CCPEVE.startConversation('.$row_a['ag_id'].')">convo</a></li>'; // shows all
				
			}
			//echo '</ul>';
			$retval .= '</table>';
		}
		$pelle='asdasd';
	return $retval;
}

$centerSystem = $_SERVER['HTTP_EVE_SOLARSYSTEMNAME'];
//$centerSystem='Vellaine'; //this is our starting system
//$distance = 5; //this is our maximum number of jumps
if($get_jumps=='0'){$cur_jumps='1';}else{$cur_jumps=$get_jumps;}
$distance = $cur_jumps; //this is our maximum number of jumps

$jumpsTable = array();
$reachableSystems = array($centerSystem);
	
//querys datadump, ignoring w-space and the inaccessible Jove regions
$querys="SELECT
f.solarSystemName,
f.solarSystemID,
GROUP_CONCAT(t.solarSystemName SEPARATOR ':') AS jumpNodes
FROM mapSolarSystems f
INNER JOIN mapSolarSystemJumps j ON (f.solarSystemID = j.fromSolarSystemID)
INNER JOIN mapSolarSystems t ON (j.toSolarSystemID = t.solarSystemID)
WHERE f.regionID < 11000001 AND f.regionID NOT IN (10000017, 10000019)
GROUP BY f.solarSystemName, f.solarSystemID";
$resultt=mysql_query($querys);
//build array with all jump nodes
//while(list($solarSystemName,$jumpNodes) = mysql_fetch_row($resultt))
while(list($solarSystemName,$solarSystemID,$jumpNodes) = mysql_fetch_row($resultt))
	$jumpsTable[$solarSystemName]= explode(':', $jumpNodes);

//this is where the magic happens :)
$jumpNum = 1;
$jumps = array();
echo '<ul class="shit">'.PHP_EOL;
while($jumpNum <= $distance){
	if($jumpNum == 1) $froms = array($centerSystem); else $froms = $jumps;
	$jumps = array();
	foreach($froms as $from) {
		$directJumps = array();
		foreach($jumpsTable[$from] as $jumpNode)
			if(array_search($jumpNode,$reachableSystems) === FALSE)
				$directJumps[]= $jumpNode;
		$reachableSystems = array_merge($reachableSystems,$directJumps);
		$jumps = array_merge($jumps,$directJumps);
		$solid = mysql_fetch_row(mysql_query("SELECT solarSystemID,solarSystemName FROM
							mapsolarsystems
							WHERE solarSystemName LIKE '$from';"));
		echo '<li class="system"><a href="javascript:void(0)" onclick="CCPEVE.showInfo(5, '.$solid[0].')" title="Show System Information">'.$from.'</a></li>' . PHP_EOL;
		//echo '<ul>' . PHP_EOL;
		//echo '<table border="0" width="100%">';
		//echo wrt_table(0,0,1,'100%','');
		//getagents($solid[0]);
		echo getagents($solid[0]);
		//echo '</ul>' . PHP_EOL;
		//echo '</table>';
	}
	$jumpNum++;
}
echo '</ul>'.PHP_EOL;
//all done!
//echo '<br />Total number of systems within '.$distance.' jumps from '. $centerSystem .' is '. (count($reachableSystems) - 1);










/*





echo'<hr>';

function getsys($curs){
	global $currsystem;
	$gets = mysql_query("SELECT msj.fromSolarSystemID AS fromss, msj.toSolarSystemID AS toss, ss.ssname AS sname,ss.systemid AS systemid FROM solarsystems ms INNER JOIN mapsolarsystemjumps msj ON ms.systemid=msj.fromSolarSystemID LEFT JOIN solarsystems ss ON msj.toSolarSystemID=ss.systemid WHERE ms.systemID='$curs';");	
	echo '<ul>';
	while($rowsys = mysql_fetch_array($gets)){
		if($rowsys['systemid']<>$currsystem){
			$test = ''.$rowsys['sname'].'<br />';
			echo '<li>'.$test.'</li>';
			//getagents($rowsys['toss']);
		}
	}
	echo '</ul>';
}



	$gets = mysql_query("SELECT msj.fromSolarSystemID AS fromss, msj.toSolarSystemID AS toss, ss.ssname AS sname,ss.systemid AS systemid FROM solarsystems ms INNER JOIN mapsolarsystemjumps msj ON ms.systemid=msj.fromSolarSystemID LEFT JOIN solarsystems ss ON msj.toSolarSystemID=ss.systemid WHERE ms.systemID='$currsystem';");	
	echo '<ul>';
	while($rowsys = mysql_fetch_array($gets)){
		if($rowsys['systemid']<>$currsystem){
			echo '<li>'.$rowsys['sname'].'</li>';
				if($nr_jumps>2){
					//echo'2 jump' . $rowsys['systemid'];
					getsys($rowsys['systemid']);
				}
		}
	}
	echo '</ul>';






echo'<hr>';


function getagents($solsystem){
	$get_ag = mysql_query("SELECT * FROM eve_db_agentloc WHERE ag_sol_id='".$solsystem."'");
		if($get_ag){
			echo '<ul>';
			while($row_a=mysql_fetch_array($get_ag)){
				if($row_a['ag_lvl']=='3'){
					$aglvl='contact3';
				}elseif($row_a['ag_lvl']=='4'){
					$aglvl='contact4';
				}else{
					$aglvl='contact';
				}
				echo '<li class="'.$aglvl.'">'.$row_a['ag_name'].'</li>';
			}
			echo '</ul>';
		}
}


function getsystem($curs){
	global $currsystem;
	$gets = mysql_query("SELECT msj.fromSolarSystemID AS fromss, msj.toSolarSystemID AS toss, ss.ssname AS sname,ss.systemid AS systemid FROM solarsystems ms INNER JOIN mapsolarsystemjumps msj ON ms.systemid=msj.fromSolarSystemID LEFT JOIN solarsystems ss ON msj.toSolarSystemID=ss.systemid WHERE ms.systemID='$curs';");	
	echo '<ul>';
	while($rowsys = mysql_fetch_array($gets)){
		if($rowsys['systemid']<>$currsystem){
			$test = ''.$rowsys['sname'].'<br />';
			echo '<li>'.$test.'</li>';
			getagents($rowsys['toss']);
		}
	}
	echo '</ul>';
}

$result = mysql_query("
SELECT
msj.fromSolarSystemID AS fromss,
msj.toSolarSystemID AS toss,
ss.ssname AS sname
FROM
solarsystems ms
INNER JOIN mapsolarsystemjumps msj ON ms.systemid=msj.fromSolarSystemID
LEFT JOIN solarsystems ss ON msj.toSolarSystemID=ss.systemid
WHERE ms.systemID='$currsystem';");
echo '<ul>';
while($row = mysql_fetch_array($result)) {

	echo '<li>' . $row['sname'] . '</li>';
	getagents($row['toss']);
	getsystem($row['toss']);


}

echo '</ul>';

getsystem($currsystem);


*/
//echo	'<a href="#" onclick="CCPEVE.setDestination(3867, 60007597)">60007597</a>';
?>