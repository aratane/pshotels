
<?php $this->load->view( $template_path .'/components/home/search_form.php' ); ?>

<div class="container">

	<div class="row justify-content-center">
		
		<div class="col-12">

			<?php $this->ps_widget->popular_cities(); ?>

			<?php $this->ps_widget->popular_hotels(); ?>

			<?php $this->ps_widget->recommended_hotels(); ?>

			<?php $this->ps_widget->popular_rooms(); ?>
		
		</div>
	</div>

</div><!-- end of container -->