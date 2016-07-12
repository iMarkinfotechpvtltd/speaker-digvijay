<?php
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
session_start();
	$enquiry_name					=	$_POST['enquiry_name'];
	$enquiry_email					=	$_POST['enquiry_email'];
	$enquiry_phone					=	$_POST['enquiry_phone'];
	$enquiry_msg					=	$_POST['enquiry_msg'];
	$speakerID						=	$_POST['speakerID'];
	$SpeakerMail					=	$_POST['UserEmail'];
	$visitor_enquiry_count 			= 	get_user_meta( $speakerID, 'visitor_enquiry_count', true );  
	 
	if($enquiry_name !='' && $enquiry_email !='' && $enquiry_phone !='' && $enquiry_msg !='' && $SpeakerMail !=''){
		$subject = 'Visitor message';
		$body = '<table border="1" style="width:100%"><tr><td>Name</td><td>Email</td><td>Phone</td><td>Message</td></tr><tr><td>'.$enquiry_name.'</td><td>'.$enquiry_email.'</td><td>'.$enquiry_phone.'</td><td>'.$enquiry_msg.'</td></tr></table>';
		$headers = array('Content-Type: text/html; charset=UTF-8');
		
		if(wp_mail( $SpeakerMail, $subject, $body, $headers )){
				if($visitor_enquiry_count==''){
					update_user_meta( $speakerID, 'visitor_enquiry_count', 1);
				}else{
					update_user_meta( $speakerID, 'visitor_enquiry_count', $visitor_enquiry_count+1);
				}
			echo '1';
			exit;
		}else{
			die('invalid mail request');
		}
	}else{
		die('invalid request');
	}
		

?>