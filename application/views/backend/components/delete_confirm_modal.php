
<div class="modal fade"  id="myModal">

	<div class="modal-dialog">
		
		<div class="modal-content">

			<div class="modal-header">

				<h4 class="modal-title"><?php echo $title; ?></h4>

				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
		          <span aria-hidden="true">&times;</span>
		        </button>
			</div>

			<div class="modal-body">
				<p><?php echo $message; ?></p>
			</div>

			<div class="modal-footer">

				<?php if ( isset( $yes_all_btn )): ?>

					<a class="btn btn-sm btn-primary btn-yes" href='<?php echo $module_site_url ."/delete_all/";?>'>
					<?php echo $yes_all_btn; ?></a>

				<?php endif; ?>

				<?php if ( isset( $no_only_btn )): ?>

				<a class="btn btn-sm btn-primary btn-no" href='<?php echo $module_site_url ."/delete/";?>'>
				<?php echo $no_only_btn; ?></a>

				<?php endif; ?>

				<a href='#' class="btn btn-sm btn-primary" data-dismiss="modal">
				<?php echo get_msg( 'btn_cancel' )?></a>
			</div>

		</div><!-- /.modal-content -->

	</div><!-- /.modal-dialog -->

</div><!-- /.modal -->

<script type="text/javascript">
function deleteModal() {
	// Delete Trigger
	$('.btn-delete').click(function(){

		// get id and links
		var id = $(this).attr('id');
		var btnYes = $('.btn-yes').attr('href');
		var btnNo = $('.btn-no').attr('href');

		// modify link with id
		$('.btn-yes').attr( 'href', btnYes + id );
		$('.btn-no').attr( 'href', btnNo + id );
	});
}
</script>