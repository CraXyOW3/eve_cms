
<script type="text/javascript" src="jquery/jqPlot/jquery.jqplot.min.js"></script>
<script type="text/javascript" src="jquery/jqPlot/plugins/jqplot.dateAxisRenderer.min.js"></script>
<script type="text/javascript">
$(document).ready(function(){
  var logon=[['2008-06-30',4], ['2008-7-30',6], ['2008-8-30',6], ['2008-9-30',9], ['2008-10-30',20]];
  var logoff=[['2008-06-30 8:00AM',5], ['2008-7-30 8:00AM',7.5], ['2008-8-30 8:00AM',6.7], ['2008-9-30 8:00AM',10], ['2008-10-30 8:00AM',9.2]];
  var plot2 = $.jqplot('chart2', [logon,logoff], {
      title:'Customized Date Axis',
      gridPadding:{right:35},
      axes:{
        xaxis:{
          renderer:$.jqplot.DateAxisRenderer,
          //tickOptions:{formatString:'%b %#d, %y'},
          tickOptions:{formatString:'%A'},
          min:'May 30, 2008',
          tickInterval:'1 month'
        }
      },
      series:[
		{lineWidth:4, markerOptions:{style:'circle'}},
		{lineWidth:4, markerOptions:{style:'diamond'}}
		]
  });
});
</script>
<div id="chart2" style="height:300px; width:650px;"></div>
<div class="code prettyprint">

<pre class="code prettyprint brush: js"></pre>
</div>