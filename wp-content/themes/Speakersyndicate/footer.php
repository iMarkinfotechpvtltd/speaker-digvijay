<?php
/**
 * The template for displaying the footer
 *
 * Contains the closing of the #content div and all content after
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */
?>
<!---footer Start Here--->

<div class="footer">
  <div class="footer-top-section">
    <div class="container">
    <div class="row-span">
          
          <div class="social-icons">
            <ul>
               <li class="twitter"><a target="_blank" href="<?php if ( function_exists( 'ot_get_option' ) ) : ?>
									<?php echo ot_get_option( 'twitter_link' ); ?>
									<?php endif; ?>">
								</a>
				</li>
               <li class="facebook"><a target="_blank" href="<?php if ( function_exists( 'ot_get_option' ) ) : ?>
									<?php echo ot_get_option( 'facebook_link' ); ?>
									<?php endif; ?>">
								</a></li>
               <li class="linked-in"><a target="_blank" href="<?php if ( function_exists( 'ot_get_option' ) ) : ?>
									<?php echo ot_get_option( 'linkedin_link' ); ?>
									<?php endif; ?>">
								</a></li>
            </ul>	
          </div>
        </div> <!--row-span-->
        
    
    </div> 
  </div> <!--footer-top-section-->
 
 <div class="footer-bottom-nav">
   <div class="container"> 
  
<ul>
	
		<?php $defaults = array(
		'theme_location'  => '',
		'menu'            => 'footer_menu',
		'container'       => '',
		'container_class' => '',
		'container_id'    => '',
		'menu_class'      => 'menu',
		'menu_id'         => '',
		'echo'            => true,
		'fallback_cb'     => 'wp_page_menu',
		'before'          => '',
		'after'           => '',
		'link_before'     => '',
		'link_after'      => '',
		'items_wrap'      => '%3$s',
		'depth'           => 0,
		'walker'          => ''
		);

		wp_nav_menu( $defaults );

		?>

</ul>
							
    <p><?php if ( function_exists( 'ot_get_option' ) ) : ?>
		<?php echo $footer_text = ot_get_option( 'footer_text' ); ?>
	<?php endif; ?>  <span>Powered By:<a href="http://www.imarkinfotech.com/" target="_blank" tittle="Powered By: iMark Infotech">iMark <span>I</span>nfotech</a>
</span>
	</p> 
   </div> 
 </div> <!---footer-bottom-nav---->
  
</div> <!---footer Close--->


<!---footer END Here--->  
  
  
  
  
<?php wp_footer(); ?>
 <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
    <!--<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>-->
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/bootstrap.min.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/owl.carousel.min.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/plugin.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/jquery.flexslider-min.js"></script>
    <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/main.js"></script>
	
   <script src="<?php echo esc_url( get_template_directory_uri() ); ?>/js/sweetalert.min.js"></script>
   
		<script>
			function scrollToAnchor(aid){
			var aTag = jQuery("a[name='"+ aid +"']");
			jQuery('html,body').animate({scrollTop: aTag.offset().top},'slow');
			}

			jQuery("#btn-learn_1").click(function() {
				scrollToAnchor('promise-pro-id');
			});
			jQuery("#btn-learn_2").click(function() {
				scrollToAnchor('premise-pro-id');
			});
			jQuery("#btn-learn_3").click(function() {
				scrollToAnchor('power-pro-id');
			});
			jQuery("#srch-spkers").click(function() {
				scrollToAnchor('search-spk-id');
			});
			jQuery("#btn-read-less").click(function() {
				scrollToAnchor('premise-pro-id');
			});
		</script>
		

</body>
</html>
