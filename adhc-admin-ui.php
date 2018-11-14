<?php
/*
  Plugin Name:  ADHC Admin UI
  Plugin URI:   http://adhc.lib.ua.edu
  Description:  UA Themed Admin interface. Includes ADHC How to documentions page and ADHC plugins repo.
  Version:      1.7.3
  Author:       Tyler Grace
  Author URI:   http://adhc.lib.ua.edu
  */

define('WP_SCSS_ALWAYS_RECOMPILE', true);

include_once('inc/fau_settings.php');


/* enqueue login pages styles */
function adhc_login_theme_style() {
  wp_enqueue_style('adhc-login-style', plugin_dir_url( __FILE__ ) . '/css/login-alt.css' );
  $login_css = "";
  //wp_add_inline_style( 'adhc-login-style', $login_css );
}
add_action( 'login_enqueue_scripts', 'adhc_login_theme_style' );


/* enqueue adminbar styles */
function adhc_admin_theme_styles() {
	wp_enqueue_style('adhc-admin-font-style', plugin_dir_url( __FILE__ ) . '/css/fonts.css');
	wp_enqueue_style('adhc-admin-style',plugin_dir_url( __FILE__ ) . '/css/admin.css');
	wp_enqueue_style('adhc-admin-bar-style', plugin_dir_url( __FILE__ ) . '/css/adminbar.css' );
	//$admin_bar_css = ""; wp_add_inline_style( 'adhc-admin-bar-style', $admin_bar_css );
	//$admin_css = ""; wp_add_inline_style( 'adhc-admin-style', $admin_css );
}
add_action( 'admin_enqueue_scripts', 'adhc_admin_theme_styles' );


/* enqueue adminbar styles to front also for frontend admin bar */
function adhc_admin_theme_front_styles() {
    wp_enqueue_style( 'admin-bar-front', plugin_dir_url( __FILE__ ) . '/css/adminbar.css' );
}
add_action( 'wp_enqueue_scripts', 'adhc_admin_theme_front_styles' );


/* change admin footer */
function adhc_swap_footer_admin() {
	echo '<i class="ua-icon-denny-chimes"></i><img id="admin-ua-logo" src="https://alabama.box.com/shared/static/rrz800hrp7h5crt74rorawa8ihagu8eb.png" width="15%"><img id="admin-ua-lib-logo" style="" src="https://www.lib.ua.edu/wp-content/themes/roots-ualib/assets/img/new-ualib-logo.png" width="25%">';
}
add_filter( 'admin_footer_text', 'adhc_swap_footer_admin' );


/* Remove default HTML height on the admin bar callback */
function adhc_admin_bar_style() {
	if ( is_admin_bar_showing() ) {
		?>
  		<style type="text/css" media="screen">
    	html { margin-top: 46px !important; }
    	* html body { margin-top: 46px !important; }
  		</style>
	<?php }
}
add_theme_support( 'admin-bar', array( 'callback' => 'adhc_admin_bar_style' ) );


function createMenu() {
    add_menu_page('Page Title', '<div style="background-color: #990000; padding-top: 15px; padding-bottom: 15px;"><img id="admin-ua-logo" src="https://alabama.box.com/shared/static/rrz800hrp7h5crt74rorawa8ihagu8eb.png" width="15%"><img id="admin-ua-lib-logo" style="" src="https://www.lib.ua.edu/wp-content/themes/roots-ualib/assets/img/new-ualib-logo.png" width="25%"></div>', 'administrator', 'click-action', 'your_new_menu', 'none', null );
}
function createMenu2() {
    add_menu_page('Page Title', '<i class="ua-icon-denny-chimes"></i>', 'administrator', 'click-action', 'your_new_menu', 'none', null );
}
//add_action('admin_menu', 'createMenu2');


/* add ua logo to admin bar */
function ua_logo_adminbar( $wp_admin_bar ) {
	$args = array(
		'id'    => 'my_page',
		'title' => '<img id="admin-ua-logo" src="' . plugin_dir_url( __FILE__ ) . '/img/ua-logo.jpg' . '" style="width: 40px; margin-top: -4px;">',
		'href'  => get_site_url() . '/wp-admin',
		'meta'  => array( 'class' => 'my-toolbar-page' )
	);
	$wp_admin_bar->add_node( $args );
}
add_action( 'admin_bar_menu', 'ua_logo_adminbar', 0 );


