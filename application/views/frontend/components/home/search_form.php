<div class="hero-text-home ps-hero-wrapper border-bottom box-shadow mb-3">

	<div class="container">


		<div class="row">
			<div class="col-12">

				<div class="ps-hero-text">
					<h1 class="">Inquiry Hotel Online</h1>
					<p class="lead ">Deep discounts on <?php echo $this->Room->count_all(); ?>+ properties, worldwide</p>
				</div>

				<div class="hero-form">

					<?php echo form_open( $module_site_url .'/city', array( 'class' => 'main-search-form p-4 mr-4')); ?>

						<div class="row align-items-center">

							<div class="col">

								<?php 
									$cities = $this->City->get_all()->result();

								 	if ( !empty( $cities )): foreach ( $cities as &$city ):

								 		$country_name = $this->Country->get_one( $city->country_id )->country_name;
								 		$total_hotels = $this->Hotel->count_all_by( array( 'city_id' => $city->city_id ));
								 		$total_rooms = $this->Room->count_all_by( array( 'city_id' => $city->city_id ));
								 		$city_options[$city->city_id] = $city->city_name .', '. $country_name .', '. $total_hotels .' hotels, '. $total_rooms .' rooms';

									endforeach; endif;
									
									echo form_dropdown(
										'city_id',
										$city_options,
										set_value( 'city_id', @$searchterm['city_id'] ),
										'class="psselect w-100 mr-5" id="city_id"'
									); 
								?>

							</div>

							<div class="col-auto">
								<button type="submit" class="btn btn-primary">Search</button>
							</div>

						</div>

					<?php echo form_close(); ?>	

				</div>
				
			</div>
		</div>

	</div>
</div>

<script type="text/javascript">
function search_form()
{
	// chosen select
	$('.psselect').chosen();

	// set background image
	$('.ps-hero-wrapper').css('background-image', 'url(<?php echo base_url( 'assets/img/hero-image.jpg' ); ?>');
}
</script>