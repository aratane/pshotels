
<script>
function jqvalidate() {

	$('#hinfo_typ-form').validate({
		rules:{
			hinfo_typ_name:{
				required: true,
				minlength: 3,
				remote: "<?php echo $module_site_url .'/ajx_exists/'.@$hinfo_typ->hinfo_typ_id; ?>"
			}
		},
		messages:{
			hinfo_typ_name:{
				required: "<?php echo get_msg( 'err_hinfo_typ_name' ) ;?>",
				minlength: "<?php echo get_msg( 'err_hinfo_typ_len' ) ;?>",
				remote: "<?php echo get_msg( 'err_hinfo_typ_exist' ) ;?>."
			}
		}
	});
}
</script>