<?php
require_once('fast-affiliate-general-config.php');
require_once('fast-affiliate-effiliation.php');
require_once('fast-affiliate-amazon.php');
require_once('fast-affiliate-ebay.php');
require_once('fast-affiliate-tradedoubler.php');
require_once('fast-affiliate-cj.php');
require_once('fast-affiliate-affilinet.php');
require_once('fast-affiliate-stock.php');
require_once('fast-affiliate-performance.php');
require_once('fast-affiliate-post-metabox.php');
require_once('fast-affiliate-active-programs.php');
require_once('fast-affiliate-api.php');
require_once('fast-affiliate-quick-link.php');
require_once(__DIR__.'/../includes/fast-affiliate-post.php');
require_once(__DIR__.'/../includes/fast-affiliate-widget.php');


/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    fast_affiliate
 * @subpackage fast_affiliate/admin
 * @author     G. Lebret <email@example.com>
 */
class fast_affiliate_Admin {

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
	 * @param      string    $plugin_name       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version = $version;
        add_action( 'admin_menu', 'fast_affiliate_menu', 10 );

        add_action( 'add_meta_boxes','fast_affiliate_init_metabox');
        
        add_action( 'wp_ajax_fast_affiliate_get_platforms', 'fast_affiliate_get_platforms' );
        add_action( 'wp_ajax_fast_affiliate_get_amazon_products', 'fast_affiliate_get_amazon_products' );
        add_action( 'wp_ajax_fast_affiliate_get_ebay_products', 'fast_affiliate_get_ebay_products' );
        add_action( 'wp_ajax_fast_affiliate_get_effiliation_products', 'fast_affiliate_get_effiliation_products' );
        add_action( 'wp_ajax_fast_affiliate_get_CJ_products', 'fast_affiliate_get_CJ_products' );
        add_action( 'wp_ajax_fast_affiliate_get_tradedoubler_products', 'fast_affiliate_get_tradedoubler_products' );
        add_action( 'wp_ajax_fast_affiliate_get_affilinet_products', 'fast_affiliate_get_affilinet_products' );

        add_action( 'wp_ajax_fast_affiliate_add_products', 'fast_affiliate_add_products' );
        add_action( 'wp_ajax_fast_affiliate_update_selected', 'fast_affiliate_update_selected' );
        add_action( 'wp_ajax_fast_affiliate_add_quick_link', 'fast_affiliate_add_quick_link' );

        // EFFILIATION
        add_action( 'wp_ajax_fast_affiliate_update_effiliation_config', 'fast_affiliate_update_effiliation_config');
        // AMAZON
        add_action( 'wp_ajax_fast_affiliate_update_amazon_config', 'fast_affiliate_update_amazon_config');
        // eBay
        add_action( 'wp_ajax_fast_affiliate_update_ebay_config', 'fast_affiliate_update_ebay_config');
        // TRADEDOUBLER
        add_action( 'wp_ajax_fast_affiliate_update_tradedoubler_config', 'fast_affiliate_update_tradedoubler_config');
        // AFFILINET
        add_action( 'wp_ajax_fast_affiliate_update_affilinet_config', 'fast_affiliate_update_affilinet_config');
        // CJ
        add_action( 'wp_ajax_fast_affiliate_update_cj_config', 'fast_affiliate_update_cj_config');

        add_action( 'widgets_init', 'fast_affiliate_register_widget' );

        add_action('fast_affiliate_daily_hook','fast_affiliate_send_platforms_programs');
        //add_action('fast_affiliate_daily_hook','fast_affiliate_construct_f_a_programs');

        add_filter( 'the_content','fast_affiliate_after');
        
        add_action( 'before_delete_post', 'fast_affiliate_delete_post');

        add_action( 'wp_ajax_fast_affiliate_update_general_config', 'fast_affiliate_update_general_config');
        
