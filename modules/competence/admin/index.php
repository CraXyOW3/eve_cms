<?php
include('modules/competence/config.php');
$wrt_script = '<script type="text/javascript">
	$(document).ready(function()
	{ShowActionOnOver();
		$(".h_act",this).hide(); // hide all
	});
	function ShowActionOnOver()
	{
		$(".h_act_cont").hover(
			function()
			{$(".h_act",this).show();},
			function()
			{$(".h_act",this).hide();}
		);
	}
	</script>
	<script type="text/javascript">
       $(document).ready(function(){
		$(".hilite").hover(function(){
			$(this).children().addClass("datahighlight");
		},function(){
			$(this).children().removeClass("datahighlight");
		});
      });
	</script>
	<script type="text/javascript">
	$(document).ready(function() {
	  $("a.actions").cluetip({
		width: 100,
		arrows:true,
		splitTitle: "|",
		sticky: true,
		mouseOutClose: true,
		showTitle: false,
		closeText: ""
	  });
	});
	</script>';

if(!isset($_GET['do'])){
	$htitle='Viewing Competence Groups';
	$vlink=' class="ot_sel"';
	$glink='';
	$plink='';
}elseif($_GET['do']=='grp'){
	$htitle='Add Competence Group';
	$vlink='';
	$glink=' class="ot_sel"';
	$plink='';
}elseif($_GET['do']=='pre'){
	$htitle='Add Competence Group';
	$vlink='';
	$glink='';
	$plink=' class="ot_sel"';
}


$wrt = $wrt_script . wrt_table(0,0,1,'100%','center');
$wrt .= '<tr>';
$wrt .= '<th class="ft_head" colspan="2">Competence Admin</th>';
$wrt .= '</tr>';
$wrt .= '<tr>';
$wrt .= '<td width="100">';
	$wrt .= wrt_table(0,0,0,'100%');
	$wrt .= '<tr><td class="ft_head">Action</td></tr>';
	$wrt .=	'<tr><td'.$vlink.'><a href="'.$module_admin.'">View</a></td></tr>';
	$wrt .=	'<tr><td'.$glink.'><a href="'.$module_admin.'&do=grp">Groups</a></td></tr>';
	$wrt .=	'<tr><td'.$plink.'><a href="'.$module_admin.'&do=pre">Prereqs</a></td></tr>';
	$wrt .= '</table>';
