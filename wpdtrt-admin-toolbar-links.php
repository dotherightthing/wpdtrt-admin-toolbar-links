<?php
/**
 * DTRT Admin Toolbar Links
 *
 * @package     wpdtrt_admin_toolbar_links
 * @author      Dan Smith
 * @copyright   2018 Do The Right Thing
 * @license     GPL-2.0+
 *
 * @wordpress-plugin
 * Plugin Name:  DTRT Admin Toolbar Links
 * Plugin URI:   https://github.com/dotherightthing/wpdtrt-admin-toolbar-links
 * Description:  Add links to the toolbar at the top of WordPress admin screens.
 * Version:      0.1.0
 * Author:       Dan Smith
 * Author URI:   https://profiles.wordpress.org/&#34;dotherightthingnz
 * License:      GPLv2 or later
 * License URI:  http://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain:  wpdtrt-admin-toolbar-links
 * Domain Path:  /languages
 */

/**
 * Constants
 * WordPress makes use of the following constants when determining the path to the content and plugin directories.
 * These should not be used directly by plugins or themes, but are listed here for completeness.
 * WP_CONTENT_DIR  // no trailing slash, full paths only
 * WP_CONTENT_URL  // full url
 * WP_PLUGIN_DIR  // full path, no trailing slash
 * WP_PLUGIN_URL  // full url, no trailing slash
 *
 * WordPress provides several functions for easily determining where a given file or directory lives.
 * Always use these functions in your plugins instead of hard-coding references to the wp-content directory
 * or using the WordPress internal constants.
 * plugins_url()
 * plugin_dir_url()
 * plugin_dir_path()
 * plugin_basename()
 *
 * @see https://codex.wordpress.org/Determining_Plugin_and_Content_Directories#Constants
 * @see https://codex.wordpress.org/Determining_Plugin_and_Content_Directories#Plugins
 */

if ( ! defined( 'WPDTRT_ADMIN_TOOLBAR_LINKS_VERSION' ) ) {
	/**
	 * Plugin version.
	 *
	 * WP provides get_plugin_data(), but it only works within WP Admin,
	 * so we define a constant instead.
	 *
	 * @see $plugin_data = get_plugin_data( __FILE__ ); $plugin_version = $plugin_data['Version'];
	 * @see https://wordpress.stackexchange.com/questions/18268/i-want-to-get-a-plugin-version-number-dynamically
	 */
	define( 'WPDTRT_ADMIN_TOOLBAR_LINKS_VERSION', '0.1.0' );
}

if ( ! defined( 'WPDTRT_ADMIN_TOOLBAR_LINKS_PATH' ) ) {
	/**
	 * Plugin directory filesystem path.
	 *
	 * @param string $file
	 * @return The filesystem directory path (with trailing slash)
	 * @see https://developer.wordpress.org/reference/functions/plugin_dir_path/
	 * @see https://developer.wordpress.org/plugins/the-basics/best-practices/#prefix-everything
	 */
	define( 'WPDTRT_ADMIN_TOOLBAR_LINKS_PATH', plugin_dir_path( __FILE__ ) );
}

if ( ! defined( 'WPDTRT_ADMIN_TOOLBAR_LINKS_URL' ) ) {
	/**
	 * Plugin directory URL path.
	 *
	 * @param string $file
	 * @return The URL (with trailing slash)
	 * @see https://codex.wordpress.org/Function_Reference/plugin_dir_url
	 * @see https://developer.wordpress.org/plugins/the-basics/best-practices/#prefix-everything
	 */
	define( 'WPDTRT_ADMIN_TOOLBAR_LINKS_URL', plugin_dir_url( __FILE__ ) );
}

/**
 * ===== Dependencies =====
 */

/**
 * Determine the correct path to the PSR-4 autoloader.
 *
 * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/issues/51
 */
if ( ! defined( 'WPDTRT_PLUGIN_CHILD' ) ) {
	define( 'WPDTRT_PLUGIN_CHILD', true );
}

/**
 * Determine the correct path to the PSR-4 autoloader.
 *
 * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/issues/104
 * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Options:-Adding-WordPress-plugin-dependencies
 */
if ( defined( 'WPDTRT_ADMIN_TOOLBAR_LINKS_TEST_DEPENDENCY' ) ) {
	$project_root_path = realpath( __DIR__ . '/../../..' ) . '/';
} else {
	$project_root_path = '';
}

require_once $project_root_path . 'vendor/autoload.php';

