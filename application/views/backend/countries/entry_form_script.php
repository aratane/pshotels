<script>
	function jqvalidate() {

		$('#country-form').validate({
			rules:{
				country_name:{
					required: true,
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$country->country_id; ?>"
				}
			},
			messages:{
				country_name:{
					required: "<?php echo get_msg( 'err_ctry_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_ctry_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_ctry_exist' ) ;?>."
				}
			}
		}); 
	}
</script>

<?php $this->load->view( $template_path .'/components/cover_photo_uploader_script', array( 
	'img_type' => 'country', 
	'img_parent_id' => @$country->country_id 
)); ?>