<?
if (isset($getHeaderTrusted)) {if ($getHeaderTrusted == 'No') {echo "no can do!";} else {if  ($getHeaderCorpID == $G_corpID) { // auth part
//pagetitle($G_siteTitle,"LogReader");
//echo $logFilePattern;


$dir = "log/";

// Open a known directory, and proceed to read its contents
if (is_dir($dir)) {
    if ($dh = opendir($dir)) {
		$wrt = '<select onchange="window.location=\'./?module=logreader&view=\'+this.value">';
		$wrt .= '<option>- view old logs -</option>';
        while (($file = readdir($dh)) !== false) {
			if (($file == '.')||($file == '..')){
			}else{
				$wrt .= '<option value="'.$file.'">'.$file.'</option>';
			}
        }
		$wrt .= '</select>';
		echo $wrt;
        closedir($dh);
    }
}
if (isset($_GET['view'])){
$viewLogFile = 'log/'.$_GET['view'];
}else{
$viewLogFile = $logFilePattern;
}

if ($logFile) {

	if(!file_exists($viewLogFile))
	{
		echo 'Could not open the log file "'.$viewLogFile.'" so im creating it!';
			$ourFileName = $viewLogFile;
			$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
			fclose($ourFileHandle);
	} else {
	
		    if(!filesize($viewLogFile)>0) {
				echo "Log is empty, nothing to show!";
			} else {
				$filename = $viewLogFile;
				$fd = fopen ($filename, "r");
				$data = fread ($fd,filesize ($filename));
				fclose ($fd);
				
				echo	'<table cellpadding="0" cellspacing="0" border="0" class="center" width="100%">
				<tr>
					<th class="ft_head">Date</th>
					<th class="ft_head">Section</th>
					<th class="ft_head">Action</th>
					<th class="ft_head">Content</th>
					<th class="ft_head">Whom</th>';
				
				$data = trim($data);
				$lines = preg_split("/\n|\r\n/", $data);
				foreach ($lines as $linenum => $linedata) {
					$cData = preg_split("/;/", $linedata);
					if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
					$evenOdd = !$evenOdd;
				   echo '<tr>
							<td class="tleft tcell'.$odder.'">'.$cData[0].'</td>
							<td class="tleft tcell'.$odder.'">'.$cData[1].'</td>
							<td class="tleft tcell'.$odder.'">'.$cData[2].'</td>
							<td class="tleft tcell'.$odder.'">'.$cData[3].'</td>
							<td class="tleft tcell'.$odder.'">'.$cData[4].'</td>
						</tr>';
				}
				echo	'</table>';
			}
	}
} else {echo 'Logging is turned off, to change that edit your config file!';}
}}}
?>
