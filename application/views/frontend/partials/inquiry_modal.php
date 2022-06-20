
<!-- sign up form modal -->
<div class="modal fade" id="inquiryModal" tabindex="-1" role="dialog">
	
	<div class="modal-dialog" role="document">
		
		<div class="modal-content">

			<div class="modal-body p-3">

				<button class="btn btn-sm float-right" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="mb-3">Inquiry about <span id="inq_room_name" class="room_name">this room</span></h4>

				<hr/>

				<div class="inquiryFlashMessage">
					<p id="inquiryError" class="text-danger fade"></p>

					<p id="inquirySuccess" class="text-success fade"></p>
				</div>

				<?php
	        		$attributes = array('id' => 'inquiry-form','method' => 'POST');
	        		echo form_open( site_url( 'citiesdirectory/create_user?url='. current_url()), $attributes);
        		?>
					<?php if ( $this->ps_auth->is_logged_in()) $user = $this->ps_auth->get_user_info(); ?>

    	    		<input id="inq_user_name" class="mb-3 ps-input" type="text" name="" placeholder="Name" value="<?php echo @$user->user_name; ?>">

					<input id="inq_user_email" class="mb-3 ps-input" type="email" name="" placeholder="Email Address" value="<?php echo @$user->user_email; ?>">

					<input id="inq_user_phone" class="mb-3 ps-input" type="phone" name="" placeholder="Phone Number">

					<input id="inq_name" class="mb-3 ps-input" type="text" name="" placeholder="Inquiry Title">

					<?php echo form_textarea( array(
						'name' => 'inq_desc',
						'class' => 'mb-3 ps-input',
						'placeholder' => get_msg( 'inq_desc' ),
						'id' => 'inq_desc',
						'rows' => 5
					)); ?>

					<input type="hidden" id="inq_room_id"/>

					<input type="hidden" id="inq_user_id" value="<?php echo @$user->user_id; ?>"/>

					<button id="btnInquiry" type="submit" class="btn btn-sm btn-outline-info float-right">Submit Inquiry</button>
				</form>

			</div>
		
		</div>
	
	</div>

</div>

<script type="text/javascript">
	function inquiry() {

		$('.btn-inq-modal').click(function(){
			var id = $(this).attr('roomid');
			var name = $(this).attr('roomname');
			console.log(id);
			$('#inq_room_id').val( id );
			$('#inq_room_name').html( name );

			$('.inquiryFlashMessage p').removeClass('show');
		});
		
		$('#btnInquiry').click(function(e){

			e.preventDefault();
			console.log('inquiry is clicked');

			// clear flash message
			$('.inquiryFlashMessage p').removeClass('show');

			$.ajax({
				method: 'POST',
				url: ajaxUrl +'/inquiry',
				data:{
					"room_id": $('#inq_room_id').val(),
					"user_id": $('#inq_user_id').val(),
					"inq_user_name": $('#inq_user_name').val(),
					"inq_user_email": $('#inq_user_email').val(),
					"inq_user_phone": $('#inq_user_phone').val(),
					"inq_name": $('#inq_name').val(),
					"inq_desc": $('#inq_desc').val()
				},
				dataType: 'json',
				success:function(data){

					if ( data.status == "error" ) {
					// error handling

						$('#inquiryError').html( data.message ).fadeIn('slow').addClass('show');
					} else if ( data.status == "success" ) {

						$('#inquirySuccess').html( data.message ).fadeIn('slow').addClass('show');
						
						$('#room_id, #inq_name, #inq_desc').val('');

						<?php if (!isset( $user )): ?>

						$('#inq_user_name, #inq_user_email').val('');

						<?php endif; ?>
						
						setTimeout(function (){
							$('#inquiryModal').modal('hide');
						}, 500);

					} else {
					// else

						console.log( "neighter success or error" );
						console.log( data );
						$('#inquiryModal').modal('hide');
					}
				}
			});
		});
	}
</script>