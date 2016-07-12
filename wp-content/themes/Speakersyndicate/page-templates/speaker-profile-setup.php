<?php
/*
 Template Name: Speaker Profile Setup Template
 */
?>
<?php get_header();
global $wpdb;
$keyNoteAlert	=	'';
if(!is_user_logged_in ()){
		$keyNoteAlert	=	'You can not not add more than 3 keynote prdogram.';
}
if(isset($_POST['speaker_id'])){
	$speaker_id					=	$_POST['speaker_id'];
	$_SESSION['speaker_id'] 	= 	$speaker_id;
	
}
$CurrentUserID		=	 get_current_user_id();
$currentUserData 	= 	wp_get_current_user();
$UserEmail 			=	$currentUserData->user_email; 
$UserFirstName 		=	$currentUserData->first_name; 
$UserLastName 		=	$currentUserData->last_name; 
$GetKeynoteData 			= $wpdb->get_results("SELECT * FROM sp_keynote_programs WHERE user_id ='$CurrentUserID'"); 
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
	$gender 				= 	get_user_meta( $CurrentUserID, 'gender', true );
	$topic_keywords 		= 	get_user_meta( $CurrentUserID, 'topic_keywords', true );
$GetPcakageData 			= $wpdb->get_results("SELECT plan_index FROM sp_payments WHERE speaker_id ='$CurrentUserID'");
$PackageID					=	 $GetPcakageData[0]->plan_index;
if($PackageID==3){
	$CategoryLimit	=	2;
	$keywordLimit	=	10;
	$keynoteLimit	=	2;
}elseif($PackageID==2){
	$CategoryLimit	=	4;
	$keywordLimit	=	15;
	$keynoteLimit	=	3;
}elseif($PackageID==1){
	$CategoryLimit	=	6;
	$keywordLimit	=	20;
	$keynoteLimit	=	4;
}elseif($PackageID==''){
	$CategoryLimit	=	2;
	$keywordLimit	=	10;
	$keynoteLimit	=	2;
}else{
	$CategoryLimit	=	2;
	$keywordLimit	=	10;
	$keynoteLimit	=	2;
}
if(isset($_POST['update_profile'])){
	
	$plan_id						=	$_POST['plan_id'];
	$GetPcakageData 			= $wpdb->get_results("SELECT payment_start_date FROM sp_payments WHERE speaker_id ='$CurrentUserID'");
	$payment_start_date			=	 $GetPcakageData[0]->payment_start_date;
			$currentDate		=	date("Y-m-d");
			$date1 		= new DateTime($payment_start_date);
			$date2 		= new DateTime($currentDate);
			$interval 	= $date1->diff($date2);
			$days		=	$interval->days;
	
		$errorFlag='';
	if($days<=90){
		$errorFlag=1;
	}elseif($days>90	&& 	$plan_id!=''){
		$enPlanId	=	base64_encode($plan_id);
		echo '<script>window.location.href="'.site_url().'/payment/?tim='.$enPlanId.'"; </script>';
	}else{
		echo '<script>window.location.href="'.site_url().'/speaker-profile/"; </script>';
	}
}
$StartDate	= date("Y-m-1", strtotime(date('m', strtotime('+1 month')).'/01/'.date('Y').' 00:00:00'));
?>

<div class="container memeber-secription">

