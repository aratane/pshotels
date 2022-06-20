<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Review_categories Controller
 */
class Review_categories extends BE_Controller {
		
	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'REVIEW_CATEGORIES' );
	}

	/**
	 * rvcats list
	 */
	function index() {

		// no publish filter
		$conds['no_status_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->ReviewCategory->count_all_by( $conds );

		// get rvcats
		$this->data['rvcats'] = $this->ReviewCategory->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * search rvcats
	 */
	function search() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'rvcat_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		// no publish filter
		$conds['no_status_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->ReviewCategory->count_all_by( $conds );

		// search data
		$this->data['rvcats'] = $this->ReviewCategory->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 * Update rvcat info
	 *
	 * @param      <type>  $id     The identifier
	 */
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'rvcat_edit' );

		// load user
		$this->data['rvcat'] = $this->ReviewCategory->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );
	}

	/**
	 * Save rvcat info
	 *
	 * @param      boolean  $id     The identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		/** 
		 * Insert ReviewCategory Records 
		 */
		$data = array();

		// prepare rvcat name
		if ( $this->has_data( 'rvcat_name' )) {
			$data['rvcat_name'] = $this->get_data( 'rvcat_name' );
		}

		// save ReviewCategory
		if ( ! $this->ReviewCategory->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );			
			return false;
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

		$this->form_validation->set_rules( 'rvcat_name', get_msg( 'rvcat_name' ), $rule);

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

		if ( strtolower( $this->ReviewCategory->get_one( $id )->rvcat_name ) == strtolower( $name )) {
		// if the name is existing name for that user id,

			return true;
		} else if ( $this->ReviewCategory->exists( array( 'rvcat_name' => $_REQUEST['rvcat_name'] ))) {
		// if the name is existed in the system,

			$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
			return false;
		}

		return true;
	}

	/**
	 * Check if name is already existed
	 *
	 * @param      boolean  $id     The identifier
	 */
	function ajx_exists( $id = false ) {

		// get rvcat name
		$rvcat_name = $_REQUEST['rvcat_name'];

		if ( $this->is_valid_name( $rvcat_name, $id )) {
		// if the rvcat name is valid,
			
			echo "true";
		} else {
		// if invalid rvcat name,
			
			echo "false";
		}
	}
}