function my_admin_scripts() {
    wp_enqueue_script( 'adhc-admin-js', plugin_dir_url( __FILE__ ) . '/js/adhc_admin.js', array( 'jquery' ), '1.0.0', true );
}
add_action( 'admin_enqueue_scripts', 'my_admin_scripts' );


function remove_howdy( $wp_admin_bar ) {
	$my_account=$wp_admin_bar->get_node('my-account');
	$newtitle = str_replace( 'Howdy,', '', $my_account->title );
	$wp_admin_bar->add_node( array(
		'id' => 'my-account',
		'title' => $newtitle,
	) );
}
add_filter( 'admin_bar_menu', 'remove_howdy',25 );


/* enqueue adminbar styles */
function adhc_admin_theme_propeller_accordion_styles() {
	wp_enqueue_style('adhc-admin-propeller-accordion-style', plugin_dir_url( __FILE__ ) . '/inc/propeller-accordion/css/accordion.css');
	wp_enqueue_style('adhc-admin-propeller-button-style', plugin_dir_url( __FILE__ ) . '/inc/propeller-accordion/css/button.css');
	wp_enqueue_style('adhc-admin-propeller-google-icons-style', plugin_dir_url( __FILE__ ) . '/inc/propeller-accordion/css/google-icons.css');
	wp_enqueue_style('adhc-admin-propeller-typography-style', plugin_dir_url( __FILE__ ) . '/inc/propeller-accordion/css/typography.css');
	//$admin_bar_css = ""; wp_add_inline_style( 'adhc-admin-bar-style', $admin_bar_css );
	//$admin_css = ""; wp_add_inline_style( 'adhc-admin-style', $admin_css );
}
//add_action( 'admin_enqueue_scripts', 'adhc_admin_theme_propeller_accordion_styles' );


function adhc_admin_theme_propeller_accordion_scripts() {
    wp_enqueue_script( 'adhc-admin-propeller-accordion-js', plugin_dir_url( __FILE__ ) . '/inc/propeller-accordion/js/accordion.js', array( 'jquery' ), '1.0.0', true );
}
//add_action( 'admin_enqueue_scripts', 'adhc_admin_theme_propeller_accordion_scripts' );


//ACF options page
function my_acf_init() {
	if( function_exists('acf_add_options_page') ) {
		$option_page = acf_add_options_page(array(
			'page_title' 	=> 'ADHC Page',
			'menu_title' 	=> 'ADHC Page',
			'menu_slug' 	=> 'adhc-page',
			'capability' 	=> 'edit_posts',
			'redirect' 	=> false
		));

		acf_add_options_sub_page(array(
			'page_title' 	=> 'Theme Header Settings',
			'menu_title'	=> 'Header',
			'parent_slug'	=> 'theme-general-settings',
		));

		if( function_exists('acf_add_local_field_group') ) {
			acf_add_local_field_group(array (
				'key' => 'group_5910c1e0030ff',
				'title' => 'ADHC Page',
				'fields' => array (
					array (
						'key' => 'field_5910c1f35e4ab',
						'label' => 'class roster',
						'name' => 'class_roster',
						'type' => 'file',
						'instructions' => '',
						'required' => 0,
						'conditional_logic' => 0,
						'wrapper' => array (
							'width' => '',
							'class' => '',
							'id' => '',
						),
						'return_format' => 'url',
						'library' => 'uploadedTo',
						'min_size' => '',
						'max_size' => '',
						'mime_types' => '',
					),
				),
				'location' => array (
					array (
						array (
							'param' => 'options_page',
							'operator' => '==',
							'value' => 'adhc-page',
						),
					),
				),
				'menu_order' => 0,
				'position' => 'normal',
				'style' => 'default',
				'label_placement' => 'top',
				'instruction_placement' => 'label',
				'hide_on_screen' => '',
				'active' => 1,
				'description' => '',
			));
		}
	}
}
//add_action('acf/init', 'my_acf_init');


function debug_to_console( $data ) {
    $output = $data;
    if ( is_array( $output ) )
        $output = implode( ',', $output);

    echo("<script>console.log('PHP: ".$data."');</script>");
}


