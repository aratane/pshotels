<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Authentication
 */
class PS_Widget {

	// codeigniter instance
	protected $CI;

	// template path
	protected $template_path;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();

		// load authetication library
		$this->CI->load->library( "PS_Auth" );
		$this->CI->load->library( "PS_Dummy" );
	}

	/**
	 * Default Conditions
	 *
	 * @param      <type>  $conds  The conds
	 */
	function base_conds()
	{
		if ( $this->CI->ps_auth->is_logged_in()) {
		// if there is logged in user, all room will be filterd by user id

			return array( 'login_user_id' => $this->CI->ps_auth->get_user_info()->user_id, 'filter_subscribe_category' => '1' );
		}

		return array();
	}

	/**
	 * Sets the template path.
	 *
	 * @param      <type>  $path   The path
	 */
	function set_template_path( $path )
	{
		$this->template_path = $path;
	}

	/**
	 * Popular Cities List
	 */
	function popular_cities()
	{
		$cities = $this->CI->City->get_all_by( array( 'popular' => 1 ), 3 )->result();

		if ( !empty( $cities )) {
			foreach ( $cities as $city ) {
				$city->default_photo = $this->get_default_photo( $city->city_id, 'city' );
			}
		}

		$data['popular_cities'] = $cities;

		$this->CI->load->view( $this->template_path .'/components/home/popular_cities', $data );
	}

	/**
	 * Popular Hotels
	 */
	function popular_hotels()
	{
		$hotels = $this->CI->Hotel->get_all_by( array( 'popular' => 1 ), 3 )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as $hotel ) {
				$hotel->default_photo = $this->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->CI->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->CI->Country->get_one( $city->country_id )->country_name;

				// get final rating 
				$ratings = $this->CI->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$data['popular_hotels'] = $hotels;

		$this->CI->load->view( $this->template_path .'/components/home/popular_hotels', $data );
	}

	/**
	 * Recommended Hotels
	 */
	function recommended_hotels()
	{
		$hotels = $this->CI->Hotel->get_all_by( array( 'is_recommended' => 1 ), 3 )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as $hotel ) {
				$hotel->default_photo = $this->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->CI->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->CI->Country->get_one( $city->country_id )->country_name;

				// get final rating 
				$ratings = $this->CI->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$data['recommended_hotels'] = $hotels;

		$this->CI->load->view( $this->template_path .'/components/home/recommended_hotels', $data );
	}

	/**
	 * Favourite Hotels
	 */
	function favourite_hotels()
	{
		if ( !$this->CI->ps_auth->is_logged_in()) {
			return false;
		}

		$login_user_id = $this->CI->ps_auth->get_user_info()->user_id;
		$conds = array( 
			"login_user_id" => $login_user_id,
			"is_favourited" => 1
		);

		// get latest 6
		$limit = $this->CI->config->item( 'favourite_hotel_display_limit' );
		$hotels = $this->CI->Hotel->get_all_by( $conds, $limit )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as $hotel ) {
				$hotel->default_photo = $this->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->CI->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->CI->Country->get_one( $city->country_id )->country_name;

				// get final rating 
				$ratings = $this->CI->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$data['favourited_hotels'] = $hotels;
		$data['limit'] = $limit;
		$data['total_hotels'] = $this->CI->Hotel->count_all_by( $conds );

		$this->CI->load->view( $this->template_path .'/components/favourite_hotels', $data );
	}

	/**
	 * Popular Rooms
	 */
	function popular_rooms()
	{
		// popular rooms
		$rooms = $this->CI->Room->get_all_by( array( 'popular' => 1), 6 )->result();

		if ( !empty( $rooms )) {
			foreach ( $rooms as $room ) {
				
				// set more info
				$this->set_more_info( $room );
			}
		}

		$data['popular_rooms'] = $rooms;


		$this->CI->load->view( $this->template_path .'/components/home/popular_rooms', $data );
	}

	/**
	 * Sidebar
	 */
	function sidebar()
	{
		$rooms = $this->CI->Room->get_all( 3 )->result();

		if ( !empty( $rooms )) {
			foreach ( $rooms as $room ) {
				
				// set more info
				$this->set_more_info( $room );
			}
		}

		$data['popular_rooms'] = $rooms;

		// popular hotels
		$hotels = $this->CI->Hotel->get_all( 3 )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as $hotel ) {
				$hotel->default_photo = $this->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->CI->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->CI->Country->get_one( $city->country_id )->country_name;

				// get final rating 
				$ratings = $this->CI->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$data['popular_hotels'] = $hotels;

		// popular cities
		$cities = $this->CI->City->get_all( 3 )->result();

		if ( !empty( $cities )) {
			foreach ( $cities as $city ) {
				$city->default_photo = $this->get_default_photo( $city->city_id, 'city' );
			}
		}

		$data['popular_cities'] = $cities;
		
		$this->CI->load->view( $this->template_path .'/components/sidebar', $data );
	}

	/**
	 * Widget for aboutus
	 */
	function aboutus_sm()
	{
		$data['aboutus'] = $this->CI->About->get_one_by( array());

		$this->CI->load->view( $this->template_path .'/components/aboutus_sm', $data );
	}

	/**
	 * Widget for contactus
	 */
	function contactus_sm()
	{
		$this->CI->load->view( $this->template_path .'/components/contactus_sm');
	}

	/**
	 * Widget for reviews
	 */
	function reviews( $room_id )
	{	
		$limit = $this->CI->config->item( 'reviews_display_limit' );
		$offset = 0;

		// get all reviews
		$reviews = $this->CI->Review->get_all_by( array( 'room_id' => $room_id, 'added_date_asc' => '1' ), $limit, $offset )->result();

		// get all users
		$cmts = array();
		if( !empty( $reviews )) {
			foreach ( $reviews as $review ) {
				$review->user = $this->CI->User->get_one( $review->user_id );
				$cmts[] = $review;
			}
		}

		$data['reviews'] = $reviews;
		$data['reviews_count'] = $this->CI->Review->count_all_by( array( 'room_id' => $room_id ) );
		$data['reviews_limit'] = $limit;

		$this->CI->load->view( $this->template_path .'/components/reviews', $data );
	}

	/**
	 * Gets the default photo.
	 *
	 * @param      <type>  $id     The identifier
	 * @param      <type>  $type   The type
	 */
	function get_default_photo( $id, $type )
	{
		$default_photo = "";

		// get all images
		$img = $this->CI->Image->get_all_by( array( 'img_parent_id' => $id, 'img_type' => $type ))->result();

		if ( count( $img ) > 0 ) {
		// if there are images for room,
			
			$default_photo = $img[0];
		} else {
		// if no image, return empty object

			$default_photo = $this->CI->ps_dummy->get_dummy_photo();
		}

		return $default_photo;
	}

	/**
	 * Sets the more information.
	 *
	 * @param      <type>  $obj    The object
	 */
	function set_more_info( &$obj )
	{
		$type = false;
		if ( isset( $obj->city_id )) $type = 'city';

		if ( isset( $obj->hotel_id )) $type = 'hotel';

		if ( isset( $obj->room_id )) $type = 'room';

		if ( !$type ) return false;

		switch( $type ) {
			case 'city':
				$this->set_city_info( $obj );
				break;

			case 'hotel':
				$this->set_hotel_info( $obj );
				break;

			case 'room':
				$this->set_room_info( $obj );
				break;
		}
	}

	/**
	 * Assign reqruired attributes
	 *
	 * @param      <type>  $city   The city
	 */
	function set_city_info( &$city )
	{
		// get other infos
		$city->country = $this->CI->Country->get_one( $city->country_id );
		$city->hotels = $this->CI->Hotel->get_all_by( array( 'city_id' => $city->city_id ))->result();
		$city->rooms = $this->CI->Room->get_all_by( array( 'city_id' => $city->city_id ))->result();
		$city->default_photo = $this->get_default_photo( $city->city_id, 'city' );
	}

	/**
	 * Assign required attribtues
	 *
	 * @param      <type>  $hotel  The hotel
	 */
	function set_hotel_info( &$hotel )
	{
		// get city
		$hotel->city = $this->CI->City->get_one( $hotel->city_id );

		// get default photo
		$hotel->default_photo = $this->get_default_photo( $hotel->hotel_id, 'hotel' );

		// get hotel price range
		// $price_range = $this->CI->Room->get_one_by( array( 'price_range' => 1, 'hotel_id' => $hotel->hotel_id ));
		// $hotel->max_price = $price_range->max_price;
		// $hotel->min_price = $price_range->min_price;

		// get final rating 
		$ratings = $this->CI->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
		if ( !empty( $ratings )) {
			$hotel->final_rating = $ratings[0]->final_rating;
			$hotel->rating_text = get_rating_text( $hotel->final_rating );
			$hotel->review_count = $ratings[0]->review_count;
		}

		// get promotions
		$promotions = $this->CI->RoomPromotion->get_all_by( array( 'hotel_id' => $hotel->hotel_id, 'valid_date_only' => 1 ))->result();
		if ( !empty( $promotions )) {
			$hotel->promotion = $promotions[0];
		}

		// get hotel features
		$infos = $this->CI->HotelInfo->get_type_and_group( array( 'hotel_id' => $hotel->hotel_id ))->result();
		$features = array();
		$feature_names = array();
		if ( !empty( $infos )) {
			foreach ( $infos as $info ) {
				$features[$info->hinfo_grp_id][] = $info->hinfo_typ_id;
				$feature_names[] = $this->CI->HotelInfoType->get_one( $info->hinfo_typ_id )->hinfo_typ_name;
			}
		}
		$hotel->features = $features;
		$hotel->feature_names = $feature_names;
	}

	/**
	 * Assign required attrbutes
	 *
	 * @param      <type>  $room   The room
	 */
	function set_room_info( &$room )
	{
		// get default photo
		$room->default_photo = $this->get_default_photo( $room->room_id, 'room' );

		// get hotel info
		$room->hotel = $this->CI->Hotel->get_one( $room->hotel_id );

		// get city info
		$room->city = $this->CI->City->get_one( $room->hotel->city_id );

		// get country info
		$room->country = $this->CI->Country->get_one( $room->city->city_id );

		// get people count
		$room->capacity = $room->room_adult_limit .' adults '. $room->room_kid_limit .' kids';

		// get room rating
		$ratings = $this->CI->Review->get_ratings( array( 'room_id' => $room->room_id ), true )->result();
		if ( !empty( $ratings )) {
			$room->final_rating = $ratings[0]->final_rating;
			$room->rating_text = get_rating_text( $room->final_rating );
			$room->review_count = $ratings[0]->review_count;
		}

		// get promotions
		$promotions = $this->CI->RoomPromotion->get_all_by( array( 'room_id' => $room->room_id, 'valid_date_only' => 1 ))->result();
		if ( !empty( $promotions )) {
			$room->promotion = $promotions[0];
		}

		// get other room features
		$infos = $this->CI->RoomInfo->get_type_and_group( array( 'room_id' => $room->room_id ))->result();
		$features = array();
		if ( !empty( $infos )) {
			foreach ( $infos as $info ) {
				$features[$info->rinfo_grp_id][] = $info->rinfo_typ_id;
			}
		}
		$room->features = $features;
	}

	/**
	 * My Bookings List
	 */
	function booking_list()
	{
		if ( !$this->CI->ps_auth->is_logged_in()) {
			return false;
		}

		$login_user_id = $this->CI->ps_auth->get_user_info()->user_id;

		$conds = array( "login_user_id" => $login_user_id );

		// get latest 3
		$bookings = $this->CI->Booking->get_all_by( $conds, 3 )->result();

		if ( !empty( $bookings )) foreach ( $bookings as &$booking ) {
		// if bookings is not empty, loop each booking and set hotel/room
			
			// set hotel
			$booking->hotel = $this->CI->Hotel->get_one( $booking->hotel_id );

			// set room
			$booking->room = $this->CI->Room->get_one( $booking->room_id );
		}

		$data['bookings'] = $bookings;

		$this->CI->load->view( $this->template_path .'/components/bookings/booking_list', $data );
	}
}