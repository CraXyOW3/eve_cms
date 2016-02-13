<?php
//session_start();
if (isset($_GET['s'])){
	if ($_GET['s'] == 'post') {
	    //if(!$_POST['fname'] || ['dna'] || !$_POST['descr']) {
		//	die('Error: Username / Password field was blank');
		//}
		if(empty($_POST['fname']) || empty($_POST['dna']) || empty($_POST['description'])){
		$_SESSION['text'] = 'Empty Fields! oHNOEs!';
		$_SESSION['type'] = 'warning';
		redirect('./?module=admin&part=fittings'); exit();
		die('Error: One or more fields was empty!');
		}
		$fittName = $_POST['fname'];
		$fittDNA = $_POST['dna'];
		$fittRole = $_POST['role'];
		$fittDescr = $_POST['description'];
		$fittAuth = $_POST['author'];
		$fittDate = date("Y-m-d");
		//$fittDate = date("Y-m-d H:i:s");
		//$cacheExpiry = new DateTime($expiryResult, new DateTimeZone('GMT'));
			list($fittShipType) = explode(":",$fittDNA);
		mysql_query("INSERT INTO fitt_dna (tid, fittName, fitting, role, description, age, author) VALUES ('$fittShipType', '$fittName', '$fittDNA', '$fittRole', '$fittDescr', '$fittDate', '$fittAuth')");
		$_SESSION['text'] = 'DNA ADDED!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Fitting','Fitt Added',$fittName);} // Logger
		redirect('./?module=admin&part=fittings'); exit();
	} elseif ($_GET['s'] == 'delete') {
		mysql_query("DELETE FROM fitt_dna WHERE id='".$_GET['id']."'");
		$_SESSION['text'] = 'DNA Deleted!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Fitting','Fitt Deleted','no return value');} // Logger
		redirect('./?module=admin&part=fittings'); exit();
	} elseif ($_GET['s'] == 'update') {
		$fittName = $_POST['fname'];
		$fittDNA = $_POST['dna'];
		$fittRole = $_POST['role'];
		$fittDescr = $_POST['description'];
		$fittAuth = $_POST['author'];
		$fittDate = date("Y-m-d");
		$fittID = $_POST['id'];
			list($fittShipType) = explode(":",$fittDNA);
		mysql_query("UPDATE fitt_dna SET tid='$fittShipType', fittName='$fittName', fitting='$fittDNA', role='$fittRole', description='$fittDescr', age='$fittDate', author='$fittAuth' WHERE id ='$fittID'");
		$_SESSION['text'] = 'DNA EDITED!!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('Fitting','Fitt Edited',$fittName);} // Logger
		redirect('./?module=admin&part=fittings'); exit();
	} elseif ($_GET['s'] == 'deleterole') {
		mysql_query("DELETE FROM fitt_dna_role WHERE id='".$_GET['id']."'");
		$_SESSION['text'] = 'Role Deleted!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('FittRole','Role Deleted','no return value');} // Logger
		redirect('./?module=admin&part=fittings&a=roles'); exit();
	} elseif ($_GET['s'] == 'updaterole') {
			if(empty($_POST['rolename'])){
			$_SESSION['text'] = 'Empty Fields! oHNOEs!';
			$_SESSION['type'] = 'warning';
			redirect('./?module=admin&part=fittings&a=roles'); exit();
			die('Error: Rolename was blank!');
			}
		$roleID = $_POST['roleid'];
		$roleName = $_POST['rolename'];
		mysql_query("UPDATE fitt_dna_role SET rolename='$roleName' WHERE id ='$roleID'");
		$_SESSION['text'] = 'Role Updated!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('FittRole','Role Updated',$roleName);} // Logger
		redirect('./?module=admin&part=fittings&a=roles'); exit();
	} elseif ($_GET['s'] == 'saverole') {
			if(empty($_POST['rolename'])){
			$_SESSION['text'] = 'Empty Fields! oHNOEs!';
			$_SESSION['warning'] = 'success';
			redirect('./??module=admin&part=fittings&a=roles'); exit();
			die('Error: Rolename was blank!');
			}
		$roleName = $_POST['rolename'];
		echo	'name: ' . $roleName . '<br />';
		mysql_query("INSERT INTO fitt_dna_role (rolename) VALUES ('$roleName')");
		$_SESSION['text'] = 'Role Added!';
		$_SESSION['type'] = 'success';
		if ($logFile) {logToFile('FittRole','Role Added',$roleName);} // Logger
		redirect('./?module=admin&part=fittings&a=roles'); exit();
	}
}
?>