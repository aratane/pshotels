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

			<?php 
				$options = array( '' => 'All Hotels');
				foreach ( $this->Hotel->get_all()->result() as $hotel) {
					$options[$hotel->hotel_id] = $hotel->hotel_name;
				}

				echo form_dropdown(
					'hotel_id',
					$options,
					set_value( 'hotel_id' ),
					'class="form-control form-control-sm mr-3" id="hotel_id"'
				);
			?>

		</div>

		<div class="form-group">

			<?php 
				$options = array( 
					'' => 'Booking Status',
					'IN-PROGRESS' => 'IN-PROGRESS',
					'CONFIRMED' => 'CONFIRMED',
					'CANCELLED' => 'CANCELLED'
				);

				echo form_dropdown(
					'booking_status',
					$options,
					set_value( 'booking_status' ),
					'class="form-control form-control-sm mr-3" id="booking_status"'
				);
			?>

		</div>

		<div class="form-group">
		  	<button type="submit" class="btn btn-sm btn-primary mr-3">
		  		<?php echo get_msg( 'btn_search' )?>
		  	</button>
	  	</div>

	  	<div class="form-group">
		  	<a href="<?php echo $module_site_url; ?>" class="btn btn-sm btn-primary">
		  		<?php echo get_msg( 'btn_reset' )?>
		  	</a>
	  	</div>
	
	<?php echo form_close(); ?>

	</div>	

	<div class='col-3'>

	</div>

</div>