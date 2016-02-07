<?php
add_theme_support( 'custom-header', $header_args );//need this for pass check.
add_theme_support( 'custom-background', $background_args );//need this for pass check.
add_theme_support( 'automatic-feed-links' );
add_editor_style();


/*-----------------------------------------------------------------------------------*/
/*	Custom Menus
/*-----------------------------------------------------------------------------------*/
function register_main_menus() {
	register_nav_menus(
		array(
			'primary-nav' => __( 'Primary Nav','junkie' ),
		)
	);
}

if (function_exists('register_nav_menus')) add_action( 'init', 'register_main_menus' );

/*-----------------------------------------------------------------------------------*/
/*	Register and deregister Scripts files	
/*-----------------------------------------------------------------------------------*/
if(!is_admin()) {
	//add_action( 'wp_print_scripts', 'my_deregister_scripts',8 );
	add_action('wp_head', 'my_register_scripts',100);
	add_action('wp_head', 'my_register_styles', 1);
}

function my_register_scripts() {
	
	/* enqueue scripts */
	wp_enqueue_script('jquery-ui', get_template_directory_uri().'/includes/js/jquery-ui-1.10.3.custom.min.js', false, '1.10.3');
	wp_enqueue_script('jquery-imagesloaded', get_template_directory_uri().'/includes/js/jquery.imagesloaded.min.js', false, '1.0');
	wp_enqueue_script('jquery-zeroclipboard', get_template_directory_uri().'/includes/js/ZeroClipboard.min.js', false, '1.2.1');	
	wp_enqueue_script('jquery-fancybox', get_template_directory_uri().'/includes/js/fancybox.js', false, '2.1.5');
	wp_enqueue_script('jquery-cookie', get_template_directory_uri().'/includes/js/jquery.cookie.js', false, '1.4.0');
	wp_enqueue_script('jquery-slidesjs', get_template_directory_uri().'/includes/js/jquery.slides.min.js', false, '3.0.3');			
	wp_enqueue_script('jquery-superfish', get_template_directory_uri().'/includes/js/superfish.js', false, '1.0');		
	wp_enqueue_script('jquery-custom', get_template_directory_uri().'/includes/js/custom.js', array("tj_shortcodes"), '1.0');
	
	if ( is_singular() && get_option('thread_comments') ) wp_enqueue_script( 'comment-reply' );
}

function my_register_styles() {
	global $shortname;
	/* enqueue styles */
	wp_enqueue_style( 'fancybox', get_template_directory_uri().'/includes/css/fancybox.css');
	wp_enqueue_style( 'jq-ui', get_template_directory_uri().'/css/jquery-ui.css');
	wp_enqueue_style( 'color', get_template_directory_uri().'/css/color-'.strtolower(get_option($shortname.'_theme_stylesheet')).'.css');
	if(get_option($shortname.'_layout') <> 'Fixed')  { 
		wp_enqueue_style( 'responsive', get_template_directory_uri().'/css/responsive.css');
	}
	wp_enqueue_style( 'custom', get_template_directory_uri().'/css/custom.css');	
}

add_action('pre_get_posts', 'themejunkie_pre_get_posts');
function themejunkie_pre_get_posts($query){
    if ( ( $query->is_home() ||  $query->is_search() || $query->is_tax() ) && $query->is_main_query() ) {

    	$meta_query = array(
				'relation'=>'OR',
				array(
					'key' => 'expire_date',
					'value' => current_time('mysql'),
					'compare' => '>=',
					'type' => 'DATE'
				),
				array(
					'key' => 'expire_date',
					'value' => '',
					'compare' => '='
				)
			);
			
    	$query->set('post_type', array( 'coupon'));
    	$query->set('meta_query', $meta_query );
    	
    }
    return $query;
}

/*-----------------------------------------------------------------------------------*/
/*	Comment Styling
/*-----------------------------------------------------------------------------------*/

if ( !function_exists( 'tj_comment' ) ) {
	function tj_comment($comment, $args, $depth) {
	
	    $isByAuthor = false;
	
	    if($comment->comment_author_email == get_the_author_meta('email')) {
	        $isByAuthor = true;
	    }
	
        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(($isByAuthor ? 'author-comment' : '')); ?> id="li-comment-<?php comment_ID() ?>">

            <div id="comment-<?php comment_ID(); ?>">
                <div class="line"></div>
                
                <?php echo get_avatar($comment,$size='36'); ?>
                
                <div class="comment-author vcard">
                    <?php printf(__('<cite class="fn">%s</cite> <span class="says">says:</span>', 'junkie'), get_comment_author_link()) ?>
                </div>

                <div class="comment-meta commentmetadata"><a href="<?php echo htmlspecialchars( get_comment_link( $comment->comment_ID ) ) ?>"><?php printf(__('%1$s at %2$s', 'junkie'), get_comment_date(),  get_comment_time()) ?></a><?php edit_comment_link(__('(Edit)', 'junkie'),'  ','') ?> / <?php comment_reply_link(array_merge( $args, array('depth' => $depth, 'max_depth' => $args['max_depth']))) ?></div>

                <?php if ($comment->comment_approved == '0') : ?>
                    <em class="moderation"><?php _e('Your comment is awaiting moderation.', 'junkie') ?></em>
                    <br />
                <?php endif; ?>

                <div class="comment-body">
                    <?php comment_text() ?>
                </div>

            </div>
	<?php
	}
}
if ( !function_exists( 'tj_comment_mini' ) ) {
	function tj_comment_mini($comment, $args, $depth) {
	
	    $isByAuthor = false;
	
	    if($comment->comment_author_email == get_the_author_meta('email')) {
	        $isByAuthor = true;
	    }
	
        $GLOBALS['comment'] = $comment; ?>
        <li <?php comment_class(($isByAuthor ? 'author-comment' : '')); ?> id="li-comment-<?php comment_ID() ?>">

            <div id="comment-<?php comment_ID(); ?>">
            	<div class="comment-avatar">
                <?php echo get_avatar($comment,$size='36'); ?>
            	</div>
				<div class="comment-content">
				<?php
                 if ($comment->comment_approved == '0') : 
				 	_e('Your comment is awaiting moderation.', 'junkie') ;
				 else:
				 	comment_text();
				 endif; ?>
			</div>
            <div class="comment-author">
                <?php echo get_comment_author(  $comment->comment_ID ); ?>, <?php printf(__('%1$s at %2$s', 'junkie'), get_comment_date(),  get_comment_time()) ?> <?php edit_comment_link(__('(Edit)', 'junkie'),'  ','') ?> 
            </div>

            </div>
	<?php
	}
}

/* Comment seperated Pings Styling */
if ( !function_exists( 'tj_list_pings' ) ) {
	function tj_list_pings($comment, $args, $depth) {
	    $GLOBALS['comment'] = $comment; ?>
		<li id="comment-<?php comment_ID(); ?>"><?php comment_author_link(); ?>
		<?php 
	}
}


/*-----------------------------------------------------------------------------------*/
/*	string_limit
@str
@start
@width
@trimmarker
expr: echo fun_string_limit(get_the_title(),0,60,'...');
/*-----------------------------------------------------------------------------------*/

