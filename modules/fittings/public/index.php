<?php
$mode = 'tabs'; // accordion or tab

if ($mode=='accordion'){
$wrt	=	'
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
	});
</script>
';


$wrt	.=	'<table cellspacing="0" cellpadding="0" class="center" border="0" width="'.$tblWidth.'">';
$wrt	.=	'<tr><td class="left"><div id="accordion" style="width:100%;">';

$shipClassQ = mysql_query("SELECT * FROM fitt_dna_cat ORDER BY cat_order"); // Ship Categories
while ($row = mysql_fetch_array($shipClassQ)) {


$wrt	.=	'<h3><a href="#">'.$row['shipclass'].'</a></h3><div>';
$wrt	.=	'<table cellspacing="0" cellpadding="0" class="center" border="0" width="100%"><tr>';
$wrt	.=	'<th class="ft_bod" width="100">Name</th>';
$wrt	.=	'<th class="ft_bod" width="100">Ship</th>';
$wrt	.=	'<th class="ft_bod" width="100">Role</th>';
$wrt	.=	'<th class="ft_bod">Description</th>';
$wrt	.=	'<th class="ft_bod" width="100">Posted</th>';
$wrt	.=	'<th class="ft_bod" width="100">Author</th>';
$wrt	.=	'</tr>';


$shipHullQ = good_query_table("SELECT * FROM fitt_dna_hull WHERE hull_id = ".$row['hull_id']."");
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
}
$wrt	.=	'</div></td></tr></table><br />';

echo $wrt;
}




if ($mode=='tabs'){
$wrt	=	'
	<script>
	$(function() {
		$( "#tabs" ).tabs({
		cache:true,
			ajaxOptions: {
				beforeSend: function() {
					$(\'#loading\').show()
				},
				complete: function(){
					$(\'#loading\').hide()
				},
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn\'t load this tab. We\'ll try to fix this as soon as possible. ");
				}
			}
		});



	});
	</script>';
/*
    $("#tabs").tabs({
      spinner: "",
      select: function(event, ui) {
        var tabID = "#ui-tabs-" + (ui.index + 1);
        $(tabID).html("<p align=\"center\"><img src=\"./img/39.gif\"></p>");
      }
    });

$(".tabs").tabs({
   cache:true,
   load: function (e, ui) {
     $(ui.panel).find(".tab-loading").remove();
   },
   select: function (e, ui) {
     var $panel = $(ui.panel);

     if ($panel.is(":empty")) {
         $panel.append("<div class='tab-loading'>Loading...</div>")
     }
    }
 })





*/

$wrt	.=	wrt_table(0,0,0,$tblWidth,'center');
$wrt	.=	'<tr><td>';

$shipGroup = good_query_table("SELECT * FROM fitt_dna_cat ORDER BY cat_order"); // Ship Categories
$wrt	.=	'<div id="tabs">';
$wrt	.=	'<ul>';
foreach($shipGroup as $row){
	//$wrt	.=	'<li><a href="./includes/fittings/showcase.php?group='.$row['id'].'">'.$row['shipclass'].'</a></li>';
	$wrt	.=	'<li><a href="'.$module_dir.$self.'/includes/showcase.php?group='.$row['hull_id'].'">'.$row['shipclass'].'</a></li>';
}
$wrt	.=	'</ul>';
$wrt	.=	'';
$wrt	.=	'<div id="tabs-1">';
//$wrt	.=	'<p><div id="loading"><p align="center"><img src="./img/ajax_preloader.gif" /> Please Wait</p></div>';
$wrt	.=	'<p><div id="loading"><p align="center">';
//$wrt	.=	'<img src="./img/ajax_preloader.gif" />';
//$wrt	.=	'<img src="./img/38.gif" />';
$wrt	.=	'<img src="./img/ghooloader2.gif" />';
//$wrt	.=	'<img src="./img/40.gif" />';
//$wrt	.=	'<img src="./img/41.gif" />';
$wrt	.=	'</p></div>';
$wrt	.=	'</div>';
$wrt	.=	'';
$wrt	.=	'</div>';

//$wrt	.=	'<div id="tabs-1"><div id="loading"><p><img src="./img/eveload.gif" /> Please Wait</p></div></div>';
$wrt	.=	'</td></tr></table>';


echo $wrt;
}




?>