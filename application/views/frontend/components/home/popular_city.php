<?php 
	// get dummy data
	$city = $this->ps_dummy->get_dummy_city();
	$img = $this->ps_dummy->get_dummy_photo();

	// if there is an city, set the city
	if ( isset( $city_info )) $city = $city_info;

	if ( isset( $city->default_photo )) $img = $city->default_photo;
?>

<div class="card">

	<a class="ps-img-layer ps-img-hover" href="<?php echo site_url( 'city/'. $city->city_id ); ?>">
		<img width="358px" height="210px" class="card-img-top" src="<?php echo img_url( $img->img_path ); ?>" alt="Card image cap">
	</a>

	<a class="ps-text-layer" href="<?php echo site_url( 'city/'. $city->city_id ); ?>">
		<div class="caption">
			<h4 class="card-title"><?php echo $city->city_name; ?></h4>

			<p class="card-text">
				<?php echo $this->Hotel->count_all_by( array( 'city_id' => $city->city_id )); ?> hotels
			</p>

		</div>
	</a>
</div>