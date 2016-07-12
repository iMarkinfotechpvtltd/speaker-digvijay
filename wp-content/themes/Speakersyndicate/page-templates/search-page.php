<?php
/*
 Template Name: Search Template
 */
?>
<?php get_header();

$GetcatID		=	$_GET['cats'];
$GetrangeID		=	$_GET['range'];
$Getgender		=	$_GET['gender'];
//echo "<pre>";  print_r($_POST);  echo "</pre>";
$serachKeyword	=	$_POST['serachKeyword'];
function custom_echo($x, $length){
	  if(strlen($x)<=$length){
		echo $x;
	  }else{
		$y=substr($x,0,$length) . '...';
		echo $y;
	  }
} 
if($GetcatID!='' || $GetrangeID!='' || $Getgender!=''){
	$Query = "SELECT DISTINCT sp_search_attributes.speaker_id FROM sp_search_attributes INNER JOIN sp_speaker_primary_cat ON sp_search_attributes.speaker_id=sp_speaker_primary_cat.speaker_id WHERE sp_search_attributes.id!='' AND sp_search_attributes.profile_status='Active'";
		if($GetcatID !=''){
			$explodeCatId	=	explode(',', $GetcatID);
			foreach($explodeCatId as $searchCatID){
				if($searchCatID!=''){
					$Query .= " AND (sp_speaker_primary_cat.primary_cat_id = '$searchCatID' OR sp_speaker_primary_cat.other_cat = '$searchCatID')";
				}
			}			
			
		}
		if($GetrangeID !=''){
			$Query .= " AND sp_search_attributes.fee_range_id='$GetrangeID'";
		}
		if($Getgender !=''){
			$Query .= " AND sp_search_attributes.gender='$Getgender'";
		}
		//echo $Query;
		$GetSearch 		= $wpdb->get_results($Query);
}else{
	
	$flag	=	'"';
	if($serachKeyword!=''){
	
		$GetSearch 		= $wpdb->get_results("SELECT DISTINCT sp_users.ID FROM sp_users INNER JOIN sp_search_attributes ON sp_users.ID=sp_search_attributes.speaker_id WHERE sp_search_attributes.topic_keywords LIKE '%$serachKeyword%' OR (sp_search_attributes.profile_headline LIKE '%$serachKeyword%') AND sp_search_attributes.profile_status='Active'");	
		
	}else{
	if(empty($_POST)){
		$GetSearch 		= $wpdb->get_results("SELECT DISTINCT sp_users.ID FROM sp_users INNER JOIN sp_speaker_primary_cat ON sp_users.ID=sp_speaker_primary_cat.speaker_id INNER JOIN sp_search_attributes ON sp_users.ID=sp_search_attributes.speaker_id WHERE sp_search_attributes.profile_status='Active'");	
	}else{
		$Category			=		$_POST['Category'];
		$keywords			=		$_POST['keywords'];
		$gender				=		$_POST['gender'];
		$fee_range_filter	=		$_POST['fee_range_filter'];
		$HomeQuery	=	"SELECT DISTINCT sp_users.ID FROM sp_users INNER JOIN sp_speaker_primary_cat ON sp_users.ID=sp_speaker_primary_cat.speaker_id INNER JOIN sp_search_attributes ON sp_users.ID=sp_search_attributes.speaker_id WHERE sp_search_attributes.profile_status='Active'";
		//(sp_speaker_primary_cat.primary_cat_id='$Category' OR sp_speaker_primary_cat.other_cat='$Category')
		if(!empty($Category)){
			foreach($Category as $PostCatID){
				if($PostCatID != 'all'){
					$HomeQuery .= " AND (sp_speaker_primary_cat.primary_cat_id = '$PostCatID' OR sp_speaker_primary_cat.other_cat = '$PostCatID')";
				}
				
			}
		}
		if($keywords !=''){
			$HomeQuery .= " AND sp_search_attributes.topic_keywords LIKE '%$keywords%'";
		}if($gender !=''){
			$HomeQuery .= " AND sp_search_attributes.gender='$gender'";
		}if($fee_range_filter !=''){
			$HomeQuery .= " AND sp_search_attributes.fee_range_id='$fee_range_filter'";
		}
		//echo $HomeQuery;
		$GetSearch 		= $wpdb->get_results($HomeQuery);	
	}
	if(!empty($GetSearch)){
		foreach($GetSearch as $GetSearchID){
			$speakerID 		=	$GetSearchID->ID; 
		}
	}
}
}	
  
