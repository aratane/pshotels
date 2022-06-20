<div class="room-gallery-wrapper mb-3">

	<h4 class="mb-4">Room's Gallery</h4>

	<?php $images = $this->Image->get_all_by( array( 'img_parent_id' => $room->room_id, 'img_type' => 'room' ))->result(); ?>

	<?php 
		$this->load->view( $template_path .'/components/image_gallery_slider.php', array( 
			'images' => $images,
			'slider_id' => 'roomGallery'
		));
	?>

</div>