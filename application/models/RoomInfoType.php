<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class RoomInfoType extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_room_info_types', 'rinfo_typ_id', 'rit' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{
		// rinfo_typ_id condition
		if ( isset( $conds['rinfo_typ_id'] )) {
			$this->db->where( 'rinfo_typ_id', $conds['rinfo_typ_id'] );
		}

		// rinfo_grp_id condition
		if ( isset( $conds['rinfo_grp_id'] )) {
			$this->db->where( 'rinfo_grp_id', $conds['rinfo_grp_id'] );
		}

		// rinfo_typ_name condition
		if ( isset( $conds['rinfo_typ_name'] )) {
			$this->db->where( 'rinfo_typ_name', $conds['rinfo_typ_name'] );
		}

		// if not status filter
		if ( !isset( $conds['no_status_filter'] )) {
			$this->db->where( 'status', '1' );
		}

		// searchterm condition
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'rinfo_typ_name', $conds['searchterm'] );
		}
	}
}