if ( is_admin() ) {
	// This replaces the TGMPA autoloader
	// @see dotherightthing/generator-wpdtrt-plugin-boilerplate#77
	// @see dotherightthing/wpdtrt-plugin-boilerplate#136.
	require_once $project_root_path . 'vendor/tgmpa/tgm-plugin-activation/class-tgm-plugin-activation.php';
}

// sub classes, not loaded via PSR-4.
// remove the includes you don't need, edit the files you do need.
require_once WPDTRT_ADMIN_TOOLBAR_LINKS_PATH . 'src/class-wpdtrt-admin-toolbar-links-plugin.php';
require_once WPDTRT_ADMIN_TOOLBAR_LINKS_PATH . 'src/class-wpdtrt-admin-toolbar-links-rewrite.php';
require_once WPDTRT_ADMIN_TOOLBAR_LINKS_PATH . 'src/class-wpdtrt-admin-toolbar-links-shortcode.php';
require_once WPDTRT_ADMIN_TOOLBAR_LINKS_PATH . 'src/class-wpdtrt-admin-toolbar-links-taxonomy.php';
require_once WPDTRT_ADMIN_TOOLBAR_LINKS_PATH . 'src/class-wpdtrt-admin-toolbar-links-widget.php';

// log & trace helpers.
global $debug;
$debug = new DoTheRightThing\WPDebug\Debug();

/**
 * ===== WordPress Integration =====
 *
 * Comment out the actions you don't need.
 *
 * Notes:
 *  Default priority is 10. A higher priority runs later.
 *  register_activation_hook() is run before any of the provided hooks
 *
 * @see https://developer.wordpress.org/plugins/hooks/actions/#priority
 * @see https://codex.wordpress.org/Function_Reference/register_activation_hook.
 */
register_activation_hook( dirname( __FILE__ ), 'wpdtrt_admin_toolbar_links_activate' );

add_action( 'init', 'wpdtrt_admin_toolbar_links_plugin_init', 0 );
add_action( 'init', 'wpdtrt_admin_toolbar_links_shortcode_init', 100 );
add_action( 'init', 'wpdtrt_admin_toolbar_links_taxonomy_init', 100 );
add_action( 'widgets_init', 'wpdtrt_admin_toolbar_links_widget_init', 10 );

register_deactivation_hook( dirname( __FILE__ ), 'wpdtrt_admin_toolbar_links_deactivate' );

/**
 * ===== Plugin config =====
 */

/**
 * Register functions to be run when the plugin is activated.
 *
 * @see https://codex.wordpress.org/Function_Reference/register_activation_hook
 * @todo https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/issues/128
 * @see See also Plugin::helper_flush_rewrite_rules()
 */
function wpdtrt_admin_toolbar_links_activate() {
	flush_rewrite_rules();
}

/**
 * Register functions to be run when the plugin is deactivated.
 * (WordPress 2.0+)
 *
 * @see https://codex.wordpress.org/Function_Reference/register_deactivation_hook
 * @todo https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/issues/128
 * @see See also Plugin::helper_flush_rewrite_rules()
 */
function wpdtrt_admin_toolbar_links_deactivate() {
	flush_rewrite_rules();
}

/**
 * Plugin initialisaton
 *
 * We call init before widget_init so that the plugin object properties are available to it.
 * If widget_init is not working when called via init with priority 1, try changing the priority of init to 0.
 * init: Typically used by plugins to initialize. The current user is already authenticated by this time.
 * widgets_init: Used to register sidebars. Fired at 'init' priority 1 (and so before 'init' actions with priority ≥ 1!)
 *
 * @see https://wp-mix.com/wordpress-widget_init-not-working/
 * @see https://codex.wordpress.org/Plugin_API/Action_Reference
 * @todo Add a constructor function to WPDTRT_Blocks_Plugin, to explain the options array
 */
