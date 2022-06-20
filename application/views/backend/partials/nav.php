<div class="fluid-container navbar-container">
	
	<div class="container">

		<nav class="navbar navbar-expand-md">

			<?php $be_url = $this->config->item('be_url'); ?>

			<a class="navbar-brand" href="<?php echo site_url( $be_url ); ?>">
				<?php echo $site_name; ?>
			</a>

			<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#profile" aria-controls="profile" aria-expanded="false" aria-label="Toggle navigation">
				<span class="fa fa-bars" style="color: white"></span>
			</button>

			<div class="collapse navbar-collapse" id="profile">

				<ul class="navbar-nav ml-auto">
					<li class="nav-item dropdown">

						<a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
							Account
							<b class="caret"></b>
						</a>

						<div class="dropdown-menu dropdown-menu-right" id="navbarDropdown">
							
							<div class="navbar-content" aria-labelledby="navbarDropdown">
										
								<?php $logged_in_user = $this->ps_auth->get_user_info(); ?>

								<div class="row">

									<div class="col-md-5">
										<?php $upload_thumbnail_path = $this->config->item( 'upload_thumbnail_path' ); ?>

										<?php $img = ( empty( $logged_in_user->user_profile_photo ))? get_dummy_photo(): $logged_in_user->user_profile_photo; ?>

										<img src="<?php echo base_url( $upload_thumbnail_path . $img );?>" alt="Alternate Text" class="img-responsive" width="100"/>

									</div>

									<div class="col-md-7">

										<span><?php echo $logged_in_user->user_name;?></span>

										<span class="small"><?php echo $this->Role->get_name($logged_in_user->role_id);?></span>

									</div>
								</div>

							</div>
								
							<div class="navbar-footer">
								
								<div class="navbar-footer-content">
									<div class="row">
										<div class="col-md-6">

											<a href="<?php echo site_url ( $be_url . '/profile');?>" class="btn btn-default btn-sm" style="background-color: #fff;background-image:  none;border-radius: 0;">Edit Profile</a>
										</div>
										<div class="col-md-6">
											<a href="<?php echo site_url('logout');?>" class="btn btn-default btn-sm pull-right" style="background-color: #fff; border-radius: 0;">Sign Out</a>
										</div>
									</div>
								</div>

							</div>
						</div>
					</li>
				</ul>
			</div>
			
		</nav>

	</div>
</div>