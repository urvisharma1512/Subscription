<?php
/**
 * @package   SubscriptionProduct
 */
namespace Inc\Base;

class Deactivate
{
	public static function deactivate() {
		flush_rewrite_rules();
		
		if(!empty(get_option("show_product_id"))){
			$product_id = get_option("show_product_id");
			wp_delete_post($product_id,true); //wp_posts
			delete_option("show_product_id");//wp_options
		  }
		  if(!empty(get_option("cart_id"))){
			$cart_id = get_option("cart_id");
			wp_delete_post($cart_id,true); //wp_posts
			delete_option("cart_id");//wp_options
		  }
		  if(!empty(get_option("checkout_id"))){
			$checkout_id = get_option("checkout_id");
			wp_delete_post($checkout_id,true); //wp_posts
			delete_option("checkout_id");//wp_options
		  }
	}
}