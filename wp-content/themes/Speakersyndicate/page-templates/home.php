<?php
/*
 Template Name: Home Page Template
 */
?>
<?php get_header('2'); 
//HTML truncate function
	function truncate($text, $length = 500, $ending = '...', $exact = false, $considerHtml = true) {
	if ($considerHtml) {
		// if the plain text is shorter than the maximum length, return the whole text
		if (strlen(preg_replace('/<.*?>/', '', $text)) <= $length) {
			return $text;
		}
		// splits all html-tags to scanable lines
		preg_match_all('/(<.+?>)?([^<>]*)/s', $text, $lines, PREG_SET_ORDER);
		$total_length = strlen($ending);
		$open_tags = array();
		$truncate = '';
		foreach ($lines as $line_matchings) {
			// if there is any html-tag in this line, handle it and add it (uncounted) to the output
			if (!empty($line_matchings[1])) {
				// if it's an "empty element" with or without xhtml-conform closing slash
				if (preg_match('/^<(\s*.+?\/\s*|\s*(img|br|input|hr|area|base|basefont|col|frame|isindex|link|meta|param)(\s.+?)?)>$/is', $line_matchings[1])) {
					// do nothing
				// if tag is a closing tag
				} else if (preg_match('/^<\s*\/([^\s]+?)\s*>$/s', $line_matchings[1], $tag_matchings)) {
					// delete tag from $open_tags list
					$pos = array_search($tag_matchings[1], $open_tags);
					if ($pos !== false) {
					unset($open_tags[$pos]);
					}
				// if tag is an opening tag
				} else if (preg_match('/^<\s*([^\s>!]+).*?>$/s', $line_matchings[1], $tag_matchings)) {
					// add tag to the beginning of $open_tags list
					array_unshift($open_tags, strtolower($tag_matchings[1]));
				}
				// add html-tag to $truncate'd text
				$truncate .= $line_matchings[1];
			}
			// calculate the length of the plain text part of the line; handle entities as one character
			$content_length = strlen(preg_replace('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', ' ', $line_matchings[2]));
			if ($total_length+$content_length> $length) {
				// the number of characters which are left
				$left = $length - $total_length;
				$entities_length = 0;
				// search for html entities
				if (preg_match_all('/&[0-9a-z]{2,8};|&#[0-9]{1,7};|[0-9a-f]{1,6};/i', $line_matchings[2], $entities, PREG_OFFSET_CAPTURE)) {
					// calculate the real length of all entities in the legal range
					foreach ($entities[0] as $entity) {
						if ($entity[1]+1-$entities_length <= $left) {
							$left--;
							$entities_length += strlen($entity[0]);
						} else {
							// no more characters left
							break;
						}
					}
				}
				$truncate .= substr($line_matchings[2], 0, $left+$entities_length);
				// maximum lenght is reached, so get off the loop
				break;
			} else {
				$truncate .= $line_matchings[2];
				$total_length += $content_length;
			}
			// if the maximum length is reached, get off the loop
			if($total_length>= $length) {
				break;
			}
		}
	} else {
		if (strlen($text) <= $length) {
			return $text;
		} else {
			$truncate = substr($text, 0, $length - strlen($ending));
		}
	}
	// if the words shouldn't be cut in the middle...
	if (!$exact) {
		// ...search the last occurance of a space...
		$spacepos = strrpos($truncate, ' ');
		if (isset($spacepos)) {
			// ...and cut the text in this position
			$truncate = substr($truncate, 0, $spacepos);
		}
	}
	// add the defined ending to the text
	$truncate .= $ending;
	if($considerHtml) {
		// close all unclosed html-tags
		foreach ($open_tags as $tag) {
			$truncate .= '</' . $tag . '>';
		}
	}
	return $truncate.'<a class="btn btn-default btn-read-more" href="javascript:void(0)">Read More</a>';
}
function custom_echo($x, $length)
{
  if(strlen($x)<=$length)
  {
    echo $x;
  }
  else
  {
    $y=substr($x,0,$length) . '...';
    echo $y;
  }
}
?>

