<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Authentication
 */
class PS_Adapter {

	// codeigniter instance
	protected $CI;

	// login user
	protected $login_user_id;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();
		$this->CI->load->library( 'PS_Dummy' );
	}

	/**
	 * Sets the login user.
	 */
	function set_login_user_id( $user_id )
	{
		$this->login_user_id = $user_id;
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
		// if there are images for news,
			
			$default_photo = $img[0];
		} else {
		// if no image, return empty object

			$default_photo = $this->CI->Image->get_empty_object();
		}

		return $default_photo;
	}

	/**
	 * Convert to standard hotel information group
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_hotel_info_group( &$obj )
	{
		$obj->types = $this->CI->HotelInfoType->get_all_by( array( 'hinfo_grp_id' => $obj->hinfo_grp_id ))->result();
	}

	/**
	 * Convert to standard room infomation group
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_room_info_group( &$obj )
	{
		$obj->types = $this->CI->RoomInfoType->get_all_by( array( 'rinfo_grp_id' => $obj->rinfo_grp_id ))->result();
	}

	/**
	 * Convert City object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_city( &$obj )
	{
		$obj->country = $this->CI->Country->get_one( $obj->country_id );
	}

	/**
	 * Convert city
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_hotel( &$obj )
	{
		// currency
		$about = $this->CI->About->get_one( 'abt1' );
		$obj->currency_symbol = $about->currency_symbol;
		$obj->currency_short_form = $about->currency_short_form;

		// default photos
		$obj->default_photo = $this->get_default_photo( $obj->hotel_id, 'hotel' );

		// promotions
		$promotions = $this->CI->RoomPromotion->get_all_by( array( 'hotel_id' => $obj->hotel_id, 'valid_date_only' => 1 ))->result();

		$obj->promotion = $this->CI->ps_dummy->get_dummy_promotion();

		if ( !empty( $promotions )) $obj->promotion = get_cheapest_promo( $promotions );

		// reviews
		$ratings = $this->CI->Review->get_ratings( array( 'hotel_id' => $obj->hotel_id ), true )->result();
		$obj->rating = $this->convert_rating( $ratings );

		// get other hotel informations
		$infos = $this->CI->HotelInfo->get_type_and_group( array( 'hotel_id' => $obj->hotel_id ))->result();

		$info_arr = array();
		if ( !empty( $infos )) {
		// if other info is not empty

			foreach ( $infos as $info ) {

				$info_grp_name = $this->CI->HotelInfoGroup->get_one( $info->hinfo_grp_id )->hinfo_grp_name;

				$info_arr[$info_grp_name][] = $this->CI->HotelInfoType->get_one( $info->hinfo_typ_id )->hinfo_typ_name;
			}
		}

		// create info class and assign the features
		$tmp_info = new stdClass;
		if ( !empty( $info_arr )) foreach( $info_arr as $key => $arr ) {

			$tmp_info->$key = $arr;
		}

		$obj->info = $tmp_info;

		// touch count
		$obj->touch_count =  $this->CI->HotelTouch->count_all_by( array( "hotel_id" => $obj->hotel_id ));

		// image count 
		$obj->image_count =  $this->CI->Image->count_all_by( array( "img_parent_id" => $obj->hotel_id ));

		//is_favourited checking
		if ( isset( $this->login_user_id )) {
		// if login user is existed,
			$conds = array( "user_id" => $this->login_user_id, "hotel_id" => $obj->hotel_id );

			$tmp_obj = $this->CI->Favourite->get_all_by( $conds )->result();
			
			$obj->is_user_favourited = "true";			
			
			if (empty($tmp_obj)) {
				$obj->is_user_favourited = "false";				
			}
			
		} else {

			$obj->is_user_favourited = "false";			
		}
	}

	/**
	 * Convert to standard hotel info object
	 */
	function convert_hotel_info( $obj )
	{
		
	}

	/**
	 * Convert Room Object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_room( &$obj )
	{
		// touch count
		$obj->touch_count =  $this->CI->RoomTouch->count_all_by( array( "room_id" => $obj->room_id ));

		// image count 
		$obj->image_count =  $this->CI->Image->count_all_by( array( "img_parent_id" => $obj->room_id ));

		// currency
		$about = $this->CI->About->get_one( 'abt1' );
		$obj->currency_symbol = $about->currency_symbol;
		$obj->currency_short_form = $about->currency_short_form;

		// default photos
		$obj->default_photo = $this->get_default_photo( $obj->room_id, 'room' );

		// promotions
		$promotions = $this->CI->RoomPromotion->get_all_by( array( 'room_id' => $obj->room_id, 'valid_date_only' => 1 ))->result();

		$obj->promotion = $this->CI->ps_dummy->get_dummy_promotion();
		if ( !empty( $promotions )) $obj->promotion = get_cheapest_promo( $promotions );

		// reviews
		$ratings = $this->CI->Review->get_ratings( array( 'room_id' => $obj->room_id ), true )->result();
		$obj->rating = $this->convert_rating( $ratings );

		// get other room information
		$infos = $this->CI->RoomInfo->get_type_and_group( array( 'room_id' => $obj->room_id ))->result();

		$info_arr = array();
		if ( !empty( $infos )) {
		// if other info is not empty
			foreach ( $infos as $info ) {

				$info_grp_name = $this->CI->RoomInfoGroup->get_one( $info->rinfo_grp_id )->rinfo_grp_name;

				$info_arr[$info_grp_name][] = $this->CI->RoomInfoType->get_one( $info->rinfo_typ_id )->rinfo_typ_name;
			}
		}

		// create info class and assign the features
		$tmp_info = new stdClass;
		if ( !empty( $info_arr )) foreach( $info_arr as $key => $arr ) {

			$tmp_info->$key = $arr;
		}

		$obj->info = $tmp_info;
	}

	/**
	 * Customize comment object
	 *
	 * @param      <type>  $obj    The object
	 */

	function convert_comment( &$obj )
	{
		// category object
		if ( isset( $obj->user_id )) {

			$obj->user = $this->CI->User->get_one( $obj->user_id );
		
		}

		// comment count
	    $obj->comment_count = $this->CI->Comment->count_all_by(array("news_id" => $obj->news_id));

	}


	/**
	 * Customize user object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_user( &$obj )
	{

		// like count
	    $obj->like_count = $this->CI->Like->count_all_by(array("user_id" => $obj->user_id));

		// comment count
		$obj->comment_count =  $this->CI->Review->count_all_by(array("user_id" => $obj->user_id));

		// fav count
		$obj->favourite_count =  $this->CI->Favourite->count_all_by(array("user_id" => $obj->user_id));

	}

	/**
	 * Customize about object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_about( &$obj )
	{
		// set default photo
		$obj->default_photo = $this->get_default_photo( $obj->about_id, 'about' );

	}

	/**
	 * Convert to standard review object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_review( &$obj ,$extra_fields = array() )
	{
		if ( isset( $obj->added_date )) {
			
			// added_date timestamp string
			$obj->added_date_str = ago( $obj->added_date );
		}

		// room name
		$obj->room_name= $this->CI->Room->get_one( $obj->room_id )->room_name;

		// user object
		$user = $this->CI->User->get_one( $obj->user_id );
		$this->convert_user( $user );
		$obj->user = $user;

		// rating object
		$ratings = $this->CI->Review->get_ratings( array( 'review_id' => $obj->review_id ), $is_rating_only = true)->result();
		$obj->rating= $this->convert_rating( $ratings );
		
		// Add extra fields
		if ( !empty( $extra_fields )) foreach ( $extra_fields as $key => $value ) {

			$obj->{$key} = $value;
		}
	}

	/**
	 * Convert to standrad rating object
	 *
	 * @param      <type>  $ratings  The ratings
	 */
	function convert_rating( $ratings )
	{
		if ( empty( $ratings ) || $ratings[0]->final_rating == 0 ) {
		// if rating is empty or rating is zero,

			return  $this->CI->ps_dummy->get_dummy_rating();
		}

		// return standard rating object
		$rating = new stdClass;
		$rating->final_rating = number_format( round( $ratings[0]->final_rating, 1), 1);
		$rating->rating_text = get_rating_text( $rating->final_rating );
		$rating->review_count = $ratings[0]->review_count;

		return $rating;
	}

	/**
	 * Convert standard review category with rating
	 *
	 * @param      <type>  $obj    The object
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function convert_review_category_rating( &$obj, $extra_fields = array())
	{
		// get review category
		$cat_rating = $this->CI->ReviewCategory->get_one( $obj->rvcat_id );

		// standard review category object
		$rating = new stdClass;
		$rating->final_rating = number_format( round( $obj->final_rating, 1), 1);
		$rating->rating_text = get_rating_text( $rating->final_rating );
		$rating->review_count = 0;

		$cat_rating->rating = $rating;

		// Add extra fields
		if ( !empty( $extra_fields )) foreach ( $extra_fields as $key => $value ) {

			$cat_rating->{$key} = $value;
		}

		$obj = $cat_rating;
	}

	/**
	 * Convert to review rating object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_review_rating( &$obj )
	{
		$obj->rvcat_name = $this->CI->ReviewCategory->get_one( $obj->rvcat_id )->rvcat_name;
	}

	/**
	 * Convert to standard promotion object
	 *
	 * @param      <type>  $obj    The object
	 */
	function convert_promotion( &$obj )
	{
		// get all promoted rooms
		$promo_rooms = $this->CI->RoomPromotion->get_all_by( array( 'promo_id' => $obj->promo_id ))->result();

		// get room ids
		$room_ids = array();
		if ( !empty( $promo_rooms )) foreach ( $promo_rooms as $promo_room ) {
			$room_ids[] = $promo_room->room_id;
		}
		$room_ids = array_unique( $room_ids );

		// get hotel ids
		$hotel_ids = array();
		foreach ( $room_ids as $room_id ) {
			$hotel_ids[] = $this->CI->Room->get_one( $room_id )->hotel_id;
		}
		$hotel_ids = array_unique( $hotel_ids );

		// convert all hotels
		$hotels = array();
		foreach ( $hotel_ids as $hotel_id ) {

			$hotel = $this->CI->Hotel->get_one( $hotel_id );
			$this->convert_hotel( $hotel );
			$hotels[] = $hotel;
		}

		// assign hotels
		$obj->hotels = $hotels;
	}

	/**
	 * Convert standard Booking Object
	 * @param  booking object &$obj booking object
	 * @return booking object       booking object with update data
	 */
	function convert_booking( &$obj )
	{
		// get hotel object, add 'added date' and convert std hotel
		$hotel = $this->CI->Hotel->get_one( $obj->hotel_id );
		$hotel->added_date_str = ago( $hotel->added_date );
		$this->convert_hotel( $hotel );
		$obj->hotel = $hotel;

		// get room object, add 'added date' and convert std room
		$room = $this->CI->Room->get_one( $obj->room_id );
		$room->added_date_str = ago( $room->added_date );
		$this->convert_room( $room );
		$obj->room = $room;
	}
}