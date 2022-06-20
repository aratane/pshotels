<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for touch table
 */
class RoomTouch extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_room_touches', 'room_touch_id', 'tou' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// room_touch_id condition
		if ( isset( $conds['room_touch_id'] )) {
			$this->db->where( 'room_touch_id', $conds['room_touch_id'] );
		}

		// room_id condition
		if ( isset( $conds['room_id'] )) {
			$this->db->where( 'room_id', $conds['room_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}
	}
}