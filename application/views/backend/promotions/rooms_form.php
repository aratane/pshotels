<?php 
	$logged_in_user = $this->ps_auth->get_user_info();
	if($logged_in_user->user_is_sys_admin == 1) {
		$hotels = $this->Hotel->get_all()->result();
	} else if($logged_in_user->is_hotel_admin == 1){
		$conds_user_hotel['user_id'] = $logged_in_user->user_id;
		$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();

		$user_hotels_ids = array();
		for($i=0; $i<count($user_hotel); $i++) {
		 	$user_hotels_ids[]= $user_hotel[$i]->hotel_id;
		}
		$hotels = $this->Hotel->get_all_in_hotel_admin($user_hotels_ids)->result();
	}
	
?>

<p class="lead"><?php echo get_msg( 'promo_choose_rooms' ); ?></p>

<div class="row">

<?php if ( !empty( $hotels )): foreach ( $hotels as $hotel ): ?>

	<?php $rooms = $this->Room->get_all_by( array( 'hotel_id' => $hotel->hotel_id ))->result(); ?>

	<?php if ( !empty( $rooms )): ?>

	<div class="col-4 mb-3">

		<h6><?php echo $hotel->hotel_name; ?></h6>

		<?php foreach ( $rooms as $room ): ?>

		<div class="form-group">
			
			<div class="form-check">

				<label class="form-check-label">
			
				<?php echo form_checkbox( array(
					'name' => 'rooms[]',
					'id' => 'rooms[]',
					'value' => $room->room_id,
					'checked' => set_checkbox('rooms[]', 1, ( @in_array( $room->room_id, @$promotion->promo_room_ids ))? true: false ),
					'class' => 'form-check-input'
				));	?>

				<?php echo $room->room_name; ?>		
				</label>
			</div>
		</div>

	<?php endforeach; endif; ?>

	</div>

<?php endforeach;  endif; ?>

</div>