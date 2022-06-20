<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Categories Controller
 */
class Comments extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'COMMENTS' );
	}

	/**
	 * List down the comments
	 */
	function index() {

		// get rows count
		$this->data['rows_count'] = $this->Comment->count_all();

		// get comments
		$this->data['comments'] = $this->Comment->get_all( $this->pag['per_page'], $this->uri->segment( 4 ) );

		// load index logic
		parent::index();
	}

	/**
	 * Delete the record
	 * 1) delete comment
	 * 2) check transactions
	 */
	function delete( $cmt_id ) {

		// start the transaction
		$this->db->trans_start();

		// check access
		$this->check_access( DEL );
		
		/**
		 * Delete comment
		 */
		if ( ! $this->Comment->delete( $cmt_id )) {
		// if there is an error in deleting news,
		
			// rollback
			$this->trans_rollback();

			// error message
			$this->set_flash_msg( 'error', get_msg( 'err_model' ));
			redirect( $this->module_site_url());
		}
			
		/**
		 * Check Transcation Status
		 */
		if ( !$this->check_trans()) {

			$this->set_flash_msg( 'error', get_msg( 'err_model' ));	
		} else {
        	
			$this->set_flash_msg( 'success', get_msg( 'success_news_delete' ));
		}
		
		redirect( $this->module_site_url());
	}


	/**
	* View Comment Detail
	*/
	function detail( $cmt_id )
	{

		$comment = $this->Comment->get_one( $cmt_id );
		$this->data['comment'] = $comment;

		$this->load_detail( $this->data );
	}

}