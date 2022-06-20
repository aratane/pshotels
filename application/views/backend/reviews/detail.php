<div class="wrapper wrapper-content animated fadeInRight">
	
	<div class="row">
		
		<div class="col-sm-6">
			
			<legend><?php echo get_msg('review_detail')?></legend>
			
			<table class="table table-striped table-bordered">
				
				<tr>
					<th><?php echo get_msg( 'room_name' )?></th>
					<td><?php echo $this->Room->get_one( $review->room_id )->room_name;?></td>
				</tr>
				
				<tr>
					<th><?php echo get_msg( 'user_name' )?></th>
					<td><?php echo $this->User->get_one( $review->user_id )->user_name;?></td>
				</tr>
				
				<tr>
					<th><?php echo get_msg( 'review_desc' )?></th>
					<td><?php echo $review->review_desc;?></td>
				</tr>

				<tr>
					<th><?php echo get_msg('room_rating' ); ?></th>
					<td><?php echo $this->Review->get_ratings( array( 'review_id' => $review->review_id, false ))->result()[0]->final_rating; ?></td>
				</tr>

				<?php $ratings = $this->Review->get_ratings( array( 'review_id' => $review->review_id, true ))->result(); ?>

				<?php if ( !empty( $ratings )): ?>

					<?php foreach ( $ratings as $rating ): ?>

						<tr>
							<th><?php echo $this->ReviewCategory->get_one( $rating->rvcat_id )->rvcat_name; ?></th>
							<th>
								<?php echo $rating->final_rating; ?>
								
								<?php $rate = $rating->final_rating;?>

								<?php $width = $rate * 20;?>

								<div class="progress">
									<div class="progress-bar" role="progressbar" aria-valuenow="<?php echo $rate; ?>" aria-valuemin="0" aria-valuemax="5" style="width: <?php echo $width; ?>%"></div>
								</div>
																
							</th>
						</tr>

					<?php endforeach; ?>

				<?php endif; ?>

			</table>

		</div>

	</div>
		
	<a class="btn btn-primary" href="<?php echo $module_site_url ?>" class="btn"><?php echo get_msg('back_button')?></a>
</div>