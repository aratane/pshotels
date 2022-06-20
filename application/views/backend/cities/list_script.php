
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'city_delete_label' ),
		'message' => get_msg( 'city_delete_confirm_message' ) .'<br>'. get_msg( 'city_no_only_message' ),
		'no_only_btn' => get_msg( 'city_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>