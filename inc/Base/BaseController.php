<?php 
/**
 * @package   SubscriptionProduct
 */
namespace Inc\Base;

class BaseController
{
	public $plugin_path;

	public $plugin_url;

	public $plugin;

	public $managers = array();

	public function __construct() {
		$this->plugin_path = plugin_dir_path( dirname( __FILE__, 2 ) );
		$this->plugin_url = plugin_dir_url( dirname( __FILE__, 2 ) );
		$this->plugin = plugin_basename( dirname( __FILE__, 3 ) ).'/subscription-product.php';
		$this->managers = array(
			'cpt_manager' => 'Activate CPT Manager',
			'templates_manager' => 'Activate Templates Manager',
			'login_manager' => 'Activate Ajax Login/Signup',
		);
	}

	public function activated( string $key )
	{
		$option = get_option( 'subscription_product' );

		return isset( $option[ $key ] ) ? $option[ $key ] : false;
	}
}