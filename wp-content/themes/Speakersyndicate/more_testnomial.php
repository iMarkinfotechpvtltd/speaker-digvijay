<?php
include('../../../wp-config.php');
$testimonialId	=	$_POST['testimonialId'];
?>
<div class="testimonial-set-up close_<?php echo $testimonialId; ?>">
        <div class="input-holder"> 
            <div class="boigraphy-icon"></div> 
             <textarea name="detailed_testimonial[]" required class="form-control" placeholder="Testimonial"></textarea>
           </div>
          <div class="input-holder text-center"> 
               <input type="text" name="client_name[]?>" required class="form-control" placeholder="Client Name & Title"> 
          </div>  
		   <div class="customCls" picid="client_img_<?php echo $testimonialId; ?>" holderid="client_img_holder_<?php echo $testimonialId; ?>">
	      <div class="client-pp" id="client_img_holder_<?php echo $testimonialId; ?>">
		  <div class="file-up">
          
			<input id="client_img_<?php echo $testimonialId; ?>" required onchange="return ValidateFileUpload('client_img_<?php echo $testimonialId; ?>')" name="client_img[]" type="file"/>
			<label for="client_img_<?php echo $testimonialId; ?>">
			<span>Add Photo</span>
			</label>
			 </div>
		 </div>
		 <span class="first_agreement"><input type="checkbox" name="agreement[]" required value="yes">I Agree</span>
		 </div>
   
	 <a href="javascript:void(0)"><div class="remove_field keynote-area" testimonialId="<?php echo $testimonialId; ?>">Delete</div></a>
     </div>
	