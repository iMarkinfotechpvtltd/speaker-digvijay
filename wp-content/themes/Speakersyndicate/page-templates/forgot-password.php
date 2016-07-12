<?php
/*
Template Name: Password Reset Template
*/
global $wpdb, $user_ID;

function tg_validate_url() {
	global $post;
	$page_url = esc_url(get_permalink( $post->ID ));
	$urlget = strpos($page_url, "?");
	if ($urlget === false) {
		$concate = "?";
	} else {
		$concate = "&";
	}
	return $page_url.$concate;
}

if (!$user_ID) { //block logged in users


	if($_POST['action'] == "tg_pwd_reset"){
		$Errormsg='';
		$Sucessmsg ='';
		if ( !wp_verify_nonce( $_POST['tg_pwd_nonce'], "tg_pwd_nonce")) {
		 $Errormsg =	"No trick please";
	   }  
		if($_POST['user_input']=='') {
			$Errormsg =	"<div class='error'>Please enter your Username or E-mail address</div>";
			
		}
		//We shall SQL escape the input
		$user_input = $wpdb->escape(trim($_POST['user_input']));
		
		if ( strpos($user_input, '@') ) {
			$user_data = get_user_by_email($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				$Errormsg =	 "<div class='error'>Invalid E-mail address!</div>";
				//exit();
			}
		}
		else {
			$user_data = get_userdatabylogin($user_input);
			if(empty($user_data) || $user_data->caps[administrator] == 1) { //delete the condition $user_data->caps[administrator] == 1, if you want to allow password reset for admins also
				$Errormsg =	"<div class='error'>Invalid Username!</div>";
				//exit();
			}
		}
		
		$user_login = $user_data->user_login;
		$user_email = $user_data->user_email;
		
		 $UserID = $wpdb->get_var($wpdb->prepare("SELECT ID FROM $wpdb->users WHERE user_login = %s", $user_login)); 
		if($UserID !='') {
			//generate password
			//$generatePass = wp_generate_password(10, false); 
			//set  password
			//wp_set_password( $generatePass, $UserID );
		//mailing reset details to the user
		$encodeUserID	=	base64_encode($UserID);
		$setPassLink	=	site_url()."/set-password/?get=".$encodeUserID;
		$message = __('Someone requested that the password be reset for the following account:') . "\r\n\r\n";
		$message .= get_option('siteurl') . "\r\n\r\n";
		$message .= sprintf(__('Username: %s'), $user_login) . "\r\n\r\n";
		$message .= __('If this was a mistake, just ignore this email.') . "\r\n\r\n";
		$message .= __('Please click on this link to set new password.:   '.$setPassLink.'') . "\r\n\r\n";
		
		
		if ( $message && !wp_mail($user_email, 'Password Reset Request', $message) ) {
			//echo "<div class='error'>Email failed to send for some unknown reason.</div>";
			//exit();
		}
		else {
			$Sucessmsg =	 "<div class='success'>We have just sent you an email please check.</div>";
			//exit();
		}
	}
		
	} 

get_header(); ?>
<div id="content" role="main">
  <div class="container">
    
    <div class="forgot-pass">
<?php 
if($Errormsg!=''){
	echo $Errormsg;
	
}
if($Sucessmsg!=''){
	echo $Sucessmsg;
	
}
?>
	<?php if ( have_posts() ) : ?>
	
		<?php while ( have_posts() ) : the_post(); ?>
			
			<form class="user_form" id="wp_pass_reset" action="" method="post">			
			<input type="text" required class="text" name="user_input" value="" />
			<input type="hidden" name="action" value="tg_pwd_reset" />
			<input type="hidden" name="tg_pwd_nonce" value="<?php echo wp_create_nonce("tg_pwd_nonce"); ?>" />
			<input type="submit" id="submitbtn" class="reset_password" name="submit" value="Reset Password" />					
			</form>
			<div id="result"></div> <!-- To hold validation results -->
			<script type="text/javascript">  						
			$("#wp_pass_reset").submit(function() {			
			$('#result').html('<span class="loading">Validating...</span>').fadeIn();
			var input_data = $('#wp_pass_reset').serialize();
			$.ajax({
			type: "POST",
			url:  "<?php echo get_permalink( $post->ID ); ?>",
			data: input_data,
			success: function(msg){
			$('.loading').remove();
			$('<div>').html(msg).appendTo('div#result').hide().fadeIn('slow');
			}
			});
			return false;
			
			});
			</script>
			
	<?php endwhile; ?>
		
	<?php else : ?>
		
			<p><?php _e('Not Found'); ?></p>
			
	<?php endif; ?>
    
     
	 </div>
   </div> 
</div><!-- content -->
<?php

get_footer();
	
}
else {
	wp_redirect( home_url() ); exit;
	//redirect logged in user to home page
}
?>