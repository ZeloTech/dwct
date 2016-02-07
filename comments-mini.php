<div class="comments-mini">
    <div class="comments-mini-text">
	    <?php echo _e( 'Want to say something?','junkie' );?> <a class="fancybox" href='<?php echo admin_url("admin-ajax.php"); ?>?action=comment_mini_post&id=<?php echo $post->ID; ?>' ><strong><?php echo _e( 'Add Comment','junkie' );?></strong></a>&nbsp;
	    <span class="close-comment"></span>
    </div><!-- .comments-mini-text -->

	<?php
	// Do not delete these lines
	if ( !empty($_SERVER['SCRIPT_FILENAME']) && 'comments.php' == basename($_SERVER['SCRIPT_FILENAME']) )
	    die( __( 'Please do not load this page directly. Thanks!', 'junkie' ) );
	    if ( post_password_required() ) :
	?>
	
	<p class="nopassword"><?php _e( 'This post is password protected. Enter the password to view any comments.', 'junkie' ); ?></p>
	
	<?php
			return;
		endif;
	/*-----------------------------------------------------------------------------------*/
	/*	Display the Comments
	/*-----------------------------------------------------------------------------------*/
	?>

    <?php if ( have_comments() ) : ?>
	    <div class="drop-comment" >	    
		        <ul class="comments-mini-<?php echo $post->ID; ?> comments-mini-list">
					<?php 
						wp_list_comments( 'type=comment&callback=tj_comment_mini' ,get_comments(array('post_id' =>$post->ID) ));
					?>
		        </ul>
	    </div><!-- .drop-comment -->	        
	<?php endif; ?>
    
</div><!-- .comments-mini -->

