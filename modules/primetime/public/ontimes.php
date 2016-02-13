<?php
//page2db();
//session_start();
?>
<script type="text/javascript">
$(document).ready(function() {
	$.fn.graphup.painters.gunghop = function($cell, options) {
		$cell.text($cell.data('percent') + '%');
	}
	$.fn.graphup.colorMaps.gunghoc = [[205,55,0], [00,100,0]];
    $('#table1 td').graphup({
        colorMap: 'gunghoc',
		painter: 'bars',
		barsAlign: 'hcenter',
    });
		$('#table3 td').graphup({
			painter: 'thermometer',
			barsAlign: 'hcenter'
		});
});
</script>
<?php
//	if (isset($getHeaderTrusted)) {if ($getHeaderTrusted == 'No') {echo "no can do!";} else {if  ($getHeaderCorpID == $G_corpID) { // auth part
echo alert_check();
//require_once('func/_secCheck.php');
//echo '<hr>' . getEVEzone('2011-09-04 22:00:00') . '<hr>';
//page2db();
//pagetitle($G_siteTitle,"Online Times");
//error_reporting(E_ALL ^ E_NOTICE);

// ################## Get EVE Time!
$timestamp = time();
$tz = 'GMT';
$dtzone = new DateTimeZone($tz);
$dtime = new DateTime();
$dtime->setTimestamp($timestamp);
$dtime->setTimeZone($dtzone);
//$time = $dtime->format('H');
//$cHour = $dtime->format('Y-m-d H:m:i');
$cHour = $dtime->format('Y-m-d H:i:s');
//$dateEVE = $dtime->format('Y-m-d H:m:i');
$dateEVE = $dtime->format('Y-m-d H:i:s');
$rowBG = getETimeVar(getETimeH($cHour));
$cHour = getETimeVar(getETimeH($cHour));
// ################## Get EVE Time!


$c_m1=0; $c_m2=0; $c_m3=0; $c_m4=0; $c_m5=0; $c_m6=0; $c_m7=0; $c_m8=0; $c_m9=0; $c_m10=0; $c_m11=0; $c_m12=0;
$c_tu1=0; $c_tu2=0; $c_tu3=0; $c_tu4=0; $c_tu5=0; $c_tu6=0; $c_tu7=0; $c_tu8=0; $c_tu9=0; $c_tu10=0; $c_tu11=0; $c_tu12=0;
$c_w1=0; $c_w2=0; $c_w3=0; $c_w4=0; $c_w5=0; $c_w6=0; $c_w7=0; $c_w8=0; $c_w9=0; $c_w10=0; $c_w11=0; $c_w12=0;
$c_th1=0; $c_th2=0; $c_th3=0; $c_th4=0; $c_th5=0; $c_th6=0; $c_th7=0; $c_th8=0; $c_th9=0; $c_th10=0; $c_th11=0; $c_th12=0;
$c_f1=0; $c_f2=0; $c_f3=0; $c_f4=0; $c_f5=0; $c_f6=0; $c_f7=0; $c_f8=0; $c_f9=0; $c_f10=0; $c_f11=0; $c_f12=0;
$c_sa1=0; $c_sa2=0; $c_sa3=0; $c_sa4=0; $c_sa5=0; $c_sa6=0; $c_sa7=0; $c_sa8=0; $c_sa9=0; $c_sa10=0; $c_sa11=0; $c_sa12=0;
$c_su1=0; $c_su2=0; $c_su3=0; $c_su4=0; $c_su5=0; $c_su6=0; $c_su7=0; $c_su8=0; $c_su9=0; $c_su10=0; $c_su11=0; $c_su12=0;
if (!isset($_GET['s'])) {$selView='';}else{$selView=$_GET['s'];}
switch ($selView) {
    case '':
		$ft_sel_cur=' ft_head_sel';
		$ft_sel_7='';
		$ft_sel_30='';
        break;
    case 'curweek':
		$ft_sel_cur=' ft_head_sel';
		$ft_sel_7='';
		$ft_sel_30='';
        break;
    case 'lst7':
		$ft_sel_cur='';
		$ft_sel_7=' ft_head_sel';
		$ft_sel_30='';
        break;
    case 'lst30':
		$ft_sel_cur='';
		$ft_sel_7='';
		$ft_sel_30=' ft_head_sel';
        break;
	default:
		$ft_sel_cur=' ft_head_sel';
		$ft_sel_7='';
		$ft_sel_30='';
        break;
}
echo	'<table cellpadding="0" cellspacing="0" border="0" width="'.$tblWidth.'" align="center">
			<tr>
				<th class="ft_head">&nbsp;</th>
				<th class="ft_head'.$ft_sel_cur.'"><a href="./?p=ontimes&s=curweek">This Week</a></th>
				<th class="ft_head'.$ft_sel_7.'"><a href="./?p=ontimes&s=lst7">Last 7 Days</a></th>
				<th class="ft_head'.$ft_sel_30.'"><a href="./?p=ontimes&s=lst30">Last 30 Days</a></th>
			</tr>
		</table>';



