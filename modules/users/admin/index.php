<?php

$wrt	=	'';
$sqlmembers = good_query_table("SELECT * FROM corp_members ORDER BY char_name ASC");



$wrt	=	wrt_table(0,0,0,$tblWidth,'center');
$wrt	.=	'<tr><th class="left ft_head">List of Members</th></tr></table>';
$wrt	.=	'';
$wrt	.=	wrt_table(0,0,0,$tblWidth,'center','table_id');
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'<tr>';
$wrt	.=	'<td class="ft_head">Name</td>';
$wrt	.=	'<td class="ft_head" width="120">Verified Status</td>';
$wrt	.=	'<td class="ft_head" width="120">Global PWD Set</td>';
$wrt	.=	'<td class="ft_head" width="120">Site Admin</td>';
$wrt	.=	'</tr>';
$wrt	.=	'';
foreach($sqlmembers as $mem){
if(!empty($mem['sec_ip'])){$verified='yes';}else{$verified='no';}
if(!empty($mem['sec_global_pwd'])){$gpwd='yes';}else{$gpwd='no';}
if(!empty($mem['sec_site_admin'])){$adm='yes';}else{$adm='no';}
if($mem['char_role']=='9223372036854775807' && $mem['char_id']!=$G_site_admin){
	if ($mem['sec_site_admin']){
		$siterole=' <a href="./?module=data&part=users&a=remove&id='.$mem['char_id'].'">Remove Access</a>';
	}else{
		$siterole=' <a href="./?module=data&part=users&a=give&id='.$mem['char_id'].'">Give Access</a>';
	}
}elseif($mem['char_role']=='9223372036854775807' && $mem['char_id']==$G_site_admin){
	$siterole=' Main';
}else{
	$siterole=' No Access';
}
$wrt	.=	'<tr class="hilite">';
$wrt	.=	'<td>'.$mem['char_name'].'</td>';
$wrt	.=	'<td>'.show_status('yn',$verified).'</td>';
$wrt	.=	'<td>'.show_status('yn',$gpwd).'</td>';
$wrt	.=	'<td>'.show_status('yn',$adm).''.$siterole.'</td>';


$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</td>';
}




$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</table>';
$wrt	.=	'
<script type="text/javascript">
       $(document).ready(function(){
		$(\'.hilite\').hover(function(){
			$(this).children().addClass(\'datahighlight\');
		},function(){
			$(this).children().removeClass(\'datahighlight\');
		});
      });
</script>
';


echo $wrt; $wrt = null;
?>