?>
<div class="search-page-banner">
  <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/speaker-search-bannerf.jpg" alt="..." />
  <div class="search-caption"> 
    <div class="container">
      <h3>Use the search filters below to find the perfect keynote speaker for your upcoming event. Please contact us with any questions or suggestions you may have.</h3>
    </div>
  </div> <!---search-caption--->
</div> <!---search-page-banner Close--->


<div class="search-result-section">
   <div class="container">
      <div class="row">
       <div class="col-xs-12 col-md-3"> 
         <h3>search speakers</h3>
        <div class="search-filter"> 
          <a id="cat-toggle" href="javascript:void(0)"><h4>Categories</h4> </a>
          <?php if(isset($GetcatID)){
			 echo '<ul id="cat-toggle-cls">'; 
		  }else{
			 echo '<ul id="cat-toggle-cls" style="display:none;">';  
		  } ?>
          
			<?php
			$GetTerms 		= $wpdb->get_results("SELECT sp_terms.term_id, sp_terms.name FROM sp_terms INNER JOIN sp_term_taxonomy ON sp_terms.term_id=sp_term_taxonomy.term_id WHERE sp_term_taxonomy.taxonomy='category' AND sp_terms.term_id!=1");
					foreach($GetTerms as $termData){
					$TermID			=	$termData->term_id;
					$TermName		=	$termData->name;
				?>
				
             <li><a class="catsrch_url" href='javascript:void(0)'><label><input type="checkbox" class="cat-btn" name="catName[]" value="<?php echo $TermID; ?>" <?php if(preg_match('/(^|,)'.$TermID.'($|,)/', $GetcatID)){ echo "checked"; } ?>> <?php echo $TermName; ?></label></a></li>
          <?php } ?>
       
          </ul>
          
        </div> <!--search-filter-->
        
         <div class="search-filter"> 
          <h4>Fee Range (US)</h4>
          
          <ul>
             <li><a class="rangesrch_url" href='javascript:void(0)'><label><input type="radio" name="range-btn" class="range-btn" value="1" <?php if($GetrangeID==1){ echo "checked"; } ?>>$5,000 to $7,500</label></a></li>
             <li><a class="rangesrch_url" href='javascript:void(0)'><label><input type="radio" name="range-btn" class="range-btn" value="2" <?php if($GetrangeID==2){ echo "checked"; } ?>>$7,500 to $15,000</label></a></li>
             <li><a class="rangesrch_url" href='javascript:void(0)'><label><input type="radio" name="range-btn" class="range-btn" value="3" <?php if($GetrangeID==3){ echo "checked"; } ?>>$15,000 to $25,000</label></a></li>
          </ul>
          
        </div> <!--search-filter-->
        
        <div class="search-filter"> 
          <h4>Gender</h4>
          
          <ul>
             <li><a class="gendersrch_url" href='javascript:void(0)'><label><input type="radio" name="gender-btn" class="gender-btn" value="male" <?php if($Getgender=='male'){ echo "checked"; } ?>>Male</label></a></li>
             <li><a class="gendersrch_url" href='javascript:void(0)'><label><input type="radio" name="gender-btn" class="gender-btn" value="female" <?php if($Getgender=='female'){ echo "checked"; } ?>>Female</label></a></li>
          </ul>
          
        </div> <!--search-filter-->
        
         <div class="search-filter"> 
           <h4>Keywords</h4>
          <div class="search-box"> 
			<form action="" method="POST" id="keywordform">
				<input type="text" id="serachKeyword" name="serachKeyword" class="form-control" placeholder="keywords">   
			</form>			
          </div> <!--search-box-->
         </div> <!--search-filter-->
         
       </div> <!--col-xs-12 col-md-3-->
       <div class="col-xs-12 col-md-9"> 
        <div class="serach-wrap">
           
          <div class="pagination-container"> 
          <div class="seacrch-top"> 
           <!--<input type="text" class="form-control" placeholder="Search Speaker by Name"> -->
           <!--<ul class="key-words">
             <li>male</li>
             <li>Arts and Pop Culture</li>
             <li>Authors</li>
             <li>College and Student Issues</li>
           </ul>-->
         </div> 
          
          </div> 
         </div>  <!---serach-wrap-->
         <div class="loader-cls" style="display:none"> <img src="<?php echo site_url(); ?>/wp-content/themes/Speakersyndicate/images/loader.gif" /></div>
		 <input type='hidden' id='current_page' />
		<input type='hidden' id='show_per_page' />
		
		   <div class="append-serch-data">
		  
         <div class="search-display-section">
		   <div id="content">
           
