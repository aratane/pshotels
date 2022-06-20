<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Ratings
 */
class Inquirys extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Inquiry' );

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
	        	'field' => 'inq_name',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'inq_desc',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'inq_user_name',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'inq_user_email',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'inq_user_phone',
	        	'rules' => 'required'
	        )
        );
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		if ( $this->is_add ) {

			$hotel_name = $this->Hotel->get_one( $obj->hotel_id )->hotel_name;

			$hotel_email = $this->Hotel->get_one( $obj->hotel_id )->hotel_email;

			$room_name = $this->Room->get_one( $obj->room_id )->room_name;

			$to = $hotel_email;

		    $subject = 'Inquiry Message';
			$msg = "<p>Hi ". $hotel_name .",</p>".
						"<p>You have recieved new inquiry message and more details at below :<br/>".

						"Title : ". $obj->inq_name ."<br>".
						"Description : ". $obj->inq_desc ."<br>".
						"Contact Name : ". $obj->inq_user_name ."<br>".
						"Contact Email : ". $obj->inq_user_email ."<br>".
						"Contact Phone : ". $obj->inq_user_phone ."<br><br>".

						"<p>Best Regards,<br/>". $this->config->item('sender_name') ."</p>";

			// send email from admin
			if ( ! $this->ps_mail->send_from_admin( $to, $subject, $msg ) ) {
				$this->error_response( get_msg( 'err_email_not_send' ));
			} else {
				$this->success_response( get_msg( 'success_inquiry_email_sent' ));
			}
			
			
			$this->success_response( get_msg( 'success_inquiry' ));
		}
	}	
}