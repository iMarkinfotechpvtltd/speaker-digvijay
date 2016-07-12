<?php
/*
 Template Name: Program description
 */
?>
<?php get_header(); ?>

<div class="banner-section">
<?php $src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID),'description' ); ?>
   <img src="<?php echo $src[0];?>" alt="Speakers" />   
 </div> <!--banner-section close--> 

<div class="program-description">
  <div class="container">
   <?php while ( have_posts() ) : the_post(); ?>
		 <h2><?php the_title(); ?></h2>
		 <?php echo content('300'); ?>
	<?php endwhile; wp_reset_query(); ?> 
    
    </div>  

</div> <!--program description-->



<div class="does-this-cost">
   <div class="container">
     <?php the_field('what_does_this_cost',7); ?>
      
     <div class="row m-top"> 
       <div class="col-xs-12 col-md-6 content">
        <?php the_field('marketing_co-op_program',7); ?>
         
         
       </div>
      
       
       <div class="col-xs-12 col-md-6">
         <div class="embed-responsive embed-responsive-16by9">
             <iframe class="embed-responsive-item" src="<?php the_field('video_url',7); ?>"></iframe>
         </div>
         
       </div> <!--col-xs-12 col-dm-6 Close--->
       
     </div> <!--row-->
     
   </div> <!--container-->
</div> <!--does-this-cost Close-->

<div class="white-boxes-section">
  <div class="container">
    <div class="box">
     <span class="icon0"></span>
      
      <?php the_field('how_is_the_money_spent',7); ?>
       
    </div> <!--box-->
    
    <div class="box">
     <span class="icon1"></span>
      
      <?php the_field('what_information_will_i_get',7); ?>
      
    </div> <!--box-->
    
     <div class="box">
     <span class="icon2"></span>
      
     <?php the_field('how_do_i_apply',7); ?>
      
    </div> <!--box-->
    
  </div> <!--white-boxes-section-->
</div> <!--white-boxes-section--->


<div class="how-many-speaker">
  <div class="container">
    <?php //the_field('how_many_speakers_do_you_have',7); ?>
    
  </div> <!---container--->
</div>  <!---how-many-speaker--->

<div class="conference-pricing">
   <div class="container">
     <h2>SPEAKER PARTICIPATION LEVELS </h2>
    
    <div class="row">
	<?php 
								
		$args = array('post_type' => 'package','posts_per_page' =>3,'order' => 'ASC' );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post();
		
	?>
      <div class="col-xs-12 col-md-4">
        <div class="price-box">
          <div class="box-head">
            <h3><?php the_title(); ?></h3>
          
          </div> <!--box-head-->
          
          <div class="per-month">
            <h1><?php the_field('price',$post->ID); ?></h1>
              
          </div>
          <div class="listing-section">
           <?php the_content(); ?>
            
               <button type="button" class="btn btn-default btn-pay">pay later</button>
                       
          </div>
       
          
        </div>  <!--price-box-->       
      </div> <!---col-xs-12 col-sm-4--->

      <?php 
	
		endwhile;
	  ?>
      
    </div> <!--row--> 
   <form action="<?php echo site_url(); ?>/set-speaker-profile" method="POST">  
   <div class="arrgrement-section">   
     <ul>
        <li><input type="checkbox" required > I understand that a completed Speaker Profile Page does not guarantee acceptance into the Speaker Syndicate.</li>
        <li><input type="checkbox" required> I understand that Speaker Syndicate does not favor any one speaker over another, aside from the participation level selected (Silver, Gold or Platinum).</li>
        <li><input type="checkbox" required> I understand that Speaker Syndicate cannot guarantee that you get booked for speaking engagements.  It can only guarantee targeted traffic to the website as a whole.</li>
        <li><input type="checkbox" required>I understand that Speaker Syndicate (currently) advertises exclusively to corporate event and meeting planners in the United States.  Other regions may be introduced in the future.</li>
        <li><input type="checkbox" required> I understand that 80% of my money will be spent directly on advertising and 20% will go to the business of maintaining and improving the website, developing ad creative, testing advertising channels, optimizing ad performance and maintaining advertising and sponsorship relationships</li>
     </ul>
    </form>  
      <button type="submit" class="btn btn-danger btn-speak">YES, I WOULD LIKE TO BEGIN SETTING UP MY SPEAKER PROFILE PAGE</button>
     </div>
   </div>
</div>   <!--conference-pricing-->
<?php get_footer(); ?>