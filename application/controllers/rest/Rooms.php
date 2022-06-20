<?php
require_once( APPPATH .'libraries/REST_Controller.php' );

/**
 * REST API for About
 */
class Rooms extends API_Controller
{
	/**
	 * Constructs Parent Constructor
	 */
	function __construct()
	{
		// call the parent
		parent::__construct( 'Room' );		
	}

	/**
	 * Convert Object
	 */
	function convert_object( &$obj )
	{
		// call parent convert object
		parent::convert_object( $obj );

		// convert customize category object
		$this->ps_adapter->convert_room( $obj );
	}

	/**
	 * Get hotel features
	 */
	function features_get()
	{
		// get either room or hotel id
        $room_id = $this->get( 'room_id' );
        $hotel_id = $this->get( 'hotel_id' );

        //  condition
        $conds = array();
        if ( $room_id ) {
        // filter by room if room exist

        	$conds = array( 'room_id' => $room_id );
        } else {
        // filter by hotel

        	$conds = array( 'hotel_id' => $hotel_id );
        }

		// get other hotel informations
		$infos = $this->RoomInfo->get_type_and_group( $conds )->result();

		// get draft format
		$info_grps = array();
		if ( !empty( $infos )) foreach( $infos as $info ) {

			$info_grps[$info->rinfo_grp_id][] = $info->rinfo_typ_id;
		}

		// pretty format
		$response = array();
		if ( !empty( $info_grps )) foreach ( $info_grps as $grp => $type ) {

			$obj = $this->RoomInfoGroup->get_one( $grp );
			$obj->default_photo = $this->ps_adapter->get_default_photo( $obj->rinfo_grp_id, 'rinfo_grp');

			if( $hotel_id != "" ) {
				$obj->rinfo_parent_id = $hotel_id;
			}

			if( $room_id != "" ) {
				$obj->rinfo_parent_id = $room_id;
			}

			if ( !empty( $type )) foreach ( $type as $typ ) {

				//$obj->types[] = $this->RoomInfoType->get_one( $typ );

				$tmp_types = $this->RoomInfoType->get_one( $typ );
				
				if( $hotel_id != "" ) {
					$tmp_types->rinfo_parent_id = $hotel_id;
				} 

				if( $room_id != "" ) {
					$tmp_types->rinfo_parent_id = $room_id;
				}

				
				$obj->types[] = $tmp_types;

			}
			$response[] = $obj;
		}

		$this->response( $response, false );
	}
}