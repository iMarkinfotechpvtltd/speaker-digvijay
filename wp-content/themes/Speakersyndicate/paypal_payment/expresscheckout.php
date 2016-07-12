<?php
/*
Template Name: Checkout Template
*/
echo '<div style="display:none">';

require_once ("paypalfunctions.php");
// ==================================
// PayPal Express Checkout Module
// ==================================

//'------------------------------------
//' The paymentAmount is the total value of 
//' the shopping cart, that was set 
//' earlier in a session variable 
//' by the shopping cart page
//'------------------------------------

$paymentAmount 	= $_POST["Payment_Amount"];
if($paymentAmount==1000){
	$itemDesc	=	'Silver Package($1000 monthly)';
	$_SESSION["itemDesc"] = $itemDesc; 
}elseif($paymentAmount==1500){
	$itemDesc	=	'Gold Package($1500 monthly)';
	$_SESSION["itemDesc"] = $itemDesc; 
}elseif($paymentAmount==2000){
	$itemDesc	=	'Platinum Package($2000 monthly)';
	$_SESSION["itemDesc"] = $itemDesc; 
}else{
	
}
$speaker_id 	= $_POST["speaker_id"];
$PlanID 		= $_POST["PlanID"];
if($paymentAmount !='' && $speaker_id !=0){
	$_SESSION["Payment_Amount"] = $paymentAmount; 
	$_SESSION["speaker_id"] 	= $speaker_id; 
	$_SESSION["PlanID"] 		= $PlanID; 
	if($PlanID =='1' || $PlanID =='2'){
		$GetPcakageData 		= 	 $wpdb->get_results("SELECT PROFILEID FROM sp_payments WHERE speaker_id ='$speaker_id'");
		$PROFILEID				=	 $GetPcakageData[0]->PROFILEID;
		$_SESSION["PROFILEID"] 	=    $PROFILEID;
	}
	//'------------------------------------
	//' The currencyCodeType and paymentType 
	//' are set to the selections made on the Integration Assistant 
	//'------------------------------------
	$currencyCodeType = "USD";
	$paymentType = "Sale";
	#$paymentType = "Authorization";
	#$paymentType = "Order";

	//'------------------------------------
	//' The returnURL is the location where buyers return to when a
	//' payment has been succesfully authorized.
	//'
	//' This is set to the value entered on the Integration Assistant 
	//'------------------------------------
	$returnURL = ''.site_url().'/confirm-subscription/';

	//'------------------------------------
	//' The cancelURL is the location buyers are sent to when they hit the
	//' cancel button during authorization of payment during the PayPal flow
	//'
	//' This is set to the value entered on the Integration Assistant 
	//'------------------------------------
	$cancelURL = ''.site_url().'/speaker-profile/';
	//'------------------------------------
	//' Calls the SetExpressCheckout API call
	//'
	//' The CallShortcutExpressCheckout function is defined in the file PayPalFunctions.php,
	//' it is included at the top of this file.
	//'-------------------------------------------------
	$resArray = CallShortcutExpressCheckout ($paymentAmount, $currencyCodeType, $paymentType, $returnURL, $cancelURL);

	$ack = strtoupper($resArray["ACK"]);
	if($ack=="SUCCESS" || $ack=="SUCCESSWITHWARNING")
	{
		RedirectToPayPal ( $resArray["TOKEN"] );
	} 
	else  
	{
		//Display a user friendly Error on the page using any of the following error information returned by PayPal
		$ErrorCode = urldecode($resArray["L_ERRORCODE0"]);
		$ErrorShortMsg = urldecode($resArray["L_SHORTMESSAGE0"]);
		$ErrorLongMsg = urldecode($resArray["L_LONGMESSAGE0"]);
		$ErrorSeverityCode = urldecode($resArray["L_SEVERITYCODE0"]);

		echo "SetExpressCheckout API call failed. ";
		echo "Detailed Error Message: " . $ErrorLongMsg;
		echo "Short Error Message: " . $ErrorShortMsg;
		echo "Error Code: " . $ErrorCode;
		echo "Error Severity Code: " . $ErrorSeverityCode;
	}
}else{
	echo '<script>window.location.href="'.site_url().'/payment"; </script>';
}
?>
</div>