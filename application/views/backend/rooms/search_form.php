<div class='row my-3'>

	<div class='col-9'>
	<?php
		$attributes = array('class' => 'form-inline');
		echo form_open( $module_site_url .'/search', $attributes);
	?>
	<?php $logged_in_user = $this->ps_auth->get_user_info(); ?>
		
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
				$conds_user_hotel['user_id'] = $logged_in_user->user_id;
				$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();

				foreach ($user_hotel as $hotel) {
					$hotel_id .=$hotel->hotel_id;
				}
				$conds['hotel_id'] = $hotel_id;
				$options = array( '' => 'All Hotels');
				if($logged_in_user->user_is_sys_admin == 1){
					foreach ( $this->Hotel->get_all()->result() as $hotel) {
						$options[$hotel->hotel_id] = $hotel->hotel_name;
					}
				} else if($logged_in_user->is_hotel_admin == 1){
					foreach ( $this->Hotel->get_all_in_hotel_admin($conds)->result() as $hotel) {
						$options[$hotel->hotel_id] = $hotel->hotel_name;
					}
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
				$options = array( '' => 'All Cities' );
				foreach ( $this->City->get_all()->result() as $city) {
					$options[$city->city_id] = $city->city_name;
				}

				echo form_dropdown(
					'city_id',
					$options,
					set_value( 'city_id' ),
					'class="form-control form-control-sm mr-3" id="city_id"'
				);
			?>

		</div>

		<div class="form-group mr-3">
		  	<button type="submit" class="btn btn-sm btn-primary">
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

		<?php if ( $this->ps_auth->has_access( ADD )): ?>
			
			<a href='<?php echo $module_site_url .'/add';?>' class='btn btn-sm btn-primary pull-right'>
				<span class='fa fa-plus'></span> 
				<?php echo get_msg( 'room_add' )?>
			</a>

		<?php endif; ?>
	</div>

</div>