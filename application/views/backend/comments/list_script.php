
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'delete_comment_label' ),
		'message' => get_msg( 'comment_delete_confirm_message' ),
		'no_only_btn' => get_msg( 'btn_yes' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>