function wpdtrt_admin_toolbar_links_plugin_init() {
	// pass object reference between classes via global
	// because the object does not exist until the WordPress init action has fired.
	global $wpdtrt_admin_toolbar_links_plugin;

	/**
	 * Global options
	 *
	 * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Options:-Adding-global-options Options: Adding global options
	 */
	$plugin_options = array(
		'pluginoption1' => array(
			'type'  => 'text',
			'label' => __( 'Field label', 'wpdtrt-admin-toolbar-links' ),
			'size'  => 10,
			'tip'   => __( 'Helper text', 'wpdtrt-admin-toolbar-links' ),
		),
	);

	/**
	 * Shortcode or Widget options
	 *
	 * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Options:-Adding-shortcode-or-widget-options Options: Adding shortcode or widget options
	 */
	$instance_options = array(
		'instanceoption1' => array(
			'type'  => 'text',
			'label' => __( 'Field label', 'wpdtrt-admin-toolbar-links' ),
			'size'  => 10,
			'tip'   => __( 'Helper text', 'wpdtrt-admin-toolbar-links' ),
		),
	);

	/**
	 * UI Messages
	 */
	$ui_messages = array(
		'demo_data_description'       => __( 'This demo was generated from the following data', 'wpdtrt-admin-toolbar-links' ),
		'demo_data_displayed_length'  => __( 'results displayed', 'wpdtrt-admin-toolbar-links' ),
		'demo_data_length'            => __( 'results', 'wpdtrt-admin-toolbar-links' ),
		'demo_data_title'             => __( 'Demo data', 'wpdtrt-admin-toolbar-links' ),
		'demo_date_last_updated'      => __( 'Data last updated', 'wpdtrt-admin-toolbar-links' ),
		'demo_sample_title'           => __( 'Demo sample', 'wpdtrt-admin-toolbar-links' ),
		'demo_shortcode_title'        => __( 'Demo shortcode', 'wpdtrt-admin-toolbar-links' ),
		'insufficient_permissions'    => __( 'Sorry, you do not have sufficient permissions to access this page.', 'wpdtrt-admin-toolbar-links' ),
		'no_options_form_description' => __( 'There aren\'t currently any options.', 'wpdtrt-admin-toolbar-links' ),
		'noscript_warning'            => __( 'Please enable JavaScript', 'wpdtrt-admin-toolbar-links' ),
		'options_form_description'    => __( 'Please enter your preferences.', 'wpdtrt-admin-toolbar-links' ),
		'options_form_submit'         => __( 'Save Changes', 'wpdtrt-admin-toolbar-links' ),
		'options_form_title'          => __( 'General Settings', 'wpdtrt-admin-toolbar-links' ),
		'loading'                     => __( 'Loading latest data...', 'wpdtrt-admin-toolbar-links' ),
		'success'                     => __( 'settings successfully updated', 'wpdtrt-admin-toolbar-links' ),
	);

	/**
	 * Demo shortcode
	 *
	 * @see https://github.com/dotherightthing/wpdtrt-plugin-boilerplate/wiki/Settings-page:-Adding-a-demo-shortcode Settings page: Adding a demo shortcode
	 */
	$demo_shortcode_params = array();

	/**
	 * Plugin configuration
	 */
	$wpdtrt_admin_toolbar_links_plugin = new WPDTRT_Admin_Toolbar_Links_Plugin(
		array(
			'path'                  => WPDTRT_ADMIN_TOOLBAR_LINKS_PATH,
			'url'                   => WPDTRT_ADMIN_TOOLBAR_LINKS_URL,
			'version'               => WPDTRT_ADMIN_TOOLBAR_LINKS_VERSION,
			'prefix'                => 'wpdtrt_admin_toolbar_links',
			'slug'                  => 'wpdtrt-admin-toolbar-links',
			'menu_title'            => __( 'Admin Toolbar Links', 'wpdtrt-admin-toolbar-links' ),
			'settings_title'        => __( 'Settings', 'wpdtrt-admin-toolbar-links' ),
			'developer_prefix'      => 'DTRT',
			'messages'              => $ui_messages,
			'plugin_options'        => $plugin_options,
			'instance_options'      => $instance_options,
			'demo_shortcode_params' => $demo_shortcode_params,
		)
	);
}

/**
 * ===== Rewrite config =====
 */

/**
 * Register Rewrite
 */
function wpdtrt_admin_toolbar_links_rewrite_init() {

	global $wpdtrt_admin_toolbar_links_plugin;

	$wpdtrt_admin_toolbar_links_rewrite = new WPDTRT_Admin_Toolbar_Links_Rewrite(
		array()
	);
}

/**
 * ===== Shortcode config =====
 */

/**
 * Register Shortcode
 */
function wpdtrt_admin_toolbar_links_shortcode_init() {

	global $wpdtrt_admin_toolbar_links_plugin;

	$wpdtrt_admin_toolbar_links_shortcode = new WPDTRT_Admin_Toolbar_Links_Shortcode(
		array(
			'name'                      => 'wpdtrt_admin_toolbar_links_shortcode',
			'plugin'                    => $wpdtrt_admin_toolbar_links_plugin,
			'template'                  => 'admin-toolbar-links',
			'selected_instance_options' => array(
				'instanceoption1',
			),
		)
	);
}

/**
 * ===== Taxonomy config =====
 */

/**
 * Register Taxonomy
 *
 * @return object Taxonomy/
 */
