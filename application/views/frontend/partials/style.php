
<!-- Bootstrap CSS -->
<link rel="stylesheet" href="<?php echo base_url( 'assets/bootstrap4/css/bootstrap.min.css' ); ?>">

<link rel="stylesheet" href="<?php echo base_url( 'assets/bootstrap-select/bootstrap-select.min.css' ); ?>">

<link rel="stylesheet" href="<?php echo base_url( 'assets/chosen/chosen.min.css' ); ?>">

<link rel="stylesheet" href="<?php echo base_url( 'assets/jquery-ui/jquery-ui.css' ); ?>">

<link rel="stylesheet" href="<?php echo base_url( 'assets/raty/jquery.raty.css' ); ?>">

<link rel="stylesheet" href="<?php echo base_url( 'assets/font-awesome/css/font-awesome.min.css' ); ?>">

<link rel="stylesheet" href="<?php echo base_url( 'assets/datepicker/bootstrap-datepicker.min.css' ); ?>">

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">

<?php $about = $this->About->get_one_by( array()); ?>

<?php if ( isset( $about->theme_style ) && !empty( $about->theme_style )): ?>
	
<link href="<?php echo base_url('assets/frontend/css/'. $about->theme_style .'.php');?>" rel="stylesheet">

<?php else: ?>
	
<link href="<?php echo base_url('assets/frontend/css/default.php');?>" rel="stylesheet">
	
<?php endif; ?>
