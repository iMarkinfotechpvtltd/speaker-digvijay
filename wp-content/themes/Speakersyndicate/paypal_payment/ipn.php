<?php
/*
Template Name: Paypal IPN
*/
mail("digvijay.daga@imarkinfotech.com","My subject",print_r($_REQUEST,true));
if(!empty($_REQUEST)){
	global $wpdb;
	$payer_id				=	$_REQUEST['payer_id'];
	$profile_status			=	$_REQUEST['profile_status'];
	$amount					=	$_REQUEST['amount'];
	$recurring_payment_id	=	$_REQUEST['recurring_payment_id'];
	$payer_email			=	$_REQUEST['payer_email'];
	$wpdb->query("UPDATE sp_payments SET PROFILESTATUS = '$profile_status', AMOUNT = '$amount' ,payer_id='$payer_id', payer_email='$payer_email' WHERE PROFILEID = '$recurring_payment_id'");
}
?>