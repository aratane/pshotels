<?php if ( isset( $aboutus ) && !isset( $aboutus->is_empty_object )): ?>

<h4 class="footer-title"><?php echo $aboutus->about_title; ?></h4>

<p class="lead"><?php echo $aboutus->about_description; ?></p>

<p>
	
	<i class="mr-2 fa fa-envelope" aria-hidden="true"></i>
	
	<a href="mailto:<?php echo $aboutus->about_email; ?>">
		<?php echo $aboutus->about_email; ?>
	</a>
	
</p>

<p>
	
	<i class="mr-2 fa fa-phone" aria-hidden="true"></i>
	
	<a href="tel:<?php echo $aboutus->about_phone; ?>">
		<?php echo $aboutus->about_phone; ?>
	</a>

</p>

<p>
	
	<i class="mr-2 fa fa-link" aria-hidden="true"></i>
	
	<a href="<?php echo $aboutus->about_website; ?>">
		<?php echo $aboutus->about_website; ?>
	</a>
	
</p>

<?php endif; ?>
