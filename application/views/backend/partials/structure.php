<?php $this->load->view( $template_path .'/partials/nav' ); ?>

<div class="container">
	<div class="row">
		<div class="col-12 col-md-3 sidebar teamps-sidebar-open">
			
			<?php $this->load->view( $template_path .'/partials/sidebar' ); ?>
		</div>
		
		<div class="col-12 col-md-9 main teamps-sidebar-push">

			<?php show_ads(); ?>
			
			<?php $this->load->view( $template_path .'/'. $view, $data ); ?>

		</div>
	</div>
</div>