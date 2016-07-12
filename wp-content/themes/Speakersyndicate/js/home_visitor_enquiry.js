var link = "http://speakersyndicate.imarkclients.com/";



/*-------------------Final Payment-----------------------*/
jQuery(function($) {
	jQuery('#visitor-form').validate({
		
		rules: {
			visitor_name: {
				required: true,
				minlength: 3,
				number: false
			},
			visitor_lastname: {
				required: true,
				minlength: 3,
				number: false
			},
			
			visitor_email: {
				required: true,
				minlength: 6,
				email: true,
			},
			
			
		},
		messages: {
			visitor_name: {
				required: "Please enter your name.",
				minlength: "",
				number: ""
			},
			
			visitor_lastname: {
				required: "Please enter your last name.",
				minlength: "",
				
			},
			visitor_email: {
				required: "Please enter your email.",
				minlength: "",
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
				url: 'http://speakersyndicate.imarkclients.com/wp-content/themes/Speakersyndicate/visitor_enquiry_ajax.php', 
				success: function(data) 
				{
					if(data=="1")
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-success' role='alert'>Your message has been sent.  </div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#visitor_name').val("");
						jQuery('#visitor_lastname').val("");
						jQuery('#visitor_email').val(""); 
						
					}
					else
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-warning' role='alert'>There is a Problem for your request please try again</div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#visitor_name').val("");
						jQuery('#visitor_lastname').val("");
						jQuery('#visitor_email').val(""); 
						
					}
				}
			});
		}
		
	});
});
/*--------------------------Open Model--------------------------------*/