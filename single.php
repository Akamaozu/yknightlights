<?php	
	
	get_header(); 
	
	$category = get_the_category($post->ID); 
	$categoryName = $category[0]->cat_name;
	$categorySlug = $category[0]->slug;
	$categoryMetadata = get_term_meta( $category[0]->term_id, 'yk_category_image' );
	$categoryImage = $categoryMetadata[0]['url'];

	if( $categoryImage ){
		$categoryImageVerticalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_vertical_position', true );
		$categoryImageHorizontalPos = get_term_meta( $category[0]->term_id, 'yk_category_image_horizontal_position', true );
	}
	
	$postCategoryQuery = new WP_Query( array( 
		'orderby' => 'date',
		'showposts' => '0',
		'category_name' => $categorySlug
	) );
?>

<div id="contentWrap" class="center">

	<?php

		$labelConfig = array();

		if( $categoryImage ){
			$labelConfig['image'] = array();
			$labelConfig['image']['url'] = $categoryImage;
			$labelConfig['image']['verticalPos'] = $categoryImageVerticalPos;
			$labelConfig['image']['horizontalPos'] = $categoryImageHorizontalPos;
		}

		else if( $categoryName ) {
			$labelConfig['text'] = $categoryName;
		}

		$post_preview_config = array( 'posts' => $postCategoryQuery->posts, 'label' => $labelConfig, 'minimized'=> true );
		render_post_preview_row( $post_preview_config ); 
	?>

	<?php while( have_posts() ) : the_post(); ?>

	<div id="titleBlock" class="clearAll">
		<div class="postMeta">
			<?php the_time('l, jS F Y');  ?>
		</div>

		<?php the_title(); ?>
	</div>

<div id="contentBlock">

<div class="shareBlock">
<?php 

$templateURL = get_bloginfo('template_url');
$coverPhoto = get_post_meta($post->ID, 'cover_photo', true);

?>

<a href="http://www.facebook.com/sharer.php?u=<?php the_permalink(); ?>&t=<?php the_title(); ?>" target="_blank" title="Share on Facebook" class="bgFade fbShareIcon center">
</a>

<a href="http://twitter.com/home?status=<?php echo str_replace("%26%23038%3B","%26", urlencode(get_the_title())); ?> - YK%2bNightlights <?php the_permalink(); ?>" target="_blank" title="Tweet This" class="bgFade twitterShareIcon center">
</a>

<a href="http://www.tumblr.com/share/photo?source=<?php echo urlencode($coverPhoto['url']) ?>&caption=<?php echo str_replace("%26%23038%3B","%26", urlencode(get_the_title())); ?>&clickthru=<?php echo urlencode( get_permalink() ) ?>" target="_blank" title="Reblog" class="bgFade tumblrShareIcon center">
</a>

</div>

<div id="twitterTrain">
<a id="ttToggle" href="javascript:toggleTrain()">Twitter Train</a>

<?php
	if ( ! dynamic_sidebar('tweet_area') ) : dynamic_sidebar('tweet_area');
	endif;
?>

</div>

<?php 

	echo the_content();

	$nightlights = get_post_meta($post->ID, 'nightlights', true); 

	if( $nightlights['sourceURL'] ){ ?>

		<div id="nightlights">
			NIGHTLIGHTS: <a href="<?php echo $nightlights['sourceURL']; ?>" target="_blank"><?php echo $nightlights['linkText']; ?></a>
		</div>

<?php } ?>

</div>
</div>

<?php endwhile ?>

<?php get_footer(); ?>
