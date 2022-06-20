<div id="hotel-list-wrapper">

<?php if ( isset( $hotels ) && !empty( $hotels )): ?>

<!-- <div class="hotel-list mb-4 ps-card-hover"> -->

	<?php foreach ( $hotels as $hotel ): ?>

		<?php $this->load->view( $template_path .'/components/city/hotel_info_card.php', array( 'hotel' => $hotel )); ?>

	<?php endforeach; ?>
	
<!-- </div> -->

<?php endif; ?>

</div>

<input type="hidden" id="totalHotelsCount" value="<?php echo $hotels_count; ?>"/>

<input type="hidden" id="hotelLimit" value="<?php echo $hotels_limit; ?>"/>

<div id="loadMoreHotels" class="row">
	<div class="col-12 text-center">			
		<span class="loadMoreHotels btn btn-sm grow" href="#" page="1">
			<i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Load More Hotels
		</span>
	</div>
</div>

<script type="text/javascript">
function hotel_list()
{
	<?php foreach ( $hotels as $hotel ): ?>

		<?php if ( isset( $hotel->hotel_star_rating )): ?>
		
		// rating
		$('#<?php echo $hotel->hotel_id; ?>').raty({ 
			starType: 'i',
			readOnly: true,
			score: <?php echo $hotel->hotel_star_rating; ?>
		});

		<?php endif; ?>

	<?php endforeach; ?>
}
</script>