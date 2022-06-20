<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for api table
 */
class User_hotel extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_user_hotels', 'id', 'userhotel' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// api_id condition
		if ( isset( $conds['id'] )) {
			
			$this->db->where( 'id', $conds['id'] );
		}

		// api_constant condition
		if ( isset( $conds['user_id'] )) {
			
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		// api_constant condition
		if ( isset( $conds['hotel_id'] )) {
			
			$this->db->where( 'hotel_id', $conds['hotel_id'] );
		}
	}
}