<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no'); ?></th>
		<th><?php echo get_msg('room_name'); ?></th>
		<th><?php echo get_msg('hotel_name'); ?></th>
		<th><?php echo get_msg('city_name'); ?></th>
		
		<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
			<th><?php echo get_msg('btn_edit')?></th>
		
		<?php endif; ?>
		
		<?php if ( $this->ps_auth->has_access( DEL )): ?>
			
			<th><?php echo get_msg('btn_delete')?></th>
		
		<?php endif; ?>

	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $rooms ) && count( $rooms->result()) > 0 ): ?>

		<?php foreach($rooms->result() as $room): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $room->room_name;?></td>

				<?php $hotel = $this->Hotel->get_one( $room->hotel_id ); ?>
				
				<td><?php echo $hotel->hotel_name; ?></td>
				<td><?php echo $this->City->get_one( $hotel->city_id )->city_name; ?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $room->room_id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $room->room_id;?>">
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