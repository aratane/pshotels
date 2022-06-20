<div class="card">
	<?php 
		// get dummy data
		$hotel = $this->ps_dummy->get_dummy_hotel();
		$img = $this->ps_dummy->get_dummy_photo();

		// if there is an hotel, set the hotel
		if ( isset( $hotel_info )) $hotel = $hotel_info;

		if ( isset( $hotel->default_photo )) $img = $hotel->default_photo;
	?>

	<?php if ( isset( $hotel->promotion )): ?>
		<span class="ps-top-badge badge badge-success"><?php echo $hotel->promotion->promo_percent; ?>% Promotion!</span>
	<?php endif; ?>

	<a href='<?php echo site_url( 'hotel/'. $hotel->hotel_id ); ?>'>
		<img width="358px" height="150px" class="card-img-top ps-img-hover" src="<?php echo img_url( $img->img_path ); ?>" alt="Card image cap">
	</a>
	
	<div class="card-body">
	<a href='<?php echo site_url( 'hotel/'. $hotel->hotel_id ); ?>'>
		<p class="hotel-title mb-3"><?php echo $hotel->hotel_name; ?></p>
		
		<?php if ( isset( $hotel->hotel_star_rating ) && $hotel->hotel_star_rating != 0 ): ?>
			<div id="<?php echo $hotel->hotel_id; ?>" class="<?php echo $hotel->hotel_id; ?> raty"></div>
		<?php else: ?>
			<p class="text-muted hotel-info mb-4">No rating</p>
		<?php endif; ?>

		<p class="hotel-info"><?php echo $hotel->city_name .', '. $hotel->country_name; ?></p>
		<p class="hotel-info"><?php echo $this->Room->count_all_by( array( 'hotel_id' => $hotel->hotel_id )); ?> room types</p>
	</a>
	</div>
</div>