
<h5 class="text-dark py-1">Popular Cities</h5>

<?php if ( isset( $popular_cities ) && !empty( $popular_cities )): ?>

<ul class="list-unstyled">

	<?php foreach ( $popular_cities as $city ): ?>

		<li class="media py-2 border-bottom">
			
			<a href='<?php echo site_url( 'city/'. $city->city_id ); ?>'>

				<img src="<?php echo img_url( $city->default_photo->img_path ); ?>" alt="" class="mr-3 img-fluid" width="100">

			</a>

			<a href='<?php echo site_url( 'city/'. $city->city_id ); ?>'>

				<div class="media-body">

				<p class="mt-0 mb-1">
					<?php echo $city->city_name; ?>
				</p>

			</div>

			</a>

		</li>

	<?php endforeach; ?>

</ul>

<?php endif; ?>