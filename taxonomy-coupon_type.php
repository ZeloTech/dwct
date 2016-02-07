<?php get_header(); ?>

	<div id="content" class="content-loop" role="main">
	<?php
	$taxonomy='coupon_type';
	$term = get_queried_object();
	
?>
		<div class="page-heading">
			<h1 class="page-title"><?php _e('All','junkie'); ?> <strong><?php echo $term->name; ?><?php _e('s','junkie'); ?></strong></h1>
		</div><!-- .page-heading -->

	    <div class="content-heading clearfix"> 
	    	<h3><?php _e('Active coupons','junkie'); ?></h3>
	    </div><!-- .content-heading -->
	    
		<?php
	    	if ( have_posts() ) :
	    	while(have_posts()) : the_post();
				get_template_part( 'content');
			endwhile;
			else :
				get_template_part( 'coupon','none'); 
			endif;
			wp_reset_query();
		?>
		
		<?php 
			junkie_pagination();  
		?>
		
		
    <div class="content-heading clearfix"> 
	    	<h3><?php _e('Unreliable coupons','junkie'); ?></h3>
	    </div><!-- .content-heading -->

		<?php
		
			$term_slug = get_query_var('term');
			$args=array(
				'post_type'=>'coupon',
				'posts_per_page' => 5,
				'orderby' => 'DESC',
				'meta_query' => array(
					array(
						'key' => 'expire_date',
						'value' => current_time('mysql'),
						'compare' => '<',
						'type' => 'DATE'
					)
				),				
				'tax_query' => array(
					array(
						'taxonomy' => 'coupon_type',
						'field' => 'slug',
						'terms' => $term_slug
					)				
				)
			);
			
			$recent = new WP_Query($args);

		    if ( $recent->have_posts() ) :
				while($recent->have_posts()) : $recent->the_post();
					get_template_part( 'content');
				endwhile;
				wp_reset_query();
			else :
				get_template_part( 'coupon', 'none' );
			endif;
		?>

	</div><!-- #content -->
		
<?php get_sidebar(); ?>
<?php get_footer(); ?>
