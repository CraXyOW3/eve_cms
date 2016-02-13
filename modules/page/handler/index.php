<?php
function validate($string){
	return preg_match('/^[a-zA-Z0-9]+$/', $string);
}
if (isset($_GET['a']) && $_GET['a']=='add') {
		$p_name=mysql_real_escape_string(strtolower($_POST['p_name']));
		$p_title=mysql_real_escape_string($_POST['p_title']);
		$p_content=mysql_real_escape_string($_POST['p_content']);
		$charid=mysql_real_escape_string($_SERVER['HTTP_EVE_CHARID']);
		$date=strtotime(date('Y-m-d H:i:s'));
		if (validate($p_name)){

		/*
		echo $p_name.'<br />';
		echo $p_title.'<br />';
		echo $p_content.'<br />';
		echo $charid.'<br />';
		echo $date.'<br />';
		*/
			mysql_query("INSERT INTO pages(p_name, p_title, p_content, char_id, datetime)VALUES('$p_name', '$p_title', '$p_content', '$charid', '$date')");
		$_SESSION['text'] = 'Page Inserted Successfully!'.$p_name;
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Site Pages','Insert',$p_name);} // Logger
		//header("Location: ./?p=page_manager");
		redirect('./?module=admin&part=page'); exit();
		}else{
		$_SESSION['text'] = 'Page Identifier contained INVALID characters';
		$_SESSION['type'] = 'warning';
		if ($logFile) {logToFile('Site Pages','Insert',$p_name);} // Logger
		//header("Location: ./?p=page_manager");
		redirect('./?module=admin&part=page'); exit();
		}
}elseif (isset($_GET['a']) && $_GET['a']=='edit') {
		$p_name=mysql_real_escape_string(strtolower($_POST['p_name']));
		$p_title=mysql_real_escape_string($_POST['p_title']);
		$p_content=mysql_real_escape_string($_POST['p_content']);
		$charid=mysql_real_escape_string($_SERVER['HTTP_EVE_CHARID']);
		$date=strtotime(date('Y-m-d H:i:s'));
		$id=mysql_real_escape_string($_POST['id']);
			mysql_query("UPDATE pages SET p_name='$p_name', p_title='$p_title', p_content='$p_content', char_id='$charid', datetime='$date' WHERE id = '$id'");
		$_SESSION['text'] = 'Page "'.$p_name.'" Updated Successfully!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Site Pages','Edit',$p_name);} // Logger
		//header('Location: ./?p=page_manager&do=edit&id='.$id.'');
		redirect('./?module=admin&part=page&do=edit&id='.$id.''); exit();
}if (isset($_GET['a']) && $_GET['a']=='del') {
	$id=mysql_real_escape_string($_GET['id']);
	$get_name=good_query_assoc("SELECT p_title FROM pages WHERE id='".$id."'");
	$show_name = $get_name['p_title'];
		$_SESSION['text'] = 'Page "'.$show_name.'" Deleted Successfully!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Site Pages','Deletion',$show_name);} // Logger
		mysql_query("DELETE FROM pages WHERE id='".$id."'");
		//header('Location: ./?p=page_manager');
		redirect('./?module=admin&part=page'); exit();
}

?>