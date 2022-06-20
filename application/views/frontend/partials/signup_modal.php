
<!-- sign up form modal -->
<div class="modal fade" id="signupModal" tabindex="-1" role="dialog">
	
	<div class="modal-dialog" role="document">
		
		<div class="modal-content">

			<div class="modal-body p-3">

				<button class="btn btn-sm float-right" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="mb-3">Create New User</h4>

				<hr/>

				<div class="signupFlashMessage">
					<p id="signupError" class="text-danger fade"></p>

					<p id="signupSuccess" class="text-success fade"></p>
				</div>

				<?php
	        		$attributes = array('id' => 'signup-form','method' => 'POST');
	        		echo form_open( site_url( 'citiesdirectory/create_user?url='. current_url()), $attributes);
        		?>
    	    		<input id="signup_name" class="mb-3 ps-input" type="text" name="" placeholder="Name">

					<input id="signup_email" class="mb-3 ps-input" type="email" name="" placeholder="Email Address">

					<input id="signup_password" class="mb-3 ps-input" type="password" name="" placeholder="Password">

					<input id="signup_conf_password" class="mb-3 ps-input" type="password" name="" placeholder="Confirm Password">

					<button id="btnSignup" type="submit" class="btn btn-sm btn-outline-info float-right">Sign Up</button>
				</form>

			</div>
		
		</div>
	
	</div>

</div>

<script type="text/javascript">
	function signup() {
		
		$('#btnSignup').click(function(e){

			e.preventDefault();
			console.log('signup is clicked');

			// clear flash message
			$('#signupFlashMessage p').removeClass('show');

			$.ajax({
				method: 'POST',
				url: ajaxUrl +'/signup',
				data:{
					"user_name": $('#signup_name').val(),
					"user_email": $('#signup_email').val(),
					"user_password": $('#signup_password').val(),
					"confPassword": $('#signup_conf_password').val()
				},
				dataType: 'json',
				success:function(data){

					console.log(data);

					if ( data.status == "error" ) {
					// error handling

						$('#signupError').html( data.message ).fadeIn('slow').addClass('show');
					} else if ( data.status == "success" ) {
					// after login success

						location.reload();

						// // show or hide after login
						// $('.hide-after-login').hide();
						// $('.show-after-login').show();

						// // add user id to profile
						// $('#profileLink').attr('href', $('#profileLink').attr('href') + data.data );

						// // hide modal
						// $('#signupModal').modal('hide');
					} else {
					// else

						console.log( "neighter success or error" );
						console.log( data );
						$('#signupModal').modal('hide');
					}
				}
			});
		});
	}
</script>