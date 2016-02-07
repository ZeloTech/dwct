<?php get_header(); ?>
	
    <?php if(!is_paged() && (get_option($shortname.'_featured_slider_enable') == 'on')) { ?>

    <div id="slides" class="clearfix">
        <?php
			$args=array(
				'post_type'=>'coupon',
				'posts_per_page' => get_option($shortname.'_featured_posts_num'),
				'post_status' => 'publish',
				'orderby' => 'DESC',
				'meta_query' => array(
					array(
						'key' => 'coupon_featured',
						'value' => 1
					)
				)
			);
			
			$recent = new WP_Query($args);

			while($recent->have_posts()) : $recent->the_post();
			
			$terms = get_the_terms( $post->ID, 'coupon_store' );
			
			if($terms <> '') { 
				foreach ( $terms as $term ) {
					$store_id = $term->term_id;
					$store_name = $term->name;
					$store_url = get_term_link( $term, 'coupon_store' );
				}
			}
			$thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'featured-thumbnail');
			$attachment_image=wp_get_attachment_image_src( get_post_meta($post->ID, 'print_imageid', true) );
			$junkie_store_image_preview = junkie_get_store_image_url($store_id, 'term_id', 100);
			if( is_array($thumbnail_image) ):
				$print_image=$thumbnail_image[0];
			else:
				$print_image=$junkie_store_image_preview ;
			endif;
		?>
			    
			<div class="slide clearfix">
			
				<div class="slide-thumbnail">
					<a href="<?php the_permalink(); ?>"><img src="<?php echo $print_image; ?>" alt="<?php the_title(); ?>" /></a>	      
				</div><!-- .slide-thumbnail -->
						
				<div class="slide-content">
				
					<h1 class="entry-title"><a href="<?php the_permalink(); ?>" rel="bookmark"><?php the_title(); ?></a></h1>
					<div class="entry-excerpt">
						<?php tj_content_limit('200'); ?>
					</div><!-- .entry-excerpt -->
					<a class="btn" href="<?php the_permalink(); ?>" rel="bookmark"><?php _e('Read More','junkie'); ?></a>
					<span class="or"><?php _e('or','junkie'); ?></span>
					<a href="<?php echo $store_url; ?>"><?php _e('View all','junkie'); ?> <?php echo $store_name; ?> <?php _e('coupons','junkie'); ?></a>
				</div><!-- .slide-content -->
				
			</div><!-- .slide -->
		
		<?php endwhile; ?>
		          
	</div><!-- #slides -->

    <?php } ?>

	<div id="content" class="content-loop">

	    <div class="content-heading clearfix"> 
	    	<h3><?php _e('New Coupons','junkie'); ?></h3>
	    	<span><?php _e('There are currently','junkie'); ?> <strong><?php echo wp_count_posts('coupon')->publish; ?></strong> <?php _e('active coupons','junkie'); ?></span>
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

	</div><!-- #content -->
		
<?php get_sidebar(); ?>
<?php get_footer(); ?>