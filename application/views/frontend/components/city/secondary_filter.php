<?php $hinfo_grps = $this->HotelInfoGroup->get_all()->result(); ?>

<?php if ( !empty( $hinfo_grps )): foreach ( $hinfo_grps as $hinfo_grp ): ?>

	<div class="filter_group mt-3 border-bottom pb-3">

	<h6><?php echo $hinfo_grp->hinfo_grp_name; ?></h6>

	<?php $hinfo_typs = $this->HotelInfoType->get_all_by( array( 'hinfo_grp_id' => $hinfo_grp->hinfo_grp_id ))->result(); ?>

	<?php if ( !empty( $hinfo_typs )): foreach ( $hinfo_typs as $hinfo_typ ): ?>

		<?php echo form_checkbox( array(
			'name' => 'hinfo_typs[]',
			'id' => 'hinfo_typs[]',
			'value' => $hinfo_typ->hinfo_typ_id,
			'checked' => set_checkbox('hinfo_typs[]', 1, ( @in_array( $hinfo_typ->hinfo_typ_id, @$hotel->hinfo_typ_ids ))? true: false ),
			'class' => 'mr-2 hinfo_typ'
		));	?>

		<?php echo $hinfo_typ->hinfo_typ_name; ?> <br/>

	<?php endforeach; endif; ?>

	</div>

<?php endforeach;  endif; ?>