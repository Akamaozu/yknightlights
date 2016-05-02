<?php get_header(); ?>

<div id="contentWrap" class="center"> 

<div class="postPreviewRow">

<div class="ykControlBlock left">

<?php
$templateURL = get_bloginfo('template_url'); 
?>

<img src="<?php echo $templateURL; ?>/images/yk-home-icon.png"></img>

</div>


<div id= "" class="postPortalsWrap center">

<div class="portalNav leftNav"> 
<a href="javascript:scrollLeft()" title="&larr; Left">&larr;</a>
</div>

<div class="portalNav rightNav"> 
<a href="javascript:scrollRight()" title="Right &rarr;">&rarr;</a>
</div>

<div id="postPortals" class="center">

<ul id="feedBlock" class="left">

<?php

$allPosts = array('post','young kings','fd');
$genreQuery = new WP_Query(array('category_name'=>$slug, 'orderby'=>'date', 'showposts'=>'0', 'post_type' => $allPosts));

while ($genreQuery->have_posts()) : $genreQuery->the_post(); 

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
</div>
</div>

</div>


<ul id="catNav">
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

</div>

<?php get_footer(); ?>
