<?php
include('modules/competence/config.php');
if(!isset($_GET['do'])){
	$htitle='Viewing Competence Groups';
	$vlink=' class="ot_sel"';
	$alink='';
}else{
	$htitle='Add Competence Group';
	$vlink='';
	$alink=' class="ot_sel"';
}
$wrt	=	'';
$wrt	.=	wrt_table(0,0,0,'100%','center');
$wrt	.=	'<tr>';
$wrt	.=	'<th class="ft_head">'.$htitle.'</th>';
$wrt	.=	'</tr>';
$wrt	.=	'</table>';
$wrt	.=	wrt_table(0,0,0,'100%','center');
$wrt	.=	'<tr>';
$wrt	.=	'	<td width="100">';
$wrt	.=	'		'.wrt_table(0,0,0,'100%');
$wrt	.=	'			<tr><td class="ft_head">Action</td></tr>';
$wrt	.=	'			<tr>';
$wrt	.=	'				<td'.$vlink.'><a href="'.$module_admin.'">View</a></td>';
$wrt	.=	'			</tr><tr>';
$wrt	.=	'				<td'.$alink.'><a href="'.$module_admin.'&do=grp">Groups</a></td>';
$wrt	.=	'			</tr>';
$wrt	.=	'		</table>';
$wrt	.=	'	</td>';
$wrt	.=	'	<td>';
$wrt	.=	'		'.wrt_table(0,0,1,'100%');
$wrt	.=	'			<tr>';
$wrt	.=	'				<td width="250">';
								if(isset($_GET['do']) && $_GET['do']=='add'){
									$wrt .= wrt_table(0,0,0,'100%');
										foreach($skillgrps as $sgroups){
											$groupname = good_query_assoc("SELECT typeName,typeID,groupID FROM eve_db_invtypes WHERE groupID=".$sgroups." AND published=1");
											if(isset($_GET['gid']) && $_GET['gid']==$groupname['groupID']){$glink=' class="ot_sel"';}else{$glink='';}
											$wrt	.=	'<tr><td'.$glink.'><a href="'.$module_admin.'&do=add&gid='.$groupname['groupID'].'">'.$groupname['typeName'].'</a></td></tr>';
										}
									$wrt .= '</table>';
								}elseif(isset($_GET['do']) && $_GET['do']=='grp'){
									$wrt .= wrt_table(0,0,0,'100%','center');
									$wrt .= '<tr>';
									$wrt .= '<td class="ft_head">Groups</td><td class="ft_head font_s right"><a href="'.$module_admin.'&do=grp&a=add">Add Group</a></td>';
									$wrt .= '</tr>';
										$comp_groups = good_query_table("SELECT * FROM comp_grp");
										foreach($comp_groups as $cgrp){
											if(isset($_GET['id']) && $_GET['id']==$cgrp['comp_grp_id']){$cglink=' class="ot_sel"';$cglink2=' ot_sel';}else{$cglink='';$cglink2='';}
											$wrt .= '<tr><td'.$cglink.'><a href="'.$module_admin.'&do=grp&a=view&id='.$cgrp['comp_grp_id'].'">'.$cgrp['comp_grp_name'].'</a></td><td class="right font_s'.$cglink2.'">(<a href="'.$module_admin.'&do=grp&a=edit&id='.$cgrp['comp_grp_id'].'">edit</a>) (<a href="">delete</a>)</td></tr>';
										}
									$wrt .= '';
									$wrt .= '</table>';
								}
