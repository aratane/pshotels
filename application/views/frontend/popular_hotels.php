
<div class="container pt-3 pb-5">
	<div class="popular-hotels mb-4">

		<h2>Popular Hotels</h2>
		
		<p class="lead">
			<?php echo get_msg( 'popular_hotel_slogan' ); ?>
		</p>

		<div class="row pl-2">

			<?php if ( !empty( $popular_hotels )): foreach ( $popular_hotels as $hotel ): ?>

			<div class="col-12 mb-1 col-md-4 padding-0">

				<?php $hotel_template = $template_path .'/components/home/popular_hotel.php'; ?>

				<?php $this->load->view( $hotel_template, array( 'hotel_info' => $hotel )); ?>
				
			</div>

			<?php endforeach; endif; ?>

			<div id="loadMoreHotels" class="col-12">
				<div class="col-12 text-center">			
					<span class="loadMoreHotels btn btn-sm grow" href="#" page="1">
						<i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Load More Hotels
					</span>
				</div>
			</div>

		</div>

		<input type="hidden" id="totalHotelsCount" value="<?php echo $total_hotels; ?>"/>

		<input type="hidden" id="hotelsLimit" value="<?php echo $limit; ?>"/>
	</div>
</div>

<div class="col-12 mb-1 col-md-4 padding-0 hotelToClone d-none">
	<div class="card">

		<a class="hotel__url">
			<img width="358px" height="150px" class="card-img-top ps-img-hover hotel__img" alt="Card image cap">
		</a>
		
		<div class="card-body">
			<p class="hotel-title mb-3 hotel__name"></p>
			
			<div class="raty hotel__raty"></div>
			<p class="text-muted hotel-info mb-4 hotel__no_raty">No rating</p>

			<p class="hotel-info hotel__hotel_ctry"></p>
			<p class="hotel-info hotel__room_types_count"></p>
		</div>
	</div>
</div>

<script type="text/javascript">
function popular_hotels()
{
	loadRatings();

	var totalHotelsCount = $('#totalHotelsCount').val();
	var limit = $('#hotelsLimit').val();

	function hideLoadMore()	
	{
		if ( $('.loadMoreHotels').attr('page') * limit >= totalHotelsCount ) {
			$('#loadMoreHotels').hide();
		}		
	}

	hideLoadMore();

	$('.loadMoreHotels').click(function(){

		$.ajax({
			type: 'POST',
			url: ajaxUrl + '/loadmore_popular_hotels',
			data: get_data( $(this).attr('page')),
			dataType:'json',
			success:function(resp){
				
				if ( resp.status == 'success' ) {
					var currentPageId = parseInt($('.loadMoreHotels').attr('page'));
					$('.loadMoreHotels').attr('page', currentPageId + 1 );

					console.log( resp.data );

					$.each(resp.data,function(index,value){

						appendHotels(value).insertBefore('#loadMoreHotels');
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
	 * Appends hotels.
	 *
	 * @param      {<type>}  hotel    The hotel
	 * @return     {<type>}  { description_of_the_return_value }
	 */
	function appendHotels( hotel )
	{
		var hotelUrl = "<?php echo $module_site_url .'/hotel/'; ?>";
		var uploadPath = "<?php echo base_url('/uploads/'); ?>";

		var hotelClone = $('.hotelToClone')
			.clone()
			.removeClass('hotelToClone d-none')
			.find('.hotel__url').attr('href',hotelUrl+hotel.hotel_id).end()
			.find('.hotel__img').attr('src',uploadPath+hotel.default_photo.img_path).end()
			.find('.hotel__name').html(hotel.hotel_name).end()
			.find('.hotel__hotel_ctry').html(hotel.city_name + ", " + hotel.country_name).end()
			.find('.hotel__room_types_count').html(hotel.room_types_count + " room types").end();

		if ( hotel.final_rating != null && hotel.final_rating > 0 ) {
			hotelClone.find('.hotel__raty').raty({
				starType: 'i',
				readOnly: true,
				score: hotel.final_rating
			});

			hotelClone.find('.hotel__no_raty').remove();
		} else {
			hotelClone.find('.hotel__raty').remove();
		}

		return hotelClone;
	}

	function loadRatings()
	{
		<?php if ( !empty( $popular_hotels )): foreach ( $popular_hotels as $hotel ): ?>

			<?php if ( isset( $hotel->hotel_star_rating ) && $hotel->hotel_star_rating != 0 ): ?>
			
			$('#<?php echo $hotel->hotel_id; ?>').raty({
				starType: 'i',
				readOnly: true,
				score: <?php echo $hotel->hotel_star_rating; ?>
			});

			<?php endif; ?>

		<?php endforeach; endif; ?>
	}
}
</script>