<?php
$wrt_top	=	'';
$wrt_top	.=	'
<script type="text/javascript">
    $(function() {
        $("#navlist_flat").sortable({
            placeholder: \'ui-state-highlight\',
            stop: function(i) {
                placeholder: \'ui-state-highlight\'
                $.ajax({
                    type: "GET",
                    url: "./'.$module_dir.'/navigation/includes/order_nav.php",
                    data: $("#navlist_flat").sortable("serialize")});
            }
        });
        $("#navlist_flat").disableSelection();
    });
</script>
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
		$( "button#insert").button({
            icons: {
                primary: "ui-icon-disk"
            },
            text: true
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
		$( "#check" ).button();
	});

	$(function() {
		$(\'a#opener\').click(function(e) {
		e.preventDefault();
			$( "#dialog-confirm" ).dialog(\'option\', \'anchor\', $(this).attr(\'href\'));
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
<div id="dialog-confirm" title="Delete Menuitem?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Press delete to remove this menu entry!<br>Proceed?</p>
</div>
';
//require_once($module_dir.'navigation/config.php');

function moduledrop($sel=null){
//if (isset($sel))
$root='modules';
$nav_admin	=	'<option>-- Admin Modules --</option>';
$nav_pub	=	'<option>-- Public Modules --</option>';
$nav_pg		=	'<option>-- Page Module</option>';
	if ($handle = opendir($root)) {
		while (false !== ($module = readdir($handle))) {
		//if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
		//$evenOdd = !$evenOdd;
		$i=0;
		$counter=0;
			if ($module != "." && $module != "..") {
				if (file_exists($root.'/'.$module.'/config.php')){
					include($root.'/'.$module.'/config.php');
				}
				if (file_exists($root.'/'.$module.'/admin/index.php')){
						$last = count($array) - 1;
						foreach ($array['Admin'] as $ic => $row){
							$isFirst = ($ic == 0);
							$isLast = ($ic == $last);
							if ($row['link']==$sel){$selected=' selected';}else{$selected='';}
							$nav_admin .= '<option value="'.$row['link'].'"'.$selected.'>&nbsp;&nbsp;'.$row['name'].'</option>';
						}
					$i++;
				}else{
				}
				if (file_exists($root.'/'.$module.'/public/index.php')){
						$last = count($array) - 1;
						foreach ($array['Public'] as $ic => $row){
							$isFirst = ($ic == 0);
							$isLast = ($ic == $last);
							if ($row['link']==$sel){$selected=' selected';}else{$selected='';}
							$nav_pub .= '<option value="'.$row['link'].'"'.$selected.'>&nbsp;&nbsp;'.$row['name'].'</option>';
						}
					$i++;
				}else{
				}
			}
		}
		closedir($handle);
				$pgmngr = good_query_table("SELECT p_name, p_title FROM pages ORDER BY id DESC");
				foreach ($pgmngr as $option) {
					if ('page&entry='.$option['p_name']==$sel){$selected=' selected';}else{$selected='';}
					$nav_pg	.=	'<option value="page&entry='.$option['p_name'].'"'.$selected.'>&nbsp;&nbsp;'.$option['p_title'].'</option>';
				}
	}
	return '<select name="lurl">'.$nav_pub . $nav_admin . $nav_pg.'</select>';
}

//echo moduledrop('index');
$i=0;


if (isset($getHeaderTrusted)) {if ($getHeaderTrusted == 'Yes'){if($getHeaderCorpID==$G_corpID){
echo alert_check();
$sec_site = good_query_assoc("SELECT sec_site_admin FROM corp_members WHERE char_id=".$getHeaderCharID."");
if ($sec_site['sec_site_admin']){
$issiteadmin=1;
$allow = array (1 => 'Basic', 2 => 'Standard', 3 => 'Admin', 4 => 'Site Admin');
$sql_in = "'1','2','3','4'";
//echo'superadmin';

}else{
$issiteadmin=0;
$allow = array (1 => 'Basic', 2 => 'Standard', 3 => 'Admin');
$sql_in = "'1','2','3'";
//echo'regularadmin';
}

include($module_dir.'navigation/config.php');
$wrt	=	$wrt_top . '<table cellpadding="0" cellspacing="0" border="0" align="center" width="'.$tblWidth.'">';
//############################################# menu order sof
$wrt	.=	'<tr><td width="25%">';
	$wrt	.=	'<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td class="ft_head left">Field for Sorting <span id="chartip" class="font_s">(<a title="Drag\'n\'Drop to reorder the Menu<br />Menu is updated \'on the fly\'.<br />Need to reload or press another link to see results." class="inp right">info</a>)</span></td></tr><tr><td>';
	//$result = mysql_query("SELECT * FROM navigation WHERE (maccess in (".$sql_in.")) ORDER BY s_order ASC");
	//$result2 = "SELECT * FROM navigation WHERE (access in (".$sql_in.")) ORDER BY s_order ASC";
	$wrt	.=	'<ul id="navlist_flat">';
	//if (good_query($result2)) {echo'1';}else{echo'2';}
	$check_nav = good_query_value("SELECT count(*) FROM navigation");
	if ($check_nav==0) {$wrt .= 'no navigation';}else{
		$mnu = good_query_table("SELECT * FROM navigation WHERE (access in (".$sql_in.")) ORDER BY s_order ASC");
		foreach($mnu as $row){
			if($row['istitle']){
				$wrt	.=	'<li id="item_'.$row['id'].'" class="ui-state-default">'.$row['name'].'</li>';
				}else{
				$wrt	.=	'<li id="item_'.$row['id'].'" class="ui-state-default"><a>'.$row['name'].'</a></li>';
				}
		}
	}
	$wrt	.=	'</ul>';
	$wrt	.=	'</td></tr></table>';
$wrt	.=	'</td><td>';
//############################################# navigation edit sof

$resultt = mysql_query("SELECT * FROM navigation WHERE (maccess in (".$sql_in.",'10')) ORDER BY s_order ASC");
	$wrtt = '<table border="0" cellspacing="0" cellpadding="0" width="300">';
	//$wrtt .= '<tr><td colspan="2" class="tright">Add Entry</td></tr>';
	$wrtt .= '<tr><td class="ft_head left">Main navigation</td><td class="ft_head right font_s"><a href="'.$module_admin.'&a=add">Add Entry</a></td></tr>';
	$check_nave = good_query_value("SELECT count(*) FROM navigation");
	if ($check_nav==0) {$wrtt .= '<tr><td>nothing to do</td></tr>';}else{
		$nav_edit = good_query_table("SELECT * FROM navigation WHERE (access in (".$sql_in.",'10')) ORDER BY s_order ASC");
		foreach($nav_edit as $rowt){
			if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
				$evenOdd = !$evenOdd;
			if($rowt['istitle']){$spc = '';}else{$spc = '&nbsp;&nbsp;&nbsp;&nbsp;';}
				$wrtt	.=	'<tr><td class="left bsmall tcell'.$odder.'">'.$spc.'<a>'.$rowt['name'].'</a></td><td class="bsmall tcell'.$odder.'">(<a href="'.$module_admin.'&a=edit&id='.$rowt['id'].'">edit</a>)&nbsp;(<a id="opener" href="./?module=data&part=navigation&s=delete&id='.$rowt['id'].'">delete</a>)</td></tr>';
		}
	}
	$wrtt .= '</table>';
//############################################# navigation edit eof

$wrt	.=	$wrtt;


//############################################# navigation edit detail sof
if(isset($_GET['a']) && ($_GET['a']=='edit')) {
$resulte = mysql_query("SELECT * FROM navigation WHERE id = '".$_GET['id']."'");
$rowe = mysql_fetch_row($resulte);

$wrt	.=	'</td><td>';
$wrt	.=	'<form action="./?module=data&part=navigation&id='.$rowe['0'].'&s=update" method="post" name="formedit"><table border="0" cellspacing="0" cellpadding="0">';
$wrt	.=	'<tr><td class="ft_head left" colspan="2">Edit Entry</td></tr>';
$wrt	.=	'<tr><td class="tleft">Link Title</td><td class="tleft"><input type="text" name="ltitle" value="'.$rowe['5'].'"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Page Title</td><td class="tleft"><input type="text" name="ptitle" value="'.$rowe['6'].'"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Module</td><td class="tleft">';
$wrt	.=	moduledrop($rowe['7']);
$wrt	.=	'</td></tr>';
$wrt	.=	'<tr><td class="tleft">Access</td><td class="tleft">';
	$wrt	.=	'<select name="access">';
	foreach ($allow as $i => $value) {
		if ($i==$rowe['4']){$asel=' selected';}else{$asel='';}
		$wrt	.=	'<option value="'.$i.'"'.$asel.'>'.$value.'</option>';
	}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
/*
$wrt	.=	'<tr><td class="tleft">Parent</td><td class="tleft">';
$resultp = mysql_query("SELECT * FROM navigation WHERE pid='0' ORDER BY s_order ASC");
	$wrt	.=	'<select name="parent">';
		while ($rowp = mysql_fetch_array($resultp)){
		if ($rowe['1']==$rowp['id']){$psel=' selected';}else{$psel='';}
			$wrt	.=	'<option value="'.$rowp['id'].'"'.$psel.'>'.$rowp['name'].'</option>'."\n";
		}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
*/
if ($rowe['2']){$tsel=' checked';}else{$tsel='';}
$wrt	.=	'<tr><td class="tleft">isTitle</td><td class="tleft"><input type="checkbox" id="check" name="istitle" value="y" '.$tsel.'/><label for="check"></label></input></td></tr>';
$wrt	.=	'<tr><td colspan="2"><input type="hidden" name="id" value="'.$_GET['id'].'"><input type="submit" value="update"></td></tr>';
//$wrt	.=	'</table></form>';

$wrt	.=	'';
$wrt	.=	'</table></form>';

}
//############################################# menu edit detail eof
//############################################# menu add bof

if(isset($_GET['a']) && ($_GET['a']=='add')) {

$wrt	.=	'</td><td>';
$wrt	.=	'<form name="formadd" action="./?module=data&part=navigation&s=add" method="post"><table border="0" cellspacing="0" cellpadding="0">';
$wrt	.=	'<tr><td class="ft_head left" colspan="2">Adding Entry</td></tr>';
$wrt	.=	'<tr><td class="tleft">Link Title</td><td class="tleft"><input type="text" name="ltitle"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Page Title</td><td class="tleft"><input type="text" name="ptitle"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Module</td><td class="tleft">';
$wrt	.=	moduledrop();
$wrt	.=	'</td></tr>';
$wrt	.=	'<tr><td class="tleft">Access</td><td class="tleft">';
	$wrt	.=	'<select name="access">';
	foreach ($allow as $i => $value) {
		$wrt	.=	'<option value="'.$i.'">'.$value.'</option>';
	}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
/*
$wrt	.=	'<tr><td class="tleft">Parent</td><td class="tleft">';
$resultp = mysql_query("SELECT * FROM navigation WHERE pid='0' ORDER BY s_order ASC");
	$wrt	.=	'<select name="parent">';
		while ($rowp = mysql_fetch_array($resultp)){
			$wrt	.=	'<option value="'.$rowp['id'].'">'.$rowp['name'].'</option>'."\n";
		}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
*/
$wrt	.=	'<tr><td class="tleft">isTitle</td><td class="tleft"><input type="checkbox" id="check" name="istitle" value="y" /><label for="check"></label></input></td></tr>';
$wrt	.=	'<tr><td colspan="2"><input type="submit" value="add"></td></tr>';

$wrt	.=	'';
$wrt	.=	'</table></form>';
$wrt	.=	'';
}

//############################################# menu add eof




$wrt	.=	'</td></tr>';


$wrt	.=	'</table>';

echo $wrt;
}}}
?>