<?php
//session_start();
/*
echo	'<html>
		<a href="ckills2.php">start</a> |
		<a href="ckills2.php?do=update">update</a> |
		<a href="ckills2.php?do=empty">empty</a> |
		<hr>';
		*/
//include('../../_cfg.php');
//include('../../_vars.php');
//if (isset($_GET['do']) && $_GET['do']=='empty') {$modeEmpty=true;}else{$modeEmpty=false;}
//if (isset($_GET['do']) && $_GET['do']=='update') {$modeUpdate=true;}else{$modeUpdate=false;}
$modeUpdate=true;
$cronState=false;
//$modeEmpty=true;
include('./config.php');
include('./includes/functions.php');
include('./includes/database.php');
if (isset($_GET['do']) && $_GET['do']=='empty') {
include('./config.php');
include('./includes/functions.php');
$empty_kbkill1 = mysql_query("TRUNCATE TABLE kb_kill");
$empty_kbkill2 = mysql_query("TRUNCATE TABLE kb_items_destr");
$empty_kbkill3 = mysql_query("TRUNCATE TABLE kb_items_drop");
$empty_kbkill4 = mysql_query("TRUNCATE TABLE kb_attackers");
$strLocation='../../';
}else{
$strLocation='./'; //for debugging porpuses ../../ for direct test
}
//echo ini_get('max_execution_time') .'<br />';
set_time_limit(120);
//echo ini_get('max_execution_time') .'<br />';


$apiauth = good_query_assoc("SELECT * FROM api");
$vCode = $apiauth['vCode'];
$keyID = $apiauth['keyID'];

