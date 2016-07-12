<?php
/*
 Template Name: Approve Speaker Template
 */
?>
<?php get_header(); ?>
<div class="speaker-log-in">
  <div class="container">
   <?php 
 function random_password( $length = 8 ) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()_-=+;:,.?";
    $password = substr( str_shuffle( $chars ), 0, $length );
    return $password;
}
   $getId		=	$_GET['id'];
   $userId		=	base64_decode($getId);
	$RandomPass 	= random_password(8);
	   if($userId !=''){
		  update_user_meta( $userId, 'activity_status', 1);  
		  wp_set_password( $RandomPass, $userId ); 
		$user_info 		= 		get_userdata($userId);
		$user_email		=	 	$user_info->user_email;
		$subject = 'Speakersyndicate Registration';
		$body = '<h2>Thanks for Registration.</h2></br></br><p>This is your login details:</br></br>
					Username: '.$user_email.'</br></br>
					Password: '.$RandomPass.'</br>
		</p>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		 
		if(wp_mail( $user_email, $subject, $body, $headers )){
			echo '<h1>Speaker has been activated sucessfully.</h2>';
			
		}else{
			die('invalid request');
		}

	   }
   ?>
		
   
    </div> 
 </div>

<?php get_footer(); ?>