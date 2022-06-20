
<div class="container pt-3 pb-5">
	<div class="popular-rooms mb-4 ps-card-hover">

		<h2>Popular Rooms</h2>
		
		<p class="lead">
			<?php echo get_msg( 'popular_room_slogan' ); ?>
		</p>

		<?php $room_template = $template_path .'/components/home/popular_room.php'; ?>

		<div class="row pl-2">

			<?php if ( !empty( $popular_rooms )): foreach ( $popular_rooms as $room ): ?>

			<div class="col-12 col-lg-6 padding-0">

				<?php $this->load->view( $room_template, array( 'room_info' => $room )); ?>

			</div>

			<?php endforeach; endif; ?>

			<div id="loadMoreRooms" class="col-12">
				<div class="col-12 text-center">			
					<span class="loadMoreRooms btn btn-sm grow" href="#" page="1">
						<i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Load More Rooms
					</span>
				</div>
			</div>

		</div>

		<input type="hidden" id="totalRoomsCount" value="<?php echo $total_rooms; ?>"/>

		<input type="hidden" id="roomsLimit" value="<?php echo $limit; ?>"/>
	</div>
</div>

<div class="col-12 col-lg-6 padding-0 roomToClone d-none">
	<div class="card mb-2">

		<div class="card-body">

			<span class="ps-top-badge badge badge-success room__promotion"></span>

			<a class="room__url">

				<div class="row">

					<div class="col-6">

						<img class="mr-3 ps-img-hover img-fluid room__img" alt="Generic placeholder image">

					</div>

					<div class="col-6">
						<h5 class="room-title mt-0 mb-1 room__name"></h5>

						<p class="city-info room__hotel_city"></p>

						<div class="room-info">
							
							<p class="mt-2">
								<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-limit.png' ); ?>"/>
								<span class="room__capacity"></span>
							</p>
							<p class="mt-2">
								<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-size.png' ); ?>"/>
								<span class="room__size"></span>
							</p>
							<p class="mt-2">
								<img class="mr-2" src="<?php echo base_url( 'assets/img/icons/room-beds.png' ); ?>"/>
								<span class="room__beds"></span>
							</p>
						</div>
					</div>
				</div>
			</a>
		</div>
	</div>
</div>

<script type="text/javascript">
function popular_rooms()
{
	var totalRoomsCount = $('#totalRoomsCount').val();
	var limit = $('#roomsLimit').val();

	function hideLoadMore()	
	{
		if ( $('.loadMoreRooms').attr('page') * limit >= totalRoomsCount ) {
			$('#loadMoreRooms').hide();
		}		
	}

	hideLoadMore();

	$('.loadMoreRooms').click(function(){

		$.ajax({
			type: 'POST',
			url: ajaxUrl + '/loadmore_popular_rooms',
			data: get_data( $(this).attr('page')),
			dataType:'json',
			success:function(resp){

				if ( resp.status == 'success' ) {
					var currentPageId = parseInt($('.loadMoreRooms').attr('page'));
					$('.loadMoreRooms').attr('page', currentPageId + 1 );

					$.each(resp.data,function(index,value){
						appendRooms(value).insertBefore('#loadMoreRooms');
					});

					hideLoadMore();
				} else {
					console.log( resp );
				}
			}
		});
	});

	/**
	 * Conditions based on usage
	 *
	 * @param      {<type>}  pageId  The page identifier
	 * @return     {<type>}  The data.
	 */
	function get_data( pageId )
	{
		var obj = {
			page: pageId
		};

		return obj;
	}

	/**
	 * Appends rooms.
	 *
	 * @param      {<type>}  room    The room
	 * @return     {<type>}  { description_of_the_return_value }
	 */
	function appendRooms( room )
	{
		var roomUrl = "<?php echo $module_site_url .'/room/'; ?>";
		var uploadPath = "<?php echo base_url('/uploads/'); ?>";

		var roomClone = $('.roomToClone')
			.clone()
			.removeClass('roomToClone d-none')
			.find('.room__url').attr('href',roomUrl+room.room_id).end()
			.find('.room__img').attr('src',uploadPath+room.default_photo.img_path).end()
			.find('.room__name').html(room.room_name).end()
			.find('.room__hotel_city').html(room.hotel.hotel_name+","+room.city.city_name).end()
			.find('.room__capacity').html(room.capacity).end()
			.find('.room__size').html(room.room_size).end()
			.find('.room__beds').html(room.room_no_of_beds+" beds").end();

		if ( room.promotion != null ) {
			roomClone.find('room__promotion').html(room.promotion);
		} else {
			roomClone.find('room__promotion').remove();
		}

		return roomClone;
	}
}
</script>