<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Ratings
 */
class Likes extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Like' );

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
	        	'rules' => 'required|callback_id_check[NewsModel]'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required|callback_id_check[User]'
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
	        	'field' => 'news_id',
	        	'rules' => 'required|callback_id_check[NewsModel]'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required|callback_id_check[User]'
	        )
        );

		// validation
        if ( !$this->is_valid( $rules )) exit;

		$news_id = $this->post('news_id');
		$user_id = $this->post('user_id');

		// prep data
        $data = array( 'news_id' => $news_id, 'user_id' => $user_id );


		if ( $this->Like->exists( $data )) {

			if ( !$this->Like->delete_by( $data )) {
				
				$this->error_response( get_msg( 'err_model' ));
			}

		} else {

			if ( !$this->Like->save( $data )) {

				$this->error_response( get_msg( 'err_model' ));
			}

		}

		$obj = new stdClass;
		$obj->news_id = $news_id;
		$news = $this->NewsModel->get_one( $obj->news_id );
		
		$this->ps_adapter->convert_news( $news );

		$this->custom_response( $news );

	}
}