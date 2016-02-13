<?php
//session_start();
//page2DBv2();
echo alert_check();
	/*
		Place code to connect to your DB here.
	*/
//unset($_SESSION['memorder']);
if (!isset($_SESSION['memorder'])){
	$_SESSION['memorder']='char_name';
}else{
	if (isset($_GET['order']) && $_GET['order']=='name'){
		$_SESSION['memorder']='char_name';
	}elseif (isset($_GET['order']) && $_GET['order']=='logon'){
		$_SESSION['memorder']='char_log_on';
	}elseif (isset($_GET['order']) && $_GET['order']=='role'){
		$_SESSION['memorder']='char_role';
	}
}
if ($_SESSION['memorder']=='char_name'){$selN=' selected';$selL='';$selR='';}
if ($_SESSION['memorder']=='char_log_on'){$selN='';$selL=' selected';$selR='';}
if ($_SESSION['memorder']=='char_role'){$selN='';$selL='';$selR=' selected';}


if (!isset($_SESSION['memsort'])){
	$_SESSION['memsort']='DESC';
}else{
	if (isset($_GET['sort']) && $_GET['sort']=='de'){
		$_SESSION['memsort']='DESC';
	}elseif (isset($_GET['sort']) && $_GET['sort']=='as'){
		$_SESSION['memsort']='ASC';
	}
}
if ($_SESSION['memsort']=='DESC'){$selD=' selected';$selA='';}
if ($_SESSION['memsort']=='ASC'){$selD='';$selA=' selected';}
	$tbl_name="corp_members";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 3;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];
	
	/* Setup vars for query. */
	$targetpage = "./?module=userlist"; 	//your file name  (the name of this file)
	$getNOPages = good_query_assoc("SELECT pages_members FROM settings LIMIT 1");
	$limit = $getNOPages['pages_members']; 								//how many items to show per page
	if (isset($_GET['page'])) {
		$page = $_GET['page'];
		$pageO = '&page='.$page;
	} else {
		$page = '1';
		$pageO = '';
	}
	//$page = $_GET['page'];
	if($page) 
		$start = ($page - 1) * $limit; 			//first item to display on this page
	else
		$start = 0;								//if no page var is given, set start to 0
	
	/* Get data. */
	$sql = "SELECT * FROM $tbl_name ORDER BY ".$_SESSION['memorder']." ".$_SESSION['memsort']." LIMIT $start, $limit";
	$result = mysql_query($sql);
	
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
					$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
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
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a href=\"$targetpage&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a href=\"$targetpage&page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a href=\"$targetpage&page=1\">1</a>";
				$pagination.= "<a href=\"$targetpage&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a href=\"$targetpage&page=$next\">next <img src=\"./img/rgt.png\"></a>";
		else
			$pagination.= "<span class=\"disabled\">next <img src=\"./img/rgt.png\"></span>";
		$pagination.= "</div>\n";		
	}

echo	'<select onchange="window.location=\'./?module=userlist'.$pageO.'&order=\'+this.value">
		<option value="0">- Order By -</option>
		<option value="name"'.$selN.'>Name</option>
		<option value="logon"'.$selL.'>Logon</option>
		<option value="role"'.$selR.'>Role</option>
		</select>';
echo	'<select onchange="window.location=\'./?module=userlist'.$pageO.'&sort=\'+this.value">
		<option value="0">- Sort By -</option>
		<option value="as"'.$selA.'>Ascending</option>
		<option value="de"'.$selD.'>Descending</option>
		</select>';



$wrt	=	'<table border="0" cellpadding="0" cellspacing="0" width="'.$tblWidth.'" class="center"><tr>';
$i=0;
		while($row = mysql_fetch_array($result))
		{
		$new_tr = ($i % 2) ? 'yes' : null;
if (strtotime($row['char_log_off']) < strtotime('-4 weeks')) {
	$charLastTimeC = 'red';
} elseif (strtotime($row['char_log_off']) < strtotime('-2 weeks')) {
	$charLastTimeC = 'orange';
} elseif (strtotime($row['char_log_off']) < strtotime('-1 weeks')) {
	$charLastTimeC = 'yellow';
} else {$charLastTimeC = 'green';}
if ($row['char_role'] == '0') {$checkRole = 'Initiate';} else {//$checkRole = 'Other';
	if( substr( dec2bin($row['char_role']), 0, 1 ) == 1 ) {$checkRole = 'Director';} else {$checkRole = 'Regular';}
}
$charLastTime = ceil((time() - strtotime($row['char_log_off']))/86400 );
			if ( $evenOdd ) {$odder = "even";}else{$odder = "odd";}
			$evenOdd = !$evenOdd;
$wrt	.=	'<td><table border="0" cellpadding="0" cellspacing="0" width="450">';
$wrt	.=	'<tr>';
$wrt	.=	'	<td class="tcell'.$odder.'" width="100" rowspan="5">'.ldimg($row['char_id'],'char','','border','64','64').'<br /><a class="jTip" name="CorpRoles!" id="crprls'.$i.'" href="./includes/rolecheck.php?width=300&crprl='.$row['char_role'].'">'.$checkRole.'</a></td>';
$wrt	.=	'	<td class="tright">Name</td>';
$wrt	.=	'	<td class="tleft"><a href="#" onclick="CCPEVE.showInfo(1377, '.$row['char_id'].')">'.$row['char_name'].'</td>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr>';
$wrt	.=	'	<td class="tright" width="60">Location</td>';
$wrt	.=	'	<td class="tleft"><a href="#<?php echo $charID; ?>" onclick="CCPEVE.showInfo(3867, '.$row['char_loc'].')">'.trim_text($row['char_loc_name'],35).'</a></td>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr>';
$wrt	.=	'	<td class="tright">Ship</td>';
$wrt	.=	'	<td class="tleft"><a href="#<?php echo $charID; ?>" onclick="CCPEVE.showInfo('.$row['char_ship'].')">'.get_name($row['char_ship']).'</a></td>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr>';
$wrt	.=	'	<td class="tright">Activity</td>';
$wrt	.=	'	<td class="tleft">On: '.$row['char_log_on'].'<br />Off: '.$row['char_log_off'].'</td>';
$wrt	.=	'</tr>';
$wrt	.=	'<tr>';
$wrt	.=	'	<td class="tright">Last Time</td>';
$wrt	.=	'	<td class="tleft txtcolor_'.$charLastTimeC.'">'.$row['char_log_off'] . ' : ' . $charLastTime.' days ago!</td>';
$wrt	.=	'</tr>';
$wrt	.=	'</table>';
$wrt	.=	'</td>';
$i++;
if ($new_tr) $wrt	.= '</tr><tr>';
		}
$wrt	.=	'</table>';
echo $wrt;

echo $pagination;
echo '<table cellpadding="0" cellspacing="0" border="0" class="center"><tr><td class="txtcolor_green">Within 1 week.</td><td class="txtcolor_yellow">Over 1 week.</td><td class="txtcolor_orange">Over 2 weeks.</td><td class="txtcolor_red">Over 4 weeks.</td></tr></table>';

?>