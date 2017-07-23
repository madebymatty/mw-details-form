<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://www.madebymatty.com
 * @since             1.0.0
 * @package           Mw_Details_Form
 *
 * @wordpress-plugin
 * Plugin Name:       MW Details Form
 * Plugin URI:        https://github.com/madebymatty/mw-details-form
 * Description:       This is Wordpress plugin by Matt Woods, to allow the user to update details and some optional fields
 * Version:           1.0.0
 * Author:            Matt Woods
 * Author URI:        http://www.madebymatty.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       mw-details-form
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-mw-test-plugin-activator.php
 */
function activate_mw_details_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mw-details-form-activator.php';
	Mw_Details_Form_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-mw-test-plugin-deactivator.php
 */
function deactivate_mw_details_form() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-mw-details-form-deactivator.php';
	Mw_Details_Form_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_mw_details_form' );
register_deactivation_hook( __FILE__, 'deactivate_mw_details_form' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-mw-details-form.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_mw_details_form() {

	$plugin = new Mw_Details_Form();
	$plugin->run();

}
run_mw_details_form();
