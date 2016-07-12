<?php
/*
 Template Name: Speaker Profile Template
 */
?>
<?php
if(isset($_POST['speaker_id'])){
	unset($_SESSION['speakerID']);	
	$speaker_id					=	$_POST['speaker_id'];
	$_SESSION['speakerID'] 		= 	$speaker_id;
	$CurrentUserID = $speaker_id;
	$currentUserData 			= 	get_userdata($CurrentUserID);
	$UserEmail 			=	$currentUserData->user_email;
}else{
	$CurrentUserID = get_current_user_id();
	$currentUserData 	= wp_get_current_user();
	$UserEmail 			=	$currentUserData->user_email;
}
get_header();
global $wpdb;


if($CurrentUserID ==0 || $CurrentUserID==''){
	echo '<script>window.location.href="'.site_url().'/speaker"; </script>';
}
	$GetKeynoteData 		= $wpdb->get_results("SELECT * FROM sp_keynote_programs WHERE user_id ='$CurrentUserID'"); 
	$keynote_title			=	unserialize($GetKeynoteData['0']->keynote_title);
	$keynote_description	=	unserialize($GetKeynoteData['0']->keynote_description);
	$keynote_program1		=	unserialize($GetKeynoteData['0']->keynote_program1);
	$keynote_program2		=	unserialize($GetKeynoteData['0']->keynote_program2);
	$keynote_program3		=	unserialize($GetKeynoteData['0']->keynote_program3);
	$keynote_program4		=	unserialize($GetKeynoteData['0']->keynote_program4);
	$keynote_photo			=	unserialize($GetKeynoteData['0']->keynote_photo);
	
	$GetClientTestData 		= $wpdb->get_results("SELECT * FROM sp_testimonials WHERE user_id ='$CurrentUserID'"); 
	$detailed_testimonial	=	unserialize($GetClientTestData['0']->detailed_testimonial);
	$client_name			=	unserialize($GetClientTestData['0']->client_name);
	$client_img				=	unserialize($GetClientTestData['0']->client_img);
	/*   echo "<pre>";
	 print_r($client_img);
	 echo "</pre>";  */
	$GetUserImageData 		= $wpdb->get_results("SELECT * FROM sp_user_img WHERE user_id ='$CurrentUserID'"); 
	$user_img				=	$GetUserImageData['0']->user_img;
	$detailed_photo1		=	$GetUserImageData['0']->detailed_photo1;
	$detailed_photo2		=	$GetUserImageData['0']->detailed_photo2;
	$detailed_photo3		=	$GetUserImageData['0']->detailed_photo3;
	$ImagePath				=	site_url()."/wp-content/themes/Speakersyndicate/speaker_images/";
	$noImg					=	'no_profile_img.gif';
	$profile_headline 		= 	get_user_meta( $CurrentUserID, 'profile_headline', true ); 
	$description 			= 	get_user_meta( $CurrentUserID, 'description', true ); 
	$fee_range 				= 	get_user_meta( $CurrentUserID, 'fee_range', true ); 
	$speaker_phone 			= 	get_user_meta( $CurrentUserID, 'speaker_phone', true );  
	$speakerWebsite 		= 	get_user_meta( $CurrentUserID, 'speaker_website', true ); 
	$embed_video1 			= 	get_user_meta( $CurrentUserID, 'embed_video1', true ); 
	$embed_video2 			= 	get_user_meta( $CurrentUserID, 'embed_video2', true );
	$detailed_biography 	= 	get_user_meta( $CurrentUserID, 'detailed_biography', true );
	//$UserEmail 				= 	get_user_meta( $CurrentUserID, 'user_email', true );
