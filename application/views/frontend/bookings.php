
<div class="container pt-3 pb-5">
	<div class="popular-bookings mb-2">

		<h4>
			My Bookings List
		</h4>
		
		<div class="row">

			<?php if ( !empty( $bookings )): $i = 0; foreach ( $bookings as $book ): ?>

			<div class="col-12 mb-1 col-md-4 padding-0">

				<?php $booking_template = $template_path .'/components/bookings/booking.php'; ?>

				<?php 
					// if there is an booking, set the booking
					$booking = ( isset( $book ))? $book: $this->ps_dummy->get_dummy_booking();

					$this->load->view( $booking_template, array( 'booking' => $booking ));
				?>
				
			</div>

			<?php $i++; endforeach; endif; ?>

			<div id="loadMoreBookings" class="col-12">
				<div class="col-12 text-center">			
					<span class="loadMoreBookings btn btn-sm grow" href="#" page="1">
						<i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Load More Bookings
					</span>
				</div>
			</div>

		</div>
	</div>

	<input type="hidden" id="totalBookingsCount" value="<?php echo $total_bookings; ?>"/>

	<input type="hidden" id="bookingsLimit" value="<?php echo $limit; ?>"/>
</div>

<div class="col-12 mb-1 col-md-4 padding-0 d-none bookingToClone">
	<div class="card">

		<span class="ps-middle-badge badge booking__booking_status"></span>

		<a class="booking__booking_url">
			<img width="358px" height="150px" class="card-img-top ps-img-hover booking__booking_img">
		</a>
		
		<div class="card-body" style="padding: 10px;">
			
			<a class="booking__booking_url">
				
			<h6 class="popular-title mb-3 booking__booking_hotel_name"></h6>

				<p class="room-info">
					<span style="display: inline-block; width: 45px">Room:</span>
					<span class="booking__booking_room_name"></span>

					<br>
					<span style="display: inline-block; width: 45px">From:</span>
					<span class="booking__booking_start_date"></span>

					<br>
					<span style="display: inline-block; width: 45px">To:</span>
					<span class="booking__booking_end_date"></span>
				</p>

			</a>

		</div>
	</div>
</div>

<script type="text/javascript">
function bookings()
{
	var totalBookingsCount = $('#totalBookingsCount').val();
	var limit = $('#bookingsLimit').val();

	function hideLoadMore()	
	{
		if ( $('.loadMoreBookings').attr('page') * limit >= totalBookingsCount ) {
			$('#loadMoreBookings').hide();
		}		
	}

	hideLoadMore();

	$('.loadMoreBookings').click(function(){

		$.ajax({
			type: 'POST',
			url: userUrl + '/loadmore_bookings',
			data: get_data( $(this).attr('page')),
			dataType:'json',
			success:function(resp){
				
				if ( resp.status == 'success' ) {
					var currentPageId = parseInt($('.loadMoreBookings').attr('page'));
					$('.loadMoreBookings').attr('page', currentPageId + 1 );

					console.log( resp.data );

					$.each(resp.data,function(index,value){

						appendBookings(value).insertBefore('#loadMoreBookings');
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
	 * Appends bookings.
	 *
	 * @param      {<type>}  booking    The booking
	 * @return     {<type>}  { description_of_the_return_value }
	 */
	function appendBookings( booking )
	{
		var bookingUrl = "<?php echo $module_site_url .'/booking_detail/'; ?>";
		var uploadPath = "<?php echo base_url('/uploads/'); ?>";

		var bookingClone = $('.bookingToClone')
			.clone()
			.removeClass('bookingToClone d-none')
			.find('.booking__booking_status').html(booking.booking_status).end()
			.find('.booking__booking_url').attr('href',bookingUrl+booking.booking_id).end()
			.find('.booking__booking_img').attr('src',uploadPath+booking.hotel.default_photo.img_path).end()
			.find('.booking__booking_hotel_name').html(booking.hotel.hotel_name).end()
			.find('.booking__booking_room_name').html(booking.room.room_name).end()
			.find('.booking__booking_start_date').html(booking.booking_start_date).end()
			.find('.booking__booking_end_date').html(booking.booking_end_date).end();

		var bookingBadge = "badge-primary";
		switch( bookingBadge ) {
			case "CONFIRMED":
				bookingBadge = "badge-success";
				break;
			case "CANCELLED":
				bookingBadge = "badge-danger";
				break;
		}

		bookingClone.find('.booking__booking_status').addClass(bookingBadge);

		return bookingClone;
	}
}
</script>