function clear_advert_main_transient() {
	$screen = get_current_screen();
	if (strpos($screen->id, "adhc-page") == true) {
		$to = 'thgrace@ua.edu';
		$subject = 'The subject';
		$body = 'The email body content';
		$headers = array('Content-Type: text/html; charset=UTF-8');

		wp_mail( $to, $subject, $body, $headers );

		debug_to_console( "Test" );
	}
}
add_action('acf/save_post', 'clear_advert_main_transient', 20);


function my_acf_update_value( $value, $post_id, $fields  ){
    $to = 'DropTes.89qpbv2tay7mmc4y@u.box.com';
	$subject = 'The subject';
	$body = 'The email body content: ' . $value;
	$headers = array('Content-Type: text/html; charset=UTF-8');
	$attachments = array( WP_CONTENT_DIR . '/uploads/pic7-280x466.jpg' );

	wp_mail( $to, $subject, $body, $headers, $attachments );

    return $value. " Success";
}
//add_filter('acf/update_value/name=couse_designation', 'my_acf_update_value', 10, 3);



/* -- HOW TO SECTION -- */
function adhc_setup_add_admin_menu(  ) {
	add_options_page( 'ADHC Setup', 'ADHC Setup', 'manage_options', 'adhc_setup_plugin', 'adhc_how_to_options_page' );
	add_menu_page( 'How To', 'How To', 'edit_posts', 'adhc/adhc-how-to-admin-page.php', 'adhc_how_to_admin_display_page', 'dashicons-info', 99 );
}
add_action( 'admin_menu', 'adhc_setup_add_admin_menu' );


function adhc_how_to_admin_display_page(){
	?>
	<style>.howto-section { margin-top: 5em; } </style>
	<div class="wrap">
		<h2>How To Materials</h2>
		<?php //var_dump(get_option( 'adhc_how_to_settings' )); ?>
		<?php
			$wordpress_basics_doc = get_option( 'adhc_how_to_settings' )['adhc_how_to_checkbox_field_wordpress_basics_doc'];
			$create_post_video = get_option( 'adhc_how_to_settings' )['adhc_how_to_checkbox_field_create_post_video'];
            $timeline_entry_doc = get_option( 'adhc_how_to_settings' )['adhc_how_to_checkbox_field_timeline_entry_doc'];

			if($wordpress_basics_doc == 1){ ?>
				<div class="howto-section">
		    		<h3>Wordpress Basics</h3>
		    		<iframe src="https://docs.google.com/viewer?url=https://alabama.box.com/shared/static/q2jl4u2tcxmw8dj09enbbcu6188ozmfi.pdf&embedded=true" style="position: initial; width:80%; height: 640px; border: none;"></iframe>
				</div>
			<?php }

			if($create_post_video == 1){ ?>
				<div class="howto-section">
		    		<h3>How to create a post video</h3>
		    		<video src="https://alabama.box.com/shared/static/a4c8ax0v1i8bte7hpzbs6v1m8v2gyoio.mp4" width="80%" controls>Sorry, your browser doesn't support embedded videos, download it <a href="https://alabama.box.com/shared/static/a4c8ax0v1i8bte7hpzbs6v1m8v2gyoio.mp4&embedded=true">here</a> and watch it offline.
		    		</video>
				</div>
			<?php }

            if($timeline_entry_doc == 1){ ?>
				<div class="howto-section">
		    		<h3>Timeline Entries in Wordpress</h3>
		    		<iframe src="https://docs.google.com/viewer?url=https://alabama.box.com/shared/static/q2jl4u2tcxmw8dj09enbbcu6188ozmfi.pdf&embedded=true" style="position: initial; width:80%; height: 640px; border: none;"></iframe>
				</div>
			<?php }

	echo '</div>';
}


function adhc_how_to_settings_init(  ) {
	register_setting( 'pluginPage', 'adhc_how_to_settings' );
	add_settings_section(
		'adhc_how_to_pluginPage_section',
		__( '', 'adhc_how_to' ),
		'adhc_how_to_settings_section_callback',
		'pluginPage'
	);
	add_settings_field(
		'adhc_how_to_checkbox_field_wordpress_basics_doc',
		__( 'Wordpress Basics Document', 'adhc_how_to' ),
		'adhc_how_to_checkbox_field_wordpress_basics_doc_render',
		'pluginPage',
		'adhc_how_to_pluginPage_section'
	);
	add_settings_field(
		'adhc_how_to_checkbox_field_create_post_video',
		__( 'How to Create a Post video', 'adhc_how_to' ),
		'adhc_how_to_checkbox_field_create_post_video_render',
		'pluginPage',
		'adhc_how_to_pluginPage_section'
	);
    add_settings_field(
		'adhc_how_to_checkbox_field_timeline_entry_doc',
		__( 'Timeline Entries in Wordpress', 'adhc_how_to' ),
		'adhc_how_to_checkbox_field_timeline_entry_doc_render',
		'pluginPage',
		'adhc_how_to_pluginPage_section'
	);
}
add_action( 'admin_init', 'adhc_how_to_settings_init' );


