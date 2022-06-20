<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Room extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_rooms', 'room_id', 'room' );
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
			$this->db->where( 'psh_rooms.status', '1' );
		}

		// city id
		if ( isset( $conds['city_id'] ) && !empty( $conds['city_id'] )) {
			$this->db->join( 'psh_hotels hotel', 'psh_rooms.hotel_id = hotel.hotel_id ');
			$this->db->where( 'hotel.city_id', $conds['city_id'] );
		}
		
		// room_id condition
		if ( isset( $conds['room_id'] )) {
			$this->db->where( 'room_id', $conds['room_id'] );
		}

		// hotel_id condition
		if ( isset( $conds['hotel_id'] ) && !empty( $conds['hotel_id'] )) {
			$this->db->where( 'psh_rooms.hotel_id', $conds['hotel_id'] );
		}

		// room_name condition
		if ( isset( $conds['room_name'] )) {
			$this->db->where( 'room_name', $conds['room_name'] );
		}

		// if filter by room information types
		if ( isset( $conds['filter_by_info_type'] )) {

			// not to duplicate while join two tables
			$this->db->distinct();

			// get only room information
			$this->db->select( 'psh_rooms.*' );

			// get all type id seperated by dash
			$typ_ids = explode( '-', $conds['filter_by_info_type'] );

			// filter by hotel information type
			$i = 0;
			if( !empty( $typ_ids )) foreach ( $typ_ids as $typ_id ) {

				$tmp_tbl_name = "hi". $i++;

				// join with room info
				$this->db->join( 'psh_room_infos '. $tmp_tbl_name, $tmp_tbl_name .'.room_id = psh_rooms.room_id ' );
				$this->db->where( $tmp_tbl_name .'.rinfo_typ_id', $typ_id );
			}
		}

		// max_price, max_price by hotel
		if ( isset( $conds['price_range'] ) && isset( $conds['hotel_id'] )) {
			$this->db->select( 'max(room_price) max_price, min(room_price) min_price ');
			$this->db->group_by( 'psh_rooms.hotel_id' );
		}

		// popular rooms condition
		if ( $this->is_filter_popular( $conds )) {

			$n = $this->table_name;
			$t = "psh_room_touches";

			$this->db->select( "{$n}.*, count({$t}.user_id) touch_count" );

			// join user_categories table by news_id
			$this->db->join( 'psh_room_touches', 'psh_room_touches' .'.room_id = '. $this->table_name .'.room_id');

			// group by news id
			$this->db->group_by( $n .'.room_id' );

			// condition for user_categories table
			$this->db->order_by( "touch_count", "desc" );
		}

		$this->db->order_by( 'psh_rooms.added_date', 'desc' );
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