<div class="carousel-section"> 
<div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
  <!-- Wrapper for slides -->
  <div class="carousel-inner" role="listbox">
		<?php
			global $post;
			$args 		= array( 'post_type' => 'slider','post_status' => 'publish','posts_per_page' => 3, 'order'=> 'ASC', );
			$GetPosts 	= get_posts( $args );
			$Flag=1;
			foreach ( $GetPosts as $post ) : setup_postdata( $post ); 
		?>
    <div class="item <?php if($Flag==1){echo 'active';} ?>">
				<?php
					if ( has_post_thumbnail() ) { 
						the_post_thumbnail( 'home-slider' ); 
					}
				?>
      <div class="carousel-caption">
       <div class="internal-caption">
        <?php the_content(); ?>
			<a class="btn btn-default btn-learn" id="btn-learn_<?php echo $Flag; ?>" href="<?php echo get_field('learn_more_link', $post->ID); ?>">Learn More</a>    
      </div>
     </div>
    </div>
   	<?php 
			$Flag++;
			endforeach; 
			wp_reset_postdata();
		?>		

  </div>

  <!-- Controls -->
  <a class="left carousel-control" href="#carousel-example-generic" role="button" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#carousel-example-generic" role="button" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
    <span class="sr-only">Next</span>
  </a>
 </div> 
</div> <!---carousel-section--->  
  
  
 <div class="multiple-item">
   <div class="container">
     <div class="owl-carousel">
	 <?php
		$ImagePath				=	site_url()."/wp-content/themes/Speakersyndicate/speaker_images/";
		$noImg					=	'no_profile_img.gif';	
	 $GetSpeakerData		= $wpdb->get_results("SELECT DISTINCT sp_users.ID FROM sp_users INNER JOIN sp_payments ON sp_users.ID=sp_payments.speaker_id WHERE sp_payments.PROFILESTATUS='Active'");	
	 if(!empty($GetSpeakerData)){
		foreach($GetSpeakerData as $GetSpeaker){
			$speakerID			=	$GetSpeaker->ID;
			$GetSpeakerImg 		= $wpdb->get_results("SELECT user_img FROM sp_user_img WHERE user_id ='$speakerID'");
			$speakerImage		=	$GetSpeakerImg['0']->user_img;	
			if(isset($speakerImage)){
				$speakerImgUrl	=	$ImagePath.$speakerImage;
			}else{
				$speakerImgUrl	=	$ImagePath.$noImg;
			} 
		$prof_headline		=	get_user_meta( $speakerID, 'profile_headline', true);
		?>
		
        <div class="grid-box">
		<?php 
				$urlID		=	get_user_meta( $speakerID, 'urlID', true);
				$urlData 	= 	get_post($urlID);
				$profileUrl	=	$urlData->guid;
		?>
		  <a href="<?php echo $profileUrl; ?>">
          <img src="<?php bloginfo('template_directory'); ?>/timthumb.php?src=<?php echo $speakerImgUrl; ?>&h=204&w=204&zc=1q=100" alt="..." />
		  <div class="grid-caption">
		
			<form action="<?php echo site_url(); ?>/speaker-profile/" method="POST" id="speaker_details_<?php echo $speakerID; ?>">
				<input type="hidden" value="<?php echo $speakerID; ?>" name="speaker_id">
				
					<h4><?php custom_echo($prof_headline, 20); ?></h4>
					<p>Keynote Speaker</p>
				  </div>
		  </form> </a>
        </div> <!---grid-box--->
	 <?php } }else{ ?>
		   <div class="grid-box">
          No Data to display.
        </div> <!---grid-box--->
	<?php  } ?> 
        
        
     </div>
   </div>
 </div>  <!--multiple-item close-->

 <a name="search-spk-id"/></a>
<div class="search-keywords-section">
  <div class="container">
    <div class="search-section">
       <h2>The Power of the Professional</h2>
      
      <form action="<?php echo site_url(); ?>/search/" method="POST" name="spkr_serach_form" onsubmit="return validateForm()">
		   <select name="Category[]" id="lstcats" multiple="multiple" class="form-control">
		  <option value="all">Any Category</option>
				<?php
				$GetTerms 		= $wpdb->get_results("SELECT sp_terms.term_id, sp_terms.name FROM sp_terms INNER JOIN sp_term_taxonomy ON sp_terms.term_id=sp_term_taxonomy.term_id WHERE sp_term_taxonomy.taxonomy='category' AND sp_terms.term_id!=1");

				foreach($GetTerms as $termData){
					$TermID			=	$termData->term_id;
					$TermName		=	$termData->name;
						echo '<option value="'.$TermID.'">'.$TermName.'</option>';
					} 
				?>
			</select>
			
			<input type="text" name="keywords" class="form-control" placeholder="Topic Keywords">
			
			<select name="gender" class="form-control">
			   <option value="">Gender</option>
			   <option value="male">Male</option>
			   <option value="female">Female</option>
			</select>
			<select name="fee_range_filter" class="form-control">
                <option value="">Fee Range (USA)</option>
                <option value="1">$5,000 to $7,500</option>
                <option value="2">$7,500 to $15,000</option>
               <option value="3">$15,000 to $25,000</option>
             </select>
		   <input type="submit" class="btn btn-danger btn-find" value="Find the Perfect Speaker!"> 
      </form>
    </div> 
  </div>
