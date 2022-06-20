<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no')?></th>
		<th><?php echo get_msg('hotel_name')?></th>
		<th><?php echo get_msg('user_name')?></th>
	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $favs ) && count( $favs->result()) > 0 ): ?>

		<?php foreach($favs->result() as $fav): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->Hotel->get_one( $fav->hotel_id )->hotel_name;?></td>
				<td><?php echo $this->User->get_one( $fav->user_id )->user_name;?></td>
			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
