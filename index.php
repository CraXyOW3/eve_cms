<?php
session_start();
include('./config.php');
include('./includes/top.php');
//sleep(3);

echo	'<table border="0" class="gmain">
		<tr><td class="gmenu">';
		include('includes/navigation.php');
echo	'</td>
		<td class="cont">';
			if(isset( $_POST["module"] ) || isset( $_GET["module"])){
				$module = isset($_GET["module"]) ? $_GET["module"] : $_POST["module"];
					//if( in_array( trim ( $module ), $allowed )) {
					$file = getModule($module);
						if( (file_exists( $file ))) {
							include( $file );
						} else {
							include( $default );
						}
					//} else {
					//include( $default );
					//}
				}else{
					include( $default );
				}
echo	'</td></tr></table>';

include('includes/bot.php');
?>