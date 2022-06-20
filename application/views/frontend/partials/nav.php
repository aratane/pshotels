<div class="main-nav sticky-nav border-bottom">
	<div class="container">

		<div class="d-flex flex-column flex-md-row align-items-center py-2 mb-2">
			
			<h1 class="my-0 mr-md-auto font-weight-normal"><a href='<?php echo site_url(); ?>'>PS Hotels</a></h1>
			
			<nav class="my-2 my-md-0 mr-md-3">
				<a class="p-2 " href="<?php echo site_url(); ?>">Home</a>

				<!-- <a class="p-2 " href="<?php //echo site_url( 'city' ); ?>">Hotels</a> -->
				<!-- <a class="p-2 " href="rooms_search.php">Rooms</a> -->
				<a class="p-2 " href="<?php echo site_url('promotions'); ?>">Promotions</a>

				<?php if ( !$this->ps_auth->is_logged_in()): ?>
					
					<a class="p-2 " href="#" data-toggle='modal' data-target='#loginModal'>Login</a>
					<a class="p-2 " href="#" data-toggle='modal' data-target='#resetModal'>Reset Password</a>

				<?php else: ?>
					
					<a class="p-2 " href="<?php echo $module_site_url .'/profile/'. @$this->ps_auth->get_user_info()->user_id; ?>">
						<?php echo get_msg( 'nav_profile' ); ?>
					</a>
	
					<?php if ( $this->ps_auth->is_system_user()): ?>

					<a class="p-2 " href="<?php echo $module_site_url .'/admin/'; ?>" target="backend">
						<?php echo get_msg( 'nav_backend' ); ?>
					</a>

					<?php endif; ?>

					<a class="p-2 " href="<?php echo site_url('logout?url='. current_url()); ?>">
						<?php echo get_msg( 'nav_logout' ); ?>
					</a>

				<?php endif; ?>
			</nav>

			<?php if ( !$this->ps_auth->is_logged_in()): ?>
				
				<a class="btn btn-outline-primary" href="#" data-toggle='modal' data-target='#signupModal'>Sign up</a>
				
			<?php endif; ?>
		</div>

	</div>
</div>

<?php $this->load->view( $template_path .'/partials/login_modal'); ?>

<?php $this->load->view( $template_path .'/partials/signup_modal'); ?>

<?php $this->load->view( $template_path .'/partials/reset_modal'); ?>

<?php $this->load->view( $template_path .'/partials/inquiry_modal'); ?>

<?php $this->load->view( $template_path .'/partials/booking_modal'); ?>

<script type="text/javascript">
function stickNav()
{
	var stickyNavTop = $('.sticky-nav').offset().top;

	var stickyNav = function(){
		var scrollTop = $(window).scrollTop();

		if (scrollTop > stickyNavTop) { 
		  $('.sticky-nav').addClass('sticky');
		} else {
		  $('.sticky-nav').removeClass('sticky'); 
		}
	};

	stickyNav();

	$(window).scroll(function() {
		stickyNav();
	});
}
</script>