<?php if(is_user_logged_in()){ ?>
	<form action="" method="post">
		Select Your Plan: <select name="plan_id">
		  <option value="2">Gold</option>
		  <option value="1">Platinum</option>
		</select> 
			<input type="hidden" value='<?php echo $StartDate; ?>' name="payment_start_date">
		<button type="submit" name="update_profile" value="" class="btn btn-default btn-sunet">Update Profile</button>
	</form>
	<?php if($errorFlag==1){echo '<div class="error"><p>You can not upgrade profile before 3 months.</p></div>';} ?>
<?php } ?>
</div>
<form action="javascript:;" enctype="multipart/form-data" method="post" accept-charset="utf-8" id="speaker_profile_setup_form">
<div class="speaker-profile-section">

  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-9">
        <div class="profile-pic" id="image-holder">
		<?php 
			if(isset($user_img)){
				$userImgUrl	=	$ImagePath.$user_img;
			}else{
				$userImgUrl	=  get_template_directory_uri()."/images/speaker-Profile-SetUp-pagepp.jpg";
			}
		?>
           <img src="<?php echo $userImgUrl; ?>" alt="...." />
   
		  <!-- <input class="add-image" id="fileUpload"  onchange="return ValidateFileUpload('fileUpload')" name='user_img' multiple="multiple" type="file" />-->
           <div class="file-up">
					<input type="file" onchange="return ValidateFileUpload('fileUpload')" name='user_img' id="fileUpload" class="add-image inputfile inputfile-1" multiple="multiple" />
					<label for="fileUpload"> <span>Add a Photo</span></label>
		   </div>		
		</div> <!---profile-pic--->
       <style type="text/css">.thumb-image{float:left;width:100px;position:relative;padding:5px;}</style>

        <div class="speaker-description border-d">
           <div class="overview-setup">
       <?php if(isset($_SESSION['visitor_name'])) {
				$visitor_name = $_SESSION['visitor_name'];
			}elseif(isset($UserFirstName)){
				$visitor_name	=	$UserFirstName;
			} else {
				//echo '<script>window.location.href="'.site_url().'/speaker";</script>';
			}
			if(isset($_SESSION['visitor_email'])) {
					$visitor_email = $_SESSION['visitor_email'];
				}elseif(isset($UserEmail)){
					$visitor_email	=	$UserEmail;
				} else {
						$visitor_email = '';
					} 	
			if(isset($_SESSION['visitor_lastname'])) {
					$visitor_lastname = $_SESSION['visitor_lastname'];
				}elseif(isset($UserLastName)){
						$visitor_lastname	=	$UserLastName;
					}else{
							$visitor_lastname = '';
						}
			if(isset($_SESSION['visitor_website'])) {
					$visitorWebsite = $_SESSION['visitor_website'];
				}elseif(isset($speakerWebsite)){
					$visitorWebsite	=	$speakerWebsite;
				} else {
					$visitorWebsite = '';
				}				
		?>
		
				<input type="text" value='<?php echo $visitor_name; ?>' id="firstname" name="firstname" class="form-control" placeholder="First Name">
				<input type="text" value='<?php echo $visitor_lastname; ?>' id="lastname" class="form-control marg" name="lastname" placeholder="Last Name"> 
					
				</div>
				 <div class="overview-tittle-setup">
				<input type="email"  class="form-control marg" value='<?php echo $visitor_email; ?>' id="email" name="email" placeholder="Email"> 	
				</div>
		 
		    <div class="overview-tittle-setup">
                <select class="form-control" name="gender">
				  <option value="0">Gender</option>
                  <option value="male" <?php if($gender=='male'){ echo 'selected';} ?>>Male</option>
				  <option value="female" <?php if($gender=='female'){ echo 'selected';} ?>>Female</option>
				</select> 
          </div>
          <div class="overview-tittle-setup">
              <input type="text" class="form-control" value="<?php if($profile_headline!=''){ echo $profile_headline; } ?>" id="prof_headline" name="prof_headline" placeholder="Your Professional Headline"> 
          </div>
		   <div class="overview-tittle-setup">		
             <input id="topic-keywords" value='<?php echo $topic_keywords; ?>' name="topic_keywords" class="form-control" placeholder="Enter Topic keywords" type="text" />
          </div>
          <div class="overview-tittle-setup">
                 <p>(Maximum 200 character)</p>
              <textarea  maxlength="200" id="biography" class="form-control" name="biography" placeholder="Biography">
			  <?php if(isset($description)){echo $description;} ?></textarea> 
          </div>
          
          <div class="overview-free-setup">
              <select type="text" name="fee_range" class="form-control">  
                   <option value="Fee Range (USA)" <?php if (isset($fee_range) && $fee_range=="Fee Range (USA)") echo ' selected';?>>Fee Range (USA)</option>
                   <option value="$5,000 to $7,500" <?php if (isset($fee_range) && $fee_range=="$5,000 to $7,500") echo ' selected';?>>$5,000 to $7,500</option>
                   <option value="$7,500 to $15,000" <?php if (isset($fee_range) && $fee_range=="$7,500 to $15,000") echo ' selected';?>>$7,500 to $15,000</option>
                   <option value="$15,000 to $25,000" <?php if (isset($fee_range) && $fee_range=="$15,000 to $25,000") echo ' selected';?>>$15,000 to $25,000</option>
              </select>
              
              <input type="text" value='<?php if(isset($speaker_phone)){ echo $speaker_phone; } ?>' class="form-control" id="val_phone" required name="phone" maxlength="15" placeholder="Phone">
              <input type="text" class="form-control" value="<?php echo $visitorWebsite; ?>" name="website" placeholder="Website">
              
          </div>
           
          </div> 
           
        </div> <!---speaker-description--->
        
      </div> <!---col-xs-12 col-md-8--->
      
     
    </div> <!--row-->
  </div> <!---container--->