// Time Conversion for database tables!
$start_date_w=strtotime($dateEVE);
	while((date("N",$start_date_w))!=1) {
	$start_date_w=$start_date_w-(60*60*24); // define monday
	}
	$end_date_w=$start_date_w+(60*60*24*6); // define sunday 
$curweekStart = date('Y-m-d H:m:s',$start_date_w);
$curweekEnd = date('Y-m-d H:m:s',$end_date_w);


if (!isset($_GET['s'])) {
	$result = mysql_query("SELECT * FROM ontimes WHERE onTime BETWEEN '".$curweekStart."' AND '".$curweekEnd."'");
} elseif ($_GET['s']=='lst7') {
	$result = mysql_query("SELECT * FROM ontimes WHERE onTime BETWEEN current_date()-7 AND current_date()");
} elseif ($_GET['s']=='lst30') {
	$result = mysql_query("SELECT * FROM ontimes WHERE onTime BETWEEN current_date()-30 AND current_date()");
} elseif ($_GET['s']=='curweek') {
	//$result = mysql_query("SELECT * FROM ontimes WHERE onTime BETWEEN '2011-09-19 19:09:04' AND '2011-09-25 19:09:04' LIMIT 0, 30 ");
	$result = mysql_query("SELECT * FROM ontimes WHERE onTime BETWEEN '".$curweekStart."' AND '".$curweekEnd."'");
}


