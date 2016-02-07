<?php	
session_start();
set_time_limit(0);
$shortname = strtolower(wp_get_theme()->Name);
$is_open_submit = get_option($shortname."_open_submit");
$is_allow_newstore=get_option($shortname."_new_store_enable");
$is_verification=get_option($shortname."_verification_enable");
$is_newtags=get_option( $shortname."_new_tags_enable" );

if ( ! function_exists( 'wp_handle_upload' ) ){
	require_once( ABSPATH . 'wp-admin/includes/file.php' );
	require_once( ABSPATH . 'wp-admin/includes/image.php' );
}	

function fun_upload_attachment($element){
	  $wp_filetype = wp_check_filetype(basename($element["name"]), null );
	  
	  $uploadedfile = $element;
	  $upload_overrides = array( 'test_form' => false );
	  $movefile = wp_handle_upload( $uploadedfile, $upload_overrides );
	  if ( $movefile ) {
		  
		  $wp_upload_dir = wp_upload_dir();
		  $attachment = array(
			 'guid' => $wp_upload_dir['url'] . '/' . basename( $movefile["file"] ), 
			 'post_mime_type' => $wp_filetype['type'],
			 'post_title' => preg_replace('/\.[^.]+$/', '', basename( $movefile["file"] )),
			 'post_content' => '',
			 'post_status' => 'inherit'
		  );
	  
		  $attach_id = wp_insert_attachment( $attachment,$movefile["file"], $this_post_id );
		  $attach_data = wp_generate_attachment_metadata( $attach_id, $movefile["file"] );
		  wp_update_attachment_metadata( $attach_id, $attach_data );
		  
		  return $attach_id;
					  
	  } else {
		  return "upload image error .";
	  }
}
//------------------------------------------------------------------------------------------