</div> <!---speaker-profile-section--->

<div class="video-section">
  <div class="container">
    <div class="row">
      <div class="col-xs-12 col-md-6">
        <div class="embed-responsive embed-responsive-16by9">
            <div class="video-set-up">
               <h3>Embed Video</h3>
              
             <div class="url-input">
               <p>We currently support Youtube and Vimeo</p>
               <input type="text" value='<?php if(isset($embed_video1)){ echo $embed_video1; } ?>' name="embed_video1" class="form-control" placeholder="Enter Video URL">
             </div>  
            
            </div>
         </div> <!--embed-responsive-->
      </div> <!--col-xs-12 col-md-6-->
      
       <div class="col-xs-12 col-md-6">
         <div class="embed-responsive embed-responsive-16by9">
            <div class="video-set-up">
               <h3>Embed Video</h3>
              
             <div class="url-input">
               <p>We currently support Youtube and Vimeo</p>
               <input type="text" value='<?php if(isset($embed_video2)){ echo $embed_video2; } ?>' name="embed_video2" class="form-control" placeholder="Enter Video URL">
			   <input type='hidden' value='<?php if(isset($CurrentUserID) && $CurrentUserID!=0) { echo $CurrentUserID;} ?>' name="speakerID">
             </div>  
           
            </div>
         </div> <!--embed-responsive-->
      </div> <!--col-xs-12 col-md-6-->
      
    </div> <!--row-->
  </div> <!--container-->
</div>  <!---video-section--->

<div class="biography">
  <div class="container">
     <div class="biography-content editor-setup">    
       <h2>Biography</h2>
       
      
         <div class="biography-editor"> 
          <p>(Maximum 1000 character)</p>
           <div class="input-holder"> 
            <div class="boigraphy-icon"></div> 
             <textarea class="form-control" maxlength="1000" name="detailed_biography" id="detailed_biography" placeholder="Biography"><?php if(isset($detailed_biography)){ echo $detailed_biography; } ?></textarea>
             
           </div>
         </div> 
       </div> 
  
  </div>
</div>  <!--biography-->