define("SECONDS_PER_HOUR", 60*60);
$last=0;
while ($row2 = mysql_fetch_array($result)) {


	$strTEST2 = getEDayVar($row2["onTime"]) . getETimeVar(getETimeH($row2["onTime"]));
	//echo $strTEST2 . '<br />';
	//echo getEDayVar($row2["onTime"]) . ' - ';
	//echo getETimeVar(getETimeH($row2["onTime"])) . '<br />';
	//echo $row2["offTime"];
	//echo '<hr>';
	//echo $row2["onTime"] .'<br >';
	//echo '<b>' . compare_dates($row2["onTime"],$row2["offTime"]) . '</b><br /><br />';

	$startdatetime = strtotime($row2["onTime"]);
	$enddatetime = strtotime($row2["offTime"]);
	$difference = $enddatetime - $startdatetime;
	$hoursDiff = $difference / SECONDS_PER_HOUR;
	$minutesDiffRemainder = $difference % SECONDS_PER_HOUR;
	//echo '-'.$hoursDiff . "h " . $minutesDiffRemainder . "m".'- <br />';
	//echo '-'.round($hoursDiff) . "h " . $minutesDiffRemainder . "m".'- <br />';
	$getFastLogonState = number_format($hoursDiff,1); //echo $getFastLogonState . '<br />';



	//echo $strTEST2;
	
	//if ($getFastLogonState < 0.1) {echo 'will not be showed<br />';} else {echo 'will appear<br />';}
	//if ($strTEST2=="m10") echo '10'; if ($strTEST2=="m11") echo '11';if ($strTEST2=="m12") echo '12';



	for($i=1; $i<=$getFastLogonState; $i=$i+1)
	{
		//echo $i.' ' . ' Date:' . $row2['onTime'] . '<br />';
		//echo $row2["onTime"] . '<br />';
		
		//$doTransformTime = strtotime(date("Y-m-d H:m:s", strtotime($row2["onTime"])) . " +1 hour");
		$doTransformTime = strtotime(date("Y-m-d H:m:s", strtotime($row2["onTime"])) . " +$i hour");
		
		//echo $doTransformTime . '<br />';
		//echo date('Y-m-d H:m:s',$doTransformTime) . '-';
		$doTransformTimeEVE = date('Y-m-d H:m:s',$doTransformTime);
		//$strTEST2 = getEDayVar($row2["onTime"]) . getETimeVar(getETimeH($row2["onTime"]));
		$strTEST3 = getEDayVar($doTransformTimeEVE) . getETimeVar(getETimeH($doTransformTimeEVE));
		//echo 'STRTEST3: '.$strTEST3 . '<br />';
		//echo 'LAST: '.$last . '<br />';

		if(!strcmp($last,$strTEST3) == 0) {
		// print out result
			//echo 'ding <br />';
							if (getEDayVar($row2["onTime"])=="m") {
								if ($strTEST3=="m1") $c_m1++; if ($strTEST3=="m2") $c_m2++; if ($strTEST3=="m3") $c_m3++; if ($strTEST3=="m4") $c_m4++; if ($strTEST3=="m5") $c_m5++; if ($strTEST3=="m6") $c_m6++; if ($strTEST3=="m7") $c_m7++; if ($strTEST3=="m8") $c_m8++; if ($strTEST3=="m9") $c_m9++; if ($strTEST3=="m10") $c_m10++; if ($strTEST3=="m11") $c_m11++; if ($strTEST3=="m12") $c_m12++;
							} elseif (getEDayVar($row2["onTime"])=="tu") {
								if ($strTEST3=="tu1") $c_tu1++; if ($strTEST3=="tu2") $c_tu2++; if ($strTEST3=="tu3") $c_tu3++; if ($strTEST3=="tu4") $c_tu4++; if ($strTEST3=="tu5") $c_tu5++; if ($strTEST3=="tu6") $c_tu6++; if ($strTEST3=="tu7") $c_tu7++; if ($strTEST3=="tu8") $c_tu8++; if ($strTEST3=="tu9") $c_tu9++; if ($strTEST3=="tu10") $c_tu10++; if ($strTEST3=="tu11") $c_tu11++; if ($strTEST3=="tu12") $c_tu12++;
							} elseif (getEDayVar($row2["onTime"])=="w") {
								if ($strTEST3=="w1") $c_w1++; if ($strTEST3=="w2") $c_w2++; if ($strTEST3=="w3") $c_w3++; if ($strTEST3=="w4") $c_w4++; if ($strTEST3=="w5") $c_w5++; if ($strTEST3=="w6") $c_w6++; if ($strTEST3=="w7") $c_w7++; if ($strTEST3=="w8") $c_w8++; if ($strTEST3=="w9") $c_w9++; if ($strTEST3=="w10") $c_w10++; if ($strTEST3=="w11") $c_w11++; if ($strTEST3=="w12") $c_w12++;
							} elseif (getEDayVar($row2["onTime"])=="th") {
								if ($strTEST3=="th1") $c_th1++; if ($strTEST3=="th2") $c_th2++; if ($strTEST3=="th3") $c_th3++; if ($strTEST3=="th4") $c_th4++; if ($strTEST3=="th5") $c_th5++; if ($strTEST3=="th6") $c_th6++; if ($strTEST3=="th7") $c_th7++; if ($strTEST3=="th8") $c_th8++; if ($strTEST3=="th9") $c_th9++; if ($strTEST3=="th10") $c_th10++; if ($strTEST3=="th11") $c_th11++; if ($strTEST3=="th12") $c_th12++;
							} elseif (getEDayVar($row2["onTime"])=="f") {
								if ($strTEST3=="f1") $c_f1++; if ($strTEST3=="f2") $c_f2++; if ($strTEST3=="f3") $c_f3++; if ($strTEST3=="f4") $c_f4++; if ($strTEST3=="f5") $c_f5++; if ($strTEST3=="f6") $c_f6++; if ($strTEST3=="f7") $c_f7++; if ($strTEST3=="f8") $c_f8++; if ($strTEST3=="f9") $c_f9++; if ($strTEST3=="f10") $c_f10++; if ($strTEST3=="f11") $c_f11++; if ($strTEST3=="f12") $c_f12++;
							} elseif (getEDayVar($row2["onTime"])=="sa") {
								if ($strTEST3=="sa1") $c_sa1++; if ($strTEST3=="sa2") $c_sa2++; if ($strTEST3=="sa3") $c_sa3++; if ($strTEST3=="sa4") $c_sa4++; if ($strTEST3=="sa5") $c_sa5++; if ($strTEST3=="sa6") $c_sa6++; if ($strTEST3=="sa7") $c_sa7++; if ($strTEST3=="sa8") $c_sa8++; if ($strTEST3=="sa9") $c_sa9++; if ($strTEST3=="sa10") $c_sa10++; if ($strTEST3=="sa11") $c_sa11++; if ($strTEST3=="sa12") $c_sa12++;
							} elseif (getEDayVar($row2["onTime"])=="su") {
								if ($strTEST3=="su1") $c_su1++; if ($strTEST3=="su2") $c_su2++; if ($strTEST3=="su3") $c_su3++; if ($strTEST3=="su4") $c_su4++; if ($strTEST3=="su5") $c_su5++; if ($strTEST3=="su6") $c_su6++; if ($strTEST3=="su7") $c_su7++; if ($strTEST3=="su8") $c_su8++; if ($strTEST3=="su9") $c_su9++; if ($strTEST3=="su10") $c_su10++; if ($strTEST3=="su11") $c_su11++; if ($strTEST3=="su12") $c_su12++;
							}
							//echo $strTEST3 . '<br />';
							$last = $strTEST3;
		}
//$last = $strTEST3;

// will there be magic ?






	}


}
/*
    // all timestamps are in seconds, so define the number of seconds in one hour
    define("SECONDS_PER_HOUR", 60*60);
    // get the data from the database
    $result = mysql_query("select ss_datestart, ss_timestart, ss_dateend, ss_timeend from datetimetable") or die(mysql_error());
    while($row = mysql_fetch_assoc($result))
    {
    // calculate the start timestamp
    $startdatetime = strtotime($row["ss_datestart"] . " " . $row["ss_timestart"]);
    // calculate the end timestamp
    $enddatetime = strtotime($row["ss_dateend"] . " " . $row["ss_timeend"]);
    // calulate the difference in seconds
    $difference = $enddatetime - $startdatetime;
    // hours is the whole number of the division between seconds and SECONDS_PER_HOUR
    $hoursDiff = $difference / SECONDS_PER_HOUR;
    // and the minutes is the remainder
    $minutesDiffRemainder = $difference % SECONDS_PER_HOUR;
    // output the result
    echo $hoursDiff . "h " . $minutesDiffRemainder . "m";
    }
*/

