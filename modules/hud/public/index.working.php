<style>
#page_container {
	position: relative;
	margin-left: auto;
	margin-right: auto;
	width: 900px;
	top: -80px;
}
.panel_button {
	margin-left: auto;
	margin-right: auto;
	position: relative;
	top: -3px;
	width: 173px;
	height: 54px;
	background: url(./img/hud/panel_button.png);
	z-index: 20;
	filter:alpha(opacity=70);
	-moz-opacity:0.70;
	-khtml-opacity: 0.70;
	opacity: 0.70;
	cursor: pointer;
}
.panel_button img {
	position: relative;
	top: 10px;
	border: none;
}
.panel_button a {
	text-decoration: none;
	color: #545454;
	font-size: 10px;
	font-weight: bold;
	position: relative;
	top: 5px;
	left: 10px;
	font-family: Arial, Helvetica, sans-serif;
}
.panel_button a:hover {
	color: #999999;
}
#wrapper {
	margin-left: auto;
	margin-right: auto;
	width: 900px;
	text-align: center;
}
#toppanel {
	position: absolute;
	width: 900px;
	left: 0px;
	z-index: 25;
	text-align: center;

}
#panel {
	width: 900px;
	position: relative;
	top: 1px;
	height: 0px;
	margin-left: auto;
	margin-right: auto;
	z-index: 10;
	overflow: hidden;
	text-align: left;
}
#panel_contents {
	background: #666666;
	filter:alpha(opacity=70);
	-moz-opacity:0.70;
	-khtml-opacity: 0.70;
	opacity: 0.70;
	height: 99%;
	width: 860px;
	position: absolute;
	z-index: -1;
}
#panel h1 {
	text-align: center;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: white;
	font-weight: normal;
	line-height: 35px;
	left: 275px;
	position: absolute;
	top: 10px;
}
#panel h2 {
	text-align: center;
	font-family: Geneva, Arial, Helvetica, sans-serif;
	color: #447c6f;
	line-height: 25px;
	font-size: 16px;
	position: absolute;
	top: 60px;
	left: 350px;
}

.border {
	border: 15px #1d1d1d solid;
}
img.border {
	float: left;
	margin-right: 15px;
	margin-bottom: 8px;
}
img.border_pic {
	border: 15px #1d1d1d solid;
	position: absolute;
	top: 110px;
	float: left;
	margin-left: 150px;
	width: 250px;
	height: 150px;
	z-index: 30;
}
</style>
<link rel="stylesheet" href="../css/hud.css" />
<script type="text/javascript">
jQuery.ajaxSetup({
  beforeSend: function() {
     $('#loadinghud').show()
  },
  complete: function(){
     $('#loadinghud').hide()
  },
  success: function() {}
});
function loadContent(id) {
  $('#contentArea2').load("./modules/hud/includes/loader.php?sys="+id+"");
}
</script>
<script>
$(document).ready(function() {
	$("div.panel_button").click(function(){
		$("div#panel").animate({
			height: "300px"
		})
		.animate({
			height: "400px"
		}, "fast");
		$("div.panel_button").toggle();
	});	
	$("div#hide_button").click(function(){
		$("div#panel").animate({
			height: "0px"
		}, "fast");
	});	
});
</script>
<link rel="stylesheet" href="./css/hud.css" />
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
 </script> 
  <div id="page_container">
  <div id="toppanel">
	<div id="panel">
		<div id="panel_contents"> </div>
			<a onClick="contentDisp()">Load Query</a><div id="contentArea"></div>
	</div>
    <div class="panel_button" style="display: visible;"><img src="./img/hud/expand.png"  alt="expand"/> <a href="#">HUD</a> </div>
    <div class="panel_button" id="hide_button" style="display: none;"><img src="./img/hud/collapse.png" alt="collapse" /> <a href="#">Hide</a> </div>

  </div>
</div>

















