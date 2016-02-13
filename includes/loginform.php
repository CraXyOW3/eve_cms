<?php
//session_start();
//echo alert_check();
?>
<style type="text/css">
	.loginStyle {color:#c0c0c0; font-size:20px !important; font-weight:bold;}
</style>
<script type="text/javascript">
$(function(){
$('#dialog').dialog({
	modal:true,
	width: 330,
	resizable: false,
	buttons: {
			"OK": function () {
				$("#login").submit()
				}
			}
	});
	$(".ui-dialog-titlebar-close").hide();
	$('#dialog_link').click(function(){
	$('#dialog').dialog('open');
	return false;
	});
	$('#dialog_link, ul#icons li').hover(
	function() { $(this).addClass('ui-state-hover'); },
	function() { $(this).removeClass('ui-state-hover'); }
	); 
});
</script>
<div id="dialog" title="Enter Global Password"><form action="./loginhandler.php" method="post" id="login" name="login"><br /><center><input name="login" type="text" class="loginStyle" id="login" size="20"></center><form></div>