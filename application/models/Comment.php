<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Comments table
 */
class Comment extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_comments', 'comment_id', 'cmt' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{		

		if ( isset( $conds['added_date_asc'])) {
			$this->db->order_by( 'added_date', 'asc' );
		} else {
			
			$this->db->order_by( 'added_date', 'desc' );
		}

		// comment_id condition
		if ( isset( $conds['comment_id'] )) {
			$this->db->where( 'comment_id', $conds['comment_id'] );
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