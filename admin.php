<?php
	
/**
 * admin.php
 *
 * Customize The WordPress Admin User Interface 
 *
 * @category   CategoryName
 * @package    PackageName
 * @author     Thibaud Alt <thibaud@we-studio.ch>
 * @copyright  2015 - Thibaud Alt
 * @version    0.9
 */
	
////////////////////////////////////////
// Login page 
////////////////////////////////////////

// Custom CSS Login 
function ws_login_css() { 
	wp_enqueue_style( 'ws_login_css', get_template_directory_uri().'/assets/styles/admin/ws-login.css'); 
} 

add_action('login_head', 'ws_login_css'); 

// Custom Logo URL 
function ws_login_url(){ 
	return esc_url( home_url( '/' ) ); 
} 

add_filter('login_headerurl', 'ws_login_url'); 

// Custom Logo Title 
function ws_login_logo_title() 
{ 
	return get_bloginfo('name');
}

add_filter( 'login_headertitle', 'ws_login_logo_title' );

// Remember me always checked 
function ws_login_checked_remember_me() 
{ 
	add_filter( 'login_footer', function(){ 
		echo "<script>document.getElementById('rememberme').checked = true;</script>"; 
	}); 
} 

add_action( 'init', 'ws_login_checked_remember_me' );

// Override the login error message
function ws_login_error_override()
{
    return '<strong>ERREUR</strong>&nbsp;: Informations de connexion incorrects.';
}
add_filter('login_errors', 'ws_login_error_override');

// Remove the login page shake
function ws_login_no_shake() 
{
	remove_action('login_head', 'wp_shake_js', 12);
}

add_action('login_head', 'ws_login_no_shake');

////////////////////////////////////////
// Customizing Admin
////////////////////////////////////////

// Load custom admin CSS
// http://codex.wordpress.org/Plugin_API/Action_Reference/admin_enqueue_scripts
function ws_admin_css()
{ 
	wp_enqueue_style('ws_admin_css', get_template_directory_uri().'/assets/styles/admin/ws-admin.css'); 
} 

// add_action( 'admin_enqueue_scripts', 'ws_admin_css' );

// Remove WordPress version in footer
// https://developer.wordpress.org/reference/hooks/update_footer/
function ws_admin_remove_version() 
{ 
	remove_filter( 'update_footer', 'core_update_footer' ); 
} 

add_action( 'admin_menu', 'ws_admin_remove_version' ); 

// Customize WordPress Footer Credits 
function ws_admin_custom_footer() 
{ 
	return '<p>© '.date("Y").' - Site web par <a href="http://we-studio.ch" title="We studio" target="_blank">We studio</a></p>'; 
}

add_filter('admin_footer_text', 'ws_admin_custom_footer');

// Favicon in WordPress admin 
// http://codex.wordpress.org/Plugin_API/Action_Reference/admin_head
function ws_admin_favicon()
{
	echo '<link rel="Shortcut Icon" type="image/x-icon" href="'.get_template_directory_uri().'/assets/images/favicon.ico" />';
} 

add_action('admin_head', 'ws_admin_favicon');

// Remove Help tab 
// http://codex.wordpress.org/Class_Reference/WP_Screen/add_help_tab
function ws_admin_remove_help( $old_help, $screen_id, $screen )
{ 
	$screen->remove_help_tabs(); return $old_help; 
} 

add_filter( 'contextual_help', 'ws_admin_remove_help', 999, 3 ); 