<div class="speaker-gallery">
  <div class="container">
   <div class="row">
       <div class="col-sm-4 gallery-box"> 
          <div class="img-gallery" id="image-holder-1">
		  <?php 
			if(isset($detailed_photo1)){
				$detailed_photo1Url	=	$ImagePath.$detailed_photo1;
			}else{
				$detailed_photo1Url	=  get_template_directory_uri()."/images/speaker-Profile-SetUp-pagepp.jpg";
			}
			if(isset($detailed_photo2)){
				$detailed_photo2Url	=	$ImagePath.$detailed_photo2;
			}else{
				$detailed_photo2Url	=  get_template_directory_uri()."/images/speaker-Profile-SetUp-pagepp.jpg";
			}
			if(isset($detailed_photo3)){
				$detailed_photo3Url	=	$ImagePath.$detailed_photo3;
			}else{
				$detailed_photo3Url	=  get_template_directory_uri()."/images/speaker-Profile-SetUp-pagepp.jpg";
			}
		?>
            <img src="<?php echo $detailed_photo1Url; ?>" alt="....">
     
		</div>
		<!-- <input id="detailed_photo1"  onchange="return ValidateFileUpload('detailed_photo1')" name="detailed_photo1"  type="file"/>-->
         <div class="file-up">
					<input type="file" onchange="return ValidateFileUpload('detailed_photo1')" name="detailed_photo1"  id="detailed_photo1" class="add-image inputfile inputfile-1" multiple="multiple" />
					<label for="detailed_photo1"> <span>Add Photo</span></label>
		   </div>
			
        </div> <!--gallery-box-->
      
     <div class="col-sm-4 gallery-box">
       <div class="img-gallery" id="image-holder-2">
            <img src="<?php echo $detailed_photo2Url; ?>" alt="....">
            <a class="add-more" href=""></a>
           
          </div>
		<!--  <input id="detailed_photo2" onchange="return ValidateFileUpload('detailed_photo2')" name="detailed_photo2" multiple="multiple" type="file"/>-->
          
           <div class="file-up">
					<input type="file" onchange="return ValidateFileUpload('detailed_photo2')" name="detailed_photo2"  id="detailed_photo2" class="add-image inputfile inputfile-1" multiple="multiple" />
					<label for="detailed_photo2"> <span>Add Photo</span></label>
		   </div>
		 
     </div> <!--gallery-box-->
    
    <div class="col-sm-4 gallery-box">
      <div class="img-gallery" id="image-holder-3">
            <img src="<?php echo $detailed_photo3Url; ?>" alt="....">
         
          </div>
	<!--	  <input id="detailed_photo3" onchange="return ValidateFileUpload('detailed_photo3')" name="detailed_photo3" multiple="multiple" type="file"/>-->
		   <div class="file-up">
					<input type="file"  onchange="return ValidateFileUpload('detailed_photo3')" name="detailed_photo3"  id="detailed_photo3" class="add-image inputfile inputfile-1" multiple="multiple" />
					<label for="detailed_photo3"> <span>Add Photo</span></label>
		   </div>
    </div> <!--gallery-box-->
    
  </div>
 </div> 
</div> <!---speaker-gallery--->
<div class="keynote-programs">

  <div class="container">
  
    <h2>keynote programs</h2>
      <div class="keynote-contnr">
<?php 
$GetTerms 		= $wpdb->get_results("SELECT sp_terms.term_id, sp_terms.name FROM sp_terms INNER JOIN sp_term_taxonomy ON sp_terms.term_id=sp_term_taxonomy.term_id WHERE sp_term_taxonomy.taxonomy='category' AND sp_terms.term_id!=1");

$GetSpeakerCatData 		= 	$wpdb->get_results("SELECT * FROM sp_speaker_primary_cat WHERE speaker_id ='$CurrentUserID'"); 
$primary_cat_id			=	$GetSpeakerCatData['0']->primary_cat_id; 

