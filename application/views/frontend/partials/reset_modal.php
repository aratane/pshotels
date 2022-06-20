
<!-- sign up form modal -->
<div class="modal fade" id="resetModal" tabindex="-1" role="dialog">
	
	<div class="modal-dialog" role="document">
		
		<div class="modal-content">

			<div class="modal-body p-3">

				<button class="btn btn-sm float-right" type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>

				<h4 class="mb-3">Reset Password</h4>

				<hr/>

				<div id="resetFlashMessage">
					<p id="resetError" class="text-danger fade"></p>

					<p id="resetSuccess" class="text-success fade"></p>
				</div>

				<?php
	        		$attributes = array('id' => 'resetRequest','method' => 'POST');
	        		echo form_open( site_url(), $attributes);
        		?>
					<input id="resetEmail" class="mb-3 ps-input" type="email" name="user_email" placeholder="Email Address">

					<button id="btnResetEmail" type="submit" class="btn btn-sm btn-outline-info float-right">Reset Password</button>
				</form>

			</div>
		
		</div>
	
	</div>

</div>

<script type="text/javascript">
	function resetEmail() {
		
		$('#btnResetEmail').click(function(e){

			e.preventDefault();
			console.log('reset is clicked');

			// clear flash message
			$('#resetFlashMessage p').removeClass('show');

			$.ajax({
				method: 'POST',
				url: ajaxUrl +'/reset_email',
				data:{
					"email": $('#resetEmail').val()
				},
				dataType: 'json',
				success:function(data){

					console.log(data);

					if ( data.status == "error" ) {
					// error handling

						$('#resetError').html( data.message ).fadeIn('slow').addClass('show');
					} else if ( data.status == "success" ) {
					// after login success

						$('#resetSuccess').html( data.message ).fadeIn('slow').addClass('show');
						setTimeout(function (){
							$('#resetModal').modal('hide');

							$('#resetFlashMessage p').removeClass('show');

							$('#resetEmail').val("");
						}, 500);
					} else {
					// else

						console.log( "neighter success or error" );
						console.log( data );
						$('#resetModal').modal('hide');
					}
				}
			});
		});
	}
</script>