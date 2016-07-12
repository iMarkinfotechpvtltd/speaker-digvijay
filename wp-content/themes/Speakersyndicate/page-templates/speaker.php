<?php
/*
 Template Name: Speaker Template
 */

if(isset($_POST['login_form'])){
		$Username	=	$_POST['Username'];
		$Password	=	$_POST['Password'];
		$getId		=	get_user_by ( 'email', $Username);
		$UserID		=	$getId->ID;
		
		$Getactivity_status	=	get_user_meta($UserID, 'activity_status');
		$activity_status	=	$Getactivity_status[0];
		$errorMsg	=	'';
		if($Username==''){
			$errorMsg = "Please enter Username.";
		}elseif($Password==''){
			$errorMsg = "Please enter Password.";
		}elseif($UserID	=='' && $Username !=''){
			$errorMsg = "Please check your email.";
		}elseif($activity_status==0){
			$errorMsg = "Please wait. Admin will approve your registration.";
		}else{
			$creds = array();
			$creds['user_login'] = $Username;
			$creds['user_password'] = $Password;
			$creds['remember'] = true;
			$user = wp_signon( $creds, false );
				if (is_wp_error($user)){
					$errorMsg = "Please check your password.";
				}else{
							$user_id	=	$user->ID;
							wp_set_current_user( $user_id, $Username );
							wp_set_auth_cookie( $user_id, true, false );
							do_action( 'wp_login', $Username );
							update_user_meta( $user_id, 'activity_status', 1); 
							echo '<script>window.location.href="'.site_url().'/speaker/"; </script>';
				}
			}
	}
		
 get_header();
?>
<?php
global $wpdb;
$CurrentUserID = get_current_user_id();
$GetPaymentProfileStatus = $wpdb->get_results("SELECT PROFILESTATUS FROM sp_payments WHERE speaker_id ='$CurrentUserID'"); 
$PaymentProfileStatus	=	$GetPaymentProfileStatus['0']->PROFILESTATUS;
$set_free__account_status='';
if ( function_exists( 'ot_get_option' ) ) : 
	$set_free__account_status	= ot_get_option( 'set_free__account_status' ); 
 endif; 
 
 //echo $set_free__account_status."--->>".$PaymentProfileStatus; die;
	if($set_free__account_status=='off' && $PaymentProfileStatus=='' && $CurrentUserID!=''){
		$paymentStartDate	= date("Y-m-1", strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
		$wpdb->insert('sp_payments', array(
			'speaker_id' => $CurrentUserID,
			'PROFILESTATUS' => 'Active',
			'payment_start_date' => $paymentStartDate,
			'plan_index'	=> '3'
		   ));
		   $wpdb->query("UPDATE sp_search_attributes SET profile_status = 'Active' WHERE speaker_id = '$speakerID'");
	}
	
	
echo '<p class="s-error">'.$errorMsg.'</p>';
if (is_user_logged_in() && $PaymentProfileStatus=='' && $set_free__account_status!='off'){
	echo '<script>window.location.href="'.site_url().'/payment/"; </script>';
}else if(is_user_logged_in() && $PaymentProfileStatus!=''){
		$urlID				=	get_user_meta( $CurrentUserID, 'urlID', true);
		$urldata			= 	get_post($urlID);
		$speakerProfileUrl	=	$urldata->guid; 
	echo '<script>window.location.href="'.$speakerProfileUrl.'"; </script>';
}else{
	
	//echo '<script>window.location.href="'.site_url().'/speaker/"; </script>';
}
?>
<div class="speaker-log-in">
  <div class="container">
    <div class="form-section">

	  <form action="" method="POST" id="login-form">
      <div class="row"> 
        <div class="col-xs-12 col-md-5">
          <span class="user icon"></span>
          <input type="text" class="form-control" id="Username" name="Username" placeholder="Username">
        </div> <!--col-xs-12 col-md-5 close-->
        <div class="col-xs-12 col-md-5">
        <span class="user password"></span>
          <input type="password" class="form-control" id="Password" name="Password"  placeholder="Password">
          <div class="rember-check">
           <label> <input type="checkbox"> 
            Remember me</label>
          </div>
          <a class="forgot-passcode" href="<?php echo site_url(); ?>/forgot-password/">Forgot Password?</a>
        </div> <!--col-xs-12 col-md-5 close-->
        
        <div class="col-xs-12 col-md-2">
          <input type="submit" name="login_form" class="btn btn-default btn-sign" value="sign in">	
        </div> <!--col-xs-12 col-md-5 close-->
        
      </div> <!--row close-->
	 </form>
    </div> <!---form-section--->
  </div>
</div> <!---speaker-log-in Close--->

<div class="speaker-application">
<?php $getImage	= get_field('spker_banner', 11); ?>
  <img src="<?php echo $getImage['url']; ?>" alt="..." />
 <div class="speaker-caption"> 
   <h2><?php echo get_field('banner_title', 11); ?></h2>
 </div> <!--spearker-caption--> 
</div> <!--speaker-application Close-->

<div class="speaker-application">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6 padding-right">
        <div class="speaker-application-block">
         <?php echo get_field('speaker_application', 11); ?>
        </div> 
      </div> <!--col-xs-12 col-md-6-->
      <div class="col-xs-12 col-md-6 padding-left">
        <div class="submit-your-application">
          <h3>submit your application</h3>
          <p>The Speaker Syndicate is an elite group of professional speakers. 
Please begin the application process below if you would like to 
join our community.</p>
          
          <div class="speaker-form">
		  <form action="" method="POST" id="visitor-form">
             <input type="text" class="form-control" id="visitor_name" name="visitor_name" placeholder="First Name">
             <input type="text" class="form-control" id="visitor_lastname" name="visitor_lastname" placeholder="Last Name">
             <input type="text" class="form-control" id="visitor_email" name="visitor_email" placeholder="Email">
             <input type="text" class="form-control" name="visitor_website" id="visitor_website" placeholder="Website">
             
             <select class="form-control">
                <option>Fee Range (USA)</option>
                <option>$5,000 to $7,500</option>
                <option>$7,500 to $15,000</option>
               <option>$15,000 to $25,000</option>
             </select>
             
            <input type="submit" name="visiror_form" class="btn btn-default btn-join" value="join us"> 
			<div class="loader" style="display:none;"></div>
		</form><div class="form-message" style="display:none;"></div>  
          </div> <!---speaker-form--->
        </div> <!---submit-your-application Close--->
      </div> <!--col-xs-12 col-md-6-->
      
    </div> 
  </div>
</div> <!--Speaker-application-->

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/visitor_enquiry.js" type="text/javascript" charset="utf-8"></script>

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/form.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>

<script>
jQuery(document).ready(function(){
jQuery.noConflict();
   jQuery("#visitor_name").keypress(function(event){
       var inputValue = event.which;
       // allow letters and whitespaces only.
       if((inputValue > 33 && inputValue < 64) || (inputValue > 90 && inputValue < 97 ) || (inputValue > 123 && inputValue < 126) && (inputValue != 32)){
           event.preventDefault();
       }
   });
      jQuery("#visitor_lastname").keypress(function(event){
       var inputValue = event.which;
       // allow letters and whitespaces only.
       if((inputValue > 33 && inputValue < 64) || (inputValue > 90 && inputValue < 97 ) || (inputValue > 123 && inputValue < 126) && (inputValue != 32)){
           event.preventDefault();
       }
   });
 });
</script>
<?php get_footer(); ?>