<div id="dialog-confirm" title="Delete a Bulletin?">
	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This bulletin will be permanently deleted and cannot be recovered. Are you sure?</p>
</div>
<?php
include('modules/bulletin/config.php');
require_once('includes/include_editor.php');

$wrt	=	wrt_table(0,0,0,$tblWidth,'center');
$wrt	.=	'<tr><th class="ft_head">Bulletins</th><th>&nbsp;</th><th class="ft_head">Settings</th></tr>';
//if ($isDirector) {$editpanel = '<hr>';} else {$editpanel ='';}


//if (!isset($_GET['mode'])){
$wrt	.=	'<tr><td>';
$wrt 	.=	wrt_table(0,0,0,$tblWidth,'center');

$bulletin = good_query_table("SELECT * FROM bulletin ORDER BY postdate DESC");
	foreach($bulletin as $row){
		if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
		$evenOdd = !$evenOdd;
		$wrt .=	'<tr><td class="bcell'.$odder.'">'.$row['title'].'</td><td class="bcell'.$odder.'"><span class="edit"><a href="'.$module_admin.'&mode=edit&id='.$row['id'].'">edit</a></span>&nbsp;<span class="del"><a id="opener" href="'.$module_data.'&a=delete&id='.$row['id'].'">delete</a></span></td></tr>';
	}

$wrt	.=	'</table>';
$wrt	.=	'</td><td>&nbsp;</td><td>';
$wrt	.=	'<span class="add"><a class="ld" href="'.$module_admin.'&mode=add">Add Bulletin</a></span>';
$wrt	.=	'<hr>';
$wrt	.=	'';
$wrt	.=	'</td></tr>';

$wrt	.=	'<tr><td>&nbsp;</td></tr>';



//} elseif ($_GET['mode'] == 'add') {
if (isset($_GET['mode']) && ($_GET['mode']=='add')) {
		if ($admin == true) {
$wrt	.=	'<tr><th class="ft_head" colspan="3">Add Bulletin</th></tr>';
$wrt	.=	'<tr><td colspan="3">';
$wrt	.=	'<form name="form1" method="post" action="./?module=data&part=bulletin&a=add">';
$wrt	.=	'	<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$wrt	.=	'		<tr>';
$wrt	.=	'			<td class="tright">Title : </td>';
$wrt	.=	'			<td class="tleft"><input type="text" name="title"></td>';
$wrt	.=	'		</tr>';
$wrt	.=	'		<tr>';
$wrt	.=	'			<td class="tright">Bulletin content : </td>';
$wrt	.=	'			<td class="tleft"><textarea name="content" cols="50" rows="10" id="editor"></textarea></td>';
$wrt	.=	'		</tr>';
$wrt	.=	'		<tr><td colspan="2"><input type="hidden" name="author" value="'.$getHeaderCharName.'"><button id="insert">Add Bulletin</button></td></tr>';
$wrt	.=	'	</table>';
$wrt	.=	'	</form>';

		}
	} elseif (isset($_GET['mode']) && ($_GET['mode'] == 'edit')) {
		//if ($admin == true) {
		$result = good_query_table("SELECT * FROM bulletin WHERE id = ".$_GET['id']."");
		//while ($row = mysql_fetch_array($result))
$wrt	.=	'<tr><th class="ft_head" colspan="3">Edit Bulletin</th></tr>';
$wrt	.=	'<tr><td colspan="3">';
		foreach($result as $row){
$wrt	.=	'<form name="form1" method="post" action="./?module=data&part=bulletin&a=update">';
$wrt	.=	'	<table width="100%" border="0" cellspacing="0" cellpadding="0">';
$wrt	.=	'		<tr>';
$wrt	.=	'			<td class="tright">Title : </td>';
$wrt	.=	'			<td class="tleft"><input type="text" name="title" value="'.$row['title'].'"></td>';
$wrt	.=	'		</tr>';
$wrt	.=	'		<tr>';
$wrt	.=	'			<td class="tright">Bulletin content : </td>';
$wrt	.=	'			<td class="tleft"><textarea name="content" cols="50" rows="10" id="editor">'.$row['content'].'</textarea></td>';
$wrt	.=	'		</tr>';
$wrt	.=	'		<tr><td colspan="2"><input type="hidden" name="author" value="'.$getHeaderCharName.'"><input type="hidden" name="id" value="'.$row['id'].'"><input type="submit" name="Submit" value="Update"></td></tr>';
$wrt	.=	'	</table>';
$wrt	.=	'	</form>';
		}
	}

$wrt	.=	'</td></tr>';
$wrt	.=	'</table>';

echo $wrt;
?>