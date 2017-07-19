<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    fast_affiliate
 * @subpackage fast_affiliate/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    fast_affiliate
 * @subpackage fast_affiliate/includes
 * @author     G. Lebret <email@example.com>
 */
class fast_affiliate_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		wp_clear_scheduled_hook('fast_affiliate_daily_hook');

	}
}