// Remove Dashboard widgets 
// http://codex.wordpress.org/Plugin_API/Action_Reference/wp_dashboard_setup
function ws_admin_remove_dashboard_widgets()
{
	remove_action('welcome_panel', 'wp_welcome_panel');						// Welcome Panel
	remove_meta_box('dashboard_primary', 'dashboard', 'side');  			// WordPress blog
	remove_meta_box('dashboard_secondary', 'dashboard', 'side');   			// Other WordPress News
	remove_meta_box('icl_dashboard_widget','dashboard','normal');			// WPML
	//remove_meta_box('dashboard_right_now', 'dashboard', 'normal');   		// Right Now
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal'); 	// Recent Comments
	//remove_meta_box('dashboard_incoming_links', 'dashboard', 'normal');  	// Incoming Links
	//remove_meta_box('dashboard_plugins', 'dashboard', 'normal');			// Plugins
	//remove_meta_box('dashboard_quick_press', 'dashboard', 'side');  		// Quick Press
	//remove_meta_box('dashboard_recent_drafts', 'dashboard', 'side');		// Recent Drafts
	//remove_meta_box('dashboard_recent_comments', 'dashboard', 'normal');	// Recent Comments
	//remove_meta_box('dashboard_activity', 'dashboard', 'normal');   		// Activity
}
add_action('wp_dashboard_setup', 'ws_admin_remove_dashboard_widgets');

// Custom widget dashboard 
// http://codex.wordpress.org/Function_Reference/wp_add_dashboard_widget
function ws_admin_add_dashboard_widgets() 
{ 
	wp_add_dashboard_widget('ws_summary_dashboard_widget', 'We studio', function(){ 
			
		echo '<table style="width:100%">'
				.'<tr><td>We Studio S&#224;rl<br>rue Côtes-de-Montbenon 30<br>CH-1003 Lausanne / VD</td>'
				.'<td>Mail : <a title="We studio" href="mailto:support@we-studio.ch">support@we-studio.ch</a><br>'
				.'Tel : <a href="tel:+41213114721">+41 21 311 47 21</a></p></td></tr>'
			.'</table>';
	}); 
} 

add_action('wp_dashboard_setup', 'ws_admin_add_dashboard_widgets' ); 

// Remove menu page 
// http://codex.wordpress.org/Plugin_API/Action_Reference/admin_menu
function ws_admin_remove_menus()
{ 
	//remove_menu_page('index.php'); 										// Dashboard 
	//remove_menu_page('edit.php'); 										// Posts 
	//remove_menu_page('upload.php' ); 										// Media 
	//remove_menu_page('edit.php?post_type=page'); 							// Pages 
	//remove_menu_page('edit.php?post_type=project'); 						// Projects
	remove_menu_page('edit-comments.php'); 									// Comments 
	//remove_menu_page('themes.php'); 										// Appearance 
	//remove_menu_page('plugins.php'); 										// Plugins 
	//remove_menu_page('users.php'); 										// Users 
	//remove_menu_page('tools.php'); 										// Tools 
	//remove_menu_page('options-general.php'); 								// Settings 
	//remove_menu_page('edit.php?post_type=acf-field-group'); 				// ACF 
	//remove_menu_page('sitepress-multilingual-cms/menu/languages.php');	// WPML
} 

add_action( 'admin_menu', 'ws_admin_remove_menus' );

// Remove submenu page
// http://codex.wordpress.org/Function_Reference/remove_submenu_page
function ws_admin_remove_submenus() 
{
	//remove_submenu_page('index.php','update-core.php');									// Updates
	//remove_submenu_page('edit.php','post-new.php');										// New post
	//remove_submenu_page('edit.php','edit-tags.php?taxonomy=category');					// Post categories
	//remove_submenu_page('edit.php','edit-tags.php?taxonomy=post_tag');					// Post tags
	//remove_submenu_page('upload.php','media-new.php');									// Add media
	//remove_submenu_page('edit.php?post_type=page','post-new.php?post_type=page');			// New page
	//remove_submenu_page('edit.php?post_type=project','post-new.php?post_type=project');	// New project
	//remove_submenu_page('themes.php','nav-menus.php'); 									// Menus
	remove_submenu_page('themes.php','theme-editor.php'); 									// Editor	
	//remove_submenu_page('plugins.php','plugin-install.php');								// Add plugin
	//remove_submenu_page('users.php','user-new.php');										// Add user
	//remove_submenu_page('users.php','profile.php');										// Profile
	remove_submenu_page('tools.php','import.php');											// Import
	remove_submenu_page('tools.php','export.php');											// Export
	//remove_submenu_page('options-general.php','options-writing.php');						// Writing settings
	//remove_submenu_page('options-general.php','options-reading.php');						// Reading settings
	remove_submenu_page('options-general.php','options-discussion.php');					// Discussion settings
	remove_submenu_page('options-general.php','options-media.php');							// Media settings
	//remove_submenu_page('options-general.php','options-permalink.php');					// Permalink settings
}

