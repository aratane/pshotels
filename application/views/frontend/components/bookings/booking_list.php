
<div class="popular-bookings mb-2">

	<h4>
		My Bookings List

		<button class="btn btn-sm btn-info pull-right">
			<a href="<?php echo site_url( 'bookings' ); ?>">View All Bookings</a>
		</button>
	</h4>
	
	<div class="row">

		<?php if ( !empty( $bookings )): $i = 0; foreach ( $bookings as $book ): ?>

		<div class="col-12 mb-1 col-md-4 <?php echo ( $i == 0 )? 'padding-0-first': 'padding-0'; ?>">

			<?php $booking_template = $template_path .'/components/bookings/booking.php'; ?>

			<?php 
				// if there is an booking, set the booking
				$booking = ( isset( $book ))? $book: $this->ps_dummy->get_dummy_booking();

				$this->load->view( $booking_template, array( 'booking' => $booking ));
			?>
			
		</div>

		<?php $i++; endforeach; endif; ?>

	</div>
</div>