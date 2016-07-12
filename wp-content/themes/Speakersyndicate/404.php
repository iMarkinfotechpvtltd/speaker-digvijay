<?php
/**
 * The template for displaying 404 pages (not found)
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

get_header(); ?>

	<div id="primary" class="container">
	
			<div class="page-error-404 text-center">
				<header class="page-404-header">
					<h1><img src="<?php echo esc_url( get_template_directory_uri() ); ?>/images/404.png"></h1>
				</header><!-- .page-header -->

				<div class="page-content">
					<p><?php _e( 'Oops! That page can&rsquo;t be found.', 'twentysixteen' ); ?><a class="home-link" href="<?php echo site_url(); ?>">GO TO HOME</a></p>
				</div><!-- .page-content -->
			</div><!-- .error-404 -->



	

	</div><!-- .content-area -->

<?php get_footer(); ?>
