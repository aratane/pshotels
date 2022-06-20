<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for promotions
 */
class Promotions extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Promotion' );		
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize promotion object
		$this->ps_adapter->convert_promotion( $obj );
	}
}