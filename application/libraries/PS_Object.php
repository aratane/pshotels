<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * PanaceaSoft Core Objects
 */
class PS_Object {

	// codeigniter instance
	protected $CI;

	/**
	 * Load CI Instances
	 */
	function __construct()
	{
		// get CI instance
		$this->CI =& get_instance();
	}

	/**
	 * Assign Country
	 */
	function get_city_object()
	{

	}

	function get_hotel_object()
	{

	}

	function get_room_object()
	{

	}
}