<?php

require_once('fast-affiliate-update-clicks.php');
require_once('fast-affiliate-update-post-views.php');

/**
 * The public-facing functionality of the plugin.
 *
 * @link       https://affiliate.trencube.com
 * @since      1.0.0
 *
 * @package    fast_affiliate
 * @subpackage fast_affiliate/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    fast_affiliate
 * @subpackage fast_affiliate/public
 * @author     G. Lebret <email@example.com>
 */
class fast_affiliate_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $plugin_name    The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $plugin_name       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;

		add_action( 'wp_ajax_fast_affiliate_update_clicks', 'fast_affiliate_update_clicks' );
		add_action( 'wp_ajax_nopriv_fast_affiliate_update_clicks', 'fast_affiliate_update_clicks' );
		add_action( 'wp_ajax_fast_affiliate_update_post_views', 'fast_affiliate_update_post_views' );
		add_action( 'wp_ajax_nopriv_fast_affiliate_post_views', 'fast_affiliate_update_post_views' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fast-affiliate-public.css', array(), $this->version, 'all' );


	}

	/**
	 * Register the JavaScript for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Plugin_Name_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Plugin_Name_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->plugin_name."-public", plugin_dir_url( __FILE__ ) . 'js/fast-affiliate-public.js', array( 'jquery' ), $this->version, true );
		wp_localize_script( $this->plugin_name."-public", 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );

	}

}
