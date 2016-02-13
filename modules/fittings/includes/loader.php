<?php
include('../../../config.php');
include('../../../includes/functions.php');
include('../../../includes/database.php');
//sleep(1);
$evenOdd=null;
if (isset($_GET['part'])){
	$wrt	=	'
<script>
	$(function() {
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
		$(\'a#opener\').click(function(e) {
		e.preventDefault();
			$( "#dialog-confirm" ).dialog(\'option\', \'anchor\', $(this).attr(\'href\'));
			$( "#dialog-confirm" ).dialog( "open" );
			return false;
		});
</script>
';
	$wrt	.=	wrt_table(0,0,0,'100%','center');
	$wrt	.=	'<tr><th class="ft_bod">Name</th><th class="ft_bod">Ship</th><th class="ft_bod">Role</th><th class="ft_bod">Description</th><th class="ft_bod">Posted</th><th class="ft_bod">Author</th><th class="ft_bod">Actions</th></tr>';
	$listHull = good_query_table("SELECT * FROM fitt_dna_hull WHERE hull_id = ".$_GET['part']."");
	foreach($listHull as $rowH){
		$shipTypeQ = good_query_table("SELECT * FROM fitt_dna_ships WHERE gid = ".$rowH['grp_id']."");
			foreach($shipTypeQ as $rowS){
				$shipDNAQ = good_query_table("SELECT * FROM fitt_dna WHERE tid = ".$rowS['tid']."");
					foreach($shipDNAQ as $rowD){
						if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
						$evenOdd = !$evenOdd;
					$wrt	.=	'<tr>';
					$wrt	.=	'<td class="tcell'.$odder.'">'.$rowD['fittName'].'</td>';
					$wrt	.=	'<td class="tcell'.$odder.'"><img align="left" src="http://image.eveonline.com/Render/' . $rowD['tid'] . '_32.png" size="64">'.fGetShip($rowD['tid']).'</td>';
					$wrt	.=	'<td class="tcell'.$odder.'">'.fGetRole($rowD['role']).'</td>';
					$wrt	.=	'<td class="tcell'.$odder.'">'.$rowD['description'].'</td>';
					$wrt	.=	'<td class="tcell'.$odder.'">'.date('Y-m-d', strtotime($rowD['age'])).'</td>';
					$wrt	.=	'<td class="tcell'.$odder.'">'.$rowD['author'].'</td>';
					$wrt	.=	'<td class="tleft tcell'.$odder.'" width="120"><span class="edit"><a href="./?module=admin&part=fittings&a=edit&id='.$rowD['id'].'">edit</a></span>&nbsp;<span class="del"><a id="opener" href="./?module=data&part=fittings&s=delete&id='.$rowD['id'].'">delete</a></span></th>';
					$wrt	.=	'</tr>';
					}
			}
		$wrt	.=	'';
		$wrt	.=	'';
		$wrt	.=	'';
		$wrt	.=	'';
	}
	$wrt	.=	'</table>';
	echo $wrt;
}

?>