<?php if ( !empty( $room->features )): ?>

<div class="row room-features">

	<?php foreach ( $room->features as $key => $feature ): ?>

	<div class="col-md-6 col-lg-4 mb-4">

		<h6 class="mb-3">
			<?php $img = $this->ps_widget->get_default_photo( $key, 'rinfo_grp' ); ?>

			<img src="<?php echo img_url( $img->img_path ); ?>" width="20" class="mr-1"/>

			<?php echo $this->RoomInfoGroup->get_one( $key )->rinfo_grp_name; ?>
		</h6>

		<?php foreach ( $feature as $info ): ?>

			<p class="">
				✓ 
				<?php echo $this->RoomInfoType->get_one( $info )->rinfo_typ_name; ?>
			</p>

		<?php endforeach; ?>

	</div>

	<?php endforeach; ?>

</div>

<?php endif; ?>