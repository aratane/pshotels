<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			<?php echo get_msg( 'site_name' ); ?>
			<?php if ( isset( $action_title )) echo get_msg( 'title_bar_seperator' ). $action_title; ?>
		</title>

		<link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">

		<?php $this->load->view( $template_path .'/partials/meta.php' ); ?>

		<?php $this->load->view( $template_path .'/partials/style.php' ); ?>

	</head>

	<body id="<?php echo strtolower( $module_name ); ?>">

		<header class="border-bottom box-shadow">

			<?php $this->load->view( $template_path .'/partials/nav.php' ); ?>

		</header>