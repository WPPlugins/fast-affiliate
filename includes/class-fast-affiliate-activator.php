<?php
require_once plugin_dir_path( __FILE__ ).('../admin/fast-affiliate-api.php');
/**
 * Fired during plugin activation
 *
 * @link       https://affiliate.trencube.com
 * @since      1.0.0
 *
 * @package    fast_affiliate
 * @subpackage fast_affiliate/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    fast_affiliate
 * @subpackage fast_affiliate/includes
 * @author     g.lebret <email@example.com>
 */
class fast_affiliate_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {

		// Creating the token
		fast_affiliate_get_token($_SERVER['SERVER_NAME']);
		//
		// Frequency of the hook
		if (! wp_next_scheduled('fast_affiliate_daily_hook')){
			wp_schedule_event(time(), 'daily', 'fast_affiliate_daily_hook');
		}
		// Creating the database
	

		global $wpdb;
		$charset_collate = $wpdb->get_charset_collate();
		$table_name = $wpdb->prefix . 'f_a_link_performance';


		$sql = "CREATE TABLE $table_name (
			id mediumint(9) NOT NULL AUTO_INCREMENT,
			time datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
			linkid varchar(100) DEFAULT '' NOT NULL,
			source varchar(100) DEFAULT '' NOT NULL,
			clicks int(12),
			PRIMARY KEY  (id)
		) $charset_collate;";

		require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
		dbDelta( $sql );
	}


}