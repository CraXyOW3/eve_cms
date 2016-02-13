<script>
	$(function() {
		$( "input:submit, input:button").button();
		var icons = {
			header: "ui-icon-circle-arrow-e",
			headerSelected: "ui-icon-circle-arrow-s"
		};
		$( "#check" ).button();
		$( "#accordion" ).accordion({
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
	});

	$(function() {
		$('a#opener').click(function(e) {
		e.preventDefault();
			$( "#dialog-confirm" ).dialog('option', 'anchor', $(this).attr('href'));
			$( "#dialog-confirm" ).dialog( "open" );
			return false;
		});
	
		$( "#dialog-confirm" ).dialog({
			autoOpen: false,
			resizable: false,
			height:140,
			modal: true,
			buttons: {
				"Delete": function(event) {
					$(location).attr('href',$(this).dialog('option', 'anchor'));
					$( this ).dialog( "close" );
				},
				Cancel: function() {
					$( this ).dialog( "close" );
				}
			}
		});
	});
</script>
<?php
echo alert_check();

if (isset($_GET['a']) && $_GET['a']=='directors'){$sqlsel='1';$urlsel='&a=directors';$fd_color='fd';}else{$sqlsel='0';$urlsel='';$fd_color='';}
if ($isDirector && (isset($_GET['a']) && $_GET['a']=='directors')) {$strCreate=$module_public.'&mode=newtopic&id='.$_GET['id'].'&a=directors';}else{$strCreate=$module_public.'&mode=newtopic&id='.$_GET['id'].'';}
$id = mysql_escape_string($_GET['id']);
$forum_chck = good_query_assoc("SELECT * FROM forum_thread ORDER BY datetime ASC");
if (empty($forum_chck['topic'])){$wrt='No categories defined!<br />Define some in Forum Admin!';}else{
$forum_cat = good_query_assoc("SELECT * FROM forum_cat WHERE cat_isdir='".$sqlsel."' AND id=".$id." ORDER BY cat_order ASC");
$forum_thread = good_query_table("SELECT * FROM forum_thread WHERE fordirs='".$sqlsel."' ORDER BY datetime ASC");
$wrt	=	wrt_table(0,0,0,$tblWidth,'center');
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';



$wrt	.=	'<tr>';
$wrt	.=	'<th class="ft_head left" colspan="2">';
$wrt	.=	'<a class="ld" href="'.$module_public.'&mode=threads'.$urlsel.'&id='.$forum_cat['id'].'">';
$wrt	.=	'<a class="ld" href="'.$module_public.''.$urlsel.'">Forum</a> / '.$forum_cat['cat_name'];
$wrt	.=	'</a>';
$wrt	.=	'</th>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr><td class="left font_s">'.$forum_cat['cat_descr'].'</td><td class="right font_s"><a href="'.$strCreate.'">Create New Topic</a</td></tr>';
	$forum_sub_chck = good_query_assoc("SELECT * FROM forum_thread WHERE pid=".$forum_cat['id']." AND fordirs=".$sqlsel." ORDER BY datetime DESC");
	if (empty($forum_sub_chck['id'])){$wrt.='<tr><td class="font_s">No Threads Found</td></tr>';}else{
		$getNOPages = good_query_assoc("SELECT forum_threads FROM settings LIMIT 1");
		$forum_th = good_query_table("SELECT * FROM forum_thread WHERE pid='".$forum_cat['id']."' ORDER BY datetime DESC LIMIT ".$getNOPages['forum_threads']."");
			$wrt	.=	'<tr><td class="right" colspan="2">'.wrt_table(0,0,0,$tblWidth,'right');
			// PAGINATION START
				$adjacents = 3;
				$query = "SELECT COUNT(*) as num FROM forum_thread WHERE pid=".$forum_cat['id']." AND fordirs=".$sqlsel."";
				$total_pages = mysql_fetch_array(mysql_query($query));
				$total_pages = $total_pages['num'];

				/* Setup vars for query. */
				$targetpage = $module_public.'&mode=threads&id='.$id.'';
				$limit = $getNOPages['forum_threads'];
				if (isset($_GET['page'])) {
					$page = $_GET['page'];
				} else {
					$page = '1';
				}
				//$page = $_GET['page'];
				if($page){$start=($page-1)*$limit;}else{$start = 0;}
				$sql = "SELECT * FROM forum_thread WHERE pid=".$forum_cat['id']." AND fordirs=".$sqlsel." ORDER BY datetime DESC LIMIT $start, $limit";
				$result = mysql_query($sql);
				
				/* Setup page vars for display. */
				if ($page == 0) $page = 1;
				$prev = $page - 1;
				$next = $page + 1;
				$lastpage = ceil($total_pages/$limit);
				$lpm1 = $lastpage - 1;

				$pagination = "";
				if($lastpage > 1)
				{	
					$pagination .= "<div class=\"pagination\">";
					//previous button
					if ($page > 1) 
						$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$prev\"><img src=\"./img/lft.png\"> previous</a>";
					else
						$pagination.= "<span class=\"disabled\"><img src=\"./img/lft.png\"> previous</span>";	
					
					//pages	
					if ($lastpage < 7 + ($adjacents * 2))	//not enough pages to bother breaking it up
					{	
						for ($counter = 1; $counter <= $lastpage; $counter++)
						{
							if ($counter == $page)
								$pagination.= "<span class=\"current\">$counter</span>";
							else
								$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$counter\">$counter</a>";					
						}
					}
					elseif($lastpage > 5 + ($adjacents * 2))	//enough pages to hide some
					{
						//close to beginning; only hide later pages
						if($page < 1 + ($adjacents * 2))		
						{
							for ($counter = 1; $counter < 4 + ($adjacents * 2); $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$counter\">$counter</a>";					
							}
							$pagination.= "...";
							$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$lpm1\">$lpm1</a>";
							$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
						}
						//in middle; hide some front and some back
						elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
						{
							$pagination.= "<a class=\"ld\" href=\"$targetpage&page=1\">1</a>";
							$pagination.= "<a class=\"ld\" href=\"$targetpage&page=2\">2</a>";
							$pagination.= "...";
							for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
							{
								if ($counter == $page)
									$pagination.= "<span class=\"current\">$counter</span>";
								else
									$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$counter\">$counter</a>";					
							}
							$pagination.= "...";
							$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$lpm1\">$lpm1</a>";
							$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
						}
						//close to end; only hide early pages
						else
						{
							$pagination.= "<a class=\"ld\" href=\"$targetpage?page=1\">1</a>";
							$pagination.= "<a class=\"ld\" href=\"$targetpage?page=2\">2</a>";
							$pagination.= "...";
							for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
							{
								if ($counter == $page){
									$pagination.= "<span class=\"current\">$counter</span>";
								}else{
									$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
									}
							}
						}
					}
					
					//next button
					if ($page < $counter - 1){$pagination.= "<a href=\"$targetpage&page=$next\">next <img src=\"./img/rgt.png\"></a>";}else{$pagination.= "<span class=\"disabled\">next <img src=\"./img/rgt.png\"></span>";$pagination.= "</div>\n";}
				}
				while($row = mysql_fetch_array($result))
				{

				if ( $evenOdd ) {$odder = " bcelleven"; $splitter = false;}else{$odder = " bcellodd"; $splitter = true;}
				$evenOdd = !$evenOdd;
					$get_latest_post = good_query_assoc("SELECT a_datetime FROM forum_posts WHERE question_id=".$row['id']." ORDER BY a_datetime DESC LIMIT 1");
					$wrt	.=	'<tr><td class="left'.$odder.$fd_color.'" width="30%"><a class="ld" href="'.$module_public.'&mode=view'.$urlsel.'&pid='.$row['pid'].'&id='.$row['id'].'">'.$row['topic'].'</a> by '.$row['name'].'</td><td class="left'.$odder.$fd_color.'" width="20%">'.trim_text($row['detail'],20).'</td><td class="left'.$odder.$fd_color.'">'.$row['name'].'</td><td class="right'.$odder.$fd_color.'">'.substr($get_latest_post['a_datetime'],0,16).'</td></tr>';

				}
			// PAGINATION END
			$wrt	.=	'</table></td></tr>';
	}


$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'';
$wrt	.=	'</table>';


}
echo $wrt;
if (isset($pagination)){
echo $pagination;
}
//echo $pagination;
$wrt=null;

/*
if (isset($_GET['a']) && $_GET['a']=='directors'){$sqlsel='1';$urlsel='&a=directors';}else{$sqlsel='0';$urlsel='';}
 // show forum!

				if ($isDirector && (isset($_GET['a']) && $_GET['a']=='directors')) {$sql="SELECT * FROM forum_thread WHERE fordirs='1' AND pid='".$_GET['id']."' ORDER BY id DESC";} else {$sql="SELECT * FROM forum_thread WHERE fordirs='0' AND pid='".$_GET['id']."' ORDER BY id DESC";}
					//$sql="SELECT * FROM forum_thread ORDER BY id DESC";
					// OREDER BY id DESC is order result by descending
					$result=mysql_query($sql);
						
		$getMainCat = good_query_assoc("SELECT * FROM forum_cat WHERE id=".$_GET['id']."");
	$wrt	=		wrt_table(0,0,0,$tblWidth,'center');
	$wrt	.=		'<tr><th class="ft_head left"><a href="./?p=forum'.$urlsel.'">Forum</a> / '.$getMainCat['cat_name'].'</th></tr></table>';
	$wrt	.=		'';
	$wrt	.=		'';
	$wrt	.=		'';
	$wrt	.=		wrt_table(0,0,0,$tblWidth,'center');
	if ($isDirector) {$cols='7';} else {$cols='6';}
	$wrt	.=		'<tr><td colspan="'.$cols.'" style="text-align:right;"><a href="'.$strCreate.'">Create New Topic</a></td></tr>';
	$wrt	.=		'	<tr>';
	$wrt	.=		'		<th class="ft_head">Topic</th>';
	$wrt	.=		'		<th class="ft_head" width="100">Latest</th>';
	$wrt	.=		'		<th class="ft_head" width="120">Author</th>';
	$wrt	.=		'		<th class="ft_head" width="130">Date/Time</th>';
	$wrt	.=		'		<th class="ft_head" width="20">Views</th>';
	$wrt	.=		'		<th class="ft_head" width="20">Replies</th>';
	if ($isDirector) {$wrt .= '<th class="ft_head" width="20">Action</th>';}
	$wrt	.=		'	</tr>';
echo $wrt;
while($rows=mysql_fetch_array($result)){ // Start looping table row
					if ( $evenOdd ) {$odder = " bcelleven"; $splitter = false;}else{$odder = " bcellodd"; $splitter = true;}
					$evenOdd = !$evenOdd;
					$sqlatest = mysql_query('SELECT * FROM forum_posts WHERE question_id='.$rows['id'].' ORDER BY a_datetime DESC');
					$thisrow=mysql_fetch_array($sqlatest);
					$numrows = mysql_num_rows($sqlatest);
					$latestpage = ceil($numrows/$pageBreak);
						if ($latestpage > '1') {$latlnk=$curUrl.'&mode=view&id='.$rows['id'].'&page='.$latestpage.'#'.$thisrow['a_id'].'';} else {$latlnk=$curUrl.'&mode=view&id='.$rows['id'].'';}
						if (empty($thisrow['a_name'])) {$lname = 'No Answers';} else {$lname = '<a href="'.$latlnk.'">'.$thisrow['a_name'] . '</a>';}
						if ($rows['fordirs']=='1'){$fd_text='[Directors]';$fd_color='fd';}else{$fd_text='';$fd_color='';}
						if ($boardMode) {$delUrl='';}else{
							if ($isDirector && (isset($_GET['a']) && $_GET['a']=='directors')){$delUrl='&a=directors';}else{$delUrl='';}
						}
						if ($isDirector) {$delT = '<td class="bcell'.$odder.$fd_color.' bsmall"><span class="del"><a id="opener" href="./?p=data&mode=forumedit'.$delUrl.'&a=delete&id='.$rows['id'].'">delete</a></span></td>';} else {$delT = '';}
				echo	'<tr>
							<td class="inte bcell'.$odder.$fd_color.'"><a href="./?p=forum&mode=view'.$urlsel.'&pid='.$_GET['id'].'&id='.$rows['id'].'">'.$rows['topic'].'</a></td>
							<td class="bcell'.$odder.$fd_color.' bsmall bleft">'.$lname.'</td>
							<td class="bcell'.$odder.$fd_color.' bsmall bleft">'.$rows['name'].'</td>
							<td class="bcell'.$odder.$fd_color.' bsmall">'.substr($rows['datetime'],0,16).'</td>
							<td class="bcell'.$odder.$fd_color.' bsmall">'.$rows['view'].'</td>
							<td class="bcell'.$odder.$fd_color.' bsmall">'.$rows['reply'].'</td>
							'.$delT.'
						</tr>';
}
echo				'</table>';
echo	'<div id="dialog-confirm" title="Delete a Thread?">
			<p><span class="ui-icon ui-icon-alert" style="float:left; margin:0 7px 20px 0;"></span>This Thread will be permanently deleted and all answers connected to it cannot be recovered. Are you sure?</p>
		</div>';
*/
?>