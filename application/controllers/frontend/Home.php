<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Front End Controller
 */
class Home extends FE_Controller {

	protected $current_user;

	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct( NO_AUTH_CONTROL, 'HOME' );

		if ( $this->ps_auth->is_logged_in()){
		// if there is logged in user,

			$this->current_user = $this->ps_auth->get_user_info();
		}

		$this->data['meta_type'] = "website";
	}

	/**
	 * Home Page
	 */
	function home()
	{
		$this->data['action_title'] = "Home";
		$this->data['meta_title'] = get_app_config( 'seo_title' );
		$this->data['meta_desc'] = get_app_config( 'seo_description' );
		$this->data['meta_keywords'] = get_app_config( 'seo_keywords' );
		$this->load_template( 'home' );
	}

	/**
	 * Popular Cities
	 */
	function popular_cities()
	{
		$this->data['action_title'] = "Popular Cities";

		$limit = $this->config->item( 'popular_city_display_limit' );
		$conds = array( 'popular' => 1 );
		$cities = $this->City->get_all_by( $conds, $limit )->result();
		if ( !empty( $cities )) {
			foreach ( $cities as $city ) {
				$city->default_photo = $this->ps_widget->get_default_photo( $city->city_id, 'city' );
			}
		}
		$this->data['popular_cities'] = $cities;

		$this->data['limit'] = $limit;
		$this->data['total_cities'] = $this->City->count_all_by( $conds );

		$this->load_template( 'popular_cities' );
	}

	/**
	 * Popular Hotels
	 */
	function popular_hotels()
	{
		$this->data['action_title'] = "Popular Hotels";

		$limit = $this->config->item( 'popular_hotel_display_limit' );
		$conds = array( "popular" => 1 );
		$hotels = $this->Hotel->get_all_by( $conds, $limit )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as $hotel ) {
				$hotel->default_photo = $this->ps_widget->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->Country->get_one( $city->country_id )->country_name;

				// get final rating 
				$ratings = $this->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$this->data['popular_hotels'] = $hotels;

		$this->data['limit'] = $limit;
		$this->data['total_hotels'] = $this->Hotel->count_all_by( $conds );

		$this->load_template( 'popular_hotels' );
	}

	/**
	 * Promotion Hotels
	 */
	function promotions()
	{
		$this->data['action_title'] = "Promotion Hotels";

		$limit = $this->config->item( 'promotion_hotel_display_limit' );
		$conds = array( "promotion_only" => 1 );
		$hotels = $this->Hotel->get_all_by( $conds, $limit )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as $hotel ) {
				$hotel->default_photo = $this->ps_widget->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->Country->get_one( $city->country_id )->country_name;

				// get final rating 
				$ratings = $this->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;

				// get promotions
				$promotions = $this->RoomPromotion->get_all_by( array( 'hotel_id' => $hotel->hotel_id, 'valid_date_only' => 1 ))->result();
				if ( !empty( $promotions )) {
					$hotel->promotion = $promotions[0];
				}
			}
		}

		$this->data['promotion_hotels'] = $hotels;

		$this->data['limit'] = $limit;
		$this->data['total_hotels'] = $this->Hotel->count_all_by( $conds );

		$this->load_template( 'promotion_hotels' );
	}

	/**
	 * Recommended Hotels
	 */
	function recommended_hotels()
	{
		$this->data['action_title'] = "Recommended Hotels";

		$limit = $this->config->item( 'recommended_hotel_display_limit' );
		$conds = array( "is_recommended" => 1 );
		$hotels = $this->Hotel->get_all_by( $conds, $limit )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as $hotel ) {
				$hotel->default_photo = $this->ps_widget->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->Country->get_one( $city->country_id )->country_name;

				// get final rating 
				$ratings = $this->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$this->data['recommended_hotels'] = $hotels;

		$this->data['limit'] = $limit;
		$this->data['total_hotels'] = $this->Hotel->count_all_by( $conds );

		$this->load_template( 'recommended_hotels' );
	}

	/**
	 * Popular Rooms
	 */
	function popular_rooms()
	{
		$this->data['action_title'] = "Popular Rooms";

		$limit = $this->config->item( 'popular_room_display_limit' );
		$conds = array( "popular" => 1 );
		$rooms = $this->Room->get_all_by( $conds, $limit )->result();

		if ( !empty( $rooms )) {
			foreach ( $rooms as $room ) {
				
				// set more info
				$this->ps_widget->set_more_info( $room );
			}
		}

		$this->data['popular_rooms'] = $rooms;

		$this->data['limit'] = $limit;
		$this->data['total_rooms'] = $this->Room->count_all_by( $conds );

		$this->load_template( 'popular_rooms' );
	}

	/**
	 * Error Page
	 */
	function error()
	{
		$this->data['action_title'] = "Error | 404 Not Found";
		$this->load_template( 'not_found' );
	}

	/**
	 * City (hotel list ) Page
	 */
	function city( $city_id = false )
	{
		$limit = $this->config->item( 'hotel_display_limit' );
		$offset = 0;

		if ( $city_id ) {
		// if city id is passed,

			$city = $this->City->get_one( $city_id );
		} else if ( $this->is_POST()) {
		// get city id if search
			
			$city_id = $this->get_data( 'city_id' );
			$city = $this->City->get_one( $city_id );
		} else {
		// get the first city

			$city = $this->City->get_all()->result()[0];
		}

		// get other infos
		$this->ps_widget->set_more_info( $city );

		// get all hotels
		$hotels = $this->Hotel->get_all_by( array( 'city_id' => $city->city_id ), $limit, $offset )->result();

		// set more hotel info
		foreach ( $hotels as $hotel ) {

			$this->ps_widget->set_more_info( $hotel );
		}

		// set the page title		
		$this->data['action_title'] = $city->city_name;
		$this->data['city'] = $city;
		$this->data['hotels'] = $hotels;
		$this->data['hotels_count'] = $this->Hotel->count_all_by( array( 'city_id' => $city->city_id ));
		$this->data['hotels_limit'] = $limit;

		$this->load_template( 'city' );
	}

	/**
	 * Hotel (room list ) page
	 *
	 * @param      boolean  $hotel_id  The hotel identifier
	 */
	function hotel( $hotel_id )
	{
		// touch hotel
		$user_id = ( $this->ps_auth->is_logged_in())? $this->ps_auth->get_user_info()->user_id: "0";
		$hotel_touch = array( 'hotel_id' => $hotel_id, 'user_id' => $user_id );
		$this->HotelTouch->save( $hotel_touch );

		// get hotel
		$hotel = $this->Hotel->get_one( $hotel_id );

		// set more info
		$this->ps_widget->set_more_info( $hotel );

		// get rooms
		$rooms = $this->Room->get_all_by( array( 'hotel_id' => $hotel_id ))->result();

		// set more room info
		foreach ( $rooms as $room ) {

			$this->ps_widget->set_more_info( $room );
		}

		// pass data
		$this->data['action_title'] = $hotel->hotel_name;
		$this->data['hotel'] = $hotel;
		$this->data['rooms'] = $rooms;

		// load tempaltes
		$this->load_template( 'hotel' );
	}

	/**
	 * Room Page
	 *
	 * @param      boolean  $room_id  The room identifier
	 */
	function room( $room_id )
	{
		// touch hotel
		$user_id = ( $this->ps_auth->is_logged_in())? $this->ps_auth->get_user_info()->user_id: "0";
		$room_touch = array( 'room_id' => $room_id, 'user_id' => $user_id );
		$this->RoomTouch->save( $room_touch );

		// get room
		$room = $this->Room->get_one( $room_id );

		// set more info
		$this->ps_widget->set_more_info( $room );

		// pass data
		$this->data['action_title'] = $room->room_name;
		$this->data['room'] = $room;

		// load template
		$this->load_template( 'room' );
	}

	/**
	 * User Profile
	 *
	 * @param      <type>  $user_id  The user identifier
	 */
	function profile( $user_id )
	{
		// get user info
		$user = $this->User->get_one( $user_id );

		$user->total_likes = $this->Like->count_all_by( array( 'user_id' => $user_id ));
		
		$user->total_comments = $this->Comment->count_all_by( array( 'user_id' => $user_id ));
		
		$user->total_favourites = $this->Favourite->count_all_by( array( 'user_id' => $user_id ));

		// pass data
		$this->data['action_title'] = $user->user_name;
		$this->data['user'] = $user;

		// load template
		$this->load_template( 'profile' );
	}

	/**
	 * Reset Password
	 *
	 * @param      boolean  $code   The code
	 */
	function reset( $code = false )
	{
		if ( !$code ) redirect( site_url());

		if ( !$this->ResetCode->exists( array( 'code' => $code ))) redirect( site_url());

		$this->data['action_title'] = "reset";
		$this->data['code'] = $code;
		$this->load_template( 'reset' );
	}

	/**
	 * Bookings List
	 */
	function bookings()
	{
		if ( !$this->ps_auth->is_logged_in()) redirect( site_url());

		$this->data['action_title'] = "My Booking List";

		$limit = $this->config->item( 'booking_list_display_limit' );
		$conds = array( "login_user_id" => $this->ps_auth->get_user_info()->user_id );
		
		$bookings = $this->Booking->get_all_by( $conds, $limit )->result();

		if ( !empty( $bookings )) foreach ( $bookings as &$booking ) {
		// if bookings is not empty, loop each booking and set hotel/room
			
			// set hotel
			$booking->hotel = $this->Hotel->get_one( $booking->hotel_id );

			// set room
			$booking->room = $this->Room->get_one( $booking->room_id );
		}

		$this->data['bookings'] = $bookings;

		$this->data['limit'] = $limit;
		$this->data['total_bookings'] = $this->Booking->count_all_by( $conds );

		$this->load_template( 'bookings' );
	}

	/**
	 * Booking
	 * @return [type] [description]
	 */
	function booking_detail( $booking_id )
	{
		if ( !$this->ps_auth->is_logged_in()) redirect( site_url());

		$this->data['action_title'] = "Booking Detail";

		$booking = $this->Booking->get_one( $booking_id );
		$booking->hotel = $this->Hotel->get_one( $booking->hotel_id );
		$booking->room = $this->Room->get_one( $booking->room_id );
		$booking->room->default_photo = get_default_photo( $booking->room_id, 'room' );

		$this->data['booking'] = $booking;

		$this->load_template( 'booking' );
	}
}