<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no')?></th>
		<th><?php echo get_msg('user_name')?></th>
		<th><?php echo get_msg('user_email')?></th>
		<th><?php echo get_msg('role')?></th>
		
		<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
			<th><?php echo get_msg('btn_edit')?></th>

		<?php endif;?>

	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>
		
	<?php if ( !empty( $users ) && count( $users->result()) > 0 ): ?>
			
		<?php foreach($users->result() as $user):
			$role_id = $this->User->get_one($user->user_id)->role_id;
		?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->User->get_one($user->user_id)->user_name;?></td>
				<td><?php echo $this->User->get_one($user->user_id)->user_email;?></td>
				<td><?php echo $this->Role->get_name( $role_id );?></td>
				
				<?php if ( $this->ps_auth->has_access( EDIT )):?>

					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $user->user_id;?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>

				<?php endif;?>

			</tr>
		
		<?php endforeach; ?>

	<?php else: ?>
			
		<?php $this->load->view( $template_path .'/partials/no_data' ); ?>

	<?php endif; ?>

</table>