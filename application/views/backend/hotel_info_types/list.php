<table class="table table-striped table-bordered">

	<tr>
		<th><?php echo get_msg('no')?></th>
		<th><?php echo get_msg('hinfo_typ_name')?></th>
		<th><?php echo get_msg('hinfo_grp_name')?></th>
		
		<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
			<th><?php echo get_msg('btn_edit')?></th>
		
		<?php endif; ?>
		
		<?php if ( $this->ps_auth->has_access( DEL )): ?>
			
			<th><?php echo get_msg('btn_delete')?></th>
		
		<?php endif; ?>

	</tr>

	<?php $count = $this->uri->segment(4) or $count = 0; ?>

	<?php if ( !empty( $hinfo_typs ) && count( $hinfo_typs->result()) > 0 ): ?>

		<?php foreach($hinfo_typs->result() as $hinfo_typ): ?>
			
			<tr>
				<td><?php echo ++$count;?></td>
				<td><?php echo $hinfo_typ->hinfo_typ_name;?></td>
				<td><?php echo $this->HotelInfoGroup->get_one( $hinfo_typ->hinfo_grp_id )->hinfo_grp_name; ?></td>

				<?php if ( $this->ps_auth->has_access( EDIT )): ?>
			
					<td>
						<a href='<?php echo $module_site_url .'/edit/'. $hinfo_typ->hinfo_typ_id; ?>'>
							<i class='fa fa-pencil-square-o'></i>
						</a>
					</td>
				
				<?php endif; ?>
				
				<?php if ( $this->ps_auth->has_access( DEL )): ?>
					
					<td>
						<a herf='#' class='btn-delete' data-toggle="modal" data-target="#myModal" id="<?php echo $hinfo_typ->hinfo_typ_id;?>">
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