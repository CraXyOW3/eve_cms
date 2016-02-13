<?php
function redirect($url,$permanent = false) {
	if($permanent) {
		header('HTTP/1.1 301 Moved Permanently');
	}
	header('Location: '.$url);
	exit();
}
function getModule($string) {
	return "modules/" . $string . "/index.php";
}
/*
if ($cronState == false) {
	//input mysql apicache check.
}
*/
function getEDay($logondate) {
	return date('l', strtotime($logondate));
}
/*
function getETime($logontime) {
	return date('YmdHi', strtotime($logontime));
}
*/
function getETimeH($logontime) {
	return date('H', strtotime($logontime));
}
function getEDayVar($string) {
	if (getEDay($string) == "Monday") return $strD="m";
	if (getEDay($string) == "Tuesday") return $strD="tu";
	if (getEDay($string) == "Wednesday") return $strD="w";
	if (getEDay($string) == "Thursday") return $strD="th";
	if (getEDay($string) == "Friday") return $strD="f";
	if (getEDay($string) == "Saturday") return $strD="sa";
	if (getEDay($string) == "Sunday") return $strD="su";
}
function getETimeVar1($string) {
	if ($string <00 || $string > 02) return $strH="01";
	if ($string <02 || $string > 04) return $strH="02";
	if ($string <04 || $string > 06) return $strH="03";
	if ($string <06 || $string > 08) return $strH="04";
	if ($string <08 || $string > 10) return $strH="05";
	if ($string <10 || $string > 12) return $strH="06";
	if ($string <12 || $string > 14) return $strH="07";
	if ($string <14 || $string > 16) return $strH="08";
	if ($string <16 || $string > 18) return $strH="09";
	if ($string <18 || $string > 20) return $strH="10";
	if ($string <20 || $string > 22) return $strH="11";
	if ($string <22 || $string > 00) return $strH="12";
}
function getETimeVar($string) {
	if ($string >= 00 && $string <= 02) { $strH="1";}
	if ($string >= 02 && $string <= 04) { $strH="2";}
	if ($string >= 04 && $string <= 06) { $strH="3";}
	if ($string >= 06 && $string <= 08) { $strH="4";}
	if ($string >= 08 && $string <= 10) { $strH="5";}
	if ($string >= 10 && $string <= 12) { $strH="6";}
	if ($string >= 12 && $string <= 14) { $strH="7";}
	if ($string >= 14 && $string <= 16) { $strH="8";}
	if ($string >= 16 && $string <= 18) { $strH="9";}
	if ($string >= 18 && $string <= 20) { $strH="10";}
	if ($string >= 20 && $string <= 22) { $strH="11";}
	if ($string >= 22 && $string <= 24) { $strH="12";}
	return $strH;
}
function page2DB() { // check if current part of page is up to date.
	if (isset( $_GET["p"] )) {
		if ($_GET["p"]=="ontimes" || ($_GET["p"]=="ov")) {
		Global $keyID, $G_author;
		$apiSheet = "corp/MemberTracking";
		$cacheQuery = "SELECT apiaddresses.*, cacheduntil.* FROM apiaddresses, cacheduntil WHERE apiaddresses.apiSheetName = '" . $apiSheet . "' AND cacheduntil.keyID = '".convert($keyID,$G_author)."' AND cacheduntil.addressID = apiaddresses.addressID";
		$cacheResult = mysql_query($cacheQuery) or die(mysql_error());
			$row = mysql_fetch_row($cacheResult);
				$expiryResult = $row['6'];
		$currentDateTime = new DateTime("now", new DateTimeZone('GMT'));
		$cacheExpiry = new DateTime($expiryResult, new DateTimeZone('GMT'));
			if ( $currentDateTime > $cacheExpiry ) {
				$sm = "DB Craves an UPDATE!!!";
					if ($_GET["p"] == "ontimes")	{$rUrl = 'ontimes';} elseif ($_GET["p"] == "ov") {$rUrl = 'ov';}
				header("Location: ./?p=cron&s=ot&r=".$rUrl."");
			} else {
				$sm = "DB is Current!";
			}
		} elseif ($_GET["p"] == "ckills") {
		Global $keyID,$G_author;
		$apiSheet = "corp/Killlog"; 
		$cacheQuery = "SELECT apiaddresses.*, cacheduntil.* FROM apiaddresses, cacheduntil WHERE apiaddresses.apiSheetName = '" . $apiSheet . "' AND cacheduntil.keyID = '".convert($keyID,$G_author)."' AND cacheduntil.addressID = apiaddresses.addressID";
		$cacheResult = mysql_query($cacheQuery) or die(mysql_error());
			$row = mysql_fetch_row($cacheResult);
			$expiryResult = $row['6'];
		$currentDateTime = new DateTime("now", new DateTimeZone('GMT'));
		$cacheExpiry = new DateTime($expiryResult, new DateTimeZone('GMT'));
			if ( $currentDateTime > $cacheExpiry ) {
				header("Location: ./?p=cron&s=ckills");
				//echo 'banana';
			} else {
			}
		}
	}
}
function page2DBv2() { // check if current part of page is up to date.
	if ($_GET['p']=='killboard') {
		Global $keyID,$G_author;
		$apiSheet = "corp/Killlog"; 
		$cacheQuery = "SELECT apiaddresses.*, cacheduntil.* FROM apiaddresses, cacheduntil WHERE apiaddresses.apiSheetName = '" . $apiSheet . "' AND cacheduntil.keyID = '".convert($keyID,$G_author)."' AND cacheduntil.addressID = apiaddresses.addressID";
		$cacheResult = mysql_query($cacheQuery) or die(mysql_error());
			$row = mysql_fetch_row($cacheResult);
			$expiryResult = $row['6'];
		$currentDateTime = new DateTime("now", new DateTimeZone('GMT'));
		$cacheExpiry = new DateTime($expiryResult, new DateTimeZone('GMT'));
			if ( $currentDateTime > $cacheExpiry ) {
				header("Location: ./?p=cron&s=killboard");
				//echo 'banana';
			} else {
			}
		}else	if ($_GET['p']=='members' || $_GET['p']=='ontimes') {
		Global $keyID,$G_author;
		$apiSheet = "corp/MemberTracking"; 
		$cacheQuery = "SELECT apiaddresses.*, cacheduntil.* FROM apiaddresses, cacheduntil WHERE apiaddresses.apiSheetName = '" . $apiSheet . "' AND cacheduntil.keyID = '".convert($keyID,$G_author)."' AND cacheduntil.addressID = apiaddresses.addressID";
		$cacheResult = mysql_query($cacheQuery) or die(mysql_error());
			$row = mysql_fetch_row($cacheResult);
			$expiryResult = $row['6'];
		$currentDateTime = new DateTime("now", new DateTimeZone('GMT'));
		$cacheExpiry = new DateTime($expiryResult, new DateTimeZone('GMT'));
			if ( $currentDateTime > $cacheExpiry ) {
				header("Location: ./?p=cron&s=members");
				//echo 'banana';
			} else {
			}
		}
}
function convert($str,$ky=''){
if($ky=='')return $str;
$ky=str_replace(chr(32),'',$ky);
if(strlen($ky)<8)exit('key error');
$kl=strlen($ky)<32?strlen($ky):32;
$k=array();for($i=0;$i<$kl;$i++){
$k[$i]=ord($ky{$i})&0x1F;}
$j=0;for($i=0;$i<strlen($str);$i++){
$e=ord($str{$i});
$str{$i}=$e&0xE0?chr($e^$k[$j]):chr($e);
$j++;$j=$j==$kl?0:$j;}
return $str;
} 
function pagetitle($str1,$str2) {
	//echo "<h1>" . $str1 . " | " . $str2 . "</h1>";
	echo '<table cellpadding="0" cellspacing="0" border="0" class="center tabwidth"><tr><td class="htitle">' . $str1 . ' | '.$str2.'</td></tr></table><p>&nbsp;</p>';
}
function pageheader($str1,$str2) {
	Global $G_corpID,$getHeaderCharID ;
	return $str1 . " | " . $str2;
}
function ShortenText($text) {
	// Change to the number of characters you want to display
	$chars = 35;
		$text = $text." ";
		$text = substr($text,0,$chars);
		$text = substr($text,0,strrpos($text,' '));
		$text = $text."...";
		return $text;
}
/**
 * trims text to a space then adds ellipses if desired
 * @param string $input text to trim
 * @param int $length in characters to trim to
 * @param bool $ellipses if ellipses (...) are to be added
 * @param bool $strip_html if html tags are to be stripped
 * @return string
 */
