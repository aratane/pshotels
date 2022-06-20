
<script>
function jqvalidate() {

	$('#rinfo_typ-form').validate({
		rules:{
			rinfo_typ_name:{
				required: true,
				minlength: 3,
				remote: "<?php echo $module_site_url .'/ajx_exists/'.@$rinfo_typ->rinfo_typ_id; ?>"
			}
		},
		messages:{
			rinfo_typ_name:{
				required: "<?php echo get_msg( 'err_rinfo_typ_name' ) ;?>",
				minlength: "<?php echo get_msg( 'err_rinfo_typ_len' ) ;?>",
				remote: "<?php echo get_msg( 'err_rinfo_typ_exist' ) ;?>."
			}
		}
	});
}
</script>