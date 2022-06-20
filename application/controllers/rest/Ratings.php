<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Ratings
 */
class Ratings extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Rating' );

		// set the validation rules for create and update
		$this->validation_rules();
	}

	/**
	 * Determines if valid input.
	 */
	function validation_rules()
	{
		// validation rules for create
		$this->create_validation_rules = array(
			array(
	        	'field' => 'news_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'rating_value',
	        	'rules' => 'required'
	        )
        );

        // $this->update_validation_rules = array();
        // $this->delete_validation_rules = array();
	}
}