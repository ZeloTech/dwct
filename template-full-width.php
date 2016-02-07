<?php
/*
Template Name: Full Width
*/
?>

<?php get_header(); ?>

		<div id="content" class="page-content">

			<h1 class="page-title"><?php the_title(); ?></h1>		
		
			<?php if (have_posts()) : while (have_posts()) : the_post(); ?>
				
			<div class="entry-content">
			
				<?php the_content(''); ?>
								
			</div><!-- .entry-content -->
			
			<?php edit_post_link('('.__('Edit', 'junkie').')', '<span class="entry-edit">', '</span>'); ?>
				
			<?php endwhile; endif; ?>
			
		</div><!-- #content .one-col -->

	
<?php get_footer(); ?>