<?php
//sleep(1);
include('../../../config.php');
include('../../../includes/database.php');
include('../../../includes/functions.php');
include('../../../includes/dna_kb_extract.php');
$evenOdd = true;
if (isset($_GET['id'])){$id=$_GET['id'];}

if (isset($_GET['mode'])) {

$sql = mysql_query ("SELECT * FROM kb_kill where killid=".$id."") or die (mysql_error());
//SELECT * FROM `kb_kill` where `killid`=20267373
$row = mysql_fetch_array($sql);
$hs_drp=0;$ms_drp=0;$ls_drp=0;$rs_drp=0;$ss_drp=0;$hs_dst=0;$ms_dst=0;$ls_dst=0;$rs_dst=0;$ss_dst=0;
$sql_drp = "SELECT * FROM kb_items_drop where kill_id=".$id." AND flag=0 ORDER BY slot ASC";
$sql_dst = "SELECT * FROM kb_items_destr where kill_id=".$id." AND flag=0 ORDER BY SLOT ASC";
$res_drp = mysql_query($sql_drp) or die (mysql_error());
$res_dst = mysql_query($sql_dst) or die (mysql_error());
/*
while ($resd=mysql_fetch_assoc($res_dst)){
	echo $resd['item_id'].'<br />';
}
*/
$test=0;
$i=0;
$slotCH=0;$slotCM=0;$slotCL=0;$slotCR=0;$slotCS=0;
while($row_drp = mysql_fetch_assoc($res_drp)){
	//echo 'drp:'.$row_drp['item_id'].'qty:'.$row_drp['qty'].'slot:'.$row_drp['slot'].'<br />';
	if ($row_drp['slot']==1){
		$hs_drp=$hs_drp+$row_drp['qty'];
		for ($hdri=1; $hdri<=$row_drp['qty']; $hdri++){$slotHarr[]=$row_drp['item_id'];$slotCH++;}
	}
	if ($row_drp['slot']==2){
		$ms_drp=$ms_drp+$row_drp['qty'];
		for ($hdri=1; $hdri<=$row_drp['qty']; $hdri++){$slotMarr[]=$row_drp['item_id'];$slotCM++;}
	}
	if ($row_drp['slot']==3){
		$ls_drp=$ls_drp+$row_drp['qty'];
		for ($hdri=1; $hdri<=$row_drp['qty']; $hdri++){$slotLarr[]=$row_drp['item_id'];$slotCL++;}
	}
	if ($row_drp['slot']==5){
		$rs_drp=$rs_drp+$row_drp['qty'];
		for ($hdri=1; $hdri<=$row_drp['qty']; $hdri++){$slotRarr[]=$row_drp['item_id'];$slotCR++;}
	}
	if ($row_drp['slot']==7){
		$ss_drp=$ss_drp+$row_drp['qty'];
		for ($hdri=1; $hdri<=$row_drp['qty']; $hdri++){$slotSarr[]=$row_drp['item_id'];$slotCS++;}
	}
		//if ($row_drp['qty'] > 1) {echo'bana';}
	$i++;
}
//echo $hs_drp.'-'.$hs_dst.'<br />';
//echo'<br>'.$slotCM.'<br>';
//echo'<pre>';
//print_r($slotRarr);
//echo'</pre>';
//echo'<hr>';
while($row_dst = mysql_fetch_assoc($res_dst)){
	//echo 'dst:'.$row_dst['item_id'].'qty:'.$row_dst['qty'].'slot:'.$row_dst['slot'].'<br />';
	if ($row_dst['slot']==1){
		$hs_dst=$hs_dst+$row_dst['qty'];
		for ($hdri=1; $hdri<=$row_dst['qty']; $hdri++){$slotHarr[]=$row_dst['item_id'];$slotCH++;}
	}
	if ($row_dst['slot']==2){
		$ms_dst=$ms_dst+$row_dst['qty'];
		for ($hdri=1; $hdri<=$row_dst['qty']; $hdri++){$slotMarr[]=$row_dst['item_id'];$slotCM++;}
	}
	if ($row_dst['slot']==3){
		$ls_dst=$ls_dst+$row_dst['qty'];
		for ($hdri=1; $hdri<=$row_dst['qty']; $hdri++){$slotLarr[]=$row_dst['item_id'];$slotCL++;}
	}
	if ($row_dst['slot']==5){
		$rs_dst=$rs_dst+$row_dst['qty'];
		for ($hdri=1; $hdri<=$row_dst['qty']; $hdri++){$slotRarr[]=$row_dst['item_id'];$slotCR++;}
	}
	if ($row_dst['slot']==7){
		$ss_dst=$ss_dst+$row_dst['qty'];
		for ($hdri=1; $hdri<=$row_dst['qty']; $hdri++){$slotSarr[]=$row_dst['item_id'];$slotCS++;}
	}
	$i++;
}
//echo 'MS_DEST'.$ms_dst.'<br>';
//echo 'HS_DEST'.$hs_dst.'<br>';
//echo 'LS_DEST'.$ls_dst.'<br>';
//echo 'totMed'.$slotCH.'<br>';
/*
echo'<pre>';
print_r($slotHarr);
echo'</pre>';
*/
//echo $i;
//echo $hs_drp.'-'.$hs_dst.'<br />';

/*
$hslot=$hs_drp + $hs_dst;
$mslot=$ms_drp + $ms_dst;
$lslot=$ls_drp + $ls_dst;
$rslot=$rs_drp + $rs_dst;
$sslot=$ss_drp + $ss_dst;
*/


//echo	'<p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><p>&nbsp;</p><hr>';




//if (isset($slotMarr[4]

for ($i=0; $i<=7; $i++){
	if (isset($slotHarr[$i])){$fittHigh[$i]=ldimg($slotHarr[$i],'type');}else{$fittHigh[$i]='';}
	if (isset($slotMarr[$i])){$fittMed[$i]=ldimg($slotMarr[$i],'type');}else{$fittMed[$i]='';}
	if (isset($slotLarr[$i])){$fittLow[$i]=ldimg($slotLarr[$i],'type');}else{$fittLow[$i]='';}
	if (isset($slotRarr[$i])){$fittRig[$i]=ldimg($slotRarr[$i],'type');}else{$fittRig[$i]='';}
	if (isset($slotSarr[$i])){$fittSub[$i]=ldimg($slotSarr[$i],'type');}else{$fittSub[$i]='';}
}
/*
echo '<pre>';
print_r($fittRig);
echo '</pre>';
*/
}
//echo $fittMed[3];
if (isset($_GET['mode']) && $_GET['mode']=='kill') {
/*
$test = good_query_table("SELECT attribtypes.attributename, attrib.valueint, attrib.valuefloat FROM eve_db_dgmTypeAttributes AS attrib
INNER JOIN eve_db_invTypes AS TYPE ON attrib.typeID = type.typeID INNER JOIN eve_db_dgmAttributeTypes AS attribtypes ON attrib.attributeID = attribtypes.attributeID
WHERE attribtypes.attributename IN ('lowSlots', 'medSlots', 'hiSlots', 'rigSlots', 'maxSubSystems', 'lowSlotModifier', 'medSlotModifier', 'hiSlotModifier'
) AND type.typeID = ".$row['shipTypeID']." ");
*/

$tester = good_query_assoc("SELECT * FROM eve_db_invtypes WHERE typeID=".$row['shipTypeID']." AND groupID='963'");



if ($tester){
$t3_hi=0;
$t3_md=0;
$t3_lo=0;
foreach($slotSarr as $itum){
	$test = good_query_table("SELECT attribtypes.attributename, attrib.valueint, attrib.valuefloat FROM eve_db_dgmtypeattributes AS attrib
	INNER JOIN eve_db_invtypes AS type ON attrib.typeID = type.typeID INNER JOIN eve_db_dgmattributetypes AS attribtypes ON attrib.attributeID = attribtypes.attributeID
	WHERE attribtypes.attributename IN ('lowSlots', 'medSlots', 'hiSlots', 'rigSlots', 'maxSubSystems', 'lowSlotModifier', 'medSlotModifier', 'hiSlotModifier'
	) AND type.typeID = ".$itum." ");
	$t3_hi=$t3_hi+$test[0]['valuefloat'];
	$t3_md=$t3_md+$test[1]['valuefloat'];
	$t3_lo=$t3_lo+$test[2]['valuefloat'];
}
	$test = good_query_table("SELECT attribtypes.attributename, attrib.valueint, attrib.valuefloat FROM eve_db_dgmtypeattributes AS attrib
	INNER JOIN eve_db_invtypes AS type ON attrib.typeID = type.typeID INNER JOIN eve_db_dgmattributetypes AS attribtypes ON attrib.attributeID = attribtypes.attributeID
	WHERE attribtypes.attributename IN ('lowSlots', 'medSlots', 'hiSlots', 'rigSlots', 'maxSubSystems', 'lowSlotModifier', 'medSlotModifier', 'hiSlotModifier'
	) AND type.typeID = ".$row['shipTypeID']." ");
foreach($test as $sl){
	$get_slots[]=$sl;
}
		$hslot=$t3_hi;
		$mslot=$t3_md;
		$lslot=$t3_lo;
		$rslot=$get_slots[0]['valuefloat'];
		$sslot=$get_slots[1]['valuefloat'];
}else{
	$test = good_query_table("SELECT attribtypes.attributename, attrib.valueint, attrib.valuefloat FROM eve_db_dgmtypeattributes AS attrib
	INNER JOIN eve_db_invtypes AS type ON attrib.typeID = type.typeID INNER JOIN eve_db_dgmattributetypes AS attribtypes ON attrib.attributeID = attribtypes.attributeID
	WHERE attribtypes.attributename IN ('lowSlots', 'medSlots', 'hiSlots', 'rigSlots', 'maxSubSystems', 'lowSlotModifier', 'medSlotModifier', 'hiSlotModifier'
	) AND type.typeID = ".$row['shipTypeID']." ");
foreach($test as $sl){
	$get_slots[]=$sl;
}
if($get_slots[2]['valuefloat']){$hslot=$get_slots[2]['valuefloat'];}else{$hslot=$get_slots[2]['valueint'];}
if($get_slots[1]['valuefloat']){$mslot=$get_slots[1]['valuefloat'];}else{$mslot=$get_slots[1]['valueint'];}
if($get_slots[0]['valuefloat']){$lslot=$get_slots[0]['valuefloat'];}else{$lslot=$get_slots[0]['valueint'];}
if($get_slots[3]['valuefloat']){$rslot=$get_slots[3]['valuefloat'];}else{$rslot=$get_slots[3]['valueint'];}
		/*$hslot=$get_slots[2]['valuefloat'];
		$mslot=$get_slots[1]['valuefloat'];
		$lslot=$get_slots[0]['valuefloat'];
		$rslot=$get_slots[3]['valuefloat'];*/
		$sslot=0;

}

/*
echo '<pre>';
print_r($get_slots);
echo '</pre>';
echo $get_slots[0]['valuefloat'];
*/
/*
echo $get_slots[0]['valuefloat'];
0 = low
1 = med
2 = hi
3 = rig
4 =
*/
//echo $test['lowSlots'];
//$highSlot = good_query_assoc("SELECT entity.*, dgma.attributeName, dgma.displayName FROM eve_db_dgmtypeattributes as entity INNER JOIN eve_db_dgmattributetypes as dgma ON dgma.attributeID=entity.attributeID WHERE typeID=".$row['shipTypeID']." AND entity.attributeID=14");
//$mediumSlot = good_query_assoc("SELECT entity.*, dgma.attributeName, dgma.displayName FROM eve_db_dgmtypeattributes as entity INNER JOIN eve_db_dgmattributetypes as dgma ON dgma.attributeID=entity.attributeID WHERE typeID=".$row['shipTypeID']." AND entity.attributeID=13");
//$lowSlot = good_query_assoc("SELECT entity.*, dgma.attributeName, dgma.displayName FROM eve_db_dgmtypeattributes as entity INNER JOIN eve_db_dgmattributetypes as dgma ON dgma.attributeID=entity.attributeID WHERE typeID=".$row['shipTypeID']." AND entity.attributeID=12");
//echo $highSlot['valueInt'];
//echo $t3_hi;

echo wrt_table(0,0,0,'100%').'<tr><td align="left" class="left">
<div id="kl-detail-fitting">
	<div id="Fitting_Panel" style="position:relative; height:398px; width:398px;">
		<div id="mask" style="position:absolute; left:0px; top:0px; width:398px; height:398px; z-index:1;">
			<img style="position:absolute; height:398px; width:398px; border:0px" src="./img/panel/tyrannis.png" alt="" /></div>

		<div id="highx" style="position:absolute; left: 0px; top: 0px; width: 398px; height: 398px; z-index:1;">
			<img src="./img/panel/'.$hslot.'h.png" alt="" style="border:0px;" /></div>
		<div id="high1" style="position:absolute; left:73px; top:60px; width:32px; height:32px; z-index:2;">'.$fittHigh[0].'</div>
		<div id="high2" style="position:absolute; left:102px; top:42px; width:32px; height:32px; z-index:2;">'.$fittHigh[1].'</div>
		<div id="high3" style="position:absolute; left:134px; top:27px; width:32px; height:32px; z-index:2;">'.$fittHigh[2].'</div>
		<div id="high4" style="position:absolute; left:169px; top:21px; width:32px; height:32px; z-index:2;">'.$fittHigh[3].'</div>
		<div id="high5" style="position:absolute; left:203px; top:22px; width:32px; height:32px; z-index:2;">'.$fittHigh[4].'</div>
		<div id="high6" style="position:absolute; left:238px; top:30px; width:32px; height:32px; z-index:2;">'.$fittHigh[5].'</div>
		<div id="high7" style="position:absolute; left:270px; top:45px; width:32px; height:32px; z-index:2;">'.$fittHigh[6].'</div>
		<div id="high8" style="position:absolute; left:295px; top:64px; width:32px; height:32px; z-index:2;">'.$fittHigh[7].'</div>

		<div id="midx" style="position:absolute; left: 0px; top: 0px; width: 398px; height: 398px; z-index:1;">
			<img src="./img/panel/'.$mslot.'m.png" alt="" style="border:0px;" /></div>
		<div id="mid1" style="position:absolute; left:26px; top:140px; width:32px; height:32px; z-index:2;">'.$fittMed[0].'</div>
		<div id="mid2" style="position:absolute; left:24px; top:176px; width:32px; height:32px; z-index:2;">'.$fittMed[1].'</div>
		<div id="mid3" style="position:absolute; left:23px; top:212px; width:32px; height:32px; z-index:2;">'.$fittMed[2].'</div>
		<div id="mid4" style="position:absolute; left:30px; top:245px; width:32px; height:32px; z-index:2;">'.$fittMed[3].'</div>
		<div id="mid5" style="position:absolute; left:46px; top:278px; width:32px; height:32px; z-index:2;">'.$fittMed[4].'</div>
		<div id="mid6" style="position:absolute; left:69px; top:304px; width:32px; height:32px; z-index:2;">'.$fittMed[5].'</div>
		<div id="mid7" style="position:absolute; left:100px; top:328px; width:32px; height:32px; z-index:2;">'.$fittMed[6].'</div>
		<div id="mid8" style="position:absolute; left:133px; top:342px; width:32px; height:32px; z-index:2;">'.$fittMed[7].'</div>

		<div id="lowx" style="position:absolute; left: 0px; top: 0px; width: 398px; height: 398px; z-index:1;">
			<img src="./img/panel/'.$lslot.'l.png" alt="" style="border:0px;" /></div>
		<div id="low1" style="position:absolute; left:344px; top:143px; width:32px; height:32px; z-index:2;">'.$fittLow[0].'</div>
		<div id="low2" style="position:absolute; left:350px; top:178px; width:32px; height:32px; z-index:2;">'.$fittLow[1].'</div>
		<div id="low3" style="position:absolute; left:349px; top:213px; width:32px; height:32px; z-index:2;">'.$fittLow[2].'</div>
		<div id="low4" style="position:absolute; left:340px; top:246px; width:32px; height:32px; z-index:2;">'.$fittLow[3].'</div>
		<div id="low5" style="position:absolute; left:323px; top:277px; width:32px; height:32px; z-index:2;">'.$fittLow[4].'</div>
		<div id="low6" style="position:absolute; left:300px; top:304px; width:32px; height:32px; z-index:2;">'.$fittLow[5].'</div>
		<div id="low7" style="position:absolute; left:268px; top:324px; width:32px; height:32px; z-index:2;">'.$fittLow[6].'</div>
		<div id="low8" style="position:absolute; left:234px; top:338px; width:32px; height:32px; z-index:2;">'.$fittLow[7].'</div>

		<div id="rigxx" style="position:absolute; left: 0px; top: 0px; width: 398px; height: 398px; z-index:1;">
			<img src="./img/panel/'.$rslot.'r.png" alt="" style="border:0px;" /></div>
		<div id="rig1" style="position:absolute; left:148px; top:259px; width:32px; height:32px; z-index:2;">'.$fittRig[0].'</div>
		<div id="rig2" style="position:absolute; left:185px; top:267px; width:32px; height:32px; z-index:2;">'.$fittRig[1].'</div>
		<div id="rig3" style="position:absolute; left:221px; top:259px; width:32px; height:32px; z-index:2;">'.$fittRig[2].'</div>

		<div id="subx" style="position:absolute; left: 0px; top: 0px; width: 398px; height: 398px; z-index:1;">
			<img src="./img/panel/'.$sslot.'s.png" alt="" style="border:0px;" /></div>
		<div id="sub1" style="position:absolute; left:117px; top:131px; width:32px; height:32px; z-index:2;">'.$fittSub[0].'</div>
		<div id="sub2" style="position:absolute; left:147px; top:108px; width:32px; height:32px; z-index:2;">'.$fittSub[1].'</div>
		<div id="sub3" style="position:absolute; left:184px; top:98px; width:32px; height:32px; z-index:2;">'.$fittSub[2].'</div>
		<div id="sub4" style="position:absolute; left:221px; top:107px; width:32px; height:32px; z-index:2;">'.$fittSub[3].'</div>
		<div id="sub5" style="position:absolute; left:250px; top:131px; width:32px; height:32px; z-index:2;">'.$fittSub[4].'</div>
	<div id="bigship" style="position:absolute; left:72px; top:71px; width:256px; height:256px; z-index:0;"><img src="img/panel/noship.png" width="256" height="256" alt="" /></div>
	<div id="bigship" style="position:absolute; left:72px; top:71px; width:256px; height:256px; z-index:0;"><img src="http://image.eveonline.com/Render/'.$row['shipTypeID'].'_256.png" width="256" height="256" alt="" /></div>
	</div>
</div>
</td><td>
';
//}elseif (isset($_GET['mode']) && $_GET['mode']=='detail') {
//$wrt	=	'<table border="0" cellspacing="0" cellpadding="0" width="100%">';
$wrt	=	'<table border="0" cellspacing="0" cellpadding="0" width="100%">';
//$wrt	.=	'<tr>';
//$wrt	.=	'<td>asd</td>';
//$wrt	.=	'</tr>';

//$wrt	.=	$row['shipTypeID'];
for ($i=0; $i<=7; $i++){
	if (isset($slotHarr[$i])){$moduleHigh[$i]=$slotHarr[$i];}else{$moduleHigh[$i]='';}
	if (isset($slotMarr[$i])){$moduleMed[$i]=$slotMarr[$i];}else{$moduleMed[$i]='';}
	if (isset($slotLarr[$i])){$moduleLow[$i]=$slotLarr[$i];}else{$moduleLow[$i]='';}
	if (isset($slotRarr[$i])){$moduleRig[$i]=$slotRarr[$i];}else{$moduleRig[$i]='';}
	if (isset($slotSarr[$i])){$moduleSub[$i]=$slotSarr[$i];}else{$moduleSub[$i]='';}
}
$moduleHigh = array_count_values($moduleHigh);
	$wrt .= '<tr><th width="24" class="ft_head"><img width="24" src="./img/highslot.png"></th><th class="left ft_head font_m">High Slot</th><th class="left ft_head font_s">Qty</th></tr>';
	foreach ($moduleHigh as $item => $key){
		if (!empty($item)) {
		$item_name = good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID={$item}");
		if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
		$evenOdd = !$evenOdd;
		$wrt .= '<tr><td class="left tcell'.$odder.'">';
			$wrt .= ldimg($item,'type','','','32','24');
			$wrt .= '</td><td class="left tcell'.$odder.'">';
			$wrt .= $item_name['typeName'];
			$wrt .= '</td><td class="left tcell'.$odder.'">';
			$wrt .= $key;
		$wrt .= '</td></tr>';
		}
	}
	$wrt .= '<tr><th class="ft_head"><img width="24" src="./img/medslot.png"></th><th class="left ft_head font_m">Med Slot</th><th class="left ft_head font_s">Qty</th></tr>';
$moduleMed = array_count_values($moduleMed);
	foreach ($moduleMed as $item => $key){
	$item_name = good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID='".$item."'");
		if (!empty($item)) {
		if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
		$evenOdd = !$evenOdd;
		$wrt .= '<tr><td class="left tcell'.$odder.'">';
			$wrt .= ldimg($item,'type','','','32','24');
			$wrt .= '</td><td class="left tcell'.$odder.'">';
			$wrt .= $item_name['typeName'];
			$wrt .= '</td><td class="left tcell'.$odder.'">';
			$wrt .= $key;
		$wrt .= '</td></tr>';
		}
	}
$moduleLow = array_count_values($moduleLow);
	$wrt .= '<tr><th class="ft_head"><img width="24" src="./img/lowslot.png"></th><th class="left ft_head font_m">Low Slot</th><th class="left ft_head font_s">Qty</th></tr>';
	foreach ($moduleLow as $item => $key){
	$item_name = good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID='".$item."'");
		if (!empty($item)) {
		if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
		$evenOdd = !$evenOdd;
		$wrt .= '<tr><td class="left tcell'.$odder.'">';
			$wrt .= ldimg($item,'type','','','32','24');
			$wrt .= '</td><td class="left tcell'.$odder.'">';
			$wrt .= $item_name['typeName'];
			$wrt .= '</td><td class="left tcell'.$odder.'">';
			$wrt .= $key;
		$wrt .= '</td></tr>';
		}
	}
	if ($moduleRig[0]){
	$moduleRig = array_count_values($moduleRig);
		$wrt .= '<tr><th class="ft_head"><img width="24" src="./img/lowslot.png"></th><th class="left ft_head font_m">Rigs</th><th class="left ft_head font_s">Qty</th></tr>';
		foreach ($moduleRig as $item => $key){
		$item_name = good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID='".$item."'");
			if (!empty($item)) {
			if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
			$evenOdd = !$evenOdd;
			$wrt .= '<tr><td class="left tcell'.$odder.'">';
				$wrt .= ldimg($item,'type','','','32','24');
				$wrt .= '</td><td class="left tcell'.$odder.'">';
				$wrt .= $item_name['typeName'];
				$wrt .= '</td><td class="left tcell'.$odder.'">';
				$wrt .= $key;
			$wrt .= '</td></tr>';
			}
		}
	}
	if ($moduleSub[0]){
	$moduleSub = array_count_values($moduleSub);
		$wrt .= '<tr><th class="ft_head"><img width="24" src="./img/lowslot.png"></th><th class="left ft_head font_m">Subsystems</th><th class="left ft_head font_s">Qty</th></tr>';
		foreach ($moduleSub as $item => $key){
		$item_name = good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID='".$item."'");
			if (!empty($item)) {
			if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
			$evenOdd = !$evenOdd;
			$wrt .= '<tr><td class="left tcell'.$odder.'">';
				$wrt .= ldimg($item,'type','','','32','24');
				$wrt .= '</td><td class="left tcell'.$odder.'">';
				$wrt .= $item_name['typeName'];
				$wrt .= '</td><td class="left tcell'.$odder.'">';
				$wrt .= $key;
			$wrt .= '</td></tr>';
			}
		}
	}
$wrt	.=	'</table>';
$wrt	.=	'</td></tr>';
$wrt	.=	'<tr><td colspan="2" class="left"><span class="exp"><a href="#" onclick="CCPEVE.showFitting(\''.getDNA($row['killid']).'\');">Export Fitting</a></span></td></tr>';
$wrt	.=	'</table>';
echo	$wrt;
}elseif (isset($_GET['mode']) && $_GET['mode']=='attackers') {

	$perc = good_query_assoc("SELECT wpn_id,SUM(dmgdone) FROM kb_kill_attackers WHERE kill_id='".$id."'");
	$att = good_query_table("SELECT * FROM kb_kill_attackers WHERE kill_id='".$id."' ORDER BY dmgdone DESC");
		$wrt	=	'<table border="0" cellspacing="0" cellpadding="0" width="100%">';
		$wrt	.= '<tr><th class="left ft_head font_m">Ship</th><th class="left ft_head font_m">Attacker</th><th class="left ft_head font_m">Damage</th></tr>';
	foreach($att as $attacker){
	//$dmgDone = number_format((double)$value['damageDone']);
		if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
		$evenOdd = !$evenOdd;
		if ($attacker['fb']==true){$fb='_fb';}else{$fb='';}
		$wrt	.=	'<tr>';
		$wrt	.=	'<td class="left font_s tcell'.$odder.'">'.ldimg($attacker['ship'],'type','left','kb_border'.$fb.'','32').''.get_name($attacker['ship']).'<br />'.get_name($attacker['wpn_id']).'</td>';
		if (!empty($attacker['all_name'])){$alli='<a onclick="CCPEVE.showInfo(16159, '.$attacker['all_id'].')" href="#">'.$attacker['all_name'].'</a>';}else{$alli='';}
		$wrt	.=	'<td class="left font_s tcell'.$odder.'">'.ldimg($attacker['plt_id'],'char','left','kb_border'.$fb.'').'<a onclick="CCPEVE.showInfo(1377, '.$attacker['plt_id'].')" href="#">'.$attacker['plt_name'].'</a><br /><a onclick="CCPEVE.showInfo(2, '.$attacker['crp_id'].')" href="#">'.$attacker['crp_name'].'</a><br />'.$alli.'</td>';
		$wrt	.=	'<td class="left font_s tcell'.$odder.'">'.number_format((double)$attacker['dmgdone']).'<br />'.percent($attacker['dmgdone'],$perc['SUM(dmgdone)']).'%</td>';
		$wrt	.=	'</tr>';
	}
		$wrt	.=	'</table>';
	echo $wrt;
}


?>