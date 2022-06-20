<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Empty Class
 */
class My_Model {}

/**
 * PanaceaSoft Base Model
 */
class PS_Model extends CI_Model {
	
	// name of the database table
	protected $table_name;

	// name of the ID field
	public $primary_key;

	// name of the key prefix
	protected $key_prefix;

	/**
	 * constructs required data
	 */
	function __construct( $table_name, $primary_key = false, $key_prefix = false )
	{
		parent::__construct();

		// set the table name
		$this->table_name = $table_name;
		$this->primary_key = $primary_key;
		$this->key_prefix = $key_prefix;
	}

	/**
	 * Empty class to be extended
	 *
	 * @param      array  $conds  The conds
	 */
	function custom_conds( $conds = array()) {

	}

	/**
	 * Generate the TeamPS Unique Key
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function generate_key()
	{
		return $this->key_prefix . md5( $this->key_prefix . microtime() . uniqid() . 'teamps' );
	}

    /**
     * Determines if exist.
     *
     * @param      <type>   $id     The identifier
     *
     * @return     boolean  True if exist, False otherwise.
     */
    function is_exist( $id ) {
    	
    	// from table
    	$this->db->from( $this->table_name );

    	// where clause
		$this->db->where( $this->primary_key, $id );
		
		// get query
		$query = $this->db->get();

		// return the result
		return ($query->num_rows()==1);
    }

    /**
     * Save the data if id is not existed
     *
     * @param      <type>   $data   The data
     * @param      boolean  $id     The identifier
     */
	function save( &$data, $id = false ) {

		if ( !$id ) {
		// if id is not false and id is not yet existed,

			if ( !empty( $this->primary_key ) && !empty( $this->key_prefix )) {
			// if the primary key and key prefix is existed,
			
				// generate the unique key
				$data[ $this->primary_key ] = $this->generate_key();
			}

			// insert the data as new record
			return $this->db->insert( $this->table_name, $data );
		} else {
		// else
			
			// where clause
			$this->db->where( $this->primary_key, $id);

			// update the data
			return $this->db->update($this->table_name,$data);
		}
	}

	/**
	 * Returns all the records
	 *
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 */
	function get_all( $limit = false, $offset = false ) {

		// where clause
		$this->custom_conds();

		// from table
		$this->db->from($this->table_name);

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}
		
