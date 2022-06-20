
<?php $this->load->view( $template_path .'/components/city/city_hero_text.php' ); ?>

<div class="container box-shadow"  style="background-color: white;">

	<div class="row my-2">
		
		<div class="col-3 padding-1-first pt-3 d-none d-lg-block" style="background-color: #f9f9f9">

			<?php $this->load->view( $template_path .'/components/city/main_filter.php' ); ?>
			
			<?php $this->load->view( $template_path .'/components/city/secondary_filter.php' ); ?>

		</div>

		<div class="col-12 col-lg-9 padding-1 pl-1 pt-3">

			<!-- hotel list -->
			<div class="hotel-list mb-4 ps-card-hover">

				<?php $this->load->view( $template_path .'/components/city/hotel_list.php', array( 'hotels' => $hotels )); ?>
	
			</div>

			<!-- hotels on map -->
			<div class="map d-none">
				<h4 class="buttonload text-center loading-map">
					<i class="fa fa-refresh fa-spin"></i>
					<?php echo $this->lang->line('f_load_map'); ?>
				</h4>

				<div id="map"></div>
			</div>

		</div>
	</div>

</div><!-- end of container -->

<?php $this->load->view( $template_path .'/components/city/map_modal.php' ); ?>

<?php $this->load->view( $template_path .'/components/city/hotel_info_card_clone.php' ); ?>

<script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDWRJCZRSf2XNckr_WXepCZnovyqOB4c7Q"></script>

<script src="<?php echo base_url('assets/googlemap/markercluster.js'); ?>"></script>

