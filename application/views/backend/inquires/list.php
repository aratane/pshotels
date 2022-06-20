<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no')?></th>
		<th><?php echo get_msg('room_name')?></th>
		<th><?php echo get_msg('hotel_name')?></th>
		<th><?php echo get_msg('user_name')?></th>
		<th><?php echo get_msg( 'inq_name' ); ?></th>		
		<th><?php echo get_msg('lbl_view')?></th>
	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $inquires ) && count( $inquires->result()) > 0 ): ?>

		<?php foreach($inquires->result() as $inquiry): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->Room->get_one( $inquiry->room_id )->room_name;?></td>
				<td><?php echo $this->Hotel->get_one( $inquiry->hotel_id )->hotel_name;?></td>
				<td><?php echo $this->User->get_one( $inquiry->user_id )->user_name;?></td>	
				<td><?php echo read_more( $inquiry->inq_name, 20 ); ?></td>			
				<td><a href='<?php echo $module_site_url .'/detail/'.$inquiry->inq_id;?>'><i class='fa fa-eye'></i></a></td>

			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
