<?php
if (isset($_SERVER['HTTP_EVE_TRUSTED'])) {if ($_SERVER['HTTP_EVE_TRUSTED'] == 'No') {echo "no can do!";} else {$CHAR_CORPID = $_SERVER['HTTP_EVE_CORPID'];if ($CHAR_CORPID == $G_corpID) {
	if (isset($_GET['a'])) {
		if ($_GET['a']=='charlist'){
			$filename='cache/recruiter/'.$_GET['id'];
			$fh=fopen($filename, 'r');
			$data=fread($fh, filesize($filename));
			fclose($fh);
			$splitcontents=explode("|", $data);
					//echo $splitcontents[2];
				//$apiurl = "https://apitest.eveonline.com/account/Characters.xml.aspx?keyID=1738&vCode=Bma3gYAsg9rP8e0mvQDoDxxpBi5l231jj2dY1uPYXomn1XhtdkIIaOndDgFFqr9A"; // test
				$apiurl = "https://api.eveonline.com/account/Characters.xml.aspx?keyID=".$splitcontents[1]."&vCode=" .$splitcontents[2]; // code to be run after debug.
				$xmlFile = file_get_contents($apiurl);
				file_put_contents("./cache/xml/recruiter/" . $splitcontents[1].'_chars.xml' , $xmlFile);
			//die("File not found");
				$_SESSION['text'] = 'XML Datasheet fetched.';
				$_SESSION['type'] = 'success';
				if ($logFile) {logToFile('Recruiter','Fetched',$id);} // Logger
				header("Location: ./?module=admin&part=recruiter&id=".$_GET['id']);
		}elseif($_GET['a']=='charsheet'){
		//create character
			$filename='cache/recruiter/'.$_GET['id'];
			$fh=fopen($filename, 'r');
			$data=fread($fh, filesize($filename));
			fclose($fh);
			$splitcontents=explode("|", $data);
				//$apiurl = "https://apitest.eveonline.com/char/CharacterSheet.xml.aspx?characterID=".$_GET['sheet']."&keyID=1738&vCode=Bma3gYAsg9rP8e0mvQDoDxxpBi5l231jj2dY1uPYXomn1XhtdkIIaOndDgFFqr9A"; // test!!
				$apiurl = "https://api.eveonline.com/char/CharacterSheet.xml.aspx?characterID=".$_GET['sheet']."&keyID=".$splitcontents[1]."&vCode=" .$splitcontents[2]; // code to be run after debug!!
				$xmlFile = file_get_contents($apiurl);
				file_put_contents("./cache/xml/recruiter/" . $splitcontents[1].'_id_'.$_GET['sheet'].'_character.xml' , $xmlFile);
				$_SESSION['text'] = 'XML Datasheet fetched.';
				$_SESSION['type'] = 'success';
				if ($logFile) {logToFile('Recruiter','Fetched',$id);} // Logger
				header("Location: ./?module=admin&part=recruiter&id=".$_GET['id']."&sheet=".$_GET['sheet']);
		}



	}
}}}
?>