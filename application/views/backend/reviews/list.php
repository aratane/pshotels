<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg( 'no' ); ?></th>
		<th><?php echo get_msg( 'user_name' ); ?></th>
		<th><?php echo get_msg( 'review_desc' ); ?></th>
		<th><?php echo get_msg( 'room_rating' ); ?></th>
		<th><?php echo get_msg( 'review_detail' ); ?></th>
	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $reviews ) && count( $reviews->result()) > 0 ): ?>

		<?php foreach($reviews->result() as $review): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->User->get_one( $review->user_id )->user_name;?></td>
				<td><?php echo $review->review_desc; ?></td>
				<td><?php echo $this->Review->get_ratings( array( 'review_id' => $review->review_id, false ))->result()[0]->final_rating; ?></td>
				<td>
					<a href='<?php echo $module_site_url .'/detail/'. $review->review_id; ?>'>
						<i class='fa fa-pencil-square-o'></i>
					</a>
				</td>
			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>