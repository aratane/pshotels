
<?php
	$attributes = array( 'id' => 'rinfo_typ-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('rinfo_typ_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('rinfo_typ_name')?></label>

				<?php echo form_input( array(
					'name' => 'rinfo_typ_name',
					'value' => set_value( 'rinfo_typ_name', show_data( @$rinfo_typ->rinfo_typ_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'rinfo_typ_name' ),
					'id' => 'rinfo_typ_name'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg( 'rinfo_grp_name' )?></label>

				<?php 
					$options = array();
					foreach ( $this->RoomInfoGroup->get_all()->result() as $rinfo_grp) {
						$options[$rinfo_grp->rinfo_grp_id] = $rinfo_grp->rinfo_grp_name;
					}

					echo form_dropdown(
						'rinfo_grp_id',
						$options,
						set_value( 'rinfo_grp_id', @$rinfo_typ->rinfo_grp_id ),
						'class="form-control form-control-sm" id="rinfo_typ_id"'
					);
				?>

				</select>

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