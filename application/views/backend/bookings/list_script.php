
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'booking_delete_label' ),
		'message' => get_msg( 'booking_delete_confirm_message' ),
		'no_only_btn' => get_msg( 'booking_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>