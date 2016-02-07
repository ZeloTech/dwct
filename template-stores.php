<?php 
// Template Name: Coupon Stores

// get all the stores
$args=array(
	'hide_empty' => 0,
	'child_of' => 0,
	'pad_counts' => 0,
);
$stores = get_terms('coupon_store',$args );
// get ids of all hidden stores 
$hidden_stores ='';
$list = '';
$groups = array();


if ($stores && is_array($stores) ) {

	// unset child stores
	foreach($stores as $key => $value)
    if($value->parent != 0)
		  unset($stores[$key]);
	
	foreach($stores as $store)
		$groups[mb_strtoupper(mb_substr($store->name, 0, 1))][] = $store;
	
	if (!empty($groups)) :
		foreach($groups as $letter => $stores) {
			$old_list = $list;
			$letter_items = false;
				$list .= "\n\t" . '<h2 class="store-title">' . apply_filters( 'the_title', $letter ) . '</h2>';
				$list .= "\n\t" . '<ul class="store-list clearfix">';
				
				foreach($stores as $store) {
					$active=get_metadata('coupon_store', $store->term_id, 'junkie_store_active', true);
					if($active=='yes'){
					//if (!in_array($store->term_id, $hidden_stores)) {
						$list .= "\n\t\t" . '<li><a href="' . get_term_link($store, 'coupon_store') . '">' . apply_filters('the_title', $store->name). '</a> (' . intval($store->count) . ')</li>';
			  $letter_items = true;
					}
				}	
			$list .= "\n\t" . '</ul>';
	
			if(!$letter_items)
			  $list = $old_list;
		}
	endif;
	
} else {

	$list .= "\n\t" . '<p>' . __( 'Sorry, but no stores were found.', 'junkie' ) .'</p>';
	
}
?>

<?php get_header(); ?>

	<div id="content" class="page-content">
	
	    <h1 class="page-title"><?php _e( 'View Coupon by Store', 'junkie' ); ?></h1>
	    
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

