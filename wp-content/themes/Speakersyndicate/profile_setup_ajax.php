<?php
//include('../../../wp-config.php');
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
/*  echo "<pre>";
print_r($_POST);
echo "</pre>"; */

/*  echo "<pre>";
print_r($_FILES);
echo "</pre>"; 

die;  */

global $wpdb;
$getPath	=	getcwd();
$path 		= $getPath."/speaker_images/"; 
$speakerID	=		$_POST['speakerID'];
if($speakerID==''){
	$email		=		$_POST['email'];
$exists = username_exists($email);
  if ( $exists ){
	echo '2';
	exit;
  }else{

$firstname					=		esc_html($_POST['firstname']);
$lastname					=		esc_html($_POST['lastname']);
$prof_headline				=		esc_html($_POST['prof_headline']);
$biography					=		esc_html($_POST['biography']);
$Getfee_range				=		$_POST['fee_range'];
$explodefee_range 			=		explode('@',$Getfee_range);
$fee_range					=		$explodefee_range[0];
$fee_range_id				=		$explodefee_range[1];
$phone						=		esc_html($_POST['phone']);
$website					=		$_POST['website'];
$embed_video1				=		$_POST['embed_video1'];
$embed_video2				=		$_POST['embed_video2'];
$detailed_biography			=		esc_html($_POST['detailed_biography']);
$gender						=		$_POST['gender'];
$primary_cat				=		$_POST['primary_cat'];
$cat_name					=		$_POST['cat_name'];
$topic_keywords				=		$_POST['topic_keywords'];
$agreement					=	serialize($_POST['agreement']);
$userdata = array(
	'user_login'  =>  	$email,
    'first_name'  =>  	$firstname,
    'last_name'    =>  $lastname,
    'user_email'   =>  $email,
	'description'  => 	$biography,
    'user_url'    =>  $website,
	'user_pass'   =>  NULL	
);
$user_id = wp_insert_user($userdata) ;
if (is_wp_error( $user_id ) ) {
    $user_id='';			
}
 update_user_meta( $user_id, 'profile_headline', $prof_headline);
 update_user_meta( $user_id, 'fee_range', $fee_range);
 update_user_meta( $user_id, 'speaker_phone', $phone);
 update_user_meta( $user_id, 'embed_video1', $embed_video1);
 update_user_meta( $user_id, 'embed_video2', $embed_video2);
 update_user_meta( $user_id, 'detailed_biography', $detailed_biography);
 update_user_meta( $user_id, 'first_agreement', $agreement);
 update_user_meta( $user_id, 'speaker_website', $website);
 update_user_meta( $user_id, 'activity_status', 0); 
 update_user_meta( $user_id, 'gender', $gender);  
 update_user_meta( $user_id, 'topic_keywords', $topic_keywords);
// Array varaibles
$esc_keynote_title			=		$_POST['keynote_title'];
$esc_keynote_desc			=		$_POST['keynote_description'];
$esc_keynote_p1				=		$_POST['keynote_program1'];
$esc_keynote_p2				=		$_POST['keynote_program2'];
$esc_keynote_p3				=		$_POST['keynote_program3'];
$esc_keynote_p4				=		$_POST['keynote_program4'];
$esc_detailes_tes			=		$_POST['detailed_testimonial'];
$esc_clientname				=		$_POST['client_name'];
$keynote_title				=	serialize($esc_keynote_title);
$keynote_description		=	serialize($esc_keynote_desc);
$keynote_program1			=	serialize($esc_keynote_p1);
$keynote_program2			=	serialize($esc_keynote_p2);
$keynote_program3			=	serialize($esc_keynote_p3);
$keynote_program4			=	serialize($esc_keynote_p4);
$detailed_testimonial		=	serialize($esc_detailes_tes);
$client_name				=	serialize($esc_clientname);

$wpdb->insert('sp_keynote_programs', array(
    'user_id' => $user_id,
    'keynote_title' => $keynote_title,
    'keynote_description' => $keynote_description,
	'keynote_program1' => $keynote_program1,
    'keynote_program2' => $keynote_program2,
    'keynote_program3' => $keynote_program3,
	'keynote_program4' => $keynote_program4
   ));
 $postTitle	=	$firstname." ".$lastname;
$my_post = array(
	'post_author' => $user_id,
    'post_title' => $postTitle,
    'post_content' => 'Speaker Profile.',
    'post_status' => 'publish',
    'post_type' => 'post'
);
$the_post_id = wp_insert_post( $my_post );	
 update_user_meta( $user_id, 'urlID', $the_post_id);	
 $wpdb->insert('sp_testimonials', array(
    'user_id' => $user_id,
    'detailed_testimonial' => $detailed_testimonial,
    'client_name' => $client_name
 ));
 foreach($cat_name as $catID){
		 $wpdb->insert('sp_speaker_primary_cat', array(
		'speaker_id' => $user_id,
		'primary_cat_id' => $primary_cat,
		'other_cat' => $catID
	 ));  
 }
 $wpdb->insert('sp_search_attributes', array(
		'speaker_id' => $user_id,
		'fee_range_id' => $fee_range_id,
		'fee_range_val' => $fee_range,
		'gender' => $gender,
		'topic_keywords' => $topic_keywords,
		'profile_headline' => $profile_headline
	 ));  
// File varaibles
$user_img_name 				= 	$_FILES['user_img']['name'];
$user_img_size 				= 	$_FILES['user_img']['size'];

$detailed_photo1_name 		= 	$_FILES['detailed_photo1']['name'];
$detailed_photo1_size 		= 	$_FILES['detailed_photo1']['size'];

$detailed_photo2_name 		= 	$_FILES['detailed_photo2']['name'];
$detailed_photo2_size 		= 	$_FILES['detailed_photo2']['size'];

$detailed_photo3_name 		= 	$_FILES['detailed_photo3']['name'];
$detailed_photo3_size 		= 	$_FILES['detailed_photo3']['size'];

$keynote_photo_count 		= 	count($_FILES['keynote_photo']['name']);
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");

if(strlen($user_img_name)){

		list($txt, $ext) = explode(".", $user_img_name);
		if(in_array($ext,$valid_formats))
		{
			if($user_img_size<(10024*10024))
				{
					$actual_image_name = $txt."_".$user_id.".".$ext;
					$tmp = $_FILES['user_img']['tmp_name'];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							 $wpdb->insert('sp_user_img', array(
									'user_id' => $user_id,
									'user_img' => $actual_image_name
								 ));	
						}
				}
			}
		}
		
if(strlen($detailed_photo1_name)){
	list($txt, $ext) = explode(".", $detailed_photo1_name);
	if(in_array($ext,$valid_formats)){
		if($detailed_photo1_size<(10024*10024))
			{
				$actual_image_name = $txt."_".$user_id.".".$ext;
				$tmp = $_FILES['detailed_photo1']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$actual_image_name))
					{
						$wpdb->query("UPDATE sp_user_img SET detailed_photo1 = '$actual_image_name' WHERE user_id = '$user_id'");
					}
			}
		}
	}