?>
<div class="speaker-profile-section">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-9">
        <div class="profile-pic">
           <img src="<?php if($user_img !=''){ echo $ImagePath.$user_img; }else{echo $ImagePath.$noImg;} ?>" alt="<?php if($user_img !=''){ echo $user_img; } ?>" />
        </div> <!---profile-pic--->
      
        <div class="speaker-description">
		<?php 
		$getloginUserID = get_current_user_id();
		if(is_user_logged_in () && $getloginUserID==$CurrentUserID){ ?>
			<form action="<?php echo site_url(); ?>/set-speaker-profile/" method="POST">
				<input type="hidden" name="speaker_id" value="<?php echo $CurrentUserID; ?>">
			<button class="btn btn-default btn-sunet" value="" name="profile_edit" type="submit">Edit Profile</button>
			</form>
			<a class="btn btn-default btn-sunet" href="<?php echo wp_logout_url( home_url() ); ?>">Logout</a>
		<?php } ?>
          <h2><?php if($profile_headline !=''){echo $profile_headline;} ?></h2>
        <?php if($profile_headline !=''){
			echo "<p>".$description."</p>";
			} ?>
           
        </div> <!---speaker-description--->
        
        <div class="speaker-tags">
          <table>
             <tr>
               <th></th>
               <th>Fee Range</th>
               <th>PHONE</th>
               <th>WEBSITE</th>
             </tr>
             
             <tr>
               <td><a class="back-to-result" href="<?php echo site_url(); ?>/search">Back to Search Results</a></td>
               <td><?php if($fee_range !=''){echo $fee_range;} ?></td>
               <td><a href="tel:<?php if($speaker_phone !=''){echo $speaker_phone;} ?>"><?php if($speaker_phone !=''){echo $speaker_phone;} ?></a></td>
               <td><a target="_blank" href="<?php if($speakerWebsite !=''){echo $speakerWebsite;} ?>"><?php if($speakerWebsite !=''){echo $speakerWebsite;} ?></a></td>
             </tr>
          </table>
        </div>
      </div> <!---col-xs-12 col-md-8--->
      <?php if(!is_user_logged_in ()){ ?>
      <div class="col-xs-12 col-md-3">
        <div class="contact-form-spaeker">
          <h3>CONTACT THIS SPEAKER</h3>
          <form action="" method="POST" id="speaker-enquiry-form">
			  <input type="text" name="enquiry_name" id="enquiry_name" class="form-control" placeholder="Name">
			  <input type="text" name="enquiry_email" id="enquiry_email" class="form-control" placeholder="Email">
			  <input type="text" name="enquiry_phone" maxlength="15" id="enquiry_phone" class="form-control" placeholder="Phone">
			  <textarea class="form-control" name="enquiry_msg" id="enquiry_msg" placeholder="Message" ></textarea>
			  <input type="hidden" name="UserEmail" value='<?php echo $UserEmail; ?>'> 
			   <input type="hidden" name="speakerID" value='<?php echo $CurrentUserID; ?>'>
			  <input type="submit" class="btn btn-default btn-submit" value="send message">
		  </form><div class="form-message" style="display:none;"></div>
        </div> <!---cntact-form-speaker--->
      </div> <!---col-xs-12 col-md-4--->
	  <?php } ?>
    </div> <!--row-->
  </div> <!---container--->
</div> <!---speaker-profile-section--->

<div class="video-section">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div class="embed-responsive embed-responsive-16by9">
		<?php
		if (strpos($embed_video1, 'youtube')) { 
			//$url 			= 'https://www.youtube.com/watch?v=1OYhHpMKgTs';
			$getYoutubeurl 	=  explode("v=",$embed_video1); 
			$youtubeUrl		=	$getYoutubeurl[1];

		?>
			<iframe width="420" height="315" src="https://www.youtube.com/embed/<?php echo $youtubeUrl; ?>" frameborder="0" allowfullscreen></iframe>
				
			<?php	}	?>
			
			<?php
				if (strpos($embed_video1, 'vimeo')) { ?>
			  <iframe class="embed-responsive-item" src='<?php echo $embed_video1; ?>'></iframe>
			<?php	}	?>
         
		      
         </div> <!--embed-responsive-->
      </div> <!--col-xs-12 col-md-6-->
      
       <div class="col-xs-12 col-md-6">
         <div class="embed-responsive embed-responsive-16by9">
          <?php
		if (strpos($embed_video2, 'youtube')) { 
			//$url 			= 'https://www.youtube.com/watch?v=1OYhHpMKgTs';
			$getYoutubeurl 	=  explode("v=",$embed_video2); 
			$youtubeUrl		=	$getYoutubeurl[1];

		?>
			<iframe width="420" height="315" src="https://www.youtube.com/embed/<?php echo $youtubeUrl; ?>" frameborder="0" allowfullscreen></iframe>
				
			<?php	}	?>
			
			<?php
				if (strpos($embed_video2, 'vimeo')) { ?>
			  <iframe class="embed-responsive-item" src='<?php echo $embed_video2; ?>'></iframe>
			<?php	}	?>
         </div> <!--embed-responsive-->
      </div> <!--col-xs-12 col-md-6-->
      
    </div> <!--row-->
  </div> <!--container-->
</div>  <!---video-section--->

<div class="biography">
  <div class="container">
     <div class="biography-content">    
       <h2>Biography</h2>
       
       <div class="biography-description">
          <p><?php echo $detailed_biography; ?></p>
          
       </div> 
     </div>
  </div>
</div>  <!--biography-->

<div class="speaker-gallery">
  <div class="container">
   <div class="row">
       <div class="col-sm-4 gallery-box"> 
          <img src='<?php if($detailed_photo1!=''){echo $ImagePath.$detailed_photo1;}else{echo $ImagePath.$noImg;} ?>' alt='<?php if($detailed_photo1!=''){echo $detailed_photo1;} ?>'>
        </div> <!--gallery-box-->
      
     <div class="col-sm-4 gallery-box">
       <img src='<?php if($detailed_photo2!=''){echo $ImagePath.$detailed_photo2;}else{echo $ImagePath.$noImg;} ?>' alt='<?php if($detailed_photo2!=''){echo $detailed_photo2;} ?>'>
     </div> <!--gallery-box-->
    
    <div class="col-sm-4 gallery-box">
      <img src='<?php if($detailed_photo3!=''){echo $ImagePath.$detailed_photo3;}else{echo $ImagePath.$noImg;} ?>' alt='<?php if($detailed_photo3!=''){echo $detailed_photo3;} ?>'>
    </div> <!--gallery-box-->
    
  </div>
 </div> 
