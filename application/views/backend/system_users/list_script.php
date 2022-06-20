<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'delete_user_label' ),
		'message' =>  get_msg( 'user_yes_all_message' ),
		'no_only_btn' => get_msg( 'usesr_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>