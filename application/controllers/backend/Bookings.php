<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Bookings Controller
 */
class Bookings extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'BOOKINGS' );

		// load the mail library
		$this->load->library( 'PS_Mail' );
	}

	/**
	 * List down the bookings
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
			$this->data['rows_count'] = $this->Booking->count_all();

			// get bookings
			$this->data['bookings'] = $this->Booking->get_all( $this->pag['per_page'], $this->uri->segment( 4 ) );
		} else if($logged_in_user->is_hotel_admin == 1) {
			$this->data['bookings'] = $this->Booking->get_all_in_hotel_admin( $user_hotels_ids );
		}

		// load index logic
		parent::index();
	}

	/**
	 * search bookings
	 */
	function search() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'booking_search' );
		
		// condition with search term
		$conds = $this->searchterm_handler( array(
			'searchterm' => $this->input->post( 'searchterm' ),
			'hotel_id' => $this->input->post( 'hotel_id' ),
			'booking_status' => $this->input->post( 'booking_status' )
		));

		// no publish filter
		$conds['no_status_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->Booking->count_all_by( $conds );

		// search data
		$this->data['bookings'] = $this->Booking->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	* View Booking Detail
	*/
	function detail( $id ) {

		if ( $this->is_POST()) {
		// if the method is post

			// save user info
			$this->save( $id );
		}

		$booking = $this->Booking->get_one( $id );

		$this->data['booking'] = $booking;

		$this->load_detail( $this->data );
	}

	/**
	 * Saving Logic
	 * 1) save about data
	 * 2) check transaction status
	 *
	 * @param      boolean  $id  The about identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		// prepare data for save
		$data = array();

		if ( $this->has_data( 'confirm' )) {
			$data = array( 'booking_status' => 'CONFIRMED' );
		}

		if ( $this->has_data( 'cancel' )) {
			$data = array( 'booking_status' => 'CANCELLED' );
		}

		// save booking
		if ( ! $this->Booking->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );
			
			return;
		}

		if ( !send_booking_status_email( $id )) {
		// if error in sending email,

			// set error message
			$this->data['error'] = get_msg( 'err_email_not_send' );

			return;
		}

		// commit the transaction
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			$this->set_flash_msg( 'success', get_msg( 'success_booking_update' ));
		}

		redirect( $this->module_site_url( '/detail/'. $id ) );
	}

	/**
	 * Delete Bookings
	 *
	 * @param      integer  $id     The identifier
	 */
	function delete( $id = 0 ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		if ( !$this->ps_delete->delete_booking( $id )) {
		// if error in deleting category,

			// set error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));

			// rollback
			$this->trans_rollback();

			// redirect to list view
			redirect( $this->module_site_url());
		}
			
		/**
		 * Check Transcation Status
		 */
		if ( !$this->check_trans()) {

			$this->set_flash_msg( 'error', get_msg( 'err_model' ));	
		} else {
        	
			$this->set_flash_msg( 'success', get_msg( 'success_delete' ));
		}
		
		redirect( $this->module_site_url());
	}
}