add_action( 'admin_menu', 'ws_admin_remove_submenus', 999 );

// Disable theme options
function ws_admin_disable_add_theme( $caps, $cap )
{
	if ( $cap === 'customize' ) $caps[] = 'do_not_allow';		// Customize 
    if ( $cap === 'install_themes' ) $caps[] = 'do_not_allow';	// Add theme
    return $caps;
    
}
add_filter( 'map_meta_cap', 'ws_admin_disable_add_theme', 10, 2 );

// Disable plugins options
function ws_admin_plugins_options( $actions, $plugin_file, $plugin_data, $context )
{  
	$plugins   = array();
	$plugins[] = 'advanced-custom-fields-pro/acf.php'; 			// ACF
	$plugins[] = 'wpremote/plugin.php'; 						// WP Remote
	$plugins[] = 'sitepress-multilingual-cms/sitepress.php';	// WPML 
	$plugins[] = 'wpml-string-translation/plugin.php';			// WPML string translation

	// Remove edit link for all plugins
	if ( array_key_exists( 'edit', $actions ) ) unset( $actions['edit'] ); 
	
	// Remove deactivate link for plugins in array
	if ( array_key_exists( 'deactivate', $actions ) && in_array( $plugin_file, $plugins)) unset( $actions['deactivate'] ); 
	
	return $actions; 
}

add_filter( 'plugin_action_links', 'ws_admin_plugins_options', 10, 4 ); 

////////////////////////////////////////
// Admin bar 
////////////////////////////////////////

// Remove elements from WordPress admin bar 
// http://codex.wordpress.org/Function_Reference/remove_node
function ws_admin_bar_remove_node( $wp_admin_bar ) 
{
	$wp_admin_bar->remove_node('wp-logo'); 			// WordPress logo
	//$wp_admin_bar->remove_node('site-name'); 		// Site name
	$wp_admin_bar->remove_menu('comments');   		// Comments
	//$wp_admin_bar->remove_menu('new-content');	// New content
	//$wp_admin_bar->remove_node('my-account'); 	// My account
	//$wp_admin_bar->remove_node('edit'); 			// Edit
	//$wp_admin_bar->remove_node('search'); 		// Search
	//$wp_admin_bar->remove_node('view'); 			// View 
	//$wp_admin_bar->remove_menu('view-site'); 		// View Site
 	//$wp_admin_bar->remove_node('menu-toggle'); 	// Menu toggle
 	
} 

add_action( 'admin_bar_menu', 'ws_admin_bar_remove_node', 999 ); 

// Remove WPML language switcher from admin bar
function ws_admin_bar_remove_wpml() 
{
	global $wp_admin_bar;
	$wp_admin_bar->remove_menu('WPML_ALS');
}

add_action( 'wp_before_admin_bar_render', 'ws_admin_bar_remove_wpml' );

// Remove the WordPress Logo from the WordPress Admin Bar
function wb_admin_bar_remove_howdy( $translation, $original ) 
{
    if( 'Howdy, %1$s' == $original ) $translation = '%1$s';
    return $translation;
}

add_filter( 'gettext', 'wb_admin_bar_remove_howdy', 10, 2 );

////////////////////////////////////////
// Edition
////////////////////////////////////////

// Enable full TinyMCE by default 
function wb_enable_full_TinyMCE( $in ) 
{ 
	$in['wordpress_adv_hidden'] = FALSE;
	return $in; 
} 

add_filter( 'tiny_mce_before_init', 'wb_enable_full_TinyMCE' );