function adhc_how_to_checkbox_field_wordpress_basics_doc_render(  ) {
	$options = get_option( 'adhc_how_to_settings' );
	?>
	<input type='checkbox' name='adhc_how_to_settings[adhc_how_to_checkbox_field_wordpress_basics_doc]' <?php checked( $options['adhc_how_to_checkbox_field_wordpress_basics_doc'], 1 ); ?> value='1'>
	<?php
}


function adhc_how_to_checkbox_field_create_post_video_render(  ) {
	$options = get_option( 'adhc_how_to_settings' );
	?>
	<input type='checkbox' name='adhc_how_to_settings[adhc_how_to_checkbox_field_create_post_video]' <?php checked( $options['adhc_how_to_checkbox_field_create_post_video'], 1 ); ?> value='1'>
	<?php
}


function adhc_how_to_checkbox_field_timeline_entry_doc_render(  ) {
	$options = get_option( 'adhc_how_to_settings' );
	?>
	<input type='checkbox' name='adhc_how_to_settings[adhc_how_to_checkbox_field_timeline_entry_doc]' <?php checked( $options['adhc_how_to_checkbox_field_timeline_entry_doc'], 1 ); ?> value='1'>
	<?php
}


function adhc_how_to_settings_section_callback(  ) {
	//echo __( 'This section description', 'adhc_how_to' );
}


function adhc_how_to_options_page(  ) {
	?>
	<form action='options.php' method='post'>
		<h2>ADHC How To Plugin</h2>
		<?php
		settings_fields( 'pluginPage' );
		do_settings_sections( 'pluginPage' );
		submit_button();
		?>
	</form>
	<?php
}





/**
 * Include the TGM_Plugin_Activation class.
 *
 * Depending on your implementation, you may want to change the include call:
 *
 * Parent Theme:
 * require_once get_template_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Child Theme:
 * require_once get_stylesheet_directory() . '/path/to/class-tgm-plugin-activation.php';
 *
 * Plugin:
 * require_once dirname( __FILE__ ) . '/path/to/class-tgm-plugin-activation.php';
 */
require_once dirname( __FILE__ ) . '/inc/class-tgm-plugin-activation.php';

add_action( 'tgmpa_register', 'adhc_how_to_register_required_plugins' );

/**
 * Register the required plugins for this theme.
 *
 * In this example, we register five plugins:
 * - one included with the TGMPA library
 * - two from an external source, one from an arbitrary source, one from a GitHub repository
 * - two from the .org repo, where one demonstrates the use of the `is_callable` argument
 *
 * The variables passed to the `tgmpa()` function should be:
 * - an array of plugin arrays;
 * - optionally a configuration array.
 * If you are not changing anything in the configuration array, you can remove the array and remove the
 * variable from the function call: `tgmpa( $plugins );`.
 * In that case, the TGMPA default settings will be used.
 *
 * This function is hooked into `tgmpa_register`, which is fired on the WP `init` action on priority 10.
 */
