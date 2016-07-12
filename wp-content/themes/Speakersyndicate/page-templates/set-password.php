<?php
/*
Template Name: Set Password
*/
?>


<?php
$msg='';
if(is_user_logged_in ()){
	wp_redirect( home_url() ); exit;
}
if(isset($_POST['submit'])){
	if(isset($_GET['get'])){
		$newPassWord	=	$_POST['user_input'];
		$userID			=	base64_decode($_GET['get']);
		if($userID !='' && $newPassWord !=''){
			wp_set_password( $newPassWord, $userID );
			$msg="Your password has been set sucessfully.";
		}else{
			$msg="Threre is a problem to set password. Please try again.";
		}
	}else{
		$ForgotPassLink	=	site_url()."/forgot-password/";
		wp_redirect($ForgotPassLink); exit;
	}
}
?>
<?php
get_header();
?>

<div class="container">
  <div class="forgot-pass">
<p class="color"><?php echo $msg; ?></p>
<form  onsubmit="return validateForm()" name="wp_set_pass" action="" method="post">			
			<input type="password" class="text" name="user_input"  />
			
			<input type="submit"   name="submit" value="Submit" />					
</form>
<script>
function validateForm() {
    var x = document.forms["wp_set_pass"]["user_input"].value.length;
	
    if (x == null || x == "") {
        
		sweetAlert('', 'Please enter your password.', 'error');
        return false;
    }else if(x<6){
		sweetAlert('', 'Please enter at laest 6 digit.', 'error');
        return false;
	}else{
		 return true;
	}
}
</script>
   </div>
 </div>
<?php get_footer(); ?>