<?php
if (isset($_GET['a']) && $_GET['a']=='directors'){$sqlsel='1';$urlsel='&a=directors';}else{$sqlsel='0';$urlsel='';}
// ############################################################################################################################################
				$id=mysql_escape_string($_GET['id']);
				$pid=mysql_escape_string($_GET['pid']);

				$sql="SELECT * FROM forum_thread WHERE id='$id'";
				$result=mysql_query($sql);

				$rows=mysql_fetch_array($result);
		$getMainCat = good_query_assoc("SELECT * FROM forum_cat WHERE id=".$pid."");
	$wrt	=		wrt_table(0,0,0,$tblWidth,'center');
	$wrt	.=		'<tr><th class="ft_head left" colspan="2"><a class="ld" href="'.$module_public.''.$urlsel.'">Forum</a> / <a class="ld" href="'.$module_public.'&mode=threads'.$urlsel.'&id='.$pid.'">'.$getMainCat['cat_name'].'</a> / '.$rows['topic'].'</th></tr>';
	$wrt	.=		'<tr><td class="left font_s">'.$getMainCat['cat_descr'].'</td><td class="right font_s"><a href="#reply">Reply</a</td></tr><tr><td>&nbsp;</td></tr></table>';
	echo $wrt;
			/*
			echo	wrt_table(0,0,1,$tblWidth,'center').'
						<tr>
							<th class="ft_head" colspan="3">'.$rows['topic'].'</th>
						</tr>
						<tr><td width="64" class="bcell bcelleven"><img src="http://image.eveonline.com/Character/' . $rows['charid'] . '_64.jpg"></td><td class="intel bcell bcelleven">By '.$rows['name'].'</td><td class="bcell bcelleven">'.substr($rows['datetime'],0,16).'</td></tr>
						<tr><td class="intel bcell bcelleven" colspan="3">'.nl2br($rows['detail']).'</td></tr>';
				if ($getHeaderCharID == $rows['charid']) {echo '<tr><td class="intel "><span class="edit"><a href="'.$module_public.'&mode=edit&a=topic&id='.$rows['id'].'">edit</a></span></td></tr>';}
			*/
echo	wrt_table(0,0,0,$tblWidth,'center').'
						<tr>
							<th class="ft_head" colspan="3">'.$rows['topic'].'</th>
						</tr>
						<tr>
			<td width="64" rowspan="3" class="bcelleven"><img src="http://image.eveonline.com/Character/'.$rows['charid'].'_64.jpg"></td>
			<td class="intel bsmall bcelleven" width="150">Author: '.$rows['name'].'</td><td class="intel bcelleven" rowspan="3">'.nl2br($rows['detail']).'</td>
		</tr>
		<tr><td class="intel bsmall bcelleven">'.substr($rows['datetime'],0,16).'</td></tr>
		<tr><td class="intel bsmall bcelleven"><a href="#" onclick="CCPEVE.sendMail('.$rows['charid'].',\'RE: '.$rows['topic'].'\',\' \')">EVEMail</a></td></tr>';
		if ($getHeaderCharID == $rows['charid']) {echo '<tr><td class="intel "><span class="edit"><a class="ld" href="'.$module_public.'&mode=edit&a=topic&pid='.$pid.'&id='.$rows['id'].'">edit</a></span></td></tr>';}
			echo	'</table><p>&nbsp;</p>';

	$tbl_name="forum_posts";		//your table name
	// How many adjacent pages should be shown on each side?
	$adjacents = 2;
	
	/* 
	   First get total number of rows in data table. 
	   If you have a WHERE clause in your query, make sure you mirror it here.
	*/
	$query = "SELECT COUNT(*) as num FROM $tbl_name WHERE question_id='$id'";
	$total_pages = mysql_fetch_array(mysql_query($query));
	$total_pages = $total_pages['num'];

	/* Setup vars for query. */
	$targetpage = $module_public.'&mode=view&pid='.$pid; 	//your file name  (the name of this file)
	//$limit = 10;					//how many items to show per page
	$getNOPages = good_query_assoc("SELECT forum_posts FROM settings LIMIT 1");
	//$limit = $pageBreak;
	$limit = $getNOPages['forum_posts'];
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
	//$sql = "SELECT * FROM $tbl_name LIMIT $start, $limit WHERE question_id='$id'";
	$sql = "SELECT * FROM $tbl_name WHERE question_id='$id' LIMIT $start, $limit";
	$result = mysql_query($sql) or die($sql."<br/><br/>".mysql_error());
