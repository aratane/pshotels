<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Front End Controller
 */
class Userajax extends Ajax_Controller {

    protected $user;

    /**
     * Construct
     */
    function __construct()
    {
        parent::__construct();

        $this->load->library( "PS_Auth" );
        $this->load->library( "PS_Widget" );
        $this->load->library( "PS_Image" );
        $this->load->library( 'PS_Mail' );

        if ( !$this->ps_auth->is_logged_in()) {
        // if user not yet logged in,
            
            $this->error_response( get_msg( 'not_yet_login' ));
        }

        // get logged in user info
        $this->user = $this->ps_auth->get_user_info();
    }

    /**
     * Update Profile Photo
     */
    function update_profile_photo()
    {            
        // load library
        $this->load->library('upload');
        $config['upload_path'] = './uploads/';
        $config['allowed_types'] = $this->config->item('image_type');
        $this->upload->initialize( $config );
 
        if ( ! $this->upload->do_upload( 'user_profile_photo' )) {
        // if error in uploading,
           
            $this->error_response( $this->upload->display_errors());
        }

        // insert to user image
        $uploaded_data = $this->upload->data();

        // create thumbnail
        $image_path = $uploaded_data['full_path'];
        $this->ps_image->create_thumbnail( $image_path );
        
        $data = array( 'user_profile_photo' => $uploaded_data['file_name'] );

        if ( !$this->User->save( $data, $this->user->user_id )) {
        // error in updating user profile

            $this->error_response( get_msg( 'err_upload' ));
        }
        
        $this->success_response( get_msg( 'success' ), $data['user_profile_photo'] );
    }

    /**
     * Update profile
     */
    function update_profile()
    {
        $rules = array(
            array(
                'field' => 'user_name',
                'label' => get_msg('user_name'),
                'rules' => 'required'
            ),
            array(
                'field' => 'user_email',
                'label' => 'Email Address',
                'rules' => 'required|valid_email|callback_email_check['. $this->user->user_id .']'
            )
        );

        if ( !$this->is_valid( $rules )) exit;

        $data = array();
        $this->set_data( $data, 'user_name');
        $this->set_data( $data, 'user_email');
        $this->set_data( $data, 'user_phone');
        $this->set_data( $data, 'user_about_me');
        $this->set_data( $data, 'user_password');
        if ( isset( $data['user_password'] )) {
            $data['user_password'] = md5( $data['user_password'] );
        }

        if ( !$this->User->save( $data, $this->user->user_id )){

            $this->error_response( get_msg( 'err_model' ));
        }

        $this->success_response( get_msg( 'success' ), $this->User->get_one( $this->user->user_id ));
    }

