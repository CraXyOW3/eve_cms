<?php
//session_start();
if (isset($getHeaderTrusted)){if($getHeaderTrusted=='No'){echo "no can do!";}else{if($getHeaderCorpID==$G_corpID) { // auth part
if ($isDirector) {
?><script type="text/javascript">
    $(function() {
        $("#navlist_flat").sortable({
            placeholder: 'ui-state-highlight',
            stop: function(i) {
                placeholder: 'ui-state-highlight'
                $.ajax({
                    type: "GET",
                    url: "./menu_order.php",
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

<div id="dialog-confirm" title="Delete Menuitem?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Press delete to remove this menu entry!<br>Proceed?</p>
</div>
<?php
if (isset($getHeaderTrusted)) {if ($getHeaderTrusted == 'Yes'){if($getHeaderCorpID==$G_corpID){
echo alert_check();
$sec_site = good_query_assoc("SELECT sec_site_admin FROM corp_members WHERE char_id=".$getHeaderCharID."");
if ($sec_site['sec_site_admin']){
$issiteadmin=1;
$allow = array (1 => 'Initiate', 2 => 'Regular', 3 => 'Admin', 4 => 'Site Admin', 10 => 'Site Functions');
$sql_in = "'1','2','3','4'";
echo'superadmin';

}else{
$issiteadmin=0;
$allow = array (1 => 'Initiate', 2 => 'Regular', 3 => 'Admin');
$sql_in = "'1','2','3'";
echo'regularadmin';

}
/*
	$result = mysql_query("SELECT * FROM menu WHERE pid='0' AND (maccess in ('1','2','3')) AND istitle=true ORDER BY morder ASC");
	$wrt	=	'<ul id="navlist_flat">';
	while ($row = mysql_fetch_array($result)){
		$wrt	.=	'<li id="item_'.$row['id'].'" class="ui-state-default">'.$row['mname'].'</li>';
			$result2 = mysql_query("SELECT * FROM menu WHERE pid='".$row['id']."' AND (maccess in ('1','2','3')) ORDER BY morder ASC");
			while ($row2 = mysql_fetch_array($result2)) {
				$wrt	.=	'<li id="item_'.$row2['id'].'" class="ui-state-default"><a>'.$row2['mname'].'</a></li>';
			}
	}
	$wrt	.=	'</ul>';
	echo	$wrt;
*/


$wrt	=	'<table cellpadding="0" cellspacing="0" border="0" align="center" width="'.$tblWidth.'">';
//############################################# menu order sof
$wrt	.=	'<tr><td width="25%">';
	$wrt	.=	'<table cellpadding="0" cellspacing="0" border="0" width="100%"><tr><td class="ft_head left">Field for Sorting <span id="chartip" class="font_s">(<a title="Drag\'n\'Drop to reorder the Menu<br />Menu is updated \'on the fly\'.<br />Need to reload or press another link to see results." class="inp right">info</a>)</span></td></tr><tr><td>';
	$result = mysql_query("SELECT * FROM menu WHERE (maccess in (".$sql_in.")) ORDER BY morder ASC");
	$wrt	.=	'<ul id="navlist_flat">';
	while ($row = mysql_fetch_array($result)){
	if($row['istitle']){
		$wrt	.=	'<li id="item_'.$row['id'].'" class="ui-state-default">'.$row['mname'].'</li>';
		}else{
		$wrt	.=	'<li id="item_'.$row['id'].'" class="ui-state-default"><a>'.$row['mname'].'</a></li>';
		}
	}
	$wrt	.=	'</ul>';
//$wrt	.=	'</td></tr>';
	$wrt	.=	'</td></tr></table>';
$wrt	.=	'</td><td>';
//############################################# menu order eof

//############################################# menu edit sof

$resultt = mysql_query("SELECT * FROM menu WHERE (maccess in (".$sql_in.",'10')) ORDER BY morder ASC");
	$wrtt = '<table border="0" cellspacing="0" cellpadding="0" width="300">';
	//$wrtt .= '<tr><td colspan="2" class="tright">Add Entry</td></tr>';
	$wrtt .= '<tr><td class="ft_head left">Main Menu</td><td class="ft_head right font_s"><a href="./?module='.$module_admin.'&a=add">Add Entry</a></td></tr>';
	$wrtt10 = '';
	while ($rowt = mysql_fetch_array($resultt)){
		if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
			$evenOdd = !$evenOdd;
	if($rowt['istitle']){$spc = '';}else{$spc = '&nbsp;&nbsp;&nbsp;&nbsp;';}
	if ($rowt['maccess']=='10') {
		$wrtt10 .= '<tr><td class="left bsmall tcell'.$odder.'">'.$spc.'<a>'.$rowt['mname'].'</a></td><td class="bsmall tcell'.$odder.'">(<a href="./?module=manager_menu&a=edit&id='.$rowt['id'].'">edit</a>)&nbsp;(<a id="opener" href="./?module=data&mode=updatelinks&s=delete&id='.$rowt['id'].'">delete</a>)</td></tr>';
	}else{
		$wrtt	.=	'<tr><td class="left bsmall tcell'.$odder.'">'.$spc.'<a>'.$rowt['mname'].'</a></td><td class="bsmall tcell'.$odder.'">(<a href="./?module=manager_menu&a=edit&id='.$rowt['id'].'">edit</a>)&nbsp;(<a id="opener" href="./?module=data&mode=updatelinks&s=delete&id='.$rowt['id'].'">delete</a>)</td></tr>';
	}
	}
	if ($issiteadmin) {
	$wrtt .= '<tr><td colspan="2">&nbsp;</td></tr><tr><td colspan="2" class="ft_head">Site Function Handlers</td></tr>'.$wrtt10;
	}
	$wrtt .= '</table>';
//############################################# menu edit eof

$wrt	.=	$wrtt;


//############################################# menu edit detail sof
if(isset($_GET['a']) && ($_GET['a']=='edit')) {
$resulte = mysql_query("SELECT * FROM menu WHERE id = '".$_GET['id']."'");
$rowe = mysql_fetch_row($resulte);

$wrt	.=	'</td><td>';
$wrt	.=	'<form action="./?module=data&mode=updatelinks&id='.$rowe['0'].'&s=update" method="post" name="formedit"><table border="0" cellspacing="0" cellpadding="0">';
$wrt	.=	'<tr><td class="ft_head left" colspan="2">Edit Entry</td></tr>';
$wrt	.=	'<tr><td class="tleft">Link Title</td><td class="tleft"><input type="text" name="ltitle" value="'.$rowe['5'].'"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Page Title</td><td class="tleft"><input type="text" name="ptitle" value="'.$rowe['6'].'"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Link Url</td><td class="tleft"><input type="text" name="lurl" value="'.$rowe['7'].'"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Access</td><td class="tleft">';
	$wrt	.=	'<select name="access">';
	foreach ($allow as $i => $value) {
		if ($i==$rowe['4']){$asel=' selected';}else{$asel='';}
		$wrt	.=	'<option value="'.$i.'"'.$asel.'>'.$value.'</option>';
	}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
$wrt	.=	'<tr><td class="tleft">Parent</td><td class="tleft">';
$resultp = mysql_query("SELECT * FROM menu WHERE pid='0' ORDER BY morder ASC");
	$wrt	.=	'<select name="parent">';
		while ($rowp = mysql_fetch_array($resultp)){
		if ($rowe['1']==$rowp['id']){$psel=' selected';}else{$psel='';}
			$wrt	.=	'<option value="'.$rowp['id'].'"'.$psel.'>'.$rowp['mname'].'</option>'."\n";
		}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
if ($rowe['2']){$tsel=' checked';}else{$tsel='';}
$wrt	.=	'<tr><td class="tleft">isTitle</td><td class="tleft"><input type="checkbox" id="check" name="istitle" value="y" '.$tsel.'/><label for="check"></label></input></td></tr>';
$wrt	.=	'<tr><td colspan="2"><input type="hidden" name="id" value="'.$_GET['id'].'"><input type="submit" value="update"></td></tr>';
//$wrt	.=	'</table></form>';
$wrt	.=	'<tr><td colspan="2">&nbsp;</td></tr>';
$wrt	.=	'<tr><td colspan="2" class="ft_head">Add From PageMngr</td></tr>';
$wrt	.=	'<tr><td class="tleft">Page</td><td class="tleft">';
$wrt	.=	'<select name="urltitle" onchange="document.formedit.lurl.value=this.value">';
$pgmngr = good_query_table("SELECT p_name, p_title FROM pages ORDER BY id DESC");
	$wrt	.=	'<option>- page selection -</option>';
foreach ($pgmngr as $option) {
	$wrt	.=	'<option title="'.$option['p_title'].'" value="index&entry='.$option['p_name'].'">'.$option['p_title'].'</option>';
}
$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
$wrt	.=	'';
$wrt	.=	'</table></form>';

}
//############################################# menu edit detail eof


//############################################# menu add bof

if(isset($_GET['a']) && ($_GET['a']=='add')) {

$wrt	.=	'</td><td>';
$wrt	.=	'<form name="formadd" action="./?module=data&mode=updatelinks&s=add" method="post"><table border="0" cellspacing="0" cellpadding="0">';
$wrt	.=	'<tr><td class="ft_head left" colspan="2">Adding Entry</td></tr>';
$wrt	.=	'<tr><td class="tleft">Link Title</td><td class="tleft"><input type="text" name="ltitle"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Page Title</td><td class="tleft"><input type="text" name="ptitle"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Link Url</td><td class="tleft"><input type="text" name="lurl"></td></tr>';
$wrt	.=	'<tr><td class="tleft">Access</td><td class="tleft">';
	$wrt	.=	'<select name="access">';
	foreach ($allow as $i => $value) {
		$wrt	.=	'<option value="'.$i.'">'.$value.'</option>';
	}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
$wrt	.=	'<tr><td class="tleft">Parent</td><td class="tleft">';
$resultp = mysql_query("SELECT * FROM menu WHERE pid='0' ORDER BY morder ASC");
	$wrt	.=	'<select name="parent">';
		while ($rowp = mysql_fetch_array($resultp)){
			$wrt	.=	'<option value="'.$rowp['id'].'">'.$rowp['mname'].'</option>'."\n";
		}
	$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
$wrt	.=	'<tr><td class="tleft">isTitle</td><td class="tleft"><input type="checkbox" id="check" name="istitle" value="y" /><label for="check"></label></input></td></tr>';
$wrt	.=	'<tr><td colspan="2"><input type="submit" value="add"></td></tr>';
//$wrt	.=	'</table></form>';
$wrt	.=	'<tr><td colspan="2">&nbsp;</td></tr>';
$wrt	.=	'<tr><td colspan="2" class="ft_head">Add From PageMngr</td></tr>';
$wrt	.=	'<tr><td class="tleft">Page</td><td class="tleft">';
$wrt	.=	'<select name="urltitle" onchange="document.formadd.lurl.value=this.value">';
$pgmngr = good_query_table("SELECT p_name, p_title FROM pages ORDER BY id DESC");
	$wrt	.=	'<option>- page selection -</option>';
foreach ($pgmngr as $option) {
	$wrt	.=	'<option title="'.$option['p_title'].'" value="index&entry='.$option['p_name'].'">'.$option['p_title'].'</option>';
}
$wrt	.=	'</select>';
$wrt	.=	'</td></tr>';
$wrt	.=	'';
$wrt	.=	'</table></form>';
$wrt	.=	'';
}

//############################################# menu add eof




$wrt	.=	'</td></tr>';


$wrt	.=	'</table>';




	echo	$wrt;
}}}

}}}} // sec end
?>