// Add buttons in TinyMCE
// http://www.wpexplorer.com/wordpress-tinymce-tweaks/ 
function wb_add_button_in_TinyMCE( $buttons ) 
{ 
	$buttons[] = 'charmap';	// Special characters
	$buttons[] = 'cut';		// Cut
	$buttons[] = 'copy';	// Copy
	$buttons[] = 'paste';	// Past
	return $buttons; 
} 

add_filter("mce_buttons", "wb_add_button_in_TinyMCE"); 

// Remove Get Shortlink 
// https://developer.wordpress.org/reference/hooks/pre_get_shortlink/
add_filter( 'pre_get_shortlink', '__return_empty_string' );

// Remove post support
function ws_remove_post_support() 
{ 
	//remove_post_type_support( 'post', 'title' ); 				// Title
	//remove_post_type_support( 'post', 'editor' ); 			// Editor
	//remove_post_type_support( 'post', 'author' ); 			// Author
	//remove_post_type_support( 'post', 'thumbnail' ); 			// Thumbnail
	//remove_post_type_support( 'post', 'excerpt' ); 			// Excerpt
	//remove_post_type_support( 'post', 'trackbacks' ); 		// Trackbacks
	remove_post_type_support( 'post', 'custom-fields' ); 		// Custom fields
	remove_post_type_support( 'post', 'comments' ); 			// Comments
	//remove_post_type_support( 'post', 'revisions' ); 			// Revisions
	//remove_post_type_support( 'post', 'page-attributes' );	// Attributes
	remove_post_type_support( 'post', 'post-formats' ); 		// Formats
} 

add_action( 'admin_init', 'ws_remove_post_support' );

// Remove page support 
function ws_remove_page_support() 
{ 
	//remove_post_type_support( 'page', 'title' ); 				// Title
	//remove_post_type_support( 'page', 'editor' ); 			// Editor
	//remove_post_type_support( 'page', 'author' ); 			// Author
	//remove_post_type_support( 'page', 'thumbnail' ); 			// Thumbnail
	//remove_post_type_support( 'page', 'excerpt' ); 			// Excerpt
	//remove_post_type_support( 'page', 'trackbacks' ); 		// Trackbacks
	remove_post_type_support( 'page', 'custom-fields' ); 		// Custom fields
	remove_post_type_support( 'page', 'comments' ); 			// Comments
	//remove_post_type_support( 'page', 'revisions' ); 			// Revisions
	//remove_post_type_support( 'page', 'page-attributes' );	// Attributes
	remove_post_type_support( 'page', 'post-formats' ); 		// Formats
} 

add_action( 'admin_init', 'ws_remove_page_support' );

// Remove Screen Options 
// https://developer.wordpress.org/reference/hooks/screen_options_show_screen/
add_filter('screen_options_show_screen', '__return_false'); 

// Remove post metaboxes 
// http://codex.wordpress.org/Function_Reference/remove_meta_box
function ws_remove_post_meta_boxes() 
{
	remove_meta_box( 'authordiv', 			'post', 'normal' );	// Author
	//remove_meta_box( 'categorydiv', 		'post', 'normal' );	// Categories
	remove_meta_box( 'commentstatusdiv',	'post', 'normal' );	// Comments status 
	remove_meta_box( 'commentsdiv', 		'post', 'normal' );	// Comments
	remove_meta_box( 'formatdiv', 			'post', 'normal' );	// Formats
	remove_meta_box( 'pageparentdiv', 		'post', 'normal' );	// Attributes
	remove_meta_box( 'postcustom', 			'post', 'normal' );	// Custom fields
	remove_meta_box( 'postexcerpt', 		'post', 'normal' );	// Excerpt
	//remove_meta_box( 'postimagediv', 		'post', 'normal' );	// Featured image
	remove_meta_box( 'revisionsdiv', 		'post', 'normal' );	// Revisions
	remove_meta_box( 'slugdiv', 			'post', 'normal' );	// Slug
	//remove_meta_box( 'submitdiv', 		'post', 'normal' );	// Date, status, and update/save metabox
	//remove_meta_box( 'tagsdiv-post_tag', 	'post', 'normal' );	// Tags
	remove_meta_box( 'trackbacksdiv', 		'post', 'normal' );	// Trackbacks
} 