    /**
     * load more hotels
     */
    function loadmore_favourited_hotels()
    {
        $rules = array(
            array(
                'field' => 'page',
                'rules' => 'required'
            )
        );

        if ( !$this->is_valid( $rules )) exit;

        // get page id
        $data = array( 
            "login_user_id" => $this->user->user_id,
            "is_favourited" => 1
        );
        $this->set_data( $data, 'page' );
        $page = $data['page'];        

        // calculate offset & limit
        $limit = $this->config->item( 'favourite_hotel_display_limit' );
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
     * user likes the room
     *
     * @return     boolean  ( description_of_the_return_value )
     */
    function like_room()
    {
        $rules = array(
            array(
                'field' => 'room_id',
                'label' => 'room_id',
                'rules' => 'callback_id_check[Hotel]'
            )
        );

        // check if the room id is valid
        if ( !$this->is_valid( $rules )) exit;

        // insert to likes
        $data['user_id'] = $this->user->user_id;
        $this->set_data( $data, 'room_id' );

        if ( $this->Like->exists( $data )) {
        // if like is already existed, unlike

            if ( !$this->Like->delete_by( $data )) {
                
                $this->error_response( get_msg( 'err_model' ));                
            }

            $obj = array(
                'likeType' => 'unlike',
                'likeCount' => $this->Like->count_all_by( array( 'room_id' => $data['room_id'] ))
            );
            
            $this->success_response( get_msg( 'success_save' ), $obj );
        } else {
        // if like is not yet exist, create new like
            
            if ( !$this->Like->save( $data )) {

                $this->error_response( get_msg( 'err_model' ));
            } 

            $obj = array(
                'likeType' => 'like',
                'likeCount' => $this->Like->count_all_by( array( 'room_id' => $data['room_id'] ))
            );

            $this->success_response( get_msg( 'success_save' ), $obj );   
        }
    }

    /**
     * User favourites the room
     */
    function fav_room()
    {
        $rules = array(
            array(
                'field' => 'room_id',
                'rules' => 'required|callback_id_check[Hotel]'
            )
        );

        // check if the room id is valid
        if ( !$this->is_valid( $rules )) exit;

        // insert to favourites        
        $data['user_id'] = $this->user->user_id;
        $this->set_data( $data, 'room_id' );

        if ( $this->Favourite->exists( $data )) {
        // if Favourite is already existed, unFavourite

            if ( !$this->Favourite->delete_by( $data )) {
                
                $this->error_response( get_msg( 'err_model' ));                
            }

            $obj = array(
                'favType' => 'unfav',
                'favCount' => $this->Favourite->count_all_by( array( 'room_id' => $data['room_id'] ))
            );
            
            $this->success_response( get_msg( 'success_save' ), $obj );
        } else {
        // if Favourite is not yet exist, create new Favourite
            
            if ( !$this->Favourite->save( $data )) {

                $this->error_response( get_msg( 'err_model' ));
            } 

            $obj = array(
                'favType' => 'fav',
                'favCount' => $this->Favourite->count_all_by( array( 'room_id' => $data['room_id'] ))
            );

            $this->success_response( get_msg( 'success_save' ), $obj );   
        }
    }

    /**
     * Review to the room
     */
    function review()
    {
        $rules = array(
            array(
                'field' => 'room_id',
                'rules' => 'required|callback_id_check[Room]'
            ),
            array(
                'field' => 'review_desc',
                'label' => get_msg('review description'),
                'rules' => 'required'
            )
        );

        // check if the room id is valid
        if ( !$this->is_valid( $rules )) exit;

         // insert to reviews        
        $data['user_id'] = $this->user->user_id;
        $this->set_data( $data, 'room_id' );
        $this->set_data( $data, 'review_desc' );

        // start the transaction
        $this->db->trans_start();

        if ( !$this->Review->save( $data )) {
        // if review is not saved,

            $this->db->trans_rollback();
            $this->error_response( get_msg( 'err_model' ));
        }

        // get review categories
        $rvcats = $this->ReviewCategory->get_all()->result();
        
        if ( !empty( $rvcats )) foreach ( $rvcats as $rvcat ) {
            $tmp = array();

            // get rating
            $this->set_data( $tmp, $rvcat->rvcat_id );

            // // insert rating if greater than 0
            if ( $tmp[ $rvcat->rvcat_id ] > 0 ) {
                
                // prepare rating
                $rating = array(
                    'review_id' => $data['review_id'],
                    'rvcat_id' => $rvcat->rvcat_id,
                    'rvrating_rate' => $tmp[$rvcat->rvcat_id]
                );

                if ( !$this->ReviewRating->save( $rating )) {

                    $this->db->trans_rollback();
                    $this->error_response( get_msg( 'err_model' ));
                }
            }
        }

        // check transactions
        if ( ! $this->check_trans()) {

           $this->error_response( get_msg( 'err_model' ));
        }

        // prepare return data
        $review = $this->Review->get_one( $data['review_id'] );
        $review->user = $this->User->get_one( $review->user_id );
        $review->added_date = $review->added_date;

        // replace dummy image for empty profile
        if ( empty( $review->user->user_profile_photo )) $review->user->user_profile_photo = $this->ps_widget->get_dummy_photo()->img_path;
        $review->user->user_profile_photo = base_url( '/uploads/'. $review->user->user_profile_photo );

        // final rating
        $ratings = $this->Review->get_ratings( array( 'review_id' => $review->review_id ), true )->result();
        $review->final_rating = $this->ps_dummy->get_dummy_rating();
        if ( !empty( $ratings )) $review->final_rating = $ratings[0];

        $obj = array(
            'review' => $review,
            'count' => $this->Review->count_all_by( array( 'room_id' => $data['room_id'] ))
        );

        $this->success_response( get_msg( 'success_save' ), $obj );
    }

    /**
     * Email Checking
     *
     * @param      <type>  $email     The identifier
     *
     * @return     <type>  ( description_of_the_return_value )
     */
    function email_check( $email, $user_id = 0 )
    {
        if ( strtolower( $this->User->get_one( $user_id )->user_email ) == strtolower( $email )) {
        // if the email is existing email for that user id,
            
            return true;
        } else if ( $this->User->exists( array( 'user_email' => $_REQUEST['user_email'] ))) {
        // if the email is existed in the system,

            $this->form_validation->set_message('email_check', get_msg( 'err_dup_email' ));
            return false;
        }

        return true;
    }

    /**
     * User favourites the hotel
     */
    function fav_hotel()
    {
        $rules = array(
            array(
                'field' => 'hotel_id',
                'rules' => 'required|callback_id_check[Hotel]'
            )
        );

        // check if the hotel id is valid
        if ( !$this->is_valid( $rules )) exit;

        // insert to favourites        
        $data['user_id'] = $this->user->user_id;
        $this->set_data( $data, 'hotel_id' );

        if ( $this->Favourite->exists( $data )) {
        // if Favourite is already existed, unFavourite

            if ( !$this->Favourite->delete_by( $data )) {
                
                $this->error_response( get_msg( 'err_model' ));                
            }

            $obj = array(
                'favType' => 'unfav',
                'favCount' => $this->Favourite->count_all_by( array( 'hotel_id' => $data['hotel_id'] ))
            );
            
            $this->success_response( get_msg( 'success_save' ), $obj );
        } else {
        // if Favourite is not yet exist, create new Favourite
            
            if ( !$this->Favourite->save( $data )) {

                $this->error_response( get_msg( 'err_model' ));
            } 

            $obj = array(
                'favType' => 'fav',
                'favCount' => $this->Favourite->count_all_by( array( 'hotel_id' => $data['hotel_id'] ))
            );

            $this->success_response( get_msg( 'success_save' ), $obj );   
        }
    }

    /**
     * Booking
     */
    function booking()
    {
        $rules = array(
            array(
                'field' => 'room_id',
                'label' => 'Room Id',
                'rules' => 'required'
            ),
            array(
                'field' => 'booking_user_name',
                'label' => 'Guest Name',
                'rules' => 'required'
            ),
            array(
                'field' => 'booking_user_email',
                'label' => 'Guest Email',
                'rules' => 'required|valid_email'
            ),
            array(
                'field' => 'booking_start_date',
                'label' => 'From Date',
                'rules' => 'required'
            ),
            array(
                'field' => 'booking_adult_count',
                'label' => 'Adult Count',
                'rules' => 'is_natural_no_zero'
            ),
            array(
                'field' => 'booking_kid_count',
                'label' => 'Kid Count',
                'rules' => 'is_natural'
            ),
            array(
                'field' => 'booking_extra_bed',
                'label' => 'Extra Bed',
                'rules' => 'is_natural'
            )
        );

        if ( !$this->is_valid( $rules )) exit;

        // booking data
        $booking_data = array();
        $this->set_data( $booking_data, 'user_id' );
        $this->set_data( $booking_data, 'room_id' );
        $this->set_data( $booking_data, 'booking_user_name' );
        $this->set_data( $booking_data, 'booking_user_email' );
        $this->set_data( $booking_data, 'booking_user_phone' );
        $this->set_data( $booking_data, 'booking_adult_count' );
        $this->set_data( $booking_data, 'booking_kid_count' );
        $this->set_data( $booking_data, 'booking_extra_bed' );
        $this->set_data( $booking_data, 'booking_start_date' );
        $this->set_data( $booking_data, 'booking_end_date' );
        $this->set_data( $booking_data, 'booking_end_date' );
        $this->set_data( $booking_data, 'booking_remark' );

        $room = $this->Room->get_one( $booking_data['room_id']);
        $booking_data['hotel_id'] = $room->hotel_id;

        if ( !$this->Booking->save( $booking_data )) {
        // if error in creating user, show error

            $this->error_response( get_msg( 'err_model' ));
        }

        if ( !send_booking_request_email( $booking_data['booking_id'] )) {
        // if error in sending email,

            $this->error_response( get_msg( 'err_email' ));
        }

        // if credential is correct, redirect to respective url
        $this->success_response( get_msg( 'success_booking' ));
    }

    /**
     * load more bookings list
     */
    function loadmore_bookings()
    {
        $rules = array(
            array(
                'field' => 'page',
                'rules' => 'required'
            )
        );

        if ( !$this->is_valid( $rules )) exit;

        // get page id
        $data = array( "login_user_id" => $this->user->user_id );
        $this->set_data( $data, 'page' );
        $page = $data['page'];        

        // calculate offset & limit
        $limit = $this->config->item( 'booking_list_display_limit' );
        $offset = $page * $limit;

        $bookings = $this->Booking->get_all_by( $data, $limit, $offset )->result();

        if ( !empty( $bookings )) foreach ( $bookings as &$booking ) {
        // if bookings is not empty,

            // set hotel
            $booking->hotel = $this->Hotel->get_one( $booking->hotel_id );            
            $booking->hotel->default_photo = get_default_photo( $booking->hotel->hotel_id, 'hotel' );

            // set room
            $booking->room = $this->Room->get_one( $booking->room_id );

            $booking->booking_start_date = date( 'd-M-Y', strtotime( $booking->booking_start_date ));
            $booking->booking_end_date = date( 'd-M-Y', strtotime( $booking->booking_end_date ));
        }

        $this->success_response( get_msg('success'), $bookings );
    }
}