echo 'Select Primary Category: 		<select class="form-control" required name="primary_cat">';
foreach($GetTerms as $termData){
	$TermID			=	$termData->term_id;
	$TermName		=	$termData->name; ?>
	
		<option value="<?php echo $TermID; ?>" <?php if($TermID==$primary_cat_id){echo 'selected';} ?>><?php echo $TermName; ?></option>
<?php	}
echo '</select><div class="selct-catergories"><h4>Select Category: </h4><ul>';
$getCatCounter=0;
$other_catIDArray	=	array();
foreach($GetTerms as $GetCatData){
			$TermID			=	$GetCatData->term_id;
			$TermName		=	$GetCatData->name;
			$GetSpeakerCatData 		= 	$wpdb->get_results("SELECT other_cat FROM sp_speaker_primary_cat WHERE speaker_id ='$CurrentUserID' ORDER BY other_cat ASC"); 
		
			$other_catID			=	$GetSpeakerCatData[$getCatCounter]->other_cat; 
			array_push($other_catIDArray,$other_catID);
			/* echo "<pre>";
			print_r($other_catIDArray); */	
			?>
		<li class="daga"><input type="checkbox" <?php if (in_array($TermID, $other_catIDArray)){echo 'checked';} ?> class="single-checkbox" name="cat_name[]" value="<?php echo $TermID; ?>">  <?php echo $TermName; ?></li>
<?php $getCatCounter++; }
echo '</ul></div>';
?>  
<?php
	$counter=0;
	if(!empty($keynote_title)){
		foreach($keynote_title as $GetKeynoteTittle){
			if($GetKeynoteTittle!=''){
				$GetKeynoteTittle;
				$Getkeynote_description		=	$keynote_description[$counter];
				$Getkeynote_program1		=	$keynote_program1[$counter];
				$Getkeynote_program2		=	$keynote_program2[$counter];
				$Getkeynote_program3		=	$keynote_program3[$counter];
				$Getkeynote_program4		=	$keynote_program4[$counter];
				$Getkeynote_photo			=	$keynote_photo[$counter];
		?>
	<div class="keynote-box boder close_<?php echo $counter; ?>"> 
	<div class="keynote-box boder"> 
      <div class="img-gallery" id="keynote-holder">
	  <?php
	  if(isset($Getkeynote_photo)){
				$Getkeynote_photoUrl	=	$ImagePath.$Getkeynote_photo;
			}else{
				$Getkeynote_photoUrl	=  get_template_directory_uri()."/images/speaker-Profile-SetUp-pagepp.jpg";
			}
	  ?>
            <img src="<?php echo $Getkeynote_photoUrl; ?>" alt="....">
            <a class="add-more" href=""></a>
            <span class="add-photo" >Add a Thumbnail Image (300 x 300 pixels)
			</span>
             <div class="file-up">
					<input  id="keynote_photo_<?php echo $counter+1; ?>" required name="keynote_photo[]" class="add-image inputfile inputfile-<?php echo $counter+1; ?>" type="file"  />
					<label for="keynote_photo_<?php echo $counter+1; ?>"> <span></span></label>
		   </div>
          </div>
     <div class="keynote-content">
        <div class="overview-tittle-setup">
              <input type="text" name="keynote_title[]" value="<?php echo $GetKeynoteTittle; ?>" id="keynote_title" required placeholder="Title" class="form-control">
          </div>
          
		  
		  
         <div class="overview-tittle-setup">
              <textarea placeholder="Description" id="keynote_description" required name="keynote_description[]" class="form-control"><?php echo $Getkeynote_description; ?></textarea>
          </div> 
          <h3>Program Take-Aways</h3>
          <div class="overview-tittle-setup keynote-area">
              <input type="text"  name="keynote_program1[]"  value="<?php echo $Getkeynote_program1; ?>"  id="keynote_program1" required class="form-control">
          </div> 
          
          <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program2[]" value="<?php echo $Getkeynote_program2; ?>" class="form-control"> 
          </div> 
          
          <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program3[]" value="<?php echo $Getkeynote_program3; ?>" class="form-control"> 
          </div> 
          
           <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program4[]" value="<?php echo $Getkeynote_program4; ?>" class="form-control"> 
          </div> 
          
     </div> <!--keynote-content-->  
	  <a href="javascript:void(0)" class="remove_field keynote-area" divid='<?php echo $counter; ?>'>Delete</a>
    </div> <!---keynote-box close--->
  <?php if($counter==0){echo ' <a class="add-more-key-nodes" id="add-more-keynote" href="">Add More Keynote Programs</a>    ';} ?>
 </div><!--keynote-Edit-programs Close--> 	
		<?php } 	
		$counter++;
		} ?>
	<?php }else{ ?>

    <div class="keynote-box boder"> 
      <div class="img-gallery" id="keynote-holder">
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/speaker-Profile-SetUp-pagepp.jpg" alt="....">
            <a class="add-more" href=""></a>
            <span class="add-photo">Add a Thumbnail Image (300 x 300 pixels)
			</span><!--<input id="keynote_photo" required  name="keynote_photo[]" type="file"/>-->
            
            <div class="file-up">
					<input  id="keynote_photo" required  name="keynote_photo[]" class="add-image inputfile inputfile-1" type="file"  />
					<label for="keynote_photo"> <span></span></label>
		   </div>
          </div>
     <div class="keynote-content">
        <div class="overview-tittle-setup">
              <input type="text" name="keynote_title[]" id="keynote_title" required placeholder="Title" class="form-control"> 
          </div>
          
         <div class="overview-tittle-setup">
              <textarea placeholder="Description" id="keynote_description" required name="keynote_description[]" class="form-control"></textarea> 
          </div> 
          <h3>Program Take-Aways</h3>
          <div class="overview-tittle-setup keynote-area">
              <input type="text"  name="keynote_program1[]" id="keynote_program1" required class="form-control">
          </div> 
          
          <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program2[]" class="form-control"> 
          </div> 
          
          <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program3[]" class="form-control"> 
          </div> 
          
           <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program4[]" class="form-control"> 
          </div> 
          
     </div> <!--keynote-content-->  
    </div> <!---keynote-box close--->
  
    <a class="add-more-key-nodes" id="add-more-keynote" href="">Add More Keynote Programs</a>    
 <!--keynote-programs Close--> 
	<?php } ?>
    
    </div>
  </div>