function wpdtrt_admin_toolbar_links_taxonomy_init() {

	global $wpdtrt_admin_toolbar_links_plugin;

	$wpdtrt_admin_toolbar_links_taxonomy = new WPDTRT_Admin_Toolbar_Links_Taxonomy(
		array(
			'name'                      => 'wpdtrt_admin_toolbar_links_things',
			'plugin'                    => $wpdtrt_admin_toolbar_links_plugin,
			'selected_instance_options' => array(
				'instanceoption1',
			),
			'taxonomy_options'          => array(
				'option1' => array(
					'type'              => 'text',
					'label'             => esc_html__( 'Option 1', 'wpdtrt-admin-toolbar-links' ),
					'admin_table'       => true,
					'admin_table_label' => esc_html__( '1', 'wpdtrt-admin-toolbar-links ' ),
					'admin_table_sort'  => true,
					'tip'               => 'Enter something',
					'todo_condition'    => 'foo !== "bar"',
				),
			),
			'labels'                    => array(
				'slug'                       => 'wpdtrt_admin_toolbar_links_thing',
				'description'                => __( 'Things', 'wpdtrt-admin-toolbar-links' ),
				'posttype'                   => 'post',
				'name'                       => __( 'Things', 'taxonomy general name' ),
				'singular_name'              => _x( 'Thing', 'taxonomy singular name' ),
				'menu_name'                  => __( 'Things', 'wpdtrt-admin-toolbar-links' ),
				'all_items'                  => __( 'All Things', 'wpdtrt-admin-toolbar-links' ),
				'add_new_item'               => __( 'Add New Thing', 'wpdtrt-admin-toolbar-links' ),
				'edit_item'                  => __( 'Edit Thing', 'wpdtrt-admin-toolbar-links' ),
				'view_item'                  => __( 'View Thing', 'wpdtrt-admin-toolbar-links' ),
				'update_item'                => __( 'Update Thing', 'wpdtrt-admin-toolbar-links' ),
				'new_item_name'              => __( 'New Thing Name', 'wpdtrt-admin-toolbar-links' ),
				'parent_item'                => __( 'Parent Thing', 'wpdtrt-admin-toolbar-links' ),
				'parent_item_colon'          => __( 'Parent Thing:', 'wpdtrt-admin-toolbar-links' ),
				'search_items'               => __( 'Search Things', 'wpdtrt-admin-toolbar-links' ),
				'popular_items'              => __( 'Popular Things', 'wpdtrt-admin-toolbar-links' ),
				'separate_items_with_commas' => __( 'Separate Things with commas', 'wpdtrt-admin-toolbar-links' ),
				'add_or_remove_items'        => __( 'Add or remove Things', 'wpdtrt-admin-toolbar-links' ),
				'choose_from_most_used'      => __( 'Choose from most used Things', 'wpdtrt-admin-toolbar-links' ),
				'not_found'                  => __( 'No Things found', 'wpdtrt-admin-toolbar-links' ),
			),
		)
	);

	// return a reference for unit testing.
	return $wpdtrt_admin_toolbar_links_taxonomy;
}

/**
 * ===== Widget config =====
 */

/**
 * Register a WordPress widget, passing in an instance of our custom widget class
 * The plugin does not require registration, but widgets and shortcodes do.
 * Note: widget_init fires before init, unless init has a priority of 0
 *
 * @uses        ../../../../wp-includes/widgets.php
 * @see         https://codex.wordpress.org/Function_Reference/register_widget#Example
 * @see         https://wp-mix.com/wordpress-widget_init-not-working/
 * @see         https://codex.wordpress.org/Plugin_API/Action_Reference
 * @uses        https://github.com/dotherightthing/wpdtrt/tree/master/library/sidebars.php
 * @todo        Add form field parameters to the options array
 * @todo        Investigate the 'classname' option
 */
function wpdtrt_admin_toolbar_links_widget_init() {

	global $wpdtrt_admin_toolbar_links_plugin;

	$wpdtrt_admin_toolbar_links_widget = new WPDTRT_Admin_Toolbar_Links_Widget(
		array(
			'name'                      => 'wpdtrt_admin_toolbar_links_widget',
			'title'                     => __( 'DTRT Admin Toolbar Links Widget', 'wpdtrt-admin-toolbar-links' ),
			'description'               => __( 'Add links to the toolbar at the top of WordPress admin screens.', 'wpdtrt-admin-toolbar-links' ),
			'plugin'                    => $wpdtrt_admin_toolbar_links_plugin,
			'template'                  => 'admin-toolbar-links',
			'selected_instance_options' => array(
				'instanceoption1',
			),
		)
	);

	register_widget( $wpdtrt_admin_toolbar_links_widget );
}
