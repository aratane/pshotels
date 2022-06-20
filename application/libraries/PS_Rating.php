<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Math
 */
class PS_Rating {

	// codeigniter instance
	protected $CI;

	/**
	 * Load CI Instances
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();
	}

	/**
	 * Gets the room final ratings.
	 *
	 * @param      <type>  $room_id  The room identifier
	 */
	function get_room_final_ratings( $room_id, $rvcat_id = false )
	{
		$ratings = $this->get_room_ratings( $room_id );

		// return the rating if only for specific category
		if ( $rvcat_id ) return $ratings[ $rvcat_id ];

		// calculate final rating
		$total = 0;
		$count = count( $ratings );
		foreach ( $ratings as $rating ) {
		// loop each rating and get total

			$total += $rating;
		}

		// calculate rating  = total / category count
		$final_rating = $total / $count;

		return $final_rating;
	}

	/**
	 * Gets the room rating.
	 *
	 * @param      <type>   $room_id   The room identifier
	 * @param      boolean  $rvcat_id  The rvcat identifier
	 */
	function get_room_ratings( $conds )
	{
		$room_ratings = array();
		$conds = arary();

		if ( isset( $conds['room_id'] )) {
		// if get all rating for the room
			
			$conds['room_id'] = $room_id;
		}

		if ( isset( $conds['user_id'] )) {
		// if get all rating by the user

			$conds['user_id'] = $user_id;
		}

		if ( isset( $conds['review_id'] )) {
		// if get all rating only for one review

			$conds['review_id'] = $review_id;
		}

		// get all the reviews
		$reviews = $this->CI->Review->get_all_by( $conds )->result();

		foreach ( $reviews as $review ) {
		// loop each review and get ratings for each category

			// get all ratings,
			$ratings = $this->CI->ReviewRating->get_all_by( array( 'review_id' => $review->review_id ))->result();

			foreach ( $ratings as $rating ) {
			// loop each ratings and get total for each category

				$review_cats[$rating->rvcat_id][] = $rating->rvrating_rate;
			}
		}

		foreach ( $review_cats as $key => $review_cat ) {
		// loop each review category and get the rating

			$total = 0;
			$count = count( $review_cat );
			foreach ( $review_cat as $cat ) {
			// sum all the ratings,

				$total += $cat;
			}

			// rating = total / item count
			$final_rating = $total / $count;

			// set to the main array
			$room_ratings[$key] = $final_rating;
		}

		return $room_ratings;
	}

	/**
	 * Gets the hotel rating.
	 *
	 * @param      <type>   $hotel_id  The hotel identifier
	 * @param      boolean  $rvcat_id  The rvcat identifier
	 */
	function get_hotel_ratings( $hotel_id, $rvcat_id = false )
	{

	}
}