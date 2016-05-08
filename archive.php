<?php 
	
	// required variables
		$templateURL = get_bloginfo('template_url'); 
	
	get_header(); 
?>

<div id="contentWrap" class="center"> 
	
	<div class="postPreviewRow minimized">

		<div class="ykControlBlock left">
			<img src="<?php echo $templateURL; ?>/images/yk-home-icon.png"></img>
		</div>

		<div class="postPortalsWrap center">
			<ul id="ykTimeline" class="left">

				<?php

					$allPosts = array('post','young kings','fd');
					$genreQuery = new WP_Query( array( 'category_name'=>$slug, 'orderby'=>'date', 'showposts'=>'0', 'post_type' => $allPosts));

					while ($genreQuery->have_posts()) : $genreQuery->the_post(); 

					$coverPhoto = get_post_meta($post->ID, 'cover_photo', true);
					$category = get_the_category($post->ID); 
					$posttype = get_post_type();

					switch( $posttype ){

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
		</div>
	</div>

	<ul id="catNav">
		<li><a href="<?php echo home_url(); ?>">home</a></li>

		<?php

			$currentCat = get_the_category();
			$thisCat = $currentCat[0]->cat_ID;
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
				
				if ($catID !== $currentCat) {
					echo ('<li><a href="'.$catLink.'">'.$catName.'</a></li>'); 
				} 

				else {
					echo ('<li class="current-cat"><a href="'.$catLink.'">'.$catName.'</a></li>');
				}		
			}
		?>
	</ul>

	<div class="postPreviewRow">

		<?php

			$templateURL = get_bloginfo('template_url'); 
			$category = get_the_category($post->ID); 
			$posttype = get_post_type();
			$categoryMetadata = get_term_meta( $category[0]->term_id, 'yk_category_image' );

			if( $categoryMetadata ){

				$categoryImageVerticalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_vertical_position' );
				$categoryImageHorizontalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_horizontal_position' );
			}

			switch( $posttype ){

				case "post":
					$category = get_the_category($post->ID); 
					$catName = $category['0']->cat_name;
					$catSlug = $catCardImg = $category['0']->slug;
				break;

				case "youngkings": 
					$catName = 'Young Kings';
					$catCardImg = $posttype;
				break;

				case "fd":
					$catName = $posttype;
					$catCardImg = $posttype;
				break;
			}

			switch ($catCardImg) {

			case "tumblr":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-tumblr-icon.png");
				break;

			case "style":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-style-icon.jpg");
				break;
				
			case "music":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-music-icon.jpg");
				break;
				
			case "art-design":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-arts-icon.jpg");
				break;

			case "leisure":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-leisure-icon.jpg");
				break;
				
			case "sports":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-sports-icon.jpg");
				break;
				
			case "technology":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-tech-icon.jpg");
				break;
				
			case "youngkings":
				$catCardImgUrl = ( count( $categoryMetadata ) > 0 ? $categoryMetadata[0]['url'] : $templateURL . "/images/yk-youngkings-icon.jpg");
				break;
			}
		?>

		<div class="ykControlBlock left" style="background-image: url( <?php echo $catCardImgUrl; ?> );">
	</div>

	<div class="postPortalsWrap center">

		<div class="portalNav leftNav"> 
			<a href="javascript:scrollLeft()" title="&larr; Left">&larr;</a>
		</div>

		<div class="portalNav rightNav"> 
			<a href="javascript:scrollRight()" title="Right &rarr;">&rarr;</a>
		</div>

		<div id="postPortals" class="center">

			<ul id="feedBlock" class="left">

				<?php

					while (have_posts()) : the_post(); 

					$coverPhoto = get_post_meta($post->ID, 'cover_photo', true);
					$posttype = get_post_type();

					switch( $posttype ){

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
		</div>
	</div>
</div>

<?php get_footer(); ?>