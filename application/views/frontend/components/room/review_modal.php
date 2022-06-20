
<?php 
	$ratings = $this->Review->get_ratings( array( 'room_id' => $room_id ), true )->result();

	if ( !empty( $ratings )) $final_rating = $ratings[0];
?>

<?php $reviews = $this->Review->get_ratings( array( 'room_id' => $room_id ), false )->result(); ?>

<!-- room gallery modal -->
<div class="modal fade room-review-modal" id="roomReviewModal" tabindex="-1" role="dialog">
	
	<div class="modal-dialog" role="document">
		
		<div class="modal-content">

			<div class="modal-header">
				
				<h4 class="modal-title">
					Total Rating : 
					<div class="badge badge-primary">
						<?php echo get_rating_text( $final_rating->final_rating )." | ". get_rating_number( $final_rating->final_rating ); ?>
					</div>
				</h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

			</div>

			<div class="modal-body p-3">

				<div class="row room-review">
					<!-- <div class="col-6 text-center">

						<div class="room-review-circle" id="circle"></div>
						
					</div> -->
					<div class="col-12">
						
						<?php if ( !empty( $reviews )): foreach ( $reviews as $rate ): ?>

							<?php $rvcat = $this->ReviewCategory->get_one( $rate->rvcat_id ); ?>

							<div class="row">
								
								<div class="col-auto">
									
									<div class="raty <?php echo $rvcat->rvcat_id; ?>" rvcatid="<?php echo $rvcat->rvcat_id; ?>"></div>
								</div>
								
								<div class="col-auto pt-2">
									
									<?php echo $rvcat->rvcat_name; ?> - <?php echo get_rating_number( $rate->final_rating ); ?>
								</div>
							</div>
			
						<?php endforeach; endif; ?>


					</div>
				</div>
			</div>
		
		</div>
	
	</div>

</div>

<script type="text/javascript">
function review_modal()
{
	<?php if ( !empty( $reviews )): foreach ( $reviews as $rate ): ?>

	$('.<?php echo $rate->rvcat_id; ?>').raty({
		starType: 'i',
		readOnly: true,
		score: <?php echo $rate->final_rating; ?>
	});

	<?php endforeach; endif; ?>

	<?php if ( !empty( $ratings )): $value =$final_rating->final_rating * 0.2; ?>

	$('#circle').circleProgress({
		value: <?php echo $value; ?>,
		size: 150,
		fill: {
		gradient: ["yellow", "orange"]
	}});

	<?php endif; ?>
}
</script>