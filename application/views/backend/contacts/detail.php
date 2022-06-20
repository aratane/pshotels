<div class="wrapper wrapper-content animated fadeInRight">
	<div class="row">
		<div class="col-sm-6">
			<legend><?php echo get_msg('contact_info_label')?></legend>
			
			<table class="table table-striped table-bordered">
				<tr>
					<th><?php echo get_msg('contact_name')?></th>
					<td><?php echo $contact->contact_name;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('contact_email')?></th>
					<td><?php echo $contact->contact_email;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('contact_phone')?></th>
					<td><?php echo $contact->contact_phone;?></td>
				</tr>
				<tr>
					<th><?php echo get_msg('about_contact_label')?></th>
					<td><?php echo $contact->contact_message;?></td>
				</tr>
			</table>
		</div>
	</div>
		
	<a class="btn btn-primary" href="<?php echo $module_site_url ?>" class="btn"><?php echo get_msg('back_button')?></a>
</div>