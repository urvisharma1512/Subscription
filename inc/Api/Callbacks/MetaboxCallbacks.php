<?php 
/**
 * @package  SubscriptionProduct
 */
namespace Inc\Api\Callbacks;

use Inc\Base\BaseController;

class MetaboxCallbacks extends BaseController
{
    public function metaBoxCallback( $post )
	{
		wp_nonce_field( 'metabox_key', 'metabox_key_nonce' );
		$data = get_post_meta( $post->ID, '_metabox_key', true );
		$price = isset($data['price']) ? $data['price'] : '';
        $sale_price = isset($data['sale_price']) ? $data['sale_price'] : '';
        $sku = isset($data['sku']) ? $data['sku'] : '';
        $stock_status = isset($data['stock_status']) ? $data['stock_status'] : '';
        $sub_per_interval = isset($data['sub_per_interval']) ? $data['sub_per_interval'] : '';
        $sub_expiry = isset($data['sub_expiry']) ? $data['sub_expiry'] : '';
        $sub_entry_fee = isset($data['sub_entry_fee']) ? $data['sub_entry_fee'] : '';
        $sub_free_trial = isset($data['sub_free_trial']) ? $data['sub_free_trial'] : '';
		return require_once( "$this->plugin_path/templates/metabox.php" );
	}
}