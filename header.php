<?php 
  
  // required vars
    $templateURL = get_bloginfo('template_url');
    $logoUrl = esc_attr( get_option('logo_url') ); 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" 
"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head>

  <title>
    <?php 

    /* Display Site Name + Description in the Title Tag on Homepage */ 
      if (is_front_page()) { 
        bloginfo('name');
        echo " | ";  
        bloginfo('description'); 
      } 

    /* Display Page Title and Site Name in the Title Tag on all other Pages */
      else { 
        wp_title('&raquo;', true, right); 
        bloginfo('name');
      }
    ?>
  </title>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <?php
  if ( is_single() ){

    $coverPhoto = get_post_meta($post->ID, 'cover_photo', true); ?>

    <meta property="og:title" content="<?php the_title(); ?>" /> 
    <meta property="og:description" content="<?php the_excerpt(); ?>" /> 
    <meta property="og:image" content="<?php echo($coverPhoto['url']); ?>" />

  <?php } ?>

  <link rel="profile" href="http://gmpg.org/xfn/11" />
  <link rel="stylesheet" type="text/css" media="all" href="<?php bloginfo( 'stylesheet_url' ); ?>" />
  <link href='http://fonts.googleapis.com/css?family=Josefin+Sans' rel='stylesheet' type='text/css'>
  <link rel="shortcut icon" href="<?php echo $templateURL; ?>/images/favicon.ico" />

  <?php wp_head(); ?>
</head>

<?php flush(); ?>

<body>
 
  <div id="headerWrap">

  <img src="<?php echo( $logoUrl ? $logoUrl : $templateURL . '/images/yklogo.png' ); ?>" id="headerLogo"></img>
  <div id="ykSubsections" class="center">
    <a href="<?php echo home_url(); ?>/youngkings/" title="Young Kings">
    <img src="<?php echo $templateURL; ?>/images/YK.png" class="defaultTransition"></img></a> <img src="<?php echo $templateURL; ?>/images/FD.png" class="defaultTransition"></img>
  </div>

  <?php get_search_form(); ?>

  </div>