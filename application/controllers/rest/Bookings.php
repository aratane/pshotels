<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Booking
 */
class Bookings extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Booking' );	
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize category object
		$this->ps_adapter->convert_booking( $obj );
	}

	/**
	 * Add Booking
	 */
	function add_post()
	{
		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'hotel_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'room_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'booking_start_date',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'booking_end_date',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'booking_user_name',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'booking_user_email',
	        	'rules' => 'required|valid_email'
	        ),
	        array(
	        	'field' => 'booking_user_phone',
	        	'rules' => 'required'
	        )
        );

		// get the post data
		$data = $this->post();

		if ( !$this->Booking->save( $data )) {
		// if error in saving booking,
			
			$this->error_response( get_msg( 'err_model' ));
		}

		// get booking, hotel and room object
		if ( !send_booking_request_email( $data['booking_id'] )) {

			$this->error_response( get_msg( 'err_email_not_send' ));
		}
		
		$obj = $this->Booking->get_one( $data['booking_id'] );

		$this->ps_adapter->convert_booking( $obj );

		$this->custom_response( $obj );
	}
}