/*

				while ($row = mysql_fetch_array($result)) {
					//$strTEST = getEDayVar($row["onTime"]) . getETimeVar(getETimeH($row["onTime"]));
					//echo $row["onTime"] . '<br>';
					$strTEST = getEDayVar($row["onTime"]) . getETimeVar(getETimeH($row["onTime"])); //Patched final try!
					//echo $strTEST;
							if (getEDayVar($row["onTime"])=="m") {
								if ($strTEST=="m1") $c_m1++; if ($strTEST=="m2") $c_m2++; if ($strTEST=="m3") $c_m3++; if ($strTEST=="m4") $c_m4++; if ($strTEST=="m5") $c_m5++; if ($strTEST=="m6") $c_m6++; if ($strTEST=="m7") $c_m7++; if ($strTEST=="m8") $c_m8++; if ($strTEST=="m9") $c_m9++; if ($strTEST=="m10") $c_m10++; if ($strTEST=="m11") $c_m11++; if ($strTEST=="m12") $c_m12++;
							} elseif (getEDayVar($row["onTime"])=="tu") {
								if ($strTEST=="tu1") $c_tu1++; if ($strTEST=="tu2") $c_tu2++; if ($strTEST=="tu3") $c_tu3++; if ($strTEST=="tu4") $c_tu4++; if ($strTEST=="tu5") $c_tu5++; if ($strTEST=="tu6") $c_tu6++; if ($strTEST=="tu7") $c_tu7++; if ($strTEST=="tu8") $c_tu8++; if ($strTEST=="tu9") $c_tu9++; if ($strTEST=="tu10") $c_tu10++; if ($strTEST=="tu11") $c_tu11++; if ($strTEST=="tu12") $c_tu12++;
							} elseif (getEDayVar($row["onTime"])=="w") {
								if ($strTEST=="w1") $c_w1++; if ($strTEST=="w2") $c_w2++; if ($strTEST=="w3") $c_w3++; if ($strTEST=="w4") $c_w4++; if ($strTEST=="w5") $c_w5++; if ($strTEST=="w6") $c_w6++; if ($strTEST=="w7") $c_w7++; if ($strTEST=="w8") $c_w8++; if ($strTEST=="w9") $c_w9++; if ($strTEST=="w10") $c_w10++; if ($strTEST=="w11") $c_w11++; if ($strTEST=="w12") $c_w12++;
							} elseif (getEDayVar($row["onTime"])=="th") {
								if ($strTEST=="th1") $c_th1++; if ($strTEST=="th2") $c_th2++; if ($strTEST=="th3") $c_th3++; if ($strTEST=="th4") $c_th4++; if ($strTEST=="th5") $c_th5++; if ($strTEST=="th6") $c_th6++; if ($strTEST=="th7") $c_th7++; if ($strTEST=="th8") $c_th8++; if ($strTEST=="th9") $c_th9++; if ($strTEST=="th10") $c_th10++; if ($strTEST=="th11") $c_th11++; if ($strTEST=="th12") $c_th12++;
							} elseif (getEDayVar($row["onTime"])=="f") {
								if ($strTEST=="f1") $c_f1++; if ($strTEST=="f2") $c_f2++; if ($strTEST=="f3") $c_f3++; if ($strTEST=="f4") $c_f4++; if ($strTEST=="f5") $c_f5++; if ($strTEST=="f6") $c_f6++; if ($strTEST=="f7") $c_f7++; if ($strTEST=="f8") $c_f8++; if ($strTEST=="f9") $c_f9++; if ($strTEST=="f10") $c_f10++; if ($strTEST=="f11") $c_f11++; if ($strTEST=="f12") $c_f12++;
							} elseif (getEDayVar($row["onTime"])=="sa") {
								if ($strTEST=="sa1") $c_sa1++; if ($strTEST=="sa2") $c_sa2++; if ($strTEST=="sa3") $c_sa3++; if ($strTEST=="sa4") $c_sa4++; if ($strTEST=="sa5") $c_sa5++; if ($strTEST=="sa6") $c_sa6++; if ($strTEST=="sa7") $c_sa7++; if ($strTEST=="sa8") $c_sa8++; if ($strTEST=="sa9") $c_sa9++; if ($strTEST=="sa10") $c_sa10++; if ($strTEST=="sa11") $c_sa11++; if ($strTEST=="sa12") $c_sa12++;
							} elseif (getEDayVar($row["onTime"])=="su") {
								if ($strTEST=="su1") $c_su1++; if ($strTEST=="su2") $c_su2++; if ($strTEST=="su3") $c_su3++; if ($strTEST=="su4") $c_su4++; if ($strTEST=="su5") $c_su5++; if ($strTEST=="su6") $c_su6++; if ($strTEST=="su7") $c_su7++; if ($strTEST=="su8") $c_su8++; if ($strTEST=="su9") $c_su9++; if ($strTEST=="su10") $c_su10++; if ($strTEST=="su11") $c_su11++; if ($strTEST=="su12") $c_su12++;
							}
				}

*/
mysql_free_result($result);
$cDay=date("D");
?><p>&nbsp;</p>
<table id="table1" cellspacing="0" width="<?php echo $tblWidth; ?>" class="center vcenter">
	<tr>
	<th class="tdata" style="width:8em"></th>
		<th class="tdata<?php if ($cDay=="Mon") {echo ' ot_d_sel';} ?>">Monday</th>
		<th class="tdata<?php if ($cDay=="Tue") {echo ' ot_d_sel';} ?>">Tuesday</th>
		<th class="tdata<?php if ($cDay=="Wed") {echo ' ot_d_sel';} ?>">Wednesday</th>
		<th class="tdata<?php if ($cDay=="Thu") {echo ' ot_d_sel';} ?>">Thursday</th>
		<th class="tdata<?php if ($cDay=="Fri") {echo ' ot_d_sel';} ?>">Friday</th>
		<th class="tdata<?php if ($cDay=="Sat") {echo ' ot_d_sel';} ?>">Saturday</th>
		<th class="tdata<?php if ($cDay=="Sun") {echo ' ot_d_sel';} ?>">Sunday</th>
	</tr>
	<tr>
	<th scope="row"<?php if ($cHour==1) {echo ' class="ot_sel"';} ?>>00:00-02:00</th>
		<td class="tdata<?php if ($cHour==1 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m1; ?></td>
		<td class="tdata<?php if ($cHour==1 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu1; ?></td>
		<td class="tdata<?php if ($cHour==1 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w1; ?></td>
		<td class="tdata<?php if ($cHour==1 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th1; ?></td>
		<td class="tdata<?php if ($cHour==1 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f1; ?></td>
		<td class="tdata<?php if ($cHour==1 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa1; ?></td>
		<td class="tdata<?php if ($cHour==1 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su1; ?></td>
	</tr>
	<tr>
	<th scope="row"<?php if ($cHour==2) {echo ' class="ot_sel"';} ?>>02:00-04:00</th>
		<td class="tdata<?php if ($cHour==2 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m2; ?></td>
		<td class="tdata<?php if ($cHour==2 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu2; ?></td>
		<td class="tdata<?php if ($cHour==2 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w2; ?></td>
		<td class="tdata<?php if ($cHour==2 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th2; ?></td>
		<td class="tdata<?php if ($cHour==2 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f2; ?></td>
		<td class="tdata<?php if ($cHour==2 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa2; ?></td>
		<td class="tdata<?php if ($cHour==2 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su2; ?></td>
	</tr>
