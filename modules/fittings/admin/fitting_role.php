<?php
//session_start();
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
		$( "button#insert").button({
            icons: {
                primary: "ui-icon-disk"
            },
            text: true
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
$('#inp *').tooltip();
$("select").tooltip({
	left: 25
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
/*
if (isset($_SESSION['text'])) {
	echo alert_notice($_SESSION['type'],$_SESSION['text']);
	unset($_SESSION['text']);
	unset($_SESSION['type']);
	session_destroy();
}
*/
echo alert_check();
$wrt =	'<div id="dialog-confirm" title="Delete a Role?">
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
						<td class="tleft" style="border-right:solid 1px #3d3d3d;"><form action="./?p=data&mode=fittings&s=saverole" method="post"><span id="inp"><input title="Type the name of the Role you are creating!" type="text" name="rolename"></span><br /><button id="insert">Add Role</button></form></td>
						<td class="tleft" width="200"><table cellpadding="0" cellspacing="0" border="0" width="250">';
							$roleList = mysql_query("SELECT * FROM fitt_dna_role");
							while ($rowRlist = mysql_fetch_array($roleList)) {
							if ( $evenOdd ) {$odder = "even";}else{$odder = "odd";}
							$evenOdd = !$evenOdd;
								$wrt .= '<tr><td class="tcell'.$odder.'">'.$rowRlist['rolename'] . '</td><td class="tcell'.$odder.'"><span class="edit"><a href="./?p=fitting_role&a=editr&id='.$rowRlist['id'].'">edit</a></span></td><td class="tcell'.$odder.'"><span class="del"><a id="opener" href="./?p=data&mode=fittings&s=deleterole&id='.$rowRlist['id'].'">delete</a></span></td></tr>';
							}
		$wrt .=	'		</table></td>
						<td class="tleft">';
					if (isset($_GET['a'])) {
						if ($_GET['a'] == 'editr') {
							$roleEdit = mysql_query("SELECT * FROM fitt_dna_role WHERE id = ".$_GET['id']."");
								while ($rowRedit = mysql_fetch_array($roleEdit)) {
									$wrt .= 'Editing Rolename "<b>'.$rowRedit['rolename'].'</b>"<br />
									<form action="./?p=data&mode=fittings&s=updaterole" method="post"><input type="hidden" name="roleid" value="'.$rowRedit['id'].'"><input type="text" name="rolename" value="'.$rowRedit['rolename'].'"> <button id="insert">update</button></form>';
								}
						}
					} else {$wrt .= '<b>NOTICE</b><br />Removing a Role will brake the current fittings role\'s if that role already is applied to a fitting.<br />To remedy that, please reassign the missing role for that setup if one is affected.<br /><br />Editing a role will not affect any entry other than changing the rolename!';}
		$wrt .=	'		</td>
					</tr>';
		$wrt .=	'</table>';
		echo	$wrt;
?>