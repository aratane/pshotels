<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no'); ?></th>
		<th><?php echo get_msg('room_name'); ?></th>
		<th><?php echo get_msg('hotel_name'); ?></th>
		<th><?php echo get_msg('user_name'); ?></th>
		<th><?php echo get_msg('booking_start_date'); ?></th>
		<th><?php echo get_msg('booking_end_date'); ?></th>
		<th><?php echo get_msg('booking_status'); ?></th>
		<th><?php echo get_msg('lbl_view'); ?></th>
		
		<?php if ( $this->ps_auth->has_access( DEL )): ?>
			
			<th><?php echo get_msg('btn_delete')?></th>
		
		<?php endif; ?>
	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $bookings ) && count( $bookings->result()) > 0 ): ?>

		<?php foreach($bookings->result() as $booking): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->Room->get_one( $booking->room_id )->room_name;?></td>
				<td><?php echo $this->Hotel->get_one( $booking->hotel_id )->hotel_name;?></td>
				<td><?php echo $this->User->get_one( $booking->user_id )->user_name;?></td>
				<td><?php echo $booking->booking_start_date; ?></td>
				<td><?php echo $booking->booking_end_date; ?></td>
				<td>
					<span class="badge <?php echo get_booking_status_badge($booking->booking_status); ?>">
						<?php echo $booking->booking_status;?>
					</span>
				</td>
				<td><a href='<?php echo $module_site_url .'/detail/'.$booking->booking_id;?>'><i class='fa fa-eye'></i></a></td>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $booking->booking_id;?>">
							<i class='fa fa-trash-o'></i>
						</a>
					</td>
				
				<?php endif; ?>

			</tr>

		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>