<?php
$ImagePath				=	site_url()."/wp-content/themes/Speakersyndicate/speaker_images/";
$noImg					=	'no_profile_img.gif';		  
if(!empty($GetSearch)){
	foreach($GetSearch as $GetSearchID){
		$speakerID 		=	$GetSearchID->ID;  
		if($speakerID==''){
			$speakerID 		=	$GetSearchID->speaker_id;
		}
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
	$topic_keywords		=	get_user_meta( $speakerID, 'topic_keywords', true);
?>
		<div class="search-result"> 
		<?php 
				$urlID		=	get_user_meta( $speakerID, 'urlID', true);
				$urlData 	= 	get_post($urlID);
				$profileUrl	=	$urlData->guid;
		?>
             <a class="profile-snap view-speaker-prf"  href="<?php echo $profileUrl; ?>"><img src="<?php echo $speakerImgUrl; ?>" alt="..." /></a>
              
              <div class="speaker-short-description">
                <h4><?php echo $prof_headline; ?></h4>
                <p><?php custom_echo($profileDesc, 50); ?></p>
              </div>
              
              <div class="speaker-topics">
                <h4>Speakers Topics</h4>
                <p><?php echo $topic_keywords; ?></p> 
              </div>
              <div class="btn-section"> 
              <a href="<?php echo $profileUrl; ?>">
				<button type="submit" name="profile_edit" value="" class="btn btn-default btn-sunet">View Profile</button>
			</a>
			   
              </div> 
           </div> <!--search-result-->
<?php } }else{
	echo 'No result Found.';
} ?>      
  
                         
          </div> </div> </div><!--search-display-section-->
        
          
         <div class="pagination-container mk00"> 
           <a class="bak-link" href="<?php echo site_url(); ?>">Back To Home</a>
            
			 <div class='page_navigation'></div>
            
          </div>
       </div> <!--col-xs-12 col-md-3-->
       

       
      </div> <!--row close-->
   </div> <!--container-->
</div> <!---search-result-section---->
<script type="text/javascript" src="<?php echo site_url(); ?>/wp-content/themes/Speakersyndicate/js/jquery.js"></script>
<script>

   
function getParameterByName(name, url) {
    if (!url) url = window.location.href;
    name = name.replace(/[\[\]]/g, "\\$&");
    var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
        results = regex.exec(url);
    if (!results) return false;
    if (!results[2]) return '';
    return decodeURIComponent(results[2].replace(/\+/g, " "));
}

jQuery(document).ready(function(){
  jQuery(".cat-btn").click(function(){
	  
	  if(jQuery("input[class=cat-btn]").is(':checked')){
			var catID	=	jQuery(this).val();
	  }else{
		  var catID	=	'';
	  }
	var url      = window.location.href;
	var catids = getParameterByName('cats'); 
	
	var rangeID	='';
	var gender	='';
	
	if(jQuery("input[class=range-btn]").is(':checked')){
		var rangeID	= jQuery("input[class=range-btn]:checked").val();
		
	}
	if(jQuery("input[class=gender-btn]").is(':checked')){
		var gender	= jQuery("input[class=gender-btn]:checked").val();
	}
	
if(catID !='' && catids==''){
	
	var changeCatUrl	= '<?php echo site_url(); ?>'+'/search/?cats='+catID+'&range='+rangeID+'&gender='+gender+'';
	window.location.href=changeCatUrl;
}else if(catID !='' && catids!=''){
	
	var catParam	=	'';
	if(catids.indexOf(catID) != -1){
		var catParam1 		= catids.replace(catID, '');
		var catParam 		= catParam1.replace(/(^,)|(,$)/g, "");
		//alert(catParam + "==" + catids);
	}else{
		
		var catParam2	=	catids+','+catID;	
		var catParam 		= catParam2.replace(/(^,)|(,$)/g, "");
		//alert(catParam);
	}
	var changeCatUrl	= '<?php echo site_url(); ?>'+'/search/?cats='+catParam+'&range='+rangeID+'&gender='+gender+'';
	window.location.href=changeCatUrl;
	}
});
    jQuery(".range-btn").click(function(){
	var rangeID	=	jQuery(this).val();
	var catID	='';
	var gender	='';
	if(jQuery("input[class=cat-btn]").is(':checked')){
		//var catID	= jQuery("input[class=cat-btn]:checked").val();
		var catID = getParameterByName('cats');
	}
	if(jQuery("input[class=gender-btn]").is(':checked')){
		var gender	= jQuery("input[class=gender-btn]:checked").val();
	}
	
	var changeRangeUrl	= '<?php echo site_url(); ?>'+'/search/?cats='+catID+'&range='+rangeID+'&gender='+gender+'';
	window.location.href=	changeRangeUrl;
	 
  });	
   jQuery(".gender-btn").click(function(){
	var gender	=	jQuery(this).val();
	var catID	='';
	var rangeID	='';
	if(jQuery("input[class=cat-btn]").is(':checked')){
		var catID = getParameterByName('cats');
	}
	if(jQuery("input[class=range-btn]").is(':checked')){
		var rangeID	= jQuery("input[class=range-btn]:checked").val();
	}
		var changeGenderUrl	= '<?php echo site_url(); ?>'+'/search/?cats='+catID+'&range='+rangeID+'&gender='+gender+'';
		window.location.href=	changeGenderUrl;
  });
   jQuery("#cat-toggle").click(function(){
        $("#cat-toggle-cls").toggle();
    });
});

