<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Analytics Controller
 */
class Analytics extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'ANALYTICS' );
	}

	/**
	 * Analytics Index
	 */
	function index()
	{
		$data['action_title'] = '';

		$this->load_template( "analytics/view", $data );
	}

	/**
	 * City Analytic
	 */
	function city()
	{
		$data = array();

		// breadcrumb urls
		$data['action_title'] = get_msg( 'city_analytic' );

		// get all cities
		$cities = $this->City->get_all()->result();

		// get city total touches
		$cities_arr = array();
		foreach ( $cities as $city ) {
			$cities_arr[ $city->city_name ] = $this->HotelTouch->count_all_by( array( 'city_id' => $city->city_id ));
		}

		// get graph side bar title
		$graph_arr = array();
		foreach ( $cities_arr as $name => $count ) {
			$graph_arr[] = "['".$name."',".$count."]";
		}

		// sort the city array
		arsort($cities_arr);
		$pie_arr = array();
		$i = 0;
		foreach ( $cities_arr as $name => $count ) {
			if(($i++) < 5){
				$pie_arr[] = "['".$name."',".$count."]";
			}
		}

		$data['count'] = count( $cities );

		$data['graph_items'] = "[['Cities','Touches'],".implode(',',$graph_arr)."]";
		$data['pie_items'] = "[['Cities','Touches'],".implode(',',$pie_arr)."]";

		$this->load_template( "analytics/city", $data);
	}

	/**
	 * Hotel Analytic
	 */
	function hotel()
	{
		$data = array();

		// breadcrumb urls
		$data['action_title'] = get_msg( 'hotel_analytic' );

		$city_id = "";

		// prepare city_id
		if ( $this->has_data( 'city_id' )) {
			$data['city_id'] = $this->get_data( 'city_id' );
			$city_id = $this->get_data( 'city_id' );
		}
		
		// get all hotels
		$hotels = $this->Hotel->get_all_by( $data )->result();

		// get hotel total touches
		$hotels_arr = array();
		foreach ( $hotels as $hotel ) {
			$hotels_arr[ $hotel->hotel_name ] = $this->HotelTouch->count_all_by( array( 'hotel_id' => $hotel->hotel_id ));
		}
		
		// get graph side bar title
		$graph_arr = array();
		foreach ( $hotels_arr as $name => $count ) {
			$graph_arr[] = "['".$name."',".$count."]";
		}
		
		// sort the hotel array
		arsort($hotels_arr);
		$pie_arr = array();
		$i = 0;
		foreach ( $hotels_arr as $name => $count ) {
			if(($i++) < 5){
				$pie_arr[] = "['".$name."',".$count."]";
			}
		}
		
		$data['count'] = count( $hotels );

		$data['graph_items'] = "[['Hotels','Touches'],".implode(',',$graph_arr)."]";
		$data['pie_items'] = "[['Hotels','Touches'],".implode(',',$pie_arr)."]";
		
		$this->load_template( "analytics/hotel", $data);
	}

	/**
	 * Room Analytic
	 */
	function room() 
	{

		$data = array();

		// breadcrumb urls
		$data['action_title'] = get_msg( 'room_analytic' );

		$hotel_id = "";

		// prepare hotel_id
		if ( $this->has_data( 'hotel_id' )) {
			$data['hotel_id'] = $this->get_data( 'hotel_id' );
			$hotel_id = $this->get_data( 'hotel_id' );
		}
		
		// get all rooms
		$rooms = $this->Room->get_all_by( $data )->result();

		// get room total touches
		$rooms_arr = array();
		foreach ( $rooms as $room ) {
			$rooms_arr[ $room->room_name ] = $this->RoomTouch->count_all_by( array( 'room_id' => $room->room_id ));
		}
		
		// get graph side bar title
		$graph_arr = array();
		foreach ( $rooms_arr as $name => $count ) {
			$graph_arr[] = "['".$name."',".$count."]";
		}
		
		// sort the room array
		arsort($rooms_arr);
		$pie_arr = array();
		$i = 0;
		foreach ( $rooms_arr as $name => $count ) {
			if(($i++) < 5){
				$pie_arr[] = "['".$name."',".$count."]";
			}
		}
		
		$data['count'] = count( $rooms );
		$data['hotel_name'] = $this->Hotel->get_one( $hotel_id )->hotel_name;

		$data['graph_items'] = "[['Rooms','Touches'],".implode(',',$graph_arr)."]";
		$data['pie_items'] = "[['Rooms','Touches'],".implode(',',$pie_arr)."]";
		
		$this->load_template( "analytics/room", $data);
	}
}