function trim_text($input, $length, $ellipses = true, $strip_html = true) {
    //strip tags, if desired
    if ($strip_html) {
        $input = strip_tags($input);
    }
     //no need to trim, already shorter than trim length
    if (strlen($input) <= $length) {
        return $input;
    }
     //find last space within length
    $last_space = strrpos(substr($input, 0, $length), ' ');
    $trimmed_text = substr($input, 0, $last_space);
    //add ellipses (...)
    if ($ellipses) {
        $trimmed_text .= '...';
    }
    return $trimmed_text;
}
function logToFile($what, $how, $msg) { 
	Global $logFilePattern;
	if(!file_exists($logFilePattern)) {
		echo "Couldn't open the log file. Try again later.";
		$ourFileName = $logFilePattern;
		$ourFileHandle = fopen($ourFileName, 'w') or die("can't open file");
		fclose($ourFileHandle);
	}
		$fd = fopen($logFilePattern, 'a');
		$str1 = '['.date('Y-m-d H:i:s', time()).']';
		$str2 = $what;
		$str3 = $how;
		$str4 = $msg;
		$str5 = $_SERVER['HTTP_EVE_CHARNAME'];
		fwrite($fd, $str1 . ";" . $str2 . ";" . $str3 . ";" . $str4 . ";" . $str5 . "\r\n");
		fclose($fd);
}
function getEVEzone($string){
	$timestamp = strtotime($string);
	$tz = 'GMT';
	$dtzone = new DateTimeZone($tz);
	$dtime = new DateTime();
	$dtime->setTimestamp($timestamp);
	$dtime->setTimeZone($dtzone);
	$string = $dtime->format('Y-m-d H:i:s');
	return $string;
}
function compare_dates($date1, $date2) {
	list($month, $day, $year) = explode('-', $date1);
	$new_date1 = sprintf('%04d%02d%02d', $year, $month, $day);
	list($month, $day, $year) = explode('-', $date2);
	$new_date2 = sprintf('%04d%02d%02d', $year, $month, $day);
	return ($new_date1 > $new_date2);
}
function alert_notice($type,$text) {
    $alert	=	'<script type="text/javascript">
    $(function() {';
	//error, info, success, warning
	$alert	.=	'	$.notify(\''.$text.'\', \''.$type.'\', {timeout: 5});';
    $alert	.=	'} );
				</script>';
	return $alert;
}
function alert_check() {
	if (isset($_SESSION['text'])) {
		$string = alert_notice($_SESSION['type'],$_SESSION['text']);
		unset($_SESSION['text']);
		unset($_SESSION['type']);
		session_destroy();
		return $string;
	}
}
function good_query($string, $debug=0)
{
    if ($debug == 1)
        print $string;

    if ($debug == 2)
        error_log($string);

    $result = mysql_query($string);

    if ($result == false)
    {
        error_log("SQL error: ".mysql_error()."\n\nOriginal query: $string\n");
        // Remove following line from production servers 
        die("SQL error: ".mysql_error()."\b<br>\n<br>Original query: $string \n<br>\n<br>");
    }
    return $result;
}
function good_query_list($sql, $debug=0)
{
    // this function require presence of good_query() function
    $result = good_query($sql, $debug);
    
    if($lst = mysql_fetch_row($result))
    {
        mysql_free_result($result);
        return $lst;
    }
    mysql_free_result($result);
    return false;
}
function good_query_assoc($sql, $debug=0)
{
    // this function require presence of good_query() function
    $result = good_query($sql, $debug);
    
    if($lst = mysql_fetch_assoc($result))
    {
        mysql_free_result($result);
        return $lst;
    }
    mysql_free_result($result);
    return false;
}
function good_query_value($sql, $debug=0)
{
    // this function require presence of good_query_list() function
    $lst = good_query_list($sql, $debug);
    return is_array($lst)?$lst[0]:false;
}
function good_query_table($sql, $debug=0)
{
    // this function require presence of good_query() function
    $result = good_query($sql, $debug);
    
    $table = array();
    if (mysql_num_rows($result) > 0)
    {
        $i = 0;
        while($table[$i] = mysql_fetch_assoc($result)) 
            $i++;
        unset($table[$i]);                                                                                  
    }                                                                                                                                     
    mysql_free_result($result);
    return $table;
}
function ldimg($string, $type, $align='', $class='', $size='32', $width='32'){
switch ($type) {
    case 'type':
        $ty='Type';$ext='png';
        break;
    case 'char':
        $ty='Character';$ext='jpg';
        break;
    case 'corp':
        $ty='Corporation';$ext='png';
        break;
    case 'render':
        $ty='Render';$ext='png';
        break;
    case 'all':
        $ty='Alliance';$ext='png';
        break;
}
	if (empty($align)){$al='';}else{$al='align="'.$align.'" ';}
	if (empty($class)){$cl='';}else{$cl='class="'.$class.'" ';}
		$result = '<img width="'.$width.'" '.$al.''.$cl.'src="http://image.eveonline.com/'.$ty.'/'.$string.'_'.$size.'.'.$ext.'">';
	return $result;
}
function percent($num_amount, $num_total) {
	$count1 = $num_amount / $num_total;
	$count2 = $count1 * 100;
	$count = number_format($count2, 1);
	return $count;
}
function get_name($string){
	$dbcall=good_query_assoc("SELECT typeName FROM eve_db_invtypes WHERE typeID=$string LIMIT 1");
	return $dbcall['typeName'];
}
function wrt_table($cpad,$cspa,$brd,$wdth,$class=null,$idt=null) {
	if (isset($class)){$clas=' class="'.$class.'"';}else{$clas='';}
	if (isset($idt)){$id=' id="'.$idt.'"';}else{$id='';}
	return '<table cellpadding="'.$cpad.'" cellspacing="'.$cspa.'" border="'.$brd.'" width="'.$wdth.'"'.$clas.''.$id.'>';
}
function show_status($mode,$color,$content=null){
	if ($mode=='text'){
		return '<font color="'.$color.'">'.$content.'</font>';
	}elseif($mode=='img'){
		return '<img alt="'.$content.'" src="./img/'.$color.'">';
	}elseif($mode=='yn'){
		return '<img alt="'.$content.'" src="./img/ico_'.$color.'.png">';
	}
}
function fGetRole($string) {
	$sqlRole = mysql_query("SELECT * FROM fitt_dna_role WHERE id=$string") or die (mysql_error());
	$roleResult = mysql_fetch_array($sqlRole);
	return $roleResult['1'];
}
function fGetShip($string) {
	$sqlShipName = mysql_query("SELECT * FROM fitt_dna_ships WHERE tid=$string") or die (mysql_error());
	$shipNameResult = mysql_fetch_row($sqlShipName);
	return $shipNameResult['3'];
}
function dropdown( $name, array $options, $selected=null ){
    /*** begin the select ***/
    $dropdown = '<select name="'.$name.'" id="'.$name.'">'."\n";
    $selected = $selected;
    /*** loop over the options ***/
    foreach( $options as $key=>$option )
    {
        /*** assign a selected value ***/
        $select = $selected==$option ? ' selected' : null;
        /*** add each option to the dropdown ***/
        //$dropdown .= '<option value="'.$key.'"'.$select.'>'.$option.'</option>'."\n";
        $dropdown .= '<option value="'.$option.'"'.$select.'>'.$option.'</option>'."\n";
    }
    /*** close the select ***/
    $dropdown .= '</select>'."\n";
    /*** and return the completed dropdown ***/
    return $dropdown;
}
?>