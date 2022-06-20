<div class="hotel-hero-text ps-hero-wrapper ps-hero-image border-bottom box-shadow mb-2">

	<div class="container">

		<div class="row">

			<div class="col-12">

				<div class="ps-hero-text hotel-title">

					<h2>
						<?php echo $hotel->hotel_name; ?>
					</h2>

					<div id="<?php echo $hotel->hotel_id; ?>" class="raty"></div>

					<p class="room-address"><?php echo $hotel->hotel_address; ?></p>
					
				</div>

				<div class="ps-hero-text hotel-review">

					<a class="btn btn-success pull-right" data-target="#hotelGalleryModal" data-toggle="modal">View Gallery</a>
					
					<?php if ( $this->ps_auth->is_logged_in()): ?>

						<?php $user_id = $this->ps_auth->get_user_info()->user_id; ?>

						<?php $is_user_fav = ( $this->Favourite->count_all_by( array( 'hotel_id' => $hotel->hotel_id, 'user_id' => $user_id )) > 0 )? 1: 0; ?>

						<a class="btn btn-primary pull-right mr-3" id="pressFav">
							<?php echo ( $is_user_fav )? "Remove from Favourite": "Add to Favourite"; ?>
						</a>

					<?php else: ?>
						
						<a class="btn btn-primary pull-right mr-3" data-target="#loginModal" data-toggle="modal">Add to favourite</a>

					<?php endif; ?>

					<br/>

					<?php if ( $hotel->review_count > 0 ): ?>
					
					<span class="btn btn-link mt-3 text-info pull-right" data-target="#hotelReviewModal" data-toggle="modal">
						<?php echo $hotel->rating_text .' - '. get_rating_number( $hotel->final_rating ) .' | '. $hotel->review_count .' reviews'; ?></span>

					<?php endif; ?>

				</div>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
function hotel_hero_text()
{
	// set background image
	// $('.ps-hero-wrapper').css('background-image', 'url(<?php //echo base_url( "assets/img/hero-image.jpg" ); ?>)');	
	$('.ps-hero-wrapper').css('background-image', 'url("<?php echo img_url( $hotel->default_photo->img_path ); ?>")');

	<?php if ( isset( $hotel->hotel_star_rating )): ?>
	
	// put the rating
	$('#<?php echo $hotel->hotel_id; ?>').raty({
		starType: 'i',
		readOnly: true,
		score: <?php echo $hotel->hotel_star_rating; ?>
	});

	<?php endif; ?>

	// Add to fav
	$('#pressFav').click(function(){

		$.ajax({
			type: "POST",
			url: userUrl + '/fav_hotel',
			data:{
				"hotel_id":"<?php echo $hotel->hotel_id; ?>"
			},
			dataType: 'json',
			success:function(obj){

				if ( obj.status == "success" ) {

					if ( obj.data.favType == "fav" ) {
					
						$('#pressFav').html('Remove from Favourite');
					} else {

						$('#pressFav').html('Add to Favourite');
					}
				} else {

					console.log( obj );
				}
			}
		});
	});
}
</script>