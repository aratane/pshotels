<?php if ( isset( $images ) && !empty( $images )): ?>

<div id="<?php echo $slider_id; ?>" class="carousel slide ps-carousel" data-ride="carousel">

	<div class="carousel-inner" role="listbox">

		<?php foreach ( $images as $key => $img ): ?>

			<div class="carousel-item <?php if ( $key == 0 ) echo 'active'; ?>">
				<img class="d-block img-fluid" alt="<?php echo $img->img_path; ?>" src="<?php echo base_url( '/uploads/'. $img->img_path ); ?>" style="height: 400px">
			</div>

		<?php endforeach; ?>

	</div>
	
	<nav class="nav justify-content-center">

		<?php foreach ( $images as $key => $img ): ?>

			<li class="nav-link mt-1 <?php if ( $key == 0 ) echo 'active'; ?>" data-target="#<?php echo $slider_id; ?>" data-slide-to="<?php echo $key; ?>">
				<img class="d-block img-fluid" alt="<?php echo $img->img_path; ?>" src="<?php echo base_url( '/uploads/thumbnail/'. $img->img_path ); ?>" style="height: 60px; width: 80px">
			</li>

		<?php endforeach; ?>

	</nav>
</div>

<?php endif; ?>