</div> <!---speaker-gallery--->


<div class="keynote-programs">
  <div class="container">
    <h2>keynote programs</h2>
    <?php
	$counter=0;
if(!empty($keynote_title)){
	foreach($keynote_title as $GetKeynoteTittle){
		$GetKeynoteTittle;
		$Getkeynote_description		=	$keynote_description[$counter];
		$Getkeynote_program1		=	$keynote_program1[$counter];
		$Getkeynote_program2		=	$keynote_program2[$counter];
		$Getkeynote_program3		=	$keynote_program3[$counter];
		$Getkeynote_program4		=	$keynote_program4[$counter];
		$Getkeynote_photo			=	$keynote_photo[$counter];
		$counter++;
		/* echo "<pre>";
	print_r($keynote_photo);
	echo "</pre>";  */
	?>
	
    <div class="keynote-box"> 
      <img src='<?php if($Getkeynote_photo !=''){ echo bloginfo('template_directory')."/timthumb.php?src=".$ImagePath.$Getkeynote_photo."&h=300&w=400&zc=1q=100"; }else{echo bloginfo('template_directory')."/timthumb.php?src=".$ImagePath.$noImg."&h=300&w=400&zc=1q=100";} ?>' alt='<?php if($Getkeynote_photo !=''){ echo $ImagePath.$Getkeynote_photo; }else{echo 'no+title'; } ?>'>
     <div class="keynote-content">
        <p><strong><?php echo $GetKeynoteTittle; ?></strong></p> 
        <p><?php echo $Getkeynote_description; ?></p>
        <ul>
          <li><?php echo $Getkeynote_program1; ?></li>
		  <?php if($Getkeynote_program2!=''){echo '<li>'.$Getkeynote_program2.'</li>';} ?>
          <?php if($Getkeynote_program3!=''){echo '<li>'.$Getkeynote_program3.'</li>';} ?>
        </ul> 
         
     </div> <!--keynote-content-->  
    </div> <!---keynote-box close--->
	<?php } }?>
    
   
    
  </div>
</div> <!--keynote-programs Close--> 


<div class="testimonial-section">
  <div class="container">
   <div class="cd-testimonials-wrapper cd-container">
      <h2>Testimonials</h2>
	 <ul class="cd-testimonials">
	 <?php
	 $testFlag=0;
	 /* echo "<pre>";
	 print_r($client_img);
	 echo "</pre>";  */
			foreach($detailed_testimonial as $getDetailTestnomial){
				$Getclient_name		=	$client_name[$testFlag];
				$Getclient_img		=	$client_img[$testFlag];
			?>
		<li>
  			<p><?php echo $getDetailTestnomial; ?></p>
			<div class="cd-author">
				
				<ul class="cd-author-info">
					<li><?php echo $Getclient_name; ?></li>
					
				</ul>
                <img src='<?php if($Getclient_img !=''){ echo $ImagePath.$Getclient_img; }else{echo $ImagePath.$noImg;} ?>' alt="Author image">
			</div>
		</li>
			<?php } ?>
		
	</ul> <!-- cd-testimonials -->

	
    </div> <!-- cd-testimonials-wrapper --> 
    
   <div class="speakers-links"> 
    <div class="col-sm-4">  
      <a class="btn btn-default btn-links" href="tel:<?php echo $speaker_phone; ?>"><?php echo $speaker_phone; ?></a> 
    </div> <!--col-sm-4-->
    
     <div class="col-sm-4">  
      <a class="btn btn-default btn-links" target="_blank" href="<?php echo $speakerWebsite; ?>">Speaker's Website</a> 
    </div> <!--col-sm-4-->
    
     <div class="col-sm-4">  
      <a class="btn btn-default btn-links" href="<?php echo site_url(); ?>/search">Back to Search Results</a> 
    </div> <!--col-sm-4-->
    
   </div> <!--speakers-links-->
  </div>
</div> <!--testimonial-section-->
  
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/speaker_enquiry.js" type="text/javascript" charset="utf-8"></script>


<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<script>
jQuery(document).ready(function(){
jQuery.noConflict();
   jQuery("#enquiry_name").keypress(function(event){
       var inputValue = event.which;
       // allow letters and whitespaces only.
       if((inputValue > 33 && inputValue < 64) || (inputValue > 90 && inputValue < 97 ) || (inputValue > 123 && inputValue < 126) && (inputValue != 32)){
           event.preventDefault();
       }
   });
    
 });
</script>
<?php get_footer(); ?>