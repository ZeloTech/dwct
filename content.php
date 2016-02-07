<?php

	$post_author=get_post_meta($post->ID, 'post_author_override', true);
	$coupon_type=get_post_meta($post->ID, 'coupon_type', true);
	
	$thumbnail_image = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'store-thumbnail');
	$attachment_image=wp_get_attachment_image_src( get_post_meta($post->ID, 'print_imageid', true) );
	$coupon_code=get_post_meta($post->ID, 'coupon_code', true);
	$coupon_aff_url=get_post_meta($post->ID, 'coupon_aff_url', true);
	
	//get my store.
	$store_terms = get_the_terms( $post->ID, 'coupon_store' );
	if($store_terms <> '') { 
		foreach ( $store_terms as $term ) {
			$store_id = $term->term_id;
			$store_name = $term->name;
			$store_url = get_term_link( $term, 'coupon_store' );
		}
	}
	$cat_terms = get_the_terms( $post->ID, 'coupon_cat' );
	$cat_str='';
	if($cat_terms <> '') { 	
		foreach( $cat_terms as $term ){
			$cat_id = $term->term_id;
			$cat_name = $term->name;
			$cat_url = get_term_link( $term, 'coupon_cat' );
			$cat_str=$cat_str.'<a href="'.$cat_url.'">'.$cat_name.'</a>';	
		}
	}
	
	$tag_terms = get_the_terms( $post->ID, 'coupon_tag' );
	$tag_str='';
	if($tag_terms <> '') { 	
		foreach( $tag_terms as $term ){
			$tag_id = $term->term_id;
			$tag_name = $term->name;
			$tag_url = get_term_link( $term, 'coupon_tag' );
			$tag_str=$tag_str.'<a href="'.$tag_url.'">'.$tag_name.'</a>';
		}
	}
	 
	$junkie_store_url = get_metadata('coupon_store', $store_id, 'junkie_store_url', true);
	$junkie_store_aff_url = get_metadata('coupon_store', $store_id, 'junkie_store_aff_url', true);
	$junkie_store_image_preview = junkie_get_store_image_url($store_id, 'term_id', 100);
	if( is_array($thumbnail_image) ):
		$print_image=$thumbnail_image[0];
	else:
		$print_image=$junkie_store_image_preview ;
	endif;
	
	if(!$coupon_aff_url)://aff_url none use store aff_url.
		if($junkie_store_aff_url):
			$coupon_aff_url=$junkie_store_aff_url;
		elseif($junkie_store_url):
			$coupon_aff_url=$junkie_store_url;
		endif;
	endif;
	
	if ($coupon_type=='Coupon Code'):
		$print_text=$coupon_code;
		$pop_info=' Click to Copy Code';
	endif;
	
	if ($coupon_type=='Printable Coupon'):
		$print_text='Print Coupon';
		$pop_info=' Click to Print Code';
		$coupon_aff_url=$attachment_image[0];
	endif;
	
	if ($coupon_type=='Promotion'):
		$print_text='Get Deal';
		$pop_info=' Click to Open Site ';
	endif;
	
	if ($coupon_type=='Credit Card'):
		if(strlen($coupon_code) > 0)
		{
		$print_text=$coupon_code;
		}
		else
		{
		$print_text='USE CARD';
		}
		$pop_info=' Click to Copy Code';
	endif;

	if ($coupon_type==''):
		$print_text='NOCODE';
		$pop_info=' Click to Open Site ';
	endif;
		
?>

<article id="post-<?php the_ID();?>" <?php post_class();?>>	

	<?php if(is_single()) { ?>
<?php
//if(is_single( array( 2292, 1781 ) ))
//{
include "include-this.php";
?>
		<h1 class="entry-title"><?php the_title(); ?></h1>

	<?php } ?>
		    	
	<div class="entry-thumb-wrapper">
	
		<a href="<?php echo $store_url; ?>" rel="bookmark"><img src="<?php echo $print_image; ?>" alt="<?php the_title(); ?>" class="store-thumbnail" /></a>
		
		<?php if( !is_single() && !is_tax('coupon_store') ) { ?>
			<a class="store-name" href="<?php echo $store_url; ?>"><?php echo $store_name; ?></a>
		<?php } ?>
		
	</div><!-- .entry-thumb-wrapper -->

	<div class="coupon-content">
	
		<?php if(!is_single()) { ?>
		
			<h1 class="entry-title"><a href="<?php echo get_permalink( $post->ID ); ?>"><?php the_title(); ?></a></h1>

		<?php } ?>
				
