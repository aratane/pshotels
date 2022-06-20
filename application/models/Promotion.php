<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for promotion table
 */
class Promotion extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_promotions', 'promo_id', 'promo' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// promo_id condition
		if ( isset( $conds['promo_id'] )) {
			$this->db->where( 'promo_id', $conds['promo_id'] );
		}

		// hotel_id condition
		if ( isset( $conds['hotel_id'] )) {
			$this->db->where( 'hotel_id', $conds['hotel_id'] );
		}

		// promo_name condition
		if ( isset( $conds['promo_name'] )) {
			$this->db->where( 'promo_name', $conds['promo_name'] );
		}

		// if not status filter
		if ( !isset( $conds['no_status_filter'] )) {
			$this->db->where( 'status', '1' );
		}

		// searchterm condition
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'promo_name', $conds['searchterm'] );
		}
	}
}