</div>

<div class="testimonial-section">
  <div class="container">
   <div class="cd-testimonials-wrapper cd-container">
      <h2>Testimonials</h2>
<?php
$testinomialCounter=0;
	if(!empty($detailed_testimonial)){
		foreach($detailed_testimonial as $GetTestinomialTittle){
			if($GetTestinomialTittle !=''){
				$Getclient_name		=	$client_name[$testinomialCounter];
				$Getclient_img		=	$client_img[$testinomialCounter];
				if(isset($Getclient_img)){
					$Gettestinomial_photoUrl	=	$ImagePath.$Getclient_img;
				}else{
					$Gettestinomial_photoUrl	=  get_template_directory_uri()."/images/speaker-Profile-SetUp-pagepp.jpg";
				}
				?>
				 <div class="testimonial-set-up close_<?php echo $testinomialCounter; ?>">
        <div class="input-holder"> 
            <div class="boigraphy-icon"></div> 
             <textarea name="detailed_testimonial[]" required class="form-control" placeholder="Testimonial"><?php echo $GetTestinomialTittle; ?></textarea>
           </div>
          <div class="input-holder text-center"> 
		
               <input type="text" value='<?php echo $Getclient_name; ?>' required name="client_name[]"  class="form-control" placeholder="Client Name & Title"> 
          </div>  
	      <div class="client-pp" id="client_img_holder">
		
		  <img alt="testinomial image" src="<?php echo $Gettestinomial_photoUrl; ?>">
            <div class="file-up">
					<input  id="client_img_<?php echo $testinomialCounter+1; ?>" required name="client_img[]" class="add-image inputfile inputfile-1" type="file"  />
					<label for="client_img_<?php echo $testinomialCounter+1; ?>"> <span>Add Photo</span></label>
		   </div>
			 </div>
			 <span class="first_agreement"><input type="checkbox" required name="agreement[]" value="yes">I Agree</span>
		    <a href="javascript:void(0)" testimonialid="<?php echo $testinomialCounter; ?>" class="remove_field keynote-area">Delete</a>
     </div>
	  
			<?php } ?>
		<?php $testinomialCounter++;
		}
	}else{ ?>
	 <div class="testimonial-set-up">
        <div class="input-holder"> 
            <div class="boigraphy-icon"></div> 
             <textarea name="detailed_testimonial[]" required class="form-control" placeholder="Testimonial"></textarea>
           </div>
          <div class="input-holder text-center"> 
               <input type="text" name="client_name[]" required class="form-control" placeholder="Client Name & Title"> 
          </div>  
	      <div class="client-pp" id="client_img_holder">
           
			<!--<input id="client_img"  name="client_img[]" type="file"/>-->
               <div class="file-up">
					<input  id="client_img" name="client_img[]" class="add-image inputfile inputfile-1" type="file"  />
					<label for="client_img"> <span>Add Photo</span></label>
		   </div>
		</div>
			<span class="first_agreement"><input type="checkbox" required name="agreement[]" value="yes">I Agree</span>
     </div>
	 
	<?php } ?>
			

    </div> <!-- cd-testimonials-wrapper --> 
    
    <a class="add-more-key-testimonial" href="">Add More Testimonials</a>
     

 
  </div>
