<?php 
	// load breadcrumb
	show_breadcrumb( $action_title );

	// show flash message
	flash_msg();
?>

<a class="btn btn-sm btn-info" href="<?php echo $module_site_url ."/city"; ?>">City Analytic</a>

<a class="btn btn-sm btn-info" href="<?php echo $module_site_url ."/hotel"; ?>">Hotel Analytic</a>

<a class="btn btn-sm btn-info" href="<?php echo $module_site_url ."/room"; ?>">Room Analytic</a>