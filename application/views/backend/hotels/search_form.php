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

		<div class="form-group">
			<?php
				$options = array( '' => 'All Stars Rating', '1' => '1 star', '2' => '2 stars', '3' => '3 stars', '4' => '4 stars', '5' => '5 stars' );

				echo form_dropdown(
					'hotel_star_rating',
					$options,
					set_value( 'hotel_star_rating' ),
					'class="form-control form-control-sm mr-3" id="hotel_star_rating"'
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

<?php if($logged_in_user->user_is_sys_admin == 1) { ?>
	<div class='col-3'>

		<?php if ( $this->ps_auth->has_access( ADD )): ?>
			
			<a href='<?php echo $module_site_url .'/add';?>' class='btn btn-sm btn-primary pull-right'>
				<span class='fa fa-plus'></span> 
				<?php echo get_msg( 'hotel_add' )?>
			</a>

		<?php endif; ?>
	</div>
<?php } ?>

</div>