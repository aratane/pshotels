<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Main Controller for API classes
 */
class API_Controller extends REST_Controller
{
	// model to access database
	protected $model;

	// validation rule for new record
	protected $create_validation_rules;

	// validation rule for update record
	protected $update_validation_rules;

	// validation rule for delete record
	protected $delete_validation_rules;

	// is adding record?
	protected $is_add;

	// is updating record?
	protected $is_update;

	// is deleting record?
	protected $is_delete;

	// login user id API parameter key name
	protected $login_user_key;

	// login user id
	protected $login_user_id;

	// if API allowed zero login user id,
	protected $is_login_user_nullable;

	// default value to ignore user id
	protected $ignore_user_id;

	/**
	 * construct the parent 
	 */
	function __construct( $model, $is_login_user_nullable = false )
	{
		// header('Access-Control-Allow-Origin: *');
    	// header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");

		parent::__construct();

		// set the model object
		$this->model = $this->{$model};

		// load security library
		$this->load->library( 'PS_Security' );

		// load the adapter library
		$this->load->library( 'PS_Adapter' );
		
		// set the login user nullable
		$this->is_login_user_nullable = $is_login_user_nullable;

		// login user id key
		$this->login_user_key = "login_user_id";

		// default value to ignore user id for API
		$this->ignore_user_id = "nologinuser";

		if ( $this->is_logged_in()) {
		// if login user id is existed, pass the id to the adapter

			$this->login_user_id = $this->get_login_user_id();

			if ( !$this->User->is_exist( $this->login_user_id ) && !$this->is_login_user_nullable ) {
			// if login user id not existed in system,

				$this->error_response( get_msg( 'invalid_login_user_id' ));
			}

			$this->ps_adapter->set_login_user_id( $this->login_user_id );
		}

		// load the mail library
		$this->load->library( 'PS_Mail' );

		if ( ! $this->is_valid_api_key()) {
		// if invalid api key

			$this->response( array(
				'status' => 'error',
				'message' => get_msg( 'invalid_api_key' )
			), 404 );
		}

		// default validation rules
		$this->default_validation_rules();
	}

	/**
	 * Determines if logged in.
	 *
	 * @return     boolean  True if logged in, False otherwise.
	 */
	function is_logged_in()
	{
		// it is login user if the GET login_user_id is not null and default key
		// it is login user if the POST login_user_id is not null
		// it is login user if the PUT login_user_id is not null
		return ( $this->get( $this->login_user_key ) != null && $this->get( $this->login_user_key ) != $this->ignore_user_id ) ||
			( $this->post( $this->login_user_key ) != null ) ||
			( $this->put( $this->login_user_key ) != null ) ;
	}

	/**
	 * Gets the login user identifier.
	 */
	function get_login_user_id()
	{
		/**
		 * GET['login_user_id'] will create POST['user_id']
		 * POST['login_user_id'] will create POST['user_id'] and remove POST['login_user_id']
		 * PUT['login_user_id'] will create PUT['user_id'] and remove PUT['login_user_id']
		 */
		// if exist in get variable,
		if ( $this->get( $this->login_user_key ) != null) {

			// get user id
			$login_user_id = $this->get( $this->login_user_key );

			// replace user_id
			$this->_post_args['user_id'] = $this->get( $this->login_user_key );
			
			return $this->get( $this->login_user_key );
		}

		// if exist in post variable,
		if ( $this->post( $this->login_user_key ) != null) {

			// get user id
			$login_user_id = $this->post( $this->login_user_key );

			// replace user_id
			$this->_post_args['user_id'] = $this->post( $this->login_user_key );
			unset( $this->_post_args[ $this->login_user_key ] );
			
			return $login_user_id;
		}

		// if exist in put variable,
		if ( $this->put( $this->login_user_key ) != null) {

			// get user id
			$login_user_id = $this->put( $this->login_user_key );

			// replace user_id
			$this->_put_args['user_id'] = $this->put( $this->login_user_key );
			unset( $this->_put_args[ $this->login_user_key ] );
			
			return $login_user_id;
		}
	}

	/**
	 * Convert logged in user id to user_id
	 */
	function get_similar_key( $actual, $similar )
	{
		if ( empty( parent::post( $actual )) && empty( parent::put( $actual ))) {
		// if actual key is not existed in POST and PUT, return similar

			return $similar;
		}

		// else, just return normal key
		return $actual;
	}

	/**
	 * Override Get variables
	 *
	 * @param      <type>  $key    The key
	 */
	function get( $key = NULL, $xss_clean = true )
	{
		return $this->ps_security->clean_input( parent::get( $key, $xss_clean ));
	}

