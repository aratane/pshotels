<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Ratings
 */
class Favourites extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Favourite' );

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
	        	'field' => 'hotel_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        )
        );
	}

	/**
	* When user press like button from app
	*/
	function press_post() 
	{

		// validation rules for create
		$rules = array(
			array(
	        	'field' => 'hotel_id',
	        	'rules' => 'required|callback_id_check[Hotel]'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required|callback_id_check[User]'
	        )
        );

		// validation
        if ( !$this->is_valid( $rules )) exit;

		$hotel_id = $this->post('hotel_id');
		$user_id = $this->post('user_id');

		// prep data
        $data = array( 'hotel_id' => $hotel_id, 'user_id' => $user_id );


		if ( $this->Favourite->exists( $data )) {

			if ( !$this->Favourite->delete_by( $data )) {
				
				$this->error_response( get_msg( 'err_model' ));
			}

		} else {

			if ( !$this->Favourite->save( $data )) {

				$this->error_response( get_msg( 'err_model' ));
			}

		}

		$obj = new stdClass;
		$obj->hotel_id = $hotel_id;
		$hotel = $this->Hotel->get_one( $obj->hotel_id );
		
		$this->ps_adapter->convert_hotel( $hotel );

		$this->custom_response( $hotel );

	}


}