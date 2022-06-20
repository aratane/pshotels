
<div class="popular-hotels mb-4">

	<h2>Recommended Hotels</h2>
	
	<p class="lead">
		<?php echo get_msg( 'recommended_hotel_slogan' ); ?>

		<button class="btn btn-sm btn-info pull-right">
			<a href="<?php echo site_url( 'recommended_hotels' ); ?>">View All Recommended Hotels</a>
		</button>
	</p>

	<div class="row">
		<div class="col-12 mb-1 col-md-4 padding-0-first">

			<?php $hotel_template = $template_path .'/components/home/popular_hotel.php'; ?>

			<?php 
				// if there is an hotel, set the hotel
				$hotel = ( isset( $recommended_hotels[0] ))? $recommended_hotels[0]: $this->ps_dummy->get_dummy_hotel();

				$this->load->view( $hotel_template, array( 'hotel_info' => $hotel ));
			?>
			
		</div>
		<div class="col-12 mb-1 col-md-4 padding-0">

			<?php 
				// if there is an hotel, set the hotel
				$hotel = ( isset( $recommended_hotels[1] ))? $recommended_hotels[1]: $this->ps_dummy->get_dummy_hotel();

				$this->load->view( $hotel_template, array( 'hotel_info' => $hotel ));
			?>
			
		</div>
		<div class="col-12 mb-1 col-md-4 padding-0">

			<?php 
				// if there is an hotel, set the hotel
				$hotel = ( isset( $recommended_hotels[2] ))? $recommended_hotels[2]: $this->ps_dummy->get_dummy_hotel();

				$this->load->view( $hotel_template, array( 'hotel_info' => $hotel ));
			?>
			
		</div>
	</div>
</div>

<script type="text/javascript">
function recommended_hotels()
{
	<?php for ( $i = 0; $i <= 2; $i++ ): ?>

		<?php if ( !isset( $recommended_hotels[$i] )) continue; ?>

		<?php $hotel = $recommended_hotels[$i];?>

		<?php if ( isset( $hotel->hotel_star_rating ) && $hotel->hotel_star_rating != 0 ): ?>
		
		$('.<?php echo $hotel->hotel_id; ?>').raty({
			starType: 'i',
			readOnly: true,
			score: <?php echo $hotel->hotel_star_rating; ?>
		});

		<?php endif; ?>

	<?php endfor; ?>
}
</script>
