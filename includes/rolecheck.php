<?php
sleep(1);
//if( substr( dec2bin($getHeaderCorpRole), 0, 1 ) == 1 ) {$isDirector = true;} else {$isDirector = false;} // director role
if (isset($_GET['crprl'])) {
function dec2bin($_indec, $_pad=64, $_bitorder=1) {
	$digits="01";
	$retval="";
	bcscale(0);
	while($_indec>1) {
		$rmod=bcmod($_indec,2);
		$_indec=bcdiv($_indec,2);
		$retval=$digits[$rmod].$retval;
	}
	$retval=$digits[intval($_indec)].$retval;
	if ($_bitorder==1) {
	$retval=strrev(str_pad($retval, $_pad, "0", STR_PAD_LEFT));
		} else {
			$retval=str_pad($retval, $_pad, "0", STR_PAD_LEFT);
		}
		return (string)$retval;
}
$ts	=	'<tr><td class="tleft">';$tm	=	'</td><td class="tleft">';$te	=	'</td></tr>';
function fonty($string1, $string2) {
	if ($string1 == 'g') {
		echo '<font color="#00ff00">'.$string2.'</font> ';
	} elseif ($string1 == 'r') {
		echo '<font color="#ff0000">'.$string2.'</font> ';
	}
}
echo	'<table border="0" width="100%" cellpadding="0" cellspacing="0">';
	//echo $_GET['crprl'];
		echo $ts . 'Director ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 0, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
		echo $ts . 'Personal Mngr ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 7, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
		echo $ts . 'Accountant ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 8, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
		echo $ts . 'Security Officer ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 9, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
		echo $ts . 'Factory Manager ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 10, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
		echo $ts . 'Station Manager ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 11, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
		echo $ts . 'Auditor ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 12, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
		echo $ts . 'Deploy Equipment ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 41, 1 ) == 1 ) {echo fonty('g','Yes');} else {echo fonty('r','No');}
		echo $te;
	echo $ts . '<b>Divisions</b>' . $tm . '<b>Wallet</b>' . $te;
	echo $ts;
	echo '<table border="0" width="100%" cellpadding="0" cellspacing="0">';

		echo $ts . 'Div1Hangar ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 13, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 20, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div2Hangar ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 14, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 21, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div3Hangar ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 15, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 22, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div4Hangar ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 16, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 23, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div5Hangar ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 17, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 24, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div6Hangar ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 18, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 25, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div7Hangar ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 19, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 26, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
	
	echo '</table>'. $tm . '<table border="0" width="100%" cellpadding="0" cellspacing="0">';
		echo $ts . 'Div1Account ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 27, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 34, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div2Account ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 28, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 35, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div3Account ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 29, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 36, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div4Account ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 30, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 37, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div5Account ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 31, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 38, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div6Account ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 32, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 39, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
		echo $ts . 'Div7Account ' . $tm;
		if( substr( dec2bin($_GET['crprl']), 33, 1 ) == 1 ) {echo fonty('g','Take');} else {echo fonty('r','Take');}
		if( substr( dec2bin($_GET['crprl']), 40, 1 ) == 1 ) {echo fonty('g','Query');} else {echo fonty('r','Query');}
		echo $te;
	echo $te;
	echo '</table>';
		/*

			// division roles
			if($this->CorpRole[13]=="1")	$this->Div1HangarTake = true;
			if($this->CorpRole[14]=="1")	$this->Div2HangarTake = true;
			if($this->CorpRole[15]=="1")	$this->Div3HangarTake = true;
			if($this->CorpRole[16]=="1")	$this->Div4HangarTake = true;
			if($this->CorpRole[17]=="1")	$this->Div5HangarTake = true;
			if($this->CorpRole[18]=="1")	$this->Div6HangarTake = true;
			if($this->CorpRole[19]=="1")	$this->Div7HangarTake = true;

			if($this->CorpRole[20]=="1")	$this->Div1HangarQuery = true;
			if($this->CorpRole[21]=="1")	$this->Div2HangarQuery = true;
			if($this->CorpRole[22]=="1")	$this->Div3HangarQuery = true;
			if($this->CorpRole[23]=="1")	$this->Div4HangarQuery = true;
			if($this->CorpRole[24]=="1")	$this->Div5HangarQuery = true;
			if($this->CorpRole[25]=="1")	$this->Div6HangarQuery = true;
			if($this->CorpRole[26]=="1")	$this->Div7HangarQuery = true;

			if($this->CorpRole[27]=="1")	$this->Div1AccountTake = true;
			if($this->CorpRole[28]=="1")	$this->Div2AccountTake = true;
			if($this->CorpRole[29]=="1")	$this->Div3AccountTake = true;
			if($this->CorpRole[30]=="1")	$this->Div4AccountTake = true;
			if($this->CorpRole[31]=="1")	$this->Div5AccountTake = true;
			if($this->CorpRole[32]=="1")	$this->Div6AccountTake = true;
			if($this->CorpRole[33]=="1")	$this->Div7AccountTake = true;

			if($this->CorpRole[34]=="1")	$this->Div1AccountQuery = true;
			if($this->CorpRole[35]=="1")	$this->Div2AccountQuery = true;
			if($this->CorpRole[36]=="1")	$this->Div3AccountQuery = true;
			if($this->CorpRole[37]=="1")	$this->Div4AccountQuery = true;
			if($this->CorpRole[38]=="1")	$this->Div5AccountQuery = true;
			if($this->CorpRole[39]=="1")	$this->Div6AccountQuery = true;
			if($this->CorpRole[40]=="1")	$this->Div7AccountQuery = true;
			
			// equipment config & deploy space for owned space objects
			if($this->CorpRole[41]=="1")	$this->EquipmentDeploy = true;
			*/
echo	'</table>';
}


?>