<div id="footerWrap" class="center">

  <?php if (is_single()) {

    function randomizeFooterPosts() {

    	do {

      	$category = get_the_category();
      	$currentCat = $category[0]->cat_name;

      	$catArray = get_categories();

      	$selectedCat = array_rand($catArray, 1);

      	$theCat = $catArray[$selectedCat]->cat_name;
    	} while ($theCat == $currentCat);
    		

      $theCatSlug = $catArray[$selectedCat]->cat_ID;		

      return array( $theCat, $theCatSlug );
    }

    $footerPosts = randomizeFooterPosts();
  ?>

    <div class="catDesc">In: <span class="highlight"><?php echo $footerPosts[0]; ?></span></div>
    <ul id="randomPosts" class="postPreviewRow minimized">

      <?php

        $randomPostQuery = new WP_Query(array('cat'=>$footerPosts[1], 'orderby'=>'date', 'showposts'=>'14'));

        while ($randomPostQuery->have_posts()) : $randomPostQuery->the_post();

        $coverPhoto = get_post_meta($post->ID, 'cover_photo', true);
        $posttype = get_post_type();

        switch ($posttype) {

          case "post":
            $category = get_the_category($post->ID); 
            $catName = $category['0']->cat_name;
            $catSlug = $category['0']->slug;
          break;

          case "youngkings": 
            $catName = $posttype;
          break;

          case "fd":
            $catName = $posttype;
          break;
        }
      ?>

      <li class="left bgFade" 
      style="background-image: url('<?php echo($coverPhoto['url']); ?>');
      background-position:
      <?php 
      if ($coverPhoto['verticalQuickPosition'] == "middle") {
      echo (" center "); 
      } else {
      echo ($coverPhoto['verticalQuickPosition']." ");
      }

      echo $coverPhoto['horizontalQuickPosition'];
       ?>;
      ">

        <a href="<?php the_permalink(); ?>">
          <div class="postTitleBlock">
            <?php the_title(); ?>
          </div>
        </a>

        <div class="grow">
          <span class="categoryLabel center">
            <?php echo $catName; ?>
          </span>
        </div>
      </li>

      <?php 
        endwhile;
        wp_reset_query();
      ?>

    </ul>

  <?php } ?>

  <div id="socialBlock" class="left">

    <?php $templateURL = get_bloginfo('template_url'); ?>
    <a href="http://www.facebook.com/ykfdinc" class="fbPageIcon left" target="_blank">
    </a>

    <a href="http://twitter.com/YKNightlights" class="twitterPageIcon left" target="_blank">
    </a>

    <a href="<?php bloginfo('atom_url'); ?>" class="rssPageIcon left" target="_blank">
    </a>
  </div>

  <div id="legalBlock">
    <strong>ST&T Regency Schools <?php echo date('Y') ?></strong><br /><br />
    20 Remi Fani Kayode, GRA-Ikeja, Lagos, Nigeria<br />
    Tel: 01 453 9343<br />
    Email: info@sttregencyschools.com<br />
    All Rights Reserved - Issyma
  </div>

</div>

<?php wp_footer(); ?>

</body>

</html>