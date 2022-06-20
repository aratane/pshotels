<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no')?></th>
		<th><?php echo get_msg('room_name')?></th>
		<th><?php echo get_msg('user_name')?></th>
		<th><?php echo get_msg('comment_desc'); ?></th>
		<th><?php echo get_msg('lbl_view')?></th>
		
		<?php if ( $this->ps_auth->has_access( DEL )): ?>
			
			<th><?php echo get_msg('btn_delete')?></th>
		
		<?php endif; ?>
	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $comments ) && count( $comments->result()) > 0 ): ?>

		<?php foreach($comments->result() as $comment): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $this->Room->get_one( $comment->room_id )->room_name;?></td>
				<td><?php echo $this->User->get_one( $comment->user_id )->user_name;?></td>
				<td><?php echo read_more( $comment->comment_desc, 30 ); ?></td>
				<td><a href='<?php echo $module_site_url .'/detail/'.$comment->comment_id;?>'><i class='fa fa-eye'></a></td>

				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $comment->comment_id;?>">
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
