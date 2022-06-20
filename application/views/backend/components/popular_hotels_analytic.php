<?php
// get all hotels
$hotels = $this->Hotel->get_all_by( array( 'popular' => 1 ), 5 )->result();

// get hotel total touches
$hotels_arr = array();
foreach ( $hotels as $hotel ) {
	$hotels_arr[ $hotel->hotel_name ] = $this->HotelTouch->count_all_by( array( 'hotel_id' => $hotel->hotel_id ));
}

// get graph side bar title
$graph_arr = array();
foreach ( $hotels_arr as $name => $count ) {
	$graph_arr[] = "['".$name."',".$count."]";
}

// sort the hotel array
arsort($hotels_arr);
$pie_arr = array();
$i = 0;
foreach ( $hotels_arr as $name => $count ) {
	if(($i++) < 5){
		$pie_arr[] = "['".$name."',".$count."]";
	}
}

$count = count( $hotels );
$graph_items = "[['Hotels','Touches'],".implode(',',$graph_arr)."]";
$pie_items = "[['Hotels','Touches'],".implode(',',$pie_arr)."]";
?>

<div class="row my-4">
	<div class="col-6">

		<div id="chart_div" style="height: 300px;width: 100%;"></div>
	
	</div>
	<div class="col-6">

		<div id="piechart" style="height: 300px;width: 100%;"></div>

	</div>
</div>

<script type="text/javascript">
	google.load("visualization", "1", {packages:["corechart"]});
	google.setOnLoadCallback(drawGraphChart);
	google.setOnLoadCallback(drawPieChart);
	
	function drawGraphChart() {
		
		var data = google.visualization.arrayToDataTable(<?php echo $graph_items;?>);
		var options = {
			title: 'Total Touch Counts (Top 5 popular Hotels ) ',
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
       		title: 'Top 5 Popular Hotels ',
       		backgroundColor: { fill:'transparent' }
     	};

     	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
     	chart.draw(data, options);
   }
   
</script>
