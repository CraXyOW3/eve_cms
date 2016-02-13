<?php
//session_start();
if (isset($getHeaderTrusted)) {if ($getHeaderTrusted == 'No') {echo "no can do!";} else {if  ($getHeaderCorpID == $G_corpID) { // auth part
//pagetitle($G_siteTitle,"Corp Fittings");
?>
<script>
	$(function() {
		$( "input:submit, input:button").button();
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		$( "#accordion" ).accordion({
			autoHeight: false,
			icons: icons
		});
		$( "#toggle" ).button().toggle(function() {
			$( "#accordion" ).accordion( "option", "icons", false );
		}, function() {
			$( "#accordion" ).accordion( "option", "icons", icons );
		});
		$( "a", ".del").button({
            icons: {
                primary: "ui-icon-trash"
            },
            text: true
        });
		$( "a", ".edit").button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: true
        });
		$( "a", ".add").button({
            icons: {
                primary: "ui-icon-pencil"
            },
            text: true
        });
	});

	$(function() {
		$('a#opener').click(function(e) {
		e.preventDefault();
			$( "#dialog-confirm" ).dialog('option', 'anchor', $(this).attr('href'));
			$( "#dialog-confirm" ).dialog( "open" );
			return false;
		});
	
		$( "#dialog-confirm" ).dialog({
			autoOpen: false,
			resizable: false,
			height:180,
			modal: true,
			buttons: {
				"Delete": function(event) {
					$(location).attr('href',$(this).dialog('option', 'anchor'));
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
</script>


<?php
echo	'<div id="dialog-confirm" title="Delete a Fittings?">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This fitting will be permanently deleted and cannot be recovered. Are you sure?</p>
		</div>';
echo alert_check();

//station ID = 60002038
//corpid = 414596443

//$admin = true;

//check, if dna exists then list the category!

function fGetRole($string) {
	$sqlRole = mysql_query("SELECT * FROM fitt_dna_role WHERE id = $string") or die (mysql_error());
	$roleResult = mysql_fetch_array($sqlRole);
	return $roleResult['1'];
}
function fGetShip($string) {
	$sqlShipName = mysql_query("SELECT * FROM fitt_dna_ships WHERE tid = ".$string."") or die (mysql_error());
	$shipNameResult = mysql_fetch_row($sqlShipName);
	return $shipNameResult['3'];
}


if (!isset($_GET['s'])){
//echo 'not set then show';
//}


echo	'<table cellspacing="0" cellpadding="0" class="center" border="0" width="'.$tblWidth.'"><tr><td class="left"><div id="accordion" style="width:100%;">';

$shipClassQ = mysql_query("SELECT * FROM fitt_dna_cat ORDER BY cat_order"); // Ship Categories
while ($row = mysql_fetch_array($shipClassQ)) {


	if ($admin == true) { // ############################ ADMIN CHECK
			$colsp = '7';
		} else {
			$colsp = '6';
		}
//echo	'<tr><th colspan="'.$colsp.'" class="ft_head">'.$row['shipclass'].'</th></tr>';
echo	'<h3><a href="#">'.$row['shipclass'].'</a></h3><div>';
echo	'<table cellspacing="0" cellpadding="0" class="center" border="0" width="100%"><tr>
		<th class="ft_bod" width="100">Name</th>
		<th class="ft_bod" width="100">Ship</th>
		<th class="ft_bod" width="100">Role</th>
		<th class="ft_bod">Description</th>
		<th class="ft_bod" width="100">Posted</th>
		<th class="ft_bod" width="100">Author</th>';
	if ($admin == true) {echo '<th class="ft_bod">Actions</th>';} // ############################ ADMIN CHECK
echo	'</tr>';

if ($fittingType == '1') {
////////////////////// Loooping Ships Experiment Part! BOF
$shipHullQ = mysql_query("SELECT * FROM fitt_dna_hull WHERE hull_id = ".$row['hull_id']."");
while ($rowH = mysql_fetch_array($shipHullQ)) {
		$shipTypeQ = mysql_query("SELECT * FROM fitt_dna_ships WHERE gid = ".$rowH['grp_id']."");
			while ($row2 = mysql_fetch_array($shipTypeQ)) {
				$shipDNAQ = mysql_query("SELECT * FROM fitt_dna WHERE tid = ".$row2['tid']."");
					while ($row3 = mysql_fetch_array($shipDNAQ)) {
						if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
						$evenOdd = !$evenOdd;
						echo	'<tr>
								<td class="tleft tcell'.$odder.'"><a href="#" onclick="CCPEVE.showFitting(\''.$row3['fitting'].'\')">'.$row3['fittName'].'</a></td>
								<td class="tleft tcell'.$odder.'"><img align="left" src="http://image.eveonline.com/Render/' . $row3['tid'] . '_32.png" size="64">'. fGetShip($row3['tid']) .'</td>
								<td class="tleft tcell'.$odder.'">'. fGetRole($row3['role']) . '</td>
								<td class="tleft tcell'.$odder.'">'.$row3['description'].'</td>
								<td class="tleft tcell'.$odder.'">'.date('Y-m-d', strtotime($row3['age'])).'</td>
								<td class="tleft tcell'.$odder.'">'.$row3['author'].'</td>';
							//if ($admin == true) {echo '<td class="tleft"><a href="./?p=fittings&s=edit&id='.$row3['id'].'#fitt"><img src="database_edit.png" class="nob"></a><a href="./?p=fitting_data&s=delete&id='.$row3['id'].'"><img src="database_delete.png" class="nob"></a></th>';} // ############################ ADMIN CHECK
							if ($admin == true) {echo '<td class="tleft tcell'.$odder.'" width="120"><span class="edit"><a href="./?p=fitting_manage&s=edit&id='.$row3['id'].'">edit</a></span>&nbsp;<span class="del"><a id="opener" href="./?p=data&mode=fittings&s=delete&id='.$row3['id'].'">delete</a></span></th>';} // ############################ ADMIN CHECK
						echo	'</tr>';
					}
			}
}
////////////////////// Loooping Ships Experiment Part! EOF
}
//echo	'<tr><td colspan="6">&nbsp;</td></tr>';
echo	'</table></div>';
}

echo	'</div></td></tr></table><br />';
}








echo	'<br /><br /><br />
		Go and friggin download the pwnage fitter <a href="http://www.evefit.org/Pyfa">Pyfa</a>!!!!! ZOMG of ODOM!<br />(it handles export of ship DNA, wich EVE Online uses!)<br />';
}}}
?>