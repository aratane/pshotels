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

	</div>

</div>