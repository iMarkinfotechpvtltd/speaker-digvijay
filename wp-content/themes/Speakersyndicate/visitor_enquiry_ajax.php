<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
session_start();
	$visitor_name					=	$_POST['visitor_name'];
	$visitor_email					=	$_POST['visitor_email'];
	$visitor_msg					=	$_POST['visitor_msg'];
	$admin_email 					= get_option('admin_email');
 
	if($visitor_name !='' && $visitor_email !='' && $visitor_msg !=''){
		$subject = 'Visitor message';
		$body = '<table border="1" style="width:100%"><tr><td>Name</td><td>Email</td><td>Message</td></tr><tr><td>'.$visitor_name.'</td><td>'.$visitor_email.'</td><td>'.$visitor_msg.'</td></tr></table>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		
		if(wp_mail( $admin_email, $subject, $body, $headers )){
			
			echo '1';
			exit;
		}else{
			die('invalid mail request');
		}
	}else{
		die('invalid request');
	}
		

?>