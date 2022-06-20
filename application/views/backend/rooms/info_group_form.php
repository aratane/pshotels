<?php $rinfo_grps = $this->RoomInfoGroup->get_all()->result(); ?>

<div class="row">

<?php if ( !empty( $rinfo_grps )): foreach ( $rinfo_grps as $rinfo_grp ): ?>

	<div class="col-4 mb-4">

	<h6 class="mb-3 lead"><?php echo $rinfo_grp->rinfo_grp_name; ?></h6>

	<?php $rinfo_typs = $this->RoomInfoType->get_all_by( array( 'rinfo_grp_id' => $rinfo_grp->rinfo_grp_id ))->result(); ?>

	<?php if ( !empty( $rinfo_typs )): foreach ( $rinfo_typs as $rinfo_typ ): ?>

		<div class="form-group">
			
			<div class="form-check">

				<label class="form-check-label">
			
				<?php echo form_checkbox( array(
					'name' => 'rinfo_typs[]',
					'id' => 'rinfo_typs[]',
					'value' => $rinfo_typ->rinfo_typ_id,
					'checked' => set_checkbox('rinfo_typs[]', 1, ( @in_array( $rinfo_typ->rinfo_typ_id, @$room->rinfo_typ_ids ))? true: false ),
					'class' => 'form-check-input'
				));	?>

				<?php echo $rinfo_typ->rinfo_typ_name; ?>				
				</label>
			</div>
		</div>

	<?php endforeach; endif; ?>

	</div>

<?php endforeach;  endif; ?>

</div>