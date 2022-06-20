<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Ratings table
 */
class Rating extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_ratings', 'rating_id', 'rat' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// rating_id condition
		if ( isset( $conds['rating_id'] )) {
			$this->db->where( 'rating_id', $conds['rating_id'] );
		}

		// rating_value condition
		if ( isset( $conds['rating_value'] )) {
			$this->db->where( 'rating_value', $conds['rating_value'] );
		}

		// rating_desc
		if ( isset( $conds['rating_desc'] )) {
			$this->db->like( 'rating_desc', $conds['rating_desc'] );
		}

		// rating_id condition
		if ( isset( $conds['news_id'] )) {
			$this->db->where( 'news_id', $conds['news_id'] );
		}
	}
}