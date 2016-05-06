<?php get_header(); ?>

<div id="contentWrap" class="center"> 

<h2 id="pageDesc"><?php echo $wp_query->found_posts; ?> Posts Containing: <span class="highlight"><?php the_search_query(); ?></span></h2>

<ul id="catNav">
<li><a href="<?php echo home_url(); ?>">All</a></li>

<?php

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
	
	$catLink = get_category_link($catID);
	
		echo ('<li><a href="'.$catLink.'">'.$catName.'</a></li>'); 

}

?>
</ul>

<div class="postPreviewRow">


<div class="ykControlBlock left">

<?php
$templateURL = get_bloginfo('template_url'); 
?>

<img title="Search Results" src="<?php echo ($templateURL."/images/yk-search-icon.jpg"); ?>"></img>

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

if (!have_posts()) { ?>

<li class="left bgFade" style="background-image: url(<?php bloginfo('template_url'); ?>/images/noSearchResult.jpg); background-position: center;">

<a href="<?php echo home_url(); ?>">

<div class="postTitleBlock">
No Results Found
</div>
</a>


<div class="grow">
<span class="categoryLabel center">
Click to Go Home
</span>

</div>

</li>

<?php } else {

while (have_posts()) : the_post();
 
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
}?>

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
}
?>

</ul>
</div>
</div>
</div>

</div>

<?php get_footer(); ?>
