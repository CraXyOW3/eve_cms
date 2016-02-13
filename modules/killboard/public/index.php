<?php
//page2DBv2();
$size_shp='32';
$size_cha='32';
$size_crp='32';
//session_start();
//echo alert_check();

echo	'
<script type="text/javascript" src="./js/jquery.blockUI.js"></script>
<script type="text/javascript">
function showUrlInDialog(url){
  var tag = $("<div></div>");
  $.ajax({
    url: url,
    success: function(data) {
      tag.html(data).dialog({
		resizable:false,
		width:700,
		modal: true
		}).dialog(\'open\');
    }
  });
}
</script>';

echo	'
<script type="text/Javascript">
function kbshow(title,mode,id){
    $(\'<div>\').dialog({
        modal: true,
		position: [\'center\',150],
		open: function ()
        {
			$(this).html(\'<p align="center"><img src="img/ghooloader2.gif" /></p>\');
            $(this).load(\''.$module_dir.'killboard/includes/kb_view.php?mode=\'+mode+\'&id=\' + id);
        },
        width: 700,
        title: title,
		show: "fade",
		hide: "fade"
    });
}
</script>
';
//include('./func/dna_kb_extract.php');



	/*
		Place code to connect to your DB here.
	*/

	$tbl_name="kb_kill";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$exclude1 = "WHERE ((corporationID NOT IN ('414596443')) or ('shipTypeID' NOT IN ('670')))";
	//$exclude2 = "WHERE (corporationID != '414596443' or 'shipTypeID' != '670')";
	//$exclude2 = "WHERE corporationID != '414596443'";
	//$exclude2 = "WHERE shipTypeID != '670'";
	$exclude2 = "WHERE corporationID != '414596443' AND shipTypeID != '670'";
	$query = "SELECT COUNT(*) as num FROM $tbl_name $exclude2";
	//$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = mysql_fetch_assoc(mysql_query($query));
	$total_pages = $total_pages['num'];

	/* Setup vars for query. */
	$targetpage = $module_public; 	//your file name  (the name of this file)
	$getNOPages = good_query_assoc("SELECT pages_kills FROM settings LIMIT 1");
	$limit = $getNOPages['pages_kills']; 								//how many items to show per page
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = '1';
	}
	//$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM $tbl_name $exclude2 ORDER BY kill_time DESC LIMIT $start, $limit";
	$result = mysql_query($sql);
	//$result = mysql_fetch_assoc(mysql_query($sql));
	
	/* Setup page vars for display. */
	if ($page == 0) $page = 1;					//if no page var is given, default to 1.
	$prev = $page - 1;							//previous page is page - 1
	$next = $page + 1;							//next page is page + 1
	$lastpage = ceil($total_pages/$limit);		//lastpage is = total pages / items per page, rounded up.
	$lpm1 = $lastpage - 1;						//last page minus 1
	
	/* 
		Now we apply our rules and draw the pagination object. 
		We're actually saving the code to a variable in case we want to draw it more than once.
	*/
	$pagination = "";
	if($lastpage > 1)
	{	
		$pagination .= "<div class=\"pagination\">";
		//previous button
		if ($page > 1) 
			$pagination.= "<a href=\"$targetpage&page=$prev\"><img src=\"./img/lft.png\"> previous</a>";
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
				$pagination.= "<a class=\"ld\" href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a class=\"ld\" href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a class=\"ld\" href=\"$targetpage&page=$next\">next <img src=\"./img/rgt.png\"></a>";
		else
			$pagination.= "<span class=\"disabled\">next <img src=\"./img/rgt.png\"></span>";
		$pagination.= "</div>\n";		
	}
$wrt	=	'<table border="0" width="'.$tblWidth.'" class="center collapse">';
		//while($row = mysql_fetch_array($result))
	$wrt	.=	'<tr><th class="ft_head" colspan="2">Ship Type</th><th class="ft_head">Pilot</th><th class="ft_head">Corporation</th><th class="ft_head">System</th><th class="ft_head">Time</th><th class="ft_head">Attackers</th></tr>';
		$i=0;
		while($row = mysql_fetch_assoc($result))
		{
		if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
		$evenOdd = !$evenOdd;
	$sql_grp = mysql_query ("SELECT fitt.tid AS type,grp.gname AS gname,grp.gid AS gid FROM fitt_dna_ships fitt, group_stuff grp WHERE fitt.tid = ".$row['shipTypeID']." AND fitt.gid=grp.gid") or die ('SQL GROUP Failed!');
	$row_grp = mysql_fetch_assoc ($sql_grp);
	$sql_shp = mysql_query ("SELECT name FROM fitt_dna_ships WHERE tid = ".$row['shipTypeID']."") or die ('SQL SHP Failed!');
	$row_shp = mysql_fetch_assoc ($sql_shp);
	$sql_sys = mysql_query ("SELECT ssname FROM solarsystems WHERE systemid = ".$row['sol_system']."") or die ('SQL SYS Failed!');
	$row_sys = mysql_fetch_assoc ($sql_sys);
	
	$wrt	.=	'';
	$wrt	.=	'<tr>';
		//$wrt	.=	'<td class="left tcell'.$odder.' font_s" width="'.$size_shp.'"><a class="jTip" onclick="CCPEVE.showInfo('.$row['shipTypeID'].')" name="'.$row_shp['name'].' - Items" id="kll'.$i.'" href="kb_viewer.php?mode=kill&id='.$row['killid'].'&db=ship&width=400">'.ldimg($row['shipTypeID'],'render','','kb_border').'</a></td>';
		//$wrt	.=	'<td class="left tcell'.$odder.' font_s" width="'.$size_shp.'" id="chartip"><span title="View Fitting"><a href="#" onclick="showUrlInDialog(\'includes/killboard/kb_view.php?mode=kill&id='.$row['killid'].'\'); return false;">'.ldimg($row['shipTypeID'],'render','','kb_border').'</a></span></td>';
	$wrt	.=	'<td class="left tcell'.$odder.' font_s" width="'.$size_shp.'" id="chartip"><span title="View Fitting"><a onclick="kbshow(\''.$row_shp['name'].'\',\'kill\',\''.$row['killid'].'\');" href="javascript:void(0)">'.ldimg($row['shipTypeID'],'render','','kb_border').'</a></span></td>' ."\n";
		//$wrt	.=	'<td class="left tcell'.$odder.' font_s"><a class="jTip" onclick="CCPEVE.showFitting(\''.getDNA($row['killid']).'\');" name="'.$row_shp['name'].' - Items" id="det'.$i.'" href="kb_viewer.php?mode=detail&id='.$row['killid'].'&db=ship&width=400">'.$row_shp['name'].'</a><br />'.$row_grp['gname'].'</td>';
	$wrt	.=	'<td class="left tcell'.$odder.' font_s" width="20%" id="chartip"><span title="Show Ship Information"><a class="jTip" onclick="CCPEVE.showInfo('.$row['shipTypeID'].')" href="javascript:void(0)">'.$row_shp['name'].'</a></span><br />'.$row_grp['gname'].'<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<span title="View Fitting"><a onclick="kbshow(\''.$row_shp['name'].'\',\'kill\',\''.$row['killid'].'\');" href="javascript:void(0)">View Fitting</a></span></td>';
		//$wrt	.=	'<td class="left"><img src="http://image.eveonline.com/Character/'.$row['characterID'].'_'.$size_cha.'.jpg" align="left">'.$row['characterName'].'<br />'.$row['corporationName'].'</td>';
		/*
			$wrt	.=	'<td class="tcell'.$odder.'">';
				$wrt	.=	'<table border="0" width="'.$tblWidth.'" class="collapse nomargin nopadding">';
				$wrt	.=	'<tr>';
				//$wrt	.=	'<td rowspan="2" width="'.$size_cha.'"><a class="jTip" onclick="CCPEVE.showInfo(1377, '.$row['characterID'].')" name="'. $row['characterName'] .'" id="chr'.$i.'" href="kb_viewer.php?mode=attackers&id='.$row['killid'].'&width=420">'.ldimg($row['characterID'],'char','','kb_border').'</a></td>';
				$wrt	.=	'<td rowspan="2" width="'.$size_cha.'"><a onclick="CCPEVE.showInfo(1377, '.$row['characterID'].')">'.ldimg($row['characterID'],'char','','kb_border').'</a></td>';
				$wrt	.=	'<td class="font_s left">'.$row['characterName'].'</td>';
				$wrt	.=	'<td rowspan="2" width="'.$size_crp.'" id="chartip"><span title="'.$row['corporationName'].'"><a name="'.$row['killid'].'" onclick="CCPEVE.showInfo(2, '.$row['corporationID'].')" style="cursor:hand;">'.ldimg($row['corporationID'],'corp','right','kb_border').'</a></span></td>';
				$wrt	.=	'</tr>';
				$wrt	.=	'<tr>';
				$wrt	.=	'<td class="font_s right">'.$row['corporationName'].'</td>';
				$wrt	.=	'</tr>';
				$wrt	.=	'</table>';
			$wrt	.=	'</td>';
		*/
	$wrt	.=	'<td class="left font_s tcell'.$odder.'" width="20%" id="chartip"><span title="View Characterinfo"><a href="javascript:void(0)" onclick="CCPEVE.showInfo(1377, '.$row['characterID'].')">'.ldimg($row['characterID'],'char','left','kb_border').'</a></span><span title="View Characterinfo"><a href="javascript:void(0)" onclick="CCPEVE.showInfo(1377, '.$row['characterID'].')">'.$row['characterName'].'</a></span></td>';
	$wrt	.=	'<td class="left font_s tcell'.$odder.'" width="20%" id="chartip"><span title="View Corporationinfo"><a href="javascript:void(0)" onclick="CCPEVE.showInfo(2, '.$row['corporationID'].')">'.ldimg($row['corporationID'],'corp','left','kb_border').'</a></span><span title="View Corporationinfo"><a href="javascript:void(0)" onclick="CCPEVE.showInfo(2, '.$row['corporationID'].')">'.$row['corporationName'].'</a></span></td>';
	$wrt	.=	'<td class="font_s tcell'.$odder.'" width="20%"><a href="javascript:void(0)" onclick="CCPEVE.showInfo(5, '.$row['sol_system'].')">'.$row_sys['ssname'].'</a></td>';
	$wrt	.=	'<td class="font_s tcell'.$odder.'" width="10%">'.date('Y.i.d',strtotime($row['kill_time'])).'<br />'.date('H:i',strtotime($row['kill_time'])).'</td>';
		//$wrt	.=	'<td class="font_s tcell'.$odder.'" id="chartip"><span title="View Attackers"><a href="#" onclick="showUrlInDialog(\'includes/killboard/kb_view.php?mode=attackers&id='.$row['killid'].'\'); return false;">'.ldimg($G_corpID,'corp','','kb_border').'</a></span></td>';
	$wrt	.=	'<td class="font_s tcell'.$odder.'" width="10%" id="chartip"><span title="View Attackers"><a href="#" onclick="kbshow(\'Attackers\',\'attackers\',\''.$row['killid'].'\'); return false;">'.ldimg($G_corpID,'corp','','kb_border').'</a></span></td>';
	$wrt	.=	'</tr>';
	$wrt	.=	'';
		$i++;
		}
$wrt	.=	'</table>';
echo	$wrt;
	?>

<?=$pagination?>
<p>&nbsp;</p>
<p class="notice">Tips: Hovering Ship will show fitting dial, hovering shiptype will show list of fitting, hovering victim will show attackers.<br />
Clicking Ship icon will show ships type info, clicking ship type will show it's fitting, clicking victim will show char info, clicking corporation will show corp info.<br />
<a href="http://eve.battleclinic.com/killboard/combat_record.php?type=corp&name=Gung-Ho#kills" target="_blank">Our BattleClinic Killoard</a></p>