<script type="text/javascript">
function loadmore_hotels()
{
	var totalHotelsCount = $('#totalHotelsCount').val();
	var hotelLimit = $('#hotelLimit').val();

	// load map
	$('.view-map').click(function(){

		toggleMap();
	});

	// load more hotels
	$('#loadMoreHotels .loadMoreHotels').click(function(){

		loadHotels();
	});

	// each hotel info type clicked
	$('.hinfo_typ').click(function(){

		refilterHotels();
	});

	// on city changed
	$('#city_id, #searchterm').change(function(){

		refilterHotels();
	});

	// slider range change
	$('#slider-range').on( 'slidestop', function(){

		refilterHotels();
	});

	// hide 'load more' button
	toggleLoadMoreHotels();

	// refilter the page
	function refilterHotels() {
		
		// reset the page
		$('.loadMoreHotels').attr('page','0');
		$('#hotel-list-wrapper').html('');

		// hide map and load list
		$('.hotel-list').removeClass('d-none');
		$('.map').addClass('d-none');
     	$('.view-map').text( 'View Map' );

		// load hotels and maps
		loadHotels();
	}

	// load hotels
	function loadHotels() {

		obj = get_params();
		obj.page = $('.loadMoreHotels').attr('page');
		//obj.city_id = "<?php //echo $city->city_id; ?>";

		$.ajax({
			type: 'POST',
			url: ajaxUrl + '/loadmore_hotels',
			data: obj,
			dataType:'json',
			success:function(resp){
				
				if ( resp.status == 'success' ) {
					var currentPageId = parseInt($('#loadMoreHotels .loadMoreHotels').attr('page'));
					$('#loadMoreHotels .loadMoreHotels').attr('page', currentPageId + 1 );

					$.each(resp.data,function(index,value){

						cloneHotel(value).appendTo('#hotel-list-wrapper');

						toggleLoadMoreHotels();
					});
				} else {
					console.log( resp );
				}
			}
		});
	}

	// append hotel
	function cloneHotel( hotel ) {
		
		// clone hotel card and assign
		var clone = $('.hotelCardClone')
			.clone()
			.removeClass( 'hotelCardClone d-none' )
			.find( '.hotel--url' ).attr( 'href', hotel.url ).end()
			.find( '.hotel--img' ).attr( 'src', hotel.img ).end()
			.find( '.hotel--title' ).html( hotel.hotel_name ).end()
			.find( '.hotel--location' ).html( hotel.city.city_name ).end()
			.find( '.hotel--rating-star' ).attr( 'id', hotel.hotel_id ).end();

		// rating
		if ( typeof hotel.final_rating !== "undefined" && hotel.final_rating !== null ){

			clone.find( '.hotel--rating-text' ).html( hotel.rating_text +' - '+ hotel.final_rating );

			clone.find('#'+ hotel.hotel_id ).raty({
				starType: 'i',
				readOnly: true,
				score: hotel.final_rating
			});	
		}		

		// feature 1
		if ( typeof hotel.feature_names[0] !== "undefined" )
			clone.find( '.hotel--feature-1' ).html( hotel.feature_names[0] );

		// feature 2
		if ( typeof hotel.feature_names[1] !== "undefined" )
			clone.find( '.hotel--feature-2' ).html( hotel.feature_names[1] );

		// promotion
		if ( typeof hotel.promotion !== "undefined" ) 
			clone.find( '.hotel--promo-percent' ).html( hotel.promotion.promo_percent + "% Promotion" );

		// min price
		if ( typeof hotel.hotel_min_price !== "undefined" ) 
			clone.find( '.hotel--min-price' ).html( hotel.hotel_min_price );

		// max price
		if ( typeof hotel.hotel_max_price !== "undefined" ) 
			clone.find( '.hotel--max-price' ).html( hotel.hotel_max_price );

		// hotel lat and lng
		if ( typeof hotel.hotel_lat !== "undefined" && typeof hotel.hotel_lng !== "undefined" )
			clone.find( '.hotel--point' ).val( '{"lat":' + hotel.hotel_lat +',"lng":'+ hotel.hotel_lng +',"title":"'+ hotel.hotel_name +'"}').addClass( 'point' );

		return clone;
	}

	// get parameters
	function get_params() {
		
		var obj = {};
		obj.city_id = $('#city_id').val();
		obj.propertyName = $('#searchterm').val();
		obj.minPrice = $( '.min-price' ).val();
		obj.maxPrice = $( '.max-price' ).val();
		obj.infoTypes = "";

		$.each($('.hinfo_typ'),function(){

			if ( $(this).is(":checked")){
				obj.infoTypes += $(this).val() +"-";
			}
		});

		return obj;
	}

	// hide load more hotels
	function toggleLoadMoreHotels() {		

		//console.log( $('.loadMoreHotels').attr('page'));
		if ( $('.loadMoreHotels').attr('page') * hotelLimit >= totalHotelsCount ) {
			$('#loadMoreHotels').hide();
		} else {
			$('#loadMoreHotels').show();
		}
	}

	// toggle Map
	function toggleMap() {

		// toggle map and hotel list
		$('.hotel-list').toggleClass('d-none');
		$('.map').toggleClass('d-none');

		// toggle text
		var txt = "View Map";
		if ( $( '.view-map' ).text() == "View Map") {
	     	txt = 'Return to list';
			loadMap();
		}
		$( '.view-map' ).text( txt );
	}

	// load google map
	function loadMap() {
		
		$('.loading-map').show();

		var map = new google.maps.Map(document.getElementById('map'),{
			 zoom: 100
		});

		var bounds = new google.maps.LatLngBounds();
		var markers = [];

		var icon = {
			url: "<?php echo base_url('assets/img/core/map_annotation.png'); ?>", 
			scaledSize: new google.maps.Size(30, 50), // scaled size
			origin: new google.maps.Point(0,0), // origin
			anchor: new google.maps.Point(0, 0) // anchor
		};

		$.each($('.point'), function() {
			var point = JSON.parse($(this).val());

			var place = new google.maps.LatLng( point.lat, point.lng );
			bounds.extend(place);

			var contentString = '<h4 class="text-center mb-3"><a href="'+ point.url +'">'+ point.title +'</a></h4>';
				//  +
				// '<img class="float-left pr-3" src="'+ point.img +'" height="100px"/>' +
				// '<small class="muted">'+ point.desc +'</small></p>' +
				// '<p><small class="fa fa-heart mr-3">&nbsp; &nbsp;'+ point.fav +'</small>' + 
				// '<small class="fa fa-thumbs-up mr-3">&nbsp; &nbsp;'+ point.like +'</small>' +
				// '<small class="fa fa-comment mr-3">&nbsp; &nbsp;'+ point.review +'</small></p>';

			var infowindow = new google.maps.InfoWindow({
				content: contentString,
				maxWidth: 300
			});

		    var marker = new google.maps.Marker({
				position: place,
				map: map,
				title: point.title,
				icon: icon
			});

			marker.addListener('click', function() {
				infowindow.open(map, marker);
			});

			markers.push(marker);
		});

		setTimeout(function(){
			var markerCluster = new MarkerClusterer(map, markers, {
				imagePath: '<?php echo base_url("assets/img/core/m"); ?>'
			});

			google.maps.event.trigger(map, 'resize'); 
			map.setZoom( map.getZoom());
			map.fitBounds(bounds);

			$('.loading-map').fadeOut('slow');

			$('#map').css('height', 600);
		}, 500);
	}
}
</script>