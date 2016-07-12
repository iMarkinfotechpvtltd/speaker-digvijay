<?php

$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
echo "<pre>";
print_r($_POST);
echo "</pre>";
/* session_start();
	$visitor_name					=	$_POST['visitor_name'];
	$_SESSION['visitor_name'] 		= 	$visitor_name;
	$visitor_email					=	$_POST['visitor_email'];
	$_SESSION['visitor_email'] 		= 	$visitor_email;
	$visitor_lastname				=	$_POST['visitor_lastname'];
	$_SESSION['visitor_lastname'] 	= 	$visitor_lastname;
		$subject = 'Speakersyndicate Registration';
		$body = '<h2>Thanks for fill the form.</h2></br></br><p>Please click on this <a href="'.site_url().'/speaker-profile/">link  </a> to complete your registration.</p>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		 
		if(wp_mail( $visitor_email, $subject, $body, $headers )){
			echo '1';
			exit;
		}else{
			die('invalid request');
		}
 */
?>