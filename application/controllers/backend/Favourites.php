<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Favourites Controller
 */

class Favourites extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'FAVOURITES' );
	}

	/**
	 * List For Favourite Records
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
			$this->data['rows_count'] = $this->Favourite->count_all();

			// get news
			$this->data['favs'] = $this->Favourite->get_all( $this->pag['per_page'], $this->uri->segment( 4 ) );
		} else if($logged_in_user->is_hotel_admin == 1) {
			$this->data['favs'] = $this->Favourite->get_all_in_hotel_admin( $user_hotels_ids );
		}

		// load index logic
		parent::index();
	}

}