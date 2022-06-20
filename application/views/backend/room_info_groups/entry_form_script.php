
<script>
function jqvalidate() {

	$('#rinfo_grp-form').validate({
		rules:{
			rinfo_grp_name:{
				required: true,
				minlength: 3,
				remote: "<?php echo $module_site_url .'/ajx_exists/'.@$rinfo_grp->rinfo_grp_id; ?>"
			}
		},
		messages:{
			rinfo_grp_name:{
				required: "<?php echo get_msg( 'err_rinfo_grp_name' ) ;?>",
				minlength: "<?php echo get_msg( 'err_rinfo_grp_len' ) ;?>",
				remote: "<?php echo get_msg( 'err_rinfo_grp_exist' ) ;?>."
			}
		}
	});
}
</script>

<?php $this->load->view( $template_path .'/components/cover_photo_uploader_script', array( 
	'img_type' => 'rinfo_grp', 
	'img_parent_id' => @$rinfo_grp->rinfo_grp_id 
)); ?>