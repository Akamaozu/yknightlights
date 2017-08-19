<ul id="catNav">

  <li <?php echo is_home() ? 'class="current-cat"' : ''; ?> >
    <a href="<?php echo home_url(); ?>">home</a>
  </li>

  <?php

    global $post;

    $currentCat = get_the_category( $post->ID );
    $thisCat = !is_home() ? $currentCat[0]->cat_ID : 0;
    $catNavArgs = array (
      'type' => 'post',
      'orderby' => 'name',
      'order' => 'asc',
      'style' => 'none',
      'hide_empty' => 0,
      'exclude' => array(1)
    );

    $catArray = get_categories($catNavArgs);

    foreach ($catArray as $cat){

      $catID = $cat->cat_ID;
      $catName = $cat->name;
      $currentCatArray = get_the_category();
      $currentCat = $currentCatArray[0]->cat_ID;
      
      $catLink = get_category_link($catID);
      
      if ($catID !== $thisCat) {
        echo ('<li><a href="'.$catLink.'">'.$catName.'</a></li>'); 
      } 

      else {
        echo ('<li class="current-cat"><a href="'.$catLink.'">'.$catName.'</a></li>');
      }   
    }
  ?>
</ul>