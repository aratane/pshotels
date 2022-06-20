
<div class="card">
	<?php 
		// get dummy data
		$emptyBooking = $this->ps_dummy->get_dummy_booking();
		$img = $this->ps_dummy->get_dummy_photo();

		// if there is an booking, set the booking
		$booking = ( isset( $booking ))? $booking: $emptyBooking;

		if ( isset( $booking->hotel->defaul_photo )) $img = $booking->hotel->defaul_photo;
	?>

	<span class="ps-middle-badge badge <?php echo get_booking_status_badge( $booking->booking_status ); ?>">
		<?php echo $booking->booking_status; ?>
	</span>

	<a href='<?php echo site_url( 'booking_detail/'. $booking->booking_id ); ?>'>
		<img width="358px" height="150px" class="card-img-top ps-img-hover" src="<?php echo img_url( $img->img_path ); ?>" alt="Card image cap">
	</a>
	
	<div class="card-body" style="padding: 10px;">
		
		<a href='<?php echo site_url( 'booking_detail/'. $booking->booking_id ); ?>'>
			
		<h6 class="popular-title mb-3">
				<?php echo $booking->hotel->hotel_name; ?>
			</h6>

			<p class="room-info">
				<span style="display: inline-block; width: 45px">Room:</span> 
				<?php echo $booking->room->room_name; ?>
				
				<br>

				<span style="display: inline-block; width: 45px">From:</span> 
				<?php echo date( 'd-M-Y', strtotime( $booking->booking_start_date )); ?>
				
				<br>
				<span style="display: inline-block; width: 45px">To:</span> 
				<?php echo date( 'd-M-Y', strtotime( $booking->booking_end_date )); ?>
			</p>

		</a>

	</div>
</div>