<div class="card">

	<div class="card-body mb-2">

		<h5 class="mx-3 pb-2">

			<?php $bookingModal = ( $this->ps_auth->is_logged_in())? "bookingModal": "loginModal"; ?>

			<a class="btn btn-info pull-right btn-booking-modal ml-2" roomid="<?php echo $room->room_id; ?>" roomname="<?php echo $room->room_name; ?>" href="#" data-toggle='modal' data-target='#<?php echo $bookingModal; ?>'>Book this room</a>

			<a class="btn btn-success pull-right btn-inq-modal" roomid="<?php echo $room->room_id; ?>" roomname="<?php echo $room->room_name; ?>" href="#" data-toggle='modal' data-target='#inquiryModal'>Inquiry about this room</a>

			<a href="<?php echo site_url( 'room/'. $room->room_id ); ?>">
				<?php echo $room->room_name; ?>
			</a>
		</h5>

		<a href="<?php echo site_url( 'room/'. $room->room_id ); ?>">

		<div class="room-detail p-3">

			<div class="row">
				<div class="col-3">
					<img class="mr-3 ps-img-hover w-100" src="<?php echo img_url( $room->default_photo->img_path ); ?>" alt="Generic placeholder image">

					<div class="room-info">
						<p class="mt-3">
							<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-limit.png' ); ?>"/>
							<?php echo $room->capacity; ?>
						</p>
						<p class="mt-3">
							<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-size.png' ); ?>"/>
							<?php echo $room->room_size; ?>
						</p>
						<p class="mt-3">
							<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-beds.png' ); ?>"/>
							<?php echo $room->room_no_of_beds; ?> beds
						</p>
					</div>
				</div>

				<div class="col-6">

					<?php if ( !empty( $room->features )): ?>
	
						<div class="row room-features">

							<?php foreach ( $room->features as $key => $feature ): ?>

							<div class="col-md-6 col-lg-4 mb-4">

								<h5 class="mb-3">
									<?php $img = $this->ps_widget->get_default_photo( $key, 'rinfo_grp' ); ?>

									<img src="<?php echo img_url( $img->img_path ); ?>" width="20" class="mr-1"/>

									<?php echo $this->RoomInfoGroup->get_one( $key )->rinfo_grp_name; ?>
								</h5>

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

				</div>

				<div class="col-2">

					<h4 class="text-success">
						<strong>
							<?php echo $room->room_price; ?>
							
							<?php echo get_app_config( 'currency_symbol' ); ?>
						</strong>
					</h4>

					<?php if ( isset( $room->final_rating )): ?>
					
						<span class="badge badge-info mb-2">Excellent - <?php echo get_rating_number( $room->final_rating ); ?></span>

					<?php endif; ?>

					<?php if ( isset( $room->promotion )): ?>

						<span class="badge badge-warning mb-2"><?php echo $room->promotion->promo_percent; ?>% Promotion!</span>

					<?php endif; ?>
				</div>

			</div>

		</div>

	</a>
	</div>
</div>