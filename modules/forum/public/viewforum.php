<?php
if (isset($_GET['a']) && $_GET['a']=='directors'){$sqlsel='1';$urlsel='&a=directors';$fd_color='fd';}else{$sqlsel='0';$urlsel='';$fd_color='';}

$forum_chck = good_query_assoc("SELECT * FROM forum_cat ORDER BY cat_order ASC");
if (empty($forum_chck['cat_name'])){$wrt='No categories defined!<br />Define some in Forum Admin!';}else{
$forum_cat = good_query_table("SELECT * FROM forum_cat WHERE cat_isdir='".$sqlsel."' ORDER BY cat_order ASC");
$wrt	=	wrt_table(0,0,0,$tblWidth,'center');
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';


foreach($forum_cat as $row){
$wrt	.=	'<tr>';
$wrt	.=	'<th class="ft_head left">';
$wrt	.=	'<a class="ld" href="'.$module_public.'&mode=threads'.$urlsel.'&id='.$row['id'].'">';
$wrt	.=	$row['cat_name'];
$wrt	.=	'</a>';
$wrt	.=	'</th>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr><td class="left font_s">'.$row['cat_descr'].'</td></tr>';
	$forum_sub_chck = good_query_assoc("SELECT * FROM forum_thread WHERE pid=".$row['id']." AND fordirs=".$sqlsel." ORDER BY datetime DESC");
	if (empty($forum_sub_chck['id'])){$wrt.='<tr><td class="font_s">No Threads Found</td></tr>';}else{
		$getNOPages = good_query_assoc("SELECT forum_overview FROM settings LIMIT 1");
		$forum_th = good_query_table("SELECT * FROM forum_thread WHERE pid='".$row['id']."' ORDER BY datetime DESC LIMIT ".$getNOPages['forum_overview']."");
			$wrt	.=	'<tr><td class="right">'.wrt_table(0,0,0,$tblWidth,'right');
				foreach($forum_th as $th){
				if ( $evenOdd ) {$odder = " bcelleven"; $splitter = false;}else{$odder = " bcellodd"; $splitter = true;}
				$evenOdd = !$evenOdd;
					$get_latest_post = good_query_assoc("SELECT a_datetime FROM forum_posts WHERE question_id=".$th['id']." ORDER BY a_datetime DESC LIMIT 1");
					$wrt	.=	'<tr><td class="left'.$odder.$fd_color.'" width="30%"><a class="ld" href="'.$module_public.'&mode=view'.$urlsel.'&pid='.$th['pid'].'&id='.$th['id'].'">'.$th['topic'].'</a></td><td class="left'.$odder.$fd_color.'" width="20%">'.trim_text($th['detail'],20).'</td><td class="left'.$odder.$fd_color.'">'.$th['name'].'</td><td class="right'.$odder.$fd_color.'">'.substr($get_latest_post['a_datetime'],0,16).'</td></tr>';
				}
			$wrt	.=	'</table></td></tr>';
	}
}

$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</table>';


}
echo $wrt;
$wrt=null;
?>