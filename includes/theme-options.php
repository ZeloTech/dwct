<?php
$admincpMainTabs = array('general','navigation','layout','ad','seo','integration','doc');
$shortname = 'Deals';

/*
praments:

@type:

### table control ###	
contenttab-wrapstart
subnavtab-start
subnav-tab
subnavtab-end
subcontent-start
session-heading

### replay element ###
slider
--id
--type
--std
--desc
	
checkbox
checkbox
	--new option "lable" follow checkbox--
	
radios
number

cat_select
colorpicker
different_checkboxes
select
textcolorpopup
text
textlimit
textarea
upload

### spacial custom replay element ###
checkboxes
doc
*/ 


$cats_array = get_categories(array('hide_empty'=>0,'orderby'=>'term_group'));
$pages_array = get_pages('hide_empty=0');
$pages_number = count($pages_array);

$site_pages = array();
$site_cats = array();

foreach ($pages_array as $pagg) {
	$site_pages[$pagg->ID] = htmlspecialchars($pagg->post_title);
	$pages_ids[] = $pagg->ID;
}

foreach ($cats_array as $categs) {
	$site_cats[$categs->cat_ID] = $categs->cat_name;
	$cats_ids[] = $categs->cat_ID;
}

$options = array (

	array( "name" => "nav-general",
		   "type" => "contenttab-wrapstart",),

		array( "name" => "general-1",
			   "type" => "subcontent-start",),

			array( "name" => "general-settings",
				   "type" => "session-heading",
				   "desc" => "General Settings"),			   

			array( "name" => "Theme Color",
				   "id" => $shortname."_theme_stylesheet",
				   "type" => "radios",
				   "std" => "Green",
				   "options" => array("Blue","Green","Orange","Red"),
				   "desc" => "",),	 			   

			array( "name" => "Logo",
				   "id" => $shortname."_logo",
				   "type" => "upload",
				   "std" => get_template_directory_uri() . '/images/logo.png',
				   "desc" => ""
			),

			array( "name" => "Site Title & Tagline",
                   "id" => $shortname."_text_logo_enable",
                   "type" => "checkbox",
                   "std" => "false",
				   "label" => "Show text-based logo (site title & description)",
                   "desc" => ""),			

			array( "name" => "Favicon",
				   "id" => $shortname."_favicon",
				   "type" => "upload",
				   "std" => get_template_directory_uri() . '/images/favicon.png',
				   "desc" => ""
			),

			array( "name" => "Contact Form E-mail",
				   "id" => $shortname."_email",
				   "type" => "text",
				   "std" => 'info@yourdomain.com',
				   "desc" => "",
				   ),				
						
			array( "name" => "Quick CSS",
				   "id" => $shortname."_custom_css",
				   "type" => "textarea",
				   "std" => "body { }",
				   "desc" => "",),

			array( "name" => "Footer Copyright",
				   "id" => $shortname."_footer_credit",
				   "type" => "textarea",
				   "std" => "<a href=\"http://www.theme-junkie.com\">WordPress Coupon Theme</a> by <a href=\"http://www.theme-junkie.com\">Theme Junkie</a>",
				   "desc" => "",),

			array( "name" => "url-structure",
				   "type" => "session-heading",
				   "desc" => "Coupon URLs Struture"),	
				   
			array( "name" => "Coupon Base",
				   "id" => $shortname."_coupon_single_url",
				   "type" => "text",
				   "std" => "coupons",
				   "desc" => "",
				   ),				   
			array( "name" => "Coupon Category Base",
				   "id" => $shortname."_coupon_cat_url",
				   "type" => "text",
				   "std" => "coupon-categories",
				   "desc" => "",
				   ),
			array( "name" => "Coupon Store Base",
				   "id" => $shortname."_coupon_stroe_url",
				   "type" => "text",
				   "std" => "stores",
				   "desc" => "",
				   ),
			array( "name" => "Coupon Type Base",
				   "id" => $shortname."_coupon_type_url",
				   "type" => "text",
				   "std" => "coupon-types",
				   "desc" => "",
				   ),
			array( "name" => "Coupon Tag Base",
				   "id" => $shortname."_coupon_tag_url",
				   "type" => "text",
				   "std" => "coupon-tags",
				   "desc" => "You must <a href=\"".home_url()."/wp-admin/options-permalink.php\">re-save your permalinks</a> for the above changes to take effect.",
				   ),
				   				   

			array( "name" => "social-icons",
				   "type" => "session-heading",
				   "desc" => "Social Icons"),
				   				   
			array( "name" => "Custom RSS Link",
				   "id" => $shortname."_rss_url",
				   "type" => "text",
				   "std" => 'http://feeds.feedburner.com/ThemeJunkie',
				   "desc" => "",
				   ),
				   
			array( "name" => "Twitter Link",
				   "id" => $shortname."_twitter_url",
				   "type" => "text",
				   "std" => 'http://twitter.com/theme_junkie',
				   "desc" => "",
				   ),
				   
			array( "name" => "Facebook Link",
				   "id" => $shortname."_facebook_page_url",
				   "type" => "text",
				   "std" => "http://www.facebook.com/#",
				   "desc" => "",
				   ),

			array( "name" => "Google Plus Link",
				   "id" => $shortname."_google_plus_url",
				   "type" => "text",
				   "std" => 'https://plus.google.com/#',
				   "desc" => "",
				   ),   				   			   				   			   				   				   				   				   

			array( "type" => "clearfix",),

		array( "name" => "general-1",
			   "type" => "subcontent-end",),		   

		array( "type" => "subnavtab-end",),					   

	array(  "name" => "nav-general",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "nav-navigation",
		   "type" => "contenttab-wrapstart",),

		   array( "name" => "navigation-1",
			   	  "type" => "subcontent-start",),

			array( "name" => "pages-nav",
				   "type" => "session-heading",
				   "desc" => "Pages"),

			array( "name" => "Home Link",
		            "id" => $shortname."_home_link",
		            "type" => "checkbox",
		            "std" => "on",
		            "label" => "Show home link on the page menu",
					"desc" => ""
			),				   			   

			array( "name" => "Exclude pages from the page menu",
				   "id" => $shortname."_menupages",
				   "type" => "checkboxes",
				   "std" => "",
				   "desc" => "",
				   "usefor" => "pages",
				   "options" => $pages_ids),
			array( "name" => "Dropdown Menus",
		            "id" => $shortname."_enable_dropdowns_pages",
		            "type" => "checkbox",
		            "std" => "on",
		            "label" => "Show dropdown page menus",
					"desc" => ""),
			array( "name" => "Number of dropdown tiers shown",
		            "id" => $shortname."_tiers_shown_pages",
		            "type" => "number",
		            "std" => "4",
					"desc" => ""),
			array( "name" => "Sort Pages Links",
                   "id" => $shortname."_sort_pages",
                   "type" => "select",
                   "std" => "post_title",
				   "desc" => "",
                   "options" => array("post_title", "menu_order","post_date","post_modified","ID","post_author","post_name")),

			array( "name" => "Order Pages Links",
                   "id" => $shortname."_order_page",
                   "type" => "select",
                   "std" => "asc",
				   "desc" => "",
                   "options" => array("asc", "desc")),
			array( "type" => "clearfix",),

		array( "name" => "navigation-1",
			   "type" => "subcontent-end",),

	array( "name" => "nav-navigation",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "nav-layout",
		   "type" => "contenttab-wrapstart",),

		array( "name" => "layout-1",
			   "type" => "subcontent-start",),

			array( "name" => "homepage",
				   "type" => "session-heading",
				   "desc" => "Homepage"),

			array( "name" => "Layout",
            	   "id" => $shortname."_layout",
            	   "type" => "radios",
                   "std" => "Responsive",
                   'options' => array("Responsive","Fixed"),                   
			       "desc" => ""),				   				   

/*			array( "name" => "Post Boxes Width",
				   "id" => $shortname."_home_element",
				   "type" => "slider",
				   "std" => "222",
				   "desc" => "Move to resize the width of post boxes"),
*/				   		

			array( "name" => "Featured Slider",
            	   "id" => $shortname."_featured_slider_enable",
            	   "type" => "checkbox2",
            	   "label" => "Show featured slider on homepage",
                   "std" => "on"),

			array( "name" => "Num. of featured coupons",
            	   "id" => $shortname."_featured_posts_num",
            	   "type" => "number",
                   "std" => "2"),			
			 
			array( "type" => "clearfix",),
			
			array( "name" => "Coupon-Submission Page",
				   "type" => "session-heading",
				   "desc" => "Coupon Submission Page"),
			array( "name" => "Open submission form for",
            	   "id" => $shortname."_open_submit",
            	   "type" => "radios",
                   "std" => "Everyone",
                   'options' => array("Everyone","Registered users only"),
			       "desc" => ""),
			array( "name" => "Add new store",
            	   "id" => $shortname."_new_store_enable",
            	   "type" => "checkbox",
                   "std" => "",
                   'label' => "Enable adding new store",
			       "desc" => ""),
			array( "name" => "Add new coupon tags",
            	   "id" => $shortname."_new_tags_enable",
            	   "type" => "checkbox",
                   "std" => "",
                   'label' => "Enable adding new coupon tags",
			       "desc" => ""),
			array( "name" => "Verification Code",
            	   "id" => $shortname."_verification_enable",
            	   "type" => "checkbox",
                   "std" => "on",
                   'label' => "Enable verification code for the submission form",
			       "desc" => ""),

				   
			array( "name" => "single-posts-pages",
				   "type" => "session-heading",
				   "desc" => "Single Posts / Pages"),	
				   
			array( "name" => "Post Comments",
            	   "id" => $shortname."_show_post_comments",
            	   "type" => "checkbox",
                   "std" => "on",
                   "label" => "Show comments on posts",                   
			       "desc" => ""),

			array( "name" => "Page Comments",
            	   "id" => $shortname."_show_page_comments",
            	   "type" => "checkbox",
                   "std" => "false",
                   "label" => "Show comments on pages",                   
			       "desc" => ""),			       

			array( "type" => "clearfix",),			

		array( "name" => "layout-2",
			   "type" => "subcontent-end",),

	array( "name" => "nav-layout",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//
//-------------------------------------------------------------------------------------//

	array( "name" => "nav-advertisements",
		   "type" => "contenttab-wrapstart",),		   

		array( "name" => "advertisements-1",
			   "type" => "subcontent-start",),

			array( "name" => "un-widgetized-ad",
				   "type" => "session-heading",
				   "desc" => "Un-Widgetized Advertisements"),			   

			array( "name" => "Show header ad",
				   "id" => $shortname."_header_ad_enable",
				   "type" => "checkbox",
				   "std" => "false",
				   'label' => "Yes",
				   "desc" => "Ad block on top of the site",),
				   
			array( "name" => "Input header ad code",
				   "id" => $shortname."_header_ad_code",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "Size: 728 x 90",), 				   				   					   

		array( "name" => "advertisements-1",
			   "type" => "subcontent-end",),
			   
	array( "name" => "nav-advertisements",
		   "type" => "contenttab-wrapend",),			   

//-------------------------------------------------------------------------------------//
	array( "name" => "nav-seo",
		   "type" => "contenttab-wrapstart",),

		array( "name" => "seo-1",
			   "type" => "subcontent-start",),

			array( "name" => "homepage-seo",
				   "type" => "session-heading",
				   "desc" => "Homepage SEO"),			   

			array( "name" => "Enable custom title",
				   "id" => $shortname."_seo_home_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",
				   "desc" => "By default the theme uses a combination of your blog name and your blog description, as defined when you created your blog, to create your homepage titles. However if you want to create a custom title then simply enable this option and fill in the custom title field below. ",),

			array( "name" => "Enable meta description",
				   "id" => $shortname."_seo_home_description",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",
				   "desc" => "By default the theme uses your blog description, as defined when you created your blog, to fill in the meta description field. If you would like to use a different description then enable this option and fill in the custom description field below. ",),

			array( "name" => " Enable meta keywords",
				   "id" => $shortname."_seo_home_keywords",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",
				   "desc" => "By default the theme does not add keywords to your header. Most search engines don't use keywords to rank your site anymore, but some people define them anyway just in case. If you want to add meta keywords to your header then enable this option and fill in the custom keywords field below. ",),

			array( "name" => " Enable canonical URL's",
				   "id" => $shortname."_seo_home_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",				   
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URLs all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Homepage custom title (if enabled)",
				   "id" => $shortname."_seo_home_titletext",
				   "type" => "text",
				   "std" => "",
				   "desc" => "If you have enabled custom titles you can add your custom title here. Whatever you type here will be placed between the < title >< /title > tags in header.php",),

			array( "name" => "Homepage meta description (if enabled)",
				   "id" => $shortname."_seo_home_descriptiontext",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "If you have enabled meta descriptions you can add your custom description here.",),

			array( "name" => "Homepage meta keywords (if enabled)",
				   "id" => $shortname."_seo_home_keywordstext",
				   "type" => "text",
				   "std" => "",
				   "desc" => "If you have enabled meta keywords you can add your custom keywords here. Keywords should be separated by comas. For example: wordpress,themes,templates,elegant",),

			array( "name" => "If custom titles are disabled, choose autogeneration method",
				   "id" => $shortname."_seo_home_type",
				   "type" => "select",
				   "std" => "BlogName | Blog description",
				   "options" => array("BlogName | Blog description", "Blog description | BlogName", "BlogName only"),
				   "desc" => "If you are not using cutsom post titles you can still have control over how your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_home_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",),

			array( "name" => "single-post-page-seo",
				   "type" => "session-heading",
				   "desc" => "Single Post Page SEO"),	

			array( "name" => "Enable custom titles",
				   "id" => $shortname."_seo_single_title",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",				   
				   "desc" => "By default the theme creates post titles based on the title of your post and your blog name. If you would like to make your meta title different than your actual post title you can define a custom title for each post using custom fields. This option must be enabled for custom titles to work, and you must choose a custom field name for your title below.",),

			array( "name" => "Enable custom description",
				   "id" => $shortname."_seo_single_description",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",				   
				   "desc" => "If you would like to add a meta description to your post you can do so using custom fields. This option must be enabled for descriptions to be displayed on post pages. You can add your meta description using custom fields based off the custom field name you define below.",),

			array( "type" => "clearfix",),

			array( "name" => "Enable custom keywords",
				   "id" => $shortname."_seo_single_keywords",
				   	"type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",				   
				   "desc" => "If you would like to add meta keywords to your post you can do so using custom fields. This option must be enabled for keywords to be displayed on post pages. You can add your meta keywords using custom fields based off the custom field name you define below.",),

			array( "name" => "Enable canonical URL's",
				   "id" => $shortname."_seo_single_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",				   
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Custom field Name to be used for title",
				   "id" => $shortname."_seo_single_field_title",
				   "type" => "text",
				   "std" => "seo_title",
				   "desc" => "When you define your title using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom title you would like to use.",),

			array( "name" => "Custom field Name to be used for description",
				   "id" => $shortname."_seo_single_field_description",
				   "type" => "text",
				   "std" => "seo_description",
				   "desc" => "When you define your meta description using custom fields you should use this value for the custom field Name. The Value of your custom field should be the custom description you would like to use.",),

			array( "name" => "Custom field Name to be used for keywords",
				   "id" => $shortname."_seo_single_field_keywords",
				   "type" => "text",
				   "std" => "seo_keywords",
				   "desc" => "When you define your keywords using custom fields you should use this value for the custom field Name. The Value of your custom field should be the meta keywords you would like to use, separated by comas.",),

			array( "name" => "If custom titles are disabled, choose autogeneration method",
				   "id" => $shortname."_seo_single_type",
				   "type" => "select",
				   "std" => "Post title | BlogName",
				   "options" => array("Post title | BlogName", "BlogName | Post title", "Post title only"),
				   "desc" => "If you are not using cutsom post titles you can still have control over hw your titles are generated. Here you can choose which order you would like your post title and blog name to be displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_single_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and post name when using autogenerated post titles. Common values are | or -",),

			array( "name" => "index-page-seo",
				   "type" => "session-heading",
				   "desc" => "Index Page SEO"),

			array( "name" => " Enable canonical URL's",
				   "id" => $shortname."_seo_index_canonical",
				   "type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",				   
				   "desc" => "Canonicalization helps to prevent the indexing of duplicate content by search engines, and as a result, may help avoid duplicate content penalties and pagerank degradation. Some pages may have different URL's all leading to the same place. For example domain.com, domain.com/index.html, and www.domain.com are all different URLs leading to your homepage. From a search engine's perspective these duplicate URLs, which also occur often due to custom permalinks, may be treaded individually instead of as a single destination. Defining a canonical URL tells the search engine which URL you would like to use officially. The theme bases its canonical URLs off your permalinks and the domain name defined in the settings tab of wp-admin.",),

			array( "name" => "Enable meta descriptions",
				   "id" => $shortname."_seo_index_description",
				   	"type" => "checkbox",
				   "std" => "false",
				   "label" => "Yes",				   
				   "desc" => "Check this box if you want to display meta descriptions on category/archive pages. The description is based off the category description you choose when creating/edit your category in wp-admin.",),

			array( "type" => "clearfix",),

			array( "name" => "Choose title autogeneration method",
				   "id" => $shortname."_seo_index_type",
				   "type" => "select",
				   "std" => "Category name | BlogName",
				   "options" => array("Category name | BlogName", "BlogName | Category name", "Category name only"),
				   "desc" => "Here you can choose how your titles on index pages are generated. You can change which order your blog name and index title are displayed, or you can remove the blog name from the title completely.",),

			array( "name" => "Define a character to separate BlogName and Post title",
				   "id" => $shortname."_seo_index_separate",
				   "type" => "text",
				   "std" => " | ",
				   "desc" => "Here you can change which character separates your blog title and index page name when using autogenerated post titles. Common values are | or -",),

			array( "type" => "clearfix",),

		array( "name" => "seo-1",
				   "type" => "subcontent-end",),

	array(  "name" => "nav-seo",
			"type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "nav-integration",
		   "type" => "contenttab-wrapstart",),

		array( "name" => "integration-1",
			   "type" => "subcontent-start",),
			   
			array( "name" => "code-integration",
				   "type" => "session-heading",
				   "desc" => "Code Integration "),			   

			array( "name" => "Enable Head code",
                   "id" => $shortname."_integrate_header_enable",
                   "type" => "checkbox",
                   "std" => "false",
                   "label" => "Yes",
                   "desc" => ""),
                   
			array( "name" => "Enable body code",
                   "id" => $shortname."_integrate_body_enable",
                   "type" => "checkbox",
                   "std" => "false",
                   "label" => "Yes",                   
                   "desc" => ""), 

			array( "name" => "Enable single top code",
                   "id" => $shortname."_integrate_singletop_enable",
                   "type" => "checkbox",
                   "std" => "false",
                   "label" => "Yes",                   
                   "desc" => ""), 

			array( "name" => "Enable single bottom code",
                   "id" => $shortname."_integrate_singlebottom_enable",
                   "type" => "checkbox",
                   "std" => "false",
                   "label" => "Yes",                   
                   "desc" => ""),                                                     

			array( "name" => "Add code to the < head > of your blog",
				   "id" => $shortname."_integration_head",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "",),         

			array( "name" => "Add code to the < body > of your blog (good for google analytics)",
				   "id" => $shortname."_integration_body",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "",),

			array( "name" => "Add code to the top of your posts",
				   "id" => $shortname."_integration_single_top",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "",),

			array( "name" => "Add code to the bottom of your posts, before the comments",
				   "id" => $shortname."_integration_single_bottom",
				   "type" => "textarea",
				   "std" => "",
				   "desc" => "",),

		array( "name" => "integration-1",
			   "type" => "subcontent-end",),

	array( "name" => "nav-integration",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

	array( "name" => "nav-doc",
		   "type" => "contenttab-wrapstart",),

		array( "type" => "subnavtab-start",),

			array( "name" => "doc-1",
				   "type" => "subnav-tab",
				   "desc" => "Installation"),

			array( "name" => "doc-2",
				   "type" => "subnav-tab",
				   "desc" => "Troubleshooting"),

		array( "type" => "subnavtab-end",),

		array( "name" => "doc-1",
			   "type" => "subcontent-start",),

			array( "name" => "installation",
				   "type" => "doc",),

		array( "name" => "doc-1",
			   "type" => "subcontent-end",),

		array( "name" => "doc-2",
			   "type" => "subcontent-start",),

			array( "name" => "troubleshooting",
				   "type" => "doc",),

		array( "name" => "doc-2",
			   "type" => "subcontent-end",),

	array( "name" => "nav-doc",
		   "type" => "contenttab-wrapend",),

//-------------------------------------------------------------------------------------//

); 


function custom_colors_css(){
	global $shortname; ?>
	
	<style type="text/css">
		body { color: #<?php echo(get_option($shortname.'_color_mainfont')); ?>; }
		#content-area a { color: #<?php echo(get_option($shortname.'_color_mainlink')); ?>; }
		ul.nav li a { color: #<?php echo(get_option($shortname.'_color_pagelink')); ?>; }
		ul.nav > li.current_page_item > a, ul#top-menu > li:hover > a, ul.nav > li.current-cat > a { color: #<?php echo(get_option($shortname.'_color_pagelink_active')); ?>; }
		h1, h2, h3, h4, h5, h6, h1 a, h2 a, h3 a, h4 a, h5 a, h6 a { color: #<?php echo(get_option($shortname.'_color_headings')); ?>; }
		
		#sidebar a { color:#<?php echo(get_option($shortname.'_color_sidebar_links')); ?>; }		
		div#footer { color:#<?php echo(get_option($shortname.'_footer_text')); ?> }
		#footer a, ul#bottom-menu li a { color:#<?php echo(get_option($shortname.'_color_footerlinks')); ?> }
	</style>

<?php };

?>