function adhc_how_to_register_required_plugins() {
	/*
	 * Array of plugin arrays. Required keys are name and slug.
	 * If the source is NOT from the .org repo, then source is also required.
	 */
	$plugins = array(
		// This is an example of how to include a plugin from a GitHub repository in your theme.
		// This presumes that the plugin code is based in the root of the GitHub repository
		// and not in a subdirectory ('/src') of the repository.
		array(
			'name'      => 'Advanced Custom Fields Pro',
			'slug'      => 'advanced-custom-fields-pro',
			'source'    => 'https://alabama.box.com/v/advanced-custom-fields-pro',
		),
		array(
			'name'      => 'ADHC Mybama Login',
			'slug'      => 'adhc-mybama-login',
			'source'    => 'https://alabama.box.com/v/adhc-mybama-login',
		),
        array(
			'name'      => 'ADHC TimelineJS Plugin',
			'slug'      => 'adhc-timeline-js',
            'required'  => false,
			'source'    => 'https://github.com/ADHC/adhc-timeline-js/archive/master.zip',
		),
		array(
			'name'        => 'Custom Post Type UI',
			'slug'        => 'custom-post-type-ui',
			'is_callable' => 'cptui_init',
			'version'     => '1.5.3',
		),
        array(
			'name'        => 'ACF Columns',
			'slug'        => 'acf-columns',
			'is_callable' => 'cptui_init',
			'version'     => '1.1.0',
		),
        array(
			'name'        => 'ManageWP Worker',
			'slug'        => 'worker',
			'is_callable' => 'cptui_init',
			'version'     => '4.3.3',
		),
        array(
			'name'        => 'Adminimize',
			'slug'        => 'adminimize',
			'version'     => '1.11.4',
		),
        array(
			'name'        => 'Disable Comments',
			'slug'        => 'disable-comments',
			'version'     => '1.7.1',
		),
        array(
			'name'        => 'View Own Posts Media Only',
			'slug'        => 'view-own-posts-media-only',
			'version'     => '1.3',
		),
        array(
			'name'        => 'Duplicate Post',
			'slug'        => 'duplicate-post',
			'version'     => '3.2.1',
		),
        array(
			'name'        => 'Timber Library',
			'slug'        => 'timber-library',
			'version'     => '1.6',
		),
        array(
			'name'        => 'WPFront User Role Editor',
			'slug'        => 'wpfront-user-role-editor',
			'version'     => '2.14.1',
		),
        array(
			'name'        => 'User Switching',
			'slug'        => 'user-switching',
			'version'     => '1.3.0',
		),

        array(
			'name'        => 'Display Posts Shortcode',
			'slug'        => 'display-posts-shortcode',
			'version'     => '2.9.0',
		),

        array(
			'name'        => 'Redirection',
			'slug'        => 'redirection',
			'version'     => '3.2.0',
		),

        array(
			'name'        => 'Simple Custom CSS and JS',
			'slug'        => 'custom-css-js',
			'version'     => '3.14.0',
		),
	);

	/*
	 * Array of configuration settings. Amend each line as needed.
	 *
	 * TGMPA will start providing localized text strings soon. If you already have translations of our standard
	 * strings available, please help us make TGMPA even better by giving us access to these translations or by
	 * sending in a pull-request with .po file(s) with the translations.
	 *
	 * Only uncomment the strings in the config array if you want to customize the strings.
	 */
	$config = array(
		'id'           => 'adhc-how-to',                 // Unique ID for hashing notices for multiple instances of TGMPA.
		'default_path' => '',                      // Default absolute path to bundled plugins.
		'menu'         => 'tgmpa-install-plugins', // Menu slug.
		'parent_slug'  => 'plugins.php',            // Parent menu slug.
		'capability'   => 'manage_options',    // Capability needed to view plugin install page, should be a capability associated with the parent menu used.
		'has_notices'  => true,                    // Show admin notices or not.
		'dismissable'  => true,                    // If false, a user cannot dismiss the nag message.
		'dismiss_msg'  => '',                      // If 'dismissable' is false, this message will be output at top of nag.
		'is_automatic' => false,                   // Automatically activate plugins after installation or not.
		'message'      => '',                      // Message to output right before the plugins table.
		'strings'      => array(
			'page_title'                      => __( 'Install ADHC Plugins', 'adhc-setup-plugins' ),
			'menu_title'                      => __( 'ADHC Plugins', 'adhc-setup-plugins' ),
		),
	);

	tgmpa( $plugins, $config );
}


function my_acf_json_load_point( $paths ) {
	if( function_exists('acf_add_options_page') ) {
	    $option_page = acf_add_options_page(array(
			'page_title' 	=> 'ADHC Setup Plugin',
			'menu_title' 	=> 'ADHC Setup',
			'menu_slug' 	=> 'adhc-setup-settings',
			'capability' 	=> 'manage_options',
			'redirect' 	=> false
		));
	}
    unset($paths[0]); // remove original path (optional)
    $paths[] = dirname( __FILE__ ) . '/acf'; // append path
    return $paths;
}
//add_filter('acf/settings/load_json', 'my_acf_json_load_point');