if(strlen($detailed_photo2_name)){
	list($txt, $ext) = explode(".", $detailed_photo2_name);
	if(in_array($ext,$valid_formats)){
			if($detailed_photo2_size<(10024*10024)){
					$actual_image_name = $txt."_".$user_id.".".$ext;
					$tmp = $_FILES['detailed_photo2']['tmp_name'];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							$wpdb->query("UPDATE sp_user_img SET detailed_photo2 = '$actual_image_name' WHERE user_id = '$user_id'");
						}
				}
		}
	}
	
	if(strlen($detailed_photo3_name)){
	list($txt, $ext) = explode(".", $detailed_photo3_name);
	if(in_array($ext,$valid_formats)){
	if($detailed_photo3_size<(10024*10024)){
			$actual_image_name = $txt."_".$user_id.".".$ext;
			$tmp = $_FILES['detailed_photo3']['tmp_name'];
			if(move_uploaded_file($tmp, $path.$actual_image_name))
				{
					$wpdb->query("UPDATE sp_user_img SET detailed_photo3 = '$actual_image_name' WHERE user_id = '$user_id'");
				}
			}
		}
}
$keynotPhotoArr	=	array();	
for($i=0; $i<$keynote_photo_count; $i++){
	$keynote_photo_name 	=	$_FILES['keynote_photo']['name'][$i]; 
	$keynote_photo_size 	=	$_FILES['keynote_photo']['size'][$i]; 
	if(strlen($keynote_photo_name)){
		list($txt, $ext) = explode(".", $keynote_photo_name);
		if(in_array($ext,$valid_formats)){
			if($keynote_photo_size<(100024*100024))
				{
					$actual_image_name = $txt."_".$user_id.".".$ext;
					$tmp = $_FILES['keynote_photo']['tmp_name'][$i];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							array_push($keynotPhotoArr, $actual_image_name);
						}
					
				}
		}
	}
}
$keynotPhotoSerlize		=	serialize($keynotPhotoArr);
$wpdb->query("UPDATE sp_keynote_programs SET keynote_photo = '$keynotPhotoSerlize' WHERE user_id = '$user_id'");

