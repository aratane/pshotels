
<?php
	$attributes = array( 'id' => 'room-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>

<?php $logged_in_user = $this->ps_auth->get_user_info(); ?>

	<h5><?php echo get_msg('room_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('room_name')?></label>

				<?php echo form_input( array(
					'name' => 'room_name',
					'value' => set_value( 'room_name', show_data( @$room->room_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'room_name' ),
					'id' => 'room_name'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('room_desc')?></label>

				<?php echo form_textarea( array(
					'name' => 'room_desc',
					'value' => set_value( 'room_desc', show_data( @$room->room_desc ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'room_desc' ),
					'id' => 'room_desc',
					'rows' => 5
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg( 'hotel_name' )?></label>

				<?php 
					$conds_user_hotel['user_id'] = $logged_in_user->user_id;
					$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();
					
					$user_hotels_ids = array();
					for($i=0; $i<count($user_hotel); $i++) {
					 	$user_hotels_ids[]= $user_hotel[$i]->hotel_id;
					}

					
					$options = array( '' => 'Select Hotel Name');
					if($logged_in_user->user_is_sys_admin == 1){
						foreach ( $this->Hotel->get_all( )->result() as $hotel) {
							$options[$hotel->hotel_id] = $hotel->hotel_name;
						}
					} else if($logged_in_user->is_hotel_admin == 1){
						foreach ( $this->Hotel->get_all_in_hotel_admin($user_hotels_ids)->result() as $hotel) {
							$options[$hotel->hotel_id] = $hotel->hotel_name;
						}
					}

					echo form_dropdown(
						'hotel_id',
						$options,
						set_value( 'hotel_id', @$room->hotel_id ),
						'class="form-control form-control-sm" id="hotel_id"'
					);
				?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('room_size')?></label>

				<?php echo form_input( array(
					'name' => 'room_size',
					'value' => set_value( 'room_size', show_data( @$room->room_size ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'room_size' ),
					'id' => 'room_size'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('room_price')?></label>

				<?php echo form_input( array(
					'name' => 'room_price',
					'value' => set_value( 'room_price', show_data( @$room->room_price ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'room_price' ),
					'id' => 'room_price'
				)); ?>

			</div>


			<div class="form-group">
				<div class="form-check">

					<label class="form-check-label">
					
					<?php echo form_checkbox( array(
						'name' => 'is_available',
						'id' => 'is_available',
						'value' => 'accept',
						'checked' => set_checkbox('is_available', 1, ( @$room->is_available == 1 )? true: false ),
						'class' => 'form-check-input'
					));	?>

					<?php echo get_msg( 'room_is_available' ); ?>

					</label>
				</div>
			</div>

		</div>

		<div class="col-6">

			<div class="form-group">
				<label><?php echo get_msg('room_no_of_beds')?></label>

				<?php echo form_input( array(
					'name' => 'room_no_of_beds',
					'value' => set_value( 'room_no_of_beds', show_data( @$room->room_no_of_beds ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'room_no_of_beds' ),
					'id' => 'room_no_of_beds'
				)); ?>

			</div>

			<div class="form-group">

				<div class="row">

					<div class="col-6">
						<label><?php echo get_msg('room_adult_limit')?></label>

						<?php echo form_input( array(
							'name' => 'room_adult_limit',
							'value' => set_value( 'room_adult_limit', show_data( @$room->room_adult_limit ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'room_adult_limit' ),
							'id' => 'room_adult_limit'
						)); ?>
					</div>

					<div class="col-6">
						<label><?php echo get_msg('room_kid_limit')?></label>

						<?php echo form_input( array(
							'name' => 'room_kid_limit',
							'value' => set_value( 'room_kid_limit', show_data( @$room->room_kid_limit ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'room_kid_limit' ),
							'id' => 'room_kid_limit'
						)); ?>
					</div>
				</div>
			</div>

			<div class="form-group">
				<label><?php echo get_msg('room_extra_bed_price')?></label>

				<?php echo form_input( array(
					'name' => 'room_extra_bed_price',
					'value' => set_value( 'room_extra_bed_price', show_data( @$room->room_extra_bed_price ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'room_extra_bed_price' ),
					'id' => 'room_extra_bed_price'
				)); ?>

			</div>
			
		</div>
	</div>

	<hr/>

	<?php $this->load->view( $template_path .'/'. $module_path .'/info_group_form', array( 'hotel' => @$hotel )); ?>
				
	<hr/>
	
	<button type="submit" name="save" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_save')?>
	</button>

	<button type="submit" name="gallery" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_save_gallery')?>
	</button>

	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_cancel')?>
	</a>

<?php echo form_close(); ?>