	/**
	 * Override Post variables
	 *
	 * @param      <type>  $key    The key
	 */
	function post( $key = NULL, $xss_clean = true )
	{
		if ( $key == 'user_id' ) {
		// if key is user_id and user_id is not in variable, get the similar key

			$key = $this->get_similar_key( 'user_id', $this->login_user_key );
		}

		return $this->ps_security->clean_input( parent::post( $key, $xss_clean ));
	}

	/**
	 * Override Put variables
	 *
	 * @param      <type>  $key    The key
	 */
	function put( $key = NULL, $xss_clean = true )
	{
		if ( $key == 'user_id' ) {
		// if key is user_id and user_id is not in variable, get the similar key
			
			$key = $this->get_similar_key( 'user_id', $this->login_user_key );
		}

		return $this->ps_security->clean_input( parent::put( $key, $xss_clean ));
	}

	/**
	 * Determines if valid api key.
	 *
	 * @return     boolean  True if valid api key, False otherwise.
	 */
	function is_valid_api_key()
	{	
		$client_api_key = $this->get( 'api_key' );
		
		if ( $client_api_key == NULL ) {
		// if API key is null, return false;

			return false;
		}

		$server_api_key = $this->config->item( 'api_key' );

		if ( $client_api_key != $server_api_key ) {
		// if API key is different with server api key, return false;

			return false;
		}

		return true;
	}

