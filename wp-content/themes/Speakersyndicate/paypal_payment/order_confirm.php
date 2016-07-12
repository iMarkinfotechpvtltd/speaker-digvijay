<div style="display:none">
<?php
/*
Template Name: Confirm Subscription
*/
	/*==================================================================
	 PayPal Express Checkout Call
	 ===================================================================
	*/
require_once ("paypalfunctions.php");
$PaymentOption = "PayPal";
if ( $PaymentOption == "PayPal" )
{
	
	
	/*
	'------------------------------------
	' The paymentAmount is the total value of 
	' the shopping cart, that was set 
	' earlier in a session variable 
	' by the shopping cart page
	'------------------------------------
	*/
	
	$finalPaymentAmount =  $_SESSION["Payment_Amount"];
	$speaker_id 		=  $_SESSION["speaker_id"];
	$PlanID 			=  $_SESSION["PlanID"]; 		
	
	/*
	'------------------------------------
	' Calls the DoExpressCheckoutPayment API call
	'
	' The ConfirmPayment function is defined in the file PayPalFunctions.jsp,
	' that is included at the top of this file.
	'-------------------------------------------------
	*/

	//$resArray = ConfirmPayment ( $finalPaymentAmount ); Remove comment with ontime payment.
//$daga 	=	ManageRecurringPaymentsProfileStatus();
	$Get_PROFILEID =  $_SESSION["PROFILEID"];
	if($Get_PROFILEID !=''){
		$manageProfile 	=	ManageRecurringPaymentsProfileStatus();
		$getStatus 		= strtoupper($manageProfile["ACK"]);
		if( $getStatus == "SUCCESS" || $getStatus == "SUCCESSWITHWARNING" ){
			global $wpdb;
			$wpdb->query($wpdb->prepare("DELETE FROM sp_payments WHERE speaker_id = '$speaker_id'"));
		}
	}
	
	$resArray = CreateRecurringPaymentsProfile();
	$ack = strtoupper($resArray["ACK"]);

	if( $ack == "SUCCESS" || $ack == "SUCCESSWITHWARNING" )
	{
		$PROFILEID			= $resArray["PROFILEID"];
		$PROFILESTATUS		= $resArray["PROFILESTATUS"];
		$Apply_date			= $resArray["TIMESTAMP"];
		$CORRELATIONID		= $resArray["CORRELATIONID"];
		$TRANSACTIONID		= $resArray["TRANSACTIONID"];
		$paymentStartDate	= date("Y-m-1", strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
		/* echo "<pre>";
		print_r($resArray);
		echo "</pre>";
		global $wpdb; */
		$wpdb->insert('sp_payments', array(
			'speaker_id' => $speaker_id,
			'PROFILEID' => $PROFILEID,
			'PROFILESTATUS' => $PROFILESTATUS,
			'Apply_date' => $Apply_date,
			'payment_start_date' => $paymentStartDate,
			'CORRELATIONID' => $CORRELATIONID,
			'TRANSACTIONID' => $TRANSACTIONID,
			'AMOUNT' => $finalPaymentAmount,
			'plan_index'	=> $PlanID
		 ));

		$wpdb->query("UPDATE sp_search_attributes SET profile_status = 'Active' WHERE speaker_id = '$speaker_id'");		 
		/*
		'********************************************************************************************************************
		'
		' THE PARTNER SHOULD SAVE THE KEY TRANSACTION RELATED INFORMATION LIKE 
		'                    transactionId & orderTime 
		'  IN THEIR OWN  DATABASE
		' AND THE REST OF THE INFORMATION CAN BE USED TO UNDERSTAND THE STATUS OF THE PAYMENT 
		'
		'********************************************************************************************************************
		*/

		$transactionId		= $resArray["TRANSACTIONID"]; // ' Unique transaction ID of the payment. Note:  If the PaymentAction of the request was Authorization or Order, this value is your AuthorizationID for use with the Authorization & Capture APIs. 
		$transactionType 	= $resArray["TRANSACTIONTYPE"]; //' The type of transaction Possible values: l  cart l  express-checkout 
		$paymentType		= $resArray["PAYMENTTYPE"];  //' Indicates whether the payment is instant or delayed. Possible values: l  none l  echeck l  instant 
		$orderTime 			= $resArray["ORDERTIME"];  //' Time/date stamp of payment
		$amt				= $resArray["AMT"];  //' The final amount charged, including any shipping and taxes from your Merchant Profile.
		$currencyCode		= $resArray["CURRENCYCODE"];  //' A three-character currency code for one of the currencies listed in PayPay-Supported Transactional Currencies. Default: USD. 
		$feeAmt				= $resArray["FEEAMT"];  //' PayPal fee amount charged for the transaction
		$settleAmt			= $resArray["SETTLEAMT"];  //' Amount deposited in your PayPal account after a currency conversion.
		$taxAmt				= $resArray["TAXAMT"];  //' Tax charged on the transaction.
		$exchangeRate		= $resArray["EXCHANGERATE"];  //' Exchange rate if a currency conversion occurred. Relevant only if your are billing in their non-primary currency. If the customer chooses to pay with a currency other than the non-primary currency, the conversion occurs in the customer’s account.
		
		/*
		' Status of the payment: 
				'Completed: The payment has been completed, and the funds have been added successfully to your account balance.
				'Pending: The payment is pending. See the PendingReason element for more information. 
		*/
		
		$paymentStatus	= $resArray["PAYMENTSTATUS"]; 

		/*
		'The reason the payment is pending:
		'  none: No pending reason 
		'  address: The payment is pending because your customer did not include a confirmed shipping address and your Payment Receiving Preferences is set such that you want to manually accept or deny each of these payments. To change your preference, go to the Preferences section of your Profile. 
		'  echeck: The payment is pending because it was made by an eCheck that has not yet cleared. 
		'  intl: The payment is pending because you hold a non-U.S. account and do not have a withdrawal mechanism. You must manually accept or deny this payment from your Account Overview. 		
		'  multi-currency: You do not have a balance in the currency sent, and you do not have your Payment Receiving Preferences set to automatically convert and accept this payment. You must manually accept or deny this payment. 
		'  verify: The payment is pending because you are not yet verified. You must verify your account before you can accept this payment. 
		'  other: The payment is pending for a reason other than those listed above. For more information, contact PayPal customer service. 
		*/
		
		$pendingReason	= $resArray["PENDINGREASON"];  

		/*
		'The reason for a reversal if TransactionType is reversal:
		'  none: No reason code 
		'  chargeback: A reversal has occurred on this transaction due to a chargeback by your customer. 
		'  guarantee: A reversal has occurred on this transaction due to your customer triggering a money-back guarantee. 
		'  buyer-complaint: A reversal has occurred on this transaction due to a complaint about the transaction from your customer. 
		'  refund: A reversal has occurred on this transaction because you have given the customer a refund. 
		'  other: A reversal has occurred on this transaction due to a reason not listed above. 
		*/
		
		$reasonCode		= $resArray["REASONCODE"]; 
		
		echo '<script>window.location.href="'.site_url().'/thank-you/"; </script>';
	}
	else  	
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);
		echo '<script>window.location.href="'.site_url().'/payment/?msg=1"; </script>';
		/* echo "GetExpressCheckoutDetails API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode; */
	}
}		
		
?>
</div>