$clientImgArr	=	array();
$client_img_count 				= 	count($_FILES['client_img']['name']);
for($k=0; $i<$client_img_count; $k++){
	$client_img_name 	=	$_FILES['client_img']['name'][$k]; 
	$client_img_size 	=	$_FILES['client_img']['size'][$k]; 
	if(strlen($client_img_name)){
		list($txt, $ext) = explode(".", $client_img_name);
		if(in_array($ext,$valid_formats)){
			if($client_img_size<(10024*10024)){
					$actual_image_name = $txt."_".$user_id.".".$ext;
					$tmp = $_FILES['client_img']['tmp_name'][$k];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							array_push($clientImgArr, $actual_image_name);
						}
				}
			}
	}
}
$clientImgArrSerlize		=	serialize($clientImgArr);
$wpdb->query("UPDATE sp_testimonials SET client_img = '$clientImgArrSerlize' WHERE user_id = '$user_id'");
		
	$encodeId		=	base64_encode($user_id);
	$admin_email	=	get_option( 'admin_email', $default );
	$HomeUrl		=	site_url();
	$UrlLink		=	$HomeUrl."/approve-speaker/?id=".$encodeId;		
	$subject = 'New Speaker register';
	$body = '<h2>New Speaker has been registered. Please approve registeration and send their username and password. </h2></br></br><p>Please click on this <a href="'.$UrlLink.'">link  </a> to complete their registration.</p>';
	$headers = array('Content-Type: text/html; charset=UTF-8');
	 
	if(wp_mail( $admin_email, $subject, $body, $headers )){
			echo '1';
		}else{
			//echo '2';
		}	

			exit;
}
}else{
	
$email						=		$_POST['email'];
$firstname					=		esc_html($_POST['firstname']);
$lastname					=		esc_html($_POST['lastname']);
$prof_headline				=		esc_html($_POST['prof_headline']);
$biography					=		esc_html($_POST['biography']);
$Getfee_range				=		$_POST['fee_range'];
$explodefee_range 			=		explode('@',$Getfee_range);
$fee_range					=		$explodefee_range[0];
$fee_range_id				=		$explodefee_range[1];
$phone						=		esc_html($_POST['phone']);
$website					=		$_POST['website'];
$embed_video1				=		$_POST['embed_video1'];
$embed_video2				=		$_POST['embed_video2'];
$detailed_biography			=		esc_html($_POST['detailed_biography']);
$agreement					=	serialize($_POST['agreement']);
$primary_cat				=		$_POST['primary_cat'];
$cat_name					=		$_POST['cat_name'];
$gender						=		$_POST['gender'];
$topic_keywords				=		$_POST['topic_keywords'];
$userdata = array(
	'ID'  =>  	$speakerID,
	'user_login'  =>  	$email,
    'first_name'  =>  	$firstname,
    'last_name'    =>  $lastname,
    'user_email'   =>  $email,
	'description'  => 	$biography,
    'user_url'    =>  $website
	
);
 wp_update_user($userdata) ;

 update_user_meta( $speakerID, 'profile_headline', $prof_headline);
 update_user_meta( $speakerID, 'fee_range', $fee_range);
 update_user_meta( $speakerID, 'speaker_phone', $phone);
 update_user_meta( $speakerID, 'embed_video1', $embed_video1);
 update_user_meta( $speakerID, 'embed_video2', $embed_video2);
 update_user_meta( $speakerID, 'detailed_biography', $detailed_biography);
 update_user_meta( $speakerID, 'first_agreement', $agreement);
update_user_meta( $speakerID, 'speaker_website', $website);
update_user_meta( $speakerID, 'gender', $gender);
update_user_meta( $speakerID, 'topic_keywords', $topic_keywords);
// Array varaibles
$esc_keynote_title			=		$_POST['keynote_title'];
$esc_keynote_desc			=		$_POST['keynote_description'];
$esc_keynote_p1				=		$_POST['keynote_program1'];
$esc_keynote_p2				=		$_POST['keynote_program2'];
$esc_keynote_p3				=		$_POST['keynote_program3'];
$esc_keynote_p4				=		$_POST['keynote_program4'];
$esc_detailes_tes			=		$_POST['detailed_testimonial'];
$esc_clientname				=		$_POST['client_name'];
$keynote_title				=	serialize($esc_keynote_title);
$keynote_description		=	serialize($esc_keynote_desc);
$keynote_program1			=	serialize($esc_keynote_p1);
$keynote_program2			=	serialize($esc_keynote_p2);
$keynote_program3			=	serialize($esc_keynote_p3);
$keynote_program4			=	serialize($esc_keynote_p4);
$detailed_testimonial		=	serialize($esc_detailes_tes);
$client_name				=	serialize($esc_clientname);
$wpdb->query("UPDATE sp_keynote_programs SET keynote_title = '$keynote_title', keynote_description = '$keynote_description',
keynote_program1 = '$keynote_program1', keynote_program2 = '$keynote_program2', keynote_program3 = '$keynote_program3',  keynote_program4 = '$keynote_program4' WHERE user_id = '$speakerID'");

$wpdb->query("UPDATE sp_testimonials SET detailed_testimonial = '$detailed_testimonial', client_name = '$client_name' WHERE user_id = '$speakerID'");

$wpdb->query("UPDATE sp_search_attributes SET fee_range_id = '$fee_range_id', fee_range_val = '$fee_range', gender='$gender', topic_keywords = '$topic_keywords', profile_headline = '$prof_headline' WHERE speaker_id = '$speakerID'");

 $wpdb->query("DELETE FROM sp_speaker_primary_cat WHERE speaker_id = '$speakerID'");
 if(!empty($cat_name)){
	  foreach($cat_name as $catID){
		 $wpdb->insert('sp_speaker_primary_cat', array(
		'speaker_id' => $speakerID,
		'primary_cat_id' => $primary_cat,
		'other_cat' => $catID
	 ));  
 }	
 }

// File varaibles
$user_img_name 				= 	$_FILES['user_img']['name'];
$user_img_size 				= 	$_FILES['user_img']['size'];

$detailed_photo1_name 		= 	$_FILES['detailed_photo1']['name'];
$detailed_photo1_size 		= 	$_FILES['detailed_photo1']['size'];

$detailed_photo2_name 		= 	$_FILES['detailed_photo2']['name'];
$detailed_photo2_size 		= 	$_FILES['detailed_photo2']['size'];

$detailed_photo3_name 		= 	$_FILES['detailed_photo3']['name'];
$detailed_photo3_size 		= 	$_FILES['detailed_photo3']['size'];

$keynote_photo_count 		= 	count($_FILES['keynote_photo']['name']);
$valid_formats = array("jpg", "png", "gif", "bmp", "jpeg");
$wpdb->get_results( 'SELECT COUNT(*) FROM sp_user_img' );
$getUserImg 	=	$wpdb->num_rows; 
if($getUserImg==''){
	$wpdb->insert('sp_user_img', array('user_id' => $speakerID ));	
}	
if(strlen($user_img_name)){
		
		list($txt, $ext) = explode(".", $user_img_name);
		if(in_array($ext,$valid_formats))
		{
			if($user_img_size<(10024*10024))
				{
					$actual_image_name = $txt."_".$speakerID.".".$ext;
					$tmp = $_FILES['user_img']['tmp_name'];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							$wpdb->query("UPDATE sp_user_img SET user_img = '$actual_image_name' WHERE user_id = '$speakerID'");
							
						}
				}
			}
		}
		
if(strlen($detailed_photo1_name)){
	list($txt, $ext) = explode(".", $detailed_photo1_name);
	if(in_array($ext,$valid_formats)){
		if($detailed_photo1_size<(10024*10024))
			{
				$actual_image_name = $txt."_".$speakerID.".".$ext;
				$tmp = $_FILES['detailed_photo1']['tmp_name'];
				if(move_uploaded_file($tmp, $path.$actual_image_name))
					{
						$wpdb->query("UPDATE sp_user_img SET detailed_photo1 = '$actual_image_name' WHERE user_id = '$speakerID'");
					}
			}
		}
	}

if(strlen($detailed_photo2_name)){
	list($txt, $ext) = explode(".", $detailed_photo2_name);
	if(in_array($ext,$valid_formats)){
			if($detailed_photo2_size<(10024*10024)){
					$actual_image_name = $txt."_".$speakerID.".".$ext;
					$tmp = $_FILES['detailed_photo2']['tmp_name'];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							$wpdb->query("UPDATE sp_user_img SET detailed_photo2 = '$actual_image_name' WHERE user_id = '$speakerID'");
						}
				}
		}
	}
	
	if(strlen($detailed_photo3_name)){
	list($txt, $ext) = explode(".", $detailed_photo3_name);
	if(in_array($ext,$valid_formats)){
	if($detailed_photo3_size<(10024*10024)){
			$actual_image_name = $txt."_".$speakerID.".".$ext;
			$tmp = $_FILES['detailed_photo3']['tmp_name'];
			if(move_uploaded_file($tmp, $path.$actual_image_name))
				{
					$wpdb->query("UPDATE sp_user_img SET detailed_photo3 = '$actual_image_name' WHERE user_id = '$speakerID'");
				}
			}
		}
}
if($keynote_photo_count!=0){
$keynotPhotoArr	=	array();	
for($i=0; $i<$keynote_photo_count; $i++){
	$keynote_photo_name 	=	$_FILES['keynote_photo']['name'][$i]; 
	$keynote_photo_size 	=	$_FILES['keynote_photo']['size'][$i]; 
	if(strlen($keynote_photo_name)){
		list($txt, $ext) = explode(".", $keynote_photo_name);
		if(in_array($ext,$valid_formats)){
			if($keynote_photo_size<(100024*100024))
				{
					$actual_image_name = $txt."_".$speakerID.".".$ext;
					$tmp = $_FILES['keynote_photo']['tmp_name'][$i];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							array_push($keynotPhotoArr, $actual_image_name);
						}
					
				}
		}
	}
}


