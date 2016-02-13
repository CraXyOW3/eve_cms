<?php
if (isset($getHeaderTrusted)) {if ($getHeaderTrusted == 'No') {echo "no can do!";} else {if  ($getHeaderCorpID == $G_corpID) { // auth part
if ($isDirector) {

echo	'<script>
			$(function() {
			$( "input:submit, input:button").button();
			$( "#check" ).button();
		});
</script>';


//#################################################

//#################################################
$multiplier=5;
$multiplierm=2;
for ($i=1;$i<=10;$i++){$counter[] = $multiplier*$i;}
for ($i=1;$i<=10;$i++){$counterm[] = $multiplierm*$i;}
for ($i=1;$i<=6;$i++){$weeks[] = $i;}

$row = good_query_assoc("SELECT * FROM settings");
$wrt	=	'<form method="post" action="./?p=data&mode=site"><table cellpadding="0" cellspacing="0" border="1" class="center" width="'.$tblWidth.'">';
$wrt	.=	'<tr><th class="ft_head left" colspan="2">Settings</th></tr>';

$wrt	.=	'<tr><td>';
$wrt	.=	'<fieldset>';
$wrt	.=	'<legend>Pagination stuff</legend>';
$wrt	.=	'';
$wrt	.=	'<table cellpadding="0" cellspacing="0" border="0" width="100%">';
$wrt	.=	'<tr><td class="left">Number of Bulletins</td><td class="left">'.dropdown('bulletins',$counter,$row['bulletins']).'</td></tr>';
$wrt	.=	'<tr><td class="left">Forum Threads</td><td class="left">'.dropdown('threads',$counter,$row['forum_threads']).'</td></tr>';
//$wrt	.=	'<tr><td class="left">Forum Topics</td><td class="left">'.dropdown('topic',$counter,$row['forum_topics']).'</td></tr>';
$wrt	.=	'<tr><td class="left">Forum Posts</td><td class="left">'.dropdown('posts',$counter,$row['forum_posts']).'</td></tr>';
$wrt	.=	'<tr><td class="left">Forum Overview</td><td class="left">'.dropdown('overview',$counter,$row['forum_overview']).'</td></tr>';

$wrt	.=	'<tr><td class="left">Members</td><td class="left">'.dropdown('members',$counterm,$row['pages_members']).'</td></tr>';
$wrt	.=	'<tr><td class="left">Kills</td><td class="left">'.dropdown('kills',$counter,$row['pages_kills']).'</td></tr>';
$wrt	.=	'</table>';
$wrt	.=	'</fieldset>';
$wrt	.=	'</td><td>';
$wrt	.=	'<fieldset>';
$wrt	.=	'<legend>Global Password Settings</legend>';
$wrt	.=	'<table cellpadding="0" cellspacing="0" border="0" width="100%">';
$wrt	.=	'<tr><td class="left">Global Password</td><td class="left"><input type="text" name="gpwd" value="'.$row['global_pwd'].'"></td></tr>';
$wrt	.=	'<tr><td class="left">ReEntry Interval</td><td class="left">'.dropdown('interval',$weeks,$row['global_pwd_interval']).'weeks</td></tr>';
$wrt	.=	'<tr><td class="left">Reset Auth\'s</td><td class="left"><input type="checkbox" id="check" name="reset" value="1" /><label for="check">Force Reset</label></td></tr>';
$wrt	.=	'</table>';
$wrt	.=	'</fieldset>';
$wrt	.=	'</td></tr>';
$wrt	.=	'<tr><td><input type="submit" value="update"></td></tr>';


$wrt	.=	'<tr><td colspan="2">&nbsp;</td></tr>';
$wrt	.=	'<tr><td colspan="2">';

$wrt	.=	wrt_table(0,0,0,'400','center');
//$wrt	.='<tr><td>';
$wrt	.='<tr><td>Module</td><td>Exists</td><td>Admin</td><td>Data</td><td>Public</td><td>State</td></tr>';
$root='modules';
if ($handle = opendir($root)) {
    while (false !== ($module = readdir($handle))) {
	if ( $evenOdd ) {$odder = "even"; $splitter = false;}else{$odder = "odd"; $splitter = true;}
	$evenOdd = !$evenOdd;
	$i=0;
        if ($module != "." && $module != "..") {
			if (file_exists($root.'/'.$module.'/config.php')){
			$fh = fopen($root.'/'.$module.'/config.php', 'rb');
			$arr = array();
				while($line = fgets($fh)) {
				$parts = explode(',', $line);
					switch($parts[0]) {
						case '#module_name':
							$arr['module_name'] = $parts[1];
							break;
						case '#module_description':
							$arr['module_description'] = $parts[1];
							break;
						case '#module_req':
							$arr['module_req'] = $parts[1];
							break;
						case '#module_id':
							$arr['module_id'] = $parts[1];
							break;
				   }
				}
				$mnm = $arr['module_name'];
				$mdescr = $arr['module_description'];
				$mreq = $arr['module_req'];
				$mid = $arr['module_id'];
			}
            $wrt .= '<tr><td class="tcell'.$odder.'">'.$module.'</td>';
			if (file_exists($root.'/'.$module.'/index.php')){
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','yes').'</td>';
				$i++;
			}else{
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','no').'</td>';
			}
			if (file_exists($root.'/'.$module.'/admin/index.php')){
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','yes').'</td>';
				$i++;
			}else{
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','no').'</td>';
			}
			if (file_exists($root.'/'.$module.'/handler/index.php')){
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','yes').'</td>';
				$i++;
			}else{
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','no').'</td>';
			}
			if (file_exists($root.'/'.$module.'/public/index.php')){
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','yes').'</td>';
				$i++;
			}else{
				$wrt .= '<td class="tcell'.$odder.'">'.show_status('yn','no').'</td>';
			}

			global $mnm, $mdescr, $mreq, $mid;
			if ($i ==$mreq){
				$mod_row = good_query_assoc("SELECT * FROM modules WHERE module_id = $mid");
					if ($mod_row){
						$wrt .= '<td class="tcell'.$odder.' font_s">installed</td>';
					}else{
						$wrt .= '<td class="tcell'.$odder.' font_s">Install</td>';
					}
			}else{
				$wrt .= '<td class="tcell'.$odder.' font_s">Broken</td>';
			}
			$wrt .= '<tr><td class="tcell'.$odder.' border_bottom font_s">&nbsp;</td><td class="tcell'.$odder.' border_bottom font_s">'.$mnm.'</td><td colspan="4" class="tcell'.$odder.' border_bottom font_s">'.$mdescr.'</td></tr>';
		}
    }
    closedir($handle);
}

$wrt	.='';
$wrt	.='';
$wrt	.='';
$wrt	.='';
//$wrt	.='</td></tr>';
$wrt	.='';
$wrt	.='';
$wrt	.='</table>';


$wrt	.=	'</td></tr>';









$wrt	.=	'</form></table>';





echo	$wrt;
}}}}


?>



