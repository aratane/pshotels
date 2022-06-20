
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'promo_delete_label' ),
		'message' => get_msg( 'promo_delete_confirm_message' ) .'<br/>'. 
			get_msg( 'promo_no_only_message' ),
		'no_only_btn' => get_msg( 'promo_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>