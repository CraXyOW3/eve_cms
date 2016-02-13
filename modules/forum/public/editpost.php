<?php
require_once('./includes/include_editor.php');
		if ($_GET['a']=='topic') {
			
					$sql="SELECT * FROM forum_thread WHERE id=".$_GET['id']."";
					$result=mysql_query($sql);
					while($rows=mysql_fetch_array($result)){
						
		echo		'<p>&nbsp;</p><form id="form1" name="form1" method="post" action="'.$module_data.'&mode=forumedit&a=topic"><table cellspacing="0" cellpadding="0" border="0" class="center" width="90%">
					<tr>
						<th width="30%" rowspan="4" class="nob">&nbsp;</th><th class="ft_head" colspan="2">Edit Topic</th>
					</tr>
					<tr>
						<td class="tright">Topic</td><td class="tleft"><input value="'.$rows['topic'].'" name="topic" type="text" id="topic" size="50" /></td>
					</tr>
					<tr>
						<td class="tright">Detail</td><td class="tleft"><textarea name="detail" cols="70" rows="10" id="editor">'.$rows['detail'].'</textarea></td>
					</tr>
					<tr>';
			if ($isDirector && (isset($_GET['a']) && $_GET['a']=='directors')) {
				echo '<td class="bsmall"><input type="hidden" id="check" name="fordirs" value="y" />&nbsp;</td>';
			}else{
				echo '<td class="bsmall">&nbsp;</td>';
			}
		//			if ($rows['fordirs']=='1') {$cbox=' checked="yes"';}else{$cbox='';}
		//			if ($isDirector) {echo '<td class="bsmall"><input type="checkbox" id="check" name="fordirs" value="y"'.$cbox.' /><label for="check">For Directors Only?</a></td>';} else {echo '<td>&nbsp;</td>';}
		echo		'	<td><input type="hidden" value="'.$rows['id'].'" name="id"><input type="hidden" value="'.$_GET['pid'].'" name="pid"><input class="ld" type="submit" name="Submit" value="Submit"></td>
					</tr>
					</table>
					</form>';
					}
			} elseif ($_GET['a']=='post') {
					$sql="SELECT * FROM forum_posts WHERE a_id=".$_GET['aid']." AND question_id=".$_GET['qid']."";
					$result=mysql_query($sql);
						while($rows=mysql_fetch_array($result)){
			echo		'<p>&nbsp;</p><form name="form1" method="post" action="'.$module_data.'&mode=forumedit&a=post"><table cellspacing="0" cellpadding="0" border="0" class="center" width="80%">
						<input name="aid" type="hidden" value="'.$rows['a_id'].'">
						<input name="qid" type="hidden" value="'.$rows['question_id'].'">
						<tr>
							<th width="50%" rowspan="3" class="nob">&nbsp;</th><th class="ft_head">Edit Reply</th>
						</tr>
						<tr>
							<td><textarea name="a_answer" cols="100" rows="5" id="editor">'.$rows['a_answer'].'</textarea></td>
						</tr>
						<tr>
							<td><input type="submit" name="Reply" value="Submit"></td>
						</tr>
						</table>
						</form>';
						}
					}
?>