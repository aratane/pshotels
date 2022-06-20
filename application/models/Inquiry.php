<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for inquiry table
 */
class Inquiry extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_inquires', 'inq_id', 'inq' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// inq_id condition
		if ( isset( $conds['inq_id'] )) {
			$this->db->where( 'inq_id', $conds['inq_id'] );
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