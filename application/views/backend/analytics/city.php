<?php 
	// load breadcrumb
	show_breadcrumb( $action_title );

	// show flash message
	flash_msg();
?>

<?php if($count > 0):?>
	<div id="chart_div" style="height: 500px;width: 800px;"></div>
	<div id="piechart" style="height: 400px;width: 700px;"></div>
<?php endif;?>

<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawGraphChart);
	google.setOnLoadCallback(drawPieChart);
	
	function drawGraphChart() {
		
		var data = google.visualization.arrayToDataTable(<?php echo $graph_items;?>);
		var options = {
			title: 'Total Touch Counts (Cities)',
			vAxis: {title: 'Items',  titleTextStyle: {color: 'red'}, minValue:0, maxValue:1000},
			colors:['#e57373'],
			backgroundColor: { fill:'transparent' }
		};
		
		var chart = new google.visualization.BarChart(document.getElementById('chart_div'));
		chart.draw(data, options);
	}
	
	function drawPieChart() {
     	
     	var data = google.visualization.arrayToDataTable(<?php echo $pie_items;?>);
     	var options = {
       		title: 'Top 5 Popular Cities',
       		backgroundColor: { fill:'transparent' }
     	};

     	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
     	chart.draw(data, options);
   }
   
</script>