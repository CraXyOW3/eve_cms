<?php
//include('../_cfg.php');
//include('../_vars.php');
function sum_array($array){
	foreach ($array AS $key)
	{
		if (!isset($ret[$key['item_id']]))
			$ret[$key['item_id']] = 0;
		
		$ret[$key['item_id']] += $key['qty'];
	}
	return $ret;
}
function getDNA($kill_id){

//$killid='20469491'; //miner
//$kill_id='20469506'; //hauler
/*
if (isset($_GET['id'])){
	$kill_id=$_GET['id'];
}else{$kill_id='20469506';}
*/
/*
$killer1 = good_query_table("SELECT kb_kill.shipTypeID as ship,kb_items_destr.item_id as itemds,kb_items_destr.qty as qtyds,kb_items_destr.slot FROM
kb_kill
LEFT JOIN kb_items_destr ON kb_kill.killid=kb_items_destr.kill_id
LEFT JOIN kb_items_drop ON kb_kill.killid=kb_items_drop.kill_id
WHERE killid=17492613 AND kb_items_destr.flag=0 and kb_items_destr.flag=0");

$killer = good_query_table("
SELECT kill_id,item_id,qty,slot FROM kb_items_destr
WHERE kill_id=17492613 AND flag=0 AND slot IN ('1','2','3','5','6','7')
UNION
SELECT kill_id,item_id,qty,slot FROM kb_items_drop
WHERE kill_id=17492613 AND flag=0 AND slot IN ('1','2','3','5','6','7')
");
*/
$dna_high = good_query_table("SELECT item_id,qty FROM kb_items_destr WHERE kill_id=".$kill_id." AND flag=0 AND slot=1 UNION SELECT item_id,qty FROM kb_items_drop WHERE kill_id=".$kill_id." AND flag=0 AND slot=1");
$dna_medium = good_query_table("SELECT item_id,qty FROM kb_items_destr WHERE kill_id=".$kill_id." AND flag=0 AND slot=2 UNION SELECT item_id,qty FROM kb_items_drop WHERE kill_id=".$kill_id." AND flag=0 AND slot=2");
$dna_low = good_query_table("SELECT item_id,qty FROM kb_items_destr WHERE kill_id=".$kill_id." AND flag=0 AND slot=3 UNION SELECT item_id,qty FROM kb_items_drop WHERE kill_id=".$kill_id." AND flag=0 AND slot=3");
$dna_rig = good_query_table("SELECT item_id,qty FROM kb_items_destr WHERE kill_id=".$kill_id." AND flag=0 AND slot=5 UNION SELECT item_id,qty FROM kb_items_drop WHERE kill_id=".$kill_id." AND flag=0 AND slot=5");
$dna_sub = good_query_table("SELECT item_id,qty FROM kb_items_destr WHERE kill_id=".$kill_id." AND flag=0 AND slot=7 UNION SELECT item_id,qty FROM kb_items_drop WHERE kill_id=".$kill_id." AND flag=0 AND slot=7");


$ship = good_query_assoc("SELECT shipTypeID FROM kb_kill WHERE killid=".$kill_id."");
/*
echo'<pre>';
//print_r($killer);
echo '<hr>';
//print_r($dna_high);
echo '<hr>';
//print_r(array_count_values($dna_high));
echo '<hr>high';
print_r(sum_array($dna_high));
echo '<hr>med';
print_r(sum_array($dna_medium));
echo '<hr>low';
print_r(sum_array($dna_low));
echo '<hr>rig';
print_r(sum_array($dna_rig));
echo '<hr>sub';
print_r(sum_array($dna_sub));
echo'</pre>';
//$dna_string='';
*/
$dna_string=$ship['shipTypeID'];
//echo $ship['shipTypeID'];
foreach ($dna_sub as $item){
	$dna_string .= ':'.$item['item_id'] .';'.$item['qty'];
}
foreach ($dna_rig as $item){
	$dna_string .= ':'.$item['item_id'] .';'.$item['qty'];
}
foreach ($dna_low as $item){
	$dna_string .= ':'.$item['item_id'] .';'.$item['qty'];
}
foreach ($dna_medium as $item){
	$dna_string .= ':'.$item['item_id'] .';'.$item['qty'];
}
foreach ($dna_high as $item){
	$dna_string .= ':'.$item['item_id'] .';'.$item['qty'];
}
$dna_string .= '::';


/*
echo'<hr>';
echo $dna_string;
echo'<hr>';
echo "<a href=\"javascript:CCPEVE.showFitting('".$dna_string."');\"'>Show Fitting</a>";
*/
/*
//echo	'<a href="?id=20469506">hauler</a> <a href="?id=20469491">miner</a> <a href="?id=20185622">apoc</a> <a href="?id=18128798">vexor</a><hr>';
$hs_drp=0;$ms_drp=0;$ls_drp=0;$rs_drp=0;$ss_drp=0;$hs_dst=0;$ms_dst=0;$ls_dst=0;$rs_dst=0;$ss_dst=0;
$slotCH=0;$slotCM=0;$slotCL=0;$slotCR=0;$slotCS=0;
$i=0;

$tstdrop = good_query_table("SELECT kb_kill.shipTypeID as ship,kb_items_drop.item_id as itemdr,kb_items_drop.qty as qtydr,kb_items_drop.slot FROM kb_kill LEFT JOIN kb_items_drop ON kb_kill.killid=kb_items_drop.kill_id WHERE killid=".$kill_id." AND flag=0");
$tstdestr = good_query_table("SELECT kb_kill.shipTypeID as ship,kb_items_destr.item_id as itemds,kb_items_destr.qty as qtyds,kb_items_destr.slot FROM kb_kill LEFT JOIN kb_items_destr ON kb_kill.killid=kb_items_destr.kill_id WHERE killid=".$kill_id." AND flag=0");
//$sql_drp = "SELECT * FROM kb_items_drop where kill_id=".$id." AND flag=0 ORDER BY slot ASC";
//$sql_dst = "SELECT * FROM kb_items_destr where kill_id=".$id." AND flag=0 ORDER BY SLOT ASC";
$ship = good_query_assoc("SELECT shipTypeID FROM kb_kill WHERE killid=".$kill_id."");
//echo '<br><b>'.$slotCH.'</b><br>';
foreach ($tstdrop as $item){
	//echo 'item '.$item['itemdr'] . ' qty' . $item['qtydr'].' slot'.$item['slot'].'<br />';
	if ($item['slot']==1){
		//$hs_drp=$hs_drp+$item['qtydr'];
		$slotHarr[$slotCH][0]=$item['itemdr'];
		$slotHarr[$slotCH][1]=$item['qtydr'];
		$slotCH++;
	}
	if ($item['slot']==2){
		//$ms_drp=$ms_drp+$item['qtydr'];
		$slotMarr[$slotCM][0]=$item['itemdr'];
		$slotMarr[$slotCM][1]=$item['qtydr'];
		$slotCM++;
	}
	if ($item['slot']==3){
		//$ls_drp=$ls_drp+$item['qtydr'];
		$slotLarr[$slotCL][0]=$item['itemdr'];
		$slotLarr[$slotCL][1]=$item['qtydr'];
		$slotCL++;
	}
	if ($item['slot']==5){
		//$rs_drp=$rs_drp+$item['qtydr'];
		$slotRarr[$slotCR][0]=$item['itemdr'];
		$slotRarr[$slotCR][1]=$item['qtydr'];
		$slotCR++;
	}
	if ($item['slot']==7){
		//$ss_drp=$ss_drp+$item['qtydr'];
		$slotSarr[$slotCS][0]=$item['itemdr'];
		$slotSarr[$slotCS][1]=$item['qtydr'];
		$slotCS++;
	}
		//if ($item['qtydr'] > 1) {echo'bana';}
	$i++;
}
*/
/*
echo'<pre>high';
print_r($slotHarr);
echo'med';
print_r($slotMarr);
echo'low';
print_r($slotLarr);
echo'</pre>';
echo '<br><b>'.$slotCH.'</b><br>';
*/
/*
$slotCH=0;$slotCM=0;$slotCL=0;$slotCR=0;$slotCS=0;
//echo	'<hr>';
foreach ($tstdestr as $item){
	//echo '<br />item '.$item['itemds'] . ' qty' . $item['qtyds'].' slot'.$item['slot'].'';
	if ($item['slot']==1){
		//$hs_drp=$hs_drp+$item['qtyds'];
		//$slotHarr[$slotCH][0]=$item['itemds'];
		//$slotHarr[$slotCH][1]=$item['qtyds'];
		//echo $slotHarr[0][0].'-'.$slotCH;
		if (isset($slotHarr[$slotCH])){
		//if (!empty($slotHarr[$slotCH])){$slotCH++;}
			if ($slotHarr[$slotCH][0]==$item['itemds']){
			//echo' if duplicate ';
				$slotHarr[$slotCH][1] += $item['qtyds'];
			}elseif ($slotHarr[$slotCH][1]>0){
			//}else{
			//echo' if cnt ';
			if (!empty($slotHarr[$slotCH])){
				//echo' hehe ';
				$slotCH++;
				}
				$slotHarr[$slotCH][0]=$item['itemds'];
				$slotHarr[$slotCH][1]=$item['qtyds'];
			}
		}else{
		//echo' else ';
			$slotMarr[$slotCH][0]=$item['itemds'];
			$slotMarr[$slotCH][1]=$item['qtyds'];
		}
		$slotCH++;
	}
	if ($item['slot']==2){
		//$ms_drp=$ms_drp+$item['qtyds'];
		if (isset($slotMarr[$slotCM])){
			if ($slotMarr[$slotCM][0]==$item['itemds']){
				$slotMarr[$slotCM][1] += $item['qtyds'];
			}elseif ($slotMarr[$slotCM][1]>1){
				$slotMarr[$slotCM][0]=$item['itemds'];
				$slotMarr[$slotCM][1]=$item['qtyds'];
			}
		}else{
			$slotMarr[$slotCM][0]=$item['itemds'];
			$slotMarr[$slotCM][1]=$item['qtyds'];
		}
		$slotCM++;
	}
	if ($item['slot']==3){
		//$ls_drp=$ls_drp+$item['qtyds'];
		if (isset($slotLarr[$slotCL])){
			if ($slotLarr[$slotCL][0]==$item['itemds']){
				$slotLarr[$slotCL][1] += $item['qtyds'];
			}elseif ($slotLarr[$slotCL][1]>1){
				$slotLarr[$slotCL][0]=$item['itemds'];
				$slotLarr[$slotCL][1]=$item['qtyds'];
			}
		}else{
			$slotLarr[$slotCL][0]=$item['itemds'];
			$slotLarr[$slotCL][1]=$item['qtyds'];
		}
		$slotCL++;
	}
	if ($item['slot']==5){
		//$rs_drp=$rs_drp+$item['qtyds'];
		if (isset($slotRarr[$slotCR])){
			if ($slotRarr[$slotCR][0]==$item['itemds']){
				$slotRarr[$slotCR][1] += $item['qtyds'];
			}elseif ($slotRarr[$slotCR][1]>1){
				$slotRarr[$slotCR][0]=$item['itemds'];
				$slotRarr[$slotCR][1]=$item['qtyds'];
			}
		}else{
			$slotLarr[$slotCR][0]=$item['itemds'];
			$slotLarr[$slotCR][1]=$item['qtyds'];
		}
		$slotCR++;
	}
	if ($item['slot']==7){
		//$ss_drp=$ss_drp+$item['qtyds'];
		if (isset($slotSarr[$slotCS])){
			if ($slotLarr[$slotCS][0]==$item['itemds']){
				$slotLarr[$slotCS][1] += $item['qtyds'];
			}elseif ($slotSarr[$slotCS][1]>1){
				$slotSarr[$slotCS][0]=$item['itemds'];
				$slotSarr[$slotCS][1]=$item['qtyds'];
			}
		}else{
			$slotLarr[$slotCS][0]=$item['itemds'];
			$slotLarr[$slotCS][1]=$item['qtyds'];
		}
		$slotCS++;
	}
		//if ($item['qtydr'] > 1) {echo'bana';}
	$i++;
}
*/
/*
echo '<br><b>'.$slotCH.'</b><br>';
echo'<pre>high';
print_r($slotHarr);
echo'med';
print_r($slotMarr);
echo'low';
print_r($slotLarr);
echo'rig';
print_r($slotRarr);
echo'sub';
print_r($slotSarr);
echo'</pre>';
*/
/*
$dna = $ship['shipTypeID'].':';
//echo $ship['shipTypeID'].':';

for ($i=0; $i<=7; $i++){
	if (isset($slotSarr[$i])){
		echo $slotSarr[$i][0].';';//echo'<br />';
		echo $slotSarr[$i][1].':';
		$dna .= $slotSarr[$i][0].';';
		$dna .= $slotSarr[$i][1].':';
	}else{
		//echo':';$dna .= ':';}
		//echo'';$dna .= '';
		$dna .= '';
		}
	if (isset($slotRarr[$i])){
		//echo $slotRarr[$i][0].';';
		//echo $slotRarr[$i][1].':';
		$dna .= $slotRarr[$i][0].';';
		$dna .= $slotRarr[$i][1].':';
	}else{
		//echo':';$dna .= ':';}
		//echo'';$dna .= '';
		$dna .= '';
		}

	if (isset($slotLarr[$i])){
		//echo $slotLarr[$i][0].';';
		//echo $slotLarr[$i][1].':';
		$dna .= $slotLarr[$i][0].';';
		$dna .= $slotLarr[$i][1].':';
	}else{
		//echo':';$dna .= ':';}
		//echo'';$dna .= '';
		$dna .= '';
		}
	if (isset($slotMarr[$i])){
		//echo $slotMarr[$i][0].';';
		//echo $slotMarr[$i][1].':';
		$dna .= $slotMarr[$i][0].';';
		$dna .= $slotMarr[$i][1].':';
	}else{
		//echo':';$dna .= ':';}
		//echo'';$dna .= '';
		$dna .= '';
		}
	if (isset($slotHarr[$i])){
		//echo $slotHarr[$i][0].';';
		//echo $slotHarr[$i][1].':';
		$dna .= $slotHarr[$i][0].';';
		$dna .= $slotHarr[$i][1].':';
	}else{
		//echo':';$dna .= ':';}
		//echo'';$dna .= '';
		$dna .= '';
		}
$dna .= ':';
}
*/
/*
echo '<hr>'.$dna,'<hr>642:519;4:6328;2:1353;1:6158;3:6175;1:9497;8:: //APOC<hr>';
echo '626:11269;2:2048;1:3530;1:2032;2:12058;1:12346;3:25861;1:24348;1:: //Vexor<hr>';
echo 'a dynamic dna link test! -><a href="javascript:CCPEVE.showFitting(\''.$dna.':\');">show</a><hr>';
echo 'a fixed dna link test! -><a href="javascript:CCPEVE.showFitting(\'597:25861;1:6673;3:439;1:4025;1:1183;1:1998;1:1236;1:11269;1::\');">show</a>';
*/
/*
SELECT 
kb_kill.shipTypeID as ship,
kb_items_drop.item_id as itemdr,
kb_items_drop.qty as qtydr

FROM kb_kill
    LEFT JOIN kb_items_drop ON
      kb_kill.killid=kb_items_drop.kill_id
WHERE killid=20469491
*/
//echo $dna;
//return $dna;
return $dna_string;
}
?>