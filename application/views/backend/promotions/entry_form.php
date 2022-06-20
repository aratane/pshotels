
<?php
	$attributes = array( 'id' => 'promo-form', 'enctype' => 'multipart/form-data');
	echo form_open( '', $attributes);
?>
	<h5><?php echo get_msg('promo_info')?></h5>
	
	<div class="row my-4">
		<div class="col-6">
			
			<div class="form-group">
				<label><?php echo get_msg('promo_name')?></label>

				<?php echo form_input( array(
					'name' => 'promo_name',
					'value' => set_value( 'promo_name', show_data( @$promotion->promo_name ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'promo_name' ),
					'id' => 'promo_name'
				)); ?>

			</div>

			<div class="form-group">
				<label><?php echo get_msg('promo_desc')?></label>

				<?php echo form_textarea( array(
					'name' => 'promo_desc',
					'value' => set_value( 'promo_desc', show_data( @$promotion->promo_desc ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'promo_desc' ),
					'id' => 'promo_desc',
					'rows' => 5
				)); ?>

			</div>
		</div>

		<div class="col-6">

			<div class="form-group">
				<label><?php echo get_msg('promo_percent')?></label>

				<?php echo form_input( array(
					'name' => 'promo_percent',
					'value' => set_value( 'promo_percent', show_data( @$promotion->promo_percent ), false ),
					'class' => 'form-control form-control-sm',
					'placeholder' => get_msg( 'promo_percent' ),
					'id' => 'promo_percent'
				)); ?>

			</div>

			<div class="form-group">

				<div class="row">
					<div class="col-6">
						<label><?php echo get_msg('promo_start_time')?></label>

						<div id="promo_start_time" class="input-group date promo_dtp">

							<?php echo form_input( array(
								'name' => 'promo_start_time',
								'value' => set_value( 'promo_start_time', show_data( @$promotion->promo_start_time ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'promo_start_time' ),
								'id' => 'promo_start_time',
								'readonly' => 'readonly'
							)); ?>

							<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
			            </div>

					</div>
					<div class="col-6">
						<label><?php echo get_msg('promo_end_time')?></label>

						<div id="promo_end_time" class="input-group date promo_dtp">

							<?php echo form_input( array(
								'name' => 'promo_end_time',
								'value' => set_value( 'promo_end_time', show_data( @$promotion->promo_end_time ), false ),
								'class' => 'form-control form-control-sm',
								'placeholder' => get_msg( 'promo_end_time' ),
								'id' => 'promo_end_time',
								'readonly' => 'readonly'
							)); ?>

							<span class="input-group-addon"><span class="fa fa-calendar"></span></span>
						</div>
					</div>
				</div>
			</div>
			
		</div>
	</div>
				
	<hr/>

	<?php $this->load->view( $template_path .'/'. $module_path .'/rooms_form', array( 'promotion' => @$promotion )); ?>
				
	<hr/>
	
	<button type="submit" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_save')?>
	</button>

	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
		<?php echo get_msg('btn_cancel')?>
	</a>

<?php echo form_close(); ?>