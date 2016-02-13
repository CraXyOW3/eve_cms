<?php
//sleep(1);
include('./functions.php');
$strLocation='./../';
$srv_status = array(
			array('Tranquility','http://api.eveonline.com/server/ServerStatus.xml.aspx'),
			array('Singularity','http://api.testeveonline.com/server/ServerStatus.xml.aspx')
			);
foreach($srv_status as $row){
	$srvLocal = $strLocation."cache/xml/server_" . $row[0] . ".xml";
	$string = file_get_contents($srvLocal);
	$xml = new SimpleXMLElement($string);
		$xmlCache = $xml->cachedUntil;
		$srv_cache = strtotime($xmlCache);
		$srv_update = strtotime(getEVEZone(date('Y-m-d H:i:s',time())));
		if ($srv_cache < $srv_update){
			$xmlFile = file_get_contents($row[1]);
				if($xmlFile==true){
					file_put_contents($strLocation."cache/xml/server_" . $row[0] . "_prepare.xml", $xmlFile);
					rename($strLocation."cache/xml/server_" . $row[0] . "_prepare.xml", $strLocation."cache/xml/server_" . $row[0] . ".xml");
				}
		}
	//echo $row[0].' ';;
	if ($xml->result->serverOpen){
		//echo'Online';
		echo '<font color="#0f0">'.$row[0].'</font>';
	}else{
		//echo'Offline';
		echo '<font color="#f00">'.$row[0].'</font>';
	}
//	echo ' Servertime: ' . date('H:i:s',strtotime($xml->currentTime));
	echo ' : ' . $xml->result->onlinePlayers;
	echo '<br />';
}
?>