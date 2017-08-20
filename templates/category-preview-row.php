<?php

  global $posts;

  $templateURL = get_bloginfo('template_url'); 
  $category = get_the_category();
  $categoryName = $category['0']->cat_name;
  $categoryMetadata = get_term_meta( $category[0]->term_id, 'yk_category_image' );
  $categoryImageUrl = $categoryMetadata[0] ? $categoryMetadata[0]['url'] : null;

  if( $categoryImageUrl ){
    $categoryImageVerticalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_vertical_position', true );
    $categoryImageHorizontalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_horizontal_position', true );
  }

  $preview_row_config = array( 'label' => array(), 'posts' => $posts );

  if( $categoryImageUrl ){
    $preview_row_config['label']['image'] = array();
    $preview_row_config['label']['image']['url'] = $categoryImageUrl;
    $preview_row_config['label']['image']['verticalPos'] = $categoryImageVerticalPos;
    $preview_row_config['label']['image']['horizontalPos'] = $categoryImageHorizontalPos;
  } 

  else if( $categoryName ) $preview_row_config['label']['text'] = $categoryName;

  render_post_preview_row( $preview_row_config );
?>