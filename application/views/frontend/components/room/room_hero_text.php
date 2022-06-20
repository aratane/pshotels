
<div class="room-hero-text ps-hero-wrapper ps-hero-image border-bottom box-shadow mb-2">

	<div class="container">

		<div class="row">

			<div class="col-12">

				<div class="ps-hero-text room-title">

					<h2><?php echo $room->room_name; ?></h2>

					<h2 class="text-warning mt-3">
						<?php echo $room->room_price; ?>
						<?php echo get_app_config( 'currency_symbol' ); ?>
					</h2>

					<?php if ( isset(  $room->final_rating )): ?>
								
					<span class="badge badge-info mb-2">Excellent - <?php echo get_rating_number( $room->final_rating ); ?></span><br/>

					<?php endif; ?>

					<?php if ( isset( $room->promotion )): ?>

					<span class="badge badge-success mb-2"><?php echo $room->promotion->promo_percent; ?>% Promotion!</span>

					<?php endif; ?>
					
				</div>

				<div class="ps-hero-text room-map">
					
					<?php $bookingModal = ( $this->ps_auth->is_logged_in())? "bookingModal": "loginModal"; ?>

					<a class="btn btn-info pull-right btn-booking-modal ml-1" roomid="<?php echo $room->room_id; ?>" roomname="<?php echo $room->room_name; ?>" href="#" data-toggle='modal' data-target='#<?php echo $bookingModal; ?>'>Book this room</a>

					<a class="btn btn-success pull-right btn-inq-modal" roomid="<?php echo $room->room_id; ?>" roomname="<?php echo $room->room_name; ?>" href="#" data-toggle='modal' data-target='#inquiryModal'>Inquiry about this room</a>

					<?php if ( $room->review_count > 0 ): ?>

						<br/><br/>
								
						<span class="btn btn-link mt-3 text-info pull-right" data-target="#roomReviewModal" data-toggle="modal">
							<?php echo $room->rating_text .' - '. get_rating_number( $room->final_rating ) .' | '. $room->review_count .' reviews'; ?>
						</span>

					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function room_hero_text()
{
	// set background image
	//$('.ps-hero-wrapper').css('background-image', 'url(<?php //echo base_url( "assets/img/hero-image.jpg " ); ?>)');
	$('.ps-hero-wrapper').css('background-image', 'url("<?php echo img_url( $room->default_photo->img_path ); ?>")');

}
</script>