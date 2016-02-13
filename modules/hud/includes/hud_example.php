<?php
$hudfile = 'hud_example.php';
?>






<?php
//include('../../../css/hud.css');
$con2 = mysql_connect("localhost","root","nsjsd");
if (!$con2)
	{die('Could not connect: ' . mysql_error());}
mysql_select_db("evedata1_dbo", $con2);


//$currsystem='30001380';
//$currsystem='30000145';
$currsystem = $_SERVER['HTTP_EVE_SOLARSYSTEMID'];
$result = mysql_query("
SELECT msj.fromSolarSystemID AS fromss, msj.toSolarSystemID AS toss, en.ItemName AS name FROM mapsolarsystems ms
INNER JOIN mapsolarsystemjumps msj ON ms.solarSystemID=fromSolarSystemID LEFT JOIN evenames en ON msj.toSolarSystemID=en.itemID
WHERE solarSystemID='$currsystem';");
$i=1;
echo	'<table cellpadding="0" cellspacing="0" border="0" width="850" class="center">';
echo	'<tr><th class="ft_head" width="200" height="40">Systems</th><th align="left" class="ft_head">Results <div id="loadinghud"><img src="./img/ghooloader2_s.gif" /></div></th></tr>';
echo	'<tr><td valign="top">';
echo	'<ul id="nav">';
while($row = mysql_fetch_array($result)) {
  //echo $row['Agent'] . ' ' . $row['Station'] . ' ' . $row['locID'] . ' ' . $row['statID'];
  echo '<li class="system"><a href="javascript:loadContent('.$row['toss'].');">'.$row['name'].'</a></li>';
  //echo $row['fromss'].' '.$row['toss'].' '.$row['name'];
  //echo '<li class="1system">
//			<a href="#" id="node_'.$i.'" onclick="CCPEVE.setDestination('.$row['toss'].')">'.$row['name'].'</a>
//				<ul><li parentID="'.$row['toss'].'">Loading....</li></ul></li>';
  //#######################
	$result2 = mysql_query("
	SELECT 	msj.fromSolarSystemID AS fromss, msj.toSolarSystemID AS toss, en.ItemName AS name FROM mapsolarsystems ms
	INNER JOIN mapsolarsystemjumps msj ON ms.solarSystemID=fromSolarSystemID LEFT JOIN evenames en ON msj.toSolarSystemID=en.itemID
	WHERE solarSystemID='".$row['toss']."';");
			echo	'<ul>';
				while($subsys = mysql_fetch_array($result2)) {
					if ($subsys['toss']!=$currsystem){
						echo '<li class="system"><a href="javascript:loadContent('.$subsys['toss'].');">'.$subsys['name'].'</a></li>';
					}
								//echo '<li>Station: '.$rowag1['Station'].'</li><ul><li>Name: '.$rowag1['Agent'].'</li></ul>';
					//$reslvl = mysql_query("SELECT * FROM agtconfig WHERE agentID=".$rowag1['agntID']." AND k='level'");
					//	while($rAlvl = mysql_fetch_array($reslvl)) {
										//echo $rAlvl['v'];
//										if ($rAlvl['v']=='3') {echo '<li class="station agntl3">Station: <a href="#" onclick="CCPEVE.showInfo(3867, '.$rowag1['statID'].')">'.$rowag1['Station'].'</a></li><ul><li class="contact3 agntl3">Name: <a href="#" onclick="CCPEVE.showInfo(1377, '.$rowag1['agntID'].')">'.$rowag1['Agent'].'</a></li></ul>';}
//										if ($rAlvl['v']=='4') {echo '<li class="station agntl4">Station: <a href="#" onclick="CCPEVE.showInfo(3867, '.$rowag1['statID'].')">'.$rowag1['Station'].'</a></li><ul><li class="contact4 agntl4">Name: <a href="#" onclick="CCPEVE.showInfo(1377, '.$rowag1['agntID'].')">'.$rowag1['Agent'].'</a></li></ul>';}
					//	}
				}
			echo	'</ul>';
$i++;
}
mysql_close($con2);
echo	'</ul>';
echo	'</td><td valign="top">';
echo	'	<div id="contentArea2" style="margin: 20px 0px 10px 10px;">
				&nbsp;
			</div>';
echo	'</td></tr></table>';

$resultTEST = mysql_query("SELECT nA.itemName AS Agent, nS.itemName AS Station FROM agtConfig c
INNER JOIN agtAgents a ON c.agentID=a.agentID
INNER JOIN eveNames nA ON c.agentID=nA.itemID
LEFT JOIN eveNames nS ON a.locationID=nS.itemID
WHERE c.k='agent.LocateCharacterService.enabled'
AND nA.itemName LIKE 'Ae%';");
	//while($testsys = mysql_fetch_array($resultTEST)) {
	//	echo $testsys['Agent'];
	//}

?>
</body>
</html>