$wrt	.=	'				</td>';
$wrt	.=	'				<td>';
							if(isset($_GET['a']) && $_GET['a']=='add'){
								$wrt .= wrt_table(0,0,0,'100%');
								$wrt .= '<tr><td class="ft_head">Adding Group Name</td></tr>';
								$wrt .= '<tr><td><form action="./?module=data&part=competence&s=group" method="post">';
								$wrt .= 'Group Name: <input type="text" name="grp_name"> <input type="submit" value="Add">';
								$wrt .= '</form></td></tr>';
								$wrt .= '</table>';
							}elseif(isset($_GET['a']) && $_GET['a']=='view'){
								$wrt .= wrt_table(0,0,0,'100%');
								$wrt .= '<tr><td class="ft_head">Current Prereq\'s</td></tr>';
									$preqs = good_query_table("SELECT * FROM comp_table");
										foreach($preqs as $p){
											
										}
								$wrt .= '</table>';
							}elseif(isset($_GET['a']) && $_GET['a']=='edit2'){
								$wrt .= wrt_table(0,0,0,'200');
								$wrt .= '<tr><td class="ft_head">edit</td></tr>';
									//$wrt .= wrt_table(0,0,0,'200');
										foreach($skillgrps as $sgroups){
											//$groupname = good_query_assoc("SELECT typeName,typeID,groupID FROM eve_db_invtypes WHERE groupID=".$sgroups." AND published=1");
											//if(isset($_GET['gid']) && $_GET['gid']==$groupname['groupID']){$glink=' class="ot_sel"';}else{$glink='';}
											//$wrt	.=	'<tr><td'.$glink.'><a href="'.$module_admin.'&do=grp&a=edit&id='.$_GET['id'].'&gid='.$groupname['groupID'].'">'.$groupname['typeName'].'</a></td></tr>';
										}
									//$wrt .= '</table>';
								$wrt .= '</table>';
							}elseif(isset($_GET['a']) && $_GET['a']=='edit'){
								$wrt .= wrt_table(0,0,0,'200');
								$wrt .= '<tr><td class="ft_head">edit</td></tr>';
									//$wrt .= wrt_table(0,0,0,'200');
										//$groupname = good_query_assoc("SELECT typeName,typeID,groupID FROM eve_db_invtypes WHERE groupID=".$sgroups." AND published=1");
										//if(isset($_GET['gid']) && $_GET['gid']==$groupname['groupID']){$glink=' class="ot_sel"';}else{$glink='';}
										//$wrt	.=	'<tr><td'.$glink.'><a href="'.$module_admin.'&do=grp&a=edit&id='.$_GET['id'].'&gid='.$groupname['groupID'].'">'.$groupname['typeName'].'</a></td></tr>';
										$m_group = good_query_table("SELECT groupID,groupName AS groupName FROM eve_db_invgroups WHERE categoryID = 16 AND published = 1 ORDER BY groupName;");
										//$wrt	.=	'<tr><td'.$glink.'><a href="'.$module_admin.'&do=grp&a=edit&id='.$_GET['id'].'&gid='.$m_group['groupID'].'">'.$m_group['typeName'].'</a></td></tr>';
										foreach($m_group as $m_grp){
											if(isset($_GET['gid']) && $_GET['gid']==$m_grp['groupID']){$glink=' class="ot_sel"';}else{$glink='';}
											$wrt	.=	'<tr><td'.$glink.'><a href="'.$module_admin.'&do=grp&a=edit&id='.$_GET['id'].'&gid='.$m_grp['groupID'].'">'.$m_grp['groupName'].'</a></td></tr>';
										}
									//$wrt .= '</table>';
								$wrt .= '</table>';
							}
$wrt	.=	'				</td>';
//$wrt .= '<td>asdasd</td>';
$wrt	.=	'			<td>';
							if(isset($_GET['gid'])){
							$i=0;
							$sub_groups = $_GET['gid'];
							$grouptypes = good_query_table("SELECT * FROM eve_db_invtypes WHERE groupID=".$sub_groups." AND published=1");
								$wrt .= wrt_table(0,0,0,'100%');
								$wrt .= '<tr><td class="ft_head">Skill</td></tr>';
								$wrt .= '<tr><td><form action="./?module=data&part=competence&s=skill" method="post">';
								$wrt .=	'<select name="c_skill">';
									foreach($grouptypes as $itum){
									$wrt	.=	'<option value="'.$itum['typeID'].'">';
									$wrt	.=	$itum['typeName'];
									$wrt	.=	'</option>';
									}
								$wrt .=	'</select>';
								$wrt .= '<select name="c_lvl">';
									while($i<=5){
										$wrt .= '<option value="'.$i.'">' . $i . '</option>';
										$i++;
									}
								$wrt .= '</select>';
								$wrt .= '<input type="hidden" name="id" value="'.$_GET['id'].'"><input type="hidden" name="gid" value="'.$_GET['gid'].'"><input type="submit" value="Add Skill"></form>';
								$wrt .= '</td></tr>';
								$wrt .= '</table>';
							}
$wrt	.=	'			</td>';
$wrt	.=	'		</tr>';
$wrt	.=	'	</table>';
$wrt	.=	'</td>';
$wrt	.=	'</tr>';
$wrt	.=	'</table>';
$wrt	.=	'</table>';
$wrt	.=	'';
$wrt	.=	'';


echo $wrt;
echo '<hr>';

$wrt = wrt_table(0,0,0,'100%');
$wrt .= '<tr>';
$wrt .= '<td>asdasd';
$wrt .= '</td>';
$wrt .= '</tr>';
$wrt .= '</table>';



echo $wrt;
?>