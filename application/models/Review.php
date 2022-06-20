<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Model class for Review
 */
class Review extends PS_Model {

	/**
	 * Constructs the required data
	 */
	function __construct() 
	{
		parent::__construct( 'psh_reviews', 'review_id', 'rv' );
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
			$this->db->where( 'psh_reviews.status', '1' );
		}

		// review_id condition
		if ( isset( $conds['review_id'] )) {
			$this->db->where( 'psh_reviews.review_id', $conds['review_id'] );
		}

		// room_id condition
		if ( isset( $conds['room_id'] )) {
			$this->db->where( 'psh_reviews.room_id', $conds['room_id'] );
		}

		// hotel_id condition
		if ( isset( $conds['hotel_id'] )) {

			$this->db->select( 'psh_reviews.*' );
			$this->db->join( 'psh_rooms', 'psh_rooms.room_id = psh_reviews.room_id' );
			$this->db->where( 'psh_rooms.hotel_id', $conds['hotel_id'] );
		}

		// user_id condition
		if ( isset( $conds['user_id'] )) {
			$this->db->where( 'psh_reviews.user_id', $conds['user_id'] );
		}
	}

	/**
	 * Gets the ratings.
	 *
	 * @param      array    $conds           The conds
	 * @param      boolean  $is_rating_only  Indicates if rating only
	 *
	 * @return     <type>   The ratings.
	 */
	function get_ratings( $conds = array(), $is_rating_only = false ) 
	{		
		if ( $is_rating_only ) {
		// if display rating only

			$this->db->select_avg( 'rating.rvrating_rate', 'final_rating' );
			$this->db->select( 'count(distinct review.review_id) as review_count' );
		} else {
		// else it is cat id vs rating,
			
			$this->db->select( 'rating.rvcat_id, avg( rating.rvrating_rate ) final_rating');
			$this->db->group_by( 'rating.rvcat_id' );
		}

		// join review vs review_rating
		$this->db->from( 'psh_reviews review' );
		$this->db->join( 'psh_review_ratings rating', 'review.review_id = rating.review_id' );

		if ( isset( $conds['hotel_id'] )) {
		// if rating for hotel,
			$this->db->join( 'psh_rooms room', 'room.room_id = review.room_id' );
			$this->db->where( 'room.hotel_id', $conds['hotel_id'] );
		}

		if ( isset( $conds['room_id'] )) {
		// if rating for room
			$this->db->where( 'review.room_id', $conds['room_id'] );
		}

		if ( isset( $conds['user_id'] )) {
		// if rating by specific user,
			$this->db->where( 'review.user_id', $conds['user_id'] );
		}

		if ( isset( $conds['review_id'] )) {
		// if rating by only one review,
			$this->db->where( 'review.review_id', $conds['review_id'] );
		}

		if ( isset( $conds['rvcat_id'] )) {
		// if rating by specific cat id,
			$this->db->where( 'rating.rvcat_id', $conds['rvcat_id'] );
		}

		return $this->db->get();
	}
}

// Rating SQLs
// by room id
//select avg(prr.rvrating_rate) from psh_reviews pr join psh_review_ratings prr on prr.review_id = pr.review_id where pr.room_id='room72ae0286528de49b8e8691a6b2ff89f4'
//
// by room id, cat id
// select avg(prr.rvrating_rate) from psh_reviews pr join psh_review_ratings prr on prr.review_id = pr.review_id where pr.room_id='room72ae0286528de49b8e8691a6b2ff89f4' and prr.rvcat_id='rvcat001'
// 
// by room id, usr id
//select avg(prr.rvrating_rate) from psh_reviews pr join psh_review_ratings prr on prr.review_id = pr.review_id where pr.room_id='room72ae0286528de49b8e8691a6b2ff89f4' and pr.user_id='c4ca4238a0b923820dcc509a6f75849b'
// 
// by review_id
// select avg(prr.rvrating_rate) from psh_reviews pr join psh_review_ratings prr on prr.review_id = pr.review_id where pr.review_id='rv001'
// 
// select by rvcat_id
// select prr.rvcat_id, avg(prr.rvrating_rate) from psh_reviews pr join psh_review_ratings prr on prr.review_id = pr.review_id where pr.room_id='room72ae0286528de49b8e8691a6b2ff89f4' group by prr.rvcat_id