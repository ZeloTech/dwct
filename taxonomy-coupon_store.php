<?php get_header(); ?>
	<div id="content" class="content-loop" role="main">
	
	<?php
	$taxonomy='coupon_store';
	$term = get_queried_object();
	//get my store.
	$store_obj = get_the_terms( $post->ID, 'coupon_store' );
	if($store_obj <> '') { 
		foreach ( $store_obj as $element ) {
			$store_id = $element->term_id;
			$store_name = $element->name;
			$store_description = $element->description;
			$store_count = $element->count;
			$store_url = get_term_link( $element, 'coupon_store' );
		}
	}
	$store_url = get_metadata('coupon_store', $term->term_id, 'junkie_store_url', true);
	$store_aff_url = get_metadata('coupon_store', $term->term_id, 'junkie_store_aff_url', true);
	$store_image_preview = junkie_get_store_image_url($term->term_id, 'term_id', 100);
	?>
    	
	<header class="page-heading clearfix">	
    	
		<div class="entry-thumb-wrapper">
 			<a href="<?php echo $store_aff_url?$store_aff_url:$store_url; ?>" target="_blank"><img src="<?php echo $store_image_preview; ?>" class="store-thumbnail" alt="<?php the_title(); ?>" /></a>				
 		</div><!-- .entry-thumb-wrapper -->
 			<div class="entry-excerpt">
		    	<h1 class="entry-title"><?php $term = $wp_query->queried_object;
echo $term->name; ?></h1>
		    	<p class="store-url"><a href="<?php echo $store_aff_url?$store_aff_url:$store_url; ?>" target="_blank"><?php echo $store_url; ?></a></p> 			
				<p class="store-desc"><?php $term = $wp_query->queried_object;
echo $term->description; ?></p>
			</div><!-- .entry-excerpt -->
 	</header><!-- .page-heading -->

    <div class="content-heading clearfix"> 
    	<h3><?php _e('Active Coupons','junkie'); ?></h3>
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
    	<h3><?php _e('Unreliable Coupons','junkie'); ?></h3>
    </div><!-- .content-heading -->

	<?php
		$args=array(
			'post_type'=>'coupon',
			'posts_per_page' => 5,
			'post_status' => 'expire',
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
					'taxonomy' => 'coupon_store',
					'field' => 'slug',
					'terms' => $term->slug
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
