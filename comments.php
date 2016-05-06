<?php // Do not delete these lines
	  if (!empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']))
		die ('Please do not load this page directly. Thanks!');

	if ( post_password_required() ) { 
		 // message for notifying of password-protected posts
		return;
	}
?>


<?php if (have_comments()) : ?>

<h2 class="commentHeader">
<?php

printf( _n( 'One Comment on &ldquo;%2$s&rdquo;', '%1$s Comments on &ldquo;%2$s&rdquo;', get_comments_number() ),
number_format_i18n( get_comments_number() ), '<span>' . get_the_title() . '</span>' );
?>
</h2>

<div id="commentlist">
<?php wp_list_comments('type=comment&callback=format_comment&style=div'); ?>
</div>

<div class="navigation">
<div class="alignleft"><?php previous_comments_link() ?></div>
<div class="alignright"><?php next_comments_link() ?></div>
</div>
	
<?php endif; ?>


<?php 
/* If comments are closed, let people know */

if ( ! comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) { ?>
<div class="commentHeader center">Comments are closed</div>

<?php } 
/* If not, invite them to join the convo */

elseif ( comments_open() && ! is_page() && post_type_supports( get_post_type(), 'comments' ) ) {  ?>
<div id="commentStatus" class="center">

<?php if(0==get_comments_number()){
echo ('Start '); 
} else {
echo ('Join '); }  ?>the Conversation</div>

<?php 

$fields =  array(
					'author' => '<div><label for="author">Name<span class="highlight"> *</span></label><input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '"/></div>',
					'email'  => '<div><label for="email">Email<span class="highlight"> *</span></label><input id="email" name="email" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '"/></div>',
					'url'    => '<div><label for="url">Website</label><input id="url" name="url" type="text" value="' . esc_attr( $commenter['comment_author_url'] ) . '"/></div>',
);

	  $theme_defaults = array(
						'fields' => apply_filters( 'comment_form_default_fields', $fields ),
						'comment_field' => '<div><label for="Comment">Comment<span class="highlight"> *</span></label><textarea id="comment" name="comment"></textarea></div>',
						'must_log_in' => '<p class="must-login">' .  sprintf( __( '<a href="%s">Log In</a> to Join the Conversation' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
						'logged_in_as' => '<p class="loggedin">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out?</a>' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( $post_id ) ) ) ) . '</p>',
						'comment_notes_before' => '<p>Asterisked fields (<span class="highlight">*</span>) are Required</p>',
						'comment_notes_after' => '',
						'id_form' => 'commentpost',
						'id_submit' => 'submit',
						'title_reply' => __( '' ),
						'title_reply_to' => __( 'Replying to %s' ),
						'cancel_reply_link' => __( 'Cancel Reply' ),
						'label_submit' => __( 'Add Comment' ),
);

comment_form($theme_defaults);
} ?>

