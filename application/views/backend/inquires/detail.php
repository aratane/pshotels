<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-6">
			<legend><?php echo get_msg('inq_detail')?></legend>
			
			<table class="table table-striped table-bordered">
				<tr>
					<th><?php echo get_msg('room_name')?></th>
					<td><?php echo $this->Room->get_one($inquiry->room_id)->room_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('hotel_name')?></th>
					<td><?php echo $this->Hotel->get_one($inquiry->hotel_id)->hotel_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('user_name')?></th>
					<td><?php echo $this->User->get_one($inquiry->user_id)->user_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('inq_name')?></th>
					<td><?php echo $inquiry->inq_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('inq_desc')?></th>
					<td><?php echo $inquiry->inq_desc;?></td>
				</tr>
			</table>
		</div>
	</div>
		
	<a class="btn btn-primary" href="<?php echo $module_site_url ?>" class="btn"><?php echo get_msg('back_button')?></a>
</div>