<?php 
/**
 * @package   SubscriptionProduct
*/
namespace Inc\Base;

use Inc\Base\BaseController;

/**
* 
*/
class Template extends BaseController
{
    public static $show_product_page = array();
    // public $cart_page = array();
    // public $checkout_page = array();

    public static function template()
	{
        $show_product_page = array(
            'post_title'      => 'Show Products',
            'post_content'    =>  "[show_product_page]",
            'post_status'     =>  'publish',
            'post_type'       =>  'page',
            'post_name'       =>  'show_product_page'
        );
        $cart_page = array(
            'post_title'      => 'Cart',
            'post_content'    =>  "[cart_page]",
            'post_status'     =>  'publish',
            'post_type'       =>  'page',
            'post_name'       =>  'cart_page'
        );
        $checkout_page = array(
            'post_title'      => 'Checkout',
            'post_content'    =>  "[checkout_page]",
            'post_status'     =>  'publish',
            'post_type'       =>  'page',
            'post_name'       =>  'checkout_page'
        );
      if ( ! empty( $show_product_page ) ) {
        $show_product_id = wp_insert_post( $show_product_page);
        add_option("show_product_id", $show_product_id );
      }
      if ( ! empty( $cart_page ) ) {
        $cart_id = wp_insert_post( $cart_page);
        add_option("cart_id", $cart_id );
      }
      if ( ! empty( $checkout_page ) ) {
        $checkout_id = wp_insert_post( $checkout_page);
        add_option("checkout_id", $checkout_id );
      }
    }
}
	
