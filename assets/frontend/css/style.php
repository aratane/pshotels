<?php  header('Content-type: text/css'); ?>

/* main */
@font-face {
    font-family: bitter;
    src: url(../../fonts/Bitter/Bitter-Regular.ttf);
}

@font-face {
    font-family: bitter;
    src: url(../../fonts/Bitter/Bitter-Bold.ttf);
    font-weight: bold;
}

@font-face {
    font-family: <?php echo @$sans_serif_font; ?>;
    src: url(../../fonts/OpenSans/OpenSans-Regular.ttf);
}

@font-face {
    font-family: <?php echo @$sans_serif_font; ?>;
    src: url(../../fonts/OpenSans/OpenSans-Bold.ttf);
    font-weight: bold;
}

body {
	font-family: '<?php echo @$sans_serif_font; ?>, sans-serif';
	font-size: 1rem;
	line-height: 1.5rem;
	background-color: <?php echo @$body_bg_color; ?>;
}
h1, h2, h3,
h4, h5, h6 {
	font-family: '<?php echo @$sans_serif_font; ?>, sans-serif';
	font-weight: 900;
}
h1 {
	font-size: 1.75rem;
	line-height: 2rem;
}
h2 {
	font-size: 1.5rem;
	line-height: 2rem;
}
h3 {
	font-size: 1.5rem;
	line-height: 1.75rem;
}
h4 {
	font-size: 1.25rem;
	line-height: 2rem;
}
h5 {
	font-size: 1rem;
	line-height: 1.5rem;
}
h6 {
	font-size: 0.9rem;
	line-height: 1.25rem;`
}
p {
	font-size: 0.9rem;
	line-height: 1.5rem;
}
.lead {
	font-size: 1rem;
}
a, a:hover {
	font-family: inherit;
	color: inherit;
	text-decoration: inherit;
}

/* common */
.border-top { border-top: 1px solid #e5e5e5; }
.border-bottom { border-bottom: 1px solid #e5e5e5; }

.box-shadow { box-shadow: 0 .1rem 1rem rgba(0, 0, 0, .2); }
.text-shadow { text-shadow: 2px 2px #444; }

/* components */
/* Custom Input */
.ps-input {
	width: 100%;
	padding: 0 10px;

	background: <?php echo @$ps_input_bg_color; ?>;
	color: <?php echo @$ps_color; ?>;

	border-color: transparent;
	box-sizing: border-box;
	margin: 0;
	border-radius: 0;

	font-size: .8rem;

	-webkit-transition: 0.2s ease-in-out;
	transition: 0.2s ease-in-out;

	outline: none;
}

/** Text Layer and Background */
.ps-text-layer .caption {
	position: absolute;
	width: 80%;
	bottom: 0;
	padding: 30px 15px;
}
.ps-text-layer .card-title {
	color: <?php echo @$ps_layer_card_title; ?>;
}
.ps-text-layer .card-text {
	font-size: 1rem;
	color: <?php echo @$ps_layer_card_text_color; ?>;
}
.ps-img-layer:after {
	content: '';
	position: absolute;
	bottom: 0;
	width: 100%;
	height: 100%;
	display: block;
	background: linear-gradient(to bottom,rgba(0,0,0,0) 0,rgba(0,0,0,0.42) 80%,rgba(0,0,0,0.88) 100%);
}
/** Hover Event */
.ps-img-hover {
	display: block;
	transition: all .25s ease-in-out;
	opacity: .9;
}
.ps-img-hover:hover {
	opacity: 1;
}

/** Hover Div */
.ps-card-hover .card {
	transition: all .25s ease-in;
	border: 1px solid <?php echo @$card_border_color; ?>;
}
.ps-card-hover .card:hover {
	/*border-color: '#333';*/
	background-color: rgba(250,250,250, .7);
	border: 1px solid <?php echo @$card_border_color_hover; ?>;
}

/** Top label */
.ps-top-badge {
    position: absolute;
    z-index: 100;
    font-size: 1rem;
    top: -0.3rem;
    right: 0.6rem;
    /* background-color: #B2DFDB; */
    margin: 0;
    /* color: green; */
    font-weight: normal;
}

/** Top label */
.ps-middle-badge {
    position: absolute;
    z-index: 100;
    font-size: 1rem;
    bottom: 58%;
    right: 0.6rem;
    /* background-color: #B2DFDB; */
    margin: 0;
    /* color: green; */
    font-weight: normal;
}

/* Square btn */
.ps-sq-btn {
	border-radius: 0;
}

/* Hero Text */
.ps-hero-wrapper {
	width: 100%;
	/*min-height: 380px;*/
	position: relative;
	/** Image  */
	background-position: center;
    background-repeat: no-repeat;
    background-size: cover;
}
.ps-hero-wrapper:after {
	content: '';
	position: absolute;
	top: 0;
	width: 100%;
	/*height: 380px;*/
	background: linear-gradient(to bottom,rgba(0,0,0,0) 0,rgba(0,0,0,0.70) 70%,rgba(0,0,0,0.60) 100%);
	opacity: 5;
}
.ps-hero-text {
	position: absolute;
	top: 80px;
	z-index: 5;
	color: <?php echo @$ps_hero_text_color; ?>;
}

/* Sticky Nav */
.sticky {
    position: fixed;
    width: 100%;
    left: 0;
    top: 0;
    z-index: 100;
    border-top: 0;
    background: <?php echo @$sticky_bg_color; ?>;
}

/* Block quotes */
blockquote {
  /*font: 1.2em/1.6em Georgia, "Times New Roman", Times, serif;*/
  background: url(../../img/core/close-quote.gif) no-repeat right bottom;
  background-color: <?php echo @$blockquote_bg_color; ?>;
  padding: 5px 5px 5px 22px;
  text-indent: -18px;
  font-size: 0.9rem;
}
blockquote:first-letter {
  background: url(../../img/core/open-quote.gif) no-repeat left top;
  padding-left: 18px;
  font: italic 1.4em Georgia, "Times New Roman", Times, serif;
}

/* Main Footer */
.main-footer {
	color: <?php echo @$main_footer_text_color; ?>;
	background: <?php echo @$main_footer_bg_color; ?>;
}
.main-footer p {
	font-size: 0.9rem;
}
.main-footer h5 {
	color: <?php echo @$main_footer_head_color; ?>;
}
.main-footer .footer-title {
	color: <?php echo @$main_footer_title_color; ?>;
	padding: 10px 0px;
	border-bottom: 1px solid <?php echo @$main_footer_title_bd_color; ?>;
}
/* Lower Footer */
.lower-footer {
	font-size: 0.85rem;
    background: <?php echo @$lower_footer_bg_color; ?>;
    color: <?php echo @$lower_footer_color; ?>;
}

/* custom Carousel Slider */
.ps-carousel .carousel-item img {
	width: 100%;
	object-fit: cover;
}
.ps-carousel .nav {
	padding: 0;
}
.ps-carousel .nav-link {
	padding: 0px 5px 0px 0px;
}
.ps-carousel .nav-link img {
	padding: 0;
	width: 100%;
	object-fit: cover;
}

/* Comments */
.comments .comment {
	border-bottom: 1px solid <?php echo @$review_bd_color; ?>;
}

/* Review */
.review p {
	font-size: 0.85rem;
}
.review .meta {
	font-size: 0.85rem;
}
.reviews .review {
	border-bottom: 1px solid #ddd;
}
.review-input {
	font-size: 0.85rem;
}
.review-input textarea {
	background-color: white;
}

/* bootstarp */
.card,
.card-img-top {
	border-radius: 0;
}
.card .card-body {
	border: 1px solid #eee;
}

.form-control{
  -webkit-border-radius: 0;
     -moz-border-radius: 0;
          border-radius: 0;
}

@media (min-width: 576px) {}

@media (min-width: 768px) {
	.padding-0-first{
		padding-right:5px;
	}
	.padding-0{
	    padding-right:5px;
	    padding-left:1px;
	}

	.padding-1-first{
		padding-right:10px;
	}
	.padding-1{
	    padding-right:10px;
	    padding-left:1px;
	}
}

@media (min-width: 992px) {
}

@media (min-width: 1200px) {}

/* theme */
header {
	/*background-color: #EFEFEF;*/
}

/* Home page Hero Text & From */
.hero-text-home {
	height: 380px;
}
.hero-text-home:after {
	height: 380px;
}
.hero-text h1 { font-weight: 900; }
.hero-form {
	position: absolute;
	z-index: 5;
	top: 180px;
	width: inherit;
}
.main-search-form{
	background: hsla(0,0%,100%,.6);
}
.main-search-form label {
	justify-content: left;
}

/** Chosen */
.chosen-container .chosen-results li {
	padding: 8px !important;
	font-size: 1rem;
}
.chosen-container-single .chosen-default,
.chosen-container-single .chosen-single {
	border-radius: 0 !important;
	padding: 8px !important;
	height: auto !important;
	font-size: 1rem;
}

/* Navigation */
.main-nav {
	background-color: <?php echo @$main_nav_bg_color; ?>;
	color: <?php echo @$main_nav_text_color; ?>;
}
.main-nav .nav a {
	color: <?php echo @$main_nav_text_color; ?> !important;	
}

/* Slider */
#slider-range {
	/*margin-top: 10px;*/
}

/* Popular places */
.popular-cities .card-img-top {
	height: 210px;
}

/* Popular hotels */
.popular-hotels .card-img-top {
	height: 150px;
}
.popular-hotels .card-body {
	padding: 10px;
}
.popular-hotels .hotel-title {
	font-size: 1rem;
	line-height: 0.4rem;
	margin: 5px 0px;
}
.popular-hotels .hotel-info {
	font-size: 0.8rem;
	line-height: 0.6rem;
}

/* Raty rating */
.raty {
	color: orange;
	margin: 10px 0px;
}
.raty i {
	font-size: 17px;
}

/* Popular Rooms */
.popular-rooms .card-body {
	padding: 10px;
}
.popular-rooms .city-info {
	font-size: 0.8rem;
}
.popular-rooms .room-info p {
	font-size: 0.8rem;
	padding: 0;
	margin: 0;
}

/* City Hero Text */
.city-hero-text {
	height: 200px;
}
.city-hero-text:after {
	height: 200px;
	background: linear-gradient(to bottom,rgba(0,0,0,0) 0,rgba(0,0,0,0.70) 70%,rgba(0,0,0,0.60) 100%);
}
.city-hero-text .hotel-title {
	top: 100px;
}
.city-hero-text .hotel-map {
	position: relative;
	top: 120px;
	right: 0px;
}

/* Hotel Hero Text */
.hotel-hero-text {
	height: 200px;
}
.hotel-hero-text:after {
	height: 200px;
	background: linear-gradient(to bottom,rgba(0,0,0,0) 0,rgba(0,0,0,0.70) 70%,rgba(0,0,0,0.60) 100%);
}
.hotel-hero-text .hotel-title {
	top: 50px;
}
.hotel-hero-text .hotel-review {
	top: 50px;
	right: 0px;
}
.hotel-hero-text .hotel-review span {
	text-decoration: underline;
}

.hotel-review-modal .hotel-review p {
	font-size: 0.8rem;
}

/* Hotel List */
.hotel-list .card-body {
	padding: 0px;
}
.hotel-list .hotel-image {
	padding-right: 0;
}
.hotel-list .hotel-info {
	background-color: <?php echo @$hotel_info_bg_color; ?>;
	padding: 10px 20px;
}
.hotel-list .hotel-info p {
	font-size: 0.9rem;
	padding: 0;
	margin: 0;
}

/** Advanced Search */
.hotel-search-form {
	background: linear-gradient(to bottom,rgba(81, 91, 97, 0.1) 0,rgba(81, 91, 97, 0.4) 50%,rgba(81, 91, 97, 0.4) 100%);;
}

/* City Page: City Info */
.ps-text-layer .card-text {
	color: <?php echo @$ps_card_text_color; ?>;
}

/* Filter Groups */
.filter_group {
	font-size: 0.8rem;
}

/** Hotel Summary */
.hotel-summary {
	<!-- padding: 0; -->
	background-color: <?php echo @$hotel_summary_bg_color; ?>;
	<!-- padding: 20px 10px; -->
}
.hotel-summary p {
	font-size: 0.9rem;
}
.hotel-summary .hotel-info p {
	font-size: 0.9rem;
}
.hotel-features {
	<!-- background-color: #fefefe; -->
	padding: 20px 10px;
}
.hotel-features p {
	font-size: 0.8rem;
	line-height: 0.8rem;
}

/** Room list */
.room-list .card-body {
	padding: 10px 0px 0px 0px;
	border: 1px solid <?php echo @$room_list_card_bd_color; ?>;
}
.room-list .room-detail {
	background: <?php echo @$room_detail_bg_color; ?>;
}
.room-list .room-info {
	padding: 10px 0px;
}
.room-list .room-info p {
	font-size: 0.8rem;
	padding: 0;
	margin: 0;
}

/* Room features */
.room-features p {
	font-size: 0.8rem;
	padding: 0;
	margin: 0;
}

/* Hotel Hero Text */
.room-hero-text {
	height: 200px;
}
.room-hero-text:after {
	height: 200px;
	background: linear-gradient(to bottom,rgba(0,0,0,0) 0,rgba(0,0,0,0.70) 70%,rgba(0,0,0,0.60) 100%);
}
.room-hero-text .room-title {
	top: 28px;
}
.room-hero-text .room-map {
	position: relative;
	top: 50px;
	right: 0px;
}

.comments p,
.comments span {
	font-size: 0.82rem;
	margin: 0;
}
.comment_textarea {
	/*background: #fff;*/
	color: <?php echo @$review_input_color; ?>;
}

/** Booking Info */
.booking-detail p strong {
	display: inline-block;
	width: 110px;
	font-weight: bold;
}