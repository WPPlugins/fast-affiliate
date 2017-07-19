<?php
/**
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              http://fast-affiliate.trencube.com
 * @since             1.0.0
 * @package           fast_affiliate
 *
 * @wordpress-plugin
 * Plugin Name:       Fast Affiliate
 * Plugin URI:        http://fast-affiliate.trencube.com
 * Description:       Choose and place your affiliate links FAST !
 * Version:           1.3
 * Author:            J. De La O & G. Lebret
 * Author URI:        http://fast-affiliate.trencube.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       fast-affiliate
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-plugin-name-activator.php
 */
function activate_fast_affiliate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fast-affiliate-activator.php';
	fast_affiliate_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-plugin-name-deactivator.php
 */
function deactivate_fast_affiliate() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-fast-affiliate-deactivator.php';
	fast_affiliate_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_fast_affiliate' );
register_deactivation_hook( __FILE__, 'deactivate_fast_affiliate' );


/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-fast-affiliate.php';

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_fast_affiliate() {

	$plugin = new fast_affiliate();
	$plugin->run();

}
run_fast_affiliate();
?>