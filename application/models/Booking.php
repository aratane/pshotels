<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for booking table
 */
class Booking extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_bookings', 'booking_id', 'booking' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// booking_id condition
		if ( isset( $conds['booking_id'] )) {
			$this->db->where( 'booking_id', $conds['booking_id'] );
		}

		// hotel_id condition
		if ( isset( $conds['hotel_id'] ) && !empty( $conds['hotel_id'] )) {
			$this->db->where( 'hotel_id', $conds['hotel_id'] );
		}

		// room_id condition
		if ( isset( $conds['room_id'] ) && !empty( $conds['room_id'] )) {
			$this->db->where( 'room_id', $conds['room_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id']) && !empty( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		// login_user_id condition
		if ( isset( $conds['login_user_id']) && !empty( $conds['login_user_id'] )) {
			$this->db->where( 'user_id', $conds['login_user_id'] );
		}

		// booking_status condition
		if ( isset( $conds['booking_status']) && !empty( $conds['booking_status'] )) {
			$this->db->where( 'booking_status', $conds['booking_status'] );
		}

		$this->db->order_by('added_date', 'desc');
	}

	function is_valid( $conds, $key ) 
	{
		return (isset( $conds[$key] ) && !empty( $conds[$key] ));
	}
}