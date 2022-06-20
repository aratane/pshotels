
<div class="container pt-3 pb-5 card my-3">

	<div class="row">
		<a href="<?php echo site_url( 'bookings' ); ?>" class="btn btn-link pull-left"> 

			<span class="badge badge-info">
			<i class="fa fa-arrow-circle-left"></i> 
			Go To Bookings List
			</span>
		</a>
	</div>

	<h1 class="text-center mt-2">Booking Detail</h1>

	<hr>

	<div class="row justify-content-center mt-2">

		<div class="col-6">
			
			<img class="img-fluid" src="<?php echo img_url( $booking->room->default_photo->img_path ); ?>"/>

		</div>

		<div class="col-6 booking-detail">

			<h4 class="text-muted">Booking Information</h4>

			<div class="booking-info">
				
				<p class="lead booking-status mb-2 d-block">
					<strong>Status: </strong>
					<span class="badge <?php echo get_booking_status_badge( $booking->booking_status ); ?>">
						<?php echo $booking->booking_status; ?>
					</span>
				</p>

				<p class="lead booking-start-date mb-2 d-block">
					<strong>From: </strong> <?php echo date( 'd-M-Y', strtotime( $booking->booking_start_date )); ?>
				</p>

				<p class="lead booking-end-date">
					<strong>To: </strong> <?php echo date( 'd-M-Y', strtotime( $booking->booking_end_date )); ?>
				</p>

			</div>

			<h4 class="text-muted">Guest Detail Information</h4>

			<div class="guest-info">
				
				<p class="lead booking-user-name mb-2 d-block">
					<strong>Name: </strong>
					<?php echo $booking->booking_user_name; ?>
				</p>

				<p class="lead booking-user-email mb-2 d-block">
					<strong>Email: </strong>
					<?php echo $booking->booking_user_email; ?>
				</p>

				<p class="lead booking-user-phone">
					<strong>Phone: </strong>
					<?php echo $booking->booking_user_phone; ?>
				</p>

			</div>

			<h4 class="text-muted">Hotel Contact Information</h4>

			<div class="room-info">

				<p class="lead booking-hotel-name mb-2 d-block">
					<strong>Hotel Name: </strong>
					<?php echo $booking->hotel->hotel_name; ?>
				</p>

				<p class="lead booking-hotel-address mb-2 d-block">
					<strong>Address: </strong>
					<?php echo $booking->hotel->hotel_address; ?>
				</p>

				<p class="lead booking-hotel-contact mb-2 d-block">
					<strong>Email: </strong>
					<?php echo $booking->hotel->hotel_email; ?>
				</p>

				<p class="lead booking-hotel-contact mb-2 d-block">
					<strong>Phone: </strong>
					<?php echo $booking->hotel->hotel_phone; ?>
				</p>
			</div>

			<h4 class="text-muted">Booking Detail Information</h4>

			<div class="room-info">
				
				<p class="lead booking-room-name mb-2 d-block">
					<strong>Room Name: </strong>
					<?php echo $booking->room->room_name; ?>
				</p>

				<p class="lead booking-adult-count mb-2 d-block">
					<strong>Adult Count: </strong>
					<?php echo $booking->booking_adult_count; ?>
				</p>

				<p class="lead booking-kid-count">
					<strong>Kid Count: </strong>
					<?php echo $booking->booking_kid_count; ?>
				</p>

				<p class="lead booking-extra-bed mb-2 d-block">
					<strong>Extra Bed: </strong>
					<?php echo $booking->booking_extra_bed; ?>
				</p>

				<p class="lead booking-remark">
					<strong>Remark: </strong>
					<?php echo $booking->booking_remark; ?>
				</p>

			</div>

		</div>

	</div>
</div>