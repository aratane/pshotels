<div class='container mt-5'>
	
	<div class='row justify-content-center'>
	
		<div class='col-8 col-md-5'>

			<h2>
				<label class="reset-title"><?php echo get_msg( 'booking_confirmation' ); ?></label>
			</h2>

			<?php flash_msg(); ?>
					
			<?php if ( $status == 'confirm' ): ?>

				<p class="lead mt-4 text-success"><?php echo get_msg( 'confirm_booking_success' ); ?></p>

			<?php else: ?>

				<p class="lead mt-4 text-danger"><?php echo get_msg( 'reject_booking_success' ); ?></p>				

			<?php endif; ?>

			<p>
				From : <?php echo $booking->booking_start_date; ?>
				<br>To : <?php echo $booking->booking_end_date; ?>
			</p>

			<p>
				Room Name : <?php echo $this->Room->get_one( $booking->room_id )->room_name; ?>
				<br>Adults: <?php echo $booking->booking_adult_count; ?>
				<br>Kids: <?php echo $booking->booking_kid_count; ?>
				<br>Extra Beds: <?php echo $booking->booking_extra_bed; ?>
			</p>

			<p>
				Remark: <?php echo $booking->booking_remark; ?>
			</p>

			<p>
				Guest Name : <?php echo $booking->booking_user_name; ?><br/>
				Guest Email : <?php echo $booking->booking_user_email; ?><br/>
				Guest Phone : <?php echo $booking->booking_user_phone; ?>
			</p>

		</div>
	</div>
</div>