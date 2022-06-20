
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="<?php echo base_url( 'assets/jquery/jquery.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/popper/popper.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/bootstrap4/js/bootstrap.min.js' ); ?>"></script>
        <script src="<?php echo base_url( 'assets/bootstrap-select/bootstrap-select.min.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/validator/jquery.validate.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/backend/js/dashboard.js' ); ?>"></script>
		<script src="<?php echo base_url( 'assets/menu/metismenu.2.7.1.min.js');?>"></script>
        <script src="<?php echo base_url( 'assets/menu/sb-admin-2.js');?>"></script>
        <script src="<?php echo base_url( 'assets/datetimepicker/bootstrap-datetimepicker.min.js');?>"></script>
         <!-- Select2 -->
        <link rel="stylesheet" href="<?php echo base_url('assets/select2/select2.min.css'); ?>">
        <script src="<?php echo base_url( 'assets/select2/select2.full.min.js' ); ?>"></script>
        <script>
            $(document).ready(function() {
                $('.select2').select2();                                    
            });
        </script>

		<?php show_analytic(); ?>

		<script type="text/javascript">

		$(document).ready(function(){
			
			// functions to run after jquery is loaded
			if ( typeof runAfterJQ == "function" ) runAfterJQ();

			// run location picker
			if ( typeof locationPicker == "function" ) locationPicker();

			// run the photo uploader
			if ( typeof photoUploader == "function" ) photoUploader();

			// run delete confirm message modal
			if ( typeof deleteModal == "function" ) deleteModal();

			// promotion datetime picker
			if ( typeof promoDtp == "function" ) promoDtp();

			<?php if ( $this->config->item( 'client_side_validation' ) == true ): ?>
				
				// functions to run after jquery is loaded
				if ( typeof jqvalidate == "function" ) jqvalidate();

			<?php endif; ?>
		});

		</script>

		<?php if ( isset( $load_gallery_js )) : ?>

			<?php $this->load->view( $template_path .'/components/gallery_script' ); ?>	

		<?php endif; ?>

  </body>
</html>