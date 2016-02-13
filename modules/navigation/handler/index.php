<?php
//include('../_cfg.php');
//ob_start();
//session_start();
if (isset($_GET['s']) && $_GET['s']=='update'){
	if(isset($_POST['istitle']) &&
	   $_POST['istitle'] == 'y')
	{$istitle = '1';} else {$istitle = '0';}
	$ltitle=mysql_real_escape_string($_POST['ltitle']);
	$ptitle=mysql_real_escape_string($_POST['ptitle']);
	$lurl=mysql_real_escape_string($_POST['lurl']);
	$access=mysql_real_escape_string($_POST['access']);
	$parent=mysql_real_escape_string($_POST['parent']);
	$idm=mysql_real_escape_string($_POST['id']);
	//echo '<br />ltitle:'.$ltitle.'<br />ptitle:'.$ptitle.'<br />url:'.$lurl.'<br />access:'.$access.'<br />parent:'.$parent.'<br />istitle:'.$istitle;
	mysql_query("UPDATE navigation SET name='$ltitle', title='$ptitle', url='$lurl', access='$access', istitle='$istitle', pid='$parent' WHERE id = '$idm'")or die($_SESSION['text']=mysql_error() . $_SESSION['type']='warning');
		$_SESSION['text']='Menu has been updated!';
		$_SESSION['type']='success';
	//header("Location: ./?module=admin&part=navigation&a=edit&id=$idm"); exit();
	redirect('./?module=admin&part=navigation&a=edit&id='.$idm.''); exit();
}elseif(isset($_GET['s']) && $_GET['s']=='add'){
	if(isset($_POST['istitle']) &&
	   $_POST['istitle'] == 'y')
	{$istitle = '1';} else {$istitle = '0';}
	$ltitle=mysql_real_escape_string($_POST['ltitle']);
	$ptitle=mysql_real_escape_string($_POST['ptitle']);
	$lurl=mysql_real_escape_string($_POST['lurl']);
	$access=mysql_real_escape_string($_POST['access']);
	$parent=mysql_real_escape_string($_POST['parent']);
	//echo '<br />ltitle:'.$ltitle.'<br />ptitle:'.$ptitle.'<br />url:'.$lurl.'<br />access:'.$access.'<br />parent:'.$parent.'<br />istitle:'.$istitle;
	
	//mysql_query("UPDATE menu SET mname='$ltitle', mtitle='$ptitle', murl='$lurl', maccess='$access', istitle='$istitle', pid='$parent' WHERE id = '$idm'")or die(mysql_error());
	
	$sql="INSERT INTO navigation(name, title, url, access, istitle, pid)VALUES('$ltitle', '$ptitle', '$lurl', '$access', '$istitle', '$parent')";
	$result=mysql_query($sql)or die($_SESSION['text']=mysql_error().$_SESSION['type']='warning');
		$_SESSION['text']='Menu has been added!';
		$_SESSION['type']='success';
	//header("Location: ./?module=admin&part=navigation"); exit();
	redirect('./?module=admin&part=navigation'); exit();
}elseif(isset($_GET['s']) && $_GET['s']=='delete'){
	mysql_query("DELETE FROM navigation WHERE id='".$_GET['id']."'")or die($_SESSION['text']=mysql_error().$_SESSION['type']='warning');
		$_SESSION['text']='Menu has been deleted!';
		$_SESSION['type']='success';
	//header("Location: ./?module=admin&part=navigation");
	redirect('./?module=admin&part=navigation'); exit();
}
//ob_flush();
?>