<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://github.com/kanafghan
 * @since             1.0.0
 * @package           Simple_User
 *
 * @wordpress-plugin
 * Plugin Name:       Simple User
 * Plugin URI:        https://github.com/kanafghan/wp-simple-user
 * Description:       Create Wordpress users simply by their names.
 * Version:           1.0.0
 * Author:            Ismail Faizi
 * Author URI:        https://github.com/kanafghan
 * License:           MIT
 * License URI:       https://github.com/kanafghan/wp-simple-user/blob/master/LICENSE
 * Text Domain:       simple-user
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'SIMPLE_USER_VERSION', '1.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-simple-user-activator.php
 */
function activate_simple_user() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-user-activator.php';
	Simple_User_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-simple-user-deactivator.php
 */
function deactivate_simple_user() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-simple-user-deactivator.php';
	Simple_User_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_simple_user' );
register_deactivation_hook( __FILE__, 'deactivate_simple_user' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-simple-user.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_simple_user() {

	$plugin = new Simple_User();
	$plugin->run();

}
run_simple_user();
