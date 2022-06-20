<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Reviews Controller
 */
class Reviews extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'REVIEWS' );

		// load math library to calculate rating
		$this->load->library( 'PS_Rating' );
	}

	/**
	 * List For Review Records
	 */
	function index() {

		$logged_in_user = $this->ps_auth->get_user_info();

		$conds_user_hotel['user_id'] = $logged_in_user->user_id;
		$user_hotel = $this->User_hotel->get_all_by( $conds_user_hotel )->result();
		
		$user_hotels_ids = array();
		for($i=0; $i<count($user_hotel); $i++) {
		 	$user_hotels_ids[]= $user_hotel[$i]->hotel_id;
		}
		
		if($logged_in_user->user_is_sys_admin == 1) {

			// get rows count
			$this->data['rows_count'] = $this->Review->count_all();

			// get news
			$this->data['reviews'] = $this->Review->get_all( $this->pag['per_page'], $this->uri->segment( 4 ) );

		} else if($logged_in_user->is_hotel_admin == 1) {
			$this->data['reviews'] = $this->Review->get_all_in_hotel_admin( $user_hotels_ids );
		}

		// load index logic
		parent::index();
	}

	/**
	* View Comment Detail
	*/
	function detail( $id )
	{
		// get review
		$review = $this->Review->get_one( $id );

		// pass review to data
		$this->data['review'] = $review;

		// load detail page
		$this->load_detail( $this->data );
	}
}