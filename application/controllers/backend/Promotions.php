<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Promotions Controller
 */
class Promotions extends BE_Controller {
		
	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'PROMOTIONS' );
	}

	/**
	 * promotions list
	 */
	function index() {

		// no publish filter
		$conds['no_status_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->Promotion->count_all_by( $conds );

		// get promotions
		$this->data['promotions'] = $this->Promotion->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * search promotions
	 */
	function search() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'promo_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_status_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->Promotion->count_all_by( $conds );

		// search data
		$this->data['promotions'] = $this->Promotion->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 * Add new promotion
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'promo_add' );

		// call the core add logic
		parent::add();
	}

	/**
	 * Update promotion info
	 *
	 * @param      <type>  $id     The identifier
	 */
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'promo_edit' );

		// load user
		$promotion = $this->Promotion->get_one( $id );

		// get hotel extra information
		$promo_rooms = $this->RoomPromotion->get_all_by( array( 'promo_id' => $id ))->result();
		$promo_room_ids = array();
		if ( !empty( $promo_rooms )) {
			foreach ( $promo_rooms as $promo_room ) {
				$promo_room_ids[] = $promo_room->room_id;
			}
		}
		$promotion->promo_room_ids = $promo_room_ids;

		// assign promotion
		$this->data['promotion'] = $promotion;

		// call the parent edit logic
		parent::edit( $id );
	}

	/**
	 * Save promotion info
	 *
	 * @param      boolean  $id     The identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		/** 
		 * Insert Promotion Records 
		 */
		$data = array();

		// prepare promo_name
		if ( $this->has_data( 'promo_name' )) {
			$data['promo_name'] = $this->get_data( 'promo_name' );
		}

		// prepare promo_desc
		if ( $this->has_data( 'promo_desc' )) {
			$data['promo_desc'] = $this->get_data( 'promo_desc' );
		}

		// prepare promo_percent
		if ( $this->has_data( 'promo_percent' )) {
			$data['promo_percent'] = $this->get_data( 'promo_percent' );
		}

		// prepare promo_start_time
		if ( $this->has_data( 'promo_start_time' )) {
			$data['promo_start_time'] = $this->get_data( 'promo_start_time' );
		}

		// prepare promo_end_time
		if ( $this->has_data( 'promo_end_time' )) {
			$data['promo_end_time'] = $this->get_data( 'promo_end_time' );
		}

		// save Promotion
		if ( ! $this->Promotion->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );			
			return false;
		}

		// get inserted id
		if ( !$id ) $id = $data['promo_id'];

		// Promoted Rooms Information
		$rooms = array();
		if ( $this->has_data( 'rooms' )) {
			$rooms = $this->get_data( 'rooms' );
		}

		// clear existing data first
		if ( !$this->RoomPromotion->delete_by( array( 'promo_id' => $id ))) {

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );			
			return false;
		}

		if ( !empty( $rooms )) {
		// if hotel extra information is not empty,			
			foreach ( $rooms as $room_id ) {

				$room_promo_data = array(
					'promo_id' => $id,
					'room_id' => $room_id
				);

				if ( !$this->RoomPromotion->save( $room_promo_data )) {
					// rollback the transaction
					$this->db->trans_rollback();

					// set error message
					$this->data['error'] = get_msg( 'err_model' );			
					return false;
				}
			}
		}

		/** 
		 * Check Transactions 
		 */
		if ( ! $this->check_trans()) {
        	
			// set flash error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
		} else {

			if ( $id ) {
			// if user id is not false, show success_add message
				
				$this->set_flash_msg( 'success', get_msg( 'success_edit' ));
			} else {
			// if user id is false, show success_edit message

				$this->set_flash_msg( 'success', get_msg( 'success_add' ));
			}
		}

		redirect( $this->module_site_url());
	}

	/**
	 * Determines if valid input.
	 *
	 * @param      integer  $id     The identifier
	 */
	function is_valid_input( $id = 0 ) {

		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'promo_name', get_msg( 'promo_name' ), $rule);

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

			return false;
		}

		return true;
	}

	/**
	 * Determines if valid name.
	 *
	 * @param      <type>   $name   The name
	 * @param      integer  $id     The identifier
	 */
	function is_valid_name( $name, $id = 0 ) {

		if ( strtolower( $this->Promotion->get_one( $id )->promo_name ) == strtolower( $name )) {
		// if the name is existing name for that user id,

			return true;
		} else if ( $this->Promotion->exists( array( 'promo_name' => $_REQUEST['promo_name'] ))) {
		// if the name is existed in the system,

			$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
			return false;
		}

		return true;
	}

	/**
	 * Delete promotion
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete( $id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete categories and images
		if ( !$this->ps_delete->delete_promotion( $id )) {

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

	/**
	 * Delete promotion and cities
	 *
	 * @param      integer  $id     The identifier
	 */
	function delete_all( $id = 0 ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete categories and images
		$enable_trigger = true; 

		/** Note: enable trigger will delete news under category and all news related data */
		if ( !$this->ps_delete->delete_promotion( $id, $enable_trigger )) {
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

	/**
	 * Check if name is already existed
	 *
	 * @param      boolean  $id     The identifier
	 */
	function ajx_exists( $id = false ) {

		// get promotion name
		$promo_name = $_REQUEST['promo_name'];

		if ( $this->is_valid_name( $promo_name, $id )) {
		// if the promotion name is valid,
			
			echo "true";
		} else {
		// if invalid promotion name,
			
			echo "false";
		}
	}
}