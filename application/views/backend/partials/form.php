<?php $this->load->view( $template_path .'/partials/nav' ); ?>

<div class="container">
	<div class="row">
		<div class="col-12 col-md-3 sidebar teamps-sidebar-open">
			
			<?php $this->load->view( $template_path .'/partials/sidebar' ); ?>
		</div>
		

		<div class="col-12 col-md-9 main teamps-sidebar-push">

			<?php show_ads(); ?>
			
			<?php 
				// load breadcrumb
				show_breadcrumb( $action_title );

				// show flash message
				flash_msg();
			?>

			<div class="wrapper wrapper-content animated fadeInRight">
				
			<?php $this->load->view( $template_path .'/'. $module_path .'/entry_form' ); ?>

			</div>

		</div>
	</div>
</div>

<?php 
	$form_script_path = $template_path .'/'. $module_path .'/entry_form_script';

	if ( is_view_exists( $form_script_path )) $this->load->view( $form_script_path );
?>