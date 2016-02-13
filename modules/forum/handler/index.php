<?php
include($module_dir.'forum/config.php');
if ($_GET['a']=='delete') {
						mysql_query("DELETE FROM forum_thread WHERE id='".$_GET['id']."'");
						mysql_query("DELETE FROM forum_posts WHERE question_id='".$_GET['id']."'");
						//$_SESSION['fittMSG'] = 'Bulletin Deleted!';
						if ($logFile) {logToFile('Forum','Deletion','Thread Deleted');} // Logger
		$_SESSION['text'] = 'Topic and related answerd deleted!';
		$_SESSION['type'] = 'success';
				if ($isDirector && (isset($_GET['a']) && $_GET['a']=='directors')) {redirect('./?p=forum&a=directors'); exit();}else{redirect('./?p=forum'); exit();}
} elseif ($_GET['a']=='topic') {
	if(isset($_POST['fordirs']) &&
	   $_POST['fordirs'] == 'y')
	{$fordirs = '1';} else {$fordirs = '0';} 
						$topic=mysql_real_escape_string($_POST['topic']);
						$detail=mysql_real_escape_string($_POST['detail']);
						$id=mysql_real_escape_string($_POST['id']);
						$pid=mysql_real_escape_string($_POST['pid']);
						mysql_query("UPDATE forum_thread SET topic='$topic', detail='$detail', fordirs='$fordirs' WHERE id = '$id'");
						if ($logFile) {logToFile('Forum','Edit',$topic);} // Logger
		$_SESSION['text'] = 'Topic '.$topic.' edited!';
		$_SESSION['type'] = 'success';
						//header("Location: ./?p=forum");
						redirect($module_public.'&mode=view&pid='.$pid.'&id='.$id); exit();
} elseif ($_GET['a']=='post') {
						$answer=mysql_real_escape_string($_POST['a_answer']);
						$aid=$_POST['aid'];
						$qid=$_POST['qid'];
						//echo $answer . $qid . $aid;
						mysql_query("UPDATE forum_posts SET a_answer='$answer' WHERE question_id = '$qid' AND a_id='$aid'");
						//if ($logFile) {logToFile('Board','Edit','Edited Post');} // Logger
		$_SESSION['text'] = 'Post added!';
		$_SESSION['type'] = 'success';
						//header("Location: ./?p=forum&mode=view&id=$qid");
						redirect('./?p=forum&mode=view&id='.$qid.''); exit();
} elseif ($_GET['a']=='delcat') {
		$id=mysql_real_escape_string($_GET['id']);
		mysql_query("DELETE FROM forum_cat WHERE id='".$id."'");
			
			$post_deleter = good_query_assoc("SELECT * FROM forum_thread WHERE pid=".$id."");
			mysql_query("DELETE FROM forum_posts WHERE question_id='".$post_deleter['id']."'");
			mysql_query("DELETE FROM forum_thread WHERE pid='".$id."'");
		if ($logFile) {logToFile('Forum','Deletion','Category Deleted');} // Logger
		$_SESSION['text'] = 'Forum Category deleted!';
		$_SESSION['type'] = 'success';
		redirect($module_admin); exit();
} elseif ($_GET['a']=='editcat') {
	if(isset($_POST['fordirs']) &&
	   $_POST['fordirs'] == '1')
	{$fordirs = '1';} else {$fordirs = '0';}
		// get data that sent from form
		$title=mysql_real_escape_string($_POST['title']);
		$descr=mysql_real_escape_string($_POST['descr']);
				// ############### add a _if director only thread value_
		$datetime=getEVEzone(date("Y-m-d H:i:s")); //create date time
		$id=mysql_real_escape_string($_POST['id']);

		//$sql="INSERT INTO forum_cat(cat_name, cat_descr, cat_isdir)VALUES('$title', '$descr', '$fordirs')";
		mysql_query("UPDATE forum_cat SET cat_name='$title', cat_descr='$descr', cat_isdir='$fordirs' WHERE id = '$id'");
		//$result=mysql_query($sql);

		if($result){
			//if ($logFile) {logToFile('Board','Topic Added',$topic);} // Logger
		$_SESSION['text'] = 'Forum Category Edited!';
		$_SESSION['type'] = 'success';
		redirect($module_admin); exit();
		}
		else {
		//echo "ERROR";
		}
}elseif ($_GET['a']=='answer'){
		// Get value of id that sent from hidden field
		$id=mysql_escape_string($_POST['id']);
		$pid=mysql_escape_string($_POST['pid']);

		// Find highest answer number.
		$sql="SELECT MAX(a_id) AS Maxa_id FROM forum_posts WHERE question_id='$id'";
		$result=mysql_query($sql);
		$rows=mysql_fetch_array($result);

		// add + 1 to highest answer number and keep it in variable name "$Max_id". if there no answer yet set it = 1
		if ($rows) {
		$Max_id = $rows['Maxa_id']+1;
		}
		else {
		$Max_id = 1;
		}

		// get values that sent from form
		//$a_name=$_POST['a_name'];
		$a_name=mysql_real_escape_string($_SERVER['HTTP_EVE_CHARNAME']);
		$a_charid=mysql_real_escape_string($_SERVER['HTTP_EVE_CHARID']);
		$a_answer=mysql_real_escape_string($_POST['a_answer']);

		$datetime=getEVEzone(date("Y-m-d H:i:s")); // create date and time

		// Insert answer
		$sql2="INSERT INTO forum_posts(question_id, a_id, a_name, a_charid, a_answer, a_datetime)VALUES('$id', '$Max_id', '$a_name', '$a_charid', '$a_answer', '$datetime')";
		$result2=mysql_query($sql2);

		if($result2){
		// If added new answer, add value +1 in reply column
		$sql3="UPDATE forum_thread SET reply='$Max_id' WHERE id='$id'";
		$result3=mysql_query($sql3);
			if ($logFile) {logToFile('Board','Reply Added','To a Post');} // Logger
		$_SESSION['text'] = 'Answer Added!';
		$_SESSION['type'] = 'success';
			if (isset($_POST['page'])) {
			//header("Location: ./?p=forum&mode=view&id=".$id."&page=".$_POST['page']."#".$_POST['idanchor']."");
			redirect($module_public.'&mode=view&id='.$id.'&page='.$_POST['page'].'#'.$_POST['idanchor'].''); exit();
			//redirect('./?p=page_manager'); exit();
			} else {
			//header("Location: ./?p=forum&mode=view&id=".$id."#".$_POST['idanchor']."");
			redirect($module_public.'&mode=view&pid='.$pid.'&id='.$id.'#'.$_POST['idanchor'].''); exit();
			}
			
		}
		else {
		//echo "ERROR";
		}
} elseif ($_GET['a']=='topicadd') {
	if(isset($_POST['fordirs']) &&
	   $_POST['fordirs'] == 'y')
	{$fordirs = '1';} else {$fordirs = '0';}
		// get data that sent from form
		$topic=mysql_real_escape_string($_POST['topic']);
		$detail=mysql_real_escape_string($_POST['detail']);
		$name=mysql_real_escape_string($_SERVER['HTTP_EVE_CHARNAME']);
		$charid=mysql_real_escape_string($_SERVER['HTTP_EVE_CHARID']);
				// ############### add a _if director only thread value_
		$datetime=getEVEzone(date("Y-m-d H:i:s")); //create date time
		$pid=mysql_escape_string($_POST['pid']);

		$sql="INSERT INTO forum_thread(topic, detail, name, charid, datetime, fordirs, pid)VALUES('$topic', '$detail', '$name', '$charid', '$datetime', '$fordirs','$pid')";
		$result=mysql_query($sql);

		if($result){
			if ($logFile) {logToFile('Board','Topic Added',$topic);} // Logger
		$_SESSION['text'] = 'Topic Added!';
		$_SESSION['type'] = 'success';
			if ($isDirector && (isset($_POST['fordirs']) && $_POST['fordirs']=='y')) {redirect($module_public.'&mode=threads&id='.$pid.'&a=directors'); exit();}else{redirect($module_public.'&mode=threads&id='.$pid.''); exit();}
		}
		else {
		//echo "ERROR";
		}
} elseif ($_GET['a']=='cat') {
	if(isset($_POST['fordirs']) &&
	   $_POST['fordirs'] == '1')
	{$fordirs = '1';} else {$fordirs = '0';}
		// get data that sent from form
		$title=mysql_real_escape_string($_POST['title']);
		$descr=mysql_real_escape_string($_POST['descr']);
				// ############### add a _if director only thread value_
		$datetime=getEVEzone(date("Y-m-d H:i:s")); //create date time

		$sql="INSERT INTO forum_cat(cat_name, cat_descr, cat_isdir)VALUES('$title', '$descr', '$fordirs')";
		$result=mysql_query($sql);

		if($result){
			//if ($logFile) {logToFile('Board','Topic Added',$topic);} // Logger
		$_SESSION['text'] = 'Forum Category Added!';
		$_SESSION['type'] = 'success';
			if ($boardMode) {header("Location: ./?p=board");}else{
				//if ($isDirector && (isset($_POST['fordirs']) && $_POST['fordirs']=='1')) {redirect('./?p=forum&a=directors'); exit();}else{redirect('./?p=forum'); exit();}
				redirect($module_public); exit();
			}
		}
		else {
		//echo "ERROR";
		}
}
?>