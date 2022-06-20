<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class HotelInfoType extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_hotel_info_types', 'hinfo_typ_id', 'hit' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// hinfo_typ_id condition
		if ( isset( $conds['hinfo_typ_id'] )) {
			$this->db->where( 'hinfo_typ_id', $conds['hinfo_typ_id'] );
		}

		// hinfo_grp_id condition
		if ( isset( $conds['hinfo_grp_id'] )) {
			$this->db->where( 'hinfo_grp_id', $conds['hinfo_grp_id'] );
		}

		// hinfo_typ_name condition
		if ( isset( $conds['hinfo_typ_name'] )) {
			$this->db->where( 'hinfo_typ_name', $conds['hinfo_typ_name'] );
		}

		// if not status filter
		if ( !isset( $conds['no_status_filter'] )) {
			$this->db->where( 'status', '1' );
		}

		// searchterm condition
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'hinfo_typ_name', $conds['searchterm'] );
		}
	}
}