$keynotPhotoSerlize		=	serialize($keynotPhotoArr);
$wpdb->query("UPDATE sp_keynote_programs SET keynote_photo = '$keynotPhotoSerlize' WHERE user_id = '$speakerID'");
}
$clientImgArr	=	array();
$client_img_count 				= 	count($_FILES['client_img']['name']);
if($client_img_count !=0){
for($k=0; $k<$client_img_count; $k++){
	$client_img_name 	=	$_FILES['client_img']['name'][$k]; 
	$client_img_size 	=	$_FILES['client_img']['size'][$k]; 
	if(strlen($client_img_name)){
		list($txt, $ext) = explode(".", $client_img_name);
		if(in_array($ext,$valid_formats)){
			if($client_img_size<(10024*10024)){
					$actual_image_name = $txt."_".$speakerID.".".$ext;
					$tmp = $_FILES['client_img']['tmp_name'][$k];
					if(move_uploaded_file($tmp, $path.$actual_image_name))
						{
							array_push($clientImgArr, $actual_image_name);
						}
				}
			}
	}
}
$clientImgArrSerlize		=	serialize($clientImgArr);

$wpdb->query("UPDATE sp_testimonials SET client_img = '$clientImgArrSerlize' WHERE user_id = '$speakerID'");
}
echo '4';
unset($_SESSION['speaker_id']);	 
exit;
}

?>