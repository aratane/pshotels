<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Rooms Controller
 */
class Rooms extends BE_Controller {
		
	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'ROOMS' );
	}

	/**
	 * rooms list
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
			$this->data['rows_count'] = $this->Room->count_all_by( $conds );

			// get rooms
			$this->data['rooms'] = $this->Room->get_all_by( $conds , $this->pag['per_page'], $this->uri->segment( 4 ) );
		} else if($logged_in_user->is_hotel_admin == 1) {
			// get rooms
			$this->data['rooms'] = $this->Room->get_all_in_hotel_admin( $user_hotels_ids );
		}

		// load index logic
		parent::index();
	}

	/**
	 * search rooms
	 */
	function search() {

		$logged_in_user = $this->ps_auth->get_user_info();
		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'room_search' );
		if($logged_in_user->user_is_sys_admin == 1) {
			// condition with search term
			$conds = $this->searchterm_handler( array(
				'searchterm' => $this->input->post( 'searchterm' ),
				'hotel_id' => $this->input->post( 'hotel_id' ),
				'city_id' => $this->input->post( 'city_id' ),
			));

			// no publish filter
			$conds['no_status_filter'] = 1;

			// pagination
			$this->data['rows_count'] = $this->Room->count_all_by( $conds );

			// search data
			$this->data['rooms'] = $this->Room->get_all_by( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		} else if($logged_in_user->is_hotel_admin == 1) {
			// condition with search term
			$conds = $this->searchterm_handler( array(
				'searchterm' => $this->input->post( 'searchterm' ),
				'hotel_id' => $this->input->post( 'hotel_id' ),
				'city_id' => $this->input->post( 'city_id' ),
			));

			$conds_user_hotel['user_id'] = $logged_in_user->user_id;
			$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();

			$user_hotels_ids = array();
			for($i=0; $i<count($user_hotel); $i++) {
			 	$user_hotels_ids[]= $user_hotel[$i]->hotel_id;
			}
			$conds['hotel_id'] = $user_hotels_ids;

			// search data
			$this->data['rooms'] = $this->Room->get_all_by_room( $conds, $this->pag['per_page'], $this->uri->segment( 4 ) );
		}
		
		// load add list
		parent::search();
	}

	/**
	 * Add new room
	 */
	function add() {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'room_add' );

		// call the core add logic
		parent::add();
	}

	/**
	 * Update room info
	 *
	 * @param      <type>  $id     The identifier
	 */
	function edit( $id ) {

		// breadcrumb urls
		$this->data['action_title'] = get_msg( 'room_edit' );

		// get room information
		$room = $this->Room->get_one( $id );

		// get room extra information
		$rinfos = $this->RoomInfo->get_all_by( array( 'room_id' => $id ))->result();
		$rinfo_typ_ids = array();
		if ( !empty( $rinfos )) {
			foreach ( $rinfos as $rinfo ) {
				$rinfo_typ_ids[] = $rinfo->rinfo_typ_id;
			}
		}
		$room->rinfo_typ_ids = $rinfo_typ_ids;

		// load user
		$this->data['room'] = $room;

		// call the parent edit logic
		parent::edit( $id );
	}

	/**
	 * Save room info
	 *
	 * @param      boolean  $id     The identifier
	 */
	function save( $id = false ) {

		// start the transaction
		$this->db->trans_start();
		
		/** 
		 * Insert Room Records 
		 */
		$data = array();

		// prepare room_name
		if ( $this->has_data( 'room_name' )) {
			$data['room_name'] = $this->get_data( 'room_name' );
		}

		// prepare room_desc
		if ( $this->has_data( 'room_desc' )) {
			$data['room_desc'] = $this->get_data( 'room_desc' );
		}

		// prepare hotel_id
		if ( $this->has_data( 'hotel_id' )) {
			$data['hotel_id'] = $this->get_data( 'hotel_id' );
		}

		// prepare room_size
		if ( $this->has_data( 'room_size' )) {
			$data['room_size'] = $this->get_data( 'room_size' );
		}

		// prepare room_price
		if ( $this->has_data( 'room_price' )) {
			$data['room_price'] = $this->get_data( 'room_price' );
		}

		// prepare room_no_of_beds
		if ( $this->has_data( 'room_no_of_beds' )) {
			$data['room_no_of_beds'] = $this->get_data( 'room_no_of_beds' );
		}

		// prepare room_adult_limit
		if ( $this->has_data( 'room_adult_limit' )) {
			$data['room_adult_limit'] = $this->get_data( 'room_adult_limit' );
		}

		// prepare room_kid_limit
		if ( $this->has_data( 'room_kid_limit' )) {
			$data['room_kid_limit'] = $this->get_data( 'room_kid_limit' );
		}

		// prepare room_extra_bed_price
		if ( $this->has_data( 'room_extra_bed_price' )) {
			$data['room_extra_bed_price'] = $this->get_data( 'room_extra_bed_price' );
		}

		// if 'is available' is checked,
		if ( $this->has_data( 'is_available' )) {
			$data['is_available'] = 1;
		} else {
			$data['is_available'] = 0;
		}

		// save Room
		if ( ! $this->Room->save( $data, $id )) {
		// if there is an error in inserting user data,	

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );			
			return false;
		}

		// get inserted id
		if ( !$id ) $id = $data['room_id'];

		// Room Extra Information
		$rinfo_typs = array();
		if ( $this->has_data( 'rinfo_typs' )) {
			$rinfo_typs = $this->get_data( 'rinfo_typs' );
		}

		// clear existing data first
		if ( !$this->RoomInfo->delete_by( array( 'room_id' => $id ))) {

			// rollback the transaction
			$this->db->trans_rollback();

			// set error message
			$this->data['error'] = get_msg( 'err_model' );			
			return false;
		}

		if ( !empty( $rinfo_typs )) {
		// if room extra information is not empty,			
			foreach ( $rinfo_typs as $rinfo_typ_id ) {

				$rinfo_typ_data = array(
					'room_id' => $id,
					'rinfo_typ_id' => $rinfo_typ_id
				);

				if ( !$this->RoomInfo->save( $rinfo_typ_data )) {
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
			array( 'url' => 'edit/'. $id, 'label' => get_msg( 'room_edit' )), 
			array( 'label' => get_msg( 'room_gallery' ))
		);
		
		$_SESSION['parent_id'] = $id;
		$_SESSION['type'] = 'room';
    	    	
    	$this->load_gallery();
    }

	/**
	 * Determines if valid input.
	 *
	 * @param      integer  $id     The identifier
	 */
	function is_valid_input( $id = 0 ) {

		$rule = 'required|callback_is_valid_name['. $id  .']';

		$this->form_validation->set_rules( 'room_name', get_msg( 'room_name' ), $rule);

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

		// get hotel id
		$hotel_id = 0;
		if ( $this->has_data( 'hotel_id' )) {
			$hotel_id = $this->get_data( 'hotel_id' );
		}

		if ( strtolower( $this->Room->get_one( $id )->room_name ) == strtolower( $name ) && 
			$this->Room->get_one( $id )->hotel_id == $hotel_id ) {
		// if the name is existing name for that user id,

			return true;
		} else if ( $this->Room->exists( array( 'room_name' => $_REQUEST['room_name'], 'hotel_id' => $hotel_id ))) {
		// if the name is existed in the system,

			$this->form_validation->set_message('is_valid_name', get_msg( 'err_dup_name' ));
			return false;
		}

		// var_dump( $_REQUEST['room_name'] );
		// var_dump( $hotel_id );

		return true;
	}

	/**
	 * Delete room
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete( $id ) {

	}

	/**
	 * Delete room and cities
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
		if ( !$this->ps_delete->delete_room( $id, $enable_trigger )) {
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

		// get room name
		$room_name = $_REQUEST['room_name'];

		if ( $this->is_valid_name( $room_name, $id )) {
		// if the room name is valid,
			
			echo "true";
		} else {
		// if invalid room name,
			
			echo "false";
		}
	}
}