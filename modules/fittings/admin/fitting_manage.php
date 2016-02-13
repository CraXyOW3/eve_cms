<script type="text/javascript">
$(function() {
$('#inp *').tooltip();
$("select").tooltip({
	left: 25
});
		$( "button#insert").button({
            icons: {
                primary: "ui-icon-disk"
            },
            text: true
		});
		$( "input:submit, input:button").button();
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
});
</script>
<?php
include('_cfg.php');
echo alert_check();
	if (isset($_GET['s']) && ($_GET['s']=='edit')) {

	$dnaQedit = mysql_query("SELECT * FROM fitt_dna WHERE id = ".$_GET['id']."");
	while ($rowEdit = mysql_fetch_array($dnaQedit)) {
	echo	'<form action="./?p=data&mode=fittings&s=update" method="post">';
	echo	'<table class="center" width="100%" cellpadding="0" cellspacing="0" border="0">
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
					echo	'<option value="'.$rowRQ['id'].'" selected>' . $rowRQ['rolename'] . '</option>';
				} else {
					echo	'<option value="'.$rowRQ['id'].'">' . $rowRQ['rolename'] . '</option>';
				}
			}
	echo	'	</select></td>
			</tr><tr><th class="ft_bod" colspan="3">Description</th></tr><tr>
				<td class="tleft"><textarea class="inp" name="description" rows="4" cols="50">'.$rowEdit['description'].'</textarea></td>
				<td class="tleft" colspan="2"><input id="edit" type="submit" value="Update" alt="Submit" /><a href="./?p=fittings"><img src="img/cross.png" class="nob"></a></td>
			</tr>
			</table>
			<input type="hidden" name="author" value="'.$_SERVER['HTTP_EVE_CHARNAME'].'" />
			<input type="hidden" name="id" value="'.$_GET['id'].'" />';
	echo	'</form>';
	}
} elseif (empty($_GET['s'])) {
	echo	'<form action="./?p=data&mode=fittings&s=post" method="post" id="addform">';
	echo	'<table class="center" width="100%" cellpadding="0" cellspacing="0" border="0">
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
				echo	'<option value="'.$rowRQ['id'].'">' . $rowRQ['rolename'] . '</option>';
			}
	echo	'	</select></td>
			</tr><tr><th class="ft_bod" colspan="3">Description</th></tr><tr>
				<td class="tleft"><span id="inp"><textarea title="A small description if the fitt!" class="inp" name="description" rows="4" cols="50"></textarea></span></td>
				<td class="tleft" colspan="2"><button id="insert">Save Fitting</button></td>
			</tr>
			</table>
			<input type="hidden" name="author" value="'.$_SERVER['HTTP_EVE_CHARNAME'].'" />';
	echo	'</form>';
}

?>