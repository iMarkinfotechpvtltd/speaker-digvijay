var link = "http://speakersyndicate.stagingdevsite.com/";



/*-------------------Final Payment-----------------------*/
jQuery(function($) {
	jQuery('#login-form').validate({
		
		rules: {
			Username: {
				required: true,
				minlength: 2
				
			},
			Password: {
				required: true,
				minlength: 2
				
			},
		
		},
		messages: {
			Username: {
				required: "Please enter your username or email.",
				minlength: "",
				number: ""
			},
			
			Password: {
				required: "Please enter your password.",
				minlength: "",
				
			},
		
			
		},
		
		submitHandler: function(form) {
			jQuery('.login-form-message').hide();	
			var image='<img src="http://speakersyndicate.stagingdevsite.com/wp-content/themes/Speakersyndicate/images/sm.gif"/>';
			jQuery('.login-loader').empty().append(image);
			jQuery('.login-loader').show();			
			jQuery(form).ajaxSubmit({
				type: "POST",
				data: jQuery(form).serialize(),
				url: 'http://speakersyndicate.stagingdevsite.com/wp-content/themes/Speakersyndicate/custom_login.php', 
				success: function(data) 
				{
					if(data=="1")
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-success' role='alert'>Registeration  link has been sent to your email please check your email.  </div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#Username').val("");
						jQuery('#Password').val("");
					}
					else
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-warning' role='alert'>There is a Problem for your request please try again</div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#Username').val("");
						jQuery('#Password').val("");
					}
				}
			});
		}
		
	});
});
/*--------------------------Open Model--------------------------------*/