// (step 1) temp download xml sheet
	// (step 2)get adress from database
	$apiSheet = "corp/Killlog"; 
	$apiAddress = mysql_query("SELECT apiaddresses.*, cacheduntil.* FROM apiaddresses, cacheduntil WHERE apiaddresses.apiSheetName = '" . $apiSheet . "'") or die(mysql_error());
		$rowapi = mysql_fetch_row($apiAddress);
			//echo $rowapi['2'] . '<br />';
			$apiUrleve = $rowapi['2'] . "?keyID=".$keyID."&vCode=" .$vCode; // code to be run after debug!!
			//$apiUrleve = 'http://gungho.pwnz.org/cache/xml/23231_killog_prepare_werror.xml';
			//$apiUrleve = 'http://gungho.pwnz.org/cache/xml/23231_killog_prepare_current.xml';
			//$apiUrleve = 'http://gungho.pwnz.org/cache/xml/23231_killog_update.xml';
				$xmlFile = file_get_contents($apiUrleve); // check if file exists first ??
				if ($cronState == false) {file_put_contents($strLocation."cache/xml/" . $keyID . "_killog_prepare.xml", $xmlFile);} // now your xml file is saved.
				if ($cronState == true) {file_put_contents("../cache/xml/" . $keyID . "_killog_prepare.xml", $xmlFile);} // now your xml file is saved.
					// (step 3)check if file contains errors, if it does, skip update and wait so we dont fuck up database!
						if ($cronState == false) {$apiUrlLocal = $strLocation."cache/xml/" . $keyID . "_killog_prepare.xml";}
						if ($cronState == true) {$apiUrlLocal = "../cache/xml/" . $keyID . "_killog_prepare.xml";}
						$string = file_get_contents($apiUrlLocal);
						$xmlRead = new SimpleXMLElement($string);
							$checkXML = $xmlRead->error[0];
	if (isset($checkXML)) { // verify if xml is ok!
								
									//error
									// if error we should update cacheduntil to the current one, so that eve api dont get sad!
									$xmlCache = $xmlRead->cachedUntil;
										$cacheUpdate = "UPDATE cacheduntil SET cacheexpire = '" . $xmlCache . "' WHERE keyID = '" . $keyID . "' AND addressID = '10'";
										$cacheUpdateResult = mysql_query($cacheUpdate) or die(mysql_error());
										if ($logFile) {logToFile('Kills','Cache','Exhausted');} // Logger
															$_SESSION['text']='Kills Cache Exhasuted, no update done.';
															$_SESSION['type']='warning';
										if ($cronState == false) {
										//header("Location: ./?p=killboard");
										//redirect('./?p=killboard'); exit();
										echo 'updated cache';
										}
								
	} else {
									//echo 'wtf';
									//ok
									// (step 4) All is ok, now we update database! and rename xml file!
									
									if ($cronState == false) {rename($strLocation."cache/xml/" . $keyID . "_killog_prepare.xml", $strLocation."cache/xml/" . $keyID . "_killog.xml");}
									if ($cronState == true) {rename("../cache/xml/" . $keyID . "_killog_prepare.xml", "../cache/xml/" . $keyID . "_killog.xml");}
									
//#########################################################################################
				// (step 5) Load the local functional xml file and retrieve cached until!
				
				if ($cronState == false) {$apiUrlLocal = $strLocation."cache/xml/" . $keyID . "_killog.xml";}
				if ($cronState == true) {$apiUrlLocal = "../cache/xml/" . $keyID . "_killog.xml";}
				
				//$apiUrlLocal = 'http://gungho.pwnz.org/cache/xml/23231_killog_prepare_current.xml';
				//$apiUrlLocal = 'http://gungho.pwnz.org/cache/xml/23231_killog_prepare_current3_ME.xml';
				$string = file_get_contents($apiUrlLocal);
				$xmlRead = new SimpleXMLElement($string);
				$xmlCache = $xmlRead->cachedUntil;
				//echo '<br />xmlCache'. $xmlCache;
				$i=0;
				$acnt=0;
				$killCnt = $xmlRead->result->rowset->row;
				$kills = $xmlRead->result->rowset->row['killID'];
				//$lastkill = '20267373';
				//echo $kills .'</br>';
			$sql = 'select * from kb_kill ORDER BY kill_time desc limit 1';
			$result = mysql_query($sql) or die(mysql_error());
			//$row = mysql_fetch_array($result) or die(mysql_error());
			//$lastkill = $row['killid'];
			//$lastkill = $result['killid'];
			//echo $lastkill;
$row = mysql_fetch_array($result, MYSQLI_ASSOC) ;

if(!$row){
$lastkill=false;
$init=true;
} else {
$lastkill=$row['killid'];
$init=false;
}
$killcounter=0;
$attackcounter=0;
$itemcounter=0;
		while ($killCnt->$i) {
		//while ($kills != $lastkill) {
		$killID = mysql_real_escape_string($xmlRead->result->rowset->row[$i]['killID']);
		//echo $killID;
		$killsystem = mysql_real_escape_string($xmlRead->result->rowset->row[$i]['solarSystemID']);
		$killDate = mysql_real_escape_string($xmlRead->result->rowset->row[$i]['killTime']);
		if ($modeUpdate) {
			if (!$init){
				if ($killID==$lastkill) break; // if no new results found, DO NOTHING MUHAHAHAHAHAHAHA
			}
		}
					//################## DATABASE KILL INFO
						if ($modeUpdate) {
							//$sql="INSERT INTO kb_kill (killid, sol_system, kill_time) VALUES ('$killID','$killsystem','$killDate')";
							//if (!mysql_query($sql,$con)) {die('Error: ' . mysql_error());}echo "1 record added";
						}
				$arrvictim = $xmlRead->xpath("result/rowset/row[@killID='".$killID."']/victim");
				$jsonvictim = json_encode($arrvictim);
				$arrayvictim = json_decode($jsonvictim,TRUE);
				//echo	$killID . '<br />';
				//echo	$killsystem . '<br />';
				//echo	$killDate . '<br />';
				$vic_chid = mysql_real_escape_string($arrayvictim[0]['@attributes']['characterID']);
				$vic_chnm = mysql_real_escape_string($arrayvictim[0]['@attributes']['characterName']);
				$vic_crpid = mysql_real_escape_string($arrayvictim[0]['@attributes']['corporationID']);
				$vic_crpnm = mysql_real_escape_string($arrayvictim[0]['@attributes']['corporationName']);
				$vic_allid = mysql_real_escape_string($arrayvictim[0]['@attributes']['allianceID']);
				$vic_allnm = mysql_real_escape_string($arrayvictim[0]['@attributes']['allianceName']);
				$vic_facid = mysql_real_escape_string($arrayvictim[0]['@attributes']['factionID']);
				$vic_facnm = mysql_real_escape_string($arrayvictim[0]['@attributes']['factionName']);
				$vic_dgm = mysql_real_escape_string($arrayvictim[0]['@attributes']['damageTaken']);
				$vic_ship = mysql_real_escape_string($arrayvictim[0]['@attributes']['shipTypeID']);
				//echo '<pre>';print_r($arrayvictim);echo '</pre>';
					//################## DATABASE VICTIM INFO
						if ($modeUpdate) {
							$sql="INSERT INTO kb_kill (killid,sol_system,kill_time,characterID,characterName,corporationID,corporationName,allianceID,allianceName,factionID,factionName,damageTaken,shipTypeID) VALUES ('$killID','$killsystem','$killDate','$vic_chid','$vic_chnm','$vic_crpid','$vic_crpnm','$vic_allid','$vic_allnm','$vic_facid','$vic_facnm','$vic_dgm','$vic_ship')";
							if (!mysql_query($sql)) {die('Error: ' . mysql_error());}$killcounter++;
						}
			//################## ITEMS BOF
			$arritems = $xmlRead->xpath("result/rowset/row[@killID='".$killID."']/rowset[@name='items']/row");
			$ii=0;
			//echo '<pre>';print_r($items);echo '</pre>';
			//$jsonitems = json_encode($arritems);
			//$arrayitems = json_decode($jsonitems,TRUE);
			//echo $killID . '<br />';
			//$itm_type = mysql_real_escape_string($arrayitems[0]['@attributes']['typeID']);
			//echo $itm_type;
			foreach ($arritems as $value){
				$typeID = $value['typeID'];
				$flag = $value['flag'];
				$qtyDrp = $value['qtyDropped'];
				$qtyDst = $value['qtyDestroyed'];
					if ($modeUpdate) {
					$sqlSlot = "
					SELECT eve_db_invTypes.typeID,eve_db_invTypes.typeName,eve_db_dgmTypeEffects.effectID,eve_db_dgmEffects.effectName
					FROM
					eve_db_invTypes LEFT JOIN eve_db_dgmTypeEffects ON eve_db_invTypes.typeID = eve_db_dgmTypeEffects.typeID 
					LEFT JOIN eve_db_dgmEffects ON eve_db_dgmTypeEffects.effectID = eve_db_dgmEffects.effectID
					WHERE
					(eve_db_invTypes.typeID = ".$typeID.") AND eve_db_dgmTypeEffects.effectID IN ('11','12','13','2663','3772')";
					$resultSlot = mysql_query($sqlSlot);// or die(mysql_error());
					$rowSlot = mysql_fetch_array($resultSlot);// or die(mysql_error());
					//echo $rowSlot['effectName'];
					if($rowSlot['effectName']=='hiPower'){$slotPlace='1';}
					elseif($rowSlot['effectName']=='medPower'){$slotPlace='2';}
					elseif($rowSlot['effectName']=='loPower'){$slotPlace='3';}
					elseif($rowSlot['effectName']=='rigSlot'){$slotPlace='5';}
					elseif($rowSlot['effectName']=='subSystem'){$slotPlace='7';}
					elseif($flag=='5'){$slotPlace='4';}
					elseif($flag=='87'){$slotPlace='6';}
					else{$slotPlace='0';}
					}else{$slotPlace='0';}
					//echo $slotPlace .'<br />';
					
					//$slotPlace='0';
				if ($qtyDrp > 0){
						if ($modeUpdate) {
							$sql="INSERT INTO kb_items_drop (kill_id, item_id, qty, slot, flag) VALUES ('$killID','$typeID','$qtyDrp','$slotPlace','$flag')";
							if (!mysql_query($sql)) {die('Error: ' . mysql_error());}//echo "1 record added";
						$itemcounter++;
						}
				}
				if ($qtyDst > 0){
						if ($modeUpdate) {
							$sql="INSERT INTO kb_items_destr (kill_id, item_id, qty, slot, flag) VALUES ('$killID','$typeID','$qtyDst','$slotPlace','$flag')";
							if (!mysql_query($sql)) {die('Error: ' . mysql_error());}//echo "1 record added";
						$itemcounter++;
						}
				}
				//echo '<hr>';
			}
			//echo '<pre>';print_r($arrayitems);echo '</pre>';
			//################## ITEMS EOF

			//################## Attackers BOF
			$arrattac = $xmlRead->xpath("result/rowset/row[@killID='".$killID."']/rowset[@name='attackers']/row");
			$jsonattac = json_encode($arrattac);
			$arrayattack = json_decode($jsonattac,TRUE);
			foreach ($arrayattack as $value) {
				$att_chr_id = mysql_real_escape_string($value['@attributes']['characterID']);
				$att_chr_nm = mysql_real_escape_string($value['@attributes']['characterName']);
				$att_crp_id = mysql_real_escape_string($value['@attributes']['corporationID']);
				$att_crp_nm = mysql_real_escape_string($value['@attributes']['corporationName']);
				$att_all_id = mysql_real_escape_string($value['@attributes']['allianceID']);
				$att_all_nm = mysql_real_escape_string($value['@attributes']['allianceName']);
				$att_fac_id = mysql_real_escape_string($value['@attributes']['factionID']);
				$att_fac_nm = mysql_real_escape_string($value['@attributes']['factionName']);
				$att_sec = mysql_real_escape_string($value['@attributes']['securityStatus']);
				$att_dmg = mysql_real_escape_string($value['@attributes']['damageDone']);
				$att_fb = mysql_real_escape_string($value['@attributes']['finalBlow']);
				$att_wpn = mysql_real_escape_string($value['@attributes']['weaponTypeID']);
				$att_shp = mysql_real_escape_string($value['@attributes']['shipTypeID']);
				//echo'<pre>';print_r($value);echo'</pre>';
					//################## DATABASE ATTACKER INFO
						if ($modeUpdate) {
							$sql="INSERT INTO kb_kill_attackers (plt_id,kill_id,plt_name,crp_id,crp_name,all_id,all_name,fac_id,fac_name,wpn_id,dmgdone,fb,sec,ship) VALUES ('$att_chr_id','$killID','$att_chr_nm','$att_crp_id','$att_crp_nm','$att_all_id','$att_all_nm','$att_fac_id','$att_fac_nm','$att_wpn','$att_dmg','$att_fb','$att_sec','$att_shp')";
							if (!mysql_query($sql)) {die('Error: ' . mysql_error());}//echo "1 record added";
						}
			$attackcounter++;
			}
			//echo '<pre>';print_r($arrayattack);echo '</pre>';
			//################## Attackers EOF
							$i++;
							}
							//echo 'Kills/Losses '.$killcounter.' | Attackers '.$attackcounter.' | Items '.$itemcounter;
														$cacheUpdate = "UPDATE cacheduntil SET cacheexpire = '" . $xmlCache . "' WHERE keyID = '" . $keyID . "' AND addressID = '10'";
														$cacheUpdateResult = mysql_query($cacheUpdate) or die(mysql_error());
														
															if (!$cacheUpdateResult) {
																//echo "die";
																
																if ($logFile) {logToFile('Kills','DB Update','Failed');} // Logger
																	$_SESSION['text']='DB Update Failed!';
																	$_SESSION['type']='warning';
																
															} else {
																
																if ($logFile) {logToFile('Kills','DB Update','Success');} // Logger
																	$_SESSION['text']='DB Update Success! Updated '.$killcounter.' Kills, '.$itemcounter.' Items, '.$attackcounter.' Attackers!';
																	$_SESSION['type']='success';
																
															}
														
//##########################################################################################
												if ($cronState == false) {
												//header("Location: ./?p=killboard"); exit();
												//redirect('./?p=killboard'); exit();
												echo 'finished';
												}
												//$redirUrl = './?p=killboard';
	}


