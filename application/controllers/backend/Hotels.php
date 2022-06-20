<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Hotels Controller
 */
class Hotels extends BE_Controller {
		
	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'HOTELS' );
	}

	/**
	 * hotels list
	 */
	function index() {

		$logged_in_user = $this->ps_auth->get_user_info();

		// no publish filter
		$conds['no_status_filter'] = 1;

		$conds_user_hotel['user_id'] = $logged_in_user->user_id;
		$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();
		
		$user_hotels_ids = array();
		for($i=0; $i<count($user_hotel); $i++) {
		 	$user_hotels_ids[]= $user_hotel[$i]->hotel_id;
		}

		if($logged_in_user->user_is_sys_admin == 1) {

			// get rows count
			$this->data['rows_count'] = $this->Hotel->count_all_by( $conds );

			// get hotels
			$this->data['hotels'] = $this->Hotel->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );
		} else if($logged_in_user->is_hotel_admin == 1) {
			$this->data['hotels'] = $this->Hotel->get_all_in_hotel_admin( $user_hotels_ids );
		}

		// load index logic
		parent::index();
	}

	/**
	 * search hotels
	 */
	function search() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'hotel_search' );

		$logged_in_user = $this->ps_auth->get_user_info();

		if($logged_in_user->user_is_sys_admin == 1) {

			// condition with search term
			$conds = $this->searchterm_handler( array( 
				'searchterm' => $this->input->post( 'searchterm' ),
				'city_id' => $this->input->post( 'city_id' ),
				'hotel_star_rating' => $this->input->post( 'hotel_star_rating' )
			));

			// no publish filter
			$conds['no_status_filter'] = 1;

			// pagination
			$this->data['rows_count'] = $this->Hotel->count_all_by( $conds );

			// search data
			$this->data['hotels'] = $this->Hotel->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		} else if($logged_in_user->is_hotel_admin == 1) {
			// condition with search term
			$conds = $this->searchterm_handler( array( 
				'searchterm' => $this->input->post( 'searchterm' ),
				'city_id' => $this->input->post( 'city_id' ),
				'hotel_star_rating' => $this->input->post( 'hotel_star_rating' ),
			));

			$conds_user_hotel['user_id'] = $logged_in_user->user_id;
			$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();

			$user_hotels_ids = array();
			for($i=0; $i<count($user_hotel); $i++) {
			 	$user_hotels_ids[]= $user_hotel[$i]->hotel_id;
			}
			$conds['hotel_id'] = $user_hotels_ids;
			// search data
			$this->data['hotels'] = $this->Hotel->get_all_by_hotel( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );

		}
		
		// load add list
		parent::search();
	}

	/**
	 * Add new hotel
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'hotel_add' );

		// call the core add logic
		parent::add();
	}

	/**
	 * Update hotel info
	 *
	 * @param      <type>  $id     The identifier
	 */
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'hotel_edit' );

		// load user
		$hotel = $this->Hotel->get_one( $id );

		// get hotel extra information
		$hinfos = $this->HotelInfo->get_all_by( array( 'hotel_id' => $id ))->result();
		$hinfo_typ_ids = array();
		if ( !empty( $hinfos )) {
			foreach ( $hinfos as $hinfo ) {
				$hinfo_typ_ids[] = $hinfo->hinfo_typ_id;
			}
		}
		$hotel->hinfo_typ_ids = $hinfo_typ_ids;

		$this->data['hotel'] = $hotel;

		// call the parent edit logic
		parent::edit( $id );
	}

	/**
	 * Save hotel info
	 *
	 * @param      boolean  $id     The identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		/** 
		 * Insert Hotel Records 
		 */
		$data = array();

		// prepare hotel_name
		if ( $this->has_data( 'hotel_name' )) {
			$data['hotel_name'] = $this->get_data( 'hotel_name' );
		}
		
		// prepare city_id
		if ( $this->has_data( 'city_id' )) {
			$data['city_id'] = $this->get_data( 'city_id' );
		}
		
		// prepare hotel_desc
		if ( $this->has_data( 'hotel_desc' )) {
			$data['hotel_desc'] = $this->get_data( 'hotel_desc' );
		}
		
		// prepare hotel_address
		if ( $this->has_data( 'hotel_address' )) {
			$data['hotel_address'] = $this->get_data( 'hotel_address' );
		}
		
		// prepare hotel_email
		if ( $this->has_data( 'hotel_email' )) {
			$data['hotel_email'] = $this->get_data( 'hotel_email' );
		}
		
		// prepare hotel_phone
		if ( $this->has_data( 'hotel_phone' )) {
			$data['hotel_phone'] = $this->get_data( 'hotel_phone' );
		}
		
		// prepare hotel_star_rating
		if ( $this->has_data( 'hotel_star_rating' )) {
			$data['hotel_star_rating'] = $this->get_data( 'hotel_star_rating' );
		}
		
		// prepare hotel_min_price
		if ( $this->has_data( 'hotel_min_price' )) {
			$data['hotel_min_price'] = $this->get_data( 'hotel_min_price' );
		}
		
		// prepare hotel_max_price
		if ( $this->has_data( 'hotel_max_price' )) {
			$data['hotel_max_price'] = $this->get_data( 'hotel_max_price' );
		}
		
		// prepare hotel_check_in
		if ( $this->has_data( 'hotel_check_in' )) {
			$data['hotel_check_in'] = $this->get_data( 'hotel_check_in' );
		}

		// prepare hotel_check_out
		if ( $this->has_data( 'hotel_check_out' )) {
			$data['hotel_check_out'] = $this->get_data( 'hotel_check_out' );
		}
		
		// prepare hotel_lat
		if ( $this->has_data( 'hotel_lat' )) {
			$data['hotel_lat'] = $this->get_data( 'hotel_lat' );
		}
		
		// prepare hotel_lng
		if ( $this->has_data( 'hotel_lng' )) {
			$data['hotel_lng'] = $this->get_data( 'hotel_lng' );
		}

		// if 'is recommended' is checked,
		if ( $this->has_data( 'is_recommended' )) {
			$data['is_recommended'] = 1;
		} else {
			$data['is_recommended'] = 0;
		}

		// save Hotel
		if ( ! $this->Hotel->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );			
			return false;
		}

		// get inserted id
		if ( !$id ) $id = $data['hotel_id'];

		// Hotel Extra Information
		$hinfo_typs = array();
		if ( $this->has_data( 'hinfo_typs' )) {
			$hinfo_typs = $this->get_data( 'hinfo_typs' );
		}

		// clear existing data first
		if ( !$this->HotelInfo->delete_by( array( 'hotel_id' => $id ))) {

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );			
			return false;
		}

		if ( !empty( $hinfo_typs )) {
		// if hotel extra information is not empty,			
			foreach ( $hinfo_typs as $hinfo_typ_id ) {

				$hinfo_typ_data = array(
					'hotel_id' => $id,
					'hinfo_typ_id' => $hinfo_typ_id
				);

				if ( !$this->HotelInfo->save( $hinfo_typ_data )) {
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

		if ( $this->has_data( 'gallery' )) {
		// if there is gallery, redirecti to gallery
			
			redirect( $this->module_site_url( 'gallery/'. $id));
		} else {
		// redirect to list view

			redirect( $this->module_site_url() );
		}
	}

	/**
	 * Show Gallery
	 *
	 * @param      <type>  $id     The identifier
	 */
	function gallery( $id ) {
		
		// breadcrumb urls
		$this->data['action_title'] = array( 
			array( 'url' => 'edit/'. $id, 'label' => get_msg( 'hotel_edit' )), 
			array( 'label' => get_msg( 'hotel_gallery' ))
		);
		
		$_SESSION['parent_id'] = $id;
		$_SESSION['type'] = 'hotel';
    	    	
    	$this->load_gallery();
    }

	/**
	 * Determines if valid input.
	 *
	 * @param      integer  $id     The identifier
	 */
	function is_valid_input( $id = 0 ) {

		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'hotel_name', get_msg( 'hotel_name' ), $rule);

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

		if ( strtolower( $this->Hotel->get_one( $id )->hotel_name ) == strtolower( $name )) {
		// if the name is existing name for that user id,

			return true;
		} else if ( $this->Hotel->exists( array( 'hotel_name' => $_REQUEST['hotel_name'] ))) {
		// if the name is existed in the system,

			$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
			return false;
		}

		return true;
	}

	/**
	 * Delete hotel
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete( $id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		// delete categories and images
		if ( !$this->ps_delete->delete_hotel( $id )) {

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
	 * Delete hotel and cities
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
		if ( !$this->ps_delete->delete_hotel( $id, $enable_trigger )) {
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

		// get hotel name
		$hotel_name = $_REQUEST['hotel_name'];

		if ( $this->is_valid_name( $hotel_name, $id )) {
		// if the hotel name is valid,
			
			echo "true";
		} else {
		// if invalid hotel name,
			
			echo "false";
		}
	}
}