</div> <!--testimonial-section-->

<div class="container bott-section">
  <button type="submit" name="profile_submit" value='' class="btn btn-default btn-sunet">SAVE</button>
  <button type="button" class="btn btn-default btn-cancel">CANCEL</button>
  <div class="form-message" style="display:none;"></div> 
</div>  
<div class="loader" style="display:none;"></div>
</form>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script>

<script>
jQuery(document).ready(function() {
	
/**************** add more keynote**************/
	var max_fields      = '<?php echo $keynoteLimit;	?>'; //maximum input boxes allowed
    var wrapper         = $(".keynote-contnr"); //Fields wrapper
    var add_button      = $("#add-more-keynote"); //Add button ID
    
    var x = '<?php echo $counter-1;	?>'; //initlal text box count
    jQuery(add_button).click(function(e){ 

         e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
			jQuery.ajax({
            type: "POST",
            url: '<?php echo site_url(); ?>'+'/wp-content/themes/Speakersyndicate/keynote_program.php',
            data: {DivId : x},
            beforeSend: function(){
               // jQuery('#result').html('<img src="loading.gif" />');
            },
            success: function(data){
               
				//jQuery(data).insertAfter('div.keynote-box:last');     
				
				jQuery(wrapper).append(data);
				//alert(data);
            }
        });
            //jQuery(wrapper).append(); //add input box
        }else{
			var keyNoteAlert	=	'<?php echo $keyNoteAlert; ?>';
			if(keyNoteAlert==''){
				sweetAlert('', 'Please upgrade your package to add more Keynote Program.', 'error');
			}else{
				sweetAlert('', keyNoteAlert, 'error');
			}
			
		} 
    });
   
    jQuery(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        //e.preventDefault(); jQuery(this).parent('div').remove(); x--;
		
		var currentId		=	jQuery(this).attr('divid');
		var closeCls		=	'close_'+currentId+'';
		//alert(closeCls);
		jQuery('.'+closeCls+'').remove(); x--;
    })	

