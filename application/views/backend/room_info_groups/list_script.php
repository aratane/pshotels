
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'rinfo_grp_delete_label' ),
		'message' => get_msg( 'rinfo_grp_delete_confirm_message' ) .'<br>'. 
			get_msg( 'rinfo_grp_yes_all_message' ) .'<br/>'. 
			get_msg( 'rinfo_grp_no_only_message' ),
		'yes_all_btn' => get_msg( 'rinfo_grp_yes_all_label' ),
		'no_only_btn' => get_msg( 'rinfo_grp_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>