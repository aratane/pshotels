
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'room_delete_label' ),
		'message' => get_msg( 'room_delete_confirm_message' ) .'<br>'. 
			get_msg( 'room_yes_all_message' ),
		'yes_all_btn' => get_msg( 'room_yes_all_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>