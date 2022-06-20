
<div class="popular-cities mt-1 mb-4">
	
	<h2>Popular Destinations</h2>

	<p class="lead">
		<?php echo get_msg( 'popular_city_slogan' ); ?>

		<button class="btn btn-sm btn-info pull-right">
			<a href="<?php echo site_url( 'popular_cities' ); ?>">View All Popular Destinations</a>
		</button>
	</p>
	
	<div class="row">

		<div class="col-12 mb-1 col-md-4 padding-0-first">

			<?php $city_template = $template_path .'/components/home/popular_city.php'; ?>

			<?php 
				// if there is an city, set the city
				$city = ( isset( $popular_cities[0] ))? $popular_cities[0]: $this->ps_dummy->get_dummy_city();

				$this->load->view( $city_template, array( 'city_info' => $city ));
			?>
			
		</div>
		<div class="col-12 mb-1 col-md-4 padding-0">

			<?php 
				// if there is an city, set the city
				$city = ( isset( $popular_cities[1] ))? $popular_cities[1]: $this->ps_dummy->get_dummy_city();

				$this->load->view( $city_template, array( 'city_info' => $city ));
			?>
			
		</div>
		<div class="col-12 mb-1 col-md-4 padding-0">

			<?php 
				// if there is an city, set the city
				$city = ( isset( $popular_cities[2] ))? $popular_cities[2]: $this->ps_dummy->get_dummy_city();

				$this->load->view( $city_template, array( 'city_info' => $city ));
			?>
			
		</div>
	</div>
</div>
