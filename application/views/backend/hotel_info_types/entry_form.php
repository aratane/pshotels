
<?php
	$attributes = array( 'id' => 'hinfo_typ-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('hinfo_typ_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('hinfo_typ_name')?></label>

				<?php echo form_input( array(
					'name' => 'hinfo_typ_name',
					'value' => set_value( 'hinfo_typ_name', show_data( @$hinfo_typ->hinfo_typ_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'hinfo_typ_name' ),
					'id' => 'hinfo_typ_name'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg( 'hinfo_grp_name' )?></label>

				<?php 
					$options = array();
					foreach ( $this->HotelInfoGroup->get_all()->result() as $hinfo_grp) {
						$options[$hinfo_grp->hinfo_grp_id] = $hinfo_grp->hinfo_grp_name;
					}

					echo form_dropdown(
						'hinfo_grp_id',
						$options,
						set_value( 'hinfo_grp_id', @$hinfo_typ->hinfo_grp_id ),
						'class="form-control form-control-sm" id="hinfo_typ_id"'
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