<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Dummy Data
 */
class PS_Dummy {

	// codeigniter instance
	protected $CI;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();
	}

	/**
	 * Gets the dummy country.
	 *
	 * @return     <type>  The dummy country.
	 */
	function get_dummy_country()
	{
		$country = $this->CI->Country->get_empty_object();

		$country->country_name = "dummy country";

		return $country;
	}

	/**
	 * Gets the dummy city.
	 *
	 * @return     <type>  The dummy city.
	 */
	function get_dummy_city()
	{
		$city = $this->CI->City->get_empty_object();

		$city->city_name = "dummy city";

		return $city;
	}

	/**
	 * Gets the dummy hotel.
	 *
	 * @return     <type>  The dummy hotel.
	 */
	function get_dummy_hotel()
	{
		$hotel = $this->CI->Hotel->get_empty_object();

		$hotel->hotel_name = "dummy hotel";
		$hotel->city_name = "dummy city";
		$hotel->country_name = "dummy country";

		return $hotel;
	}

	/**
	 * Gets the dummy room.
	 */
	function get_dummy_room()
	{
		$room = $this->CI->Room->get_empty_object();

		$room->room_name = "dummy room";
		$room->hotel = $this->get_dummy_hotel();
		$room->city = $this->get_dummy_city();
		$room->country = $this->get_dummy_country();
		$room->room_size = "12ft/32ft";
		$room->room_no_of_beds = "2";
		$room->room_adult_limit = "2";
		$room->room_kid_limit = "1";
		$room->capacity = "0 adults";

		return $room;
	}

	/**
	 * Gets the dummy rating.
	 *
	 * @return     stdClass  The dummy rating.
	 */
	function get_dummy_rating()
	{
		$rating = new stdClass;
		$rating->final_rating = 0;
		$rating->rating_text = "No Rating";
		$rating->review_count = 0;
		$rating->is_empty_object = 1;

		return $rating;
	}

	/**
	 * Gets the dummy promotion.
	 *
	 * @return     <type>  The dummy promotion.
	 */
	function get_dummy_promotion()
	{
		$tmp_promotion = $this->CI->RoomPromotion->get_empty_object();
		
		$tmp_promotion->promo_name = "";
		$tmp_promotion->promo_desc = "";
		$tmp_promotion->promo_percent = "";
		$tmp_promotion->promo_start_time = "";
		$tmp_promotion->promo_end_time = "";
		$tmp_promotion->added_date = "";
		

		$promotion = $tmp_promotion;
		
		//$promotion = $this->CI->RoomPromotion->get_empty_object();
		return $promotion;
	}

	/**
	 * Gets the dummy photo.
	 *
	 * @return     <type>  The dummy photo.
	 */
	function get_dummy_photo()
	{
		$img = $this->CI->Image->get_empty_object();

		$img->img_path = "default_city.jpeg";

		return $img;
	}

	/**
	 * Get dummy booking
	 * @return [type] [description]
	 */
	function get_dummy_booking()
	{
		$booking = $this->CI->Booking->get_empty_object();

		$booking->hotel = $this->get_dummy_hotel();

		$booking->room = $this->get_dummy_room();

		return $booking;
	}
}