<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for ReviewCategory
 */
class ReviewCategory extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_review_categories', 'rvcat_id', 'rvcat' );
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
			$this->db->where( 'psh_review_categories.status', '1' );
		}

		// rvcat_id condition
		if ( isset( $conds['rvcat_id'] )) {
			$this->db->where( 'psh_review_categories.rvcat_id', $conds['rvcat_id'] );
		}

		// rvcat_name condition
		if ( isset( $conds['rvcat_name'] )) {
			$this->db->where( 'psh_review_categories.rvcat_name', $conds['rvcat_name'] );
		}

		if ( isset( $conds['searchterm'] ) && !empty( $conds['searchterm'])) {
			$this->db->like( 'psh_review_categories.rvcat_name', $conds['searchterm'] );	
		}
	}
}