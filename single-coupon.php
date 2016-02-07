<?php

get_header();

$view_num=get_post_meta( $post->ID, "view_point", true );
update_post_meta($post->ID,"view_point",$view_num+1);
 
?>

	<div id="content" class="page-content">
	
		<?php while ( have_posts() ) : the_post(); ?>
	
			<?php get_template_part( 'content' ); ?>
			<?php echo do_shortcode('[mc4wp_form]');?>
			<?php comments_template('', true);  ?> 	
		  		
		<?php endwhile; ?>

		<script>jQuery(".comment-reply-link").attr('onclick','');</script>

	</div><!-- #content .page-content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>