var link = "http://speakersyndicate.imarkclients.com/";



/*-------------------Final Payment-----------------------*/
jQuery(function($) {
	jQuery('#visitor-form').validate({
		
		rules: {
			visitor_name: {
				required: true,
				number: false
			},
			visitor_lastname: {
				required: true,
				number: false
			},
			
			visitor_email: {
				required: true,
				email: true,
			},
			
			
		},
		messages: {
			visitor_name: {
				required: "Please enter your name.",
				minlength: "",
				number: "Please enter text only."
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
				url: 'http://speakersyndicate.imarkclients.com/wp-content/themes/Speakersyndicate/visitor_reg.php', 
				success: function(data) 
				{
					if(data=="1")
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-success' role='alert'>Registeration  link has been sent to your email please check your email.  </div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#visitor_name').val("");
						jQuery('#visitor_lastname').val("");
						jQuery('#visitor_email').val(""); 
						jQuery('#visitor_website').val("");
					}
					else
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-warning' role='alert'>There is a Problem for your request please try again</div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#visitor_name').val("");
						jQuery('#visitor_lastname').val("");
						jQuery('#visitor_email').val(""); 
						jQuery('#visitor_website').val("");
					}
				}
			});
		}
		
	});
});
/*--------------------------Open Model--------------------------------*/