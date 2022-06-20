<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class RoomInfo extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_room_infos', 'rinfo_id', 'ri' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// rinfo_id condition
		if ( isset( $conds['rinfo_id'] )) {
			$this->db->where( 'rinfo_id', $conds['rinfo_id'] );
		}

		// rinfo_name condition
		if ( isset( $conds['rinfo_name'] )) {
			$this->db->where( 'rinfo_name', $conds['rinfo_name'] );
		}

		// room_id condition
		if ( isset( $conds['room_id'] )) {
			$this->db->where( 'room_id', $conds['room_id'] );
		}
	}

	/**
	 * Gets the type and group by room id
	 *
	 * @param      <type>  $room_id  The room identifier
	 */
	function get_type_and_group( $conds )
	{
		//not duplicate
		$this->db->distinct();

		// get the type id and group id
		$this->db->select( 'rit.rinfo_grp_id, rit.rinfo_typ_id');

		// from room info
		$this->db->from( 'psh_room_infos ri' );

		// join type table to get the group id
		$this->db->join( 'psh_room_info_types rit', 'rit.rinfo_typ_id = ri.rinfo_typ_id' );
		
		if ( isset( $conds['room_id'] )) {
		// filter by room

			$this->db->where( 'ri.room_id', $conds[ 'room_id' ] );
		} else if ( isset( $conds[ 'hotel_id' ] )) {
		// filter by hotel

			$this->db->join( 'psh_rooms', 'psh_rooms.room_id = ri.room_id' );
			$this->db->where( 'psh_rooms.hotel_id', $conds[ 'hotel_id'] );
		}

		// return the result
		return $this->db->get();
	}
}