
<!-- hotel gallery modal -->
<div class="modal fade" id="hotelGalleryModal" tabindex="-1" role="dialog">
	
	<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
		
		<div class="modal-content">

			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>

			<div class="modal-body p-3">

				<?php $images = $this->Image->get_all_by( array( 'img_parent_id' => $hotel_id, 'img_type' => 'hotel' ))->result(); ?>
				
				<?php 
					$this->load->view( $template_path .'/components/image_gallery_slider.php', array( 
						'images' => $images,
						'slider_id' => 'hotelGallery'
					));
				?>

			</div>
		
		</div>
	
	</div>

</div>