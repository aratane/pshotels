
<script>
function jqvalidate() {

	$('#promo-form').validate({
		rules:{
			promo_name:{
				required: true,
				minlength: 3,
				remote: "<?php echo $module_site_url .'/ajx_exists/'.@$promotion->promo_id; ?>"
			}
		},
		messages:{
			promo_name:{
				required: "<?php echo get_msg( 'err_promo_name' ) ;?>",
				minlength: "<?php echo get_msg( 'err_promo_len' ) ;?>",
				remote: "<?php echo get_msg( 'err_promo_exist' ) ;?>."
			}
		}
	});
}
function promoDtp()
{
	$('#promo_start_time').datetimepicker({
		format: 'yyyy-mm-dd hh:ii:ss'
	});
    $('#promo_end_time').datetimepicker({
    	format: 'yyyy-mm-dd hh:ii:ss',
        useCurrent: false //Important! See issue #1075
    });
    $("#promo_start_time").on("dp.change", function (e) {
        $('#promo_end_time').data("DateTimePicker").minDate(e.date);
    });
    $("#promo_end_time").on("dp.change", function (e) {
        $('#promo_start_time').data("DateTimePicker").maxDate(e.date);
    });
}
</script>