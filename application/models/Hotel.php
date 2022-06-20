<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for about table
 */
class Hotel extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_hotels', 'hotel_id', 'ht' );
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
			$this->db->where( 'psh_hotels.status', '1' );
		}
		
		// hotel_id condition
		if ( isset( $conds['hotel_id'] )) {
			$this->db->where( 'psh_hotels.hotel_id', $conds['hotel_id'] );
		}

		// hotel_name condition
		if ( isset( $conds['hotel_name'] )) {
			$this->db->like( 'hotel_name', $conds['hotel_name'] );
		}

		// is_recommended condition
		if ( isset( $conds['is_recommended'] )) {
			$this->db->like( 'is_recommended', 1 );
		}

		// city_id condition
		if ( isset( $conds['city_id'] ) && !empty( $conds['city_id'] )) {
			$this->db->where( 'psh_hotels.city_id', $conds['city_id'] );
		}

		// hotel_min_price condition
		if ( isset( $conds['hotel_min_price'] )) {
			$this->db->where( 'psh_hotels.hotel_min_price >=', $conds['hotel_min_price'] );
		}

		// hotel_max_price condition
		if ( isset( $conds['hotel_max_price'] )) {
			$this->db->where( 'psh_hotels.hotel_max_price <=', $conds['hotel_max_price'] );
		}

		// hotel_star_rating condition
		if ( isset( $conds['hotel_star_rating'] ) && !empty( $conds['hotel_star_rating'] )) {

			// get all type id seperated by dash
			$stars = explode( '-', $conds['hotel_star_rating'] );

			$this->db->where_in( 'psh_hotels.hotel_star_rating', $stars );
		}

		// if filter by hotel information types
		if ( isset( $conds['filter_by_info_type'] )) {

			// not to duplicate while join two tables
			$this->db->distinct();

			// get only hotel information
			$this->db->select( 'psh_hotels.*' );

			// get all type id seperated by dash
			$typ_ids = explode( '-', $conds['filter_by_info_type'] );

			// filter by hotel information type
			$i = 0;
			if( !empty( $typ_ids )) foreach ( $typ_ids as $typ_id ) {

				if ( empty( $typ_id )) continue;

				$tmp_tbl_name = "hi". $i++;

				// join with hotel info
				$this->db->join( 'psh_hotel_infos '. $tmp_tbl_name, $tmp_tbl_name .'.hotel_id = psh_hotels.hotel_id ' );
				$this->db->where( $tmp_tbl_name .'.hinfo_typ_id', $typ_id );
			}
		}

		// min_user_rating
		if ( isset( $conds['min_user_rating'] )) {			
			$ratings = $this->get_by_rating()->result();

			$hotel_ids = array( 'norating' );
			if ( !empty( $ratings )) foreach ( $ratings as $rating ) {
				if ( $rating->final_rating >= $conds['min_user_rating'] ) {
					$hotel_ids[] = $rating->hotel_id;
				}
			}

			$this->db->where_in( 'psh_hotels.hotel_id', $hotel_ids );
		}

		// favourite list
		// is_favourited condition
		if ( isset( $conds['is_favourited'] )) {
			
			if ( $this->is_filter_favourite( $conds )) {
				
				$this->db->select( $this->table_name .'.*' );

				// join by news id
				$this->db->join( 'psh_favourites', 'psh_favourites' .'.hotel_id = '. $this->table_name .'.hotel_id' );

				// filter by login user id
				$this->db->where( 'psh_favourites' .'.user_id', $conds['login_user_id'] );

			}
		}


		// popular rooms condition
		if ( $this->is_filter_popular( $conds )) {

			$n = $this->table_name;
			$t = "psh_hotel_touches";

			$this->db->select( "{$n}.*, count({$t}.user_id) touch_count" );

			// join user_categories table by hotel_id
			$this->db->join( 'psh_hotel_touches', 'psh_hotel_touches' .'.hotel_id = '. $this->table_name .'.hotel_id');

			// group by news id
			$this->db->group_by( $n .'.hotel_id' );

			// condition for user_categories table
			$this->db->order_by( "touch_count", "desc" );
		}

		// promotion only
		if ( $this->is_filter_promotion_only( $conds )) {
			// not to duplicate while join two tables
			$this->db->distinct();
			
			$this->db->select( 'psh_hotels.*' );
			$this->db->join( 'psh_rooms room', 'room.hotel_id = psh_hotels.hotel_id' );
			$this->db->join( 'psh_room_promotions', 'psh_room_promotions.room_id = room.room_id' );
			$this->db->join( 'psh_promotions', 'psh_promotions.promo_id = psh_room_promotions.promo_id' );
			$this->db->where( 'now() between psh_promotions.promo_start_time AND psh_promotions.promo_end_time' );
		}

		$this->db->order_by( 'psh_hotels.added_date', 'desc' );
	}

	/**
	 * Gets the maximum price.
	 *
	 * @return     <type>  The maximum price.
	 */
	function get_max_price()
	{
		$this->db->select( 'max(hotel_max_price) as max_price' );

		$this->db->from( 'psh_hotels' );

		return $this->db->get()->row();
	}

	/**
	 * Gets the hotels by minimum user rating.
	 */
	function get_by_rating()
	{
		// get final rating and hotel id
		$this->db->select_avg( 'rating.rvrating_rate', 'final_rating' );
		$this->db->select( 'psh_hotels.hotel_id' );

		// from hotels
		$this->db->from( 'psh_hotels' );

		// join rooms to get the hotel id
		$this->db->join( 'psh_rooms room', 'room.hotel_id = psh_hotels.hotel_id' );
		$this->db->join( 'psh_reviews review', 'room.room_id = review.room_id' );
		$this->db->join( 'psh_review_ratings rating', 'review.review_id = rating.review_id' );

		// group by hotel id
		$this->db->group_by( 'psh_hotels.hotel_id' );

		return $this->db->get();
	}

	/**
	 * Determines if filter promotion_only.
	 *
	 * @return     boolean  True if filter promotion_only, False otherwise.
	 */
	function is_filter_promotion_only( $conds )
	{
		return ( isset( $conds['promotion_only'] ) && $conds['promotion_only'] == 1 );
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

	/**
	 * Determines if filter favourite.
	 *
	 * @return     boolean  True if filter favourite, False otherwise.
	 */
	function is_filter_favourite( $conds )
	{
		return ( isset( $conds['login_user_id'] ) && 
			     isset( $conds['is_favourited'] ) && 
			     $conds['is_favourited'] == 1
			   );
	}
}