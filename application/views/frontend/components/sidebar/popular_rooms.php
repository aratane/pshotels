
<h5 class="text-dark py-1">Popular Rooms</h5>

<?php if ( isset( $popular_rooms ) && !empty( $popular_rooms )): ?>

<ul class="list-unstyled">

	<?php foreach ( $popular_rooms as $room ): ?>

		<li class="media py-2 border-bottom">
			
			<a href='<?php echo site_url( 'room/'. $room->room_id ); ?>'>

				<img src="<?php echo img_url( $room->default_photo->img_path ); ?>" alt="" class="mr-3 img-fluid" width="100">

			</a>

			<a href='<?php echo site_url( 'room/'. $room->room_id ); ?>'>

				<div class="media-body">

					<p class="mt-0 mb-1">
						<?php echo $room->room_name; ?>
					</p>

					<p class="text-muted">
						<?php //echo $room->city->city_name; ?>
					</p>

				</div>

			</a>

		</li>

	<?php endforeach; ?>

</ul>

<?php endif; ?>