	/**
	 * Get all or Get One
	 */
	function get_get()
	{
		// get id
		$id = $this->get( 'id' );

		if ( $id ) {
			
			// if 'id' is existed, get one record only
			$data = $this->model->get_one( $id );

			if ( isset( $data->is_empty_object )) {
			// if the id is not existed in the return object, the object is empty
				
				$data = array();
			}

			$this->custom_response( $data );
		}

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$conds = $this->get();

		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( count( $conds ) == 0 ) {
		// if 'id' is not existed, get all	
		
			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty
				
				$data = $this->model->get_all( $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty
				
				$data = $this->model->get_all( $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_all()->result();
			}

			$this->custom_response( $data );
		} else {

			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty

				$data = $this->model->get_all_by( $conds, $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty

				$data = $this->model->get_all_by( $conds, $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_all_by( $conds )->result();
			}

			$this->custom_response( $data );
		}
	}

	/**
	 * Get all or Get One
	 */
	function get_post()
	{
		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		// get search criteria
		$conds = $this->post();

		if ( $limit ) {
			unset( $conds['limit']);
		}

		if ( $offset ) {
			unset( $conds['offset']);
		}

		if ( count( $conds ) == 0 ) {
		// if 'id' is not existed, get all	
		
			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty
				
				$data = $this->model->get_all( $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty
				
				$data = $this->model->get_all( $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_all()->result();
			}

			$this->custom_response( $data );
		} else {

			$final_conds = array();
			foreach( $conds as $key => $value ) {
				if ( !empty( $value )) {
					$final_conds[$key] = $value;
				}
			}
			$conds = $final_conds;

			if ( !empty( $limit ) && !empty( $offset )) {
			// if limit & offset is not empty

				$data = $this->model->get_all_by( $conds, $limit, $offset )->result();
			} else if ( !empty( $limit )) {
			// if limit is not empty

				$data = $this->model->get_all_by( $conds, $limit )->result();
			} else {
			// if both are empty

				$data = $this->model->get_all_by( $conds )->result();
			}

			$this->custom_response( $data );
		}
	}

	/**
	 * Search API
	 */
	function search_get()
	{
		$conds = $this->get();

		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		if ( !empty( $limit ) && !empty( $offset )) {
		// if limit & offset is not empty

			$data = $this->model->get_all_by( $conds, $limit, $offset )->result();
		} else if ( !empty( $limit )) {
		// if limit is not empty

			$data = $this->model->get_all_by( $conds, $limit )->result();
		} else {
		// if both are empty

			$data = $this->model->get_all_by( $conds )->result();
		}

		$this->custom_response( $data );
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj ) 
	{
		// convert added_date date string
		if ( isset( $obj->added_date )) {
			
			// added_date timestamp string
			$obj->added_date_str = ago( $obj->added_date );
		}
	}

	/**
	 * Gets the default photo.
	 *
	 * @param      <type>  $id     The identifier
	 * @param      <type>  $type   The type
	 */
	function get_default_photo( $id, $type )
	{
		$default_photo = "";

		// get all images
		$img = $this->Image->get_all_by( array( 'img_parent_id' => $id, 'img_type' => $type ))->result();

		if ( count( $img ) > 0 ) {
		// if there are images for news,
			
			$default_photo = $img[0];
		} else {
		// if no image, return empty object

			$default_photo = $this->Image->get_empty_object();
		}

		return $default_photo;
	}

	/**
	 * Response Error
	 *
	 * @param      <type>  $msg    The message
	 */
	function error_response( $msg )
	{
		$this->response( array(
			'status' => 'error',
			'message' => $msg
		), 404 );
	}

	/**
	 * Response Success
	 *
	 * @param      <type>  $msg    The message
	 */
	function success_response( $msg )
	{
		$this->response( array(
			'status' => 'success',
			'message' => $msg
		));
	}

	/**
	 * Custome Response return 404 if not data found
	 *
	 * @param      <type>  $data   The data
	 */
	function custom_response( $data, $require_convert = true )
	{
		if ( empty( $data )) {
		// if there is no data, return error

			$this->error_response( get_msg( 'no_record' ) );

		} else if ( $require_convert ) {
		// if there is data, return the list

			if ( is_array( $data )) {
			// if the data is array

				foreach ( $data as $obj ) {

					// convert object for each obj
					$this->convert_object( $obj );
				}
			} else {

				$this->convert_object( $data );
			}
		}

		$data = $this->ps_security->clean_output( $data );

		$this->response( $data );
	}

	/**
	 * Default Validation Rules
	 */
	function default_validation_rules()
	{
		// default rules
		$rules = array(
			array(
				'field' => $this->model->primary_key,
				'rules' => 'required|callback_id_check'
			)
		);

		// set to update validation rules
		$this->update_validation_rules = $rules;

		// set to delete_validation_rules
		$this->delete_validation_rules = $rules;
	}

	/**
	 * Id Checking
	 *
	 * @param      <type>  $id     The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function id_check( $id, $model_name = false )
    {
    	$tmp_model = $this->model;

    	if ( $model_name != false) {
    		$tmp_model = $this->{$model_name};
    	}

        if ( !$tmp_model->is_exist( $id )) {
        
            $this->form_validation->set_message('id_check', 'Invalid {field}');
            return false;
        }

        return true;
    }

	/**
	 * { function_description }
	 *
	 * @param      <type>   $conds  The conds
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function is_valid( $rules )
	{
		if ( empty( $rules )) {
		// if rules is empty, no checking is required
			
			return true;
		}

		// GET data
		$user_data = array_merge( $this->get(), $this->post(), $this->put() );

		$this->form_validation->set_data( $user_data );
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_rules( $rules );

		if ( $this->form_validation->run() == FALSE ) {
		// if there is an error in validating,

			$errors = $this->form_validation->error_array();

			if ( count( $errors ) == 1 ) {
			// if error count is 1, remove '\n'

				$this->error_response( trim(validation_errors()) );
			}

			$this->error_response( validation_errors());
		}

		return true;
	}

	/**
	 * Adds a post.
	 */
	function add_post()
	{
		// set the add flag for custom response
		$this->is_add = true;

		if ( !$this->is_valid( $this->create_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$data = $this->post();

		if ( !$this->model->save( $data )) {
			$this->error_response( get_msg( 'err_model' ));
		}

		// response the inserted object	
		$obj = $this->model->get_one( $data[$this->model->primary_key] );

		$this->custom_response( $obj );
	}

	/**
	 * Adds a post.
	 */
	function update_put()
	{
		// set the add flag for custom response
		$this->is_update = true;

		if ( !$this->is_valid( $this->update_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get the post data
		$data = $this->put();

		// get id
		$id = $this->get( $this->model->primary_key );

		if ( !$this->model->save( $data, $id )) {
		// error in saving, 
			
			$this->error_response( get_msg( 'err_model' ));
		}

		// response the inserted object	
		$obj = $this->model->get_one( $id );

		$this->custom_response( $obj );
	}

	/**
	 * Delete the record
	 */
	function delete_delete()
	{
		// set the add flag for custom response
		$this->is_delete = true;

		if ( !$this->is_valid( $this->delete_validation_rules )) {
		// if there is an error in validation,
			
			return;
		}

		// get id
		$id = $this->get( $this->model->primary_key );

		if ( !$this->model->delete( $id )) {
		// error in saving, 
			
			$this->error_response( get_msg( 'err_model' ));
		}

		$this->success_response( get_msg( 'success_delete' ));
	}
}