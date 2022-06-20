<?php $this->load->view( $template_path .'/partials/nav' ); ?>

<div class="container">
	<div class="row">
		<div class="col-12 col-md-3 sidebar teamps-sidebar-open">
			
			<?php $this->load->view( $template_path .'/partials/sidebar' ); ?>
		</div>
		
		<div class="col-12 col-md-9 main teamps-sidebar-push">

			<?php show_ads(); ?>
		
			<?php show_breadcrumb(); ?>

			<?php flash_msg(); ?>

			<?php 
				$detail = $template_path .'/'. $module_path .'/detail';
				
				if ( is_view_exists( $detail )) $this->load->view( $detail ); 
			?>

		</div>
	</div>
</div>

<?php 
	$detail_script_path = $template_path .'/'. $module_path .'/detail_script';
	
	if ( is_view_exists( $detail_script_path )) $this->load->view( $detail_script_path ); 
?>