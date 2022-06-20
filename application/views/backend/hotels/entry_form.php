
<?php
	$attributes = array( 'id' => 'hotel-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('hotel_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('hotel_name')?></label>

				<?php echo form_input( array(
					'name' => 'hotel_name',
					'value' => set_value( 'hotel_name', show_data( @$hotel->hotel_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'hotel_name' ),
					'id' => 'hotel_name'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg( 'city_name' )?></label>

				<?php 
					$options = array();
					foreach ( $this->City->get_all()->result() as $city) {
						$options[$city->city_id] = $city->city_name;
					}

					echo form_dropdown(
						'city_id',
						$options,
						set_value( 'city_id', @$hotel->city_id ),
						'class="form-control form-control-sm" id="city_id"'
					);
				?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('hotel_desc')?></label>

				<?php echo form_textarea( array(
					'name' => 'hotel_desc',
					'value' => set_value( 'hotel_desc', show_data( @$hotel->hotel_desc ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'hotel_desc' ),
					'id' => 'hotel_desc',
					'rows' => 5
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('hotel_address')?></label>

				<?php echo form_input( array(
					'name' => 'hotel_address',
					'value' => set_value( 'hotel_address', show_data( @$hotel->hotel_address ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'hotel_address' ),
					'id' => 'hotel_address'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('hotel_email')?></label>

				<?php echo form_input( array(
					'name' => 'hotel_email',
					'value' => set_value( 'hotel_email', show_data( @$hotel->hotel_email ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'hotel_email' ),
					'id' => 'hotel_email'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('hotel_phone')?></label>

				<?php echo form_input( array(
					'name' => 'hotel_phone',
					'value' => set_value( 'hotel_phone', show_data( @$hotel->hotel_phone ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'hotel_phone' ),
					'id' => 'hotel_phone'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg( 'hotel_star_rating' )?></label>

				<?php 
					$options = array( '1' => '1 star', '2' => '2 stars', '3' => '3 stars', '4' => '4 stars', '5' => '5 stars' );

					echo form_dropdown(
						'hotel_star_rating',
						$options,
						set_value( 'hotel_star_rating', @$hotel->hotel_star_rating ),
						'class="form-control form-control-sm" id="hotel_star_rating"'
					);
				?>

			</div>

		</div>

		<div class="col-6">

			<div class="form-group">

				<div class="row">
					<div class="col-6">
						
						<label><?php echo get_msg('hotel_min_price')?></label>

						<?php echo form_input( array(
							'name' => 'hotel_min_price',
							'value' => set_value( 'hotel_min_price', show_data( @$hotel->hotel_min_price ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'hotel_min_price' ),
							'id' => 'hotel_min_price'
						)); ?>

					</div>

					<div class="col-6">								

						<label><?php echo get_msg('hotel_max_price')?></label>

						<?php echo form_input( array(
							'name' => 'hotel_max_price',
							'value' => set_value( 'hotel_max_price', show_data( @$hotel->hotel_max_price ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'hotel_max_price' ),
							'id' => 'hotel_max_price'
						)); ?>

					</div>
				</div>

			</div>

			<div class="form-group">

				<div class="row">
					<div class="col-6">
						<label><?php echo get_msg('hotel_check_in')?></label>

						<?php echo form_input( array(
							'name' => 'hotel_check_in',
							'value' => set_value( 'hotel_check_in', show_data( @$hotel->hotel_check_in ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'hotel_check_in' ),
							'id' => 'hotel_check_in'
						)); ?>
					</div>

					<div class="col-6">
						<label><?php echo get_msg('hotel_check_out')?></label>

						<?php echo form_input( array(
							'name' => 'hotel_check_out',
							'value' => set_value( 'hotel_check_out', show_data( @$hotel->hotel_check_out ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'hotel_check_out' ),
							'id' => 'hotel_check_out'
						)); ?>
					</div>
				</div>
			</div>

			<?php $this->load->view( 'common/location_picker', array( 'lat' => @$hotel->hotel_lat, 'lng' => @$hotel->hotel_lng )); ?>

			<div class="form-group">

				<div class="row">
					<div class="col-6">
						<label><?php echo get_msg('hotel_lat')?></label>

						<?php echo form_input( array(
							'name' => 'hotel_lat',
							'value' => set_value( 'hotel_lat', show_data( @$hotel->hotel_lat ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'hotel_lat' ),
							'id' => 'lat'
						)); ?>
					</div>

					<div class="col-6">
						<label><?php echo get_msg('hotel_lng')?></label>

						<?php echo form_input( array(
							'name' => 'hotel_lng',
							'value' => set_value( 'hotel_lng', show_data( @$hotel->hotel_lng ), false ),
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'hotel_lng' ),
							'id' => 'lng'
						)); ?>
					</div>
				</div>
			</div>

			<div class="form-group">
				<div class="form-check">

					<label class="form-check-label">
					
					<?php echo form_checkbox( array(
						'name' => 'is_recommended',
						'id' => 'is_recommended',
						'value' => 'accept',
						'checked' => set_checkbox('is_recommended', 1, ( @$hotel->is_recommended == 1 )? true: false ),
						'class' => 'form-check-input'
					));	?>

					<?php echo get_msg( 'hotel_is_recommended' ); ?>

					</label>
				</div>
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