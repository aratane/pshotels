<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for About
 */
class Countries extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Country' );		
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );
	}
}