
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'rinfo_typ_delete_label' ),
		'message' => get_msg( 'rinfo_typ_delete_confirm_message' ) .'<br>'. get_msg( 'rinfo_typ_no_only_message' ),
		'no_only_btn' => get_msg( 'rinfo_typ_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>