<?php
if(isset($_GET['s'])) {
	if($_GET['s']=='apiset') {
		$keyid=mysql_real_escape_string($_POST['keyID']);
		$vcode=mysql_real_escape_string($_POST['vCode']);
		$charid=mysql_real_escape_string($_POST['charID']);
		mysql_query("UPDATE corp_members SET api_keyid='$keyid', api_vcode='$vcode' WHERE char_id='$charid'");
		echo 'Update Success';
		$_SESSION['text'] = 'API Updated!';
		$_SESSION['type'] = 'success';
		//if ($logFile) {logToFile('Fitting','Fitt Deleted','no return value');} // Logger
		redirect('./?module=member_settings'); exit();
	}elseif($_GET['s']=='standings'){
		$char_id=$_SERVER['HTTP_EVE_CHARID'];
		$apidb = good_query_assoc("SELECT * FROM corp_members WHERE char_id='$char_id'");
		$apiurl = "https://api.eveonline.com/char/Standings.xml.aspx?keyID=".$apidb['api_keyid']."&vCode=" .$apidb['api_vcode'];
		$xmlFile = file_get_contents($apiurl);
		file_put_contents("./cache/xml/hud/" . $char_id . '.xml' , $xmlFile);
		//echo 'Done Fetching Api';
			if(!file_exists('./cache/xml/hud/'.$_SERVER['HTTP_EVE_CHARID'].'.xml')){
				//echo'nope';
			}else{
				$charxml = './cache/xml/hud/'.$_SERVER['HTTP_EVE_CHARID'].'.xml';
				$xmlFile = file_get_contents($charxml);
				$xmlRead = new SimpleXMLElement($xmlFile);
					$accChars = $xmlRead->xpath("result/characterNPCStandings/rowset[@name='NPCCorporations']/row");
					$ic=0;
					foreach($accChars as $curChars){
						$result = good_query("SELECT * FROM cache_ag_standings WHERE char_id='$char_id' AND fromID=$curChars[fromID]");
						if (mysql_num_rows($result)>0){
							mysql_query("UPDATE cache_ag_standings SET standings='$curChars[standing]' WHERE char_id=$char_id AND fromID=$curChars[fromID]");
						}else{
							mysql_query("INSERT INTO cache_ag_standings (char_id, fromID, standings) VALUES ($char_id, $curChars[fromID], '$curChars[standing]')");
						}
					}
					//echo'<br />Done Updating Database.';
			}
		$_SESSION['text'] = 'Standings API Updated!';
		$_SESSION['type'] = 'success';
		redirect('./?module=member_settings'); exit();
	}
}
?>