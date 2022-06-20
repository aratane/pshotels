<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Country extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_countries', 'country_id', 'ctry' );
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
			$this->db->where( 'status', '1' );
		}

		// country_id condition
		if ( isset( $conds['country_id'] )) {
			$this->db->where( 'country_id', $conds['country_id'] );
		}

		// country_name condition
		if ( isset( $conds['country_name'] )) {
			$this->db->where( 'country_name', $conds['country_name'] );
		}

		// searchterm condition
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'country_name', $conds['searchterm'] );
		}
	}
}