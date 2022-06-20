<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Likes Controller
 */

class Likes extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'LIKES' );
	}

	/**
	 * List For Like Records
	 */

	function index() {

		// get rows count
		$this->data['rows_count'] = $this->Like->count_all();

		// get news
		$this->data['likes'] = $this->Like->get_all( $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

}