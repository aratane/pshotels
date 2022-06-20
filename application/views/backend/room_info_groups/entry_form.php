
<?php
	$attributes = array( 'id' => 'rinfo_grp-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('rinfo_grp_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('rinfo_grp_name')?></label>

				<?php echo form_input( array(
					'name' => 'rinfo_grp_name',
					'value' => set_value( 'rinfo_grp_name', show_data( @$rinfo_grp->rinfo_grp_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'rinfo_grp_name' ),
					'id' => 'rinfo_grp_name'
				)); ?>

			</div>

			<?php $this->load->view( $template_path .'/components/cover_photo_uploader', array( 
				'img_type' => 'rinfo_grp', 
				'img_parent_id' => @$rinfo_grp->rinfo_grp_id 
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