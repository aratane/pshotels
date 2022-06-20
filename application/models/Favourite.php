<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Favourite
 */
class Favourite extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_favourites', 'favourite_id', 'fav' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// hotel_id condition
		if ( isset( $conds['hotel_id'] )) {
			$this->db->where( 'hotel_id', $conds['hotel_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		// searchterm
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'cat_name', $conds['searchterm'] );
		}
	}
}