add_action( 'admin_menu', 'ws_remove_post_meta_boxes' );

// Remove page metaboxes 
// http://codex.wordpress.org/Function_Reference/remove_meta_box
function ws_remove_page_meta_boxes() 
{
	remove_meta_box( 'authordiv', 			'page', 'normal' );	// Author
	//remove_meta_box( 'categorydiv', 		'page', 'normal' );	// Categories
	remove_meta_box( 'commentstatusdiv',	'page', 'normal' );	// Comments status 
	remove_meta_box( 'commentsdiv', 		'page', 'normal' );	// Comments
	remove_meta_box( 'formatdiv', 			'page', 'normal' );	// Formats
	//remove_meta_box( 'pageparentdiv', 	'page', 'normal' );	// Attributes
	remove_meta_box( 'postcustom', 			'page', 'normal' );	// Custom fields
	remove_meta_box( 'postexcerpt', 		'page', 'normal' );	// Excerpt
	//remove_meta_box( 'postimagediv', 		'page', 'normal' );	// Featured image
	remove_meta_box( 'revisionsdiv', 		'page', 'normal' );	// Revisions
	remove_meta_box( 'slugdiv', 			'page', 'normal' );	// Slug
	//remove_meta_box( 'submitdiv', 		'page', 'normal' );	// Date, status, and update/save metabox
	//remove_meta_box( 'tagsdiv-post_tag', 	'page', 'normal' );	// Tags
	remove_meta_box( 'trackbacksdiv', 		'page', 'normal' );	// Trackbacks
} 

add_action( 'admin_menu', 'ws_remove_page_meta_boxes' );

// Remove WPML metaboxes
function ws_remove_wpml_meta_boxes() 
{
	global $post;
	//remove_meta_box('icl_div',$post->posttype,'side');			// Side config
	remove_meta_box('icl_div_config',$post->posttype,'normal');		// Bottom config
}

add_action('admin_head', 'ws_remove_wpml_meta_boxes',99);

////////////////////////////////////////
// Medias 
////////////////////////////////////////

// Remove media columns
// https://developer.wordpress.org/reference/hooks/manage_media_columns/
function ws_media_remove_columns( $columns ) 
{ 
	//unset( $columns['author'] );  // Author
	unset( $columns['comments'] ); 	// Comments
	return $columns; 
} 
add_filter( 'manage_media_columns', 'ws_media_remove_columns' ); 

////////////////////////////////////////
// Comments 
////////////////////////////////////////

// Disable comments
function ws_admin_close_comments( $open, $post_id ) 
{
	if ('post' == get_post($post_id)->post_type) $open = false;
	return $open;
}

add_filter('comments_open', 'ws_admin_close_comments', 10, 2);

////////////////////////////////////////
// Update & Nags & Notifications  
////////////////////////////////////////

//Disable Update WordPress nag 
// add_action('after_setup_theme','ws_remove_core_updates'); 

//Disable Plugin Update Notifications 
// remove_action('load-update-core.php','wp_update_plugins'); 
// add_filter('pre_site_transient_update_plugins','__return_null'); 

//Disable all the Nags & Notifications 
/*
function ws_remove_core_updates()
{ 
	global $wp_version;
	return(object) array('last_checked'=> time(),'version_checked'=> $wp_version,); 
}
*/ 

// add_filter('pre_site_transient_update_core','ws_remove_core_updates'); 
// add_filter('pre_site_transient_update_plugins','ws_remove_core_updates'); 
// add_filter('pre_site_transient_update_themes','ws_remove_core_updates'); 

// Hide WordPress Update Alert 
// http://www.wpoptimus.com/626/7-ways-disable-update-wordpress-notifications/
/*
function ws_hide_nag() 
{ 
	remove_action('admin_notices', 'update_nag', 3); 
}
*/

// add_action('admin_menu', 'ws_hide_nag');