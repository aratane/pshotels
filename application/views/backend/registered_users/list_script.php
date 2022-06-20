<script>
function runAfterJQ() {

	$(document).ready(function(){

		$(document).delegate('.ban','click',function(){
			var btn = $(this);
			var id = $(this).attr('userid');

			$.ajax({
				url: "<?php echo $module_site_url .'/ban/';?>"+id,
				method:'GET',
				success:function(msg){
					if(msg == 'true')
						btn.addClass('unban btn-danger')
							.removeClass('btn-primary-green ban')
							.html('Unban');
					else
						console.log( 'System error occured. Please contact your system administrator.' );
				}
			});
		});
		
		$(document).delegate('.unban','click',function(){
			var btn = $(this);
			var id = $(this).attr('userid');

			$.ajax({
				url: "<?php echo $module_site_url .'/unban/';?>"+id,
				method:'GET',
				success:function(msg){
					if(msg == 'true')
						btn.addClass('ban btn-primary-green')
							.removeClass('btn-danger unban')
							.html('Ban');
					else
						console.log( 'System error occured. Please contact your system administrator.' );
				}
			});
		});
	});
}
</script>
<?php
	// Delete Confirm Message Modal
	$data = array(
		'title' => get_msg( 'delete_user_label' ),
		'message' =>  get_msg( 'user_yes_all_message' ),
		'no_only_btn' => get_msg( 'usesr_no_only_label' )
	);
	
	$this->load->view( $template_path .'/components/delete_confirm_modal', $data );
?>