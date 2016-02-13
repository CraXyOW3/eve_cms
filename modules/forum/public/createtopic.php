<?php
$pid=mysql_escape_string($_GET['id']);
require_once('./includes/include_editor.php');
echo		'<p>&nbsp;</p><form id="form1" name="form1" method="post" action="'.$module_data.'&mode=forumadd&a=topicadd"><table cellspacing="0" cellpadding="0" border="0" class="center" width="90%">
			<tr>
				<th width="30%" rowspan="4" class="nob">&nbsp;</th><th class="ft_head" colspan="2">Create New Topic</th>
			</tr>
			<tr>
				<td class="tright">Topic</td><td class="tleft"><input name="topic" type="text" id="topic" size="50" /></td>
			</tr>
			<tr>
				<td class="tright">Detail</td><td class="tleft"><textarea name="detail" cols="70" rows="10" id="editor"></textarea></td>
			</tr>
			<tr>';
	//if ($isDirector && (isset($_GET['a']) && $_GET['a']=='directors')) {}
			if ($isDirector && (isset($_GET['a']) && $_GET['a']=='directors')) {
				echo '<td class="bsmall"><input type="hidden" id="check" name="fordirs" value="y" />&nbsp;</td>';
			}else{
				echo '<td class="bsmall">&nbsp;</td>';
			}
echo		'	<td><input name="pid" type="hidden" value="'.$pid.'"><input type="submit" name="Submit" value="Submit"></td>
			</tr>
			</table>
			</form>';
?>