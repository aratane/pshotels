
<?php if ( $this->ps_auth->is_logged_in() || ( $reviews_count > 0 )): ?>
	<h4 class="mb-2">Guests' Reviews</h4>
<?php endif; ?>

<div class="reviews">

	<?php if ( $this->ps_auth->is_logged_in()): ?>

		<div class="reviewFlashMessage">
			<p id="reviewError" class="text-danger fade"></p>

			<p id="reviewSuccess" class="text-success fade"></p>
		</div>
		
		<!-- review input -->
		<div class="review-input row py-2">

			<div class="review-avatar col-2 padding-0-first">

				<?php $current_user = $this->ps_auth->get_user_info(); ?>
				
				<a href="<?php echo $module_site_url .'/profile/'. $current_user->user_id; ?>">

					<?php 
						// get dummy photo
						$img = $this->ps_dummy->get_dummy_photo();

						// if there is an image, set the image
						if ( !empty( $current_user->user_profile_photo )) $img->img_path = $current_user->user_profile_photo;
					?>

					<img class="img-fluid" width="80%" alt="<?php echo $img->img_path; ?>" src="<?php echo base_url( '/uploads/'. $img->img_path ); ?>">
				</a>
			</div>

			<div class="col-10 padding-0">
				<textarea id="review_desc" class="ps-input" placeholder="What do you think?" rows="3"></textarea>

				<?php $rvcats = $this->ReviewCategory->get_all_by()->result(); ?>

				<?php if ( !empty( $rvcats )): foreach ( $rvcats as $rvcat ): ?>

					<div class="row">
						<div class="col-auto">
							<div class="raty" id="<?php echo $rvcat->rvcat_id; ?>"></div>	
						</div>
						<div class="col-auto pt-2">
							<?php echo $rvcat->rvcat_name; ?>							
						</div>
					</div>

					<input type="hidden" class="ratings_<?php echo $rvcat->rvcat_id; ?>"/>

				<?php endforeach; endif; ?>
			</div>

			<div class="col w-100">
				<button id="review_submit" type="button" class="btn btn-sm btn-outline-dark float-right">Submit</button>
			</div>

		</div>	

	<hr>

	<?php else: ?>
	
	<p class="text-center">
		<a class="btn btn-success" href="#" data-toggle='modal' data-target='#loginModal'>Add Review for this room</a>
	</p>

	<?php endif; ?>

	<!-- review counts -->
	<p id="reviewCount" class="muted lead <?php if ( isset( $reviews ) && $reviews_count == 0 ) echo 'fade'; ?>">
		<?php echo $reviews_count; ?>
		review<?php if ( $reviews_count > 1 ) echo "s"; ?>
	</p>

	<!-- reviews -->
	<?php if ( isset( $reviews ) && !empty( $reviews )): ?>

		<?php foreach ( $reviews as $review ): ?>

			<div class="review row py-2">

				<div class="review-avatar col-2 padding-0-first">
					
					<a href="<?php echo $module_site_url .'/profile/'. $review->user->user_id; ?>">

						<?php 
							// get dummy photo
							$img = $this->ps_dummy->get_dummy_photo();

							// if there is an image, set the image
							if ( !empty( $review->user->user_profile_photo )) $img->img_path = $review->user->user_profile_photo;
						?>

						<img class="img-fluid" width="80%" alt="<?php echo $img->img_path; ?>" src="<?php echo base_url( '/uploads/'. $img->img_path ); ?>">
					</a>
				</div>

				<div class="col-7 padding-0">
					<p class="meta">
						<span class="meta-date">
							<strong class="review_username mr-2"><?php echo $review->user->user_name; ?></strong>
							<span class="review_date"><?php echo $review->added_date; ?></span>
						</span>
					</p>

					<p class="review_desc"><?php echo $review->review_desc; ?></p>
				</div>

				<div class="col-3 padding-0">
					<?php $ratings = $this->Review->get_ratings( array( 'review_id' => $review->review_id ), true )->result(); ?>
						
					<?php if ( !empty( $ratings )): ?>
						
						<span class="text-muted">Total Rating: </span><br>
						<span class="badge badge-success"><?php echo $ratings[0]->final_rating; ?></span>

					<?php endif; ?>
				</div>
				
			</div>

		<?php endforeach; ?>

		<input type="hidden" id="totalReviewsCount" value="<?php echo $reviews_count; ?>"/>

		<input type="hidden" id="reviewLimit" value="<?php echo $reviews_limit; ?>"/>

		<div id="loadMoreReviews" class="row">
			<div class="col-12 text-center">			
				<span class="loadMoreReviews btn btn-sm grow" href="#" page="1">
					<i class="fa fa-chevron-circle-down" aria-hidden="true"></i> Load More Reviews
				</span>
			</div>
		</div>

	<?php endif; ?>

