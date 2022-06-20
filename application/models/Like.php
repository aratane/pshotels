<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Like
 */
class Like extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_likes', 'like_id', 'lik' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// like_id condition
		if ( isset( $conds['like_id'] )) {
			$this->db->where( 'like_id', $conds['like_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'user_id', $conds['user_id'] );
		}

		// room_id condition
		if ( isset( $conds['room_id'] )) {
			$this->db->where( 'room_id', $conds['room_id'] );
		}
	}
}