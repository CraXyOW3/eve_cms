<?php
require_once('./includes/include_editor.php');
$pidenti='Page Identifier, this is used in menu later!';
$pages = good_query_table("SELECT * FROM pages ORDER BY id ASC");
$wrt	=	'<table cellpadding="0" cellspacing="0" border="0" class="center" width="'.$tblWidth.'">';
$wrt	.=	'<tr><th class="ft_head left">Pages</th><th class="ft_head left">Content Editor <span class="add"><a href="./?module=admin&part=page&do=add">create page</a></span></th></tr>';
$wrt	.=	'<tr><td class="left" width="250">';
$wrt	.=	'<ul>';
foreach ($pages as $page){
	$wrt	.=	'<li><a href="./?module=admin&part=page&do=edit&id='.$page['id'].'">'.$page['p_name'].'</a></li>';
}
$wrt	.=	'</ul>';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</td><td class="left border_left">';
$wrt	.=	'';
if (isset($_GET['do']) && $_GET['do']=='add'){
$wrt	.=	'<form action="./?module=data&part=page&a=add" method="post"><table border="0">';
$wrt	.=	'<tr><th colspan="2">Add Page</th></tr>';
$wrt	.=	'<tr>';
$wrt	.=	'<td class="left">Page Identifier</td><td class="left"><span id="inp"><input title="'.$pidenti.'" type="text" name="p_name"></span></td>';
$wrt	.=	'</tr><tr>';
$wrt	.=	'<td class="left">Page Title</td><td class="left"><input type="text" name="p_title"></td>';
$wrt	.=	'</tr><tr>';
$wrt	.=	'<td class="left">Page Content</td></tr>';
$wrt	.=	'<tr><td class="left" colspan="2"><textarea id="editor" name="p_content"  rows="10" cols="100"></textarea></td>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr><td colspan="2"><input type="submit" value="insert"></td></tr>';
$wrt	.=	'</table></form>';
}elseif (isset($_GET['do']) && $_GET['do']=='edit'){
$wrt	.=	'<div id="dialog-confirm" title="Delete a Page?">';
$wrt	.=	'	<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This Page will be permanently deleted and cannot be recovered. Are you sure?</p>';
$wrt	.=	'	</div>';
$editor=good_query_assoc("SELECT * FROM pages WHERE id='".$_GET['id']."'");
$wrt	.=	'<form action="./?module=data&part=page&a=edit" method="post"><table border="0">';
$wrt	.=	'<tr><th colspan="2">Edit Page</th></tr>';
$wrt	.=	'<tr>';
$wrt	.=	'<td class="left">Page Identifier</td><td class="left"><span id="inp"><input title="'.$pidenti.'<br />Like this: index&entry='.$editor['p_name'].'" type="text" name="p_name" value="'.$editor['p_name'].'"></span></td>';
$wrt	.=	'</tr><tr>';
$wrt	.=	'<td class="left">Page Title</td><td class="left"><input type="text" name="p_title" value="'.$editor['p_title'].'"></td>';
$wrt	.=	'</tr><tr>';
$wrt	.=	'<td class="left">Page Content</td></tr>';
$wrt	.=	'<tr><td class="left" colspan="2"><textarea id="editor" name="p_content"  rows="10" cols="100">'.$editor['p_content'].'</textarea></td>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr><td colspan="2"><input type="hidden" name="id" value="'.$editor['id'].'"><input type="submit" value="update"><span class="del"><a id="opener" href="./?module=data&part=page&a=del&id='.$editor['id'].'">delete</a></span></td></tr>';
$wrt	.=	'</table></form>';
}
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</td></tr>';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</table>';

echo $wrt;
?>