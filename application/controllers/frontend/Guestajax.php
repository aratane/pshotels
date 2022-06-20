<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Front End Controller
 */
class Guestajax extends Ajax_Controller {

	/**
	 * Construct
	 */
	function __construct()
	{
		parent::__construct();

		$this->load->library( "PS_Auth" );
		$this->load->library( "PS_Widget" );
		$this->load->library( "PS_Mail" );
	}

	/**
	 * Load more cities
	 */
	function loadmore_hotels()
	{
		// validation
		$rules = array(
			array(
				'field' => 'page',
				'rules' => 'required'
			),
			array(
				'field' => 'city_id',
				'rules' => 'required'
			)
		);

		if( !$this->is_valid( $rules )) exit;

		// clean input data
		$data = array();
		$this->set_data( $data, 'page' );
		$this->set_data( $data, 'city_id' );
		$this->set_data( $data, 'propertyName' );
		$this->set_data( $data, 'minPrice' );
		$this->set_data( $data, 'maxPrice' );
		$this->set_data( $data, 'infoTypes' );

		// create condition array
		$conds = array();
		if ( isset( $data['city_id'] )) $conds['city_id'] = $data['city_id'];

		if ( isset( $data['propertyName'] ) && !empty( $data['propertyName'] )) 
			$conds['searchterm'] = $data['propertyName'];

		if ( isset( $data['minPrice'] ) && !empty( $data['minPrice'] )) 
			$conds['hotel_min_price'] = $data['minPrice'];

		if ( isset( $data['maxPrice'] ) && !empty( $data['maxPrice'] )) 
			$conds['hotel_max_price'] = $data['maxPrice'];
		
		if ( isset( $data['infoTypes'] ) && !empty( $data['infoTypes'] )) 
			$conds['filter_by_info_type'] = $data['infoTypes'];

		// get data
		$page = $data['page'];
		$city_id = $data['city_id'];

		// limit & offset
		$limit = $this->config->item( 'hotel_display_limit' );
		$offset = $page * $limit;

		$hotels = $this->Hotel->get_all_by( $conds, $limit, $offset )->result();

		if ( !empty( $hotels )) foreach( $hotels as $hotel ) {

			// get more info
			$this->ps_widget->set_more_info( $hotel );

			// set json format
			$hotel->url = site_url( 'hotel/'. $hotel->hotel_id );
			$hotel->img = img_url( $hotel->default_photo->img_path );
		}

		$this->success_response( get_msg('success'), $hotels );

	}

