
<h5 class="text-dark py-1">Popular Hotels</h5>

<?php if ( isset( $popular_hotels ) && !empty( $popular_hotels )): ?>

<ul class="list-unstyled">

	<?php foreach ( $popular_hotels as $hotel ): ?>

		<li class="media py-2 border-bottom">
			
			<a href='<?php echo site_url( 'hotel/'. $hotel->hotel_id ); ?>'>

				<img src="<?php echo img_url( $hotel->default_photo->img_path ); ?>" alt="" class="mr-3 img-fluid" width="100">

			</a>

			<a href='<?php echo site_url( 'hotel/'. $hotel->hotel_id ); ?>'>

				<div class="media-body">

				<p class="mt-0 mb-1">
					<?php echo $hotel->hotel_name; ?>
				</p>

				<p class="text-muted">
					<?php //echo $hotel->city_name; ?>
				</p>

			</div>

			</a>

		</li>

	<?php endforeach; ?>

</ul>

<?php endif; ?>