<article id="post-<?php the_ID();?>" <?php post_class();?>>	
	
	<?php if(!is_single()) { ?>
	
		<a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_post_thumbnail('blog-thumbnail', array('class' => 'post-thumb')); ?></a>
		<h1 class="post-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
		
	<?php } else { ?>
	
		<?php the_post_thumbnail('blog-thumbnail', array('class' => 'post-thumb')); ?>		
		<h1 class="post-title"><?php the_title(); ?></h1>
		
	<?php } ?>
	
	<div class="post-meta">
		<?php the_author_posts_link(); ?> / <?php the_time('M d, Y'); ?></span> / <?php comments_popup_link( 'No Comment', '1 Comment', '% Comments', 'comments-link', 'Comments Off'); ?><?php edit_post_link( __('Edit', 'junkie'), ' / <span class="edit-post">', '</span>' ); ?>
	</div><!-- .post-meta -->

	<?php if(!is_single()) { ?>
	
		<div class="post-excerpt">
			<?php tj_content_limit('200'); ?>
		</div><!-- .post-excerpt -->

		<div class="read-more">
			<a href="<?php the_permalink(); ?>" rel="bookmark"><?php _e('Continue Reading &rarr;','junkie'); ?></a>
		</div><!-- .read-more -->		
		
	<?php } else { ?>	
		
		<div class="entry-content">
			<?php global $shortname; ?>
			<?php if(get_option($shortname.'_integrate_singletop_enable') == 'on') echo (get_option($shortname.'_integration_single_top')); ?>
		
			<?php the_content(); ?>
			
			<?php wp_link_pages( array( 'before' => '<div class="page-links"><span class="page-links-title">' . __( 'Pages:', 'junkie' ) . '</span>', 'after' => '</div>', 'link_before' => '<span>', 'link_after' => '</span>' ) ); ?>
			
			<?php if(get_option($shortname.'_integrate_singlebottom_enable') == 'on') echo (get_option($shortname.'_integration_single_bottom')); ?>							
			
	<?php if( is_single() ) { ?>

			<div class="entry-footer">
					
	            
		            <span class="entry-categories">
		            	<?php _e( 'Posted in:','junkie' );?> <?php the_category(', '); ?> 		            
		            </span><!-- .entry-categories -->
	            
	
				
					<span class="entry-tags">
		            	<?php the_tags( '' . __('Tags: ', 'junkie') . '', '', ''); ?>
		            </span><!-- .entry-tags -->
	            
	            
			</div><!-- .entry-footer -->    
				
	<?php } ?>	
			</div><!-- .entry-content -->
		
	<?php } ?>

</article><!-- #post-<?php the_ID(); ?> -->