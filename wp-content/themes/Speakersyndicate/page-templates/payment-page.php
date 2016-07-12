<?php
/*
Template Name: Payment Page
*/
get_header();
?>
<div class="container">
  <div class="payment-gateway">	

<?php
$user_ID = get_current_user_id();
/* echo "<pre>";
print_r($_GET);
echo "</pre>"; */
if($_GET['msg']==1){
	echo '<p class="error">There was some problem in payment plaese try again.</p>';
}
if($user_ID==0){
	echo '<script>window.location.href="'.site_url().'/speaker";</script>';
}
$PlanID	=	3;
if(isset($_GET['tim'])){
	$PlanID		=	base64_decode($_GET['tim']);
}
if($PlanID==1){
	$Payment_Amount	=	2000;
}elseif($PlanID==2){
	$Payment_Amount	=	1500;
}elseif($PlanID==''){
	$Payment_Amount	=	1000;
}else{
	$Payment_Amount	=	1000;
}
?>


    <form action='<?php echo site_url(); ?>/checkout-page/' METHOD='POST'>
	<input type="hidden" name="Payment_Amount" value="<?php echo $Payment_Amount; ?>"/>
	<input type="hidden" name="speaker_id" value='<?php echo $user_ID = get_current_user_id(); ?>'/>	
	<input type="hidden" name="PlanID" value='<?php echo $PlanID; ?>'/>
        <h3>Please confirm your payment for better result</h3>
		<p>Start test recurring payment.</p>
		<p>You will pay $<?php echo $Payment_Amount; ?> monthly to this service.</p>
		<input type='image' name='submit' src='https://www.paypal.com/en_US/i/btn/btn_xpressCheckout.gif' border='0' align='top' alt='Check out with PayPal'/>
		
	</form>
  </div>  
</div>    
    
	<?php get_footer(); ?>
	
