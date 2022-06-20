<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no')?></th>
		<th><?php echo get_msg('rinfo_typ_name')?></th>
		<th><?php echo get_msg('rinfo_grp_name')?></th>
		
		<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
			<th><?php echo get_msg('btn_edit')?></th>
		
		<?php endif; ?>
		
		<?php if ( $this->ps_auth->has_access( DEL )): ?>
			
			<th><?php echo get_msg('btn_delete')?></th>
		
		<?php endif; ?>

	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $rinfo_typs ) && count( $rinfo_typs->result()) > 0 ): ?>

		<?php foreach($rinfo_typs->result() as $rinfo_typ): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $rinfo_typ->rinfo_typ_name;?></td>
				<td><?php echo $this->RoomInfoGroup->get_one( $rinfo_typ->rinfo_grp_id )->rinfo_grp_name; ?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $rinfo_typ->rinfo_typ_id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $rinfo_typ->rinfo_typ_id;?>">
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