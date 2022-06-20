
<?php
	$attributes = array( 'id' => 'country-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('ctry_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('ctry_name')?></label>

				<?php echo form_input( array(
					'name' => 'country_name',
					'value' => set_value( 'country_name', show_data( @$country->country_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'ctry_name' ),
					'id' => 'country_name'
				)); ?>

			</div>

			<?php $this->load->view( $template_path .'/components/cover_photo_uploader', array( 
				'img_type' => 'country', 
				'img_parent_id' => @$country->country_id 
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