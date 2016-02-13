<?php
if (isset($_GET['a'])) {
	if ($_GET['a']=='apiupdate') {
		$keyid=mysql_real_escape_string($_POST['keyID']);
		$vcode=mysql_real_escape_string($_POST['vCode']);
		mysql_query("UPDATE api SET keyID='$keyid', vCode='$vcode'");
		$_SESSION['text'] = 'API Updated!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('API','Update','');} // Logger
		header("Location: ./?module=admin&part=api");
	}
}
?>