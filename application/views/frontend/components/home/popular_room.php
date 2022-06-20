<div class="card mb-2">

	<?php 
		// get dummy data
		$room = $this->ps_dummy->get_dummy_room();
		$img = $this->ps_dummy->get_dummy_photo();

		// if there is an room, set the room
		if ( isset( $room_info )) $room = $room_info;

		if ( isset( $room->default_photo )) $img = $room->default_photo;
	?>

	<div class="card-body">

		<?php if ( isset( $room->promotion )): ?>
			
			<span class="ps-top-badge badge badge-success"><?php echo $room->promotion->promo_percent; ?>% Promotion!</span>

		<?php endif; ?>

		<a href='<?php echo site_url( 'room/'. $room->room_id ); ?>'>

			<div class="row">

				<div class="col-6">

					<img class="mr-3 ps-img-hover img-fluid" src="<?php echo img_url( $img->img_path ); ?>" alt="Generic placeholder image">

				</div>

				<div class="col-6">
					<h5 class="room-title mt-0 mb-1"><?php echo $room->room_name; ?></h5>

					<p class="city-info"><?php echo $room->hotel->hotel_name; ?>, <?php echo $room->city->city_name; ?></p>

					<div class="room-info">
						
						<p class="mt-2">
							<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-limit.png' ); ?>"/>
							<?php echo $room->capacity; ?>
						</p>
						<p class="mt-2">
							<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-size.png' ); ?>"/>
							<?php echo $room->room_size; ?>
						</p>
						<p class="mt-2">
							<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-beds.png' ); ?>"/>
							<?php echo $room->room_no_of_beds; ?> beds
						</p>
					</div>
				</div>
			</div>
		</a>
	</div>
</div>