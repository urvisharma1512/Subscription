<?php
/**
 * @package   SubscriptionProduct
 */
namespace Inc\Base;

class Activate 
{
	public static function activate() {
		flush_rewrite_rules();

		$default = array();

		if ( ! get_option( 'subscription_product' ) ) {
			update_option( 'subscription_product', $default );
		}

		if ( ! get_option( 'subscription_product_cpt' ) ) {
			update_option( 'subscription_product_cpt', $default );
		}
	}
	
}