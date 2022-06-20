<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * Send Booking Request Email to hotel
 * @param  [type] $booking_id [description]
 * @return [type]             [description]
 */
if ( !function_exists( 'send_booking_request_email' )) {

	function send_booking_request_email( $booking_id )
	{
		// get ci instance
		$CI =& get_instance();

		// get booking, hotel and room object
		$booking = $CI->Booking->get_one( $booking_id );
		$hotel = $CI->Hotel->get_one( $booking->hotel_id );
		$room = $CI->Room->get_one( $booking->room_id );

		// Send email with reset code
		$to = $hotel->hotel_email;
	    $subject = 'New Booking Request';
	    $confirm_url = site_url( "booking/confirm/". $booking_id );
	    $reject_url = site_url( "booking/reject/". $booking_id );
	    $sender_name = $CI->config->item('sender_name');

		$msg = <<<EOL
<p>Hi,{$hotel->hotel_name}</p>

<p>New Booking Request is received with following information.</p>

<p>
From : {$booking->booking_start_date}<br/>
To : {$booking->booking_end_date}<br/>
Room Name : {$room->room_name}<br/>
Adults: {$booking->booking_adult_count}<br/>
Kids: {$booking->booking_kid_count}<br/>
Extra Beds: {$booking->booking_extra_bed}
</p>

<p>
Remark: {$booking->booking_remark}
</p>

<p>
Guest Name : {$booking->booking_user_name}<br/>
Guest Email : {$booking->booking_user_email}<br/>
Guest Phone : {$booking->booking_user_phone}
</p>

<p>
<a style="margin-right: 10px" href='{$confirm_url}'>Confirm Booking</a>
<a href='{$reject_url}'>Cancel Booking</a>
</p>

<p>
Best Regards,<br/>
{$sender_name}
</p>
EOL;

		// send email from admin
		return $CI->ps_mail->send_from_admin( $to, $subject, $msg );
	}
}

/**
 * Send Booking Confirmation Status to Guest
 * @param  [type] $booking_id [description]
 * @return [type]             [description]
 */
if ( !function_exists( 'send_booking_status_email' )) 
{	
	function send_booking_status_email( $booking_id )
	{
		// get ci instance
		$CI =& get_instance();

		// get booking, hotel and room object
		$booking = $CI->Booking->get_one( $booking_id );
		$user = $CI->User->get_one( $booking->user_id );
		$hotel = $CI->Hotel->get_one( $booking->hotel_id );
		$room = $CI->Room->get_one( $booking->room_id );

		// Send email with reset code
		$to = $booking->booking_user_email;
	    
	    $subject = 'Your Booking Request is ';
	    $status_msg = ( $booking->booking_status == 'CONFIRMED' )? " confirmed": " cancelled";
	    $subject .= $status_msg;
	    $sender_name = $CI->config->item('sender_name');

		$msg = <<<EOL
<p>Hi,{$booking->booking_user_name}</p>

<p>Your Booking Request with the following information is {$status_msg}.</p>

<p>Booking ID : {$booking->booking_id}</p>

<p>
From : {$booking->booking_start_date}<br/>
To : {$booking->booking_end_date}<br/>
Room Name : {$room->room_name}<br/>
Adults: {$booking->booking_adult_count}<br/>
Kids: {$booking->booking_kid_count}<br/>
Extra Beds: {$booking->booking_extra_bed}
</p>

<p>
Remark: {$booking->booking_remark}
</p>

<p>
Guest Name : {$booking->booking_user_name}<br/>
Guest Email : {$booking->booking_user_email}<br/>
Guest Phone : {$booking->booking_user_phone}
</p>

<p>
Best Regards,<br/>
{$sender_name}
</p>
EOL;

		// send email from admin
		return $CI->ps_mail->send_from_admin( $to, $subject, $msg );
	}
}