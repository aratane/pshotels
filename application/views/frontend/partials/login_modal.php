
<!-- login modal -->
<div class="modal fade" id="loginModal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">

			<div class="modal-body p-3">

				<button class="btn btn-sm float-right" type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>

				<h4 class="mb-3">Login to <?php echo get_msg( 'site_name' ); ?></h4>

				<hr/>

				<div class="loginFlashMessage">
					<p id="loginError" class="text-danger fade"></p>

					<p id="loginSuccess" class="text-success fade"></p>
				</div>

				<?php
	        		$attributes = array('id' => 'login-form','method' => 'POST');
	        		echo form_open( site_url( 'login?url='. current_url()), $attributes);
        		?>
					<input id="login_email" class="mb-3 ps-input" type="email" name="" placeholder="Email Address">

					<input id="login_password" class="mb-3 ps-input" type="password" name="" placeholder="Password">

					<button id="btnLogin" type="submit" class="btn btn-sm btn-outline-info float-right">Log In</button>
				</form>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
	function login() {

		$('#btnLogin').click(function(e){

			e.preventDefault();

			// clear flash message
			$('#loginFlashMessage p').removeClass('show');

			$.ajax({
				method: 'POST',
				url: ajaxUrl +'/login',
				data:{
					"email": $('#login_email').val(),
					"password": $('#login_password').val()
				},
				dataType: 'json',
				success:function(data){

					console.log(data);

					if ( data.status == "error" ) {
					// error handling

						$('#loginError').html( data.message ).fadeIn('slow').addClass('show');
					} else if ( data.status == "success" ) {
					// after login success

						location.reload();

						// // show or hide after login
						// $('.hide-after-login').hide();
						// $('.show-after-login').show();

						// // add user id to profile
						// $('#profileLink').attr('href', $('#profileLink').attr('href') + data.data );

						// // hide modal
						// $('#loginModal').modal('hide');
					} else {
					// else

						console.log( data );
						$('#loginModal').modal('hide');
					}
				}
			});
		});
	}
</script>