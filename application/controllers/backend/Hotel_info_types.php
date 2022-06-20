<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Cities Controller
 */
class Hotel_info_types extends BE_Controller {
		
	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'HOTEL_INFO_TYPES' );
	}

	/**
	 * hinfo_typs list
	 */
	function index() {

		// no publish filter
		$conds['no_status_filter'] = 1;

		// get rows count
		$this->data['rows_count'] = $this->HotelInfoType->count_all_by( $conds );

		// get hinfo_typs
		$this->data['hinfo_typs'] = $this->HotelInfoType->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * search hinfo_typs
	 */
	function search() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'hinfo_typ_search' );
		
		// condition with search term
		$conds = array( 'searchterm' => $this->searchterm_handler( $this->input->post( 'searchterm' )) );
		
		// no publish filter
		$conds['no_status_filter'] = 1;

		// pagination
		$this->data['rows_count'] = $this->HotelInfoType->count_all_by( $conds );

		// search data
		$this->data['hinfo_typs'] = $this->HotelInfoType->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		
		// load add list
		parent::search();
	}

	/**
	 * Add new hinfo_typ
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'hinfo_typ_add' );

		// call the core add logic
		parent::add();
	}

	/**
	 * Update hinfo_typ info
	 *
	 * @param      <type>  $id     The identifier
	 */
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'hinfo_typ_edit' );

		// load user
		$this->data['hinfo_typ'] = $this->HotelInfoType->get_one( $id );

		// call the parent edit logic
		parent::edit( $id );
	}

	/**
	 * Save hinfo_typ info
	 *
	 * @param      boolean  $id     The identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		/** 
		 * Insert City Records 
		 */
		$data = array();

		// prepare hinfo_typ name
		if ( $this->has_data( 'hinfo_typ_name' )) {
			$data['hinfo_typ_name'] = $this->get_data( 'hinfo_typ_name' );
		}

		// prepare hotel information type id
		if ( $this->has_data( 'hinfo_grp_id' )) {
			$data['hinfo_grp_id'] = $this->get_data( 'hinfo_grp_id' );
		}

		// save City
		if ( ! $this->HotelInfoType->save( $data, $id )) {
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

		$this->form_validation->set_rules( 'hinfo_typ_name', get_msg( 'hinfo_typ_name' ), $rule);

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

		if ( strtolower( $this->HotelInfoType->get_one( $id )->hinfo_typ_name ) == strtolower( $name )) {
		// if the name is existing name for that user id,

			return true;
		} else if ( $this->HotelInfoType->exists( array( 'hinfo_typ_name' => $_REQUEST['hinfo_typ_name'] ))) {
		// if the name is existed in the system,

			$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
			return false;
		}

		return true;
	}

	/**
	 * Delete hinfo_typ
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete( $id ) {
		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete categories and images
		if ( !$this->ps_delete->delete_hotel_info_type( $id )) {

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
	 * Delete hinfo_typ and hinfo_typs
	 *
	 * @param      integer  $id     The identifier
	 */
	function delete_all( $id = 0 ) {

	}

	/**
	 * Check if name is already existed
	 *
	 * @param      boolean  $id     The identifier
	 */
	function ajx_exists( $id = false ) {

		// get hinfo_typ name
		$hinfo_typ_name = $_REQUEST['hinfo_typ_name'];

		if ( $this->is_valid_name( $hinfo_typ_name, $id )) {
		// if the hinfo_typ name is valid,
			
			echo "true";
		} else {
		// if invalid hinfo_typ name,
			
			echo "false";
		}
	}
}