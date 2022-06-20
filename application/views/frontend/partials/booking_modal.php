
<!-- sign up form modal -->
<div class="modal fade" id="bookingModal" tabindex="-1" role="dialog">
	
	<div class="modal-dialog" role="document">
		
		<div class="modal-content">

			<div class="modal-body p-3">

				<button class="btn btn-sm float-right" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="mb-3">Book <span id="booking_room_name" class="room_name">this room</span></h4>

				<hr/>

				<div class="bookingFlashMessage">
					<p id="bookingError" class="text-danger fade"></p>

					<p id="bookingSuccess" class="text-success fade"></p>
				</div>

				<?php
	        		$attributes = array('id' => 'booking-form','method' => 'POST');
	        		echo form_open('', $attributes);
        		?>

					<?php if ( $this->ps_auth->is_logged_in()) $user = $this->ps_auth->get_user_info(); ?>

    	    		<input id="booking_user_name" class="mb-3 ps-input" type="text" name="" placeholder="Name" value="<?php echo @$user->user_name; ?>">

					<input id="booking_user_email" class="mb-3 ps-input" type="email" name="" placeholder="Email Address" value="<?php echo @$user->user_email; ?>">

					<input id="booking_user_phone" class="mb-3 ps-input" type="phone" name="" placeholder="Phone Number"value="<?php echo @$user->user_phone; ?>">

					<input id="booking_adult_count" class="mb-3 ps-input" type="number" name="" placeholder="Adult Count">

					<input id="booking_kid_count" class="mb-3 ps-input" type="number" name="" placeholder="Kids Count">

					<input id="booking_extra_bed" class="mb-3 ps-input" type="number" name="" placeholder="Extra Bed Count">

					<div id="booking_start_date_wrapper" class="input-group date mb-3" data-provide="datepicker">
						
						<?php 
						echo form_input( array(
							'name' => 'booking_start_date',
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'booking_start_date' ),
							'id' => 'booking_start_date',
							'readonly' => 'readonly'
						)); 
						?>
						
						<div class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</div>
					</div>

					<div id="booking_end_date_wrapper" class="input-group date mb-3" data-provide="datepicker">
						
						<?php 
						echo form_input( array(
							'name' => 'booking_end_date',
							'class' => 'form-control form-control-sm',
							'placeholder' => get_msg( 'booking_end_date' ),
							'id' => 'booking_end_date',
							'readonly' => 'readonly'
						));
						?>
						
						<div class="input-group-addon">
							<span class="fa fa-calendar"></span>
						</div>
					</div>

					<?php 
					echo form_textarea( array(
						'name' => 'booking_remark',
						'class' => 'mb-3 ps-input',
						'placeholder' => get_msg( 'booking_remark' ),
						'id' => 'booking_remark',
						'rows' => 5
					)); 
					?>

					<input type="hidden" id="user_id" value="<?php echo @$user->user_id; ?>"/>

					<input type="hidden" id="room_id"/>

					<button id="btnBook" type="submit" class="btn btn-sm btn-outline-info float-right">Submit Booking</button>
				</form>

			</div>
		
		</div>
	
	</div>

</div>

<script type="text/javascript">
	function booking() {

		$('#booking_start_date_wrapper').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayBtn: true,
			todayHighlight: true
		});
	    $('#booking_end_date_wrapper').datepicker({
	    	format: 'yyyy-mm-dd',
			autoclose: true,
			todayBtn: true,
			todayHighlight: true,
	        useCurrent: false //Important! See issue #1075
	    });

		$('.btn-booking-modal').click(function(){
			var id = $(this).attr('roomid');
			var name = $(this).attr('roomname');
			console.log(id);
			$('#room_id').val( id );
			$('#booking_room_name').html( name );

			$('.bookingFlashMessage p').removeClass('show');
		});
		
		$('#btnBook').click(function(e){

			e.preventDefault();
			console.log('booking is clicked');

			// clear flash message
			$('.bookingFlashMessage p').removeClass('show');

			$.ajax({
				method: 'POST',
				url: userUrl +'/booking',
				data:{
					"user_id": $('#user_id').val(),
					"room_id": $('#room_id').val(),
					"booking_user_name": $('#booking_user_name').val(),
					"booking_user_email": $('#booking_user_email').val(),
					"booking_user_phone": $('#booking_user_phone').val(),
					"booking_adult_count": $('#booking_adult_count').val(),
					"booking_kid_count": $('#booking_kid_count').val(),
					"booking_extra_bed": $('#booking_extra_bed').val(),
					"booking_start_date": $('#booking_start_date').val(),
					"booking_end_date": $('#booking_end_date').val(),
					"booking_remark": $('#booking_remark').val()
				},
				dataType: 'json',
				success:function(data){
					
					if ( data.status == "error" ) {
					// error handling
					
						console.log('error');

						$('#bookingError')
							.html( data.message )
							.fadeIn('slow')
							.addClass('show');
					} else if ( data.status == "success" ) {

						console.log('success');

						$('#bookingSuccess')
							.html( data.message )
							.fadeIn('slow')
							.addClass('show');
						
						$("#room_id, #booking_adult_count, #booking_kid_count, #booking_extra_bed, #booking_start_date, #booking_end_date").val('');
						
						setTimeout(function (){
							$('#bookingModal').modal('hide');
						}, 500);

					} else {
					// else

						console.log( "neighter success or error" );
						console.log( data );
						$('#bookingModal').modal('hide');
					}
				}
			});
		});
	}
</script>