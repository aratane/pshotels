<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class City extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_cities', 'city_id', 'cty' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		
		// city_id condition
		if ( isset( $conds['city_id'] )) {
			$this->db->where( 'city_id', $conds['city_id'] );
		}

		// country_id condition
		if ( isset( $conds['country_id'] )) {
			$this->db->where( 'country_id', $conds['country_id'] );
		}

		// city_name condition
		if ( isset( $conds['city_name'] )) {
			$this->db->where( 'city_name', $conds['city_name'] );
		}

		// if not status filter
		if ( !isset( $conds['no_status_filter'] )) {
			$this->db->where( 'psh_cities.status', '1' );
		}

		// searchterm condition
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'city_name', $conds['searchterm'] );
		}

		// popular rooms condition
		if ( $this->is_filter_popular( $conds )) {

			$n = $this->table_name;
			$t = "psh_hotel_touches";

			$this->db->select( "{$n}.*, count({$this->table_name}.city_id) touch_count" );

			$this->db->join( 'psh_hotels', 'psh_hotels.city_id = '. $this->table_name .'.city_id' );

			// join user_categories table by hotel_id
			$this->db->join( 'psh_hotel_touches', 'psh_hotel_touches' .'.hotel_id = psh_hotels.hotel_id');

			// group by news id
			$this->db->group_by( $n .'.city_id' );

			// condition for user_categories table
			$this->db->order_by( "touch_count", "desc" );
		}

		$this->db->order_by( 'country_id', 'asc' );
	}

	/**
	 * Determines if filter popular.
	 *
	 * @return     boolean  True if filter popular, False otherwise.
	 */
	function is_filter_popular( $conds )
	{
		return ( isset( $conds['popular'] ) && $conds['popular'] == 1 );
	}
}