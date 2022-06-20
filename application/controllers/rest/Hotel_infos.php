<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Hotel Info
 */
class Hotel_infos extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'HotelInfo' );		
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize category object
		$this->ps_adapter->convert_hotel_info( $obj );
	}
}