function fun_string_limit($str ,$start ,$width ,$trimmarker ){
	$output = trim(preg_replace('/^(?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$start.'}((?:[\x00-\x7F]|[\xC0-\xFF][\x80-\xBF]+){0,'.$width.'}).*/s','\1',$str));
	return $output.$trimmarker;
}

/*-----------------------------------------------------------------------------------*/
/*	Disable Autosave WP3.0+
/*-----------------------------------------------------------------------------------*/
remove_action('pre_post_update', 'wp_save_post_revision');
add_action('wp_print_scripts','disable_autosave');
function disable_autosave() {
	wp_deregister_script('autosave');
}

/*-----------------------------------------------------------------------------------*/
/*	Get Limit Excerpt or content
@max_char
@more_link_text
@stripteaser
/*-----------------------------------------------------------------------------------*/
function tj_content_limit($max_char, $more_link_text = '', $stripteaser = 0) {
	$excerpt = get_the_excerpt();
    $excerpt?$content =$excerpt:$content = get_the_content($more_link_text, $stripteaser);
    $content = apply_filters('the_content', $content);
    $content = str_replace(']]>', ']]&gt;', $content);
    $content = strip_tags($content);

   if (strlen($_GET['p']) > 0) {
      echo "";
      echo $content;
      echo "...";
   }
   else if ((strlen($content)>$max_char) && ($espacio = strpos($content, " ", $max_char ))) {
        $content = substr($content, 0, $espacio);
        $content = $content;
        echo "";
        echo $content;
        echo "...";
   }
   else {
      echo "";
      echo $content;
   }
}
/*-----------------------------------------------------------------------------------*/
/* function get ip
/*-----------------------------------------------------------------------------------*/
function fun_get_real_ip(){
	$ip=false;
	if(getenv($_SERVER["HTTP_CLIENT_IP"])){
		$ip = getenv($_SERVER["HTTP_CLIENT_IP"]);
	}
	else if (getenv($_SERVER['HTTP_X_FORWARDED_FOR'])) {
		$ips = explode (", ", getenv($_SERVER['HTTP_X_FORWARDED_FOR']));
		if ($ip) { array_unshift($ips, $ip); $ip = FALSE; }
			for ($i = 0; $i < count($ips); $i++) {
				if (!eregi ("^(10|172\.16|192\.168)\.", $ips[$i])) {
					$ip = $ips[$i];
					break;
				}
			}
	}
	if(getenv($_SERVER["REMOTE_ADDR"]))
		$islocal=getenv($_SERVER["REMOTE_ADDR"]);
	else
		$islocal="127.0.0.1";
	return ($ip ? $ip : $islocal );
}

/*-----------------------------------------------------------------------------------*/
/* action ajax
/*-----------------------------------------------------------------------------------*/
//reset under code.
/*delete_post_meta_by_key( 'likeit' );
delete_post_meta_by_key( 'unlikeit' );
delete_post_meta_by_key( 'like_ip' );
*/
add_action('like_me', 'function_like_me');
function function_like_me($post_id){	 
	if(get_post_meta($post_id,'likeit', true)){
		$data=get_post_meta($post_id, 'likeit',true);
		$data++;
		update_post_meta($post_id, 'likeit', $data);
		add_post_meta($post_id, 'like_ip', fun_get_real_ip() );
		echo get_post_meta($post_id, 'likeit',true);
	}else{
		add_post_meta( $post_id, 'likeit', 1 );
		add_post_meta( $post_id, 'like_ip',fun_get_real_ip() );
		echo "1";
	}
}
add_action('unlike_me', 'function_unlike_me');
function function_unlike_me($post_id) {
	if(get_post_meta($post_id,'unlikeit', true)){
		$data=get_post_meta($post_id, 'unlikeit',true);
		$data++;
		update_post_meta($post_id, 'unlikeit', $data);
		add_post_meta($post_id, 'like_ip', fun_get_real_ip() );
		echo get_post_meta($post_id, 'unlikeit',true);
	}else{
		add_post_meta( $post_id, 'unlikeit', 1 );
		add_post_meta( $post_id, 'like_ip',fun_get_real_ip() );
		echo "1";
	}
}
add_action('click_point', 'function_click_point');
function function_click_point($post_id) {
	if(get_post_meta($post_id,'click_point', true)){
		$data=get_post_meta($post_id, 'click_point',true);
		$data++;
		update_post_meta($post_id, 'click_point', $data);
	}else{
		add_post_meta( $post_id, 'click_point', 1 );
	}
	return;
}
add_action('view_point', 'function_view_point');
function function_view_point($post_id) {
	if(get_post_meta($post_id,'view_point', true)){
		$data=get_post_meta($post_id, 'view_point',true);
		$data++;
		update_post_meta($post_id, 'view_point', $data);
	}else{
		add_post_meta( $post_id, 'view_point', 1 );
	}
	return;
}
add_action('report_issue', 'function_report_issue',10, 2 );
function function_report_issue($post_id,$ras) {
	add_post_meta( $post_id, 'report_issue',$ras );
 	echo "Thanks for reporting!";
	return;
}
/*	Comment Front page */
function comment_mini_post(){
	global $shortname;
	$fields = array(
            'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true"></textarea></p>',
            'must_log_in' => '<p class="must-log-in">' .  sprintf( __( 'You must be <a href="%s">logged in</a> to post a comment.', 'junkie' ), wp_login_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'logged_in_as' => '<p class="logged-in-as">' . sprintf( __( 'Logged in as <a href="%1$s">%2$s</a>. <a href="%3$s" title="Log out of this account">Log out &raquo;</a>', 'junkie' ), admin_url( 'profile.php' ), $user_identity, wp_logout_url( apply_filters( 'the_permalink', get_permalink( ) ) ) ) . '</p>',
            'comment_notes_before' => '',
            'comment_notes_after' => '',
            'title_reply' => __('Leave a Comment', 'junkie'),
            'title_reply_to' => __('Reply to %s', 'junkie'),
            'cancel_reply_link' => __('Cancel Reply', 'junkie'),
            'label_submit' => __('Submit Comment', 'junkie')
	    );
	   echo '
	   <html>
	   <head>
	   <link href="'.get_template_directory_uri().'/style.css" media="all" type="text/css" rel="stylesheet">
	   <link href="'.get_template_directory_uri().'/css/color-'.strtolower(get_option($shortname.'_theme_stylesheet')).'.css" rel="stylesheet">	   
	   </head>
	   <body style="background:#ffffff;">
	   <div id="commentform" class="form-inner">
	   <p>&nbsp;</p>
	   ';
	   echo comment_form($fields,(int)$_GET["id"]);
	   echo "
	   </div>
	   <script type='text/javascript'>
	   		document.getElementById('commentform').onsubmit =function(){
				parent.jQuery.fancybox.close();
				parent.reflash_comments(".(int)$_GET["id"].",'".admin_url("admin-ajax.php")."');
				
			}
	   </script>
	   </body>
	   </html>
	   ";//submit close. 
	   die();
}
	   
add_action('wp_ajax_comment_mini_post', 'comment_mini_post');
add_action('wp_ajax_nopriv_comment_mini_post', 'comment_mini_post'); // not really needed

function comment_mini_list(){
	echo wp_list_comments( 'type=comment&callback=tj_comment_mini',get_comments(array('post_id' =>(int)$_POST["id"])) );
	die();
}
add_action('wp_ajax_comment_mini_list', 'comment_mini_list');
add_action('wp_ajax_nopriv_comment_mini_list', 'comment_mini_list'); // not really needed

function send_mail(){
	global $shortname;
	if(isset($_POST['submitted'])) {
		if(trim($_POST['contactName']) === '') {
			$nameError = 'Please enter your name.';
			$hasError = true;
		} else {
			$name = trim($_POST['contactName']);
		}
		
		if(trim($_POST['email']) === '')  {
			$emailError = 'Please enter your email address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['email']))) {
			$emailError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$email = trim($_POST['email']);
		}
		
		if(trim($_POST['recipients']) === '')  {
			$recipientsError = 'Please enter your recipients address.';
			$hasError = true;
		} else if (!eregi("^[A-Z0-9._%-]+@[A-Z0-9._%-]+\.[A-Z]{2,4}$", trim($_POST['recipients']))) {
			$recipientsError = 'You entered an invalid email address.';
			$hasError = true;
		} else {
			$recipients = trim($_POST['recipients']);
		}
			
		if(trim($_POST['comments']) === '') {
			$commentError = 'Please enter a message.';
			$hasError = true;
		} else {
			if(function_exists('stripslashes')) {
				$comments = stripslashes(trim($_POST['comments']));
			} else {
				$comments = trim($_POST['comments']);
			}
		}
			
		if(!isset($hasError)) {
			$emailTo = $recipients;
			if (!isset($emailTo) || ($emailTo == '') ){
				$emailTo = get_option($shortname.'_email');
			}
			$subject = '[Contact Form] From '.$email;
			$body = "Name: $name \n\nEmail: $email \n\nComments: $comments";
			$headers = 'From: '.$name.' <'.$email.'>' . "\r\n" . 'Reply-To: ' . $email;
			
			mail($emailTo, $subject, $body, $headers);
			echo "successful.";
		}
		
	}
}
add_action('wp_ajax_send-mail', 'send_mail');
add_action('wp_ajax_nopriv_send-mail', 'send_mail'); // not really needed

function email_form(){
	echo '
	<html>
	<head>
	<link href="'.get_template_directory_uri().'/style.css" media="all" type="text/css" rel="stylesheet">
	</head>
	<body>
	<div class="form-inner">
	<p>Send mail to a friend</p>				
	<form class="mail-form" action="'.admin_url("admin-ajax.php").'?action=send-mail" method="post" >
	<input name="submitted" value="1" type="hidden">
	<p><label for="contactName">Your Name:</label> <input name="contactName" value="" type="text"></p>
	<p><label for="email">Your Email:</label> <input name="email" value="" type="text"></p>
	<p><label for="recipients">Recipients Email:</label> <input name="recipients" value="" type="text"></p>
	<p><label for="comments">Your Message:</label> <textarea cols="45" rows="8" name="comments"></textarea></p>
	<input type="submit"  value="Send mail">
	</form>
	</div>
	</body>
	</html>
	';
	die();
}
add_action('wp_ajax_email-form', 'email_form');
add_action('wp_ajax_nopriv_email-form', 'email_form'); // not really needed

/*-----------------------------------------------------------------------------------*/
/* custom_upload_mimes init 
/*-----------------------------------------------------------------------------------*/
add_filter('upload_mimes', 'custom_upload_mimes');
function custom_upload_mimes ( $existing_mimes=array() ) {
	// add as many as you like e.g. 
	$existing_mimes['doc'] = 'application/msword'; 
	$existing_mimes['webm'] = 'audio/webm';
	// remove items here if desired ...
	// and return the new full result
	return $existing_mimes;
}

/*-----------------------------------------------------------------------------------*/
/*	Pagination
/*-----------------------------------------------------------------------------------*/

/* new page query vars */
add_filter('query_vars', 'parameter_queryvars' );
function parameter_queryvars( $qvars ){
	$qvars[] = 'cp';
	return $qvars;
}
/* new page rewrite rule */
add_action('init','pagination_rewrite');
function pagination_rewrite() {
  global $shortname,$wp_rewrite;

  $store_rewrite=get_option($shortname."_coupon_stroe_url");
  $type_rewrite=get_option($shortname."_coupon_type_url");
  $cat_rewrite=get_option($shortname."_coupon_cat_url");
  $tag_rewrite=get_option($shortname."_coupon_tag_url");
  
  $wp_rewrite->add_rule('cp/([^/]*)/?','index.php?cp=$matches[1]', 'top');
  $wp_rewrite->add_rule($store_rewrite.'/([^/]*)/cp/([^/]*)/?','index.php?coupon_store=$matches[1]&cp=$matches[2]', 'top');
  $wp_rewrite->add_rule($type_rewrite.'/([^/]*)/cp/([^/]*)/?','index.php?coupon_type=$matches[1]&cp=$matches[2]', 'top');
  $wp_rewrite->add_rule($cat_rewrite.'/([^/]*)/cp/([^/]*)/?','index.php?coupon_cat=$matches[1]&cp=$matches[2]', 'top');
  $wp_rewrite->add_rule($tag_rewrite.'/([^/]*)/cp/([^/]*)/?','index.php?coupon_tag=$matches[1]&cp=$matches[2]', 'top');
  // Once you get working, remove this next line for test
  //$wp_rewrite->flush_rules(false);  
}

/*-----------------------------------------------------------------------------------*/
/*	Pagination
/*-----------------------------------------------------------------------------------*/


function junkie_pagination($total = '', $paged=''){
    global $wp_query;   
    if(empty($total)) $total = $wp_query->max_num_pages;
    
    if(empty($paged)) $paged = get_query_var('paged');
    


    $big = 999999999; // need an unlikely integer
    
    $pagination = array(
        'base' => str_replace( $big, '%#%', get_pagenum_link( $big ) ),
        'format' => '',
        'total' => $total,
        'current' => max( 1,$paged),
        'prev_text' => __('&laquo;'),
        'next_text' => __('&raquo;')
    );

    if ($total > 1) {
    	echo '<div class="junkie-pagination">'.paginate_links($pagination).'</div>';
    }
};

/*-----------------------------------------------------------------------------------*/
/*	Add thumbnail to posts and page list
/*-----------------------------------------------------------------------------------*/
add_theme_support('post-thumbnails', array( 'post', 'page' ) );
add_theme_support( 'post-thumbnails', array( 'coupon' ) ); 
// for posts
add_filter( 'manage_posts_columns', 'fb_AddThumbColumn' );
add_action( 'manage_posts_custom_column', 'fb_AddThumbValue', 10, 2 );
// for pages
add_filter( 'manage_pages_columns', 'fb_AddThumbColumn' );
add_action( 'manage_pages_custom_column', 'fb_AddThumbValue', 10, 2 );
function fb_AddThumbColumn($cols) {
	$cols['thumbnail'] = __('Thumbnail','junkie');
	return $cols;
}
function fb_AddThumbValue($column_name, $post_id) {
	$width = (int) 60;
	$height = (int) 60;
	if ( 'thumbnail' == $column_name ) {
		// thumbnail of WP 2.9
		$thumbnail_id = get_post_meta( $post_id, '_thumbnail_id', true );
		// image from gallery
		$attachments = get_children( array('post_parent' => $post_id, 'post_type' => 'attachment', 'post_mime_type' => 'image') );
		if ($thumbnail_id)
			$thumb = wp_get_attachment_image( $thumbnail_id, array($width, $height), true );
			elseif ($attachments) {
			foreach ( $attachments as $attachment_id => $attachment ) {
				$thumb = wp_get_attachment_image( $attachment_id, array($width, $height), true );
			}
		}
		if ( isset($thumb) && $thumb ) {
			echo $thumb;
			} else {
			echo __('None' , 'junkie');
		}
	}
}


/*-----------------------------------------------------------------------------------*/
/* taxonomy coupon script & css
/*-----------------------------------------------------------------------------------*/
add_action( 'admin_enqueue_scripts', 'coupon_admin_scripts' );
function coupon_admin_scripts() {
	global $is_IE;//?? for some day
	wp_enqueue_script('jquery-ui-tabs');
	wp_enqueue_script('jquery-ui-datepicker');
	wp_enqueue_style('jquery-ui',get_template_directory_uri()."/css/jquery-ui.css");
	wp_enqueue_style('admin-css',get_template_directory_uri().'/includes/css/admin_meta.css');
	if(function_exists( 'wp_enqueue_media' )){
		wp_enqueue_media();
	}else{ 
		wp_enqueue_style('thickbox');
		wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
	}
	
}

add_action( 'init', 'coupon_type_init' );
function coupon_type_init() {
	global $shortname;
	$labels_args=array(
		'name'               => 'Coupons',
		'singular_name'      => 'Coupon',
		'add_new'            => 'Add New',
		'add_new_item'       => 'Add New Coupon',
		'edit_item'          => 'Edit Coupon',
		'new_item'           => 'New Coupon',
		'all_items'          => 'All Coupons',
		'view_item'          => 'View Coupon',
		'search_items'       => 'Search Coupons',
		'not_found'          => 'No coupons found',
		'not_found_in_trash' => 'No coupons found in Trash',
		'parent_item_colon'  => '',
		'menu_name'          => 'Coupons'
	);
	$supports_args=array(
		'title' ,
		'editor',
		'author',
		'thumbnail',
		'trackbacks',
		'comments',
		'revisions'
	);
	register_post_type( 'coupon' , array( 'label' =>'Coupons','hierarchical'=> true,'query_var' => true,'rewrite'=>array( 'slug' => get_option($shortname."_coupon_single_url") ),'show_ui'=>true,'public'=>true,' show_in_nav_menus '=>true,'labels'=>$labels_args,'supports'=>$supports_args));
	//register_taxonomy
	$coupon_store_labels_args = array(
		'name'              => _x( 'Coupon Store', 'Store general name' , 'junkie' ),
		'singular_name'     => _x( 'Coupon Store', 'Store singular name' , 'junkie' ),
		'search_items'      => __( 'Search Stores' , 'junkie' ),
		'all_items'         => __( 'All Stores' , 'junkie' ),
		'parent_item'       => __( 'Parent Store' , 'junkie' ),
		'parent_item_colon' => __( 'Parent Store:' , 'junkie' ),
		'edit_item'         => __( 'Edit Store' , 'junkie' ),
		'update_item'       => __( 'Update Store' , 'junkie' ),
		'add_new_item'      => __( 'Add New Store' , 'junkie' ),
		'new_item_name'     => __( 'New Store Name' , 'junkie' ),
		'menu_name'         => __( 'Stores' , 'junkie' ),
	);

	$coupon_type_labels_args = array(
		'name'              => _x( 'Coupon Type', 'Coupon general name' , 'junkie'),
		'singular_name'     => _x( 'Coupon Type', 'Coupon singular name' , 'junkie'),
		'search_items'      => __( 'Search Types' ,'junkie' ),
		'all_items'         => __( 'All Coupon Types' , 'junkie' ),
		'parent_item'       => __( 'Parent Coupon Type' , 'junkie' ),
		'parent_item_colon' => __( 'Parent Coupon Type:' , 'junkie' ),
		'edit_item'         => __( 'Edit Coupon Type' , 'junkie' ),
		'update_item'       => __( 'Update Coupon Type' , 'junkie' ),
		'add_new_item'      => __( 'Add New Coupon Type' , 'junkie' ),
		'new_item_name'     => __( 'New Coupon Name' , 'junkie' ),
		'menu_name'         => __( 'Coupon Types' , 'junkie' ),
	);
	$coupon_cat_args = array(
		'name'              => _x( 'Coupon Category', 'Category general name' , 'junkie'),
		'singular_name'     => _x( 'Coupon Category', 'Category singular name' , 'junkie'),
		'search_items'      => __( 'Search Category' , 'junkie' ),
		'all_items'         => __( 'All Coupon Categorys' , 'junkie' ),
		'parent_item'       => __( 'Parent Coupon Category' , 'junkie' ),
		'parent_item_colon' => __( 'Parent Coupon Category:' , 'junkie' ),
		'edit_item'         => __( 'Edit Coupon Category' , 'junkie' ),
		'update_item'       => __( 'Update Coupon Category' , 'junkie' ),
		'add_new_item'      => __( 'Add New Coupon Category' , 'junkie' ),
		'new_item_name'     => __( 'New Coupon Category Name' , 'junkie' ),
		'menu_name'         => __( 'Categories' , 'junkie' ),
	);
	$coupon_tag_args = array(
		'name'              => _x( 'Coupon Tag', 'Tag general name' , 'junkie'),
		'singular_name'     => _x( 'Coupon Tag', 'Tag singular name' , 'junkie'),
		'search_items'      => __( 'Search Tag' , 'junkie' ),
		'all_items'         => __( 'All Coupon Tags' , 'junkie' ),
		'parent_item'       => __( 'Parent Coupon Tag' , 'junkie' ),
		'parent_item_colon' => __( 'Parent Coupon Tag:' , 'junkie' ),
		'edit_item'         => __( 'Edit Coupon Tag' , 'junkie' ),
		'update_item'       => __( 'Update Coupon Tag' , 'junkie' ),
		'add_new_item'      => __( 'Add New Coupon Tag' , 'junkie' ),
		'new_item_name'     => __( 'New Coupon Tag Name' , 'junkie' ),
		'menu_name'         => __( 'Coupon Tags' , 'junkie' ),
	);
	register_taxonomy('coupon_store', 'coupon', array( 'hierarchical'=> true,'label' =>'Stores','labels'=>$coupon_store_labels_args,'query_var' => true,'rewrite'=>array( 'slug' => get_option($shortname."_coupon_stroe_url") ),'show_ui'=>true) );
	register_taxonomy('coupon_type', 'coupon', array( 'hierarchical'=> true,'label' =>'Coupon Types','labels'=>$coupon_type_labels_args,'query_var' => true,'rewrite'=>array( 'slug' => get_option($shortname."_coupon_type_url") ),'show_ui'=>true) );
	register_taxonomy('coupon_cat', 'coupon', array( 'hierarchical'=> true,'label' =>'Categories','labels'=>$coupon_cat_args,'query_var' => true,'rewrite'=>array( 'slug' => get_option($shortname."_coupon_cat_url") ),'show_ui'=>true) );
	register_taxonomy('coupon_tag', 'coupon', array( 'hierarchical'=> false,'label' =>'Coupon Tags','labels'=>$coupon_tag_args,'query_var' => true,'rewrite'=>array( 'slug' => get_option($shortname."_coupon_tag_url") ),'show_ui'=>true) );
	
	//add template type
	wp_insert_term( 'Coupon Code','coupon_type', array(
		'description'=> '',
		'slug' => 'coupon-code',
		'parent'=> 0
	));
	wp_insert_term( 'Printable Coupon','coupon_type', array(
		'description'=> '',
		'slug' => 'printable-coupon',
		'parent'=> 0
	));
	wp_insert_term( 'Promotion','coupon_type', array(
		'description'=> '',
		'slug' => 'promotion',
		'parent'=> 0
	));
	wp_insert_term( 'Credit Card','coupon_type', array(
		'description'=> '',
		'slug' => 'credit-card',
		'parent'=> 0
	));
	//add template page.
	$blog_pages_args = array(
	  'post_author'    => 1,
	  'post_content'   => 'Default blog page.',
	  'post_name'      => 'blog',
	  'post_status'    => 'publish' ,
	  'post_title'     => 'Blog',
	  'post_type'      => 'page',
	); 
	$stores_cat_pages_args = array(
	  'post_author'    => 1,
	  'post_content'   => 'Default coupon categories page.',
	  'post_name'      => 'categories',
	  'post_status'    => 'publish' ,
	  'post_title'     => 'Categories',
	  'post_type'      => 'page',
	); 
	$stores_pages_args = array(
	  'post_author'    => 1,
	  'post_content'   => 'Default stores page.',
	  'post_name'      => 'stores',
	  'post_status'    => 'publish' ,
	  'post_title'     => 'Stores',
	  'post_type'      => 'page',
	); 
	$submit_pages_args = array(
	  'post_author'    => 1,
	  'post_content'   => 'Default coupon submission page.',
	  'post_name'      => 'submit',
	  'post_status'    => 'publish' ,
	  'post_title'     => 'Submit Coupon',
	  'post_type'      => 'page',
	); 

	if(get_page_by_title('Blog')==NULL&&get_option('coupon_frist_run_check')<>'1'){
	  $page_id=wp_insert_post( $blog_pages_args, $wp_error );
	  update_post_meta($page_id, '_wp_page_template', 'template-blog.php');
	}
	if(get_page_by_title('Categories')==NULL&&get_option('coupon_frist_run_check')<>'1'){
	  $page_id=wp_insert_post( $stores_cat_pages_args, $wp_error );
	  update_post_meta($page_id, '_wp_page_template', 'template-cats.php');
	}
	if(get_page_by_title('Stores')==NULL&&get_option('coupon_frist_run_check')<>'1'){
	  $page_id=wp_insert_post( $stores_pages_args, $wp_error );
	  update_post_meta($page_id, '_wp_page_template', 'template-stores.php');
	}
	if(get_page_by_title('Submit Coupon')==NULL&&get_option('coupon_frist_run_check')<>'1'){
	  $page_id=wp_insert_post( $submit_pages_args, $wp_error );
	  update_post_meta($page_id, '_wp_page_template', 'template-submit.php');
	}
	
	update_option( 'coupon_frist_run_check','1');// frist run over.
	

/*-----------------------------------------------------------------------------------*/
/* Create the theme database tables
/*-----------------------------------------------------------------------------------*/	
	// create the meta table for the custom stores taxonomy
	global $wpdb;
	$type="coupon_store";
	$table_name =$wpdb->prefix . $type ."meta";

	$sql = "CREATE TABLE IF NOT EXISTS $table_name (
				meta_id bigint(20) unsigned NOT NULL AUTO_INCREMENT,
				coupon_store_id bigint(20) unsigned NOT NULL default '0',
				meta_key varchar(255) DEFAULT NULL,
				meta_value longtext,
				PRIMARY KEY  (meta_id),
				KEY coupon_store_id (coupon_store_id),
				KEY meta_key (meta_key)
				);";
				

	//$wpdb->query($sql);
	require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
	dbDelta($sql);
	// Register Taxonomy Table
	$variable_name = $type . 'meta';
	$wpdb->$variable_name = $table_name;
		 
}


/*-----------------------------------------------------------------------------------*/
/* Admin post coupons' meta
/*-----------------------------------------------------------------------------------*/	

//remove coupon_type box in posts & edit page
function remove_artist_meta() {
	remove_meta_box( 'authordiv', 'coupon', 'side' );
	remove_meta_box( 'coupon_typediv', 'coupon', 'side' );
}
add_action( 'admin_menu' , 'remove_artist_meta' );

function coupon_meta_inner(){
	global $post;
	$post_author=get_post_meta($post->ID, 'post_author_override', true);
	$coupon_type=get_post_meta($post->ID, 'coupon_type', true);
	$attachment_image=wp_get_attachment_image_src( get_post_meta($post->ID, 'print_imageid', true) );
?>
	<script type="text/javascript">	
	//<![CDATA[
	jQuery(document).ready(function() {
	  var formfield;
		// upload printable coupon image
		jQuery('input#upload_image_button').click(function() {
		  formfield = jQuery(this).attr('rel');
			if(wp.media){
				//e.preventDefault();
				// Set options for 1st frame render
				var options = {
					state: 'insert',
					frame: 'post'
				};
	
				frame = wp.media(options).open();
				
				// Tweak views
				frame.menu.get('view').unset('gallery');
				frame.menu.get('view').unset('featured-image');
										
				frame.toolbar.get('view').set({
					insert: {
						style: 'primary',
						text: '<?php _e("Insert", "junkie"); ?>',
	
						click: function() {
							var models = frame.state().get('selection'),
								imageID = models.first().attributes.id,
								url = models.first().attributes.url;
								//alert( var_dump(models));
								imgoutput = '<a href="' + url + '" target="_blank"><img width="100px" src="' + url + '" /></a>'; 
								jQuery('#print_url').val(url); // return the image url to the field
								jQuery('input[name=print_imageid]').val(imageID); // return the image url to the field			
								jQuery('#print_url').siblings('.upload_image_preview').slideDown().html(imgoutput); // display the uploaded image thumbnail
							frame.close();
						}
					}
				});
			
			}else{
				
				alert('plz ,update you wordpress to v3.1+ .');
						
			}

			return false;
		});		
		// show the coupon code or upload coupon field based on type select box
		jQuery('select#coupon_meta_dropdown').change(function() {	
			var coupon_type=jQuery(this).find("option:selected").text();
			if (coupon_type == 'Coupon Code') {
				jQuery('tr#ctype-coupon-code').fadeIn('fast');
				jQuery('tr#ctype-printable-coupon').hide();
			} else if (coupon_type == 'Printable Coupon') {
				jQuery('tr#ctype-printable-coupon').fadeIn('fast');
				jQuery('tr#ctype-coupon-code').hide();
			} else if (coupon_type == 'Credit Card') {
				jQuery('tr#ctype-coupon-code').fadeIn('fast');
				jQuery('tr#ctype-printable-coupon').hide();	
			} else {
				jQuery('tr.ctype').hide();
				jQuery('tr.ctype input').removeClass('required invalid');
			}		
		}).change();
		
		jQuery( "#expire_date" ).datepicker({ dateFormat: "yy-mm-dd" });
		
		<?php 
			if ($coupon_type=='Coupon Code'){
				echo "jQuery('tr#ctype-printable-coupon').hide();jQuery('tr#ctype-coupon-code').show();";
			}
			if ($coupon_type=='Printable Coupon'){	
				echo "jQuery('tr#ctype-printable-coupon').show();jQuery('tr#ctype-coupon-code').hide();";
			}
			if ($coupon_type=='Promotion'){	
				echo "jQuery('tr#ctype-printable-coupon').hide();jQuery('tr#ctype-coupon-code').hide();";
			}
			if($post_author){
				echo 'jQuery("#post_author_override option[value=\''.$post_author.'\']").attr("selected","selected");';
			}
			echo 'jQuery("#coupon_meta_dropdown option[value=\''.$coupon_type.'\']").attr("selected","selected");';
				
		?>
	});	
	//]]>
	</script>
<table class="form-table coupon-meta-table">
		
			<tbody><tr>
				<th style="width:20%"><label for="cp_sys_ad_conf_id">Coupon Info:</label></th>
				<td class="coupon-conf">
					<span>Coupon ID: <font color="#0099CC"><strong><?php echo get_post_meta($post->ID, 'coupon_id', true );?></strong></font> &nbsp;&nbsp;</span>
					<span>
                    Views:  <strong>
						<?php
                        $view_point=get_post_meta($post->ID, 'view_point',true);
                        if($view_point=='')
                        $view_point=0;
                        echo $view_point;
                        ?>
                        </strong>
					</span> | 
				
					<span>
						Clicks: <strong>
                        <?php
						$click_point=get_post_meta($post->ID, 'click_point',true);
						if($click_point=='')
						$click_point=0;
						echo $click_point;
						?>
                        </strong> |
						CTR: <strong>
                        <?php
                        
                        if($view_point == '' ) {
	                        echo '0';
                        } else {
							echo round($click_point/$view_point*100,2)."%";
						}				
                        ?>
                        </strong>
					</span>
				</td>
			</tr>
			<tr>
				<th style="width:20%"><label>Submitted By:</label></th>
				<td >
                <select id="post_author_override" name="post_author_override">
                <?php 
					$args = array(
						'blog_id'      => $GLOBALS['blog_id'],
					 );
					 $blogusers=get_users( $args );
					foreach ($blogusers as $user) {
						echo '<option value="' . $user->ID . '">' . $user->display_name . '</li>';
					}
				?>
                </select>
                
				</td>
			</tr>			
			<tr>
				<th style="width:20%"><label>Coupon Type:</label></th>
				<td>
                <?php
 
					$coupon_type=get_terms( 'coupon_type', 'orderby=count&hide_empty=0' );
					//var_dump($coupon_type);
				?>
				<select id="coupon_meta_dropdown" name="coupon_type" >
                <?php
  					foreach ( $coupon_type as $term ) {
						echo "<option value='".$term->name."' >" . $term->name . "</option>";
					}              
				?>
				</select></td>
			</tr>
			
			<tr class="ctype" id="ctype-coupon-code">
				<th style="width:20%"><label>Coupon Code:</label></th>
				<td><input type="text" value="<?php echo get_post_meta($post->ID, 'coupon_code', true); ?>" class="text required" name="coupon_code"></td>
			</tr>
			
			<tr class="ctype" id="ctype-printable-coupon" style="display: none;">
				<th style="width:20%"><label>Printable Coupon URL:</label></th>
				<td>
					<input type="text" value="<?php
					  echo trim($attachment_image[0]);
					?>" class="upload_image_url text" id="print_url" name="print_url" readonly="">
					<input type="button" value="Add Image" rel="print_url" class="upload_button button" id="upload_image_button">							
					<div class="upload_image_preview">
					<?php
						if(is_array($attachment_image))
							echo "<img src='$attachment_image[0]' width='100px' />";
					?>
                    </div>
					<input type="hidden" value="<?php echo get_post_meta($post->ID, 'print_imageid', true); ?>" name="print_imageid" id="imageid" class="hide">
				</td>
			</tr>
			
			<tr>
				<th style="width:20%"><label>Destination URL:</label></th>
				<td><input type="text" value="<?php echo get_post_meta($post->ID, 'coupon_aff_url', true); ?>" class="text" name="coupon_aff_url"></td>
			</tr>
			
			<tr>
				<th style="width:20%"><label>Display URL:</label></th>
				<td><a target="_blank"  href="<?php echo get_permalink( $post->ID ); ?>"><?php echo get_permalink( $post->ID ); ?></a></td>
			</tr>
			
			<tr>
				<th style="width:20%"><label>Expiration Date:</label></th>
				<td><input type="text" value="<?php echo get_post_meta($post->ID, 'expire_date', true); ?>"  name="expire_date" id="expire_date"></td>
			</tr>
			
			<tr>
				<th style="width:20%"><label for="coupon_featured">Featured Coupon:</label></th>
				<td>
            <?php
            	$coupon_featured = get_post_meta($post->ID, 'coupon_featured', true)?'checked="checked"':'';
			?>    
			<span class="checkbox-wrap"><input type="checkbox" <?php echo $coupon_featured; ?> class="checkbox"  value="1" name="coupon_featured"> Show this coupon in the home page slider</span></td>
			</tr>
			
			<tr>
				<th style="width:20%"><label>Submitted from IP:<?php echo get_post_meta($post->ID, 'coupon_ip', true); ?></label></th>
				<td><?php echo fun_get_real_ip(); ?></td>
			</tr>
			
		</tbody></table>
<?php
}
function coupon_meta_issue_report(){
	$post_id=(int)$_GET['post'];
	if($post_id){
		$issues=get_post_meta($post_id, 'report_issue',false);
		//print_r($issues);
		foreach($issues as $item){
			$items=explode("|",$item);
			echo "<strong>".$items[1]."</strong> reported: <font color='#990000'>".$items[0]."</font></br>";
		}
	}
}
// coupon quick_edit_control . 
function quick_edit_control($column_name, $post_type) {
	 if($column_name == 'cp_type'){
	 	echo '
			<script>//hide the type select because we make the select file as an string option.
				jQuery(".inline-edit-col-center span:eq(1)").hide();
				jQuery(".coupon_type-checklist").hide();
			</script>
			<fieldset class="inline-edit-col-right"><div class="inline-edit-col">
				<label class="inline-edit-group">
					<!--maybe you do somthing in other time and save it in save_post action-->
				</label>
			</div></fieldset>
		';
	 }
}
add_action( 'quick_edit_custom_box', 'quick_edit_control', 10, 3 );

function coupon_add_custom_box($post_id) {
        add_meta_box(
            'coupon_meta',
            __( 'Coupon Meta', 'junkie' ),
            'coupon_meta_inner',
            'coupon',
			'advanced'
        );
		add_meta_box(
            'issue_reports',
            __( 'Issue Report', 'junkie' ),
            'coupon_meta_issue_report',
            'coupon',
			'advanced'
        );

 }
add_action( 'add_meta_boxes', 'coupon_add_custom_box' );

function coupon_save_meta_box($post_id){

	if($_GET['trashed']!='1'&&$_GET['action']!='trash'&&$_GET['action']!='untrash'&&$_GET['untrashed']!='1'&&$_POST['action']!='inline-save'){
		$metafields = array(
			'post_author_override' => $_POST['post_author_override'],
			'coupon_type' => $_POST['coupon_type'],
			'coupon_code' => $_POST['coupon_code'],
			'print_url' => $_POST['print_url'],
			'print_imageid' => $_POST['print_imageid'],
			'coupon_aff_url' => $_POST['coupon_aff_url'],
			'display_url' => $_POST['display_url'],
			'expire_date' => $_POST['expire_date'],
			'coupon_featured' => $_POST['coupon_featured'],
		);
		foreach ($metafields as $name => $value){
			update_post_meta($post_id, $name, sanitize_text_field($value));
			if($name=='coupon_type')
			wp_set_object_terms( $post_id, $value,'coupon_type', false );//set type
		}
		// give it an id number		
		$rand_id = uniqid( rand( 10,1000 ), false );
		add_post_meta( $post_id, 'coupon_id', $rand_id, true );
	}else{
	 //die();
	}
}
add_action( 'save_post', 'coupon_save_meta_box' );
 
/*-----------------------------------------------------------------------------------*/
/*	add extra fields to the create store admin page
/*-----------------------------------------------------------------------------------*/
function add_store_extra_fields( $tag ) {
?>

	<div class="form-field">
		<label for="junkie_store_url"><?php _e( 'Store URL', 'junkie' ); ?></label>
		<input type="text" name="junkie_store_url" id="junkie_store_url" value="" />
		<p class="description"><?php _e( 'The URL for the store (i.e. http://www.mysite.com)', 'junkie' ); ?></p>
	</div>
	<div class="form-field">
		<label for="junkie_store_aff_url"><?php _e( 'Destination URL', 'junkie' ); ?></label>
		<input type="text" name="junkie_store_aff_url" id="junkie_store_aff_url" value="" />
		<p class="description"><?php _e( 'The affiliate URL for the store (i.e. http://www.mysite.com/?affid=12345)', 'junkie' ); ?></p>
	</div>
	<div class="form-field">
		<label for="junkie_store_image_id"><?php _e( 'Store Image', 'junkie'  ); ?></label>
		<div id="stores_image" style="float:left; margin-right:15px;"><img src="<?php echo get_template_directory_uri(); ?>/images/store-default.png" width="75px" height="auto" alt="Store Image" /></div>
		<div style="line-height:75px;">
			<input type="hidden" name="junkie_store_image_id" id="junkie_store_image_id" value="" />
			<button type="submit" class="button" id="button_add_image" rel="junkie_store_image_url"><?php _e( 'Add Image', 'junkie'  ); ?></button>
			<button type="submit" class="button" id="button_remove_image"><?php _e( 'Remove Image', 'junkie'  ); ?></button>
		</div>
		<div class="clear"></div>
		<p class="description"><?php _e( 'Choose custom image for the store. (best size: 360x300)', 'junkie'  ); ?></p>
	</div>
	<script type="text/javascript">
	//<![CDATA[	
	jQuery(document).ready(function() {

	  var formfield;

		if ( ! jQuery('#junkie_store_image_id').val() ) {
			jQuery('#button_remove_image').hide();
		} else {
			jQuery('#button_add_image').hide();
		}

		jQuery('#button_add_image').live('click', function(e) {
			formfield = jQuery(this).attr('rel');
			if(wp.media){
				e.preventDefault();
				// Set options for 1st frame render
				var options = {
					state: 'insert',
					frame: 'post'
				};
	
				frame = wp.media(options).open();
				
				// Tweak views
				frame.menu.get('view').unset('gallery');
				frame.menu.get('view').unset('featured-image');
										
				frame.toolbar.get('view').set({
					insert: {
						style: 'primary',
						text: '<?php _e("Insert", "junkie"); ?>',
	
						click: function() {
							var models = frame.state().get('selection'),
								imageID = models.first().attributes.id;
								url = models.first().attributes.url;
				
							jQuery('input[name=junkie_store_image_id]').val(imageID);
								jQuery('#stores_image img').attr('src', url);
								jQuery('#button_remove_image').show();
								jQuery('#button_add_image').hide();
							frame.close();
						}
					}
				});
			
			}else{
				
				alert('plz ,update you wordpress to v3.1+ .');
						
			}
			
			return false;
		});

		jQuery('#button_remove_image').live('click', function() {
			jQuery('#stores_image img').attr('src', '<?php echo get_template_directory_uri(); ?>/images/store-default.png');
			jQuery('#junkie_store_image_id').val('');
			jQuery('#button_remove_image').hide();
			jQuery('#button_add_image').show();
			return false;
		});


	});
	//]]>
	</script>

<?php
}
add_action( 'coupon_store_add_form_fields', 'add_store_extra_fields', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/*	add extra fields to the edit store admin page
/*-----------------------------------------------------------------------------------*/

function junkie_edit_stores( $tag, $taxonomy ) {
	$the_store_url = get_metadata($tag->taxonomy, $tag->term_id, 'junkie_store_url', true);
	$the_store_aff_url = get_metadata($tag->taxonomy, $tag->term_id, 'junkie_store_aff_url', true);
	$junkie_store_aff_url_cloaked = get_metadata($tag->taxonomy, $tag->term_id, 'junkie_store_aff_url_cloaked', true);
	$the_store_active = get_metadata($tag->taxonomy, $tag->term_id, 'junkie_store_active', true);
	$the_store_aff_url_clicks = get_metadata($tag->taxonomy, $tag->term_id, 'junkie_aff_url_clicks', true);
	$junkie_store_image_url = get_metadata($tag->taxonomy, $tag->term_id, 'junkie_store_image_url', true);
	$junkie_store_image_id = get_metadata($tag->taxonomy, $tag->term_id, 'junkie_store_image_id', true);
	$junkie_store_image_preview = junkie_get_store_image_url($tag->term_id, 'term_id', 75);
?>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="junkie_store_url"><?php _e( 'Store URL', 'junkie' ); ?></label></th>
		<td>
			<input type="text" name="junkie_store_url" id="junkie_store_url" value="<?php echo $the_store_url; ?>"/><br />
			<p class="description"><?php _e( 'The URL for the store (i.e. http://www.mysite.com)', 'junkie' ); ?></p>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="junkie_store_aff_url"><?php _e( 'Destination URL', 'junkie' ); ?></label></th>
		<td>
			<input type="text" name="junkie_store_aff_url" id="junkie_store_aff_url" value="<?php echo $the_store_aff_url; ?>"/><br />
			<p class="description"><?php _e( 'The affiliate URL for the store (i.e. http://www.mysite.com/?affid=12345)', 'junkie' ); ?></p>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="junkie_store_aff_url_cloaked"><?php _e( 'Display URL', 'junkie' ); ?></label></th>
		<td><?php echo get_term_link( $tag, $taxonomy ); ?></td>
	</tr>

<!--	<tr class="form-field">
		<th scope="row" valign="top"><label for="junkie_aff_url_clicks"><?php _e( 'Clicks', 'junkie' ); ?></label></th>
		<td><?php echo esc_attr( $the_store_aff_url_clicks ); ?></td>
	</tr>-->

	<tr class="form-field">
		<th scope="row" valign="top"><label for="junkie_store_active"><?php _e( 'Store Active', 'junkie' ); ?></label></th>
		<td>
			<select class="postform" id="junkie_store_active" name="junkie_store_active" style="min-width:125px;">
				<option value="yes" <?php if ($the_store_active == 'yes') echo 'selected = selected'; ?>><?php _e( 'Yes', 'junkie' ); ?></option>
				<option value="no" <?php if ($the_store_active == 'no') echo 'selected = selected'; ?>><?php _e( 'No', 'junkie' ); ?></option>
			</select>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="junkie_store_url"><?php _e( 'Store Screenshot', 'junkie' ); ?></label></th>
		<td>     			
			<span class="thumb-wrap">
				<a href="<?php echo $the_store_url; ?>" target="_blank"><img class="store-thumb" src="" alt="" /></a>
			</span>
		</td>
	</tr>

	<tr class="form-field">
		<th scope="row" valign="top"><label for="junkie_store_image_id"><?php _e( 'Store Image', 'junkie' ); ?></label></th>
		<td>
			<div id="stores_image" style="float:left; margin-right:15px;"><img src="<?php echo $junkie_store_image_preview; ?>" width="75px" height="auto" /></div>
			<div style="line-height:75px;">
				<input type="hidden" name="junkie_store_image_id" id="junkie_store_image_id" value="<?php echo $junkie_store_image_id; ?>" />
				<button type="submit" class="button" id="button_add_image" rel="junkie_store_image_url"><?php _e( 'Add Image', 'junkie' ); ?></button>
				<button type="submit" class="button" id="button_remove_image"><?php _e( 'Remove Image', 'junkie' ); ?></button>
			</div>
			<div class="clear"></div>
			<p class="description"><?php _e( 'Choose custom image for the store. (best size: 360x300)', 'junkie' ); ?></p>
		</td>
	</tr>
	<script type="text/javascript">
	//<![CDATA[	
	jQuery(document).ready(function() {

	  var formfield;

		if ( ! jQuery('#junkie_store_image_id').val() ) {
			jQuery('#button_remove_image').hide();
		} else {
			jQuery('#button_add_image').hide();
		}

		jQuery('#button_add_image').live('click', function() {
			formfield = jQuery(this).attr('rel');
			if(wp.media){
				//e.preventDefault();
				// Set options for 1st frame render
				var options = {
					state: 'insert',
					frame: 'post'
				};
	
				frame = wp.media(options).open();
				
				// Tweak views
				frame.menu.get('view').unset('gallery');
				frame.menu.get('view').unset('featured-image');
										
				frame.toolbar.get('view').set({
					insert: {
						style: 'primary',
						text: '<?php _e("Insert", "junkie"); ?>',
	
						click: function() {
							var models = frame.state().get('selection'),
								imageID = models.first().attributes.id;
								url = models.first().attributes.url;
				
							jQuery('input[name=junkie_store_image_id]').val(imageID);
								jQuery('#stores_image img').attr('src', url);
								jQuery('#button_remove_image').show();
								jQuery('#button_add_image').hide();
							frame.close();
						}
					}
				});
			
			}else{
				
				alert('plz, update your wordpress to v3.1+ .');
						
			}
			return false;
		});

		jQuery('#button_remove_image').live('click', function() {
			jQuery('#stores_image img').attr('src', '<?php echo get_template_directory_uri(); ?>/images/store-default.png');
			jQuery('#junkie_store_image_id').val('');
			jQuery('#button_remove_image').hide();
			jQuery('#button_add_image').show();
			return false;
		});
	});
	//]]>
	</script>

<?php
}

add_action( 'coupon_store_edit_form_fields', 'junkie_edit_stores', 10, 2 );

/*-----------------------------------------------------------------------------------*/
/*	admin page's column show
/*-----------------------------------------------------------------------------------*/
// return store image url with specified size
function junkie_get_store_image_url( $id, $type = 'post_id', $width = 110 ) {
	$store_url = false;
	$store_image_id = false;

	$sizes = array( 75 => 'thumb-med', 110 => 'post-thumbnail', 150 => 'thumb-store', 160 => 'thumb-featured', 250 => 'thumb-large-preview' );
	$sizes = apply_filters( 'junkie_store_image_sizes', $sizes );

	if ( ! array_key_exists( $width, $sizes ) )
		$width = 110;

	if ( ! isset( $sizes[ $width ] ) )
		$sizes[$width] = 'post-thumbnail';

	if ( $type == 'term_id' && $id ) {
		
		$store_url = get_metadata('coupon_store', $id, 'junkie_store_url', true);
		
		$store_image_id = get_metadata('coupon_store', $id, 'junkie_store_image_id', true);
	}

	if ( $type == 'post_id' && $id ) {
		$term_id = appthemes_get_custom_taxonomy($id, 'coupon_store', 'term_id');
		$store_url = get_metadata('coupon_store', $term_id, 'junkie_store_url', true);
		$store_image_id = get_metadata('coupon_store', $term_id, 'junkie_store_image_id', true);
	}

	if ( is_numeric( $store_image_id ) ) {
		$store_image_src = wp_get_attachment_image_src( $store_image_id, $sizes[ $width ] );
		if ( $store_image_src )
			return $store_image_src[0];
	}else {
		$store_image_url =  get_template_directory_uri() . '/images/store-default.png';
		return apply_filters( 'junkie_store_default_image', $store_image_url, $width );
	}
	/*

	if ( ! empty( $store_url ) ) {
		$store_image_url = "http://s.wordpress.com/mshots/v1/" . urlencode($store_url) . "?w=" . $width;
		return apply_filters( 'junkie_store_image', $store_image_url, $width, $store_url );
	} 
	*/

}

// setup "Coupons" columns
function custom_coupons_columns( $column, $post_id ) {//code
	//global $taxonomy;
    switch ( $column ) {
		case 'cp_store':
			$cp_store = wp_get_post_terms( $post_id,'coupon_store');
			echo $cp_store[0]->name ;
			break;
		case 'cp_cat':
			$cp_cat = wp_get_post_terms( $post_id,'coupon_cat');
			echo $cp_cat[0]->name ;
			break;
		case 'cp_type':
			echo get_post_meta( $post_id,'coupon_type' , true);
			break;
		case 'cp_codes':
			$coupon_type=get_post_meta( $post_id,'coupon_type' , true);
			if ($coupon_type=='Coupon Code'):
				echo get_post_meta( $post_id,'coupon_code' , true);
			endif;	
			if ($coupon_type=='Printable Coupon'):
				$attachment_image=wp_get_attachment_image_src( get_post_meta($post_id, 'print_imageid', true) );
				echo "<img src='".$attachment_image[0]."' width='80' />";
			endif;	
			if ($coupon_type=='Promotion'):
				echo "No code";
			endif;	
			if ($coupon_type=='best Deal'):
				echo get_post_meta( $post_id,'coupon_code' , true);
			endif;		
			break;
		case 'cp_votes':
		    $likeit=get_post_meta($post_id, 'likeit',true);
			if($likeit=='')
			$likeit=0;
			$unlikeit=get_post_meta($post_id, 'unlikeit',true);
			if($unlikeit=='')
			$unlikeit=0;
			echo $likeit." / ".$unlikeit;
			break;
		case 'cp_cv':
			$click_point=get_post_meta($post_id, 'click_point',true);
			if($click_point=='')
			$click_point=0;
			$view_point=get_post_meta($post_id, 'view_point',true);
			if($view_point=='')
			$view_point=0;
			echo $click_point." / ".$view_point;
			break;
		case 'cp_ctr':
			$click_point=get_post_meta($post_id, 'click_point',true);
			if($click_point=='')
			$click_point=0;
			$view_point=get_post_meta($post_id, 'view_point',true);
			if($view_point=='')
			$view_point=0;
			if($click_point>=$view_point)
				echo "100%";
			else
				echo round($click_point/$view_point*100,2)."%";
			break;
		default:
			break;

    }
}
function coupons_column_headers($columns){//face
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'title' => __( 'Title', 'junkie' ),
		'author' => __( 'Submitted',  'junkie' ),
		'cp_store' => __( 'Store',  'junkie' ),
		'cp_cat' => __( 'Categories',  'junkie' ),
		'cp_type' => __( 'Type',  'junkie' ),
		'cp_codes' => __( 'Coupon',  'junkie' ),
		
		'cp_votes' => __( 'Votes',  'junkie' ),
		'cp_cv' => __( 'Clicks / Views',  'junkie' ),
		'cp_ctr' => __( 'CTR', 'junkie' ),
		'date' => __( 'Date',  'junkie' ),
		'comments' => '<div class="vers"><img alt="" src="' . esc_url( admin_url( 'images/comment-grey-bubble.png' ) ) . '" /></div>',
		
		'thumbnail' => __( 'Thumbnail', 'junkie' ),
	);	
	return $columns;	
}
add_filter( 'manage_coupon_posts_custom_column', 'custom_coupons_columns', 10, 3 );
add_filter('manage_edit-coupon_columns', 'coupons_column_headers', 10, 1);


// setup "Stores" columns
function junkie_stores_column_headers($columns){
	$columns = array(
		'cb' => '<input type="checkbox" />',
		'junkie_store_image' => __( 'Image', 'junkie' ),
		'name' => __( 'Name',  'junkie' ),
		
		//'short_description' => __( 'Description',  'junkie' ),
		'junkie_store_url' => __( 'Store URL',  'junkie' ),
		'junkie_store_aff_url' => __( 'Destination ',  'junkie' ),
		'slug' => __( 'Slug',  'junkie' ),
		'junkie_store_active' => __( 'Active',  'junkie' ),
		'posts' => __( 'Coupons', 'junkie' ),
		//'junkie_store_clicks' => __( 'Clicks', APP_TD )
	);	
	return $columns;	
}
function custom_columns( $row_content, $column_name, $term_id ) {
	global $taxonomy;
    switch ( $column_name ) {

		case 'junkie_store_image':
			return '<img class="store-thumb'.$term_id.'" src="' . junkie_get_store_image_url($term_id, 'term_id', 75). '" width="75px" />';
			break;
		case 'junkie_store_url':
			echo  get_metadata('coupon_store', $term_id, 'junkie_store_url', true);
			break;
		case 'junkie_store_aff_url':
			echo  get_metadata('coupon_store', $term_id, 'junkie_store_aff_url', true);;
			break;
			
		case 'junkie_store_active':
			echo get_metadata('coupon_store', $term_id, 'junkie_store_active', true);;
			break;
		default:
			echo "err";
			break;

    }
}
add_filter( 'manage_coupon_store_custom_column', 'custom_columns', 10, 3 );
add_filter('manage_edit-coupon_store_columns', 'junkie_stores_column_headers', 10, 1);

// add the store custom meta field
function coupon_create_stores( $term_id, $tt_id ) {
	//echo $term_id; die();
	if ( ! $term_id )
		return;
		//echo  $_POST['junkie_store_url'];
	if ( isset( $_POST['junkie_store_image_id'] ) && is_numeric( $_POST['junkie_store_image_id'] ) )
		update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_image_id', $_POST['junkie_store_image_id'] );
	if ( isset( $_POST['junkie_store_url'] ) )
	    update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_url', $_POST['junkie_store_url']);
	if ( isset( $_POST['junkie_store_aff_url'] ) )
	    update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_aff_url', $_POST['junkie_store_aff_url']);
		
	update_metadata( 'coupon_store', $term_id, 'junkie_store_active','yes' );
		
}
add_action( 'created_coupon_store', 'coupon_create_stores', 10, 3 );


// edit the store url custom meta field
function coupon_edit_stores( $term_id, $tt_id ) {
	if ( ! $term_id )
		return;

	if ( isset( $_POST['junkie_store_image_id'] ) && is_numeric( $_POST['junkie_store_image_id'] ) )
		update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_image_id', $_POST['junkie_store_image_id'] );

	if ( isset( $_POST['junkie_store_url'] ) )
		update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_url', $_POST['junkie_store_url'] );

	if ( isset( $_POST['junkie_store_aff_url'] ) )
		update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_aff_url', $_POST['junkie_store_aff_url'] );
		
	if ( isset( $_POST['junkie_store_aff_url_cloaked'] ) )
		update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_aff_url_cloaked', $_POST['junkie_store_aff_url_cloaked'] );

	if ( isset( $_POST['junkie_store_active'] ) )
		update_metadata( $_POST['taxonomy'], $term_id, 'junkie_store_active', $_POST['junkie_store_active'] );		

}
add_action( 'edited_coupon_store', 'coupon_edit_stores', 10, 2 );
function custom_post_status(){
	global $wpdb;
	register_post_status( 'expire', array(
		'label'                     => _x( 'Expire', 'post' ),
		'public'                    => true,
		'exclude_from_search'       => false,
		'show_in_admin_all_list'    => true,
		'show_in_admin_status_list' => true,
		'label_count'               => _n_noop( 'Expired <span class="count">(%s)</span>', 'Expired <span class="count">(%s)</span>		' )
	) );
	$blog_id=get_current_blog_id();
	if($blog_id>1)
		$blog_id='_'.$blog_id;
	else
		$blog_id='';	
	$sql="update wp".$blog_id."_posts p left join wp".$blog_id."_postmeta m on p.ID=m.post_id set p.post_status='expire'
		  WHERE p.post_type = 'coupon'
		  AND m.meta_key = 'expire_date'
		  AND m.meta_value<>''
		  AND unix_timestamp(m.meta_value) < unix_timestamp(CURDATE())";
	$wpdb->query($sql);
}
add_action( 'init', 'custom_post_status' );

?>
