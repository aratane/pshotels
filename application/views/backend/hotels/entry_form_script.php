
<script>

	function jqvalidate() {

		$('#hotel-form').validate({
			rules:{
				hotel_name:{
					required: true,
					minlength: 3
				}
			},
			messages:{
				hotel_name:{
					required: "<?php echo get_msg( 'err_hotel_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_hotel_len' ) ;?>"
				}
			}
		});
	}
</script>