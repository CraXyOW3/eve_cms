<?php
include($module_dir.'hud/config.php');
?>
<style type="text/css">
#container			{clear: both;margin: 0;padding: 0;}
#container a		{float: right; background: #9FC54E; border: 1px solid #9FC54E; -moz-border-radius-topright: 20px; -webkit-border-top-right-radius: 20px; -moz-border-radius-bottomleft: 20px; -webkit-border-bottom-left-radius: 20px; text-decoration: none; font-size: 16px; letter-spacing:-1px; font-family: verdana, helvetica, arial, sans-serif;color:#fff; padding: 20px; font-weight: 700; border:solid 1px #00ff00;}
#container a:hover{float: right; background: #a0a0a0; border: 1px solid #cccccc; -moz-border-radius-topright: 20px; -webkit-border-top-right-radius: 20px; -moz-border-radius-bottomleft: 20px; -webkit-border-bottom-left-radius: 20px; text-decoration: none; font-size: 16px; letter-spacing:-1px; font-family: verdana, helvetica, arial, sans-serif; color:#fff; padding: 20px; font-weight: 700;}
.content			{font-style:normal; font-family:helvetica, arial, verdana, sans-serif; color:#ffffff; background:#333333; border:1px solid #444444; margin: 30px 0 50px; padding: 15px 0;}
.content p			{margin: 10px 0; padding: 15px 20px;}
.panel				{position: absolute; top: 20px; right: 0; display: none; background: #000000; border:1px solid #c0c0c0; width: 300px; height: auto; padding: 5px 5px 5px 5px; filter: alpha(opacity=85); opacity: .85;}
.panel p			{margin: 0 0 15px 0; padding: 0; color: #cccccc;}
.panel a, .panel a:visited{margin: 0; padding: 0; color: #9FC54E; text-decoration: none;}
.panel a:hover, .panel a:visited:hover{margin: 0; padding: 0; color: #ffffff; text-decoration: none;}
a.trigger			{position: absolute; text-decoration: none; top: 30px; right: 0; font-size: 14px; letter-spacing:-1px; font-family: verdana, helvetica, arial, sans-serif; color:#fff; padding: 5px 5px 5px 5px; font-weight: 700; border:1px solid #cccccc; display: block;}
a.trigger:hover		{position: absolute; text-decoration: none; top: 30px; right: 0; font-size: 14px; letter-spacing:-1px; font-family: verdana, helvetica, arial, sans-serif; color:#fff; padding: 5px 7px 5px 5px; font-weight: 700; border:1px solid #ccff99; display: block;}
a.active.trigger	{border:1px solid #66cb00;}
.columns			{clear: both; width: 330px; padding: 0 0 20px 0; line-height: 22px;}
.colleft			{float: left; width: 130px; line-height: 22px;}
.colright			{float: right; width: 130px; line-height: 22px;}
</style>
<script type="text/javascript">
function  contentDisp()
{
	$.ajax({
	url : "./modules/hud/includes/hud.php",
	success : function (data) {
	$("#contentArea").html(data);
	}
	});
}
function  contentSett()
{
	$.ajax({
	url : "./modules/hud/includes/hud_settings.php",
	success : function (data) {
	$("#contentArea").html(data);
	}
	});
}
</script>
<script type="text/javascript">
$(document).ready(function(){
	$(".trigger").click(function(){
		$(".panel").toggle("fast");
		$(this).toggleClass("active");
		//return false;
		{
			$.ajax({
			url : "./modules/hud/includes/hud.php",
			success : function (data) {
			$("#contentArea").html(data);
			}
			});
		};
		return false;
	});
});
</script>

<script type="text/javascript"> 
function submitForm() {
    $.ajax({type:'POST', url: '/modules/hud/hud_handler.php?set=standingsapi', data:$('#ag_lvl_form').serialize(), success: function(response) {
        $('#ag_lvl_form').find('.form_result').html(response);
    }});
    return false;
}
</script>
<div class="panel"><?php
//$wrt = '<a href="javascript:void(0)" onClick="contentDisp()">Reload</a> - <a href="javascript:void(0)" onClick="contentSett()">Settings</a><div id="contentArea"></div>';
$wrt = '<a href="javascript:void(0)" onClick="contentDisp()">Reload</a><div id="contentArea"></div>';
echo $wrt;
?></div>
<a class="trigger" href="#">LocAgent</a>