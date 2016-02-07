<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" <?php language_attributes( 'xhtml' ); ?>>
<head profile="http://gmpg.org/xfn/11">
<meta http-equiv="Content-Type" content="<?php bloginfo('html_type'); ?>" charset="<?php bloginfo('charset'); ?>" />
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
<title><?php tj_custom_titles(); ?></title>
<?php tj_custom_description(); ?>
<?php tj_custom_keywords(); ?>
<?php tj_custom_canonical(); ?>
<link rel="stylesheet" type="text/css" media="all" href="<?php  echo bloginfo( 'stylesheet_url' ); ?>" />
<?php wp_head(); ?>
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<?php global $shortname; ?>
<body <?php body_class(); ?>>
<?php
//ini_set("display_errors","ON");
//error_reporting(E_ALL);
?>
	<?php if (get_option($shortname.'_header_ad_enable') == 'on') { ?>
		<div class="header-ad clearfix">
			<?php echo get_option($shortname.'_header_ad_code'); ?>
		</div><!-- .header-ad -->
	<?php } ?>
				
	<div id="header">
		<div class="container clearfix">
		<?php
			$logo = (get_option($shortname.'_logo') <> '') ? get_option($shortname.'_logo') : get_template_directory_uri().'/images/logo.png';
			if (get_option($shortname.'_text_logo_enable') == 'on') { 
		?>
			<div id="text-logo">
				<h1 id="site-title"><a href="<?php echo home_url(); ?>"><?php bloginfo('name'); ?></a></h1>
				<p id="site-desc"><?php bloginfo('description'); ?></p>
			</div><!-- #text-logo -->
		<?php } else { ?>
			<a href="<?php echo home_url(); ?>">
				<img src="<?php echo ($logo) ?>" alt="<?php bloginfo('name'); ?>" id="logo"/>
			</a>
		<?php } ?>
		
		<?php get_search_form(); ?>
		
			<ul class="header-social-icons">
				<li class="follow-text">Follow us :</li>
				<li class="ico-twitter"><a href="<?php echo get_option($shortname.'_twitter_url'); ?>" title="Follow us on Twitter">Twitter</a></li>
				<li class="ico-facebook"><a href="<?php echo get_option($shortname.'_facebook_page_url'); ?>" title="Become our fan">Facebook</a></li>
				<li class="ico-google-plus"><a href="<?php echo get_option($shortname.'_google_plus_url'); ?>" title="Join our circle">Google Plus</a></li>
				<li class="ico-rss"><a href="<?php echo get_option($shortname.'_rss_url'); ?>" title="Subscribe to RSS">RSS</a></li>
			</ul><!-- .header-social-icons -->

			<div class="btn-nav-right">
				<?php _e('Menu', 'junkie'); ?> 
			</div><!-- .btn-nav-right -->
									
		</div><!-- .container -->
	</div><!-- #header -->
	
	<div id="primary-nav">
		<div class="container">
		<?php 
			$menuClass = 'nav';
			$menuID = 'primary-navigation';
			$primaryNav = '';
			if (function_exists('wp_nav_menu')) {
				$primaryNav = wp_nav_menu( array( 'theme_location' => 'primary-nav', 'container' => '', 'fallback_cb' => '', 'menu_class' => $menuClass, 'menu_id' => $menuID, 'echo' => false ) );
			};
			if ($primaryNav == '') { 
		?>
			<ul id="<?php echo $menuID; ?>" class="<?php echo $menuClass; ?>">
				<?php if (get_option($shortname.'_home_link') == 'on') { ?>
					<li class="first"><a href="<?php echo home_url() ; ?>"><?php _e('Home', 'junkie') ?></a></li>
				<?php } ?>				
				<?php show_page_menu($menuClass,false,false); ?>
			</ul>
		<?php 
			} else echo ($primaryNav); 
		?>
		</div><!-- .container -->
	</div><!-- #primary-nav -->

	<nav id="mobile-menu">
		<div class="container">
			<?php
				 $menuClass = 'ul';
					$menuID = 'responsive-menu';
					$res_menu = '';
					$response_menu_args = array( 
						'theme_location' => 'primary-nav', 
						'container' => '', 
						'fallback_cb' => '', 
						'menu_class' => $menuClass, 
						'menu_id' => $menuID, 
						'echo' => false 
					);
				$res_menu = wp_nav_menu( $response_menu_args); 
				if ($res_menu) {
					
					echo $res_menu;
					
				}else{
					echo '<ul id="responsive-menu">';
					show_page_menu($menuClass,false,false); 
					echo '</ul>';
				}
			?>
		</div><!-- .container -->
	</nav><!-- #mobile-menu -->
		
	<div id="main" class="container clearfix">