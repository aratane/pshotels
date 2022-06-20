<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/** Home Page Config */
/* 1) if both frontend and backend folder exist */
$config['homepage'] = "home";
$config['reset_url'] = "reset";

/* 2) if only backend folder */
// $config['homepage'] = "admin";
// $config['reset_url'] = "reset_email";

/** Themes File Names */
$config['themes'] = array( 'default', 'green', 'blue', 'orange', 'blue-grey' );

/** System Email */
$config['sender_name'] = "Team PS";
$config['sender_email'] = "admin@panacea-soft.com";

/** API Key */
$config['api_key'] = "teampsisthebest";
$config['fcm_api_key']  = "AIzaSyC9BGuOix3lxA8m8RjMmS9-JRCyehtShmU";
$config['gmap_api_key'] = "AIzaSyDWRJCZRSf2XNckr_WXepCZnovyqOB4c7Q";

/** Validation */
$config['client_side_validation'] = true;
$config['ajax_request_checking'] = true;

/** Comments */
$config['default_display_limit'] = 2;
$config['popular_city_display_limit'] = 6;
$config['popular_hotel_display_limit'] = 6;
$config['recommended_hotel_display_limit'] = 6;
$config['popular_room_display_limit'] = 6;
$config['favourite_hotel_display_limit'] = 6;
$config['promotion_hotel_display_limit'] = 6;
$config['reviews_display_limit'] = 3;
$config['news_display_limit'] = 6;
$config['fav_display_limit'] = 3;
$config['like_display_limit'] = 3;
$config['hotel_display_limit'] = 10;
$config['booking_list_display_limit'] = 3;

/** FrontEnd Template Path */
$config['fe_view_path'] = 'frontend';
$config['fe_url'] = '';

/** Backend Teamplate Path */
$config['be_view_path'] = 'backend';
$config['be_url'] = 'admin';

/** Uploads Folder Path */
$config['upload_path'] = 'uploads/';
$config['upload_thumbnail_path'] = 'uploads/thumbnail/';
$config['image_type'] = 'jpg|jpeg|png';

/** Pagination */
$config['pagination']['per_page'] = 20;
$config['pagination']['num_links'] = 5;
$config['pagination']['uri_segment'] = 4;
$config['pagination']['attributes'] = array('class' => 'page-link');
$config['pagination']['full_tag_open'] =  '<ul class="pagination">';
$config['pagination']['full_tag_close'] = '</ul>';
$config['pagination']['num_tag_open'] = '<li class="page-item">';
$config['pagination']['num_tag_close'] = '</li>';
$config['pagination']['first_link'] = '&laquo;';
$config['pagination']['first_tag_open'] = '<li class="page-item">';
$config['pagination']['first_tag_close'] = '</li>';
$config['pagination']['last_link'] = '&raquo;';
$config['pagination']['last_tag_open'] = '<li class="page-item">';
$config['pagination']['last_tag_close'] = '</li>';
$config['pagination']['next_link'] = '&raquo;';
$config['pagination']['next_tag_open'] = '<li class="page-item">';
$config['pagination']['next_tag_close'] = '</li>';
$config['pagination']['prev_link'] = '&laquo;';
$config['pagination']['prev_tag_open'] = '<li class="page-item">';
$config['pagination']['prev_tag_close'] = '</li>';
$config['pagination']['cur_tag_open'] = '<li class="page-item active"><a class="page-link">';
$config['pagination']['cur_tag_close'] = '</a></li>';