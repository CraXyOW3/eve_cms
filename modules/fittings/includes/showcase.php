<?php
include('../../../config.php');
include('../../../includes/functions.php');
include('../../../includes/database.php');
//sleep(3);
if (isset($_GET['group'])){
$groupID = mysql_real_escape_string($_GET['group']);
$evenOdd = true;
$wrt	=	'<table cellspacing="0" cellpadding="0" class="center" border="0" width="100%"><tr>';
$wrt	.=	'<th class="ft_bod" width="100">Name</th>';
$wrt	.=	'<th class="ft_bod" width="100">Ship</th>';
$wrt	.=	'<th class="ft_bod" width="100">Role</th>';
$wrt	.=	'<th class="ft_bod">Description</th>';
$wrt	.=	'<th class="ft_bod" width="100">Posted</th>';
$wrt	.=	'<th class="ft_bod" width="100">Author</th>';
$wrt	.=	'</tr>';
$shipHullQ = good_query_table("SELECT * FROM fitt_dna_hull WHERE hull_id = ".$groupID."");
foreach ($shipHullQ as $rowH) {
		$shipTypeQ = good_query_table("SELECT * FROM fitt_dna_ships WHERE gid = ".$rowH['grp_id']."");
			foreach ($shipTypeQ as $row2) {
				//$shipDNAQ = mysql_query("SELECT * FROM fitt_dna WHERE tid = ".$row2['tid']."");
				$shipDNAQ = good_query_table("SELECT * FROM fitt_dna WHERE tid = ".$row2['tid']."");
					//while ($row3 = mysql_fetch_array($shipDNAQ)) {
					foreach ($shipDNAQ as $row3) {
						if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
						$evenOdd = !$evenOdd;
						$wrt	.=	'<tr>';
						$wrt	.=	'	<td class="tleft tcell'.$odder.'"><a href="#" onclick="CCPEVE.showFitting(\''.$row3['fitting'].'\')">'.$row3['fittName'].'</a></td>';
						$wrt	.=	'		<td class="tleft tcell'.$odder.'"><img align="left" src="http://image.eveonline.com/Render/' . $row3['tid'] . '_32.png" size="64">'. fGetShip($row3['tid']) .'</td>';
						$wrt	.=	'		<td class="tleft tcell'.$odder.'">'. fGetRole($row3['role']) . '</td>';
						$wrt	.=	'		<td class="tleft tcell'.$odder.'">'.$row3['description'].'</td>';
						$wrt	.=	'		<td class="tleft tcell'.$odder.'">'.date('Y-m-d', strtotime($row3['age'])).'</td>';
						$wrt	.=	'		<td class="tleft tcell'.$odder.'">'.$row3['author'].'</td>';
							//if ($admin == true) {echo '<td class="tleft"><a href="./?p=fittings&s=edit&id='.$row3['id'].'#fitt"><img src="database_edit.png" class="nob"></a><a href="./?p=fitting_data&s=delete&id='.$row3['id'].'"><img src="database_delete.png" class="nob"></a></th>';} // ############################ ADMIN CHECK
							//if ($admin == true) {echo '<td class="tleft tcell'.$odder.'" width="120"><span class="edit"><a href="./?p=fitting_manage&s=edit&id='.$row3['id'].'">edit</a></span>&nbsp;<span class="del"><a id="opener" href="./?p=data&mode=fittings&s=delete&id='.$row3['id'].'">delete</a></span></th>';} // ############################ ADMIN CHECK
						$wrt	.=	'</tr>';
					}
			}
}
$wrt	.=	'</table></div>';
echo $wrt;
}
?>