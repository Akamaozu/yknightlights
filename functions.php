<?php

/*   Admin Panel Stylesheet  */
 
 function adminStyleMods() {
    $url = site_url();
    echo ('<!-- Custom Admin Stylesheet -->
          <link rel="stylesheet" type="text/css" href="'); 
		  
	echo (bloginfo('template_directory') . '/stylesheets/adminstyle.css" />');
}

add_action('admin_head', 'adminStyleMods');

// load category custom metaboxes 

  function load_category_metaboxes(){

    require_once( 'classes/tax-meta-class/Tax-meta-class/Tax-meta-class.php' );

    $category_img_metabox_config = array(
    
      'id' => 'yk_category_image',
      'title' => 'Category Image',
      'pages' => array('category'),
      'context' => 'normal',
      'local_images' => true,
      'use_with_theme' => get_stylesheet_directory_uri() . '/classes/tax-meta-class/Tax-meta-class'
    );

    $category_img_metabox = new Tax_Meta_Class( $category_img_metabox_config );

    $category_img_metabox->addImage( 'yk_category_image', array( 'name' => 'Image' ));
        
    $category_id = $_GET['tag_ID'] ? $_GET['tag_ID'] : get_queried_object()->term_id;

	$category_img_metabox->addRadio('yk_category_image_vertical_position', array( 'top' => 'Top', 'center' => 'Center', 'bottom' => 'Bottom'), array( 'name' => 'Vertical Image Position' ));

	$category_img_metabox->addRadio('yk_category_image_horizontal_position', array( 'left' => 'Left', 'center' => 'Center', 'right' => 'Right'), array( 'name' => 'Horizontal Image Position' ));

    $category_img_metabox->Finish();
  }

  if( is_admin() ) load_category_metaboxes();


/*  Enqueue Scripts   */

$templateURL= get_bloginfo('template_url'); 
$themeScripts = $templateURL . "/scripts/";

$enqueueable_js = array (

	"behavior" => array (
		"prefix" => "yk",
		"name" => "behavior",
		"filename" => "behavior.js",
		"url" => $themeScripts,
		"version" => "0.1",
		"footerLoad" => true
	),
	
	"tumblr" => array (
		"prefix" => "yk",
		"name" => "tumblr",
		"filename" => "share.js",
		"url" => "http://platform.tumblr.com/v1/",
		"version" => "1.0",
		"footerLoad" => true
	)
	
);

function javascript_enqueues() {

global $enqueueable_js;

	foreach ($enqueueable_js as $script) {
		
		$scriptAlias =  $script['prefix']."_".$script['name'];
		$scriptLocation = $script['url'].$script['filename'];
		$scriptVersion = $script['version'];
		$scriptPosition = $script['footerLoad'];
		
		if (!$script['dependables']) {
			$scriptDependables = "";
		} else {
			$scriptDependables = $script['dependables'];
		}
		
		wp_register_script (
		$scriptAlias, 
		$scriptLocation,
		$scriptDependables,
		$scriptVersion,
		$scriptPosition
		);
		
		wp_enqueue_script($scriptAlias);
	}
}

add_action('wp_enqueue_scripts', 'javascript_enqueues');


/* Contains all Custom Metabox Information */

$custom_metaboxes = array (

	/* Cover Photo Metabox */
	
	"coverPhoto" => array (
	
		"title" => "Cover Photo",
		
		"subtitle" => "Primary Image displayed on Post Previews",
		
		"key" => "cover_photo",
		
		"id" => "coverPhoto",
		
		"callback" => "display_cover_photo",
		
		"posttypes" => array ('post','young kings','fd'),
		
		"formfields" => array (
			
			"url" => array (
				"name" => "url",
				"label" => "Image Location",
				"input" => "text",
				"description" => "The full URL path to your desired image goes here"
			),
		
			"verticalQuickPosition" => array (
				"name" => "verticalQuickPosition",
				"label" => "Vertical Positioning",
				"input" => "select",
				"description" => "Which side would you want displayed? Top, Middle or Bottom?",
				"options" => array ("top", "middle", "bottom") 
			),
			
			"horizontalQuickPosition" => array (
				"name" => "horizontalQuickPosition",
				"label" => "Horizontal Positioning",
				"input" => "select",
				"description" => "Which side would you want displayed? Left, Center or Right?",
				"options" => array ("left", "center", "right") 
			)
		)
	
	),
	
	"nightlights" => array (
	
		"title" => "Nightlights",
		
		"subtitle" => "Post Source & Curation",
		
		"key" => "nightlights",
		
		"id" => "nightlights",
		
		"callback" => "display_nightlights",
		
		"posttypes" => "post",
		
		"formfields" => array (
		
			"sourceURL" => array (
				"name" => "sourceURL",
				"label" => "Link to Source",
				"input" => "text",
				"description" => "Where did you get this post's assets from?"
			),
			
			"linkText" => array (
				"name" => "linkText",
				"label" => "Link Title",
				"input" => "text",
				"description" => "What do you want the link text to be?"
			),
			
			"curate" => array (
				"name" => "curate",
				"label" => "Curate Post?",
				"input" => "radio",
				"description" => "Is this a special post you'd like to emphasize?",
				"options" => array ("yes", "no"),
				"option_default" => "no"
			),
		
		)
	
	)


);



function create_metabox() {

global $custom_metaboxes;
 
	foreach ($custom_metaboxes as $metabox_name => $metabox) {
	
		if (is_array($metabox['posttypes'])) {
			
			foreach ( $metabox['posttypes'] as $posttype) { 
				add_meta_box( 
				$metabox['id'], 
				$metabox['title'], 
				$metabox['callback'], 
				$posttype, 
				'advanced',
				'high', 
				$current_metabox = array( "data" => $metabox, "name" => $metabox_name )
				);
			}
		
		} else {
			add_meta_box( 
			$metabox['id'], 
			$metabox['title'], 
			$metabox['callback'], 
			$metabox['posttypes'], 
			'advanced', 
			'high', 
			$current_metabox = array( "data" => $metabox, "name" => $metabox_name )
			);
		
		}
	}

}


function display_cover_photo($post, $current_metabox) {

$metabox_name = $current_metabox['args']['name'];
$metabox = $current_metabox['args']['data'];
$key = $metabox['key'];

$postMeta = get_post_meta($post->ID, $key, true); ?>

<div class="metaboxWrap">
	
	<div class="metaboxTitle">
		<span><?php echo $metabox['title']; ?></span>
		<p><?php echo $metabox['subtitle'] ?></p>
	</div>
	
	<?php 
	/* Show Preview if URL is Set */
	
	if(!empty($postMeta['url'])) { 
	
	if ($postMeta['verticalQuickPosition'] == 'middle' ) {
		$verticalAlign = "center";
	} else {
		$verticalAlign = $postMeta['verticalQuickPosition'];
	}
	
	$horizontalAlign = $postMeta['horizontalQuickPosition'];
	?>
	
	<div class="metaboxImagePreview left" style="background-image:url(<?php echo $postMeta['url'] ?>); background-position: <?php echo ($verticalAlign." ".$horizontalAlign); ?>">
		
		<span>
		<p>Vertical: <strong><?php echo ucfirst($postMeta['verticalQuickPosition']); ?></strong><br />
		Horizontal: <strong><?php echo ucfirst($postMeta['horizontalQuickPosition']); ?></strong></p>
		</span>
		
	</div>
	
	<?php } 
	/* NONCE Security Feature */
	wp_nonce_field( plugin_basename(__FILE__), $key . '_wpnonce', false, true ); ?>
		
	<div class="tlImageControl right">
		
		<?php foreach ($metabox['formfields'] as $formfield) { 
				
		$fieldname = $formfield['name']; ?>
		
			<div class="form-field">
				<label for="<?php echo $fieldname; ?>"><?php echo $formfield['label']; ?></label>
				<p><?php echo $formfield['description']; ?></p>
				
				<?php 
				/* Switch to handle multiple forms of input */ 
				switch ($formfield['input']) { 
				
				case "text": ?>
					
					<input type="text" name="<?php echo $fieldname; ?>" value="<?php echo htmlspecialchars($postMeta[ $fieldname ]); ?>" />
									
				<?php break;
				case "select": ?>
				
					<select name="<?php echo $fieldname ?>" id="<?php echo $fieldname ?>">
					<?php foreach ($formfield['options'] as $option) { ?>
						
						<option value="<?php echo $option ?>"
						<?php if ( $postMeta[ $fieldname ] == $option ) { echo ' selected="selected"'; } ?>>
						
							<?php echo ucfirst($option); ?>
						
						</option>
					<?php } ?>
					</select>
					
				<?php break; } ?>
			</div>
		
		
		
		
		<?php } ?>
	
	</div>
	
</div>



<?php }

function display_nightlights($post, $current_metabox) {

$metabox_name = $current_metabox['args']['name'];
$metabox = $current_metabox['args']['data'];
$key = $metabox['key']; 

$postMeta = get_post_meta($post->ID, $key, true); 
?>

<div class="metaboxWrap">
	
	<div class="metaboxTitle">
		<span><?php echo $metabox['title']; ?></span>
		<p><?php echo $metabox['subtitle'] ?></p>
	</div>
	
	<?php  
	/* NONCE Security Feature */
	wp_nonce_field( plugin_basename(__FILE__), $key . '_wpnonce', false, true ); ?>
		
	<div class="tlImageControl right">
		
		<?php foreach ($metabox['formfields'] as $formfield) { 
				
		$fieldname = $formfield['name']; ?>
		
			<div class="form-field">
				<label for="<?php echo $fieldname; ?>"><?php echo $formfield['label']; ?></label>
				<p><?php echo $formfield['description']; ?></p>
				
				<?php 
				/* Switch to handle multiple forms of input */ 
				switch ($formfield['input']) { 
				
				case "text": ?>
					
					<input type="text" name="<?php echo $fieldname; ?>" 
					value="<?php echo htmlspecialchars($postMeta[ $fieldname ]); ?>" />
									
				<?php break;
				
				case "radio": ?>
				
					<?php foreach ($formfield['options'] as $option) { ?>
						
						<label><?php echo ucfirst($option); ?></label>
						<input type="radio" name="<?php echo $formfield['name']; ?>" value="<?php echo $option ?>"
						
						<?php 
						if ( $postMeta[ $fieldname ] == $option ) {  
						echo 'checked'; 
						}
						
						if ( !$postMeta[ $fieldname ] && $option == $formfield['option_default'] ) {
						echo 'checked'; 
						} ?> />
						
							
						<?php } break; 
						} ?>
				</div>
						
						<?php } ?>
								
		
		
		</div>
	
</div>

<?php }

function save_metabox ( $post_id ) {
global $custom_metaboxes, $post;

foreach ($custom_metaboxes as $metabox_name => $metabox) {

	$key = $metabox['key'];
	
	foreach ( $metabox['formfields'] as $formfield ) {
		$postdata[ $formfield['name'] ] = $_POST[ $formfield['name'] ];
	}
	
	// verify if this is an auto save routine. 
	// If it is our form has not been submitted, so we dont want to do anything
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { 
		return $post_id;
	}
	
	// verify this came from the our screen and with proper authorization,
	// because save_post can be triggered at other times

	if ( !wp_verify_nonce( $_POST[ $key . '_wpnonce'], plugin_basename( __FILE__ ) ) ) {
		return $post_id;
	}
	
	if ( !current_user_can( 'edit_post', $post_id) ){ 
		return $post_id;
	}
	
	update_post_meta ($post_id, $metabox['key'], $postdata);
}
}

add_action ('admin_menu', 'create_metabox' );
add_action ('save_post', 'save_metabox' );


$custom_posttypes = array (

	'YK' => array (
	
		'labels' => array (
			'name' => 'YK Posts',
			'singular_name' => 'Young Kings',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New YK',
			'all_items' => 'All YKs',
			'edit_item' => 'Edit YK',
			'new_item' => 'New YK',
			'view_item' => 'View YK',
			'search_items' => 'Search YK',
			'not_found' => 'Found Nothing',
			'not_found_in_trash' => 'Found Nothing in the Trash',
			),
		
		'args' => array (
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array('title','editor','thumbnail','comments'),
			'has_archive' =>true
		)
	),
	
	'FD' => array (
		'labels' => array (
			'name' => 'FD Profiles',
			'singular_name' => 'FD',
			'add_new' => 'Add New',
			'add_new_item' => 'Add New Profile',
			'all_items' => 'All Profiles',
			'edit_item' => 'Edit Profile',
			'new_item' => 'New Profile',
			'view_item' => 'View Profile',
			'search_items' => 'Search FD',
			'not_found' => 'Found Nothing',
			'not_found_in_trash' => 'Found Nothing in the Trash'
			),
		
		'args' => array (
			'public' => true,
			'publicly_queryable' => true,
			'show_ui' => true,
			'query_var' => true,
			'rewrite' => true,
			'capability_type' => 'post',
			'hierarchical' => false,
			'menu_position' => 5,
			'supports' => array('title','editor','thumbnail','comments')
		)
	)

);

function create_posttypes() {

global $custom_posttypes;
 
foreach ($custom_posttypes as $posttype) {

	$posttype['args']['labels'] = $posttype['labels']; 

	register_post_type( $posttype['labels']['singular_name'] , $posttype['args'] );
	
}

flush_rewrite_rules( false );
}

add_action('init','create_posttypes');	

 /*
 ________________________________________________
	
		Make Custom Post-Types Searchable
 ________________________________________________
 */
 
function searchAll( $query ) {
 if ( $query->is_search ) { $query->set( 'post_type', array( 'post', 'YK Posts', 'FD Profiles' )); }
 return $query;
}
add_filter( 'the_search_query', 'searchAll' );

/*-----------------------------------------------------------------------------
							Edit Comments
-----------------------------------------------------------------------------*/ 

function list_pings($comment, $args, $depth) {
	// this just globalizes the comment information
       $GLOBALS['comment'] = $comment;
?>
        <div id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
<?php }

// this adds a filter for the comments count
add_filter('get_comments_number', 'comment_count', 0);
// function for the comments count
function comment_count( $count ) {
	global $id;
	$get_comments= get_comments('post_id=' . $id);
	$comments_by_type = &separate_comments($get_comments);
	return count($comments_by_type['comment']);
}

// this is the actual function that formats the comments.
function format_comment($comment, $args, $depth) {
   $GLOBALS['comment'] = $comment; 
   // below helps determine if a given comment has a parent (so it can be designated as a reply, and what it's relpying to)
   $id = get_comment_ID();
   $info = get_comment($id);
   $parent = $info->comment_parent; 
   if($args['has_children']) $class = "parent ";
   if($parent > 0) $class .= "reply ";  
   $class .= 'clear'; ?>

   <div id="comment-<?php comment_ID(); ?>" <?php comment_class($class);?>>
     
	 
	<div class="commentAuthor">
   <?php // the avatar info
   echo get_avatar($comment,$size='75' ); ?>
   <?php // comment author link
   printf(__('%s'), get_comment_author_link()) ?>
   </div>
   
   
   <div class="commentDetails">
   <?php
   if ( $comment->comment_parent ) {
	$parent = get_comment( $comment->comment_parent );
	$parent_link = esc_url( get_comment_link( $comment->comment_parent ) );
	printf( '<div class="childComment">Response to <a href="%1$s">%2$s</a>.</div>', $parent_link, $parent->comment_author );
} ?>
   <span class="commentPostTime">
     <?php // comment date
    printf(__('%1$s at %2$s'), get_comment_date(),  get_comment_time()) ?>
    </span>
	
	<?php // comment edit link
    edit_comment_link(__('edit')) ?>
    
	<?php // comment reply link
           comment_reply_link(array_merge( $args, array('add_below' => 'div-comment', 'depth' => $depth, 'max_depth' => $args['max_depth']))) ?>  
     
	 <?php // if the comment is awaiting moderation, this is what you see.
   if ($comment->comment_approved == '0') : ?>
   <span class="underModeration"><?php _e('Your comment is awaiting moderation.') ?></span>
   <?php endif; 
   
    
	 // actual text of comment
     comment_text(); ?> 
  
  </div>
   
<?php } 

function widget_builder(){
	
	register_sidebar ( array (
	'id' => 'tweet_area',
	'name' => 'tweet_area'
	)
	);
	
}

add_action('widgets_init', 'widget_builder');

// create theme settings page
	add_action( 'admin_menu', 'create_theme_settings_page' );

	function create_theme_settings_page(){

		add_menu_page( 'Theme Settings', 'Theme Settings', 'administrator', 'theme-settings', 'render_theme_settings_page' );

		add_action('admin_init', 'register_theme_settings');
    
    wp_enqueue_media();
    wp_enqueue_style( 'theme-settings-style', get_stylesheet_directory_uri() . '/stylesheets/theme-settings-style.css', array(), '0.0.1' );
    wp_enqueue_script( 'theme-settings-behavior', get_stylesheet_directory_uri() . '/scripts/theme-settings-behavior.js', array('jquery'), '0.0.1' );

		function register_theme_settings(){

			register_setting( 'yknightlights-theme', 'logo_url' );
			register_setting( 'yknightlights-theme', 'home_card_url' );
		}
	}

	function render_theme_settings_page(){ 
		?>

		<div id="theme-settings" class="wrap">

			<h1>Theme Settings</h1>

	    <?php submit_button( 'Save Changes', 'right button-primary' ); ?>

			<form method="post" action="options.php">
		    
		    <?php 
		    	settings_fields( 'yknightlights-theme' );
		    	do_settings_sections( 'yknightlights-theme' ); 

		    	// required variables
			    	$logo_url = esc_attr( get_option('logo_url') );
			    	$home_card_url = esc_attr( get_option('home_card_url') );
		    ?>

				<div class="row">
					<div class="title">Logo</div>
					<div class="content">

						<img id="logo-preview" class="<?php echo( !$logo_url ? 'hidden' : '' ); ?>" src="<?php echo $logo_url; ?>">

						<input id="image-url" name="logo_url" value="<?php echo $logo_url; ?>">
						<div id="upload-button" class="button">Choose Image</div>
					</div>
				</div>

				<div class="row">
					<div class="title">Home Card Image</div>
					<div class="content">

						<img id="home-card-preview" class="<?php echo( !$home_card_url ? 'hidden' : '' ); ?>" src="<?php echo $home_card_url; ?>">

						<input id="home-card-url" name="home_card_url" value="<?php echo $home_card_url; ?>">
						<div id="choose-home-card" class="button">Choose Image</div>
					</div>
				</div>

				<div class="row">
					<div class="content">    
				    <?php submit_button(); ?>
					</div>
				</div>

			</form>
		</div>

		<?php
	}

// ensure media uploader for logo (on theme settings page) accepts images only
  add_filter('upload_mimes','restrict_theme_settings_upload_to_images');
	
	function restrict_theme_settings_upload_to_images( $mimes ){

		// ensure it's theme settings logo upload
			if( !$_REQUEST['upload-source'] || $_REQUEST['upload-source'] !== 'theme-settings' ) return $mimes;
			if( !$_REQUEST['upload-type'] || $_REQUEST['upload-type'] !== 'image-only' ) return $mimes;
		
		// set permitted mime types to images only
			$mimes = array(
	      'jpg|jpeg|jpe' => 'image/jpeg',
	      'gif' => 'image/gif',
	      'png' => 'image/png'
			);

		return $mimes;
	}

?>