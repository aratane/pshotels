<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Inquires Controller
 */
class Inquires extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'INQUIRES' );
	}

	/**
	 * List down the inquires
	 */
	function index() {

		$logged_in_user = $this->ps_auth->get_user_info();

		$conds_user_hotel['user_id'] = $logged_in_user->user_id;
		$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();
		
		$user_hotels_ids = array();
		for($i=0; $i<count($user_hotel); $i++) {
		 	$user_hotels_ids[]= $user_hotel[$i]->hotel_id;
		}

		if($logged_in_user->user_is_sys_admin == 1) {

			// get rows count
			$this->data['rows_count'] = $this->Inquiry->count_all();

			// get inquires
			$this->data['inquires'] = $this->Inquiry->get_all( $this->pag['per_page'], $this->uri->segment( 4 ) );
		} else if($logged_in_user->is_hotel_admin == 1) {
			$this->data['inquires'] = $this->Inquiry->get_all_in_hotel_admin( $user_hotels_ids );
		}

		// load index logic
		parent::index();
	}

	/**
	 * Delete the record
	 * 1) delete inquiry
	 * 2) check transactions
	 */
	function delete( $id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		/**
		 * Delete inquiry
		 */
		if ( ! $this->Inquiry->delete( $id )) {
		// if there is an error in deleting news,
		
			// rollback
			$this->trans_rollback();

			// error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
			redirect( $this->module_site_url());
		}
			
		/**
		 * Check Transcation Status
		 */
		if ( !$this->check_trans()) {

			$this->set_flash_msg( 'error', get_msg( 'err_model' ));	
		} else {
        	
			$this->set_flash_msg( 'success', get_msg( 'success_news_delete' ));
		}
		
		redirect( $this->module_site_url());
	}


	/**
	* View Inquiry Detail
	*/
	function detail( $id )
	{

		$inquiry = $this->Inquiry->get_one( $id );
		$this->data['inquiry'] = $inquiry;

		$this->load_detail( $this->data );
	}

}