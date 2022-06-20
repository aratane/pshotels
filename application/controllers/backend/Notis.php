<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Notis Controller
 */
class Notis extends BE_Controller {

	/**
	 * Construt required variables
	 */
	function __construct() {

		parent::__construct( MODULE_CONTROL, 'NOTIS' );
	}

	/**
	* Load Notification Sending Form
	*/
	function index() {
		$this->data['action_title'] = "Push Notification";
		$this->load_form($this->data);
	}

	/**
	* Sending Push Notification Message
	*/
	function push_message() {
		
		if ( $this->input->server( 'REQUEST_METHOD' ) == "POST" ) {
				
			$message = htmlentities($this->input->post( 'message' ));

			$error_msg = "";
			$success_device_log = "";

			// Android Push Notification
			$devices = $this->Noti->get_all_by(array('os_type' => 'ANDROID'))->result();

			$device_ids = array();
			if ( count( $devices ) > 0 ) {
				foreach ( $devices as $device ) {
					$device_ids[] = $device->device_id;
				}
			}

			$status = $this->send_android_fcm( $device_ids, array( "message" => $message ));
			if ( !$status ) $error_msg .= "Fail to push all android devices <br/>";

			// IOS Push Notification
			$devices = $this->Noti->get_all_by(array('os_type' => 'IOS'))->result();
			
			if ( count( $devices ) > 0 ) {
				foreach ( $devices as $device ) {
					if ( ! $this->send_ios_apns( $device->device_id, $message )) {
						$error_msg .= "Fail to push ios device named ". $device->device_id ."<br/>";
						//echo $error_msg;
					} else {
						//echo " Sent to : " . $device->reg_id;
						$success_device_log .= " Device Id : " . $device->device_id . "<br>";
					}
				}
			}
			//die;
			// response message
			if ( $status ) {
				$this->session->set_flashdata( 'success', "Successfully Sent Push Notification.<br>" . $success_device_log );
			}

			if ( !empty( $error_msg )) {
				$this->session->set_flashdata( 'error', $error_msg );
			}
			
			$this->module_site_url('push_message');
			
		}

		$this->data['action_title'] = "Push Notification";
		$this->load_form($this->data);
	}

	/**
	* Sending Message From FCM For Android
	*/
	function send_android_fcm( $registatoin_ids, $message) 
    {
    	//Google cloud messaging GCM-API url
    	$url = 'https://fcm.googleapis.com/fcm/send';
    	$fields = array(
    	    'registration_ids' => $registatoin_ids,
    	    'data' => $message,
    	);
    	// Update your Google Cloud Messaging API Key
    	//define("GOOGLE_API_KEY", "AIzaSyCCwa8O4IeMG-r_M9EJI_ZqyybIawbufgg");
    	define("GOOGLE_API_KEY", $this->config->item( 'fcm_api_key' ));  	
    		
    	$headers = array(
    	    'Authorization: key=' . GOOGLE_API_KEY,
    	    'Content-Type: application/json'
    	);
    	$ch = curl_init();
    	curl_setopt($ch, CURLOPT_URL, $url);
    	curl_setopt($ch, CURLOPT_POST, true);
    	curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);	
    	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    	curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
    	$result = curl_exec($ch);				
    	if ($result === FALSE) {
    	    die('Curl failed: ' . curl_error($ch));
    	}
    	curl_close($ch);
    	
    	return $result;
    }


    /**
	* Sending Message From APNS For iOS
	*/
    function send_ios_apns($tokenId, $message) 
	{
		ini_set('display_errors','On'); 
		//error_reporting(E_ALL);
		// Change 1 : No braces and no spaces
		$deviceToken= $tokenId;
		//'fe2df8f5200b3eb133d84f73cc3ea4b9065b420f476d53ad214472359dfa3e70'; 
		// Change 2 : If any
		$passphrase = 'teamps'; 
		$ctx = stream_context_create();
		// Change 3 : APNS Cert File name and location.
		stream_context_set_option($ctx, 'ssl', 'local_cert', realpath('assets').'/apns/apns_pshotels_cert.pem'); 
		stream_context_set_option($ctx, 'ssl', 'passphrase', $passphrase);
		// Open a connection to the APNS server
		$fp = stream_socket_client( 
		    'ssl://gateway.sandbox.push.apple.com:2195', $err,
		    $errstr, 60, STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT, $ctx);
		if (!$fp)
		    exit("Failed to connect: $err $errstr" . PHP_EOL);
		//echo 'Connected to APNS' . PHP_EOL;
		// Create the payload body
		$body['aps'] = array(
		    'alert' => $message,
		    'sound' => 'default'
		    );
		// Encode the payload as JSON
		$payload = json_encode($body);
		// Build the binary notification
		$msg = chr(0) . pack('n', 32) . pack('H*', $deviceToken) . pack('n', strlen($payload)) . $payload;
		// Send it to the server
		$result = fwrite($fp, $msg, strlen($msg));
		// Close the connection to the server
		fclose($fp);
		//var_dump($result); die;
		if (!$result) 
		    //echo 'Message not delivered' . PHP_EOL;
		    return false;

		//echo 'Message successfully delivered' . PHP_EOL;
		return true;
	}

}