$wrt .= '</td>';
$wrt .= '<td>';
//------------------------------- Content Start
	if(!isset($_GET['do'])){
		$wrt .= wrt_table(0,0,0,'100%');
		$wrt .= '<tr><td class="ft_head">Admin Diagram</td></tr>';
		$wrt .=	'<tr><td>content</td></tr>';
		$wrt .= '</table>';
	}elseif($_GET['do']=='grp'){
			if(!isset($_GET['a'])){
				$wrt_g = '<form action="./?module=data&part=competence&s=group" method="post">Group Name: <input type="text" name="grp_name"> <input type="submit" value="Add"></form>';
				$stitle = 'Add Group';
			}elseif(isset($_GET['a']) && $_GET['a']=='edit'){
				$get_id = mysql_escape_string($_GET['id']);
				$sql_ed_grp = good_query_assoc("SELECT * FROM comp_grp WHERE comp_grp_id=$get_id");
				$wrt_g = '<form action="./?module=data&part=competence&s=groupupd" method="post">Group Name: <input type="text" name="grp_name" value="'.$sql_ed_grp['comp_grp_name'].'"><input type="hidden" name="grp_id" value="'.$sql_ed_grp['comp_grp_id'].'"> <input type="submit" value="Update"></form>';
				$stitle = 'Edit Group';
			}else{
				$wrt_g = '';
				$stitle = '&nbsp;';
			}
		$wrt .= wrt_table(0,0,0,'100%');
		$wrt .= '<tr><td class="ft_head">Groups</td><td class="ft_head">'.$stitle.'</td></tr>';
			$comp_groups = good_query_table("SELECT * FROM comp_grp");
				$wrt .= '<tr><td width="150">' . wrt_table(0,0,0,'100%');
				foreach($comp_groups as $cgrp){
					if(isset($_GET['id']) && $_GET['id']==$cgrp['comp_grp_id']){$cglink=' class="ot_sel"';$cglink2=' ot_sel';}else{$cglink='';$cglink2='';}
					//$wrt .= '<tr class="hilite"><td'.$cglink.'><div class="h_act_cont">'.$cgrp['comp_grp_name'].'<div class="h_act">&nbsp;&nbsp;<a href="'.$module_admin.'&do=grp&a=edit&id='.$cgrp['comp_grp_id'].'">Edit</a> | <a href="">Delete</a></div></div></td></tr>';
					$wrt .= '<tr class="hilite"><td'.$cglink.'><a class="actions" title="<a href=\''.$module_admin.'&do=grp&a=edit&id='.$cgrp['comp_grp_id'].'\'>Edit</a> | <a href=\'\'>Delete</a>">'.$cgrp['comp_grp_name'].'</a></td></tr>';
				}
				$wrt .= '</table></td><td>'.$wrt_g.'</td></tr>';
		$wrt .= '</table>';
	}elseif($_GET['do']=='pre'){
		$wrt .= wrt_table(0,0,0,'100%');
		$wrt .= '<tr><td class="ft_head">Prereq\'s for Groups</td><td class="ft_head">Current Skills</td><td class="ft_head">Addable</td><td class="ft_head">Subskills</td></tr>';
		//$wrt .=	'<tr><td>content</td></tr>';
			$comp_groups = good_query_table("SELECT * FROM comp_grp");
				$wrt .= '<tr>';
				$wrt .= '<td width="150">' . wrt_table(0,0,0,'100%');
				foreach($comp_groups as $cgrp){
					if(isset($_GET['id']) && $_GET['id']==$cgrp['comp_grp_id']){$cglink=' class="ot_sel"';$cglink2=' ot_sel';}else{$cglink='';$cglink2='';}
					$wrt .= '<tr class="hilite"><td'.$cglink.'><a href="'.$module_admin.'&do=pre&a=edit&id='.$cgrp['comp_grp_id'].'">'.$cgrp['comp_grp_name'].'</a></td></tr>';
				}
				$wrt .= '</table></td>';
					//CURRENT SKILLS SET
						$wrt .= '<td width="280">';
						if(isset($_GET['a']) && $_GET['a']=='edit'){
							$comp_id = mysql_escape_string($_GET['id']);
							$sql_currskill = good_query_table("SELECT * FROM comp_table WHERE comp_id=$comp_id");
							if($sql_currskill){
								$wrt .= wrt_table(0,0,0,'100%');
									if(isset($_GET['gid'])){$redlnk='&gid='.$_GET['gid'];}else{$redlnk='';}
								foreach($sql_currskill as $skset){
									$wrt .= '<tr><td><a class="actions" title="<a href=\''.$module_data.'&s=delsubskill&skill_id='.$skset['id'].'&id='.$_GET['id'].$redlnk.'\'>Remove</a>">'.get_name($skset['skill_id']).'</a></td><td>'.$skset['skill_lvl'].'</td></tr>';
								}
								$wrt .= '</table>';
							}else{$wrt .= 'No prereq\'s set.';}
							//$wrt .=
						}
						$wrt .= '</td>';
					//ADDABLE SKILLS SET
						$wrt .= '<td width="200">';
							if(isset($_GET['a']) && $_GET['a']=='edit'){
								$m_group = good_query_table("SELECT groupID,groupName AS groupName FROM eve_db_invgroups WHERE categoryID = 16 AND published = 1 ORDER BY groupName;");
								$wrt .= wrt_table(0,0,0,'100%');
								foreach($m_group as $m_grp){
									if(isset($_GET['gid']) && $_GET['gid']==$m_grp['groupID']){$glink=' class="ot_sel"';}else{$glink='';}
									$wrt	.=	'<tr><td'.$glink.'><a href="'.$module_admin.'&do=pre&a=edit&id='.$_GET['id'].'&gid='.$m_grp['groupID'].'">'.$m_grp['groupName'].'</a></td></tr>';
								}
								$wrt .= '</table>';
							}
						$wrt .= 'asdasd';
						$wrt .= '</td>';
					//SUBSKILLS SET
						$wrt .= '<td>';
							if(isset($_GET['a']) && $_GET['a']=='edit'){
								if(isset($_GET['gid'])){
								$i=0;
								$sub_groups = $_GET['gid'];
								$grouptypes = good_query_table("SELECT * FROM eve_db_invtypes WHERE groupID=".$sub_groups." AND published=1 ORDER BY typeName ASC");
									$wrt .= wrt_table(0,0,0,'100%');
									$wrt .= '<tr><td><form action="./?module=data&part=competence&s=skill" method="post">';
									$wrt .=	'<select rows="30" name="c_skill">';
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
							}
						$wrt .= '</td>';
				$wrt .= '</tr>';
		$wrt .= '</table>';
	}
//------------------------------- Content End
$wrt .= '</td>';
$wrt .= '</tr>';
$wrt .= '</table>';
$wrt .= '';
$wrt .= '';
$wrt .= '';
$wrt .= '';
$wrt .= '';
$wrt .= '';















echo $wrt;
?>