<?php 
	
	// required variables
		$templateURL = get_bloginfo('template_url'); 
    $homeCardImageURL = get_option('home_card_url') ? esc_attr( get_option('home_card_url') ) : $templateURL . '/images/yk-home-icon.png';
	
	get_header(); 
?>

<div id="contentWrap" class="center">

	<div class="postPreviewRow">

		<?php

			$templateURL = get_bloginfo('template_url'); 
			$category = get_the_category($post->ID); 
			$posttype = get_post_type();
			$categoryMetadata = get_term_meta( $category[0]->term_id, 'yk_category_image' );

			if( $categoryMetadata ){

				$categoryImageVerticalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_vertical_position', true );
				$categoryImageHorizontalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_horizontal_position', true );
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

		<?php if( $catCardImgUrl ){ ?>

			<div class="ykControlBlock left" style="background-image: url( <?php echo $catCardImgUrl; ?> ); background-position: <?php echo $categoryImageVerticalPos ? $categoryImageVerticalPos : 'center'; ?> <?php echo $categoryImageHorizontalPos ? $categoryImageHorizontalPos : 'center'; ?>;">
			</div>

		<?php } else { ?>

			<div class="ykControlBlock left"><span class="catTitle"><?php echo $catName; ?></span></div>

		<?php } ?>

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