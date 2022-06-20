<!DOCTYPE html>
<html lang="en">
	<head>
		<title>
			<?php echo $title; ?>
			<?php 
				if ( isset( $action_title )) {
					echo " | ";
					if ( is_string( $action_title )) echo $action_title;
					else if ( is_array( $action_title )) echo $action_title[count($action_title) - 1]['label'];
				} 
			?>
		</title>

		<link rel="icon" href="<?php echo base_url('assets/img/favicon.ico'); ?>">
		
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<meta property="og:site_name" content="<?php echo get_msg('site_name'); ?>"/>

		<!-- custom meta tags -->
		<?php if ( isset( $meta_type )): ?>
			<meta property="og:type" content="<?php echo $meta_type; ?>"/>
		<?php endif; ?>

		<?php if ( isset( $meta_title )): ?>
			<meta property="og:title" content="<?php echo $meta_title; ?>"/>
		<?php endif; ?>

		<?php if ( isset( $meta_desc )): ?>
			<meta property="og:description" content="<?php echo $meta_desc; ?>"/>
		<?php endif; ?>

		<?php if ( isset( $meta_keywords )): ?>
			<meta name="keywords" content="<?php echo $meta_keywords; ?>">
		<?php endif; ?>

		<!-- Bootstrap core CSS -->
		<link href="<?php echo base_url('assets/bootstrap4/css/bootstrap.min.css'); ?>" rel="stylesheet">

		<!-- Custom styles for this template -->
	 	<link href="<?php echo base_url('assets/fonts/ptsan/stylesheet.css');?>" rel="stylesheet">
	 	
		<link href="<?php echo base_url('assets/backend/css/style.css');?>" rel="stylesheet">

		<!-- Menu CSS -->
   		<link href="<?php echo base_url('assets/menu/metismenu.2.7.1.min.css');?>" rel="stylesheet">
		
		<!-- Animation core CSS -->
		<link href="<?php echo base_url('assets/animation/animate.css');?>" rel="stylesheet">
		<link href="<?php echo base_url('assets/datetimepicker/bootstrap-datetimepicker.min.css');?>" rel="stylesheet">

		<link href="<?php echo base_url('assets/font-awesome/css/font-awesome.min.css');?>" rel="stylesheet">

		<link href="<?php echo base_url( 'assets/bootstrap-select/bootstrap-select.min.css' ); ?>" rel="stylesheet">

		<link href="<?php echo base_url( 'assets/datetimepicker/bootstrap-datetimepicker.min.css' ); ?>" rel="stylesheet">

	</head>

	<body id="<?php echo strtolower( $module_name ); ?>">