
<div class="popular-rooms mb-4 ps-card-hover">

	<h2>Popular Rooms</h2>
	
	<p class="lead">
		<?php echo get_msg( 'popular_room_slogan' ); ?>

		<button class="btn btn-sm btn-info pull-right">
			<a href="<?php echo site_url( 'popular_rooms' ); ?>">View All Popular Rooms</a>
		</button>
	</p>

	<div class="row">
		<div class="col-12 col-lg-6 padding-0-first">

			<?php $room_template = $template_path .'/components/home/popular_room.php'; ?>

			<?php 
				// if there is an room, set the room
				$room = ( isset( $popular_rooms[0] ))? $popular_rooms[0]: $this->ps_dummy->get_dummy_room();

				$this->load->view( $room_template, array( 'room_info' => $room ));
			?>

			<?php 
				// if there is an room, set the room
				$room = ( isset( $popular_rooms[1] ))? $popular_rooms[1]: $this->ps_dummy->get_dummy_room();

				$this->load->view( $room_template, array( 'room_info' => $room ));
			?>

			<?php 
				// if there is an room, set the room
				$room = ( isset( $popular_rooms[2] ))? $popular_rooms[2]: $this->ps_dummy->get_dummy_room();

				$this->load->view( $room_template, array( 'room_info' => $room ));
			?>

		</div>

		<div class="col-12 col-lg-6 padding-0">
			
			<?php 
				// if there is an room, set the room
				$room = ( isset( $popular_rooms[3] ))? $popular_rooms[3]: $this->ps_dummy->get_dummy_room();

				$this->load->view( $room_template, array( 'room_info' => $room ));
			?>

			<?php 
				// if there is an room, set the room
				$room = ( isset( $popular_rooms[4] ))? $popular_rooms[4]: $this->ps_dummy->get_dummy_room();

				$this->load->view( $room_template, array( 'room_info' => $room ));
			?>

			<?php 
				// if there is an room, set the room
				$room = ( isset( $popular_rooms[5] ))? $popular_rooms[5]: $this->ps_dummy->get_dummy_room();

				$this->load->view( $room_template, array( 'room_info' => $room ));
			?>

		</div>

	</div>

	
</div>