//###################### MEMEBR TRACKIGN ###########################

	// (step 1) temp download xml sheet
		// (step 2)get adress from database
			$apiSheet = "corp/MemberTracking"; 
			$apiAddress = mysql_query("SELECT apiaddresses.*, cacheduntil.* FROM apiaddresses, cacheduntil WHERE apiaddresses.apiSheetName = '" . $apiSheet . "'") or die(mysql_error());
				$rowapi = mysql_fetch_row($apiAddress);
					//echo $rowapi['2'] . '<br />';
					$apiUrleve = $rowapi['2'] . "?keyID=" . $keyID . "&vCode=" . $vCode."&extended=1"; // code to be run after debug!!
					//$apiUrleve = 'http://craxxe.mooo.com/gungho/ghoo/xml/23231_membertracking_prepare_current.xml';
					//$apiUrleve = 'http://craxxe.mooo.com/gungho/ghoo/xml/23231_membertracking_prepare_werror.xml';
					//$apiUrleve = 'http://gungho.pwnz.org/xml/23231_membertracking_awe.xml';
						$xmlFile = file_get_contents($apiUrleve); // check if file exists first ??
						if ($cronState == false) {file_put_contents($strLocation."cache/xml/" . $keyID . "_membertracking_prepare.xml", $xmlFile);} // now your xml file is saved.
						if ($cronState == true) {file_put_contents("../cache/xml/" . $keyID . "_membertracking_prepare.xml", $xmlFile);} // now your xml file is saved.
							// (step 3)check if file contains errors, if it does, skip update and wait so we dont fuck up database!
								if ($cronState == false) {$apiUrlLocal = $strLocation."cache/xml/" . $keyID . "_membertracking_prepare.xml";}
								if ($cronState == true) {$apiUrlLocal = "../cache/xml/" . $keyID . "_membertracking_prepare.xml";}
								$string = file_get_contents($apiUrlLocal);
								$xmlRead = new SimpleXMLElement($string);
									$checkXML = $xmlRead->error[0];
										if (isset($checkXML)) { // verify if xml is ok!
											//error
											// if error we should update cacheduntil to the current one, so that eve api dont get sad!
											$xmlCache = $xmlRead->cachedUntil;
												$cacheUpdate = "UPDATE cacheduntil SET cacheexpire = '" . $xmlCache . "' WHERE keyID = '" . $keyID . "' AND addressID = '2'";
												$cacheUpdateResult = mysql_query($cacheUpdate) or die(mysql_error());
												if ($logFile) {logToFile('MembTrack','Cache','Exhausted');} // Logger
												if ($cronState == false) {
												//header("Location: ./?p=".$_GET['r']."");
												redirect('./?p='.$_GET['r'].''); exit();
												}
										} else {
											//ok
											// (step 4) All is ok, now we update database! and rename xml file!
											if ($cronState == false) {rename($strLocation."cache/xml/" . $keyID . "_membertracking_prepare.xml", $strLocation."cache/xml/" . $keyID . "_membertracking.xml");}
											if ($cronState == true) {rename("../cache/xml/" . $keyID . "_membertracking_prepare.xml", "../cache/xml/" . $keyID . "_membertracking.xml");}
//#########################################################################################
												// (step 5) Load the local functional xml file and retrieve cached until!
													if ($cronState == false) {$apiUrlLocal = $strLocation."cache/xml/" . $keyID . "_membertracking.xml";}
													if ($cronState == true) {$apiUrlLocal = "../cache/xml/" . $keyID . "_membertracking.xml";}
													$string = file_get_contents($apiUrlLocal);
													$xmlRead = new SimpleXMLElement($string);
													$xmlCache = $xmlRead->cachedUntil;
													//echo '<br />xmlCache'. $xmlCache;
														$cacheUpdate = "UPDATE cacheduntil SET cacheexpire = '" . $xmlCache . "' WHERE keyID = '" . $keyID . "' AND addressID = '2'";
														$cacheUpdateResult = mysql_query($cacheUpdate) or die(mysql_error());
															if (!$cacheUpdateResult) {
																//echo "die";
																$sm = "DB Update Failed!";
																if ($logFile) {logToFile('MembTrack V2','DB Update','Failed');} // Logger
																	$_SESSION['text']='DB Update Failed!';
																	$_SESSION['type']='warning';
															} else {
																//echo "success!!!!";
																$sm = "DB Update Success!";
																if ($logFile) {logToFile('MembTrack V2','DB Update','Success');} // Logger
																	$_SESSION['text']='DB Update Succeeded!';
																	$_SESSION['type']='success';
																// (step 6) Load the local functional xml file and retrieve online times!
																	//#################################################################### updateDB.php BOF
																	$string = file_get_contents($apiUrlLocal);
																	$xml = new SimpleXMLElement($string);
																	$xmlrowset = $xml->result->rowset;
																	$xmlrow = $xml->result->rowset->row;
																	$member = $xml->result->rowset->row;
																// (step 7) Update all results and skip duplicates based on charid and charlogon!
																	$cnt=0;
																		/*
																		while ($member->$cnt) {
																			$charID = $xmlrowset->row[$cnt]['characterID'];
																			$charTime = $xmlrowset->row[$cnt]['logonDateTime'];
																			$charTimeOff = $xmlrowset->row[$cnt]['logoffDateTime'];
																			$result=mysql_query("SELECT count(*) as numrecords FROM ontimes WHERE charid='" . $charID . "' and onTime='" . $charTime . "'") or die ('Queryproblem - updatemania');
																			$row=mysql_fetch_assoc($result);
																			if ($row['numrecords'] >= 1){
																			} else {
																			mysql_query("INSERT INTO ontimes (charID, onTime, offTime) VALUES ('$charID','$charTime','$charTimeOff')") or die("Error inserting onTimes! ".mysql_error());
																			}
																			$cnt++;
																		}
																		*/

				$arrmembers = $xmlRead->xpath("result/rowset[@name='members']/row");
				$jsonmembers = json_encode($arrmembers);
				$arraymembers = json_decode($jsonmembers,TRUE);
				//echo '<pre>';
				//print_r($arraymembers);
				//echo '</pre>';
				$arrRemove=array();
				foreach($arraymembers as $mem){
					$chaid = $mem['@attributes']['characterID'];
					$chaname = mysql_real_escape_string($mem['@attributes']['name']);
					$charole = $mem['@attributes']['roles'];
					$chaloc = mysql_real_escape_string($mem['@attributes']['locationID']);
					$chalocname = mysql_real_escape_string($mem['@attributes']['location']);
					$chaship = $mem['@attributes']['shipTypeID'];
					$chaon = $mem['@attributes']['logonDateTime'];
					$chaoff = $mem['@attributes']['logoffDateTime'];
					/*
					echo $chaid.'<br />';
					echo $chaname.'<br />';
					echo $charole.'<br />';
					echo $chaloc.'<br />';
					echo $chaloc.'<br />';
					echo $chaship.'<br />';
					echo $chaon.'<br />';
					echo $chaoff.'<br />';
					*/

					$exists= good_query_assoc("SELECT count(*) as numrecords FROM corp_members WHERE char_id='" . $chaid . "'") or die ('queryproblems - exists.');
					//$exists= good_query_assoc("SELECT count(*) as numrecords FROM corp_members WHERE char_id='" . $chaid . "' and char_log_on='" . $chaon . "'") or die ('Queryproblem checking existing record.');
					if(!$exists['numrecords'] >= 1) {
						//echo 'doesnt exists';
						mysql_query("INSERT INTO corp_members (char_id,char_name,char_role,char_loc,char_loc_name,char_ship,char_log_on,char_log_off) VALUES ('$chaid','$chaname','$charole','$chaloc','$chalocname','$chaship','$chaon','$chaoff')") or die("Error inserting onTimes! ".mysql_error());
					}else{
						$update= good_query_assoc("SELECT count(*) as numrecords FROM corp_members WHERE char_id='" . $chaid . "' and char_log_on='" . $chaon . "'") or die ('Queryproblem - update.');
						if (!$update['numrecords'] >=1){
							//echo'logdate old';
							$updatetimes = "UPDATE corp_members SET char_role='".$charole."',char_loc='".$chaloc."',char_ship='".$chaship."',char_log_on='".$chaon."',char_log_off='".$chaoff."' WHERE char_id = '" .$chaid. "'";
							$updateit = mysql_query($updatetimes) or die(mysql_error());
						}else{
							//echo'logdate current';
						}
						
					}
					$arrRemove[]=$chaid;
					//echo '<hr>';
				}
				//------------ Clean Corp Start
				$clean_corp = good_query_table("SELECT * FROM corp_members WHERE char_id NOT IN ('".implode(',', $arrRemove)."')");
				foreach($clean_corp as $clean_mem){
					if(!in_array($clean_mem['char_id'],$arrRemove)){
						//remove corp member
						mysql_query("DELETE FROM corp_members WHERE char_id='".$clean_mem['char_id']."'");
					}
				}
				//------------- Clean Corp End
																		while ($member->$cnt) {
																			$charID = $xmlrowset->row[$cnt]['characterID'];
																			$charTime = $xmlrowset->row[$cnt]['logonDateTime'];
																			$charTimeOff = $xmlrowset->row[$cnt]['logoffDateTime'];
																			$result=mysql_query("SELECT count(*) as numrecords FROM ontimes WHERE charid='" . $charID . "' and onTime='" . $charTime . "'") or die ('Queryproblem - updatemania');
																			$row=mysql_fetch_assoc($result);
																			if ($row['numrecords'] >= 1){
																			} else {
																			mysql_query("INSERT INTO ontimes (charID, onTime, offTime) VALUES ('$charID','$charTime','$charTimeOff')") or die("Error inserting onTimes! ".mysql_error());
																			}
																			$cnt++;
																		}
																	//#################################################################### updateDB.php EOF
															}
//##########################################################################################
										//header redir after successfull update!
												if ($cronState == false) {
												//header("Location: ./?p=members");
												//redirect('./?p=members'); exit();
												}
										}

