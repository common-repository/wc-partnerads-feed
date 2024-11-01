<?php
/**
 * Plugin Name: WC PartnerAds Feed
 * Plugin URI: http://dicm.dk/
 * Description: Creates a feed to integrate with your PartnerAds campaign at http://www.partner-ads.com/
 * Author: Kim Vinberg
 * Author URI: http://dicm.dk/
 * Version: 1.0.9
 * Text Domain: wcpaf
 * Domain Path: /languages/
 */

define( 'WOO_PAF_PATH', plugin_dir_path( __FILE__ ) );
define( 'WOO_PAF_URL', plugin_dir_url( __FILE__ ) );

/**
 * WooCommerce fallback notice.
 */
function wcpaf_woocommerce_fallback_notice() {
    echo '<div class="error"><p>' . sprintf( __( 'WooCommerce PartnerAds feed depends on the last version of %s to work!', 'wcpaf' ), '<a href="http://wordpress.org/extend/plugins/woocommerce/">' . __( 'WooCommerce', 'wcpaf' ) . '</a>' ) . '</p></div>';
}

/**
 * Load functions.
 */
function wcpaf_gateway_load() {

    /**
     * Load textdomain.
     */
    load_plugin_textdomain( 'wcpaf', false, dirname( plugin_basename( __FILE__ ) ) . '/languages/' );

    // Checks with WooCommerce is installed.
    if ( ! class_exists( 'WC_Integration' ) ) {
        add_action( 'admin_notices', 'wcpaf_woocommerce_fallback_notice' );

        return;
    }

    /**
     * Add a new integration to WooCommerce.
     *
     * @param  array $integrations WooCommerce integrations.
     *
     * @return array               Integrations with WooCommerce Partnerads Feed.
     */
    function wcpaf_add_integration( $integrations ) {
        $integrations[] = 'WC_partnerads_Feed';

        return $integrations;
    }

    add_filter( 'woocommerce_integrations', 'wcpaf_add_integration' );

    // Include integration class.
    require_once WOO_PAF_PATH . 'includes/class-wc-partnerads-feed.php';
}

add_action( 'plugins_loaded', 'wcpaf_gateway_load', 0 );


/**
 * Create feed page on plugin install.
 */
if(!function_exists("wcpaf_create_page")) {
    function wcpaf_create_page() {
    $slug = sanitize_title( _x( 'partnerads-feed', 'page slug', 'wcpaf' ) );

    if ( ! get_page_by_path( $slug ) ) {
        $page = array(
            'post_title'     => _x( 'Partnerads Feed', 'page name', 'wcpaf' ),
            'post_name'      => $slug,
            'post_status'    => 'publish',
            'post_type'      => 'page',
            'comment_status' => 'closed',
            'ping_status'    => 'closed',
            'post_content'   => '',
        );

        wp_insert_post( $page );
    }

    }
}

register_activation_hook( __FILE__, 'wcpaf_create_page' );
