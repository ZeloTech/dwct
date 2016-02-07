<?php 
// Template Name: Coupon Categories
?>

<?php

// get all the coupon categories except for child cats
$categories = get_terms('coupon_cat', array('hide_empty' => 0, 'child_of' => 0, 'pad_counts' => 0, 'app_pad_counts' => 1));
$list = '';
$groups = array();

if ($categories && is_array($categories)) {

	foreach($categories as $key => $value)
    if($value->parent != 0)
		  unset($categories[$key]);
	
	foreach($categories as $category)
		$groups[mb_strtoupper(mb_substr($category->name, 0, 1))][] = $category;
	
	if (!empty($groups)) :
	
		foreach($groups as $letter => $categories) {
			$list .= "\n\t" . '<h2 class="category-title">' . apply_filters('the_title', $letter) . '</h2>';
			$list .= "\n\t" . '<ul class="category-list clearfix">';
			
			foreach($categories as $category)
				$list .= "\n\t\t" . '<li><a href="' . get_term_link($category, APP_TAX_STORE) . '">' . apply_filters('the_title', $category->name) . '</a> (' . intval($category->count) . ')</li>';
				
			$list .= "\n\t" . '</li></ul>';
		}
		
	endif;
	
} else {

	$list .= "\n\t" . '<p>' . __( 'Sorry, but no coupon categories were found.', APP_TD ) .'</p>';
	
}
?>

<?php get_header(); ?>

	<div id="content" class="page-content">
	
	    <h1 class="page-title"><?php _e( 'View Coupon by Category', 'junkie' ); ?></h1>
	    
		<?php while ( have_posts() ) : the_post(); ?>
		
		    <div class="entry-content">
		    
		    	<?php the_content(); ?>

				<?php wp_link_pages(array('before' => '<p><strong>'.__('Pages:', 'junkie').'</strong> ', 'after' => '</p>', 'next_or_number' => 'number')); ?>		    	
		    	<?php edit_post_link( __('Edit', 'junkie'), ' <div class="edit-post">( ', ' )</div>' ); ?>
		    	
		    </div><!-- .entry-content -->
		    
		<?php endwhile; ?>
		
	    <div class="text-box">
	    
	        <?php print $list; ?>
	        
	    </div><!-- .text-box -->
	    
	</div><!-- #content -->

<?php get_sidebar(); ?>
<?php get_footer(); ?>

