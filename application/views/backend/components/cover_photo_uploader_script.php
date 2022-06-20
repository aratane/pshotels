<script type="text/javascript">
function photoUploader()
{
	<?php if ( !empty( $img_parent_id )): ?>
	
	$('.delete-img').click(function(e){
		e.preventDefault();

		// get id and image
		var id = $(this).attr('id');

		// do action
		var action = '<?php echo $module_site_url .'/delete_cover_photo/'; ?>' + id + '/<?php echo $img_parent_id; ?>';
		console.log( action );
		$('.btn-delete-image').attr('href', action);
	});

	<?php endif; ?>
}
</script>

<?php 
	// replace cover photo modal
	$data = array(
		'title' => get_msg('upload_photo'),
		'img_type' => $img_type,
		'img_parent_id' => $img_parent_id
	);

	$this->load->view( $template_path .'/components/photo_upload_modal', $data );

	// delete cover photo modal
	$this->load->view( $template_path .'/components/delete_cover_photo_modal' ); 
?>