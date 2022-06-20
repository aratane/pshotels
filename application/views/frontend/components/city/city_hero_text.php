<div class="city-hero-text ps-hero-wrapper ps-hero-image border-bottom box-shadow mb-3">

	<div class="container">

		<div class="ps-hero-text hotel-title">

			<h4><?php echo $city->city_name .', '. $city->country->country_name; ?></h4>

			<p><?php echo count( $city->hotels ); ?> hotels, <?php echo count( $city->rooms ); ?> room types</p>
			
		</div>

		<div class="ps-hero-text hotel-map">
			
			<a class="btn btn-success pull-right view-map">View Map</a>

		</div>
	</div>
</div>

<script type="text/javascript">
function hero_text_city()
{
	// set background image
	//$('.ps-hero-wrapper').css('background-image', 'url(<?php //echo base_url( "assets/img/hero-image.jpg " ); ?>)');
	
	$('.ps-hero-wrapper').css('background-image', 'url(<?php echo img_url( $city->default_photo->img_path ); ?> )');
}
</script>