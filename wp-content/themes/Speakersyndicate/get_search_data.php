<?php
/*  echo "<pre>";
print_r($_POST);
echo "</pre>"; die; */
function custom_echo($x, $length){
	  if(strlen($x)<=$length){
		echo $x;
	  }else{
		$y=substr($x,0,$length) . '...';
		echo $y;
	  }
} 
$parse_uri = explode( 'wp-content', $_SERVER['SCRIPT_FILENAME'] );
require_once( $parse_uri[0] . 'wp-load.php' );
$catID		=	$_POST['catID'];
$rangeID	=	$_POST['rangeID'];
$gender		=	$_POST['gender'];

$Query = "SELECT DISTINCT sp_search_attributes.speaker_id FROM sp_search_attributes INNER JOIN sp_speaker_primary_cat ON sp_search_attributes.speaker_id=sp_speaker_primary_cat.speaker_id WHERE sp_search_attributes.id!=''";
if($catID !=''){
	$Query .= "AND sp_speaker_primary_cat.primary_cat_id='$catID' OR sp_speaker_primary_cat.other_cat='$catID'";
}
if($rangeID !=''){
	$Query .= "AND sp_search_attributes.fee_range_id='$rangeID'";
}
if($gender !=''){
	$Query .= "AND sp_search_attributes.gender='$gender'";
}
$GetSearch 		= $wpdb->get_results($Query);

$ImagePath				=	site_url()."/wp-content/themes/Speakersyndicate/speaker_images/";
$noImg					=	'no_profile_img.gif';		  
if(!empty($GetSearch)){
	foreach($GetSearch as $GetSearchID){
		$speakerID 		=	$GetSearchID->speaker_id; 
		$GetSpeakerImg 		= $wpdb->get_results("SELECT user_img FROM sp_user_img WHERE user_id ='$speakerID'");
		$speakerImage		=	$GetSpeakerImg['0']->user_img;	
		if(isset($speakerImage)){
			$speakerImgUrl	=	$ImagePath.$speakerImage;
		}else{
			$speakerImgUrl	=	$ImagePath.$noImg;
		} 
	$prof_headline		=	get_user_meta( $speakerID, 'profile_headline', true);
	$user_info 			= 	get_userdata($speakerID);
	$profileDesc		=	$user_info->description;
?>

	<div class="search-display-section">
	<div id="content">
		<div class="search-result"> 
             <a class="profile-snap" href="#"><img src="<?php echo $speakerImgUrl; ?>" alt="..." /></a>
              
              <div class="speaker-short-description">
                <h4><?php echo $prof_headline; ?></h4>
                <p><?php custom_echo($profileDesc, 50); ?></p>
              </div>
              
              <div class="speaker-topics">
                <h4>Speakers Topics</h4>
                <p>Business Speaker <br>
Motivational Speaker <br>
Change Management Speaker</p> 
              </div>
              <div class="btn-section"> 
              <form id="requestNew" method="POST" action="<?php echo site_url(); ?>/speaker-profile/">
				<input type="hidden" name="speaker_id" value="<?php echo $speakerID; ?>">
				<button type="submit" name="profile_edit" value="" class="btn btn-default btn-sunet">View Profile</button>
			</form>
			   
              </div> 
           </div> </div> </div><!--search-result-->
<?php } }
else{
	echo "No result found.";
} ?>      
