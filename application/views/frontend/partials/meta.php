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