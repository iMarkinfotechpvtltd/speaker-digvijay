<?php
include('../../../wp-config.php');
$DivId	=	$_POST['DivId'];
?>
<div class="keynote-box boder close_<?php echo $DivId; ?>"> 
      <div class="img-gallery" id="keynote-holder_<?php echo $DivId; ?>"> 
            <img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/speaker-Profile-SetUp-pagepp.jpg" alt="....">
            <a class="add-more" href=""></a>
            <span class="add-photo" href="">Add a Thumbnail Image (300 x 300 pixels)
			</span><div class="daga file-up" picid="keynote_photo_<?php echo $DivId; ?>" holderid="keynote-holder_<?php echo $DivId; ?>"><input onchange="return ValidateFileUpload('keynote_photo_<?php echo $DivId; ?>')" id="keynote_photo_<?php echo $DivId; ?>" class="inputfile inputfile-<?php echo $DivId+1; ?>" value='keynote_photo_<?php echo $DivId; ?>' name="keynote_photo[]" required type="file"/>
			<label for="keynote_photo_<?php echo $DivId; ?>">
				<span></span>
				</label>
          </div></div>			
     <div class="keynote-content">
        <div class="overview-tittle-setup">
              <input type="text" name="keynote_title[]" required placeholder="Title" class="form-control"> <a href="#" class="editor-button"></a>
          </div>
          
         <div class="overview-tittle-setup">
              <textarea placeholder="Description" required name="keynote_description[]" class="form-control"></textarea> <a href="#" class="editor-button"></a>
          </div> 
          <h3>Program Take-Aways</h3>
          <div class="overview-tittle-setup keynote-area">
              <input type="text"  name="keynote_program1[]" required class="form-control"> <a href="#" class="editor-button"></a>
          </div> 
          
          <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program2[]" class="form-control"> <a href="#" class="editor-button"></a>
          </div> 
          
          <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program3[]" class="form-control"> <a href="#" class="editor-button"></a>
          </div> 
          
           <div class="overview-tittle-setup keynote-area">
              <input type="text" name="keynote_program4[]" class="form-control"> <a href="#" class="editor-button"></a>
          </div> 
          
     </div> <!--keynote-content-->  
	 <a href="javascript:void(0)"><div class="remove_field keynote-area" divid='<?php echo $DivId; ?>'>Delete</div></a>
    </div> <!---keynote-box close--->
	