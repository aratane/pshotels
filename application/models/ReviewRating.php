<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for ReviewRating
 */
class ReviewRating extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_review_ratings', 'rvrating_id', 'rvcat' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// if not status filter
		if ( !isset( $conds['no_status_filter'] )) {
			$this->db->where( 'psh_review_ratings.status', '1' );
		}

		// rvrating_id condition
		if ( isset( $conds['rvrating_id'] )) {
			$this->db->where( 'psh_review_ratings.rvrating_id', $conds['rvrating_id'] );
		}

		// rvcat_id condition
		if ( isset( $conds['rvcat_id'] )) {
			$this->db->where( 'psh_review_ratings.rvcat_id', $conds['rvcat_id'] );
		}

		// review_id condition
		if ( isset( $conds['review_id'] )) {
			$this->db->where( 'psh_review_ratings.review_id', $conds['review_id'] );
		}

		// rvrating_rate condition
		if ( isset( $conds['rvrating_rate'] )) {
			$this->db->where( 'psh_review_ratings.rvrating_rate', $conds['rvrating_rate'] );
		}
	}
}