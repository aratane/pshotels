
<script>
	function jqvalidate() {

		$('#city-form').validate({
			rules:{
				city_name:{
					required: true,
					minlength: 3,
					remote: "<?php echo $module_site_url .'/ajx_exists/'.@$city->city_id; ?>"
				}
			},
			messages:{
				city_name:{
					required: "<?php echo get_msg( 'err_city_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_city_len' ) ;?>",
					remote: "<?php echo get_msg( 'err_city_exist' ) ;?>."
				}
			}
		});
	}
</script>

<?php $this->load->view( $template_path .'/components/cover_photo_uploader_script', array( 
	'img_type' => 'city', 
	'img_parent_id' => @$city->city_id 
)); ?>	