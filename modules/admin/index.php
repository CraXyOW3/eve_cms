<?php
if (isset($_GET['part'])){
$datadir='./modules/'.$_GET['part'].'/admin/index.php';
	if (file_exists($datadir)){
		include($datadir);
	}else{
		$_SESSION['text'] = 'Warning: The Adminarea of "'.$_GET['part'].'" does not exists!';
		$_SESSION['type'] = 'warning';
		redirect('./');
	}
}
?>