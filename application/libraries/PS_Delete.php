<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Database Trigger
 */
class PS_Delete {

	// codeigniter instance
	protected $CI;

	/**
	 * Constructor
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();

		// load image library
		$this->CI->load->library( 'PS_Image' );
	}

	/**
	 * Delete Country and delete cify if trigger enable
	 *
	 * @param      <type>   $country_id      The country identifier
	 * @param      boolean  $enable_trigger  The enable trigger
	 */
	function delete_country( $country_id, $enable_trigger = false ) 
	{

		if ( !$this->CI->Country->delete( $country_id )) {
		// false if error in deleting country

			return false;
		}

		$conds = array( 'img_type' => 'country', 'img_parent_id' => $country_id );
		if ( !$this->CI->delete_images_by( $conds )) {
		// false if error in deleting image, 

			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete city data

			if ( ! $this->delete_country_trigger( $country_id )) {
			// if error in deleteing city data

				return false;
			}
		}

		return true;
	}

	/**
	 * Delete the Shop Tags
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_user_hotel( $user_id )
	{		
		$conds = array( 'user_id' => $user_id );
		if ( ! $this->CI->User_hotel->delete_by( $conds )) {
		// if there is an error in deleting Product,
			return false;
		}
	}

	/**
	 * Delete City only
	 *
	 * @param      <type>   $city_id         The city identifier
	 */
	function delete_city( $city_id ) 
	{
		if ( !$this->CI->City->delete( $city_id )) {
		// false if error in deleting country

			return false;
		}

		$conds = array( 'img_type' => 'city', 'img_parent_id' => $city_id );
		if ( !$this->CI->delete_images_by( $conds )) {
		// false if error in deleting image, 

			return false;
		}

		return true;
	}

	/**
	 * Delete Hotel, delete rooms if trigger enable
	 *
	 * @param      <type>   $hotel_id        The hotel identifier
	 * @param      boolean  $enable_trigger  The enable trigger
	 */
	function delete_hotel( $hotel_id, $enable_trigger = false ) 
	{
		if ( !$this->CI->Hotel->delete( $hotel_id )) {
		// false if error in deleting hotel

			return false;
		}

		if ( !$this->CI->HotelInfo->delete_by( array( 'hotel_id' => $hotel_id ))) {
		// false if error in deleting hotel related information,

			return false;
		}

		$conds = array( 'img_type' => 'hotel', 'img_parent_id' => $hotel_id );
		if ( !$this->CI->delete_images_by( $conds )) {
		// false if error in deleting image, 

			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete room data

			if ( ! $this->delete_hotel_trigger( $hotel_id )) {
			// if error in deleteing room and rooms related data

				return false;
			}
		}

		return true;
	}

	/**
	 * Delete the category and image under the category
	 *
	 * @param      <type>  $id     The identifier
	 */
	function delete_user( $user_id )
	{		
		if ( ! $this->CI->User->delete( $user_id )) {
		// if there is an error in deleting user,
			
			return false;
		}

		if ( !$this->CI->User_hotel->delete_by( array( 'user_id' => $user_id ))) {
		// false if error in deleting hotel related information,

			return false;
		}

		return true;
	}

	/**
	 * Delete room, delete rooms related information if tigger enable
	 *
	 * @param      <type>   $room_id         The room identifier
	 * @param      boolean  $enable_trigger  The enable trigger
	 */
	function delete_room( $room_id, $enable_trigger = false ) 
	{
		if ( !$this->CI->Room->delete( $room_id )) {
		// false if error in deleting room

			return false;
		}

		if ( !$this->CI->RoomInfo->delete_by( array( 'room_id' => $room_id ))) {
		// false if error in deleting room related information,

			return false;
		}

		$conds = array( 'img_type' => 'room', 'img_parent_id' => $room_id );
		if ( !$this->CI->delete_images_by( $conds )) {
		// false if error in deleting image, 

			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete city data

			if ( ! $this->delete_room_trigger( $room_id )) {
			// if error in deleteing room related data

				return false;
			}
		}

		return true;
	}

	/**
	 * Delete promotions
	 *
	 * @param      <type>  $promo_id  The promotion identifier
	 */
	function delete_promotion( $promo_id ) 
	{
		if ( !$this->CI->Promotion->delete( $promo_id )) {
		// false if error in deleting hotel

			return false;
		}

		if ( !$this->CI->RoomPromotion->delete_by( array( 'promo_id' => $promo_id ))) {
		// false if error in deleting promoted rooms,

			return false;
		}

		return true;
	}