;
	
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
			$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$prev\"><img src=\"./img/lft.png\"> previous</a>";
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
					$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$counter\">$counter</a>";					
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
						$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$lastpage\">$lastpage</a>";		
			}
			//in middle; hide some front and some back
			elseif($lastpage - ($adjacents * 2) > $page && $page > ($adjacents * 2))
			{
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=1\">1</a>";
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $page - $adjacents; $counter <= $page + $adjacents; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a href=\"$targetpage&id=$id&page=$counter\">$counter</a>";					
				}
				$pagination.= "...";
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$lpm1\">$lpm1</a>";
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$lastpage\">$lastpage</a>";		
			}
			//close to end; only hide early pages
			else
			{
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=1\">1</a>";
				$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=2\">2</a>";
				$pagination.= "...";
				for ($counter = $lastpage - (2 + ($adjacents * 2)); $counter <= $lastpage; $counter++)
				{
					if ($counter == $page)
						$pagination.= "<span class=\"current\">$counter</span>";
					else
						$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$counter\">$counter</a>";					
				}
			}
		}
		
		//next button
		if ($page < $counter - 1) 
			$pagination.= "<a class=\"ld\" href=\"$targetpage&id=$id&page=$next\">next <img src=\"./img/rgt.png\"></a>";
		else
			$pagination.= "<span class=\"disabled\">next <img src=\"./img/rgt.png\"></span>";
		$pagination.= "</div>\n";		
	}

echo	wrt_table(0,0,0,$tblWidth,'center').'
		<tr><th class="ft_head" colspan="4">Replies</th></tr>';
		while($row = mysql_fetch_array($result))
		{
			if ( $evenOdd ) {$odder = " bcelleven"; $splitter = false;}else{$odder = " bcellodd"; $splitter = true;}
				$evenOdd = !$evenOdd;
echo	'<tr>
			<td width="64" rowspan="3" class="bcell'.$odder.'"><a name="'.$row['a_id'].'"><img src="http://image.eveonline.com/Character/'.$row['a_charid'].'_64.jpg"></td>
			<td class="intel bsmall'.$odder.'" width="150">Author: '.$row['a_name'].'</td><td class="intel bcell'.$odder.'" rowspan="3">'.nl2br($row['a_answer']).'</td>
		</tr>
		<tr><td class="intel bsmall'.$odder.'">'.substr($row['a_datetime'],0,16).'</td></tr>
		<tr><td class="intel bsmall bcell'.$odder.'"><a href="#" onclick="CCPEVE.sendMail('.$row['a_charid'].',\'RE: '.$rows['topic'].'\',\' \')">EVEMail</a></td></tr>';
$getPostTime = strtotime(date('Y-m-d H:i:s',strtotime($row['a_datetime'])+600)); // time from post
$curPostTime = strtotime(getEVEzone(date('Y-m-d H:i:s'))); // actual time
if ($getHeaderCharID==$row['a_charid']) {if ($getPostTime > $curPostTime) {echo '<tr><td colspan="3" class="intel bsmall bcell'.$odder.'"><span class="edit"><a href="'.$module_public.'&mode=edit&a=post&qid='.$row['question_id'].'&aid='.$row['a_id'].'">edit</a></span> - Editing current post is only possible within 10 minutes.</td></tr>';}}
//echo	strtotime(date('Y-m-d H:i:s',strtotime($row['a_datetime'])+1200)) . '_<br />'; // time from post
//echo	strtotime(getEVEzone(date('Y-m-d H:i:s',strtotime('+20 minutes')))) . '<br />'; // actual time
//echo	date('Y-m-d H:i:s',strtotime('+30 minutes',$row['a_datetime']));
		}
		echo	'</table>';
	?>
<?=$pagination?>
<?php



				$sql3="SELECT view FROM forum_thread WHERE id='$id'";
				$result3=mysql_query($sql3);
				$rows=mysql_fetch_array($result3);
				$view=$rows['view'];
				// if have no counter value set counter = 1
				if(empty($view)){
				$view=1;
				$sql4="INSERT INTO forum_thread(view) VALUES('$view') WHERE id='$id'";
				$result4=mysql_query($sql4);
				}
				// count more value
				$addview=$view+1;
				$sql5="update forum_thread set view='$addview' WHERE id='$id'";
				$result5=mysql_query($sql5);
				//mysql_close();



			$sqlatest = mysql_query('SELECT * FROM forum_posts WHERE question_id='.$id.' ORDER BY a_datetime DESC');
			$thisrow=mysql_fetch_array($sqlatest);
echo		'<p>&nbsp;</p><a name="reply"></a><form name="form1" method="post" action="'.$module_data.'&mode=forumadd&a=answer"><table cellspacing="0" cellpadding="0" border="0" class="center" width="80%">
			<input name="id" type="hidden" value="'.$id.'">
			<input name="pid" type="hidden" value="'.$pid.'">';
if (isset($_GET['page'])) {echo '<input name="page" type="hidden" value="'.$_GET['page'].'">';}
require_once('./includes/include_editor.php');

echo		'<input name="idanchor" type="hidden" value="'.($thisrow['a_id']+1).'">';
echo		'<tr>
				<th width="50%" rowspan="3" class="nob">&nbsp;</th><th class="ft_head">Reply</th>
			</tr>
			<tr>
				<td><textarea name="a_answer" cols="100" rows="4" id="editor"></textarea></td>
			</tr>
			<tr>
				<td><input type="submit" name="Reply" value="Submit"></td>
			</tr>
			</table>
			</form>';
mysql_close();

// ####################################
?>