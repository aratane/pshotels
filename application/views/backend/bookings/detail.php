<div class="wrapper wrapper-content animated fadeInRight">

	<div class="row">
		<div class="col-sm-6">
			<legend><?php echo get_msg('booking_detail')?></legend>
			
			<table class="table table-striped table-bordered">
				<tr>
					<th><?php echo get_msg('room_name')?></th>
					<td><?php echo $this->Room->get_one($booking->room_id)->room_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('hotel_name')?></th>
					<td><?php echo $this->Hotel->get_one($booking->hotel_id)->hotel_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('user_name')?></th>
					<td><?php echo $this->User->get_one($booking->user_id)->user_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_user_name')?></th>
					<td><?php echo $booking->booking_user_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_user_email')?></th>
					<td><?php echo $booking->booking_user_email;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_user_phone')?></th>
					<td><?php echo $booking->booking_user_phone;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_start_date')?></th>
					<td><?php echo $booking->booking_start_date;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_end_date')?></th>
					<td><?php echo $booking->booking_end_date;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_adult_count')?></th>
					<td><?php echo $booking->booking_adult_count;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_kid_count')?></th>
					<td><?php echo $booking->booking_kid_count;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_extra_bed')?></th>
					<td><?php echo $booking->booking_extra_bed;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('booking_remark')?></th>
					<td><?php echo $booking->booking_remark;?></td>
				</tr>

				<tr>
					<th><?php echo get_msg('booking_status')?></th>
					<td>
						<span class="badge <?php echo get_booking_status_badge($booking->booking_status); ?>">
							<?php echo $booking->booking_status;?>
						</span>
					</td>
				</tr>
			</table>
		</div>
	</div>

	<?php echo form_open( '', array( 'id' => 'booking-form')); ?>

	<button type="submit" name="confirm" class="btn btn-success">
		<?php echo get_msg('confirm_button')?>
	</button>

	<button type="submit" name="cancel" class="btn btn-danger">
		<?php echo get_msg('cancel_button')?>
	</button>

	<a class="btn btn-primary" href="<?php echo $module_site_url ?>" class="btn">
		<?php echo get_msg('back_button')?>
	</a>

	<?php echo form_close(); ?>

</div>