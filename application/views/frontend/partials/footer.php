		<!-- footer -->
		<footer class="">
			<div class="main-footer pt-4 pb-5">
				<div class="container">
					<div class="row">
						<div class="col-12 col-md-8">
							
							<?php //$this->load->view( $template_path .'/components/aboutus_sm' ); ?>

							<?php echo $this->ps_widget->aboutus_sm(); ?>

						</div>

						<div class="col-12 col-md-4">

							<?php echo $this->ps_widget->contactus_sm(); ?>

						</div>

					</div>
				</div>
			</div><!-- end of upper footer -->

			<div class="lower-footer py-1">

				<div class="container">

					<div class="row">

						<div class="col-12 text-center">
							<?php echo get_msg( 'footer_message' ); ?>
						</div>

					</div>

				</div>

			</div><!-- end of lower footer -->
		</footer>

		<!-- Optional JavaScript -->
		<!-- jQuery first, then Popper.js, then Bootstrap JS -->
		<script src="<?php echo base_url( 'assets/jquery/jquery-3.3.1.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/popper/popper.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/bootstrap4/js/bootstrap.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/bootstrap-select/bootstrap-select.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/chosen/chosen.jquery.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/jquery-ui/jquery-ui.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/scrollreveal/scrollreveal.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/raty/jquery.raty.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/circle-progress/circle-progress.min.js' ); ?>"></script>	
        <script src="<?php echo base_url( 'assets/datepicker/bootstrap-datepicker.min.js');?>"></script>
		<script src="<?php echo base_url( 'assets/frontend/js/ps-bundle.js' ); ?>"></script>

		<script type="text/javascript">
	
			var baseUrl = "<?php echo base_url(); ?>";
			var siteUrl = "<?php echo site_url(); ?>";
			var moduleUrl = "<?php echo $module_site_url; ?>";
			var ajaxUrl = "<?php echo site_url( 'guestajax' ); ?>";
			var userUrl = "<?php echo site_url( 'userajax' ); ?>";
			var uploadPath = "<?php echo img_url(); ?>";

			// bookings
	if ( typeof bookings == "function" ) bookings();
		</script>
	</body>
</html>