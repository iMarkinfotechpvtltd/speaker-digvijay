var link = "http://speakersyndicate.imarkclients.com/";



/*-------------------Final Payment-----------------------*/
jQuery(function($) {
	jQuery('#speaker-enquiry-form').validate({
		
		rules: {
			enquiry_name: {
				required: true,
				
				number: false
			},
			enquiry_email: {
				required: true,
				
				email: true,
			},
			enquiry_phone: {
				required: true,
				minlength: 5,
				number: true
			},
			enquiry_msg: {
				required: true,
				minlength: 3,
				number: false
			},
		},
		messages: {
			enquiry_name: {
				required: "Please enter your name.",
				minlength: "",
				number: ""
			},
			enquiry_email: {
				required: "Please enter your email.",
				minlength: "",
			},
			enquiry_phone: {
				required: "Please enter your phone.",
				minlength: "",
				number: "Please enter numeric value."
			},
			enquiry_msg: {
				required: "Please enter your message.",
				minlength: "Please enter atleast 3 words.",
			}
		},
		
		submitHandler: function(form) {
			jQuery('.form-message').hide();	
			var image='<img src="http://speakersyndicate.imarkclients.com/wp-content/themes/Speakersyndicate/images/sm.gif"/>';
			jQuery('.loader').empty().append(image);
			jQuery('.loader').show();			
			jQuery(form).ajaxSubmit({
				type: "POST",
				data: jQuery(form).serialize(),
				url: 'http://speakersyndicate.imarkclients.com/wp-content/themes/Speakersyndicate/speaker_enquiry_ajax.php', 
				success: function(data) 
				{
					if(data=="1")
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-success' role='alert'>Your message has been sent.  </div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#enquiry_name').val("");
						jQuery('#enquiry_email').val("");
						jQuery('#enquiry_phone').val(""); 
						jQuery('#enquiry_msg').val("");
					}
					else
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-warning' role='alert'>There is a Problem for your request please try again</div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#enquiry_name').val("");
						jQuery('#enquiry_email').val("");
						jQuery('#enquiry_phone').val(""); 
						jQuery('#enquiry_msg').val("");
					}
				}
			});
		}
		
	});
});
/*--------------------------Open Model--------------------------------*/