/**************** add more testinomial**************/
	var max_fields_test      = 5; //maximum input boxes allowed
    var wrapper_test         = $(".cd-container"); //Fields wrapper
    var add_button_test      = $(".add-more-key-testimonial"); //Add button ID
    
    var counter = '<?php echo $testinomialCounter; ?>'; //initlal text box count
    jQuery(add_button_test).click(function(e){ 

         e.preventDefault();
        if(counter < max_fields_test){ //max input box allowed
            counter++; //text box increment
			jQuery.ajax({
            type: "POST",
            url: '<?php echo site_url(); ?>'+'/wp-content/themes/Speakersyndicate/more_testnomial.php',
            data: {testimonialId : counter},
            beforeSend: function(){
               // jQuery('#result').html('<img src="loading.gif" />');
            },
            success: function(data){
               
				//jQuery(data).insertAfter('div.keynote-box:last');     
				
				jQuery(wrapper_test).append(data);
				//alert(data);
            }
        });
            //jQuery(wrapper).append(); //add input box
        } 
    });
    
    jQuery(wrapper_test).on("click",".remove_field", function(e){ //user click on remove text
	
       var currentId		=	jQuery(this).attr('testimonialId');
		var closeCls		=	'close_'+currentId+'';
		jQuery('.'+closeCls+'').remove(); counter--;
    })	
 
/****** submit form******/
    jQuery('.btn-sunet1').click(function(e){ 

         e.preventDefault();
		 //var formData = jQuery('#speaker-pro-setup').serialize();
		  var formData = new FormData(jQuery('#speaker-pro-setup')[0]);
   jQuery.ajax({
            type: "POST",
            url: '<?php echo site_url(); ?>'+'/wp-content/themes/Speakersyndicate/profile_setup_ajax.php',
            data:	formData,
			 async: false,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function(){
               // jQuery('#result').html('<img src="loading.gif" />');
            },
            success: function(data){
               jQuery(wrapper).append(data);
				//alert(data);
            }
        });
    }); 
  });

function ValidateFileUpload($inputId) {
var fuData = document.getElementById($inputId);
var FileUploadPath = fuData.value;
if (FileUploadPath == '') {
    
	sweetAlert('', 'Please upload an image.', 'error');

} else {
    var Extension = FileUploadPath.substring(FileUploadPath.lastIndexOf('.') + 1).toLowerCase();
	if (Extension == "gif" || Extension == "png" || Extension == "bmp"
                || Extension == "jpeg" || Extension == "jpg") {
		if (fuData.files && fuData.files[0]) {
			jQuery('.btn-sunet').removeAttr("disabled");
				var size = fuData.files[0].size;
				//alert(size);
				var MAX_SIZE	=	1500000;
                if(size > MAX_SIZE){
                  
					sweetAlert('Oops...', 'Maximum file size exceeds.', 'error');
                    return;
                }
            }
		} 
else {
		sweetAlert('Oops...', 'Photo only allows file types of GIF, PNG, JPG, JPEG and BMP.', 'error');
		jQuery('.btn-sunet').attr("disabled","disabled");
		return false;
    }
}}
/* var limit = 2;
jQuery('li.daga input.single-checkbox').on('change', function(evt) {
   if(jQuery(this).siblings(':checked').length >= limit) {
	   sweetAlert('Oops...', 'Please select only 2 category.', 'error');
	   this.checked = false;
   }
}); */
jQuery("input[name='cat_name[]']").change(function () {
        var maxAllowed = '<?php echo $CategoryLimit; ?>';
        var cnt = $("input[name='cat_name[]']:checked").length;
        if (cnt > maxAllowed) {
            jQuery(this).prop("checked", "");
            
			  sweetAlert('Oops...', 'Please select only ' + maxAllowed + ' category.', 'error');
        }
    });

jQuery('document').ready(function(){
	jQuery("#topic-keywords").keypress(function(e){
    var value = jQuery(this).val().replace(" ", "");
    var words = value.split(",");
    var wordLimit	=	'<?php echo $keywordLimit; ?>';
    if(words.length > wordLimit){
		
		sweetAlert('', 'Please upgrade your package to add more keywords.', 'error');
		e.preventDefault();
    }
});
});
</script>


<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/profile_setup.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/form.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>

<script>(function(e,t,n){var r=e.querySelectorAll("html")[0];r.className=r.className.replace(/(^|\s)no-js(\s|$)/,"$1js$2")})(document,window,0);</script>

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/fileinput.min.js" type="text/javascript"></script>


<?php get_footer(); ?>