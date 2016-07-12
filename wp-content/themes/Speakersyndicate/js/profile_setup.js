var link = "http://speakersyndicate.imarkclients.com/";



/*-------------------Final Payment-----------------------*/
jQuery(function($) {
	jQuery('#speaker_profile_setup_form').validate({
		
		rules: {
			firstname: {
				required: true,
				number: false
			},
			lastname: {
				required: true,
				number: false
			},
			
			email: {
				required: true,
				email: true,
			},
			prof_headline: {
				required: true,
				number: false
			},
			biography: {
				required: true
				
			},
			val_phone: {
				required: true,
				minlength: 5,
				number: true
			},
			detailed_biography: {
				required: true
			},
			keynote_title: {
				required: true
			},
			keynote_description: {
				required: true
			},
			keynote_program1: {
				required: true
			},
		},
		messages: {
			firstname: {
				required: "Please enter your name.",
				minlength: "",
				number: ""
			},
			
			lastname: {
				required: "Please enter your last name.",
				minlength: "",
				
			},
			email: {
				required: "Please enter your email.",
				minlength: "",
			},
			prof_headline: {
				required: "Please enter Profile heading.",
				minlength: "",
			},
			biography: {
				required: "Please enter biography.",
				minlength: "",
			},
			val_phone: {
				required: "Please enter Phone.",
				minlength: "Please enter numeric value.",
			},
			detailed_biography: {
				required: "Please enter Biography.",
				minlength: "",
			},
			keynote_title: {
				required: "Please enter Keynote Tittle.",
				minlength: "",
			},
			keynote_description: {
				required: "Please enter Keynote description.",
				minlength: "",
			},
			keynote_program1: {
				required: "Please enter Keynote program.",
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
				url: 'http://speakersyndicate.imarkclients.com/wp-content/themes/Speakersyndicate/profile_setup_ajax.php', 
				success: function(data) 
				{
					if(data=="1")
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-success' role='alert'>Registeration   has been done. We will send you password soon.  </div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#visitor_name').val("");
						jQuery('#visitor_lastname').val("");
						jQuery('#visitor_email').val(""); 
						jQuery('#visitor_website').val("");
						 setTimeout(function(){// wait for 5 secs(2)
							   window.location.href="http://speakersyndicate.imarkclients.com/speaker/"; // then reload the page.(3)
						  }, 1000); 
					}
					else if(data=="2")
					{
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-warning' role='alert'>This email has been already registered.</div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#visitor_name').val("");
						jQuery('#visitor_lastname').val("");
						jQuery('#visitor_email').val(""); 
						jQuery('#visitor_website').val("");
					}
					else if(data=="4")	
					{	
						jQuery('.loader').hide();
						jQuery('.form-message').empty().append("<div class='alert alert-success' role='alert'>Profile has been updated sucessfully.</div>");
						jQuery('.form-message').slideDown( "slow" );
						jQuery('#visitor_name').val("");
						jQuery('#visitor_lastname').val("");
						jQuery('#visitor_email').val(""); 
						jQuery('#visitor_website').val("");
						  setTimeout(function(){// wait for 5 secs(2)
							   window.location.href="http://speakersyndicate.imarkclients.com/speaker-profile/"; // then reload the page.(3)
						  }, 1000); 
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