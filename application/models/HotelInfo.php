<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class HotelInfo extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_hotel_infos', 'hinfo_id', 'hi' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// hinfo_id condition
		if ( isset( $conds['hinfo_id'] )) {
			$this->db->where( 'hinfo_id', $conds['hinfo_id'] );
		}

		// hinfo_name condition
		if ( isset( $conds['hinfo_name'] )) {
			$this->db->where( 'hinfo_name', $conds['hinfo_name'] );
		}

		// hotel_id condition
		if ( isset( $conds['hotel_id'] )) {
			$this->db->where( 'hotel_id', $conds['hotel_id'] );
		}
	}

	/**
	 * Gets the type and group by hotel id
	 *
	 * @param      <type>  $hotel_id  The hotel identifier
	 */
	function get_type_and_group( $conds )
	{	
		//not duplicate
		$this->db->distinct();

		// get the type id and group id
		$this->db->select( 'hit.hinfo_grp_id, hit.hinfo_typ_id');

		// from hotel info
		$this->db->from( 'psh_hotel_infos hi' );

		// join type table to get the group id
		$this->db->join( 'psh_hotel_info_types hit', 'hit.hinfo_typ_id = hi.hinfo_typ_id' );
		
		if ( isset( $conds['hotel_id'] )) {
		// filter by hotel

			$this->db->where( 'hi.hotel_id', $conds[ 'hotel_id' ] );
		} else if ( isset( $conds[ 'city_id' ] )) {
		// filter by city

			$this->db->join( 'psh_hotels', 'psh_hotels.hotel_id = hi.hotel_id' );
			$this->db->where( 'psh_hotels.city_id', $conds[ 'city_id'] );
		}

		// return the result
		return $this->db->get();
	}
}