        add_shortcode('fa_announce','fast_affiliate_shortcode');


	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/fast-affiliate-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
		wp_enqueue_script($this->plugin_name."-admin", plugin_dir_url( __FILE__ ) . 'js/fast-affiliate-admin.js', array( 'jquery' ), $this->version, false );
		wp_localize_script($this->plugin_name."-admin", 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
        wp_enqueue_script($this->plugin_name."-tablesorter", plugin_dir_url( __FILE__ ) . 'js/jquery.tablesorter.min.js', array( 'jquery' ), $this->version, false );
        wp_localize_script($this->plugin_name."-tablesorter", 'ajax_object', array( 'ajax_url' => admin_url( 'admin-ajax.php' )) );
	}
}
/**
 * Register the top level menu in the Wordpress Admin.
 *
 * @since    1.0.0
 */
function fast_affiliate_menu(){
    add_menu_page( 'Fast Affiliate', 'Fast Affiliate', 'administrator', 'fast_affiliate_admin');
    add_submenu_page('fast_affiliate_admin', __('Configuration', 'fast-affiliate'), __('Configuration', 'fast-affiliate'), 'administrator', 'fast_affiliate_admin', 'fast_affiliate_render_admin');
    add_submenu_page('fast_affiliate_admin', __('Stock', 'fast-affiliate'), __('Stock', 'fast-affiliate'), 'administrator', 'fast_affiliate_stock', 'fast_affiliate_stock');
    add_submenu_page('fast_affiliate_admin', __('Performance', 'fast-affiliate'), __('Performance', 'fast-affiliate'), 'administrator', 'fast_affiliate_performance', 'fast_affiliate_performance');
}


/**
 * Render Admin Page.
 *
 * @since    1.0.0
 */
function fast_affiliate_render_admin()
{

    ?>
    <div class="wrap">
        <h2>Fast Affiliate - <?php _e("Configuration", "fast-affiliate")?></h2>
        <?php 
            $active_tab = isset( $_GET[ 'tab' ] ) ? $_GET[ 'tab' ] : 'general';
        ?>
        <h2 class="nav-tab-wrapper">
            <a href="admin.php?page=fast_affiliate_admin&tab=general" class="nav-tab <?php echo $active_tab == 'general' ? 'nav-tab-active' : ''; ?>"><?php _e("general","fast-affiliate")?></a>
            <a href="admin.php?page=fast_affiliate_admin&tab=effiliation" class="nav-tab <?php echo $active_tab == 'effiliation' ? 'nav-tab-active' : ''; ?>"><?php _e("effiliation","fast-affiliate")?></a>
            <a href="admin.php?page=fast_affiliate_admin&tab=amazon" class="nav-tab <?php echo $active_tab == 'amazon' ? 'nav-tab-active' : ''; ?>"><?php _e("amazon","fast-affiliate")?></a>
            <a href="admin.php?page=fast_affiliate_admin&tab=ebay" class="nav-tab <?php echo $active_tab == 'ebay' ? 'nav-tab-active' : ''; ?>"><?php _e("ebay","fast-affiliate")?></a>
            <a href="admin.php?page=fast_affiliate_admin&tab=tradedoubler" class="nav-tab <?php echo $active_tab == 'tradedoubler' ? 'nav-tab-active' : ''; ?>"><?php _e("tradedoubler","fast-affiliate")?></a>
            <a href="admin.php?page=fast_affiliate_admin&tab=affilinet" class="nav-tab <?php echo $active_tab == 'affilinet' ? 'nav-tab-active' : ''; ?>"><?php _e("affilinet","fast-affiliate")?></a>
            <a href="admin.php?page=fast_affiliate_admin&tab=cj" class="nav-tab <?php echo $active_tab == 'cj' ? 'nav-tab-active' : ''; ?>"><?php _e("cj","fast-affiliate")?></a>
        </h2>
        <br>
        
        <?php
            if  ($active_tab == 'general') {
                fast_affiliate_general_config();
            }
            elseif ($active_tab == 'effiliation') {
                fast_affiliate_effiliation();
            } elseif ($active_tab == 'amazon') {
                fast_affiliate_amazon();
            } elseif ($active_tab == 'ebay') {
                fast_affiliate_ebay();
            } elseif ($active_tab == 'tradedoubler') {
                fast_affiliate_tradedoubler();
            } elseif ($active_tab == 'affilinet') {
                fast_affiliate_affilinet();
            } elseif ($active_tab == 'cj') {
                fast_affiliate_cj();
            } 
        ?>

    </div>
    <?php
}