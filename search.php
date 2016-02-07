<?php get_header(); ?>

	<div id="content" class="content-loop">

		<div class="page-heading">
			<h1 class="page-title"><?php printf( __('Search Results for &ldquo;%s&rdquo;', 'junkie'), get_search_query()); ?></h1>
		</div><!-- .page-heading -->
		
	    <div class="content-heading clearfix"> 
	    	<h3><?php _e('Active Coupons','junkie'); ?></h3>
	    </div><!-- .content-heading -->
	    	
		<?php
			if( have_posts()) :
			while(have_posts()) : the_post();
				get_template_part('content');
			endwhile;
			else:
				get_template_part('coupon','none');
			endif;
	 	?>
	
		<?php 
			junkie_pagination();
		?>

	</div><!-- #content .content-loop -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>