</div> <!--search-keywords-section Close-->


<div class="power-pro-section">
  <div class="container">
    <div class="row" id="contact-us">
      <div class="col-xs-12 col-md-6">
        <div class="pro-block">
         <?php echo get_field('power_of_pro_1', 2); ?>
        </div>  <!--pro-block-->
      </div> <!--col-xs-12 col-md-6-->
      
      <div class="col-xs-12 col-md-6">
        <div class="pro-block-form">
           <h2>contact form</h2>
          <form action="" method="POST" id="visitor-form"> 
             <input type="text" class="form-control" id="visitor_name" name="visitor_name" placeholder="Name">
             <input type="text" class="form-control" id="visitor_email" name="visitor_email" placeholder="Email">
             <textarea class="form-control" name="visitor_msg" id="visitor_msg" placeholder="Message"></textarea>
             
             <input type="submit" name="visiror_form" class="btn btn-default btn-contact" value="contact us">
          </form><div class="form-message" style="display:none;"></div> 
        </div>  <!--pro-block-form-->
      </div> <!--col-xs-12 col-md-6-->
    </div> <!--row-->
       
  </div> <!--container-->
</div> <!--power-pro-section Close-->
  
  <div class="container">
  
  <a name="promise-pro-id"/></a>
    <div class="promise-pro-section0">
		<?php echo get_field('promise_of_pro', 2); ?>
   </div> <!---promise-pro-section--->
    <a name="premise-pro-id"/></a>
    <div class="promise-pro-section1">
    <?php $conTent	= get_field('premise_of_pro', 2);
		echo "<span class='hidedaga'>".truncate($conTent)."</span>";
	?>
	 <span class="daga" style="display:none"><?php echo $conTent; ?><a class="btn btn-default btn-read-more btn-less-more" href="javascript:void(0)" id="btn-read-less">Less</a></span>	
	</div>
     <a name="power-pro-id"/></a>		
    <div class="promise-pro-section0">
      <?php echo get_field('power_of_pro_2', 2); ?>
   </div> <!---promise-pro-section--->
    
  </div> <!---container-section--->

<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/home_visitor_enquiry.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.validate.js" type="text/javascript" charset="utf-8"></script>
<script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bootstrap-multiselect.js" type="text/javascript"></script>
<script type="text/javascript">
	jQuery(function () {
		jQuery('#lstcats').multiselect({
			includeSelectAllOption: false
		});
	   
	});
</script>
<script>
jQuery(document).ready(function() {
	jQuery(".btn-read-more").click(function() {
		
		jQuery('.daga').show();
		jQuery('.hidedaga').hide();
		
});
	jQuery(".btn-less-more").click(function() {
		jQuery('.daga').hide();
		jQuery('.hidedaga').show();
		
});	
	

jQuery.noConflict();
   jQuery("#visitor_name").keypress(function(event){
       var inputValue = event.which;
       // allow letters and whitespaces only.
       if((inputValue > 33 && inputValue < 64) || (inputValue > 90 && inputValue < 97 ) || (inputValue > 123 && inputValue < 126)
&& (inputValue != 32)){
           event.preventDefault();
       }
   });
   var text33 = jQuery('.multiselect-selected-text').replaceWith( '<span class="multiselect-selected-text">TOPIC CATEGORIES </span>' );
  
});
function validateForm() {
    var x = document.forms["spkr_serach_form"]["Category[]"].value;
	//alert(x);
    if (x == null || x == "") {
         sweetAlert('Oops...', 'Please select category.', 'error');
        return false;
    }
}
</script>
<?php get_footer(); ?>