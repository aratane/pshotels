<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for About
 */
class Hotels extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Hotel' );		
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize category object
		$this->ps_adapter->convert_hotel( $obj );
	}

	/**
	 * Get hotel features
	 */
	function features_get()
	{
		// get either room or hotel id
        $city_id = $this->get( 'city_id' );
        $hotel_id = $this->get( 'hotel_id' );

        //  condition
        $conds = array();
        if ( $city_id ) {
        // filter by room if room exist

        	$conds = array( 'city_id' => $city_id );
        } else {
        // filter by hotel

        	$conds = array( 'hotel_id' => $hotel_id );
        }

		// get other hotel informations
		$infos = $this->HotelInfo->get_type_and_group( $conds )->result();
	

		// get draft format
		$info_grps = array();
		if ( !empty( $infos )) foreach( $infos as $info ) {
			$info_grps[$info->hinfo_grp_id][] = $info->hinfo_typ_id;		
		}

		// pretty format
		$response = array();
		if ( !empty( $info_grps )) foreach ( $info_grps as $grp => $type ) {

			$obj = $this->HotelInfoGroup->get_one( $grp );
			$obj->default_photo = $this->ps_adapter->get_default_photo( $obj->hinfo_grp_id, 'hinfo_grp');


			if( $hotel_id != "" ) {
				$obj->hinfo_parent_id = $hotel_id;
			}

			if( $city_id != "" ) {
				$obj->hinfo_parent_id = $city_id;
			}


			if ( !empty( $type )) foreach ( $type as $typ ) {
				
				$tmp_types = $this->HotelInfoType->get_one( $typ );
				
				if( $hotel_id != "" ) {
					$tmp_types->hinfo_parent_id = $hotel_id;
				} 

				if( $city_id != "" ) {
					$tmp_types->hinfo_parent_id = $city_id;
				}

				
				$obj->types[] = $tmp_types;
				
			}

			
			$response[] = $obj;
		}

		$this->custom_response( $response, false );
	}

	/**
	 * Get the maxinum price
	 */
	function max_price_get()
	{
		$obj = new stdClass;

		// get maximum price
		$obj->max_price = $this->Hotel->get_max_price()->max_price;

		// get currency symbol
		$about = $this->About->get_one('abt1');

		// get currecnty symbol
		$obj->currency_symbol = $about->currency_symbol;

		// get currency symbol
		$obj->currency_short_form = $about->currency_short_form;

		$this->custom_response( $obj, false );
	}
}