<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://reloadly.com
 * @since             2.0.0
 * @package           Reloadly_widget
 *
 * @wordpress-plugin
 * Plugin Name:       Reloadly Plugin
 * Plugin URI:        https://reloadly.com
 * Description:       Build a perfect experience on your site for airtime, data bundles and digital gift cards purchase with no code involved.
 * Version:           2.0.0
 * Author:            Reloadly
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       reloadly_widget
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Currently plugin version.
 * Start at version 2.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'RELOADLY_WIDGET_VERSION', '2.0.0' );

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-reloadly_widget-activator.php
 */
function activate_reloadly_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-reloadly_widget-activator.php';
    $activator = new Reloadly_widget_Activator();
    $activator->activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-reloadly_widget-deactivator.php
 */
function deactivate_reloadly_widget() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-reloadly_widget-deactivator.php';
    $deactivator = new Reloadly_widget_Deactivator();
    $deactivator->deactivate();
}

register_activation_hook( __FILE__, 'activate_reloadly_widget' );
register_deactivation_hook( __FILE__, 'deactivate_reloadly_widget' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-reloadly_widget.php';


/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_reloadly_widget() {

	$plugin = new Reloadly_widget();
    $plugin->run();

}

run_reloadly_widget();
