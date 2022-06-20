
<div class="container pt-3 pb-5">
	<div class="popular-cities mt-1 mb-4">
		
		<h2>Popular Destinations</h2>

		<p class="lead">
			<?php echo get_msg( 'popular_city_slogan' ); ?>
		</p>
	</div>

	<div class="row pl-3">

		<?php if (!empty( $popular_cities )): foreach ( $popular_cities as $city ): ?>

			<div class="col-12 mb-1 col-md-4 padding-0">

				<?php $city_template = $template_path .'/components/home/popular_city.php'; ?>

				<?php $this->load->view( $city_template, array( 'city_info' => $city )); ?>
				
			</div>

		<?php endforeach; endif; ?>

		<div id="loadMoreCities" class="col-12">
			<div class="col-12 text-center">			
				<span class="loadMoreCities btn btn-sm grow" href="#" page="1">
					<i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Load More Cities
				</span>
			</div>
		</div>
	</div>

	<input type="hidden" id="totalCitiesCount" value="<?php echo $total_cities; ?>"/>

	<input type="hidden" id="citiesLimit" value="<?php echo $limit; ?>"/>
</div>

<div class="col-12 mb-1 col-md-4 padding-0 cityToClone d-none">

	<div class="card">

		<a class="ps-img-layer ps-img-hover city__url" href="#">
			<img width="358px" height="210px" class="card-img-top city__img" alt="Card image cap">
		</a>

		<a class="ps-text-layer city__url">
			<div class="caption">
				<h4 class="card-title city__name"></h4>

				<p class="card-text city__hotel_count"></p>

			</div>
		</a>
	</div>
</div>

<script type="text/javascript">
function popular_cities()
{
	var totalCitiesCount = $('#totalCitiesCount').val();
	var limit = $('#citiesLimit').val();

	function hideLoadMore()	
	{
		if ( $('.loadMoreCities').attr('page') * limit >= totalCitiesCount ) {
			$('#loadMoreCities').hide();
		}		
	}

	hideLoadMore();

	$('.loadMoreCities').click(function(){

		$.ajax({
			type: 'POST',
			url: ajaxUrl + '/loadmore_popular_cities',
			data: get_data( $(this).attr('page')),
			dataType:'json',
			success:function(resp){
				
				if ( resp.status == 'success' ) {
					var currentPageId = parseInt($('.loadMoreCities').attr('page'));
					$('.loadMoreCities').attr('page', currentPageId + 1 );

					$.each(resp.data,function(index,value){

						appendCities(value).insertBefore('#loadMoreCities');
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
	 * Appends cities.
	 *
	 * @param      {<type>}  city    The city
	 * @return     {<type>}  { description_of_the_return_value }
	 */
	function appendCities( city )
	{
		var cityUrl = "<?php echo $module_site_url .'/city/'; ?>";
		var uploadPath = "<?php echo base_url('/uploads/'); ?>";

		return $('.cityToClone')
			.clone()
			.removeClass('cityToClone d-none')
			.find('.city__url').attr('href',cityUrl+city.city_id).end()
			.find('.city__img').attr('src',uploadPath+city.default_photo.img_path).end()
			.find('.city__name').html(city.city_name).end()
			.find('.city__hotel_count').html(city.hotel_count + " hotels").end();
	}
}
</script>