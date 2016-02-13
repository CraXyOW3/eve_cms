<?php
if (isset($_GET['part'])){
$datadir='./modules/'.$_GET['part'].'/handler/index.php';
	if (file_exists($datadir)){
		include($datadir);
	}else{
		$_SESSION['text'] = 'Warning: The Datahandler "'.$_GET['part'].'" does not exists!';
		$_SESSION['type'] = 'warning';
		redirect('./');
	}
}
?>