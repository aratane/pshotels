		
<div class="heading py-3 d-none d-md-block">
	<div class="container text-left">

		<div class="row align-items-center">
		
			<div class="col-auto mr-auto">

				<h1 class="display-5">
					<a href="<?php echo site_url(); ?>">
						<?php echo get_msg('site_name'); ?>
					</a>
				</h1>
				
				<p class="lead">
					<?php echo get_msg('slogan'); ?>
				</p>

			</div>

			<?php if ( !isset( $hide_search_sm )): ?>

			<div class="col-auto d-none d-lg-block">
				<?php $this->load->view( $template_path .'/partials/search_box_sm.php' ); ?>
			</div>

			<?php endif; ?>

		</div>
		
	</div>
</div> <!-- end of heading -->
		