</script>
<script type="text/javascript">
$(document).ready(function(){
	jQuery('#serachKeyword').blur(function() { 
    jQuery('#keywordform').submit();
	
});  

	//how much items per page to show
	var show_per_page = 1; 
	//getting the amount of elements inside content div
	var number_of_items = $('#content').children().size();
	//calculate the number of pages we are going to have
	var number_of_pages = Math.ceil(number_of_items/show_per_page);
	
	//set the value of our hidden input fields
	$('#current_page').val(0);
	$('#show_per_page').val(show_per_page);
	
	//now when we got all we need for the navigation let's make it '
	
	/* 
	what are we going to have in the navigation?
		- link to previous page
		- links to specific pages
		- link to next page
	*/
	var navigation_html = '<a class="previous_link" href="javascript:previous();">Prev</a>';
	var current_link = 0;
	while(number_of_pages > current_link){
		navigation_html += '<a class="page_link" href="javascript:go_to_page(' + current_link +')" longdesc="' + current_link +'">'+ (current_link + 1) +'</a>';
		current_link++;
	}
	navigation_html += '<a class="next_link" href="javascript:next();">Next</a>';
	
	$('.page_navigation').html(navigation_html);
	
	//add active_page class to the first page link
	$('.page_navigation .page_link:first').addClass('active_page');
	
	//hide all the elements inside content div
	$('#content').children().css('display', 'none');
	
	//and show the first n (show_per_page) elements
	$('#content').children().slice(0, show_per_page).css('display', 'block');
	jQuery(".view-speaker-prf").click(function() {
		var formId	=	jQuery(this).attr('pid');
		jQuery( '#requestprofile_'+formId+'' ).submit();
});
});

function previous(){
	
	new_page = parseInt($('#current_page').val()) - 1;
	//if there is an item before the current active link run the function
	if($('.active_page').prev('.page_link').length==true){
		go_to_page(new_page);
	}
	
}

function next(){
	new_page = parseInt($('#current_page').val()) + 1;
	//if there is an item after the current active link run the function
	if($('.active_page').next('.page_link').length==true){
		go_to_page(new_page);
	}
	
}
function go_to_page(page_num){
	//get the number of items shown per page
	var show_per_page = parseInt($('#show_per_page').val());
	
	//get the element number where to start the slice from
	start_from = page_num * show_per_page;
	
	//get the element number where to end the slice
	end_on = start_from + show_per_page;
	
	//hide all children elements of content div, get specific items and show them
	$('#content').children().css('display', 'none').slice(start_from, end_on).css('display', 'block');
	
	/*get the page link that has longdesc attribute of the current page and add active_page class to it
	and remove that class from previously active page link*/
	$('.page_link[longdesc=' + page_num +']').addClass('active_page').siblings('.active_page').removeClass('active_page');
	
	//update the current page input field
	$('#current_page').val(page_num);
}

</script>

<?php get_footer(); ?>