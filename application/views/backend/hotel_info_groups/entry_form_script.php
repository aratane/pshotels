
<script>
function jqvalidate() {

	$('#hinfo_grp-form').validate({
		rules:{
			hinfo_grp_name:{
				required: true,
				minlength: 3,
				remote: "<?php echo $module_site_url .'/ajx_exists/'.@$hinfo_grp->hinfo_grp_id; ?>"
			}
		},
		messages:{
			hinfo_grp_name:{
				required: "<?php echo get_msg( 'err_hinfo_grp_name' ) ;?>",
				minlength: "<?php echo get_msg( 'err_hinfo_grp_len' ) ;?>",
				remote: "<?php echo get_msg( 'err_hinfo_grp_exist' ) ;?>."
			}
		}
	});
}
</script>

<?php $this->load->view( $template_path .'/components/cover_photo_uploader_script', array( 
	'img_type' => 'hinfo_grp', 
	'img_parent_id' => @$hinfo_grp->hinfo_grp_id 
)); ?>