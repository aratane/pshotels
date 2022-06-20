<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for room_promotion table
 */
class RoomPromotion extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_room_promotions', 'rpromo_id', 'rpromo' );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array())
	{		
		// rpromo_id condition
		if ( isset( $conds['rpromo_id'] )) {
			$this->db->where( 'rpromo_id', $conds['rpromo_id'] );
		}

		// promo_id condition
		if ( isset( $conds['promo_id'] )) {
			$this->db->where( 'promo_id', $conds['promo_id'] );
		}

		// room_id condition
		if ( isset( $conds['room_id'] )) {
			$this->db->where( 'room_id', $conds['room_id'] );
		}

		// hotel_id condition
		if ( isset( $conds['hotel_id'] )) {
			$this->db->select( 'psh_room_promotions.*' );
			$this->db->join( 'psh_rooms room', 'room.room_id = psh_room_promotions.room_id' );
			$this->db->where( 'room.hotel_id', $conds['hotel_id'] );
		}

		// get the latest
		if ( isset( $conds['valid_date_only'] )) {
			$this->db->select( 'psh_room_promotions.*, psh_promotions.*' );
			$this->db->join( 'psh_promotions', 'psh_promotions.promo_id = psh_room_promotions.promo_id' );
			$this->db->where( 'now() between psh_promotions.promo_start_time AND psh_promotions.promo_end_time' );
			$this->db->order_by( 'psh_promotions.promo_percent', 'desc' );
		}

		// if not status filter
		if ( !isset( $conds['no_status_filter'] )) {
			$this->db->where( 'psh_room_promotions.status', '1' );
		}

		// searchterm condition
		if ( isset( $conds['searchterm'] )) {
			$this->db->like( 'promo_name', $conds['searchterm'] );
		}
	}
}