<div class="coupon clearfix">			
	<?php if(wp_is_mobile()) { ?>
			<label><?php echo $pop_info; ?></label>
			<div class="coupon-code"><a href="<?php echo $coupon_aff_url; ?>" target="_blank"><?php echo $print_text; ?></a></div>
	<?php } else { ?>
			<label><?php _e( 'Code:','junkie' );?></label>
            <div class="coupon-code" cid="<?php echo $post->ID; ?>" data-clipboard-text="<?php echo get_post_meta($post->ID, 'coupon_code', true); ?>"  pop-info='<?php echo $pop_info; ?>' aff-url='<?php echo $coupon_aff_url; ?>'><?php echo $print_text; ?></div>
	<?php } ?>
		</div><!-- .coupon -->

		<?php if(!is_single()) { ?>

			<div class="entry-excerpt">
				<?php tj_content_limit(100); ?>
			</div><!-- .entry-excerpt -->

		<?php } else { ?>

			<div class="entry-store">
				<a href="<?php echo $store_url; ?>"><?php echo $store_name; ?></a> <span>( <a href="<?php echo $junkie_store_aff_url?$junkie_store_aff_url:$junkie_store_url; ?>" target="_blank"><?php _e( 'visit store','junkie' );?></a> )</span>
			</div><!-- .entry-store -->
		
		<?php } ?>		
        
		<div class="entry-meta">
		
		<span class="entry-time">
			<?php

				$expire_date=strtotime(get_post_meta($post->ID,'expire_date',true));
				
				if($expire_date):
					if($interval>-86400&&$interval<0):
						echo "Expires: "."<span class=\"expired-color\">".date('M d, Y',strtotime(get_post_meta($post->ID,'expire_date',true)))."</span>";
					else:
						echo "Expires: ".date('M d, Y',strtotime(get_post_meta($post->ID,'expire_date',true))).'';
					endif;
				else:
					echo "Expires: unknown";
				endif;
				
			?>
		</span><!-- .entry-time -->
		
		<span class="entry-share">
		
			<a href="#" class="share"><?php _e( 'Share','junkie' );?></a>
			
			<section class="drop-section clearfix">
			
				<a target="_blank" rel="nofollow" href="https://twitter.com/share?url=<?php the_permalink(); ?>" class="share-twitter"><?php _e( 'Twitter','junkie' );?></a>
				
				<a target="_blank" rel="nofollow" href="https://www.facebook.com/sharer/sharer.php?u=<?php the_permalink(); ?>" class="share-facebook"><?php _e( 'Facebook','junkie' );?></a>
							
				<a target="_blank" rel="nofollow" href="https://plus.google.com/share?url=<?php the_permalink(); ?>" class="share-google-plus"><?php _e( 'Google Plus','junkie' );?></a>
				
				<a target="_blank" rel="nofollow" href="http://pinterest.com/pin/create/button/?url=<?php the_permalink(); ?>&media=<?php echo $print_image; ?>&description=<?php tj_content_limit('100'); ?>" class="share-pinterest" count-layout="horizontal"><?php _e( 'Pinterest','junkie' );?></a>
				
			</section><!-- .drop-section -->
			
		</span><!-- .entry-share -->

		<span class="entry-report">
		
			<a href="#" class="report"><?php _e( 'Report','junkie' );?></a>
			
			<section class="drop-section clearfix">
			
			    <select name="report_as">
			        <option value="<?php _e( 'Invalid Coupon Code','junkie' );?>"><?php _e( 'Invalid Coupon Code','junkie' );?></option>
			        <option value="<?php _e( 'Expired Coupon','junkie' );?>"><?php _e( 'Expired Coupon','junkie' );?></option>
			        <option value="<?php _e( 'Offensive Content','junkie' );?>"><?php _e( 'Offensive Content','junkie' );?></option>
			        <option value="<?php _e( 'Invalid Link','junkie' );?>"><?php _e( 'Invalid Link','junkie' );?></option>
			        <option value="<?php _e( 'Spam','junkie' );?>"><?php _e( 'Spam','junkie' );?></option>
			        <option value="<?php _e( 'Other','junkie' );?>"><?php _e( 'Other','junkie' );?></option>
			    </select>
			    
			    <input type="button" mid="<?php echo $post->ID; ?>" class="report-button" value="<?php _e( 'Submit','junkie' );?>">
			    
			</section><!-- .drop-section -->
			
		</span><!-- .entry-report -->
		
	</div><!-- .entry-meta -->

	</div><!-- .coupon-content -->
    
	<div class="coupon-ratings">
		<span class="thumbs-up" mid='<?php echo $post->ID; ?>' > 
			<?php 
			 if(get_post_meta($post->ID, 'likeit',true))
				echo get_post_meta($post->ID, 'likeit',true);
			 else
			 	echo 0;
			?>
	    </span><!-- .thumbs-up -->
	    
		<span class="thumbs-down" href="#" mid='<?php echo $post->ID; ?>' >
			<?php 
			 if(get_post_meta($post->ID, 'unlikeit',true))
				echo get_post_meta($post->ID, 'unlikeit',true);
			 else
			 echo 0;
			?>
	    </span><!-- .thumbs-down -->
	    
	    <div class="clear"></div>
	    
		<div class="comment-count">
		
			<?php if(!is_single()) { ?>
				<a href="#" class="make-comment"><?php _e( 'Comments','junkie' );?> (<?php echo get_comments_number( $post->ID );?>)</a>
			<?php } else { ?>
				<?php comments_popup_link( 'Comments (0)', 'Comments (1)', 'Comments (%)', 'comments-link', 'Comments Off'); ?>
			<?php } ?>
			
			<?php edit_post_link( __('Edit', 'junkie'), ' <div class="edit-post">( ', ' )</div>' ); ?>
					
		</div><!-- .comment-count -->
	
	</div><!-- .coupon-ratings -->
    
	<div class="clear"></div>
	
	<?php global $withcomments; $withcomments = 1; ?>
	
	<?php comments_template('/comments-mini.php'); ?>

	<?php if(is_single()) { ?>

		<div class="entry-content">
		
			<?php the_content(); ?>
<?php include 'include-this.php'; ?>		
			<div class="entry-footer">
					
				<?php if ($cat_str <> null ) { ?>
	            
		            <span class="entry-categories">
		            	<?php _e( 'Posted in:','junkie' );?> <?php echo $cat_str; ?> 		            
		            </span><!-- .entry-categories -->
	            
	            <?php } ?>
	
				<?php if ($tag_str <> null ) { ?>
				
					<span class="entry-tags">
		            	<?php _e( 'Tags:','junkie' );?> <?php echo $tag_str; ?>
		            </span><!-- .entry-tags -->
	            
	            <?php } ?>
	            
			</div><!-- .entry-footer -->           
            
		</div><!-- .entry-content -->
		
	<?php } ?>
		
</article><!-- #post -->