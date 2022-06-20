<div class='row my-3'>

	<div class='col-9'>
	<?php
		$attributes = array('class' => 'form-inline');
		echo form_open( $module_site_url .'/search', $attributes);
	?>
		
		<div class="form-group mr-3">

			<?php echo form_input(array(
				'name' => 'searchterm',
				'value' => set_value( 'searchterm' ),
				'class' => 'form-control form-control-sm',
				'placeholder' => 'Search'
			)); ?>

	  	</div>

		<div class="form-group">
		  	<button type="submit" class="btn btn-sm btn-primary">
		  		<?php echo get_msg( 'btn_search' )?>
		  	</button>
	  	</div>
	
	<?php echo form_close(); ?>

	</div>	

	<div class='col-3'>

		<?php if ( $this->ps_auth->has_access( ADD )): ?>
			
			<a href='<?php echo $module_site_url .'/add';?>' class='btn btn-sm btn-primary pull-right'>
				<span class='fa fa-plus'></span> 
				<?php echo get_msg( 'promo_add' )?>
			</a>

		<?php endif; ?>
	</div>

</div>