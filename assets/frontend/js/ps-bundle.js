
$(document).ready(function() {
	// common scripts

	// sticky navigation
	if ( typeof stickNav == "function" ) stickNav();

	// Contact Us script
	if ( typeof contactUs == "function" ) contactUs();

	// Login Script
	if ( typeof login == "function" ) login();

	// Signup Script
	if ( typeof signup == "function" ) signup();

	// resetPassword
	if ( typeof resetPassword == "function" ) resetPassword();

	// resetEmail
	if ( typeof resetEmail == "function" ) resetEmail();

	// inquiry
	if ( typeof inquiry == "function" ) inquiry();

	// booking
	if ( typeof booking == "function" ) booking();

	// profile
	if ( typeof profile == "function" ) profile();

	// custom scripts

	// functions to run after jquery is loaded
	if ( typeof search_form == "function" ) search_form();

	// popular hotels
	if ( typeof popular_hotels == "function" ) popular_hotels();

	// recommended_hotels
	if ( typeof recommended_hotels == "function" ) recommended_hotels();

	// popular_rooms
	if ( typeof popular_rooms == "function" ) popular_rooms();

	// favourited_hotels
	if ( typeof favourited_hotels == "function" ) favourited_hotels();

	// promotion_hotels
	if ( typeof promotion_hotels == "function" ) promotion_hotels();

	// main filter
	if ( typeof main_filter == "function" ) main_filter();

	// hero text city
	if ( typeof hero_text_city == "function" ) hero_text_city();

	// loadmore_hotels
	if ( typeof loadmore_hotels == "function" ) loadmore_hotels();

	// room summary
	if ( typeof room_summary == "function" ) room_summary();

	// room hero text
	if ( typeof room_hero_text == "function" ) room_hero_text();

	// hotel_list
	if ( typeof hotel_list == "function" ) hotel_list();

	// hotel_hero_text
	if ( typeof hotel_hero_text == "function" ) hotel_hero_text();

	// room_list
	//if ( typeof room_list == "function" ) room_list();

	// room_hero_text
	if ( typeof room_hero_text == "function" ) room_hero_text();

	// room detail
	if ( typeof room == "function" ) room();

	// reviews
	if ( typeof reviews == "function" ) reviews();

	// review_modal
	if ( typeof review_modal == "function" ) review_modal();

	// popular_cities
	if ( typeof popular_cities == "function" ) popular_cities();

	// bookings
	if ( typeof bookings == "function" ) bookings();

});