<div class="container mt-3 mb-5">

	<div class="row">
		<div class="col-5">

			<!-- categories -->
			<div class="text-left">
				<h2 class="mt-3">Reset Password</h2>
				<p class="lead">Enter new password and confirm password</p>
			</div>

			<div id="resetPassFlashMessage">
				<p id="resetPassError" class="text-danger fade"></p>

				<p id="resetPassSuccess" class="text-success fade"></p>
			</div>

			<?php
				$attributes = array('id' => 'reset-form','method' => 'POST');
				echo form_open( '', $attributes);
			?>
				<input id="resetPass" class="mb-3 ps-input" type="password" name="password" placeholder="Password">

				<input id="resetConfPass" class="mb-3 ps-input" type="password" name="conf_password" placeholder="Confirm Password">

				<input type="submit" id="btnReset" class="btn btn-sm btn-outline-info float-right" value="Reset"/>
			</form>

			<a id="resetLink" class="btn btn-sm btn-outline-info fade" href="<?php echo site_url(); ?>">Go back to Home Page</a>
		</div>
	</div>
</div><!-- end of container -->

<script type="text/javascript">
	function resetPassword()
	{
		$('#resetLink').hide();

		$('#btnReset').click(function(e){

			e.preventDefault();

			// clear flash message
			$('#resetPassFlashMessage p').removeClass('show');

			$.ajax({
				method: 'POST',
				url: ajaxUrl +'/reset',
				data:{
					"code": "<?php echo $code; ?>",
					"password": $('#resetPass').val(),
					"conf_password": $('#resetConfPass').val()
				},
				dataType: 'json',
				success:function(data){

					console.log(data);

					if ( data.status == "error" ) {
					// error handling

						$('#resetPassError').html( data.message ).fadeIn('slow').addClass('show');
					} else if ( data.status == "success" ) {
					// after login success

						$('#resetPassSuccess').html( data.message ).fadeIn('slow').addClass('show');
						$('#resetLink').fadeIn('slow').addClass('show');
						$('#reset-form').hide();
					} else {
					// else
						console.log( "neighter success nor error" );
					}
				}
			});
		});
	}
</script>