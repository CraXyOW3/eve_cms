<?php
require_once($module_dir.'bulletin/config.php');


echo	'<p>&nbsp;</p>';
if (!isset($_GET['mode'])){

$getNOPages = good_query_assoc("SELECT bulletins FROM settings LIMIT 1");
$bulletin_limit=$getNOPages['bulletins'];
$result = good_query("SELECT *, DATE_FORMAT(postdate,'%Y-%m-%d') AS date FROM bulletin ORDER BY postdate DESC LIMIT $bulletin_limit");
echo	'<table class="center" width="'.$tblWidth.'"><tr><td class="left"><div id="accordion" style="width:100%;">';
while ($row = mysql_fetch_array($result))
{
//if ($isDirector) {$editpanel = '<hr><span class="edit"><a href="'.$root_url.'&mode=edit&id='.$row['id'].'">edit</a></span>&nbsp;<span class="del"><a id="opener" href="./?p=data&mode=bulletin&a=delete&id='.$row['id'].'">delete</a></span>';} else {$editpanel ='';}
echo	'<h3><a href="#"><div><span>'.$row['title'].'</span><span class="right">'.$row['author'].' | '.date('Y-m-d',strtotime($row['postdate'])).'&nbsp;&nbsp;&nbsp;</span></div></a></h3>
		<div><span class="btext">'.$row['content'].'</span></div>';
//if ($admin == true) {echo '<tr><td class="tleft" colspan="2"><a href="./?p=bulletin&s=edit&id='.$row['id'].'"><img src="database_edit.png" class="nob"></a><a href="./?p=bulletin&s=delete&id='.$row['id'].'"><img src="database_delete.png" class="nob"></a></td></tr>';} // ############################ ADMIN CHECK
//if ($admin == true) {echo '<tr><td class="tleft" colspan="2"><span class="edit"><a href="./?p=bulletin&s=edit&id='.$row['id'].'">edit</a></span>&nbsp;<span class="del"><a id="opener" href="./?p=bulletin_data&a=delete&id='.$row['id'].'">delete</a></span></td></tr>';} // ############################ ADMIN CHECK
//echo	'</table>';
//echo	'<p>&nbsp;</p>';
}
echo	'</div></td></tr></table>';
// ############################################################## NEW WAY EOF
}
?>