// add fetch corp standings to be able to merge them with the LAL
		$apiurl = "https://api.eveonline.com/corp/Standings.xml.aspx?keyID=".$keyID."&vCode=" .$vCode;
		$xmlFile = file_get_contents($apiurl);
		file_put_contents($strLocation."cache/xml/hud/corp_standings.xml" , $xmlFile);
		if(!file_exists($strLocation.'cache/xml/hud/corp_standings.xml')){
			echo'nope';
		}else{
			$charxml = $strLocation.'cache/xml/hud/corp_standings.xml';
			$xmlFile = file_get_contents($charxml);
			$xmlRead = new SimpleXMLElement($xmlFile);
				$xmlnpc = $xmlRead->xpath("result/corporationNPCStandings/rowset[@name='NPCCorporations']/row");
				$npccharid='0000'.$G_corpID;
				$faccharid='0001'.$G_corpID;
				foreach($xmlnpc as $curnpc){
					$resultnpc = good_query("SELECT * FROM cache_ag_standings WHERE char_id='$npccharid' AND fromID=$curnpc[fromID]");
					if (mysql_num_rows($resultnpc)>0){
						mysql_query("UPDATE cache_ag_standings SET standings='$curnpc[standing]' WHERE char_id='$npccharid' AND fromID=$curnpc[fromID]");
					}else{
						mysql_query("INSERT INTO cache_ag_standings (char_id, fromID, standings) VALUES ('$npccharid', $curnpc[fromID], '$curnpc[standing]')");
					}
				}
				$xmlfac = $xmlRead->xpath("result/corporationNPCStandings/rowset[@name='factions']/row");
				foreach($xmlfac as $curfac){
					$resultfac = good_query("SELECT * FROM cache_ag_standings WHERE char_id='$faccharid' AND fromID=$curfac[fromID]");
					if (mysql_num_rows($resultfac)>0){
						mysql_query("UPDATE cache_ag_standings SET standings='$curfac[standing]' WHERE char_id='$faccharid' AND fromID=$curfac[fromID]");
					}else{
						mysql_query("INSERT INTO cache_ag_standings (char_id, fromID, standings) VALUES ('$faccharid', $curfac[fromID], '$curfac[standing]')");
					}
				}
				echo'<br />Done Updating Corp Standings Database.';
		}

?>