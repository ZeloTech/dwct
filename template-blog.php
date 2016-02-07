<?php 
// Template Name: Blog
?>

<?php get_header(); ?>
		
<div id="content" class="content-loop">

    <div class="content-heading clearfix">
    	<h3><?php the_title(); ?></h3>
    	<span><?php _e('There are currently','junkie'); ?> <strong><?php echo wp_count_posts('post')->publish; ?></strong> <?php _e('posts','junkie'); ?></span>
    </div><!-- content-heading -->
    	
	<?php
		$current = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args=array(
			'post_type'=>'post',
			'posts_per_page' => get_option("posts_per_page"),
			'paged'=>$current,
			'order'=>'DESC'
		);
	    $recent = new WP_Query($args);
	    while($recent->have_posts()) : $recent->the_post();
    		get_template_part( 'content', 'post' ); 
		endwhile;
	?>
	
	<?php junkie_pagination($recent->max_num_pages, $recent->query_vars['paged']); ?>	
	
</div><!-- #content .content-loop -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>
