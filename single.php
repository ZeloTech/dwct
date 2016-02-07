<?php get_header(); ?>

	<div id="content" class="page-content">
	
		<?php while ( have_posts() ) : the_post(); ?>
			
			<?php get_template_part( 'content', 'post' ); ?>
			<?php echo do_shortcode('[mc4wp_form]');?>
			<?php if(get_option($shortname.'_show_post_comments') == 'on') { ?>
				<?php comments_template('', true);  ?> 	
		  	<?php } ?>
		  				
		<?php endwhile; ?>
	
	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>