	/**
	 * Delete Hotel information Group
	 *
	 * @param      <type>   $hinfo_grp_id    The hinfo group identifier
	 * @param      boolean  $enable_trigger  The enable trigger
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function delete_hotel_info_group( $hinfo_grp_id, $enable_trigger = false )
	{
		if ( !$this->CI->HotelInfoGroup->delete( $hinfo_grp_id )) {
		// false if error in deleting hotel information group

			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete information types

			if ( ! $this->delete_hotel_info_group_trigger( $hinfo_grp_id )) {
			// if error in deleteing hotel information types

				return false;
			}
		}

		return true;
	}

	/**
	 * Delete Hotel Information Type
	 *
	 * @param      <type>   $hinfo_typ_id  The hinfo typ identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function delete_hotel_info_type( $hinfo_typ_id )
	{
		if ( !$this->CI->HotelInfoType->delete( $hinfo_typ_id )) {
		// false if error in deleting hotel information type

			return false;
		}

		return true;
	}

	/**
	 * Delete room Information group
	 *
	 * @param      <type>   $rinfo_grp_id    The rinfo group identifier
	 * @param      boolean  $enable_trigger  The enable trigger
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function delete_room_info_group( $rinfo_grp_id, $enable_trigger = false )
	{
		if ( !$this->CI->RoomInfoGroup->delete( $rinfo_grp_id )) {
		// false if error in deleting room information group

			return false;
		}

		if ( $enable_trigger ) {
		// if execute_trigger is enable, trigger to delete information types

			if ( ! $this->delete_room_info_group_trigger( $rinfo_grp_id )) {
			// if error in deleteing room information types

				return false;
			}
		}

		return true;
	}

	/**
	 * Delete Room Information Type
	 *
	 * @param      <type>   $rinfo_typ_id  The rinfo typ identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function delete_room_info_type( $rinfo_typ_id )
	{
		if ( !$this->CI->RoomInfoType->delete( $rinfo_typ_id )) {
		// false if error in deleting room information type

			return false;
		}

		return true;
	}

	/**
	 * Delete city information
	 *
	 * @param      <type>  $country_id  The country identifier
	 */
	function delete_country_trigger( $country_id ) 
	{
		// get all cities including status 1 or 0
		$cities = $this->CI->City->get_all_by( array( 'country_id' => $country_id, 'no_status_filter' => 1 ))->result();

		if ( !empty( $cities )) {
		// if cities are not empty,

			foreach ( $cities as $city ) {
			// loop each city,
			
				if ( !$this->delete_city( $city->city_id )) {
				// if error in deleting,

					return false;
				}	
			}
		}

		return true;
	}

	/**
	 * Delete room information
	 *
	 * @param      <type>  $hotel_id  The hotel identifier
	 */
	function delete_hotel_trigger( $hotel_id )
	{
		// get all rooms including status 1 or 0
		$rooms = $this->CI->Room->get_all_by( array( 'hotel_id' => $hotel_id, 'no_status_filter' => 1 ))->result();

		if ( !empty( $rooms )) {
		// if rooms are not empty,

			foreach ( $rooms as $room ) {
			// loop each room

				$enable_trigger = true;

				if ( !$this->delete_room( $room->room_id, $enable_trigger )) {
				// if error in deleting room and room related data,

					return false;
				}
			}
		}

		return true;
	}

	/**
	 * Delete Room Related Information
	 *
	 * @param      <type>  $room_id  The room identifier
	 */
	function delete_room_trigger( $room_id )
	{
		$conds = array( 'room_id' => $room_id );

		// delete comments
		if ( !$this->CI->Comment->delete_by( $conds )) {

			return false;
		}		

		// delete favourites
		// if ( !$this->CI->Favourite->delete_by( $conds )) {

		// 	return false;
		// }

		// delete likes
		if ( !$this->CI->Like->delete_by( $conds )) {

			return false;
		}

		// delete touches
		if ( !$this->CI->RoomTouch->delete_by( $conds )) {

			return false;
		}

		return true;
	}

	/**
	 * Delete Hotel Info Group Trigger
	 *
	 * @param      <type>   $hinfo_grp_id  The hinfo group identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function delete_hotel_info_group_trigger( $hinfo_grp_id )
	{
		// get all hinfo_typs including status 1 or 0
		$hinfo_typs = $this->CI->HotelInfoType->get_all_by( array( 'hinfo_grp_id' => $hinfo_grp_id, 'no_status_filter' => 1 ))->result();

		if ( !empty( $hinfo_typs )) {
		// if hinfo_typs are not empty,

			foreach ( $hinfo_typs as $hinfo_typ ) {
			// loop each hinfo_typ,
			
				if ( !$this->delete_hotel_info_type( $hinfo_typ->hinfo_typ_id )) {
				// if error in deleting,

					return false;
				}	
			}
		}

		return true;
	}

	/**
	 * Delete Room Info Group Trigger
	 *
	 * @param      <type>   $rinfo_grp_id  The rinfo group identifier
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function delete_room_info_group_trigger( $rinfo_grp_id )
	{
		// get all rinfo_typs including status 1 or 0
		$rinfo_typs = $this->CI->RoomInfoType->get_all_by( array( 'rinfo_grp_id' => $rinfo_grp_id, 'no_status_filter' => 1 ))->result();

		if ( !empty( $rinfo_typs )) {
		// if rinfo_typs are not empty,

			foreach ( $rinfo_typs as $rinfo_typ ) {
			// loop each rinfo_typ,
			
				if ( !$this->delete_room_info_type( $rinfo_typ->rinfo_typ_id )) {
				// if error in deleting,

					return false;
				}	
			}
		}

		return true;
	}

	/**
	 * Delete Image by id and type
	 *
	 * @param      <type>  $conds  The conds
	 */
	function delete_images_by( $conds )
	{
		// get all images
		$images = $this->CI->Image->get_all_by( $conds );

		if ( !empty( $images )) {
		// if images are not empty,

			foreach ( $images->result() as $img ) {
			// loop and delete each image

				if ( ! $this->CI->ps_image->delete_images( $img->img_path ) ) {
				// if there is an error in deleting images

					return false;
				}
			}
		}

		if ( ! $this->CI->Image->delete_by( $conds )) {
		// if error in deleting from database,

			return false;
		}

		return true;
	}

	/**
	 * Delete Bookings
	 *
	 * @param      <type>  $booking_id  The booking identifier
	 */
	function delete_booking( $booking_id ) 
	{
		if ( !$this->CI->Booking->delete( $booking_id )) {
		// false if error in deleting hotel

			return false;
		}

		return true;
	}
}