
<div class="container box-shadow my-3" >

	<div class="row">
		<div class="col-md-12 col-lg-8 py-2 px-3 " style="background-color: white;">

			<!-- categories -->
			<div class="text-left mb-1">
					
				<h2 class="mt-2">
					<span class="user_name">
						<?php echo $user->user_name; ?>
					</span>

					<?php if ( $this->ps_auth->is_logged_in() && $this->ps_auth->get_user_info()->user_id == $user->user_id ): ?>
						
						<i id="editProfile" class="fa fa-pencil-square-o ml-3 grow text-info" aria-hidden="true"></i>

					<?php endif; ?>
				</h2>

				<hr/>

				<div class="profileFlashMessage">
					<p id="profileError" class="text-danger d-none"></p>

					<p id="profileSuccess" class="text-success d-none"></p>
				</div>

				<div class="row">
				
					<div class="col-6 col-md-4 mb-2">

						<?php 
							// get dummy photo
							$img = $this->ps_dummy->get_dummy_photo();

							// if there is an image, set the image
							if ( !empty( $user->user_profile_photo )) $img->img_path = $user->user_profile_photo;
						?>

						<img class="user_profile_photo img-fluid" alt="<?php echo $img->img_path; ?>" src="<?php echo base_url( '/uploads/'. $img->img_path ); ?>">
					</div>

					<div class="col-6 col-md-3">

						<p><strong>Total Comments</strong>: <?php echo $user->total_comments; ?></p>

						<p><strong>Total Favourites</strong>: <?php echo $user->total_favourites; ?></p>

						<input id="profilePhoto" type="file" name="profileImg" style="display:none"/> 

						<?php if ( $this->ps_auth->is_logged_in() && $this->ps_auth->get_user_info()->user_id == $user->user_id ): ?>
							
							<button type="button" class="btnProfilePhoto btn btn-sm btn-outline-info float-right">Update Profile Photo</button>

						<?php endif; ?>

					</div>

					<div class="col-12 col-md-5">

						<!-- <h4 class="mt-4">Contact Information</h4> -->
							
						<p><strong>Email</strong>: <span class="user_email"><?php echo $user->user_email; ?></span></p>

						<div class="hide-edit-profile">

							<p><strong>Phone</strong>: <span class="user_phone"><?php echo $user->user_phone; ?></span></p>

						</div>

						<div class="show-edit-profile d-none">

							<p>

								<strong><?php echo get_msg( 'user_name' ); ?></strong>
								<input id="user_name" class="mb-2 ps-input" type="text" placeholder="user name" value="<?php echo $user->user_name; ?>">

								<strong><?php echo get_msg( 'user_email' ); ?></strong>
								<input id="user_email" class="mb-2 ps-input" type="text" placeholder="email address" value="<?php echo $user->user_email; ?>">
								
								<strong><?php echo get_msg( 'user_password' ); ?></strong>
								<input id="user_password" class="mb-2 ps-input" type="password">

								<strong><?php echo get_msg( 'conf_password' ); ?></strong>
								<input id="conf_password" class="mb-2 ps-input" type="password">

								<strong><?php echo get_msg( 'user_phone' ); ?></strong>
								<input id="user_phone" class="mb-2 ps-input" type="phone" placeholder="Phone" value="<?php echo $user->user_phone; ?>">

							</p>

							<button type="button" class="btnProfile btn btn-sm btn-outline-info float-right">Update</button>
						</div>

					</div>

				</div>

				<hr/>

				<div class="row">
					<div class="col-12">

						<h4>About Me</h4>

						<div class="hide-edit-profile">
							
							<p class="user_about_me"><?php echo $user->user_about_me; ?></p>
						</div>

						<div class="show-edit-profile d-none">

							<textarea id="user_about_me" class="ps-input" rows="3"><?php echo $user->user_about_me; ?></textarea>

							<button type="button" class="btnProfile btn btn-sm btn-outline-info float-right">Update</button>
						</div>
						

					</div>
				</div>
			</div>

			<?php if ( $this->ps_auth->is_logged_in() && $this->ps_auth->get_user_info()->user_id == $user->user_id ): ?>

			<?php $this->ps_widget->booking_list(); ?>

			<?php $this->ps_widget->favourite_hotels(); ?>

			<?php endif; ?>

		</div>
		
		<div class="d-none d-lg-block col-lg-4 py-2 px-3 ">

			<?php echo $this->ps_widget->sidebar(); ?>

			<div class="my-3">
				<?php echo show_ads(); ?>
			</div>

		</div>
	</div>

</div><!-- end of container -->

<script type="text/javascript">
	function profile()
	{
		<?php if ( $this->ps_auth->is_logged_in() && $this->ps_auth->get_user_info()->user_id == $user->user_id ): ?>

		$('.btnProfilePhoto').click(function(){
			console.log('profile photo updated');
			$('#profilePhoto').trigger('click');
		});

		$("#profilePhoto").change(function(e){

			var data = new FormData();
		    var files = e.target.files[0];
		    data.append( 'user_profile_photo', files );	

		    $.ajax({
		    	method: 'POST',
		    	url: userUrl + '/update_profile_photo',
		    	data: data,
		        cache: false,
		        processData: false, // Don't process the files
		        contentType: false, // Set content type to false as jQuery will tell the server its a query string request
		    	dataType: 'json',
		    	success:function(resp){

		    		if ( resp.status == 'success' ) {
				
						$('.profileFlashMessage p').addClass('d-none');

		    			$('.user_profile_photo').attr('src', uploadPath + resp.data );
		    		} else {
		    			$('#profileError').html( resp.message ).fadeIn('slow').removeClass('d-none');
		    		}
		    	}
		    });
		});
		
		$('#editProfile').click(function(){
			
			$(this).toggleClass('fa-pencil-square-o fa-pencil-square');
			$('.show-edit-profile').toggleClass('d-none');
			$('.hide-edit-profile').toggleClass('d-none');
		});

		$('.btnProfile').click(function(){

			// profile data
			data = {
				"user_name": $('#user_name').val(),
				"user_email": $('#user_email').val(),
				"user_phone": $('#user_phone').val(),
				"user_about_me": $('#user_about_me').val()
			};

			// check password changed
			var password = $('#user_password').val();
			var confPassword = $('#conf_password').val();

			if ( password != confPassword ) {
				$('#profileError').html( "Password and Confirm Password do not match" ).fadeIn('slow').removeClass('d-none');
				return;
			}

			if ( password ) {
				data.user_password = password;
			}

			// update profile
			$.ajax({
				type: 'POST',
				url: userUrl + '/update_profile',
				data: data,
				dataType: 'json',
				success:function(resp){
				
					$('.profileFlashMessage p').addClass('d-none');

					console.log(resp);

					if ( resp.status == 'success' ) {

						// update UI
						$('.show-edit-profile').addClass('d-none');
						$('.hide-edit-profile').removeClass('d-none');

						// update date
						$('.user_name').html(resp.data.user_name);
						$('.user_email').html(resp.data.user_email);
						$('.user_phone').html(resp.data.user_phone);
						$('.user_about_me').html(resp.data.user_about_me);

						// update status
						$('#profileSuccess').html( "User profile is updated!" ).fadeIn('slow').removeClass('d-none');
					} else {
						
						$('#profileError').html( resp.message ).fadeIn('slow').removeClass('d-none');
					}
				}
			});
		});

		<?php endif; ?>
	}
</script>