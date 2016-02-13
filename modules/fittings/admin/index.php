<?php
include('modules/fittings/config.php');
if (!isset($_GET['a'])){
$wrt	=	'
<script type="text/javascript">
function loadContent(id) {
  $(\'#contentArea\').load("./includes/fittings/loader.php?part="+id+"");
}
function jaquest(id) {
  $(\'#placeholder\').html(\'<p class="loader"><img src="./img/ghooloader2.gif" /></p>\');
  $(\'#placeholder\').load("'.$module_dir.'/fittings/includes/loader.php?part="+id+"");
}
$(function() {
	$( ".btn" ).button();
});
</script>
<script type="text/javascript">
	$(function() {
		$( "#dialog-confirm" ).dialog({
			autoOpen: false,
			resizable: false,
			height:180,
			modal: true,
			buttons: {
				"Delete": function(event) {
					$(location).attr(\'href\',$(this).dialog(\'option\', \'anchor\'));
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
</script>
';


$wrt	.=	'<div id="dialog-confirm" title="Delete a Fitt?">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This fitt will be permantently deleted from library!<br>Proceed?</p>
		</div>';
$wrt	.=	wrt_table(0,0,0,$tblWidth,'center');
$wrt	.=	'<tr><th class="ft_head" width="140">Class</th><th class="ft_head">Content</th></tr>';
$shipHulls = good_query_table("SELECT * FROM fitt_dna_cat ORDER BY cat_order ASC");
$wrt	.=	'<tr><td class="left"><ul id="btnlist">';
foreach($shipHulls as $row){
	$wrt	.=	'<li><a class="btn" href="javascript:jaquest('.$row['hull_id'].')">'.$row['shipclass'].'</a></li>';
}
$wrt	.=	'<li>&nbsp;</li>';
$wrt	.=	'<li>&nbsp;</li>';
$wrt	.=	'<li><a class="btn ld" href="'.$module_admin.'&a=add">Add Fitt</a></li>';
$wrt	.=	'</ul></td><td valign="top">';
$wrt	.=	'';
$wrt	.=	'<div id="placeholder"></div>';
$wrt	.=	'';
$wrt	.=	'</td></tr>';
$wrt	.=	'';
$wrt	.=	'</table>';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';

$wrt	.=	'<div id="contentArea" style="margin: 20px 0px 10px 10px;">
				&nbsp;
			</div>';

}elseif($_GET['a']=='add'){
$wrt	=	'
<script>
	$(function() {
		$( "input:submit, input:button").button();
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		$( "button#insert").button({
            icons: {
                primary: "ui-icon-disk"
            },
            text: true
		}).click(function () {$(\'#loadingpage\').fadeIn()});;
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
$(\'#inp *\').tooltip();
$("select").tooltip({
	left: 25
});
	});
</script>
';
$wrt	.=	'<form action="./?module=data&part=fittings&s=post" method="post" id="addform">';
$wrt	.=	'<table class="center" width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th class="ft_head" colspan="6"><a name="fitt">Fitting Input Field</a></th>
			</tr>
			<tr>
				<th class="ft_bod">Name</th>
				<th class="ft_bod">DNA</th>
				<th class="ft_bod">Role</th>
			</tr>
			<tr>
				<td class="tleft" width="100"><span id="inp"><input title="The name of the fitting you are posting!<br>i.e Passive Cane" class="inp" type="text" name="fname" size="20"></span></td>
				<td class="tleft" width="380"><span id="inp"><input title="The DNA string that can be exported with PyFa!" class="inp" type="text" name="dna" size="80"></span></td>
				<td class="tleft" width="100"><select title="Select the appropriate Role to this fitt!" class="inp" name="role">';
			$roleQ = mysql_query("SELECT * FROM fitt_dna_role");
			while ($rowRQ = mysql_fetch_array($roleQ)) {
				$wrt	.=	'<option value="'.$rowRQ['id'].'">' . $rowRQ['rolename'] . '</option>';
			}
$wrt	.=	'	</select></td>
			</tr><tr><th class="ft_bod" colspan="3">Description</th></tr><tr>
				<td class="tleft"><span id="inp"><textarea title="A small description if the fitt!" class="inp" name="description" rows="4" cols="50"></textarea></span></td>
				<td class="tleft" colspan="2"><button id="insert">Save Fitting</button></td>
			</tr>
			</table>
			<input type="hidden" name="author" value="'.$_SERVER['HTTP_EVE_CHARNAME'].'" />';
$wrt	.=	'</form>';
}elseif($_GET['a']=='edit'){
	$dnaQedit = mysql_query("SELECT * FROM fitt_dna WHERE id = ".$_GET['id']."");
	while ($rowEdit = mysql_fetch_array($dnaQedit)) {
$wrt	=	'<form action="./?module=data&part=fittings&s=update" method="post">';
$wrt	.=	'<table class="center" width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<th class="ft_head" colspan="6"><a name="fitt">Fitting Input Field | EDIT</a></th>
			</tr>
			<tr>
				<th class="ft_bod">Name</th>
				<th class="ft_bod">DNA</th>
				<th class="ft_bod">Role</th>
			</tr>
			<tr>
				<td class="tleft" width="100"><input id="fittname" title="whoopie" class="inp" type="text" name="fname" size="20" value="'.$rowEdit['fittName'].'"></td>
				<td class="tleft" width="380"><input class="inp" type="text" name="dna" size="80" value="'.$rowEdit['fitting'].'"></td>
				<td class="tleft" width="100"><select class="inp" name="role">';
			$roleQ = mysql_query("SELECT * FROM fitt_dna_role");
			while ($rowRQ = mysql_fetch_array($roleQ)) {
				if  ($rowEdit['role'] == $rowRQ['id']) {
					$wrt	.=	'<option value="'.$rowRQ['id'].'" selected>' . $rowRQ['rolename'] . '</option>';
				} else {
					$wrt	.=	'<option value="'.$rowRQ['id'].'">' . $rowRQ['rolename'] . '</option>';
				}
			}
$wrt	.=	'	</select></td>
			</tr><tr><th class="ft_bod" colspan="3">Description</th></tr><tr>
				<td class="tleft"><textarea class="inp" name="description" rows="4" cols="50">'.$rowEdit['description'].'</textarea></td>
				<td class="tleft" colspan="2"><input id="edit" type="submit" value="Update" alt="Submit" /><a href="./?p=fittings"><img src="img/cross.png" class="nob"></a></td>
			</tr>
			</table>
			<input type="hidden" name="author" value="'.$_SERVER['HTTP_EVE_CHARNAME'].'" />
			<input type="hidden" name="id" value="'.$_GET['id'].'" />';
$wrt	.=	'</form>';
	}
}elseif($_GET['a']=='roles'){
$wrt	=	'
<script type="text/javascript">
$(function() {
$(\'#inp *\').tooltip();
$("select").tooltip({
	left: 25
});

});

</script>
';
$wrt .=	'<div id="dialog-confirm" title="Delete a Role?">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This role will be permanently deleted and cannot be recovered.<br>Remember, deleting an already assigned role can and will brake that fittings role. Please reassign a role to that fitt!<br>Proceed?</p>
		</div>';
		$wrt .=	'<table class="center" width="100%" cellpadding="0" cellspacing="0" border="0">
					<tr>
						<th class="ft_head" colspan="6"><a name="roled">Role Editor</a></th>
					</tr>';
		$wrt .=	'	<tr>
						<td width="200" style="border-right:solid 1px #3d3d3d;">Add Role</td><td colspan="2">Edit Role</td>
					</tr>
					<tr>
						<td class="tleft" style="border-right:solid 1px #3d3d3d;"><form action="./?module=data&part=fittings&s=saverole" method="post"><span id="inp"><input title="Type the name of the Role you are creating!" type="text" name="rolename"></span><br /><button id="insert">Add Role</button></form></td>
						<td class="tleft" width="200"><table cellpadding="0" cellspacing="0" border="0" width="250">';
							$roleList = mysql_query("SELECT * FROM fitt_dna_role");
							while ($rowRlist = mysql_fetch_array($roleList)) {
							if ( $evenOdd ) {$odder = "even";}else{$odder = "odd";}
							$evenOdd = !$evenOdd;
								$wrt .= '<tr><td class="tcell'.$odder.'">'.$rowRlist['rolename'] . '</td><td class="tcell'.$odder.'"><span class="edit"><a href="./?module=admin&part=fittings&a=roles&s=editr&id='.$rowRlist['id'].'">edit</a></span></td><td class="tcell'.$odder.'"><span class="del"><a id="opener" href="./?module=data&part=fittings&s=deleterole&id='.$rowRlist['id'].'">delete</a></span></td></tr>';
							}
		$wrt .=	'		</table></td>
						<td class="tleft">';
					if (isset($_GET['s'])) {
						if ($_GET['s'] == 'editr') {
							$roleEdit = mysql_query("SELECT * FROM fitt_dna_role WHERE id = ".$_GET['id']."");
								while ($rowRedit = mysql_fetch_array($roleEdit)) {
									$wrt .= 'Editing Rolename "<b>'.$rowRedit['rolename'].'</b>"<br />
									<form action="./?module=data&part=fittings&s=updaterole" method="post"><input type="hidden" name="roleid" value="'.$rowRedit['id'].'"><input type="text" name="rolename" value="'.$rowRedit['rolename'].'"> <button id="insert">update</button></form>';
								}
						}
					} else {$wrt .= '<b>NOTICE</b><br />Removing a Role will brake the current fittings role\'s if that role already is applied to a fitting.<br />To remedy that, please reassign the missing role for that setup if one is affected.<br /><br />Editing a role will not affect any entry other than changing the rolename!';}
		$wrt .=	'		</td>
					</tr>';
		$wrt .=	'</table>';
}elseif($_GET['a']=='editr'){
}
echo $wrt;


?>