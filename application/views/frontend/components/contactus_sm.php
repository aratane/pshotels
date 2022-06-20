<div class="contact-us">
<h4 class="footer-title">Contact Us</h4>

<form id="contactForm">

	<div class="contactFlashMessage">
		<p id="contactError" class="text-danger fade"></p>

		<p id="contactSuccess" class="text-success fade"></p>
	</div>
	
	<input id="contact_name" class="mb-2 ps-input" type="text" name="" placeholder="Name">

	<input id="contact_email" class="mb-2 ps-input" type="email" name="" placeholder="Email Address">

	<input id="contact_phone" class="mb-2 ps-input" type="phone" name="" placeholder="Phone">

	<textarea id="contact_message" class="mb-2 ps-input" placeholder="Message"></textarea>

	<button id="btnContact" type="button" class="btn btn-sm btn-info float-right">Submit</button>

</form>
</div>

<script type="text/javascript">
	function contactUs() {

		$('#btnContact').click(function(){
			$.ajax({
				type: 'POST',
				url: ajaxUrl + '/contact_us',
				data: {
					'contact_name': $('#contact_name').val(),
					'contact_email': $('#contact_email').val(),
					'contact_phone': $('#contact_phone').val(),
					'contact_message': $('#contact_message').val()
				},
				dataType: 'JSON',
				success: function( data ){

					$('#contactFlashMessage p').removeClass('show');

					if ( data.status == "error" ) {

						$('#contactError').html( data.message ).fadeIn('slow').addClass('show');
					} else if ( data.status == "success" ) {

						$('#contactSuccess').html( data.message ).fadeIn('slow').addClass('show');

						$('#contactForm input').val('');
						$('#contactForm textarea').val('');
						$('#contactError').html('');
					} else {
						console.log( data );
					}
				}
			});	
		});		
	}
</script>