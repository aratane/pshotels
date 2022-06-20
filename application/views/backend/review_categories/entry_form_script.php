
<script>
	function jqvalidate() {

		$('#rvcat-form').validate({
			rules:{
				rvcat_name:{
					required: true,
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$rvcat->rvcat_id; ?>"
				}
			},
			messages:{
				rvcat_name:{
					required: "<?php echo get_msg( 'err_rvcat_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_rvcat_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_rvcat_exist' ) ;?>."
				}
			}
		});
	}
</script>