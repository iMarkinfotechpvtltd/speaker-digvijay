<?php
/**
 * The template for displaying the header
 *
 * Displays all of the head element and everything up until the "site-content" div.
 *
 * @package WordPress
 * @subpackage Twenty_Sixteen
 * @since Twenty Sixteen 1.0
 */

?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>SPEAKERS SYNDICATE</title>

    <!-- Bootstrap -->
    <link rel="icon" href="<?php echo esc_url( get_template_directory_uri() ); ?>/images/fav.png" type="image/x-icon">
	<?php wp_head(); ?>
    <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/style.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo esc_url( get_template_directory_uri() ); ?>/css/sweetalert.css">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
 
 <div class="top-section">
   <div class="container">
      <div class="row">
        <div class="col-xs-5">
          <a class="logo" href="<?php echo site_url(); ?>"><?php if ( function_exists( 'ot_get_option' ) ) : ?>
								<?php $logo = ot_get_option( 'speakersyndicate_logo' ); ?>
								<img src="<?php echo $logo; ?>" alt=" "></a>
						<?php endif; ?></a>
        </div> <!--col-xs-6-->
        <div class="col-xs-7 text-right">	
            <a class="btn btn-danger btn-speak" id="srch-spkers" href="javascript:void(0);"><span class="search-icon"></span>SEARCH SPEAKERs</a> 
            <a class="btn btn-danger btn-speak" href="<?php echo site_url(); ?>/speaker/"><span class="speaker-icon"></span>SPEAKERS</a> 
        </div> <!---col-xs-7--->
      </div> <!--row-->     
   </div> <!--container-->
 </div>  <!---top-section Close--->