if (isset($_POST['action']) && $_POST['action'] == 'post' && wp_verify_nonce($_POST['_wpnonce'],'new-post')&&$err=="") {

	if($is_open_submit == 'Registered users only'){
		if ( !is_user_logged_in() ){
			wp_redirect( home_url() . '/' );
			exit;
		}
	}else{
		$user_id = get_current_user_id();
	}
   
	$err = "";
	$attach_id = "";
	
	$verification	= sanitize_text_field($_POST['verification']);
	$post_title     = sanitize_text_field($_POST['post-title']);
	$post_content   = sanitize_text_field($_POST['post-content']);	
	$form_store		= sanitize_text_field($_POST['form-store']);
	$store_name     = sanitize_text_field($_POST['store-name']);
	$store_url    	= sanitize_text_field($_POST['store-url']);
	$form_cat 		= sanitize_text_field($_POST['form-cat']);
	$form_type 		= sanitize_text_field($_POST['form-type']);
	$form_code 		= sanitize_text_field($_POST['form-code']);
	$destination	= sanitize_text_field($_POST['destination']);
	$expiration		= sanitize_text_field($_POST['expiration']);//datetime
	$tags 			= explode(',',sanitize_text_field($_POST['tags']));
	$image_file=$_FILES;//upload file
	//echo ($image_file['store-img']["error"]);
	//print_r($image_file);
	//die();
	$file_type=array("image/gif","image/png","image/jpg","image/jpeg","image/pjpeg");
	 
	if ($is_verification=="on"&&$verification<>$_SESSION['coupon_submit_code']) {
	  $err .= __('Please besure the verification code.', 'junkie') . "<br />";
	  
	}
	if ($post_title == "") {
	  $err .= __('Please fill Portfolio Title.', 'junkie') . "<br />";
	}
	
	foreach($image_file as $element){
		if(!in_array($element["type"],$file_type)&&$element["error"]==0){
			$err .= __('images fotmat limit : "gif","jpg","jpeg","png"', 'junkie') . "<br />";
			break;
		}
	}
	if($err){
		return;
	}
        

	$post_args = array(
	  //'ID'             => [ <post id> ] 	 //Are you updating an existing post?
	  //'menu_order'     => [ <order> ] 	 //If new post is a page, it sets the order in which it should appear in the tabs.
	  'comment_status' => "open",	 		 //[ 'closed' | 'open' ]  'closed' means no comments.
	  'ping_status'    => "closed",  		 //[ 'closed' | 'open' ] // 'closed' means pingbacks or trackbacks turned off
	  //'pinged'         => [ ? ] //?
	  'post_author'    => $user_id,  		 //[ <user ID> ] //The user ID number of the author.
	  //'post_category'  => $cat,		 		 //[ array(<category id>, <...>) ] //post_category no longer exists, try wp_set_post_terms() for setting a post's categories
	  'post_content'   => $post_content,	 //[ <the text of the post> ] //The full text of the post.
	  //'post_date'      => [ Y-m-d H:i:s ]  //The time post was made.
	  //'post_date_gmt'  => [ Y-m-d H:i:s ]  //The time post was made, in GMT.
	  //'post_excerpt'   => $description,		 //[ <an excerpt> ] //For all your post excerpt needs.
	  //'post_name'      => [ <the name> ] 	 // The name (slug) for your post
	  //'post_parent'    => [ <post ID> ]    //Sets the parent of the new post.
	  //'post_password'  => [ ? ] //password for post?
	  'post_status'    => 'pending',		 //[ 'draft' | 'publish' | 'pending'| 'future' | 'private' | 'custom_registered_status' ] //Set the status of the new post.
	  'post_title'     => $post_title,		 //[ <the title> ] //The title of your post.
	  'post_type'      => 'coupon',			 //[ 'post' | 'page' | 'link' | 'nav_menu_item' | 'custom_post_type' ] //You may want to insert a regular post, page, link, a menu item or some custom post type
	  'tags_input'     => $tags,		//[ '<tag>, <tag>, <...>' ] //For tags.
	  //'to_ping'        => [ ? ] //?
	  //'tax_input'      => [ array( 'taxonomy_name' => array( 'term', 'term2', 'term3' ) ) ] // support for custom taxonomies. 
	); 
	$this_post_id = wp_insert_post( $post_args );
	wp_set_post_terms( $this_post_id, $form_cat,'coupon_cat') ;
	update_post_meta($this_post_id, 'coupon_type', $form_type);
	
	if($tags)
		foreach($tags as $tag_term )
			wp_set_object_terms( $this_post_id, $tag_term,'coupon_tag') ;
	/* coupon_store */
	if($store_name&&$store_name<>""){
		$term_id = wp_insert_term( $store_name,'coupon_store', array(
			'description'=> 'A share coupon for user.',
			'slug' => $store_name,
			'parent'=> 0
		));

		update_metadata( 'coupon_store', $term_id[term_id], 'junkie_store_url', $store_url );
		update_metadata( 'coupon_store', $term_id[term_id], 'junkie_store_aff_url', $store_url );
		update_metadata( 'coupon_store', $term_id[term_id], 'junkie_store_active', 'no' );
		if($image_file['store-img']["error"]==0){
			$element=$image_file['store-img'];
			$attach_id=fun_upload_attachment($element);
			update_metadata( 'coupon_store', $term_id[term_id], 'junkie_store_image_id', $attach_id );
		}
		
		wp_set_post_terms( $this_post_id, $term_id[term_id] ,'coupon_store') ; // set new coupon_store
	}else{
		wp_set_post_terms( $this_post_id, $form_store,'coupon_store') ; // set coupon_store
	}
	
	update_post_meta($this_post_id, 'coupon_code', $form_code);
	update_post_meta($this_post_id, 'coupon_aff_url', $destination);
	update_post_meta($this_post_id, 'expire_date', $expiration);
	
/* -------------------------- */
	if(is_array($image_file)){
		$ids="";
		$index =0;
		foreach($image_file as $element){
			if($element["error"]==0){
				if(in_array($element["type"],$file_type)){
					$attach_id=fun_upload_attachment($element);
					if(is_int($attach_id)){
							$ids=$attach_id.','.$ids;
							$ids = rtrim($ids, ',');
							update_post_meta($this_post_id, 'print_imageid', $ids);	
					}
				}
			}
			$index++;
		}
	}
	$post_sented = true;
}
?>  