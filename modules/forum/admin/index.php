<?php
include($module_dir.'forum/config.php');
$wrt	=	'<script type="text/javascript">
				$(function() {
					$("#forum_cat").sortable({
						placeholder: \'ui-state-highlight\',
						stop: function(i) {
							placeholder: \'ui-state-highlight\'
							$.ajax({
								type: "GET",
								url: "./'.$module_dir.'/forum/includes/order_forum.php",
								data: $("#forum_cat").sortable("serialize")});
						}
					});
					$("#forum_cat").disableSelection();
				});
				$(function() {
					$("#forum_cat_admin").sortable({
						placeholder: \'ui-state-highlight\',
						stop: function(i) {
							placeholder: \'ui-state-highlight\'
							$.ajax({
								type: "GET",
								url: "./'.$module_dir.'/forum/includes/order_forum.php",
								data: $("#forum_cat_admin").sortable("serialize")});
						}
					});
					$("#forum_cat_admin").disableSelection();
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
</script>';
$wrt	.=	'<div id="dialog-confirm" title="Delete Forum Category?">
				<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>Are you really sure you want to delete this?<br />Deleting this Category will REMOVE ALL underlying information such as Topics and all Posts related to the Main Category!</p>
			</div>';

$wrt	.=	'<table cellpadding="0" cellspacing="0" border="0" class="center" width="'.$tblWidth.'">';
$wrt	.=	'<tr><th class="ft_head" width="40%">Categories</th><th class="ft_head left"><span class="add"><a href="'.$module_admin.'&do=add">Create Category</a></span></th></tr>';
$wrt	.=	'<tr><td class="left">';
$wrt	.=	'';
$wrt	.=	wrt_table(0,0,0,$tblWidth);
$wrt	.=	'<tr><td class="ft_head left">Public Categories</td></tr>';
$wrt	.=	'</table>';
$wrt	.=	'<ul id="forum_cat">';
	$forum_order = good_query_table("SELECT * FROM forum_cat WHERE cat_isdir=0 ORDER BY cat_order ASC");
	foreach($forum_order as $forder) {
		//$wrt	.=	'<li id="item_'.$forder['id'].'" class="ui-state-default ui-corner-all">'.wrt_table(0,0,0,'100%').'<tr><td class="left" width="60%">'.$forder['cat_name'].'</td><td class="right font_s"><span class="edit"><a href="./?p=forum_mng&do=edit&id='.$forder['id'].'">edit</a></span> <span class="del"><a>delete</a></span></td></tr></table></li>';
		$wrt	.=	'<li id="item_'.$forder['id'].'" class="ui-state-default ui-corner-all">'.wrt_table(0,0,0,'100%').'<tr><td class="left" width="60%">'.$forder['cat_name'].'</td><td class="right font_s"><span class="edit"><a href="'.$module_admin.'&do=edit&id='.$forder['id'].'">edit</a></span> <span class="del"><a id="opener" href="'.$module_data.'&mode=forumedit&a=delcat&id='.$forder['id'].'">delete</a></span></td></tr></table></li>';
	}
$wrt	.=	'';
$wrt	.=	'</ul>';
$wrt	.=	wrt_table(0,0,0,$tblWidth);
$wrt	.=	'<tr><td class="ft_head left">Admin Categories</td></tr>';
$wrt	.=	'</table>';
$wrt	.=	'<ul id="forum_cat_admin">';
	$forum_order = good_query_table("SELECT * FROM forum_cat WHERE cat_isdir=1 ORDER BY cat_order ASC");
	foreach($forum_order as $forder) {
		//$wrt	.=	'<li id="item_'.$forder['id'].'" class="ui-state-default ui-corner-all">'.$forder['cat_name'].'</li>';
		$wrt	.=	'<li id="item_'.$forder['id'].'" class="ui-state-default ui-corner-all">'.wrt_table(0,0,0,'100%').'<tr><td class="left" width="60%">'.$forder['cat_name'].'</td><td class="right font_s"><span class="edit"><a href="'.$module_admin.'&do=edit&id='.$forder['id'].'">edit</a></span> <span class="del"><a id="opener" href="'.$module_data.'&mode=forumedit&a=delcat&id='.$forder['id'].'">delete</a></span></td></tr></table></li>';
	}
$wrt	.=	'';
$wrt	.=	'</ul>';
$wrt	.=	'</td><td>';
$wrt	.=	'';
$wrt	.=	'';
if (isset($_GET['do']) && $_GET['do']=='add'){
	$wrt	.=	'<form method="post" action="'.$module_data.'&mode=forumadd&a=cat" name="addcat"><table border="0" cellspacing="0" cellpadding="0">';
	$wrt	.=	'<tr><td class="left">Title</td><td class="left"><input type="text" name="title"></td>';
	$wrt	.=	'<tr><td class="left">Description</td><td class="left"><textarea name="descr"></textarea></td>';
	$wrt	.=	'<tr><td class="left" colspan="2"><input type="checkbox" id="check" name="fordirs" value="1"/><label for="check">Director Only?</label> <input type="submit" value="Add"></td></tr>';
	$wrt	.=	'';
	$wrt	.=	'</table></form>';
}elseif (isset($_GET['do']) && $_GET['do']=='edit'){
	$edit_cat = good_query_assoc("SELECT * FROM forum_cat WHERE id='".$_GET['id']."'");
	$wrt	.=	'<form method="post" action="'.$module_data.'&mode=forumedit&a=editcat" name="editcat"><table border="0" cellspacing="0" cellpadding="0">';
	$wrt	.=	'<tr><td class="left">Title</td><td class="left"><input type="text" name="title" value="'.$edit_cat['cat_name'].'"></td>';
	$wrt	.=	'<tr><td class="left">Description</td><td class="left"><textarea name="descr">'.$edit_cat['cat_descr'].'</textarea></td>';
	if ($edit_cat['cat_isdir']){$chck_isdir=' checked';}else{$chck_isdir='';}
	$wrt	.=	'<tr><td class="left" colspan="2"><input type="checkbox" id="check" name="fordirs" value="1"/'.$chck_isdir.'><label for="check">Director Only?</label> <input type="hidden" name="id" value="'.$edit_cat['id'].'"><input type="submit" value="Update"></td></tr>';
	$wrt	.=	'';
	$wrt	.=	'</table></form>';
}
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</td></tr>';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';

$wrt	.=	'</table>';

echo $wrt;
?>