	/**
	 * Load More Reviews
	 */
	function loadmore_reviews()
	{
		$rules = array(
			array(
				'field' => 'page',
				'rules' => 'required'
			),
			array(
				'field' => 'room_id',
				'rules' => 'required|callback_id_check[Room]'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		$data = array();
		$this->set_data( $data, 'page' );
		$this->set_data( $data, 'room_id' );
		$page = $data['page'];
		$room_id = $data['room_id'];

		$limit = $this->config->item( 'reviews_display_limit' );	
		$offset = $page * $limit;

		$reviews = $this->Review->get_all_by( array( 'room_id' => $room_id, 'added_date_asc' => '1' ), $limit, $offset )->result();

		$cmts = array();
		if ( !empty( $reviews )) {
			foreach ( $reviews as $review ) {
				$review->user = $this->User->get_one( $review->user_id );
		        $review->added_date = $review->added_date;

		        // replace dummy image for empty profile
		        if ( empty( $review->user->user_profile_photo )) $review->user->user_profile_photo = $this->ps_widget->get_dummy_photo()->img_path;
		        $review->user->user_profile_photo = base_url( '/uploads/'. $review->user->user_profile_photo );
		        
		        // final rating
		        $ratings = $this->Review->get_ratings( array( 'review_id' => $review->review_id ), true )->result();
		        $review->final_rating = $this->ps_dummy->get_dummy_rating();
		        if ( !empty( $ratings )) $review->final_rating = $ratings[0];		

		        $cmts[] = $review;
			}
		}
        
     	$this->success_response( get_msg('success'), $cmts );
	}

	/**
	 * load more cities
	 */
	function loadmore_popular_cities()
	{
		$rules = array(
			array(
				'field' => 'page',
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// get page id
		$data = array( 'popular' => 1 );
		$this->set_data( $data, 'page' );
		$page = $data['page'];

		// calculate offset & limit
		$limit = $this->config->item( 'popular_city_display_limit' );
		$offset = $page * $limit;

		$cities = $this->City->get_all_by( $data, $limit, $offset )->result();

		if ( !empty( $cities )) {
			foreach ( $cities as &$city ) {
				$city->default_photo = $this->ps_widget->get_default_photo( $city->city_id, 'city' );
				$city->hotel_count = $this->Hotel->count_all_by( array( 'city_id' => $city->city_id ));
			}
		}

		$this->success_response( get_msg('success'), $cities );
	}

	/**
	 * load more hotels
	 */
	function loadmore_popular_hotels()
	{
		$rules = array(
			array(
				'field' => 'page',
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// get page id
		$data = array( 'popular' => 1 );
		$this->set_data( $data, 'page' );
		$page = $data['page'];

		// calculate offset & limit
		$limit = $this->config->item( 'popular_hotel_display_limit' );
		$offset = $page * $limit;

		$hotels = $this->Hotel->get_all_by( $data, $limit, $offset )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as &$hotel ) {
				$hotel->default_photo = $this->ps_widget->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->Country->get_one( $city->country_id )->country_name;
				$hotel->room_types_count = $this->Room->count_all_by( array( 'hotel_id' => $hotel->hotel_id ));

				// get final rating 
				$ratings = $this->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$this->success_response( get_msg('success'), $hotels );
	}

	/**
	 * load more hotels
	 */
	function loadmore_recommended_hotels()
	{
		$rules = array(
			array(
				'field' => 'page',
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// get page id
		$data = array( 'is_recommended' => 1 );
		$this->set_data( $data, 'page' );
		$page = $data['page'];

		// calculate offset & limit
		$limit = $this->config->item( 'recommended_hotel_display_limit' );
		$offset = $page * $limit;

		$hotels = $this->Hotel->get_all_by( $data, $limit, $offset )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as &$hotel ) {
				$hotel->default_photo = $this->ps_widget->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->Country->get_one( $city->country_id )->country_name;
				$hotel->room_types_count = $this->Room->count_all_by( array( 'hotel_id' => $hotel->hotel_id ));

				// get final rating 
				$ratings = $this->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;
			}
		}

		$this->success_response( get_msg('success'), $hotels );
	}

	/**
	 * Promotion Hotels
	 */
	function loadmore_promotion_hotels()
	{
		$rules = array(
			array(
				'field' => 'page',
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// get page id
		$data = array( 'promotion_only' => 1 );
		$this->set_data( $data, 'page' );
		$page = $data['page'];

		// calculate offset & limit
		$limit = $this->config->item( 'promotion_hotel_display_limit' );
		$offset = $page * $limit;

		$hotels = $this->Hotel->get_all_by( $data, $limit, $offset )->result();

		if ( !empty( $hotels )) {
			foreach ( $hotels as &$hotel ) {
				$hotel->default_photo = $this->ps_widget->get_default_photo( $hotel->hotel_id, 'hotel' );
				$city = $this->City->get_one( $hotel->city_id );
				$hotel->city_name = $city->city_name;
				$hotel->country_name = $this->Country->get_one( $city->country_id )->country_name;
				$hotel->room_types_count = $this->Room->count_all_by( array( 'hotel_id' => $hotel->hotel_id ));

				// get final rating 
				$ratings = $this->Review->get_ratings( array( 'hotel_id' => $hotel->hotel_id ), true )->result();
				if ( !empty( $ratings )) $hotel->final_rating = $ratings[0]->final_rating;

				// get promotions
				$promotions = $this->RoomPromotion->get_all_by( array( 'hotel_id' => $hotel->hotel_id, 'valid_date_only' => 1 ))->result();
				if ( !empty( $promotions )) {
					$hotel->promotion = $promotions[0];
				}
			}
		}

		$this->success_response( get_msg('success'), $hotels );
	}

	/**
	 * load more popular rooms
	 */
	function loadmore_popular_rooms()
	{
		$rules = array(
			array(
				'field' => 'page',
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// get page id
		$data = array( 'popular' => 1 );
		$this->set_data( $data, 'page' );
		$page = $data['page'];

		// calculate offset & limit
		$limit = $this->config->item( 'popular_room_display_limit' );
		$offset = $page * $limit;

		$rooms = $this->Room->get_all_by( $data, $limit, $offset )->result();

		if ( !empty( $rooms )) {
			foreach ( $rooms as $room ) {
				
				// set more info
				$this->ps_widget->set_more_info( $room );
			}
		}

		$this->success_response( get_msg('success'), $rooms );
	}

	/**
	 * Contact Us
	 */
	function contact_us()
	{
		$rules = array(
			array(
				'field' => 'contact_name',
				'label' => get_msg('Name'),
				'rules' => 'required'
			),
			array(
				'field' => 'contact_email',
				'label' => get_msg('Email Address'),
				'rules' => 'required'
			),
			array(
				'field' => 'contact_message',
				'label' => get_msg('Message'),
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		$contact = array();
		$this->set_data( $contact, 'contact_name' );
		$this->set_data( $contact, 'contact_email' );
		$this->set_data( $contact, 'contact_phone' );
		$this->set_data( $contact, 'contact_message' );

		if ( !$this->Contact->save( $contact )) {
		// if an error in saving contact,

			$this->error_response( get_msg( 'err_model' ));
		}

		$this->success_response( get_msg( 'success_save_contact' ));
	}

	/**
	 * Login from or Redirect to home page if already logged in
	 */
	function login() 
	{
		$rules = array(
			array(
				'field' => 'email',
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'password',
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		$data = array();
		$this->set_data( $data, 'email' );
		$this->set_data( $data, 'password' );

		if ( ! $this->ps_auth->login( $data['email'], $data['password'] )) {
		// if credentail is wrong, redirect to login
		
			$this->error_response( get_msg( 'error_login' ));
		}

		// if credential is correct, redirect to respective url
		$this->success_response( get_msg( 'success_login'), $this->ps_auth->get_user_info()->user_id );
	}

	/**
	 * Sign Up
	 */
	function signup()
	{
		$rules = array(
			array(
				'field' => 'user_name',
				'label' => 'Name',
				'rules' => 'required'
			),
			array(
				'field' => 'user_email',
				'label' => 'Email Address',
				'rules' => 'required|valid_email|callback_email_check'
			),
			array(
				'field' => 'user_password',
				'label' => 'Password',
				'rules' => 'required'
			),
			array(
				'field' => 'confPassword',
				'label' => 'Confirm Password',
				'rules' => 'required|matches[user_password]'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// user data
		$user_data = array();
		$this->set_data( $user_data, 'user_name' );
		$this->set_data( $user_data, 'user_email' );
		$this->set_data( $user_data, 'user_password' );

		$password = $user_data['user_password'];
		$user_data['user_password'] = md5( $password );

		if ( !$this->User->save( $user_data )) {
		// if error in creating user, show error

			$this->error_response( get_msg( 'err_model' ));
		}

		if ( ! $this->ps_auth->login( $user_data['user_email'], $password )) {
		// if credentail is wrong, show error
		
			$this->error_response( get_msg( 'error_login' ));
		}

		// if credential is correct, redirect to respective url
		$this->success_response( get_msg( 'success_login'), $this->ps_auth->get_user_info()->user_id );
	}

	/**
	 * Inquiry
	 */
	function inquiry()
	{
		$rules = array(
			array(
				'field' => 'room_id',
				'label' => 'Room Id',
				'rules' => 'required'
			),
			array(
				'field' => 'inq_user_name',
				'label' => 'Name',
				'rules' => 'required'
			),
			array(
				'field' => 'inq_user_email',
				'label' => 'Email Address',
				'rules' => 'required|valid_email'
			),
			array(
				'field' => 'inq_name',
				'label' => 'Inquiry Title',
				'rules' => 'required'
			),
			array(
				'field' => 'inq_desc',
				'label' => 'Inquiry Message',
				'rules' => 'required'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// inquiry data
		$inq_data = array();
		$this->set_data( $inq_data, 'room_id' );
		$this->set_data( $inq_data, 'user_id' );
		$this->set_data( $inq_data, 'inq_user_name' );
		$this->set_data( $inq_data, 'inq_user_email' );
		$this->set_data( $inq_data, 'inq_user_phone' );
		$this->set_data( $inq_data, 'inq_name' );
		$this->set_data( $inq_data, 'inq_desc' );

		if ( !$this->Inquiry->save( $inq_data )) {
		// if error in creating user, show error

			$this->error_response( get_msg( 'err_model' ));
		}

		// get hotel email address
		$hotel_id = $this->Room->get_one( $inq_data['room_id'] )->hotel_id;
		$hotel = $this->Hotel->get_one( $hotel_id );
		
		$to = $hotel->hotel_email;
		$subject = 'Inquiry Message';
		$msg = "<p>Hi ". $hotel->hotel_name .",</p>".
					"<p>You have recieved new inquiry message and more details at below :<br>".

					"Title : ". $inq_data['inq_name'] ."<br>".
					"Description : ". $inq_data['inq_desc'] ."<br>".
					"Contact Name : ". $inq_data['inq_user_name'] ."<br>".
					"Contact Email : ". $inq_data['inq_user_email'] ."<br>".
					"Contact Phone : ". $inq_data['inq_user_phone'] ."<br><br>".

					"<p>Best Regards,<br/>". $this->config->item('sender_name') ."</p>";

		if ( ! $this->ps_mail->send_from_admin( $to, $subject, $msg ) ) {
		// if error in sending email,

			$this->error_response( get_msg( 'err_email' ));
		}

		// if credential is correct, redirect to respective url
		$this->success_response( get_msg( 'success_inquiry' ));
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
     * Reset Password
     */
    function reset()
    {
    	$rules = array(
    		array(
				'field' => 'code',
				'label' => 'Code',
				'rules' => 'required|callback_code_check'
			),
			array(
				'field' => 'password',
				'label' => 'Password',
				'rules' => 'required'
			),
			array(
				'field' => 'conf_password',
				'label' => 'Confirm Password',
				'rules' => 'required|matches[password]'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// get post data
		$data = array();
		$this->set_data( $data, 'code' );
		$this->set_data( $data, 'password' );

		// get user id
		$user_id = $this->ResetCode->get_one_by( array( 'code' => $data['code'] ))->user_id;

		// start the transaction
		$this->db->trans_start();

		$user_data = array( 'user_password' => md5( $data['password'] ));

		if ( !$this->User->save( $user_data, $user_id )) {
		// if error in updating password,

			$this->db->trans_rollback();
			$this->error_response(  get_msg( 'err_model' ));
		}

		if ( !$this->ResetCode->delete_by( array( 'user_id' => $user_id ))) {
		// if error in deleting all reset codes by user id,

			$this->db->trans_rollback();
			$this->error_response(  get_msg( 'err_model' ));
		}

		if ( $this->db->trans_status() === FALSE ) {
        	
        	// rollback the transaction
			$this->db->trans_rollback();
			$this->error_response(  get_msg( 'err_model' ));
		}

		// commit and success return
		$this->db->trans_commit();
		$this->success_response( get_msg( 'success_reset' ));
    }

    /**
     * Reset Email
     */
    function reset_email()
    {
    	$rules = array(
			array(
				'field' => 'email',
				'label' => 'Email Address',
				'rules' => 'required|valid_email'
			)
		);

		if ( !$this->is_valid( $rules )) exit;

		// get post data
		$data = array();
		$this->set_data( $data, 'email' );

		$user_info = $this->User->get_one_by( array( "user_email" => $data['email'] ));

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
					"<a href='". site_url( 'reset/'. $code ) ."'>Reset Password</a></p>".
					"<p>Best Regards,<br/>". $this->config->item('sender_name') ."</p>";

		// send email from admin
		if ( ! $this->ps_mail->send_from_admin( $to, $subject, $msg ) ) {

			$this->error_response( get_msg( 'err_email_not_send' ));
		}
		
		$this->success_response( get_msg( 'success_email_sent' ));
    }

    /**
     * Checking the reset code
     *
     * @param      <type>   $code   The code
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    function code_check( $code )
    {
    	if ( !$this->ResetCode->exists( array( 'code' => $code ))) {

    		$this->form_validation->set_message('code_check', 'Invalid Reset Code');
            return false;
    	}

    	return true;
    }
}