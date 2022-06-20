<div class="main-filter-warpper">
	<div class="filter_group border-bottom pb-3">

		<h6>Change Destination</h6>
		
		<?php 
			$cities = $this->City->get_all()->result();

		 	if ( !empty( $cities )): foreach ( $cities as &$tmp ):

		 		$country_name = $this->Country->get_one( $tmp->country_id )->country_name;
		 		$total_rooms = $this->Room->count_all_by( array( 'city_id' => $tmp->city_id ));
		 		$city_options[$tmp->city_id] = $tmp->city_name .', '. $country_name .', '. $total_rooms .' rooms';

			endforeach; endif;
			
			echo form_dropdown(
				'city_id',
				$city_options,
				set_value( 'city_id', @$city->city_id ),
				'class="psselect w-100 mr-5" id="city_id"'
			);
		?>

	</div>

	<div class="filter_group mt-3 border-bottom pb-3">
		<h6>Property Name</h6>

		<input id="searchterm" type="text" class="form-control form-control-sm" placeholder="Sedona" />
	</div>

	<div class="filter_group mt-3 border-bottom pb-3">
		<h6>Price per night</h6>

		<label><span id="pricePerNight" class="text-primary ml-5"></span></label>

		<input class="min-price" type="hidden" value="75"/>
		<input class="max-price" type="hidden" value="900"/>

		<div id="slider-range"></div>
	</div>
</div>

<!-- <div class="filter_group mt-3 border-bottom">
	<h6>Star Rating</h6>

	<div class="raty"></div>
	
</div>

<div class="filter_group mt-3 border-bottom">
	<h6>Guest Rating</h6>

	<div class="raty"></div>
</div> -->


<script type="text/javascript">
function main_filter()
{
	// chosen select
	$('.psselect').chosen();

	// slider
	$( "#slider-range" ).slider({
		range: true,
		min: 0,
		max: 950,
		values: [ 75, 900 ],
		slide: function( event, ui ) {
			$( "#pricePerNight" ).html( "$" + ui.values[ 0 ] + " - $" + ui.values[ 1 ] );

			$( '.min-price' ).val( ui.values[0] );
			$( '.max-price' ).val( ui.values[1] );
		}
	});

	$( "#pricePerNight" ).html( "$" + $( "#slider-range" ).slider( "values", 0 ) + " - $" + $( "#slider-range" ).slider( "values", 1 ) );
}
</script>