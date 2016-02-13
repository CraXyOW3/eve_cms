<style type="text/css">
#sliderWrap {
margin: 0 auto;
width: 100%;
}
#slider {

position: absolute;
background-image:url(slider.png);
background-repeat:no-repeat;
background-position: bottom;
width: 300px;
height: 159px;
margin-top: -200px;
}
#slider img {
border: 0;
}
#sliderContent {
margin: 50px 0 0 50px;
position: absolute;
text-align:center;
background-color:#000000;
color:#fff;
border:solid 1px #fff;
font-weight:bold;
padding: 10px;
}


#openCloseWrap {
position:absolute;
margin: 143px 0 0 120px;
font-size:12px;
font-weight:bold;
}
</style>

<script type="text/javascript">
jQuery.ajaxSetup({
  beforeSend: function() {
     $('#loading').show()
  },
  complete: function(){
     $('#loading').hide()
  },
  success: function() {}
});
function loadContent(id) {
  $('#contentArea2').load("./modules/hud/includes/loader.php?sys="+id+"");
}
</script>

	<script type="text/javascript">
	$(document).ready(function() {
		$(".topMenuAction").click( function() {
			if ($("#openCloseIdentifier").is(":hidden")) {
				$("#slider").animate({ 
					marginTop: "-200px"
					}, 500 );
				$("#topMenuImage").html('<img src="open.png" alt="open" />');
				$("#openCloseIdentifier").show();
			} else {
				$("#slider").animate({ 
					marginTop: "0px"
					}, 500 );
				$("#topMenuImage").html('<img src="close.png" alt="close" />');
				$("#openCloseIdentifier").hide();
			}
		});  
	});
	</script>
<script type="text/javascript">
function  contentDisp()
{
	$.ajax({
	url : "./modules/hud/includes/hud_example.php",
	success : function (data) {
	$("#contentArea").html(data);
	}
	});
}
 </script> 

	
	
	<div id="sliderWrap">
		<div id="openCloseIdentifier"></div>
		<div id="slider">
			<div id="sliderContent">
				<a onClick="contentDisp()">asd</a><div id="contentArea"></div>
			</div>
			<div id="openCloseWrap">
				<a href="#" class="topMenuAction" id="topMenuImage">
					<img src="open.png" alt="open" />

				</a>
			</div>
		</div>
	</div>
	
	
	
		<a href="#" class="topMenuAction">Click me</a> or the open/close buttons. I will stay behind the slider.