		return $this->db->get();
	}

	/**
	 * Returns the total count
	 */
	function count_all() {
		// from table
		$this->db->from( $this->table_name );

		// where clause
		$this->custom_conds();

		// return the count all results
		return $this->db->count_all_results();
	}

	/**
	 * Return the info by Id
	 *
	 * @param      <type>  $id     The identifier
	 */
	function get_one( $id ) {
		
		// query the record
		$query = $this->db->get_where( $this->table_name, array( $this->primary_key => $id ));
		
		if ( $query->num_rows() == 1 ) {
		// if there is one row, return the record
			
			return $query->row();
		} else {
		// if there is no row or more than one, return the empty object
			
			return $this->get_empty_object( $this->table_name );
		}
	}

	/**
	 * Returns the multiple Info by Id
	 *
	 * @param      array  $ids    The identifiers
	 */
	function get_multi_info( $ids = array()) {
		
		// from table
		$this->db->from( $this->table_name );

		// where clause
		$this->db->where_in( $this->primary_key, $ids );

		// returns
		return $this->db->get();
	}

	/**
	 * Delete the records by Id
	 *
	 * @param      <type>  $id     The identifier
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function delete( $id )
	{
		// where clause
		$this->db->where( $this->primary_key, $id );

		// delete the record
		return $this->db->delete( $this->table_name );
 	}

 	/**
 	 * Delete the records by ids
 	 *
 	 * @param      array   $ids    The identifiers
 	 *
 	 * @return     <type>  ( description_of_the_return_value )
 	 */
 	function delete_list( $ids = array()) {
 		
 		// where clause
		$this->db->where_in( $this->primary_key, $id );

		// delete the record
		return $this->db->delete( $this->table_name );
 	}

	/**
	 * returns the object with the properties of the table
	 *
	 * @return     stdClass  The empty object.
	 */
    function get_empty_object()
    {   
        $obj = new stdClass();
        
        $fields = $this->db->list_fields( $this->table_name );
        foreach ( $fields as $field ) {
            $obj->$field = '';
        }
        $obj->is_empty_object = true;
        return $obj;
    }

   	/**
   	 * Execute The query
   	 *
   	 * @param      <type>   $sql     The sql
   	 * @param      <type>   $params  The parameters
   	 *
   	 * @return     boolean  ( description_of_the_return_value )
   	 */
	function exec_sql( $sql, $params = false )
	{
		if ( $params ) {
		// if the parameter is not false

			// bind the parameter and run the query
			return $this->db->query( $sql, $params );	
		}

		// if there is no parameter,
		return $this->db->query( $sql );
	}

	/**
	 * Implement the where clause
	 *
	 * @param      array  $conds  The conds
	 */
	function conditions( $conds = array())
	{
		// if condition is empty, return true
		if ( empty( $conds )) return true;
	}

	/**
	 * Check if the key is existed,
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function exists( $conds = array()) {

		// where clause
		$this->custom_conds( $conds );
		
		// from table
		$this->db->from( $this->table_name );

		// get query
		$query = $this->db->get();

		// return the result
		return ($query->num_rows() == 1);
	}

	/**
	 * Gets all by the conditions
	 *
	 * @param      array    $conds   The conds
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 *
	 * @return     <type>   All by.
	 */
	function get_all_by( $conds = array(), $limit = false, $offset = false, $orderby = false ) {
		// where clause
		$this->custom_conds( $conds );

		// from table
		$this->db->from( $this->table_name );

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		if( $orderby ) {
			$this->db->order_by($orderby, "desc");
		}
		
		return $this->db->get();
		// print_r($this->db->last_query());die;
	}

	/**
	 * Counts the number of all by the conditions
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  Number of all by.
	 */
	function count_all_by( $conds = array()) {

		// where clause
		$this->custom_conds( $conds );
		
		// from table
		$this->db->from( $this->table_name );

		// return the count all results
		return $this->db->count_all_results();
	}

	/**
	 * Gets the information by.
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  The information by.
	 */
	function get_one_by( $conds = array()) {
		
		// where clause
		$this->custom_conds( $conds );

		// query the record
		$query = $this->db->get( $this->table_name );
		
		if ( $query->num_rows() == 1 ) {
		// if there is one row, return the record
			
			return $query->row();
		} else {
		// if there is no row or more than one, return the empty object
			
			return $this->get_empty_object( $this->table_name );
		}
	}

	/**
	 * Delete the records by condition
	 *
	 * @param      array   $conds  The conds
	 *
	 * @return     <type>  ( description_of_the_return_value )
	 */
	function delete_by( $conds = array() )
	{
		// where clause
		$this->custom_conds( $conds );

		// delete the record
		return $this->db->delete( $this->table_name );
 	}

 	/**
	Returns Shop Admin 
	*/
	function get_all_module( )
	{
	
		$this->db->select('core_modules.*');    
  		$this->db->from('core_modules');
  		$this->db->where('is_show_on_menu',1);
  		$this->db->order_by('group_id','AESC');
		return $this->db->get();
		
	}

	/**
	Returns Hotel Admin 
	*/
	function get_hotel_admin($conds = array())
	{
		$this->db->select('psh_user_hotels.*');    
  		$this->db->from('psh_user_hotels');
  		$this->db->where_in('psh_user_hotels.hotel_id',$conds);

		return $this->db->get();
		// print_r($this->db->last_query());die;
		
	}

	/**
	 * Gets the allowed modules.
	 *
	 * @param      <type>  $user_id  The user identifier
	 *
	 * @return     <type>  The allowed modules.
	*/
	function get_hotel_id( $conds = array() )
	{
		
		$this->db->select('psh_user_hotels.*');    
  		$this->db->from('psh_user_hotels');
  		$this->db->where('psh_user_hotels.user_id',$conds['user_id']);

  		return $this->db->get();
  		
	}

	/**
	  * Gets all by the conditions
	  *
	  * @param      array    $conds   The conds
	  * @param      boolean  $limit   The limit
	  * @param      boolean  $offset  The offset
	  *
	  * @return     <type>   All by.
	*/
	 function get_all_in_hotel_admin( $conds = array(), $limit = false, $offset = false ) {
	  	// where clause
	  	$this->db->where_in('hotel_id', $conds);

	  	// from table
	  	$this->db->from( $this->table_name );

	  	if ( $limit ) {
	  	// if there is limit, set the limit
	   
	   		$this->db->limit($limit);
	  	}
	  
	  	if ( $offset ) {
	  	// if there is offset, set the offset,
	   
	   		$this->db->offset($offset);
	  	}
	    return $this->db->get();
	    // print_r($this->db->last_query());die;
	    
	 }

	 /**
	 * Gets all by the conditions
	 *
	 * @param      array    $conds   The conds
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 *
	 * @return     <type>   All by.
	 */
	function get_all_by_hotel( $conds, $limit = false, $offset = false, $orderby = false ) {
		
		// from table
		$this->db->from( $this->table_name );

		if(isset($conds['searchterm'])) {
					
			$this->db->where( 'hotel_name', $conds['searchterm'] );	

		}

		if(isset($conds['hotel_id'])) {
					
			$this->db->where_in( 'hotel_id', $conds['hotel_id'] );	

		}

		if(isset($conds['city_id'])) {

			if ($conds['city_id'] != "" || $conds['city_id'] != 0) {
					
					$this->db->where( 'city_id', $conds['city_id'] );	

			}

		}

		if(isset($conds['hotel_star_rating'])) {

			if ($conds['hotel_star_rating'] != "" || $conds['hotel_star_rating'] != 0) {
					
					$this->db->where( 'hotel_star_rating', $conds['hotel_star_rating'] );	

			}

		}

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		if( $orderby ) {
			$this->db->order_by($orderby, "desc");
		}
		
		return $this->db->get();
		// print_r($this->db->last_query());die;
	}

	/**
	 * Gets all by the conditions
	 *
	 * @param      array    $conds   The conds
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 *
	 * @return     <type>   All by.
	 */
	function get_all_by_room( $conds, $limit = false, $offset = false, $orderby = false ) {
		
		// from table
		$this->db->from( $this->table_name );

		if(isset($conds['searchterm'])) {
					
			$this->db->where( 'room_name', $conds['searchterm'] );	

		}

		if(isset($conds['hotel_id'])) {
					
			$this->db->where_in( 'hotel_id', $conds['hotel_id'] );	

		}

		if(isset($conds['city_id'])) {

			if ($conds['city_id'] != "" || $conds['city_id'] != 0) {
					
					$this->db->where( 'city_id', $conds['city_id'] );	

			}

		}

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			
			$this->db->offset($offset);
		}

		if( $orderby ) {
			$this->db->order_by($orderby, "desc");
		}
		
		return $this->db->get();
		// print_r($this->db->last_query());die;
	}

	/**
	  * Gets all by the conditions
	  *
	  * @param      array    $conds   The conds
	  * @param      boolean  $limit   The limit
	  * @param      boolean  $offset  The offset
	  *
	  * @return     <type>   All by.
	*/
	 function get_all_in_hotel_users( $conds = array(), $limit = false, $offset = false ) {

	 	$this->db->distinct();
		$this->db->select('user_id'); 

	  	// where clause
	  	$this->db->where_in('hotel_id', $conds);

	  	// from table
	  	$this->db->from( $this->table_name );

	  	if ( $limit ) {
	  	// if there is limit, set the limit
	   
	   		$this->db->limit($limit);
	  	}
	  
	  	if ( $offset ) {
	  	// if there is offset, set the offset,
	   
	   		$this->db->offset($offset);
	  	}
	    return $this->db->get();
	    // print_r($this->db->last_query());die;
	    
	 }

	 /**
	 * Gets all by the conditions
	 *
	 * @param      array    $conds   The conds
	 * @param      boolean  $limit   The limit
	 * @param      boolean  $offset  The offset
	 *
	 * @return     <type>   All by.
	 */
	function get_all_by_user( $conds, $limit = false, $offset = false, $orderby = false ) {
		$this->db->distinct();
		$this->db->select('core_users.user_id'); 
		$this->db->from('core_users');
		$this->db->join('psh_user_hotels', 'psh_user_hotels.user_id = core_users.user_id');

		if(isset($conds['searchterm'])) {
					
			$this->db->where( 'user_name', $conds['searchterm'] );	

		}

		if(isset($conds['user_id'])) {

			if ($conds['user_id'] != "" || $conds['user_id'] != 0) {
					
					$this->db->where( 'user_id', $conds['user_id'] );	

			}

		}

		if ( $limit ) {
		// if there is limit, set the limit
			
			$this->db->limit($limit);
		}
		
		if ( $offset ) {
		// if there is offset, set the offset,
			$this->db->offset($offset);
		}
		
		return $this->db->get();
		// print_r($this->db->last_query());die;
	}


}