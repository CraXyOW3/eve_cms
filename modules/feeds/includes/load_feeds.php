<?php
//sleep(1);
if (isset($_GET['load'])){
include('../../../includes/functions.php');
if ($_GET['load']=='edev'){
//sleep(2);
}elseif($_GET['load']=='erole'){
//sleep(4);
}elseif($_GET['load']=='enews'){
//sleep(5);
}

function simplexml_unCDATAise($xml) {
    $new_xml = NULL;
    preg_match_all("/\<\!\[CDATA\[(.*)\]\]\>/U", $xml, $args);
    if (is_array($args)) {
        if (isset($args[0]) && isset($args[1])) {
            $new_xml = $xml;
            for ($i=0; $i<count($args[0]); $i++) {
                $old_text = $args[0][$i];
                $new_text = htmlspecialchars($args[1][$i]);
                $new_xml = str_replace($old_text, $new_text, $new_xml);
            }
        }
    }
    return $new_xml;
}


$tag = mysql_real_escape_string($_GET['load']);
$xmlFile = '../../../cache/xml/feeds_'.$tag.'.xml';

$xml = simplexml_load_file($xmlFile);


echo	wrt_table(0,0,0,'100%','center');
$items = $xml->item;
	foreach($items as $item){
		echo	'<tr>';
		echo	'<th class="ft_head font_m left"><a href="'.$item->link.'" target="_blank">'.$item->title.'</a></th>';
		echo	'</tr><tr>';
		echo	'<td class="font_s">'.trim_text($item->description,240).'</td>';
		echo	'</tr>';
		echo	'<tr><td>&nbsp;</td></tr>';
	}
echo	'</table>';
}
?>