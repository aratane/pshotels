<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Users
 */
class Users extends API_Controller
{

	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		parent::__construct( 'User' );
	}	

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize category object
		$this->ps_adapter->convert_user( $obj );
	}

	/**
	 * Users Categoires Table
	 */
	function categories_post()
	{
		// validation rules for create
		$rules = array(
			array(
	        	'field' => 'user_id',
	        	'rules' => 'required|callback_id_check[User]'
	        ),
	        array(
	        	'field' => 'categories[]',
	        	'label' => 'categories',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $this->db->trans_begin();

        $cat_ids = $this->post( 'categories' );

        $cats = array();

        // insert to each category
        if ( !empty( $cat_ids )) {

        	foreach ( $cat_ids as $cat_id ) {

        		$cat = $this->Category->get_one( $cat_id );

        		if ( isset( $cat->is_empty_object )) {
        			continue;
        		}

        		// prep data
        		$data = array( 'user_id' => $this->login_user_id, 'cat_id' => $cat_id );

        		if ( $this->UserCategory->exists( $data )) {
        		// if user and cat is already existed,

        			if ( !$this->UserCategory->delete_by( $data )) {

        				$this->db->trans_rollback();
        				$this->error_response( get_msg( 'err_model' ));
        			}
        		} else {

        			if ( !$this->UserCategory->save( $data )) {

        				$this->db->trans_rollback();
        				$this->error_response( get_msg( 'err_model' ));
        			}
        		}

        		$this->ps_adapter->convert_category( $cat );

        		$cats[] = $cat; 
        	}
        }

        // database transaction checking
		if ($this->db->trans_status() === FALSE) {
        	
        	$this->db->trans_rollback();
    	} else {
		       
			$this->db->trans_commit();
		}

		if ( empty( $cats )) {
		// if none of categories is existed,

			$this->error_response( get_msg( 'category_not_exist' ));
		}

        $this->response($cats);
	}

	/**
	 * Users Registration
	 */
	function add_post()
	{
		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'user_name',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_email',
	        	'rules' => 'required|valid_email|callback_email_check'
	        ),
	        array(
	        	'field' => 'user_password',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $user_data = array(
        	"user_name" => $this->post('user_name'), 
        	"user_email" => $this->post('user_email'), 
        	'user_password' => md5($this->post('user_password')));

        if ( !$this->User->save($user_data)) {

        	$this->error_response( get_msg( 'err_user_register' ));
        }

        $this->custom_response($this->User->get_one($user_data["user_id"]));

	}


	/**
	 * Email Checking
	 *
	 * @param      <type>  $email     The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function email_check( $email )
    {

        if ( $this->User->exists( array( 'user_email' => $email ))) {
        
            $this->form_validation->set_message('email_check', 'Email Exist');
            return false;
        }

        return true;
    }

    /**
	 * Users Login
	 */
	function login_post()
	{
		// validation rules for user register
		$rules = array(
			
	        array(
	        	'field' => 'user_email',
	        	'rules' => 'required|valid_email'
	        ),
	        array(
	        	'field' => 'user_password',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        if ( !$this->User->exists( array( 'user_email' => $this->post( 'user_email' ), 'user_password' => $this->post( 'user_password' )))) {
        
            $this->error_response( get_msg( 'err_user_not_exist' ));
        }

        $this->custom_response($this->User->get_one_by(array("user_email" => $this->post('user_email'))));
	}

	/**
	* User Reset Password
	*/
	function reset_post()
	{
		// validation rules for user register
		$rules = array(
	        array(
	        	'field' => 'user_email',
	        	'rules' => 'required|valid_email'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $user_info = $this->User->get_one_by( array( "user_email" => $this->post( 'user_email' )));

        if ( isset( $user_info->is_empty_object )) {
        // if user info is empty,
        	
        	$this->error_response( get_msg( 'err_user_not_exist' ));
        }

        // generate code
        $code = md5(time().'teamps');

        // insert to reset
        $data = array(
			'user_id' => $user_info->user_id,
			'code' => $code
		);

		if ( !$this->ResetCode->save( $data )) {
		// if error in inserting,

			$this->error_response( get_msg( 'err_model' ));
		}

		// Send email with reset code
		$to = $user_info->user_email;
	    $subject = 'Password Reset';
		$msg = "<p>Hi,". $user_info->user_name ."</p>".
					"<p>Please click the following link to reset your password<br/>".
					"<a href='". site_url( $this->config->item( 'reset_url') .'/'. $code ) ."'>Reset Password</a></p>".
					"<p>Best Regards,<br/>". $this->config->item('sender_name') ."</p>";

		// send email from admin
		if ( ! $this->ps_mail->send_from_admin( $to, $subject, $msg ) ) {

			$this->error_response( get_msg( 'err_email_not_send' ));
		}
		
		$this->success_response( get_msg( 'success_email_sent' ));
	}

	/**
	* User Profile Update
	*/

	function profile_update_put()
	{

		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'user_id',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_name',
	        	'rules' => 'required'
	        ),
	        array(
	        	'field' => 'user_email',
	        	'rules' => 'required|valid_email'
	        ),
	        array(
	        	'field' => 'user_phone',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        
        $user_data = array(
        	"user_name"     => $this->put('user_name'), 
        	"user_email"    => $this->put('user_email'), 
        	"user_phone"    => $this->put('user_phone'),
        	"user_about_me" => $this->put('user_about_me')
        );

        if ( !$this->User->save($user_data, $this->put('user_id'))) {

        	$this->error_response( get_msg( 'err_user_update' ));
        }

        $this->success_response( get_msg( 'success_profile_update' ));

	}

	/**
	* User Profile Update
	*/
	function password_update_put()
	{

		// validation rules for user register
		$rules = array(
			array(
	        	'field' => 'user_id',
	        	'rules' => 'required|callback_id_check[User]'
	        ),
	        array(
	        	'field' => 'user_password',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $user_data = array(
        	"user_password"     => md5($this->put('user_password'))
        );

        if ( !$this->User->save($user_data, $this->put('user_id'))) {
        	$this->error_response( get_msg( 'err_user_password_update' )); 
        }

        $this->success_response( get_msg( 'success_profile_update' ));

	}
}