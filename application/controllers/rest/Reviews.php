<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for Reviews
 */
class Reviews extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Review' );
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize review object
		$this->ps_adapter->convert_review( $obj );
	}

	/**
	 * Final Rating Object
	 */
	function summary_get()
	{
		// validation rules for create
		$rules = array(
			array(
	        	'field' => 'api_key',
	        	'rules' => 'required|callback_params_check'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $hotel_id = $this->get( 'hotel_id' );
		$room_id = $this->get( 'room_id' );

		$obj = new stdClass;
		$conds = array();

		if ( $hotel_id ) {

			// hotel id
			$obj->hotel_id = $hotel_id;

			// conditions
			$conds = array( 'hotel_id' => $hotel_id, 'review_parent_id' => $hotel_id );

		} else {
			// room id
			$obj->room_id = $room_id;

			//conditions
			$conds = array( 'room_id' => $room_id, 'review_parent_id' => $room_id );
		}

		// rating
		$ratings = $this->Review->get_ratings( $conds, $is_rating_only = true)->result();
		$obj->rating= $this->ps_adapter->convert_rating( $ratings );

		// if rating is empty
		if ( $obj->rating->review_count == 0 ) {

			$this->custom_response( array(), false );
		}

		//To return parent id
		if($hotel_id != "") {
			$obj->review_parent_id = $hotel_id;
		}

		if($room_id != "") {
			$obj->review_parent_id = $room_id;
		}
		
		//print_r($conds); die;
		// review_categories
		$review_cat_ratings = $this->Review->get_ratings( $conds, $is_rating_only = false )->result();

		//print_r($review_cat_ratings); die;

		if ( !empty( $review_cat_ratings )) foreach ( $review_cat_ratings as &$review_cat_rating ) {

			$this->ps_adapter->convert_review_category_rating( $review_cat_rating, $conds );
		}

		$obj->review_categories = $review_cat_ratings;

		$this->custom_response( $obj, false );
	}

	/**
	 * Final Rating Object
	 */
	function details_get()
	{	
		// validation rules for create
		$rules = array(
			array(
	        	'field' => 'api_key',
	        	'rules' => 'required|callback_params_check'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        $hotel_id = $this->get( 'hotel_id' );
		$room_id = $this->get( 'room_id' );

		$obj = new stdClass;

		//To return parent id
		if($hotel_id != "") {
			$obj->review_parent_id = $hotel_id;
		}

		if($room_id != "") {
			$obj->review_parent_id = $room_id;
		}

		$conds = array();

		if ( $hotel_id ) {

			// conditions
			$conds = array( 'hotel_id' => $hotel_id );
			$extra_rileds = array( 'review_parent_id' => $hotel_id );

		} else {

			//conditions
			$conds = array( 'room_id' => $room_id );
			$extra_rileds = array( 'review_parent_id' => $room_id );

		}

		// get limit & offset
		$limit = $this->get( 'limit' );
		$offset = $this->get( 'offset' );

		$orderby = "added_date";
		
		// reviews
		$reviews = $this->Review->get_all_by( $conds, $limit, $offset , $orderby )->result();
		if ( !empty( $reviews )) foreach ( $reviews as &$review ) {
			
			$this->ps_adapter->convert_review( $review, $extra_rileds );	
		}
		
		$obj = $reviews;
		
		$this->custom_response( $obj, false );
	}

	/**
	 * Check parameters
	 *
	 * @return     boolean  ( description_of_the_return_value )
	 */
	function params_check()
	{
		// get hotel id or room id
		$hotel_id = $this->get( 'hotel_id' );
		$room_id = $this->get( 'room_id' );

		if ( $hotel_id || $room_id ) {
		// true if hotel id or room id is exited,
			
			return true;
		}

		// id validation
		$this->form_validation->set_message('params_check', 'Hotel Id or Room Id is reqruied');
        return false;
	}

	/**
	 * Submit Review and Ratings
	 * {
		  "room_id":"roombf41089e534007b01b1c047fc0bb3ada",
		  "user_id":"c4ca4238a0b923820dcc509a6f75849b ",
		  "review_desc":"blala",
		  "ratings":[
		    {
		      "rvcat_id":"id001",
		      "rvrating_rate":"2"
		    },
		    {
		      "rvcat_id":"3",
		      "rvrating_rate":"5"
		    }
		  ]
		}
	 */
	function submit_post()
	{
		// validation rules for create
		$rules = array(
			array(
	        	'field' => 'room_id',
	        	'rules' => 'required|callback_id_check[Room]'
	        ),
	        array(
	        	'field' => 'user_id',
	        	'rules' => 'required|callback_id_check[User]'
	        ),
	        array(
	        	'field' => 'review_desc',
	        	'rules' => 'required'
	        )
        );

		// exit if there is an error in validation,
        if ( !$this->is_valid( $rules )) exit;

        // transaction start
        $this->db->trans_begin();

        // insert psh_reviews (room_id, user_id, review_desc)
 		$review = array(
 			'room_id' => $this->post( 'room_id' ),
 			'user_id' => $this->post( 'user_id' ),
 			'review_desc' => $this->post( 'review_desc' )
 		);

 		if ( !$this->Review->save( $review )) {
 		// if error in saving review

 			$this->error_response( get_msg( 'err_model' ));
 		}

        // insert psh_review_ratings (review_id, rvcat_id, rvrating_rate)
        $ratings = $this->post( 'ratings', false );
		$ratings = $this->ps_security->clean_output( $ratings );

        $datas = json_decode($ratings);
        
        if ( !empty( $datas )) foreach( $datas as $rate ) {
        	$rating[ 'review_id' ] = $review['review_id'];
        	$rating[ 'rvcat_id' ]  = $rate->rvcat_id;
        	$rating[ 'rvrating_rate' ]  = $rate->rvrating_rate;
			
			if ( !$this->ReviewRating->save( $rating )) {
        	// if error in saving review rating,
				$this->error_response( get_msg( 'err_model' ));
        	}
        }

        // transaction end
		if ($this->db->trans_status() === FALSE) {
        	
        	$this->db->trans_rollback();
        	$this->error_response( get_msg( 'err_model' ));
    	} else {
		       
			$this->db->trans_commit();
		}

		$this->success_response("success_review");

	}
}