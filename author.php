<?php get_header(); 

global $post;
$author_id=$post->post_author;

$templateURL = get_bloginfo('template_url'); 
?>

<div id="contentWrap" class="center"> 

<h2 id="pageDesc">All Posts By: <span class="highlight"><?php the_author_meta('display_name', $author_id); ?></span></h2>

<ul id="catNav">
<li><a href="<?php echo home_url(); ?>" class="defaultTransition">home</a></li>
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
	
		echo ('<li><a href="'.$catLink.'">'.$catName.'</a></li>'); 
	
	
	
}

?>
</ul>

<div class="postPreviewRow">


<div class="ykControlBlock left">

<img title="<?php the_author_meta('display_name', $author_id); ?>'s Posts" src="<?php echo ($templateURL."/images/yk-search-icon.jpg"); ?>"></img>

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

$author = get_userdata(get_query_var('author'));
$allPosts = array('post','young kings','fd');
$genreQuery = new WP_Query(array('category_name'=>$slug, 'orderby'=>'date', 'showposts'=>'0', 'post_type' => $allPosts, 'author' => $author->ID));

while ($genreQuery->have_posts()) : $genreQuery->the_post(); 

$coverPhoto = get_post_meta($post->ID, 'cover_photo', true);

$category = get_the_category($post->ID); 

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

</div>

<?php get_footer(); ?>
