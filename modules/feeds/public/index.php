<?php
function readnews($title,$tag){
	$pr	=	'<script type="text/javascript">' . "\n";
	$pr	.=	'$(document).ready(function(){';
	$pr	.=	'	$(".newsloader_'.$tag.'").ready(function(){';
	$pr	.=	'		$(".newscontent_'.$tag.'").fadeIn();';
	$pr	.=	'		$(".loader_'.$tag.'").hide().load("./includes/feeds/load_feeds.php?load='.$tag.'", function() {';
	$pr	.=	'			$(".newscontent_'.$tag.'").hide();';
	$pr	.=	'			$(this).fadeIn();';
	$pr	.=	'		});';
	$pr	.=	'	});';
	$pr	.=	'});';
	$pr	.=	'</script>';
	$pr	.=	'<div class="ui-accordion ui-widget ui-helper-reset">';
	$pr	.=	'<h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top">';
	$pr	.=	'<a href="#">'.$title.'</a>';
	$pr	.=	'</h3>';
	$pr	.=	'<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">';
	$pr	.=	'<div class="newscontent_'.$tag.'" style="display: none;"><p align="center"><img src="./img/ghooloader2.gif" alt="loading" /></p></div><div class="loader_'.$tag.'"></div>';
	$pr	.=	'</div>';
	$pr	.=	'</div><br />';
	return $pr;
}


//echo readnews('test','test2');



$sql = good_query_table("SELECT * FROM feeds WHERE enabled='1'");
foreach($sql as $row){
	//echo readnews($row['name'],$row['tag']);
}

?>

<!--
<script type="text/javascript">
	$(document).ready(function(){
		$('.newsloader').ready(function(){
			$('.newscontent').fadeIn();
			$('.loader').hide().load('./includes/feeds/load_feeds.php?load=', function() {
				$('.newscontent').hide();
				$(this).fadeIn();				
			});
		});
	});
</script>


<div class="ui-accordion ui-widget ui-helper-reset">
  <h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top">
    
    <a href="#">Section 1</a>
  </h3>
  <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">
    <div class="newscontent" style="display: none;"><p align="center"><img src="./img/ghooloader2.gif" alt="loading" /></p></div><div class="loader"></div>
  </div>

</div>
-->
<?php
$wrt	=	'
	<script>
	$(function() {
		$( "#tabs" ).tabs({
		cache:true,
			ajaxOptions: {
				beforeSend: function() {
					$(\'#loading\').show()
				},
				complete: function(){
					$(\'#loading\').hide()
				},
				error: function( xhr, status, index, anchor ) {
					$( anchor.hash ).html(
						"Couldn\'t load this tab. We\'ll try to fix this as soon as possible. ");
				}
			}
		});



	});
	</script>';
/*
    $("#tabs").tabs({
      spinner: "",
      select: function(event, ui) {
        var tabID = "#ui-tabs-" + (ui.index + 1);
        $(tabID).html("<p align=\"center\"><img src=\"./img/39.gif\"></p>");
      }
    });

$(".tabs").tabs({
   cache:true,
   load: function (e, ui) {
     $(ui.panel).find(".tab-loading").remove();
   },
   select: function (e, ui) {
     var $panel = $(ui.panel);

     if ($panel.is(":empty")) {
         $panel.append("<div class='tab-loading'>Loading...</div>")
     }
    }
 })





*/

$wrt	.=	wrt_table(0,0,0,$tblWidth,'center');
$wrt	.=	'<tr><td>';

$shipGroup = good_query_table("SELECT * FROM feeds"); // Ship Categories
$wrt	.=	'<div id="tabs">';
$wrt	.=	'<ul>';
foreach($shipGroup as $row){
	//$wrt	.=	'<li><a href="./includes/feeds/load_feeds.php?load='.$row['tag'].'">'.$row['name'].'</a></li>';
	$wrt	.=	'<li><a href="'.$module_dir.$self.'/includes/load_feeds.php?load='.$row['tag'].'">'.$row['name'].'</a></li>';
}
$wrt	.=	'</ul>';
$wrt	.=	'';
$wrt	.=	'<div id="tabs-1">';
$wrt	.=	'<p><div id="loading"><p align="center">';
$wrt	.=	'<img src="./img/ghooloader2.gif" />';
$wrt	.=	'</p></div>';
$wrt	.=	'</div>';
$wrt	.=	'';
$wrt	.=	'</div>';
$wrt	.=	'</td></tr></table>';


echo $wrt;


	$pr2	=	'<script type="text/javascript">' . "\n";
	$pr2	.=	'$(document).ready(function(){';
	$pr2	.=	'	$(".newsloader").ready(function(){';
	$pr2	.=	'		$(".newscontent").fadeIn();';
	$pr2	.=	'		$(".loader").hide().load("./includes/serverstatus.php", function() {';
	$pr2	.=	'			$(".newscontent").hide();';
	$pr2	.=	'			$(this).fadeIn();';
	$pr2	.=	'		});';
	$pr2	.=	'	});';
	$pr2	.=	'});';
	$pr2	.=	'</script>';
	$pr2	.=	'<div class="ui-accordion ui-widget ui-helper-reset">';
	$pr2	.=	'<h3 class="ui-accordion-header ui-helper-reset ui-state-active ui-corner-top">';
	$pr2	.=	'<a href="#">asdasd</a>';
	$pr2	.=	'</h3>';
	$pr2	.=	'<div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">';
	$pr2	.=	'<div class="newscontent" style="display: none;"><p align="center"><img src="./img/ghooloader2_s.gif" alt="loading" /></p></div><div class="loader"></div>';
	$pr2	.=	'</div>';
	$pr2	.=	'</div><br />';
//echo $pr2;
echo $module_dir.$self.'';
?>

