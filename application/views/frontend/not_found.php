<div class="container">
	<div class="row">
		
		<div class="col-5 reveal">
					
			<img class="img-fluid" src="<?php echo base_url('/assets/img/core/404icon.png'); ?>"/>

		</div>

		<div class="col-7 error-links text-center reveal">

			<h3 class="mt-5 pt-5">
				<?php echo $this->lang->line('f_err_no_page_title'); ?>
			</h3>

			<h3 class="mt-4 pt-4">
				<?php echo $this->lang->line('f_err_no_page_text'); ?>
			</h3>

			<p class="lead py-5">						

				<a class="d-block mb-5" href="<?php echo site_url(); ?>"><?php echo $this->lang->line('f_nav_home'); ?></a>

				<a class="d-block mb-5" href="<?php echo site_url('AboutUs'); ?>"><?php echo $this->lang->line('f_nav_about'); ?></a>

				<a class="d-block mb-5" href="<?php echo site_url('ContactUs'); ?>"><?php echo $this->lang->line('f_nav_contact'); ?></a>

				<a class="d-block mb-5" href="<?php echo site_url('CreateCity'); ?>"><?php echo $this->lang->line('f_nav_create_city'); ?></a>
			</p>

		</div>
		
	</div>
</div>