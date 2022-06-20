<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for touch table
 */
class HotelTouch extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_hotel_touches', 'hotel_touch_id', 'tou' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// hotel_touch_id condition
		if ( isset( $conds['hotel_touch_id'] )) {
			$this->db->where( 'hotel_touch_id', $conds['hotel_touch_id'] );
		}

		// hotel_id condition
		if ( isset( $conds['hotel_id'] )) {
			$this->db->where( 'hotel_id', $conds['hotel_id'] );
		}

		// city_id condition
		if ( isset( $conds['city_id'] )) {
			$this->db->join( 'psh_hotels', 'psh_hotels.hotel_id = psh_hotel_touches.hotel_id' );
			$this->db->where( 'psh_hotels.city_id', $conds['city_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}
	}
}