</div>

<script type="text/javascript">
	function reviews()
	{
		var totalReviewsCount = $('#totalReviewsCount').val();
		var reviewLimit = $('#reviewLimit').val();

		// hide 'load more' button
		hideLoadMoreReviews();

		// review category events
		reviewCategory();

		// submit coments
		$('#review_submit').click(function(){

			$.ajax({
				type: 'POST',
				url: userUrl + '/review',
				data:{
					"room_id": "<?php echo $room->room_id; ?>",
					<?php if ( !empty( $rvcats )): foreach ( $rvcats as $rvcat ): ?>

						"<?php echo $rvcat->rvcat_id; ?>": $('.ratings_<?php echo $rvcat->rvcat_id; ?>').val(),

					<?php endforeach; endif; ?>
					"review_desc": $('#review_desc').val()
				},
				dataType: 'json',
				success:function(response){

					$('#reviewFlashMessage p').removeClass('show');

					if ( response.status == "success" ) {

						// reviews count
						var txt = " review";
						if ( response.data.count > 1 ) txt = " reviews";

						$('#reviewCount')
							.removeClass('fade')
							.html(response.data.count.toString()+txt);
						
						// add review
						appendComment(response.data.review).insertAfter('#reviewCount');

						// clear score
						$('.raty').raty( 'score', 0 );

						// clear input
						$('#review_desc').val('');
						$('.reviewFlashMessage p').html('');

					} else {

						$('#reviewError').html( response.message ).fadeIn('slow').addClass('show');
						console.log(response);
					}
				}
			});
		});

		// load more reviews
		$('#loadMoreReviews .loadMoreReviews').click(function(){

			$.ajax({
				type: 'POST',
				url: ajaxUrl + '/loadmore_reviews',
				data: {
					'page': $(this).attr('page'),
					'room_id': "<?php echo $room->room_id; ?>"
				},
				dataType:'json',
				success:function(resp){
					
					if ( resp.status == 'success' ) {
						var currentPageId = parseInt($('#loadMoreReviews .loadMoreReviews').attr('page'));
						$('#loadMoreReviews .loadMoreReviews').attr('page', currentPageId + 1 );

						$.each(resp.data,function(index,value){

							appendComment(value).insertBefore('#loadMoreReviews');

							hideLoadMoreReviews();
						});
					} else {
						console.log( resp );
					}
				}
			});
		});

		// append review
		function appendComment( review )
		{
			var profileUrl = "<?php echo $module_site_url .'/profile/'; ?>";

			return $('.reviewToClone')
				.clone()
				.removeClass('reviewToClone d-none')
				.find('.review-avatar a').attr('href',profileUrl+review.user.user_id).end()
				.find('.review-avatar img').attr('src',uploadPath+review.user.user_profile_photo).end()
				.find('img').attr('src',review.user.user_profile_photo).end()
				.find('.review_username').html(review.user.user_name).end()
				.find('.review_date').html(review.added_date).end()
				.find('.review_desc').html(review.review_desc).end()
				.find('.review_final_rating').html(review.final_rating.final_rating).end();
		}

		function hideLoadMoreReviews()	
		{		
			console.log( $('.loadMoreReviews').attr('page'));
			if ( $('.loadMoreReviews').attr('page') * reviewLimit >= totalReviewsCount ) {
				$('#loadMoreReviews').hide();
			}		
		}

		/** Reviews by categories */
		function reviewCategory()
		{
			<?php if ( !empty( $rvcats )): foreach ( $rvcats as $rvcat ): ?>

				$('#<?php echo $rvcat->rvcat_id; ?>').raty({
					starType: 'i',
					score: 0,
					click: function(score, evt) {
						$('.ratings_' + this.id ).val( score );
					}
				});

			<?php endforeach; endif; ?>
		}
	}
</script>

<!-- reviews clone -->
<div class="reviewToClone review row py-2 d-none">

	<div class="review-avatar col-2 padding-0-first">
		
		<a href="#">

			<img class="img-fluid" width="80%" src="">
		</a>
	</div>

	<div class="col-7 padding-0">
		<p class="meta">
			<span class="meta-date">
				<strong class="review_username mr-2"></strong>
				<span class="review_date"></span>
			</span>
		</p>

		<p class="review_desc"></p>
	</div>

	<div class="col-3 padding-0">				
		<span class="text-muted">Total Rating: </span><br>
		<span class="badge badge-success review_final_rating"></span>
	</div>
	
</div>