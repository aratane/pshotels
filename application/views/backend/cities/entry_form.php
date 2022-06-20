
<?php
	$attributes = array( 'id' => 'city-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('city_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('city_name')?></label>

				<?php echo form_input( array(
					'name' => 'city_name',
					'value' => set_value( 'city_name', show_data( @$city->city_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'city_name' ),
					'id' => 'city_name'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg( 'country_name' )?></label>

				<?php 
					$options = array();
					foreach ( $this->Country->get_all()->result() as $country) {
						$options[$country->country_id] = $country->country_name;
					}

					echo form_dropdown(
						'country_id',
						$options,
						set_value( 'country_id', @$city->country_id ),
						'class="form-control form-control-sm" id="country_id"'
					);
				?>

				</select>

			</div>

			<?php $this->load->view( $template_path .'/components/cover_photo_uploader', array( 
				'img_type' => 'city', 
				'img_parent_id' => @$city->city_id 
			)); ?>		
			
		</div>
	</div>
				
	<hr/>
	
	<button type="submit" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_save')?>
	</button>

	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_cancel')?>
	</a>

<?php echo form_close(); ?>