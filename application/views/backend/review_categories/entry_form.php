
<?php
	$attributes = array( 'id' => 'rvcat-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('rvcat_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('rvcat_name')?></label>

				<?php echo form_input( array(
					'name' => 'rvcat_name',
					'value' => set_value( 'rvcat_name', show_data( @$rvcat->rvcat_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'rvcat_name' ),
					'id' => 'rvcat_name'
				)); ?>

			</div>		
			
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