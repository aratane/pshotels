<?php 
	// load breadcrumb
	show_breadcrumb( $action_title );

	// show flash message
	flash_msg();
?>

<?php
	$attributes = array('class' => 'form-inline','method' => 'POST');
	echo form_open($module_site_url .'/room', $attributes);
?>
  	<div class="form-group">
  		<label class="mr-2"><?php echo get_msg( 'hotel_name' )?></label>
  		
  		<?php 
	  		$options = array();
	  		$options[0] = get_msg( 'select_hotel' );
	  		foreach ( $this->Hotel->get_all()->result() as $hotel) {
				$options[$hotel->hotel_id] = $hotel->hotel_name;
			}

			echo form_dropdown(
				'hotel_id',
				$options,
				set_value( 'hotel_id' ),
				'class="form-control form-control-sm mr-3" id="hotel_id"'
			);
  		?>
  	</div>
  	
  	<button type="submit" class="btn btn-primary">Generate Report</button>
<?php echo form_close(); ?>
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
			title: 'Total Touch Counts (All Rooms)',
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
       		title: 'Top 5 Popular Rooms',
       		backgroundColor: { fill:'transparent' }
     	};

     	var chart = new google.visualization.PieChart(document.getElementById('piechart'));
     	chart.draw(data, options);
   }
   
</script>