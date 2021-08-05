<?php
/**
 * @package  SubscriptionProduct
 */
/*
Plugin Name: Subscription-Product
Plugin URI: http://subscription-product.com/plugin
Description: Trial.
Version: 1.0.0
Author: urvi sharma
Author URI: http://subscription-product.com
License: GPLv2 or later
Text Domain: subscription-product
*/

// If this file is called firectly, abort!!!
defined( 'ABSPATH' ) or die( 'Cant Access' );

// Require once the Composer Autoload
if ( file_exists( dirname( __FILE__ ) . '/vendor/autoload.php' ) ) {
	require_once dirname( __FILE__ ) . '/vendor/autoload.php';
}

/**
 * The code that runs during plugin activation
 */
function activate_subscription_product() {
	Inc\Base\Activate::activate();
	Inc\Base\Template::template();
}
register_activation_hook( __FILE__, 'activate_subscription_product' );

/**
 * The code that runs during plugin deactivation
 */
function deactivate_subscription_product() {
	Inc\Base\Deactivate::deactivate();
}
register_deactivation_hook( __FILE__, 'deactivate_subscription_product' );

/**
 * Initialize all the core classes of the plugin
 */
if ( class_exists( 'Inc\\Init' ) ) {
	Inc\Init::register_services();
}