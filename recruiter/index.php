<?php
include('../config.php');
?>
<html>
<head>
<title>Recruiter</title>
<meta charset="utf-8" />
<link rel="stylesheet" href="../css/stylesheet.css" />
<link rel="stylesheet" href="../css/merged.css" />
<script type="text/javascript" src="./js/jquery-1.6.4.min.js"></script>
<script type="text/javascript" src="./js/jquery.graphup.pack.js"></script>
<script type="text/javascript" src="./js/jquery-ui-1.8.16.custom.min.js"></script>
<link rel="stylesheet" href="css/ui-darkness/jquery-ui-1.8.16.custom.css" />
<script type="text/javascript" src="./js/jquery.tooltip.min.js"></script>
<script type="text/javascript" src="./js/jquery.notify.js"></script>

<script type="text/javascript" src="./js/jtip.js"></script>
<script type="text/javascript" src="./js/site.js"></script>
 
</head>
<?php
if ((isset($_SERVER['HTTP_EVE_TRUSTED'])) && $_SERVER['HTTP_EVE_TRUSTED']=='Yes'){
echo'<body>';
}else{
echo '<body onload="CCPEVE.requestTrust(\''.$G_domain.'\')">';
echo'You must trust the site before continuing.<br />When trusted, refresh window och click <a href="/recruiter/">here</a>.!';
die();
}










?>
<p>&nbsp;</p>
<form action="./?a=send" method="post">
<table border="0" class="center" width="80%">

<tr><td>
<fieldset style="width:80%;">
<legend>Application</legend>
	<table cellpadding="0" cellspacing="0" border="0">
		<tr>
			<td>Name:</td><td><input name="cname" type="text" value="<?php echo $_SERVER['HTTP_EVE_CHARNAME'];?>" readonly="readonly"></td>
		</tr><tr>
			<td>keyID:</td><td><input name="keyID" type="text"></td>
		</tr><tr>
			<td>vCode:</td><td><input name="vCode" type="text" size="80"></td>
		</tr><tr>
			<td>&nbsp;</td><td><input type="hidden" value="1" name="submitted"><input type="submit" value="Send Application"></td>
		</tr>
	</table>
</td>
<td width="300">
<fieldset>
<legend>Help?</legend>
First of all, if you have not handled API before, simplest is to got to the link at the end of this text and create that specific API Key.<br />
After it is created, copy and paste both <b>keyID</b> and <b>vCode</b> into the respective fields in here and press submit.<br />
Step by step:<br />
<ol>
<li>Login</li>
<li>Name API Key</li>
<li>Add a couple of days for the expire key</li>
<li>Do not change anything else!</li>
<li>Hit the "Submit" button to Create!</li>
<li>Now you will see both "<b>ID</b>" and "<b>Verification Code</b>"</li>
<li><b>ID</b> is keyID, <b>Verification Code</b> is vCode.</li>
<li>Copy and Paste the respective information in each field and submit.</li>
<li>Finished.</li>
</ol>
<br />
<a href="https://support.eveonline.com/api/Key/CreatePredefined/50331656" target="_blank">Create Predefined API Key</a>
</fieldset>
</td>
</tr>

</table>
</form>

<?php
if(isset($_POST['submitted'])){
	if ($_POST['submitted']==1) {
		$errormsg = ""; //Initialize errors
		if ($_POST['cname']){
			$cname = $_POST['cname']; //If name was entered
		}else{
			$errormsg = "Please enter Name";
		}
		if ($_POST['keyID']){
			$keyID = $_POST['keyID']; //If comment was entered
		}else{
			if ($errormsg){ //If there is already an error, add next error
				$errormsg = $errormsg . " & keyID";
			}else{
				$errormsg = "Please enter keyID";
			}
		}

		if ($_POST['vCode']){
			$vCode = $_POST['vCode']; //If comment was entered
		}else{
			if ($errormsg){ //If there is already an error, add next error
				$errormsg = $errormsg . " & vCode";
			}else{
				$errormsg = "Please enter vCode";
			}
		}

	}
}
if(isset($errormsg)){
    if ($errormsg){ //If any errors display them
        echo "<div class=\"box red\">$errormsg</div>";
		$state=0;
    }

	if (!$errormsg) {
		echo'Submition Added';
		$state=1;
	}
}

if (isset($_GET['a']) && $_GET['a']=='send') {
	//if (empty($_GET['keyID'])) || (empty($_GET['vCode'])) {echo 'empty';}
	if ($state){
		//$myFile = $name . ".api";
		$myFile = $keyID;
		$fh = fopen('../cache/recruiter/'.$myFile, 'w') or die("can't open file");
		$stringData=$cname.'|';
		fwrite($fh, $stringData);
		$stringData=$keyID.'|';
		fwrite($fh, $stringData);
		$stringData=$vCode;
		fwrite($fh, $stringData);
		fclose($fh);
	}
}
?>

</body>
</html>