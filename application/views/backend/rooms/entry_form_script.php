
<script>

	function jqvalidate() {

		$('#room-form').validate({
			rules:{
				room_name:{
					required: true,
					minlength: 3
				}
			},
			messages:{
				room_name:{
					required: "<?php echo get_msg( 'err_room_name' ) ;?>",
					minlength: "<?php echo get_msg( 'err_room_len' ) ;?>"
				}
			}
		});
	}
</script>