<tr>
	<th scope="row"<?php if ($cHour==3) {echo ' class="ot_sel"';} ?>>04:00-06:00</th>
		<td class="tdata<?php if ($cHour==3 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m3; ?></td>
		<td class="tdata<?php if ($cHour==3 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu3; ?></td>
		<td class="tdata<?php if ($cHour==3 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w3; ?></td>
		<td class="tdata<?php if ($cHour==3 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th3; ?></td>
		<td class="tdata<?php if ($cHour==3 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f3; ?></td>
		<td class="tdata<?php if ($cHour==3 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa3; ?></td>
		<td class="tdata<?php if ($cHour==3 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su3; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==4) {echo ' class="ot_sel"';} ?>>06:00-08:00</th>
		<td class="tdata<?php if ($cHour==4 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m4; ?></td>
		<td class="tdata<?php if ($cHour==4 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu4; ?></td>
		<td class="tdata<?php if ($cHour==4 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w4; ?></td>
		<td class="tdata<?php if ($cHour==4 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th4; ?></td>
		<td class="tdata<?php if ($cHour==4 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f4; ?></td>
		<td class="tdata<?php if ($cHour==4 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa4; ?></td>
		<td class="tdata<?php if ($cHour==4 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su4; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==5) {echo ' class="ot_sel"';} ?>>08:00-10:00</th>
		<td class="tdata<?php if ($cHour==5 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m5; ?></td>
		<td class="tdata<?php if ($cHour==5 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu5; ?></td>
		<td class="tdata<?php if ($cHour==5 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w5; ?></td>
		<td class="tdata<?php if ($cHour==5 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th5; ?></td>
		<td class="tdata<?php if ($cHour==5 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f5; ?></td>
		<td class="tdata<?php if ($cHour==5 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa5; ?></td>
		<td class="tdata<?php if ($cHour==5 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su5; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==6) {echo ' class="ot_sel"';} ?>>10:00-12:00</th>
		<td class="tdata<?php if ($cHour==6 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m6; ?></td>
		<td class="tdata<?php if ($cHour==6 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu6; ?></td>
		<td class="tdata<?php if ($cHour==6 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w6; ?></td>
		<td class="tdata<?php if ($cHour==6 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th6; ?></td>
		<td class="tdata<?php if ($cHour==6 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f6; ?></td>
		<td class="tdata<?php if ($cHour==6 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa6; ?></td>
		<td class="tdata<?php if ($cHour==6 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su6; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==7) {echo ' class="ot_sel"';} ?>>12:00-14:00</th>
		<td class="tdata<?php if ($cHour==7 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m7; ?></td>
		<td class="tdata<?php if ($cHour==7 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu7; ?></td>
		<td class="tdata<?php if ($cHour==7 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w7; ?></td>
		<td class="tdata<?php if ($cHour==7 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th7; ?></td>
		<td class="tdata<?php if ($cHour==7 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f7; ?></td>
		<td class="tdata<?php if ($cHour==7 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa7; ?></td>
		<td class="tdata<?php if ($cHour==7 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su7; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==8) {echo ' class="ot_sel"';} ?>>14:00-16:00</th>
		<td class="tdata<?php if ($cHour==8 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m8; ?></td>
		<td class="tdata<?php if ($cHour==8 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu8; ?></td>
		<td class="tdata<?php if ($cHour==8 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w8; ?></td>
		<td class="tdata<?php if ($cHour==8 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th8; ?></td>
		<td class="tdata<?php if ($cHour==8 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f8; ?></td>
		<td class="tdata<?php if ($cHour==8 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa8; ?></td>
		<td class="tdata<?php if ($cHour==8 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su8; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==9) {echo ' class="ot_sel"';} ?>>16:00-18:00</th>
		<td class="tdata<?php if ($cHour==9 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m9; ?></td>
		<td class="tdata<?php if ($cHour==9 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu9; ?></td>
		<td class="tdata<?php if ($cHour==9 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w9; ?></td>
		<td class="tdata<?php if ($cHour==9 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th9; ?></td>
		<td class="tdata<?php if ($cHour==9 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f9; ?></td>
		<td class="tdata<?php if ($cHour==9 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa9; ?></td>
		<td class="tdata<?php if ($cHour==9 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su9; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==19) {echo ' class="ot_sel"';} ?>>18:00-20:00</th>
		<td class="tdata<?php if ($cHour==10 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m10; ?></td>
		<td class="tdata<?php if ($cHour==10 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu10; ?></td>
		<td class="tdata<?php if ($cHour==10 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w10; ?></td>
		<td class="tdata<?php if ($cHour==10 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th10; ?></td>
		<td class="tdata<?php if ($cHour==10 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f10; ?></td>
		<td class="tdata<?php if ($cHour==10 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa10; ?></td>
		<td class="tdata<?php if ($cHour==10 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su10; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==11) {echo ' class="ot_sel"';} ?>>20:00-22:00</th>
		<td class="tdata<?php if ($cHour==11 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m11; ?></td>
		<td class="tdata<?php if ($cHour==11 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu11; ?></td>
		<td class="tdata<?php if ($cHour==11 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w11; ?></td>
		<td class="tdata<?php if ($cHour==11 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th11; ?></td>
		<td class="tdata<?php if ($cHour==11 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f11; ?></td>
		<td class="tdata<?php if ($cHour==11 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa11; ?></td>
		<td class="tdata<?php if ($cHour==11 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su11; ?></td>
</tr>
<tr>
	<th scope="row"<?php if ($cHour==12) {echo ' class="ot_sel"';} ?>>22:00-24:00</th>
		<td class="tdata<?php if ($cHour==12 || ($cDay=='Mon')) {echo ' ot_sel';} ?>"><?php echo $c_m12; ?></td>
		<td class="tdata<?php if ($cHour==12 || ($cDay=='Tue')) {echo ' ot_sel';} ?>"><?php echo $c_tu12; ?></td>
		<td class="tdata<?php if ($cHour==12 || ($cDay=='Wed')) {echo ' ot_sel';} ?>"><?php echo $c_w12; ?></td>
		<td class="tdata<?php if ($cHour==12 || ($cDay=='Thu')) {echo ' ot_sel';} ?>"><?php echo $c_th12; ?></td>
		<td class="tdata<?php if ($cHour==12 || ($cDay=='Fri')) {echo ' ot_sel';} ?>"><?php echo $c_f12; ?></td>
		<td class="tdata<?php if ($cHour==12 || ($cDay=='Sat')) {echo ' ot_sel';} ?>"><?php echo $c_sa12; ?></td>
		<td class="tdata<?php if ($cHour==12 || ($cDay=='Sun')) {echo ' ot_sel';} ?>"><?php echo $c_su12; ?></td>
	</tr>
</table>
<br />
<center>Notice: All times are GMT, EVE time!</center>
<p class="notice">Notice: Coloring is for easyreading, to see what times are most populated. The number is 'how many' has been registerd online at that given time.<br />All stat's are based on unique characters login and logout time and the time between! These stat's are also not "Live", in other words, this is not realtime<br />As with all stat's available in the world, they are all more like guidelines.<br />The more data collected the better average will be coverd.</p>
<?php
//	}}}
?>